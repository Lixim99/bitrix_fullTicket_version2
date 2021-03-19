<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader,
    Bitrix\Iblock;

if(!$productIBlockID = (int) $arParams['PRODUCTS_IBLOCK_ID']) return false;
if(!$servisesIBlockID = (int) $arParams['CLASSIFIED_IBLOCK_ID']) return false;
if(!$productCode = trim($arParams['CLASSIFIED_CODE'])) return false;

if($this->StartResultCache()){
    
    $arClassifiedSections = array();
    $arFilter = Array('IBLOCK_ID'=>$servisesIBlockID);
    $db_list = CIBlockSection::GetList(Array($by=>$order), $arFilter, false, array('ID', 'NAME'));
    while($ar_result = $db_list->Fetch())
    {
       $arClassifiedSections[$ar_result['ID']] = array(
            'NAME'=>$ar_result['NAME'],
            'PRODUCT_ID'=>array(),
       );
    }
    
    $arProducts = array();
    $arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM", 'PROPERTY_' . $productCode, 'PROPERTY_ARTNUMBER', 'PROPERTY_MATERIAL', 'PROPERTY_PRICE');
    $arFilter = Array("IBLOCK_ID"=>$productIBlockID, "ACTIVE"=>"Y", 'PROPERTY_' . $productCode=>array_keys($arClassifiedSections));
    $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
    while($ob = $res->GetNext())
    {
      
        if(!isset($arProducts[$ob['ID']])){
            $arProducts[$ob['ID']] = array(
                'NAME' =>  $ob['NAME'],
                'MATERIAL' =>  $ob['PROPERTY_MATERIAL_VALUE'],
                'PRICE' =>  $ob['PROPERTY_PRICE_VALUE'],
                'ARTNUMBER' =>  $ob['PROPERTY_ARTNUMBER_VALUE'],
            );
        }
        $arClassifiedSections[$ob['PROPERTY_'. $productCode .'_VALUE']]['PRODUCT_ID'][] = $ob['ID'];
    }
      
    $arResult['SECTIONS'] = $arClassifiedSections;
    $arResult['PRODUCTS'] = $arProducts;
    $arResult['COUNT_PRODUCTS'] = count($arProducts);
    
    $this->SetResultCacheKeys(array("COUNT_PRODUCTS"));
    
    $this->IncludeComponentTemplate();
}


$APPLICATION->SetPageProperty('title', 'Элементов - ' . $arResult['COUNT_PRODUCTS']);
$APPLICATION->SetPageProperty('h1', 'Элементов - ' . $arResult['COUNT_PRODUCTS']);
?>