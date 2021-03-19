<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentParameters = array(
	"PARAMETERS" => array(
		"PRODUCTS_IBLOCK_ID" => array(
			"NAME" => GetMessage("PRODUCTS_IBLOCK_ID_MESS"),
			"TYPE" => "STRING",
            ),
        "CLASSIFIED_IBLOCK_ID" => array(
			"NAME" => GetMessage("CLASSIFIED_IBLOCK_ID_MESS"),
			"TYPE" => "STRING",
            ),
        "CLASSIFIED_CODE" => array(
			"NAME" => GetMessage("CLASSIFIED_CODE_MESS"),
			"TYPE" => "STRING",
            ),
        "CACHE_TIME"  =>  array("DEFAULT"=>36000000),
        ),
    );
?>