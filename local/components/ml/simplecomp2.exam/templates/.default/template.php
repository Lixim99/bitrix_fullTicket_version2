<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?= time()?>
<ul><b>Избранные элементы</b>
    <?foreach($arResult['CUR_USER_PRODUCTS'] as $curUserProd):?>
        <li><?=$curUserProd['NAME'] . ' - ' . $curUserProd['PRICE'] . ' - ' . $curUserProd['MATERIAL'] . ' - ' . $curUserProd['ARTNUMBER']?></li>
    <?endforeach;?>
</ul>

<ul><b>Вам также понравиться:</b>
    <?foreach($arResult['OTHER_USERS_PRODUCTS'] as $otherUserProd):
        $userStr = '';
        foreach($otherUserProd['LOGIN'] as $userLogin){
            $userStr .= ' ' .  $userLogin;
        }
    ?>
        <li>
        <?=$otherUserProd['NAME'] . ' - ' . $otherUserProd['PRICE'] . ' - ' . $otherUserProd['MATERIAL'] . ' - ' . $otherUserProd['ARTNUMBER']
        . '</br>В избранном у пользователей :'. $userStr;?>
        </li>
    <?endforeach;?>
</ul>