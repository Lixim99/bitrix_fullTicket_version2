<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader,
    Bitrix\Iblock;

if(!$productIBlockID = (int) $arParams['PRODUCTS_IBLOCK_ID']) return false;
if(!$productCode = trim($arParams['PRODUCTS_CODE'])) return false;

GLOBAL $USER;
if(!$USER->GetID()){
    return false;
}
if($this->StartResultCache(false,$USER->GetID())){
    
    GLOBAL $CACHE_MANAGER;
    $CACHE_MANAGER->StartTagCache("");
    
    //CUR USER PRODUCTS
    $arCurUserProducts = array();
    $sameUsers = array();
    $arSelect = Array("ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM", 'PROPERTY_' . $productCode, 'PROPERTY_PRICE', 'PROPERTY_MATERIAL', 'PROPERTY_ARTNUMBER');
    $arFilter = Array("IBLOCK_ID"=>$productIBlockID, "ACTIVE"=>"Y", '!PROPERTY_' . $productCode => false);
    $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
    while($arProd = $res->GetNextElement())
    {
        $arProductFields = $arProd->GetFields();
        $arProductFields['PROPERTIES'] = $arProd->GetProperties();
        
        if(in_array($USER->GetID(),$arProductFields['PROPERTIES'][$productCode]['VALUE'])){
            $arCurUserProducts[$arProductFields['ID']] = array(
                'NAME' => $arProductFields['NAME'],
                'PRICE' => $arProductFields['PROPERTY_PRICE_VALUE'],
                'MATERIAL' => $arProductFields['PROPERTY_MATERIAL_VALUE'],
                'ARTNUMBER' => $arProductFields['PROPERTY_ARTNUMBER_VALUE'],
            );
            
            foreach($arProductFields['PROPERTIES'][$productCode]['VALUE'] as $userID){
                if($USER->GetID() != $userID){
                   $sameUsers[] = $userID;
                }
            }
        }
    }
    $sameUsers = array_unique($sameUsers);
    
    //USERS LOGIN
    $arUsersLogin = array();
    $filter = array("ID" => $sameUsers);
    $rsUsers = CUser::GetList(($by="personal_country"), ($order="desc"), $filter, array('FIELDS' => array('ID', 'LOGIN')));
    while($arUser = $rsUsers->Fetch()){
        
        $arUsersLogin[$arUser['ID']] = array(
            'LOGIN' => $arUser['LOGIN'],
        );
    }
    
    
    //OTHER PRODUCTS
    $arOtherUserProducts = array();
    $arSelect = Array("ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM", 'PROPERTY_' . $productCode, 'PROPERTY_PRICE', 'PROPERTY_MATERIAL', 'PROPERTY_ARTNUMBER');
    $arFilter = Array("IBLOCK_ID"=>$productIBlockID, "ACTIVE"=>"Y",'!ID' => array_keys($arCurUserProducts), 'PROPERTY_' . $productCode => $sameUsers );
    $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
    while($arProdUnd = $res->GetNext())
    {
        
       if(!isset($arOtherUserProducts[$arProdUnd['ID']])){
            $arOtherUserProducts[$arProdUnd['ID']] = array(
                'NAME' => $arProdUnd['NAME'],
                'LOGIN' => array($arUsersLogin[$arProdUnd['PROPERTY_' . $productCode . '_VALUE']]['LOGIN']),
                'PRICE' => $arProdUnd['PROPERTY_PRICE_VALUE'],
                'MATERIAL' => $arProdUnd['PROPERTY_MATERIAL_VALUE'],
                'ARTNUMBER' => $arProdUnd['PROPERTY_ARTNUMBER_VALUE'],
            );
       }else{
            $arOtherUserProducts[$arProdUnd['ID']]['LOGIN'][] = $arUsersLogin[$arProdUnd['PROPERTY_' . $productCode . '_VALUE']]['LOGIN'];
       }
       
    }
    
    $arResult['CUR_USER_PRODUCTS'] = $arCurUserProducts;
    $arResult['OTHER_USERS_PRODUCTS'] = $arOtherUserProducts;
    $arResult['CUR_USER_PRODUCTS_COUNT'] = count($arCurUserProducts);
    
    $this->SetResultCacheKeys(array(
        "CUR_USER_PRODUCTS_COUNT",
    ));
    
    $this->IncludeComponentTemplate();
    
    $CACHE_MANAGER->RegisterTag('own_tag');
    $CACHE_MANAGER->EndTagCache();
    
}

$APPLICATION->SetPageProperty('title','Избранных элементов - ' . $arResult['CUR_USER_PRODUCTS_COUNT']);
?>