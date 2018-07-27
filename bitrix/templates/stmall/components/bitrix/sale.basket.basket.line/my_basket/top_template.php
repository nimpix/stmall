<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/**
 * @global array $arParams
 * @global CUser $USER
 * @global CMain $APPLICATION
 * @global string $cartId
 */
$compositeStub = (isset($arResult['COMPOSITE_STUB']) && $arResult['COMPOSITE_STUB'] == 'Y');
?><div class="bx-hdr-profile">
<?if (!$compositeStub && $arParams['SHOW_AUTHOR'] == 'Y'):?>
	<div class="bx-basket-block">
		<i class="fa fa-user"></i>
		<?if ($USER->IsAuthorized()):
			$name = trim($USER->GetFullName());
			if (! $name)
				$name = trim($USER->GetLogin());
			if (strlen($name) > 15)
				$name = substr($name, 0, 12).'...';
			?>
			<a href="<?=$arParams['PATH_TO_PROFILE']?>"><?=htmlspecialcharsbx($name)?></a>
			&nbsp;
			<a href="?logout=yes"><?=GetMessage('TSB1_LOGOUT')?></a>
		<?else:
			$arParamsToDelete = array(
				"login",
				"login_form",
				"logout",
				"register",
				"forgot_password",
				"change_password",
				"confirm_registration",
				"confirm_code",
				"confirm_user_id",
				"logout_butt",
				"auth_service_id",
				"clear_cache"
			);

			$currentUrl = urlencode($APPLICATION->GetCurPageParam("", $arParamsToDelete));
			if ($arParams['AJAX'] == 'N')
			{
				?><script type="text/javascript"><?=$cartId?>.currentUrl = '<?=$currentUrl?>';</script><?
			}
			else
			{
				$currentUrl = '#CURRENT_URL#';
			}
			?>
			<a href="<?=$arParams['PATH_TO_AUTHORIZE']?>?login=yes&backurl=<?=$currentUrl; ?>"><?=GetMessage('TSB1_LOGIN')?></a>
			&nbsp;
			<a href="<?=$arParams['PATH_TO_REGISTER']?>?register=yes&backurl=<?=$currentUrl; ?>"><?=GetMessage('TSB1_REGISTER')?></a>
		<?endif?>
	</div>
<?endif?>
<!--	<div class="bx-basket-block">--><?//
//		if (!$arResult["DISABLE_USE_BASKET"])
//		{
//			?>
<!--			--><?//
//		}
//		if (!$compositeStub)
//		{
//			if ($arParams['SHOW_NUM_PRODUCTS'] == 'Y' && ($arResult['NUM_PRODUCTS'] > 0 || $arParams['SHOW_EMPTY_VALUES'] == 'Y'))
//			{
//				echo $arResult['NUM_PRODUCTS'].' '.$arResult['PRODUCT(S)'];
//			}
//			if ($arParams['SHOW_TOTAL_PRICE'] == 'Y'):?>
<!--			<br --><?// if ($arParams['POSITION_FIXED'] == 'Y'): ?><!--class="hidden-xs"--><?//endif ?><!--/>-->
<!--			<span>-->
<!--				--><?//= GetMessage('TSB1_TOTAL_PRICE') ?>
<!--				--><?// if ($arResult['NUM_PRODUCTS'] > 0 || $arParams['SHOW_EMPTY_VALUES'] == 'Y'):?>
<!--					<strong>--><?//= $arResult['TOTAL_PRICE'] ?><!--</strong>-->
<!--				--><?//endif ?>
<!--			</span>-->
<!--			--><?//endif;?>
<!--			--><?//
//		}
//		if ($arParams['SHOW_PERSONAL_LINK'] == 'Y'):?>
<!--			<div style="padding-top: 4px;">-->
<!--			<span class="icon_info"></span>-->
<!--			<a href="--><?//=$arParams['PATH_TO_PERSONAL']?><!--">--><?//=GetMessage('TSB1_PERSONAL')?><!--</a>-->
<!--			</div>-->
<!--		--><?//endif?>
<!--	</div>-->
</div>

<?// print "<pre>";?>
<?// print_r($arResult['NUM_PRODUCTS']);?>
<?// print "</pre>";?>
<div id="app">
<div class="cart-icons">
    <span></span>
    <span>
        <div class="cart-count">
            <?if ($arParams['SHOW_NUM_PRODUCTS'] == 'Y' && ($arResult['NUM_PRODUCTS'] > 0 || $arParams['SHOW_EMPTY_VALUES'] == 'Y'))
            {
                echo $arResult['NUM_PRODUCTS'];
            } ?>
        </div>
        <input id="cart-count" type="hidden" value=" <?if ($arParams['SHOW_NUM_PRODUCTS'] == 'Y' && ($arResult['NUM_PRODUCTS'] > 0 || $arParams['SHOW_EMPTY_VALUES'] == 'Y'))
        {
            echo $arResult['NUM_PRODUCTS'];
        } ?>">
    </span>
</div>
    <div class="cart-text">
        <div><span>Корзина</span><span class="cart-price"><? echo str_replace('руб.','р.',$arResult['TOTAL_PRICE']) ?></span></div>
        <input id="cart-price" type="hidden" value="<? echo str_replace('руб.','',$arResult['TOTAL_PRICE']) ?>">
    </div>
</div>