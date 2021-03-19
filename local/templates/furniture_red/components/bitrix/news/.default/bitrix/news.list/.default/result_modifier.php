<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if($arParams['SET_SPECIALDATE'] == 'Y'){
    $arResult['FIRST_NEWS_DATE'] = $arResult['ITEMS'][0]['DISPLAY_ACTIVE_FROM'];
    $this->getComponent()->SetResultCacheKeys(array('FIRST_NEWS_DATE'));
}
?>