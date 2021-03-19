<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
    $APPLICATION->SetPageProperty('specialdate', $arResult['FIRST_NEWS_DATE']);
    
    define('NEWS_IBLOCK_ID', 1);
    
    if(!empty($_REQUEST['news_id'])){
        $arSelect = Array("ID", "NAME", "TIMESTAMP_X");
        $arFilter = Array("IBLOCK_ID"=>NEWS_IBLOCK_ID, 'ID' => $_REQUEST['news_id']);
        $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
        $ob = $res->Fetch();
        if($_REQUEST['ajax'] =='Y'):
            $APPLICATION->RestartBuffer();
            echo json_encode($ob['TIMESTAMP_X']);
            exit;
        else:
?>
<script>
    $('#hidden_answ').html('Дата последнего изменения в новости :<?=$ob['TIMESTAMP_X']?>').show();
</script>
<?endif;}?>