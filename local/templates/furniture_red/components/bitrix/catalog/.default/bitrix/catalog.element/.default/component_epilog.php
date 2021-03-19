<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
var_dump($arResult['DETAIL_PICTURE_PATH']);
    $APPLICATION->SetPageProperty('head_style',"background-image: url('" . $arResult['DETAIL_PICTURE_PATH'] . "'); background-size:contain;");
    $APPLICATION->SetPageProperty('slogan_head', $arResult['PREVIEW_TEXT_FOR_HEAD']);
?>