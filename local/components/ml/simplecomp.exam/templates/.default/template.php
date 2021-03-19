<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

?>
<ul>
    <?foreach($arResult['SECTIONS'] as $newSect):?>
    <li><?=$newSect['NAME'] ?>
        <ul>
        <?foreach($newSect['PRODUCT_ID'] as $productID):?>
            <li>
                <?=
                $arResult['PRODUCTS'][$productID]['NAME'] . ' - ' . $arResult['PRODUCTS'][$productID]['PRICE'] . ' - ' .
                $arResult['PRODUCTS'][$productID]['MATERIAL'] . ' - ' . $arResult['PRODUCTS'][$productID]['ARTNUMBER']
                ?>
            </li>
        <?endforeach;?>
        </ul>
    </li>
    <?endforeach;?>
</ul>