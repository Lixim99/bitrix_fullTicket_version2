<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentParameters = array(
	"PARAMETERS" => array(
		"PRODUCTS_IBLOCK_ID" => array(
			"NAME" => GetMessage("PRODUCTS_IBLOCK_ID_MESS"),
			"TYPE" => "STRING",
            ),
        "PRODUCTS_CODE" => array(
			"NAME" => GetMessage("PRODUCTS_CODE_MESS"),
			"TYPE" => "STRING",
            ),
        "CACHE_TIME"  =>  array("DEFAULT"=>36000000),
        ),
    );
?>