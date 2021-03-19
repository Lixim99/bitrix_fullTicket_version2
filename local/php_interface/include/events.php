<?
AddEventHandler("iblock", "OnBeforeIBlockElementAdd", Array("NewClass", "OnBeforeIBlockElementAddHandler"));

class NewClass
{
    // создаем обработчик события "OnBeforeIBlockElementAdd"
    function OnBeforeIBlockElementAddHandler(&$arFields)
    {
		if($arFields['IBLOCK_ID'] == 1){
			if(stripos($arFields['PREVIEW_TEXT'], 'калейдоскоп') !==false){
				global $APPLICATION;
				$APPLICATION->throwException("Мы не используем слово калейдоскоп в аносах");
				return false;
			}
		}
	}
}

AddEventHandler("main", "OnEpilog", "addEventError404");
function addEventError404(){
	if(ERROR_404 == 'Y'){
		GLOBAL $APPLICATION;
		
		CEventLog::Add(array(
         "SEVERITY" => "INFO",
         "AUDIT_TYPE_ID" => "ERROR_404",
         "MODULE_ID" => "main",
         "DESCRIPTION" => $APPLICATION->GetCurDir(),
      ));
	}
}

AddEventHandler("main", "OnBeforeUserUpdate", Array("SomeClass", "OnBeforeUserUpdateHandler"));

class SomeClass
{
    function OnBeforeUserUpdateHandler(&$arFields)
    {
        //if(is_object($GLOBALS['CACHE_MANAGER'])){
            $GLOBALS['CACHE_MANAGER']->ClearByTag('own_tag');
        //}
    }
}
?>