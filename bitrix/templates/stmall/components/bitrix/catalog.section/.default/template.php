<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 */

$this->setFrameMode(true);



$this->addExternalCss('/bitrix/css/main/bootstrap.css');



if (!empty($arResult['NAV_RESULT']))
{
	$navParams =  array(
		'NavPageCount' => $arResult['NAV_RESULT']->NavPageCount,
		'NavPageNomer' => $arResult['NAV_RESULT']->NavPageNomer,
		'NavNum' => $arResult['NAV_RESULT']->NavNum
	);
}
else
{
	$navParams = array(
		'NavPageCount' => 1,
		'NavPageNomer' => 1,
		'NavNum' => $this->randString()
	);
}

$showTopPager = false;
$showBottomPager = false;
$showLazyLoad = false;

?>


<?

if ($arParams['PAGE_ELEMENT_COUNT'] > 0 && $navParams['NavPageCount'] > 1)
{
	$showTopPager = $arParams['DISPLAY_TOP_PAGER'];
	$showBottomPager = $arParams['DISPLAY_BOTTOM_PAGER'];
	$showLazyLoad = $arParams['LAZY_LOAD'] === 'Y' && $navParams['NavPageNomer'] != $navParams['NavPageCount'];
}

$templateLibrary = array('popup', 'ajax', 'fx');
$currencyList = '';

if (!empty($arResult['CURRENCIES']))
{
	$templateLibrary[] = 'currency';
	$currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}

$templateData = array(
	'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
	'TEMPLATE_LIBRARY' => $templateLibrary,
	'CURRENCIES' => $currencyList
);
unset($currencyList, $templateLibrary);

$elementEdit = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT');
$elementDelete = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE');
$elementDeleteParams = array('CONFIRM' => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM'));

$positionClassMap = array(
	'left' => 'product-item-label-left',
	'center' => 'product-item-label-center',
	'right' => 'product-item-label-right',
	'bottom' => 'product-item-label-bottom',
	'middle' => 'product-item-label-middle',
	'top' => 'product-item-label-top'
);

$discountPositionClass = '';
if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && !empty($arParams['DISCOUNT_PERCENT_POSITION']))
{
	foreach (explode('-', $arParams['DISCOUNT_PERCENT_POSITION']) as $pos)
	{
		$discountPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}

$labelPositionClass = '';
if (!empty($arParams['LABEL_PROP_POSITION']))
{
	foreach (explode('-', $arParams['LABEL_PROP_POSITION']) as $pos)
	{
		$labelPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}

$arParams['~MESS_BTN_BUY'] = $arParams['~MESS_BTN_BUY'] ?: Loc::getMessage('CT_BCS_TPL_MESS_BTN_BUY');
$arParams['~MESS_BTN_DETAIL'] = $arParams['~MESS_BTN_DETAIL'] ?: Loc::getMessage('CT_BCS_TPL_MESS_BTN_DETAIL');
$arParams['~MESS_BTN_COMPARE'] = $arParams['~MESS_BTN_COMPARE'] ?: Loc::getMessage('CT_BCS_TPL_MESS_BTN_COMPARE');
$arParams['~MESS_BTN_SUBSCRIBE'] = $arParams['~MESS_BTN_SUBSCRIBE'] ?: Loc::getMessage('CT_BCS_TPL_MESS_BTN_SUBSCRIBE');
$arParams['~MESS_BTN_ADD_TO_BASKET'] = $arParams['~MESS_BTN_ADD_TO_BASKET'] ?: Loc::getMessage('CT_BCS_TPL_MESS_BTN_ADD_TO_BASKET');
$arParams['~MESS_NOT_AVAILABLE'] = $arParams['~MESS_NOT_AVAILABLE'] ?: Loc::getMessage('CT_BCS_TPL_MESS_PRODUCT_NOT_AVAILABLE');
$arParams['~MESS_SHOW_MAX_QUANTITY'] = $arParams['~MESS_SHOW_MAX_QUANTITY'] ?: Loc::getMessage('CT_BCS_CATALOG_SHOW_MAX_QUANTITY');
$arParams['~MESS_RELATIVE_QUANTITY_MANY'] = $arParams['~MESS_RELATIVE_QUANTITY_MANY'] ?: Loc::getMessage('CT_BCS_CATALOG_RELATIVE_QUANTITY_MANY');
$arParams['~MESS_RELATIVE_QUANTITY_FEW'] = $arParams['~MESS_RELATIVE_QUANTITY_FEW'] ?: Loc::getMessage('CT_BCS_CATALOG_RELATIVE_QUANTITY_FEW');

$generalParams = array(
	'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
	'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
	'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
	'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
	'MESS_SHOW_MAX_QUANTITY' => $arParams['~MESS_SHOW_MAX_QUANTITY'],
	'MESS_RELATIVE_QUANTITY_MANY' => $arParams['~MESS_RELATIVE_QUANTITY_MANY'],
	'MESS_RELATIVE_QUANTITY_FEW' => $arParams['~MESS_RELATIVE_QUANTITY_FEW'],
	'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
	'USE_PRODUCT_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
	'PRODUCT_QUANTITY_VARIABLE' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
	'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
	'ADD_PROPERTIES_TO_BASKET' => $arParams['ADD_PROPERTIES_TO_BASKET'],
	'PRODUCT_PROPS_VARIABLE' => $arParams['PRODUCT_PROPS_VARIABLE'],
	'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'],
	'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
	'COMPARE_PATH' => $arParams['COMPARE_PATH'],
	'COMPARE_NAME' => $arParams['COMPARE_NAME'],
	'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
	'PRODUCT_BLOCKS_ORDER' => $arParams['PRODUCT_BLOCKS_ORDER'],
	'LABEL_POSITION_CLASS' => $labelPositionClass,
	'DISCOUNT_POSITION_CLASS' => $discountPositionClass,
	'SLIDER_INTERVAL' => $arParams['SLIDER_INTERVAL'],
	'SLIDER_PROGRESS' => $arParams['SLIDER_PROGRESS'],
	'~BASKET_URL' => $arParams['~BASKET_URL'],
	'~ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
	'~BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE'],
	'~COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
	'~COMPARE_DELETE_URL_TEMPLATE' => $arResult['~COMPARE_DELETE_URL_TEMPLATE'],
	'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
	'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
	'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
	'BRAND_PROPERTY' => $arParams['BRAND_PROPERTY'],
	'MESS_BTN_BUY' => $arParams['~MESS_BTN_BUY'],
	'MESS_BTN_DETAIL' => $arParams['~MESS_BTN_DETAIL'],
	'MESS_BTN_COMPARE' => $arParams['~MESS_BTN_COMPARE'],
	'MESS_BTN_SUBSCRIBE' => $arParams['~MESS_BTN_SUBSCRIBE'],
	'MESS_BTN_ADD_TO_BASKET' => $arParams['~MESS_BTN_ADD_TO_BASKET'],
	'MESS_NOT_AVAILABLE' => $arParams['~MESS_NOT_AVAILABLE']
);

$obName = 'ob'.preg_replace('/[^a-zA-Z0-9_]/', 'x', $this->GetEditAreaId($navParams['NavNum']));
$containerName = 'container-'.$navParams['NavNum'];

	?>


<?
$_SESSION['arNav_RESULT'] = $arResult['NAV_RESULT'];
$_SESSION['arName'] =  $arResult['NAME'];
$_SESSION['DEPTH'] = $arResult['DEPTH_LEVEL'];
$_SESSION['SECTION_PAGE_TITLE'] = $arResult['IPROPERTY_VALUES']['SECTION_PAGE_TITLE'];
$_SESSION['SECTION_META_TITLE'] = $arResult['IPROPERTY_VALUES']['SECTION_META_TITLE'];
$_SESSION['ELEMENT_META_TITLE'] = $arResult['IPROPERTY_VALUES']['ELEMENT_META_TITLE'];
$_SESSION['PAGEN_1'] = $_GET['PAGEN_1'];
$_SESSION['catalog_url'] = $arResult['ORIGINAL_PARAMETERS']['CURRENT_BASE_PAGE'];

?>

<div class="catalog-section bx-<?=$arParams['TEMPLATE_THEME']?>" data-entity="<?=$containerName?>">
        <!-- <div class="sortirovka">
                <span>Выводить сначала:</span>
                <a <?//if (($_GET["sort"] == "price") && ($_GET["method"] == "asc") || (!isset($_GET["sort"]))):?> class="sorted" <?//endif;?> href="<?//=$arResult["SECTION_PAGE_URL"]?>?sort=price&method=asc">
                    самые дешевые
                </a>
                <a <?//if (($_GET["sort"] == "price") && ($_GET["method"] == "desc")):?> class="sorted" <?//endif;?> href="<?//=$arResult["SECTION_PAGE_URL"]?>?sort=price&method=desc">
                    самые дорогие
                </a>

		</div> -->
		
    <div data-pagination-num="<?=$navParams['NavNum']?>" class="top-pagination">
        <!-- pagination-container -->
        <?=$arResult['NAV_STRING']?>
        <!-- pagination-container -->
    </div>
<!--    <div class="tov-count">Товаров на странице:--><?// $obj = $arResult['NAV_RESULT']; print_r($obj->result->num_rows); ?><!--</div>-->
	<?
	if (!empty($arResult['ITEMS']) && !empty($arResult['ITEM_ROWS']))
	{
		$areaIds = array();

		foreach ($arResult['ITEMS'] as $item)
		{
			$uniqueId = $item['ID'].'_'.md5($this->randString().$component->getAction());
			$areaIds[$item['ID']] = $this->GetEditAreaId($uniqueId);
			$this->AddEditAction($uniqueId, $item['EDIT_LINK'], $elementEdit);
			$this->AddDeleteAction($uniqueId, $item['DELETE_LINK'], $elementDelete, $elementDeleteParams);
		}
		?>
		<!-- items-container -->
		<?
		foreach ($arResult['ITEM_ROWS'] as $rowData)
		{
			$rowItems = array_splice($arResult['ITEMS'], 0, $rowData['COUNT']);
			?>
			<div class="row no-gutters <?=$rowData['CLASS']?>" data-entity="items-row">

						<div class="col-xs-12 product-item-small-card">
							<div class="row justify-content-start">  <!--Выравнивание товаров-->
								<?
								foreach ($rowItems as $item)
								{
									?>
                                    <!-- Карточка продукта-->
									<div class="col-sm-4 product-item-big-card">
										<div class="row">
											<div class="col-md-12">

												<? /*
												$curPath = $item['DETAIL_PAGE_URL'];
												$res = CIBlockSection::GetByID($item['IBLOCK_SECTION_ID']);
												if($ar_res = $res->GetNext())
													$sect_code = $ar_res['CODE'];
		
												$tArr = explode('/', $curPath);
												$resPath = '/catalog/'.$sect_code.'/'.$tArr[count($tArr)-2].'/';
											
												$item['DETAIL_PAGE_URL'] = $resPath; */
												?>
											
												<?
												$APPLICATION->IncludeComponent(
													'bitrix:catalog.item',
													'',
													array(
														'RESULT' => array(
															'ITEM' => $item,
															'AREA_ID' => $areaIds[$item['ID']],
															'TYPE' => $rowData['TYPE'],
															'BIG_LABEL' => 'N',
															'BIG_DISCOUNT_PERCENT' => 'N',
															'BIG_BUTTONS' => 'Y',
															'SCALABLE' => 'N'
														),
														'PARAMS' => $generalParams
															+ array('SKU_PROPS' => $arResult['SKU_PROPS'][$item['IBLOCK_ID']])
													),
													$component,
													array('HIDE_ICONS' => 'Y')
												);
												?>
											</div>
										</div>
									</div>
									<?
								}
								?>
							</div>
						</div>
				
			</div>
			<?
		}
		unset($generalParams, $rowItems);
		?>
		<!-- items-container -->
		<?
	}
	else
	{
		// load css for bigData/deferred load
		$APPLICATION->IncludeComponent(
			'bitrix:catalog.item',
			'',
			array(),
			$component,
			array('HIDE_ICONS' => 'Y')
		);
	}
	?>

</div>
<?
if ($showLazyLoad)
{
	?>
	<div class="row bx-<?=$arParams['TEMPLATE_THEME']?>">
		<div class="btn btn-default btn-lg center-block" style="margin: 15px;"
			data-use="show-more-<?=$navParams['NavNum']?>">
			<?=$arParams['MESS_BTN_LAZY_LOAD']?>
		</div>
	</div>
	<?
}

if ($showBottomPager)
{
	?>
	<div data-pagination-num="<?=$navParams['NavNum']?>" class="pagination">
		<!-- pagination-container -->
		<?=$arResult['NAV_STRING']?>
		<!-- pagination-container -->
	</div>
	<?
}

?>




<? 
if($arResult['ORIGINAL_PARAMETERS']['CURRENT_BASE_PAGE'] != '/catalog/' && strpos($arResult['ORIGINAL_PARAMETERS']['CURRENT_BASE_PAGE'], '/catalog/?PAGEN_1') === false){

    if(!empty($_GET['PAGEN_1'])){
		if(empty($arResult['DESCRIPTION'])){
        ?>
        <div class="meta-text-cat">
            <p>Сложно выбрать <a class="bottom-text-meta-link" href="<?print "http://st-mall.ru".$arResult['SECTION_PAGE_URL'];?>"><span class="lowecase-title"></span></a> самостоятельно? Наш менеджер найдет оборудование за вас! Оставляйте заявку, и мы бесплатно отберем самые лучшие варианты!</p>
        </div>

	<? }else{
		?><div class="meta-text-cat"></div><?
	}
	}else{
		if(empty($arResult['DESCRIPTION'])){	
		?>

    <div class="meta-text-cat">
        <h2>Покупайте <span class="lowecase-title"></span> на 10% дешевле, чем в магазинах! </h2>

        <span>Это выгодно ➤</span>
        <p>Чтобы не завышать цены на <span class="lowecase-title"><?//$APPLICATION->ShowTitle(false);?></span>, мы не храним их на складе. Каждый товар изготавливают и отравляют в ваш город после поступления онлайн-заказа. Результат: за ту же стоимость вы покупаете оборудование, у которого лучше качество и функционал.</p>
        <span>Это удобно ➤</span>
        <p>На сайте st-mall.ru все <span class="lowecase-title"><?//$APPLICATION->ShowTitle(false);?></span> с фото, подробным описанием и характеристиками. Любые вопросы можно задать онлайн — специалист отвечает через 3 минуты. При этом оформление покупки у вас займет не больше 5 минут!<p>
    </div>
    <? }else{
		?><div class="meta-text-cat"><?=$arResult['DESCRIPTION']?></div><?
	}
}

}

$signer = new \Bitrix\Main\Security\Sign\Signer;
$signedTemplate = $signer->sign($templateName, 'catalog.section');
$signedParams = $signer->sign(base64_encode(serialize($arResult['ORIGINAL_PARAMETERS'])), 'catalog.section');


?>


<script>
	BX.message({
		BTN_MESSAGE_BASKET_REDIRECT: '<?=GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_BASKET_REDIRECT')?>',
		BASKET_URL: '<?=$arParams['BASKET_URL']?>',
		ADD_TO_BASKET_OK: '<?=GetMessageJS('ADD_TO_BASKET_OK')?>',
		TITLE_ERROR: '<?=GetMessageJS('CT_BCS_CATALOG_TITLE_ERROR')?>',
		TITLE_BASKET_PROPS: '<?=GetMessageJS('CT_BCS_CATALOG_TITLE_BASKET_PROPS')?>',
		TITLE_SUCCESSFUL: '<?=GetMessageJS('ADD_TO_BASKET_OK')?>',
		BASKET_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCS_CATALOG_BASKET_UNKNOWN_ERROR')?>',
		BTN_MESSAGE_SEND_PROPS: '<?=GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_SEND_PROPS')?>',
		BTN_MESSAGE_CLOSE: '<?=GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_CLOSE')?>',
		BTN_MESSAGE_CLOSE_POPUP: '<?=GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_CLOSE_POPUP')?>',
		COMPARE_MESSAGE_OK: '<?=GetMessageJS('CT_BCS_CATALOG_MESS_COMPARE_OK')?>',
		COMPARE_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCS_CATALOG_MESS_COMPARE_UNKNOWN_ERROR')?>',
		COMPARE_TITLE: '<?=GetMessageJS('CT_BCS_CATALOG_MESS_COMPARE_TITLE')?>',
		PRICE_TOTAL_PREFIX: '<?=GetMessageJS('CT_BCS_CATALOG_PRICE_TOTAL_PREFIX')?>',
		RELATIVE_QUANTITY_MANY: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_MANY'])?>',
		RELATIVE_QUANTITY_FEW: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_FEW'])?>',
		BTN_MESSAGE_COMPARE_REDIRECT: '<?=GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_COMPARE_REDIRECT')?>',
		BTN_MESSAGE_LAZY_LOAD: '<?=$arParams['MESS_BTN_LAZY_LOAD']?>',
		BTN_MESSAGE_LAZY_LOAD_WAITER: '<?=GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_LAZY_LOAD_WAITER')?>',
		SITE_ID: '<?=SITE_ID?>'
	});
	var <?=$obName?> = new JCCatalogSectionComponent({
		siteId: '<?=CUtil::JSEscape(SITE_ID)?>',
		componentPath: '<?=CUtil::JSEscape($componentPath)?>',
		navParams: <?=CUtil::PhpToJSObject($navParams)?>,
		deferredLoad: false, // enable it for deferred load
		initiallyShowHeader: '<?=!empty($arResult['ITEM_ROWS'])?>',
		bigData: <?=CUtil::PhpToJSObject($arResult['BIG_DATA'])?>,
		lazyLoad: !!'<?=$showLazyLoad?>',
		loadOnScroll: !!'<?=($arParams['LOAD_ON_SCROLL'] === 'Y')?>',
		template: '<?=CUtil::JSEscape($signedTemplate)?>',
		ajaxId: '<?=CUtil::JSEscape($arParams['AJAX_ID'])?>',
		parameters: '<?=CUtil::JSEscape($signedParams)?>',
		container: '<?=$containerName?>'
	});
</script>
