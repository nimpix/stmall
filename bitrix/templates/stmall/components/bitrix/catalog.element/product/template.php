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
 * @var string $templateFolder
 */

$this->setFrameMode(true);
$this->addExternalCss('/bitrix/css/main/bootstrap.css');

$templateLibrary = array('popup', 'fx');
$currencyList = '';



//get brend value and counter
$res = CIBlockElement::GetList(
    array(),
    array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "ID" => $arResult['ID'], "INCLUDE_SUBSECTIONS" => "Y"),
    false,
    false,
    array("ID", "IBLOCK_ID", "LANG_DIR", "DETAIL_PAGE_URL", "PROPERTY_BREND", "SHOW_COUNTER","PROPERTY_MY_COUNTER","PROPERTY_MOB_BANNER")
);


$tmps = array();
while($ob = $res->GetNext())
{
    $tmps["BREND_VAL"] = $ob["PROPERTY_BREND_VALUE"];
    $tmps["COUNTER"] = $ob["SHOW_COUNTER"];
    if(empty($ob["PROPERTY_MY_COUNTER_VALUE"])) $ob["PROPERTY_MY_COUNTER_VALUE"] = 0;
	$tmps["BUY_COUNTER"] = $ob["PROPERTY_MY_COUNTER_VALUE"];

	// Мобильный баннер
	$img_path = CFile::GetFileArray($ob["PROPERTY_MOB_BANNER_VALUE"]);
	$mobpath = $img_path["SRC"];
	//Мобильный баннер
}
//Sending data to init.php
$_SESSION['BUY_COUNTER'] = $tmps["BUY_COUNTER"];
$_SESSION['BUY_ID'] = $arResult['ID'];



$basePath = $arResult['SECTION']['LIST_PAGE_URL'];
$basePath = substr($basePath,0, strlen($basePath)-1);

$full_path = '';
$sec_title = '';

if (isset($arResult['SECTION']['PATH'][1])){
    $full_path = $arResult['SECTION']['PATH'][1]['SECTION_PAGE_URL'];
    $sec_title = $arResult['SECTION']['PATH'][1]['NAME'].' '.strtolower($arResult['SECTION']['PATH'][0]['NAME']);
}
else{
    $full_path = $arResult['SECTION']['PATH'][0]['SECTION_PAGE_URL'];
    $sec_title = $arResult['SECTION']['PATH'][0]['NAME'];
}


$brend_path = '';
$brend_name = '';

if (isset($arResult['DISPLAY_PROPERTIES']['brend']['VALUE'])){
    $brend_path = $arResult['DISPLAY_PROPERTIES']['brend']['VALUE'];
    $brend_name = $arResult['DISPLAY_PROPERTIES']['brend']['DISPLAY_VALUE'];
}


if (!empty($arResult['CURRENCIES']))
{
	$templateLibrary[] = 'currency';
	$currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}

$templateData = array(
	'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
	'TEMPLATE_LIBRARY' => $templateLibrary,
	'CURRENCIES' => $currencyList,
	'ITEM' => array(
		'ID' => $arResult['ID'],
		'IBLOCK_ID' => $arResult['IBLOCK_ID'],
		'OFFERS_SELECTED' => $arResult['OFFERS_SELECTED'],
		'JS_OFFERS' => $arResult['JS_OFFERS']
	)
);
unset($currencyList, $templateLibrary);

$mainId = $this->GetEditAreaId($arResult['ID']);
$itemIds = array(
	'ID' => $mainId,
	'DISCOUNT_PERCENT_ID' => $mainId.'_dsc_pict',
	'STICKER_ID' => $mainId.'_sticker',
	'BIG_SLIDER_ID' => $mainId.'_big_slider',
	'BIG_IMG_CONT_ID' => $mainId.'_bigimg_cont',
	'SLIDER_CONT_ID' => $mainId.'_slider_cont',
	'OLD_PRICE_ID' => $mainId.'_old_price',
	'PRICE_ID' => $mainId.'_price',
	'DISCOUNT_PRICE_ID' => $mainId.'_price_discount',
	'PRICE_TOTAL' => $mainId.'_price_total',
	'SLIDER_CONT_OF_ID' => $mainId.'_slider_cont_',
	'QUANTITY_ID' => $mainId.'_quantity',
	'QUANTITY_DOWN_ID' => $mainId.'_quant_down',
	'QUANTITY_UP_ID' => $mainId.'_quant_up',
	'QUANTITY_MEASURE' => $mainId.'_quant_measure',
	'QUANTITY_LIMIT' => $mainId.'_quant_limit',
	'BUY_LINK' => $mainId.'_buy_link',
	'ADD_BASKET_LINK' => $mainId.'_add_basket_link',
	'BASKET_ACTIONS_ID' => $mainId.'_basket_actions',
	'NOT_AVAILABLE_MESS' => $mainId.'_not_avail',
	'COMPARE_LINK' => $mainId.'_compare_link',
	'TREE_ID' => $mainId.'_skudiv',
	'DISPLAY_PROP_DIV' => $mainId.'_sku_prop',
	'DISPLAY_MAIN_PROP_DIV' => $mainId.'_main_sku_prop',
	'OFFER_GROUP' => $mainId.'_set_group_',
	'BASKET_PROP_DIV' => $mainId.'_basket_prop',
	'SUBSCRIBE_LINK' => $mainId.'_subscribe',
	'TABS_ID' => $mainId.'_tabs',
	'TAB_CONTAINERS_ID' => $mainId.'_tab_containers',
	'SMALL_CARD_PANEL_ID' => $mainId.'_small_card_panel',
	'TABS_PANEL_ID' => $mainId.'_tabs_panel'
);
$obName = $templateData['JS_OBJ'] = 'ob'.preg_replace('/[^a-zA-Z0-9_]/', 'x', $mainId);
$name = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
	: $arResult['NAME'];
$title = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE']
	: $arResult['NAME'];
$alt = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT']
	: $arResult['NAME'];

$haveOffers = !empty($arResult['OFFERS']);
if ($haveOffers)
{
	$actualItem = isset($arResult['OFFERS'][$arResult['OFFERS_SELECTED']])
		? $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]
		: reset($arResult['OFFERS']);
	$showSliderControls = false;

	foreach ($arResult['OFFERS'] as $offer)
	{
		if ($offer['MORE_PHOTO_COUNT'] > 1)
		{
			$showSliderControls = true;
			break;
		}
	}
}
else
{
	$actualItem = $arResult;
	$showSliderControls = $arResult['MORE_PHOTO_COUNT'] > 1;
}




$skuProps = array();
$price = $actualItem['ITEM_PRICES'][$actualItem['ITEM_PRICE_SELECTED']];
$measureRatio = $actualItem['ITEM_MEASURE_RATIOS'][$actualItem['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'];
$showDiscount = $price['PERCENT'] > 0;

$showDescription = !empty($arResult['PREVIEW_TEXT']) || !empty($arResult['DETAIL_TEXT']);
$showBuyBtn = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION']);
$buyButtonClassName = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-default' : 'btn-link';
$showAddBtn = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION']);
$showButtonClassName = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-default' : 'btn-link';
$showSubscribe = $arParams['PRODUCT_SUBSCRIPTION'] === 'Y' && ($arResult['CATALOG_SUBSCRIBE'] === 'Y' || $haveOffers);

$arParams['MESS_BTN_BUY'] = $arParams['MESS_BTN_BUY'] ?: Loc::getMessage('CT_BCE_CATALOG_BUY');
$arParams['MESS_BTN_ADD_TO_BASKET'] = $arParams['MESS_BTN_ADD_TO_BASKET'] ?: Loc::getMessage('CT_BCE_CATALOG_ADD');
$arParams['MESS_NOT_AVAILABLE'] = $arParams['MESS_NOT_AVAILABLE'] ?: Loc::getMessage('CT_BCE_CATALOG_NOT_AVAILABLE');
$arParams['MESS_BTN_COMPARE'] = $arParams['MESS_BTN_COMPARE'] ?: Loc::getMessage('CT_BCE_CATALOG_COMPARE');
$arParams['MESS_PRICE_RANGES_TITLE'] = $arParams['MESS_PRICE_RANGES_TITLE'] ?: Loc::getMessage('CT_BCE_CATALOG_PRICE_RANGES_TITLE');
$arParams['MESS_DESCRIPTION_TAB'] = $arParams['MESS_DESCRIPTION_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_DESCRIPTION_TAB');
$arParams['MESS_PROPERTIES_TAB'] = $arParams['MESS_PROPERTIES_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_PROPERTIES_TAB');
$arParams['MESS_COMMENTS_TAB'] = $arParams['MESS_COMMENTS_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_COMMENTS_TAB');
$arParams['MESS_SHOW_MAX_QUANTITY'] = $arParams['MESS_SHOW_MAX_QUANTITY'] ?: Loc::getMessage('CT_BCE_CATALOG_SHOW_MAX_QUANTITY');
$arParams['MESS_RELATIVE_QUANTITY_MANY'] = $arParams['MESS_RELATIVE_QUANTITY_MANY'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_MANY');
$arParams['MESS_RELATIVE_QUANTITY_FEW'] = $arParams['MESS_RELATIVE_QUANTITY_FEW'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_FEW');



$positionClassMap = array(
	'left' => 'product-item-label-left',
	'center' => 'product-item-label-center',
	'right' => 'product-item-label-right',
	'bottom' => 'product-item-label-bottom',
	'middle' => 'product-item-label-middle',
	'top' => 'product-item-label-top'
);

$discountPositionClass = 'product-item-label-big';
if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && !empty($arParams['DISCOUNT_PERCENT_POSITION']))
{
	foreach (explode('-', $arParams['DISCOUNT_PERCENT_POSITION']) as $pos)
	{
		$discountPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}

$labelPositionClass = 'product-item-label-big';
if (!empty($arParams['LABEL_PROP_POSITION']))
{
	foreach (explode('-', $arParams['LABEL_PROP_POSITION']) as $pos)
	{
		$labelPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}

?>

<?// print "<pre>";?>
<?// print($arResult['NAME']);?>
<?// print "</pre>";?>

<!--Устанавливаем мета-тэги-->
<?
$_SESSION['PROD_NAME'] = $arResult['NAME'];
$_SESSION['PROD_PRICE'] = $arResult['PRICES']['base_price']['PRINT_VALUE'];
?>

<?$this->SetViewTarget('border-top');?>
<div class="border-top"></div>
<?$this->EndViewTarget();?>
<div class="form-2">
    <div class="form-main">
        <?$APPLICATION->IncludeComponent(
            "bitrix:form",
            "my_product_form",
            Array(
                "AJAX_MODE" => "N",
                "AJAX_OPTION_ADDITIONAL" => "",
                "AJAX_OPTION_HISTORY" => "N",
                "AJAX_OPTION_JUMP" => "N",
                "AJAX_OPTION_STYLE" => "Y",
                "CACHE_TIME" => "3600",
                "CACHE_TYPE" => "A",
                "CHAIN_ITEM_LINK" => "",
                "CHAIN_ITEM_TEXT" => "",
                "EDIT_ADDITIONAL" => "N",
                "EDIT_STATUS" => "Y",
                "IGNORE_CUSTOM_TEMPLATE" => "Y",
                "NOT_SHOW_FILTER" => "",
                "NOT_SHOW_TABLE" => "",
                "RESULT_ID" => $_REQUEST[RESULT_ID],
                "SEF_FOLDER" => "",
                "SEF_MODE" => "Y",
                "SEF_URL_TEMPLATES" => Array("edit"=>"#WEB_FORM_ID#/edit/#RESULT_ID#/","list"=>"#WEB_FORM_ID#/list/","new"=>"#WEB_FORM_ID#/","view"=>"#WEB_FORM_ID#/view/#RESULT_ID#/"),
                "SHOW_ADDITIONAL" => "N",
                "SHOW_ANSWER_VALUE" => "N",
                "SHOW_EDIT_PAGE" => "N",
                "SHOW_LIST_PAGE" => "N",
                "SHOW_STATUS" => "Y",
                "SHOW_VIEW_PAGE" => "N",
                "START_PAGE" => "new",
                "SUCCESS_URL" => "",
                "USE_EXTENDED_ERRORS" => "N",
                "WEB_FORM_ID" => 2
            )
        );?>
    </div>
</div>
<div class="bx-catalog-element product container bx-<?=$arParams['TEMPLATE_THEME']?>" id="<?=$itemIds['ID']?>"
	itemscope itemtype="http://schema.org/Product">

		<div class="row no-gutters">
			<div class="col-lg-6 col-md-6 col-sm-12">
				<div class="product-item-detail-slider-container" id="<?=$itemIds['BIG_SLIDER_ID']?>">
					<span class="product-item-detail-slider-close" data-entity="close-popup"></span>
					<div class="product-item-detail-slider-block
						<?=($arParams['IMAGE_RESOLUTION'] === '1by1' ? 'product-item-detail-slider-block-square' : '')?>"
						data-entity="images-slider-block">
						<span class="product-item-detail-slider-left" data-entity="slider-control-left" style="display: none;"></span>
						<span class="product-item-detail-slider-right" data-entity="slider-control-right" style="display: none;"></span>
						<div class="product-item-label-text <?=$labelPositionClass?>" id="<?=$itemIds['STICKER_ID']?>"
							<?=(!$arResult['LABEL'] ? 'style="display: none;"' : '' )?>>
							<?
							if ($arResult['LABEL'] && !empty($arResult['LABEL_ARRAY_VALUE']))
							{
								foreach ($arResult['LABEL_ARRAY_VALUE'] as $code => $value)
								{
									?>
									<div<?=(!isset($arParams['LABEL_PROP_MOBILE'][$code]) ? ' class="hidden-xs"' : '')?>>
										<span title="<?=$value?>"><?=$value?></span>
									</div>
									<?
								}
							}
							?>
						</div>
						<?
						if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y')
						{
							if ($haveOffers)
							{
								?>
								<div class="product-item-label-ring <?=$discountPositionClass?>" id="<?=$itemIds['DISCOUNT_PERCENT_ID']?>"
									style="display: none;">
								</div>
								<?
							}
							else
							{
								if ($price['DISCOUNT'] > 0)
								{
									?>
									<div class="product-item-label-ring <?=$discountPositionClass?>" id="<?=$itemIds['DISCOUNT_PERCENT_ID']?>"
										title="<?=-$price['PERCENT']?>%">
										<span><?=-$price['PERCENT']?>%</span>
									</div>
									<?
								}
							}
						}
						?>
						<div class="product-item-detail-slider-images-container" data-entity="images-container">
							<?
							if (!empty($actualItem['MORE_PHOTO']))
							{
								foreach ($actualItem['MORE_PHOTO'] as $key => $photo)
								{
									?>

									<div class="product-image d-flex align-items-center justify-content-center">
										<img src="<?=$photo['SRC']?>" alt="<?=$alt?>" title="<?=$title?>"<?=($key == 0 ? ' itemprop="image"' : '')?>>
									</div>
									<?
								}
							}

							if ($arParams['SLIDER_PROGRESS'] === 'Y')
							{
								?>
								<div class="product-item-detail-slider-progress-bar" data-entity="slider-progress-bar" style="width: 0;"></div>
								<?
							}
							?>
						</div>
					</div>
					<?
					if ($showSliderControls)
					{
						if ($haveOffers)
						{
							foreach ($arResult['OFFERS'] as $keyOffer => $offer)
							{
								if (!isset($offer['MORE_PHOTO_COUNT']) || $offer['MORE_PHOTO_COUNT'] <= 0)
									continue;

								$strVisible = $arResult['OFFERS_SELECTED'] == $keyOffer ? '' : 'none';
								?>
								<div class="product-item-detail-slider-controls-block" id="<?=$itemIds['SLIDER_CONT_OF_ID'].$offer['ID']?>" style="display: <?=$strVisible?>;">
									<?
									foreach ($offer['MORE_PHOTO'] as $keyPhoto => $photo)
									{
										?>
										<div class="product-item-detail-slider-controls-image<?=($keyPhoto == 0 ? ' active' : '')?>"
											data-entity="slider-control" data-value="<?=$offer['ID'].'_'.$photo['ID']?>">
											<img src="<?=$photo['SRC']?>">
										</div>
										<?
									}
									?>
								</div>
								<?
							}
						}
						else
						{
							?>
							<div class="product-item-detail-slider-controls-block" id="<?=$itemIds['SLIDER_CONT_ID']?>">
								<?
								if (!empty($actualItem['MORE_PHOTO']))
								{
									foreach ($actualItem['MORE_PHOTO'] as $key => $photo)
									{
										?>
										<div class="product-item-detail-slider-controls-image<?=($key == 0 ? ' active' : '')?>"
											data-entity="slider-control" data-value="<?=$photo['ID']?>">
											<img src="<?=$photo['SRC']?>">
										</div>
										<?
									}
								}
								?>
							</div>
							<?
						}
					}
					?>
				</div>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-12">
				<div class="row no-gutters">
					
                        <?
                        if ($arParams['DISPLAY_NAME'] === 'Y')
                        {
                            ?>
                         
                                <div class="col-xs-12 col-xs-12 px-3 px-md-0">
                                    <h1 class="bx-title"><?=$name?></h1>
                                    <? $priced = '';?>
                                    <? if(!empty($arResult['PROPERTIES']['old_price']['VALUE'])){
                                        $priced = 'со скидкой';
                                        ?>
                                    <div class="old-price"><?echo round($arResult['PROPERTIES']['old_price']['VALUE']);?> р.</div>
                                    <?}?>
                                    <div class="product-item-detail-price-current" id="<?=$itemIds['PRICE_ID']?>"><span><span class='prc-text'>Цена</span> <?=$priced?></span>
                                        <?=str_replace('руб.','р.',$price['PRINT_RATIO_PRICE'])?>
									</div>
									  <!--  Счетчики -->
									<div class="view-panel schetchiki" style="display:none;">
                                        <div class="cnt"><span><?=$tmps["COUNTER"];?></span></div>
                                        <div class="buy_cnt"><span><?=$tmps['BUY_COUNTER'];?></span></div>
                                    </div>
                                </div>
                      
                            <?
                        }
                        ?>
                        <div class="col-xs-12">
                            <div class="row no-gutters product-buttons px-3 px-md-0">
                                <div class="favourite">

                                    <? if(\Bitrix\Main\Loader::includeModule("sale"))
                                    {  $isFav = false;
                                        $dbBasketItems = CSaleBasket::GetList(
                                            array(
                                                "NAME" => "ASC",
                                                "ID" => "ASC"
                                            ),
                                            array(
                                                "FUSER_ID" => CSaleBasket::GetBasketUserID(),
                                                "LID" => SITE_ID,
                                                "ORDER_ID" => "NULL",
                                                "DELAY" => "Y", //раcкоментировать, и только отложенные товары будут получены
                                            ),
                                            false,
                                            false,
                                            array("ID", "DELAY", "PRODUCT_ID", "DETAIL_PAGE_URL")
                                        );
                                        $my_arr = array();
                                        while ($arrItems = $dbBasketItems->Fetch())
                                        {
                                            $my_arr[] = $arrItems;
                                            if(($arrItems['DELAY'] == 'Y') && (strpos($arrItems['DETAIL_PAGE_URL'],$arResult['ORIGINAL_PARAMETERS']['ELEMENT_CODE']) !== false))
                                            {
                                                $isFav = true;
                                            }

                                        }
                                    } ?>

                                    <? if (!$isFav): ?>
                                        <?	if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']))
                                        { ?>
                                            <button class="add_to_fav"  onclick="to_delay('<?=$arResult['OFFERS'][$arResult['OFFERS_SELECTED']]["ID"]?>', '<?=$arResult['OFFERS'][$arResult['OFFERS_SELECTED']]["CATALOG_PRICE_ID_1"]?>',
                                                    '<?=$arResult['OFFERS'][$arResult['OFFERS_SELECTED']]["CATALOG_PRICE_1"]?>', '<?=$arResult['OFFERS'][$arResult['OFFERS_SELECTED']]["NAME"]?>', '<?=$arResult["DETAIL_PAGE_URL"]?>',
                                                    '<?=$arResult['OFFERS'][$arResult['OFFERS_SELECTED']]['PROPERTIES']['SIZES_SHOES']['VALUE']?>', '<?=$arResult['OFFERS'][$arResult['OFFERS_SELECTED']]['PROPERTIES']['COLOR_REF']['VALUE']?>')"><span class="icon-fav"></span>В избранное</button>
                                        <?   }
                                        else
                                        {
                                            ?>
                                            <button class="add_to_fav"  onclick="to_delay('<?=$arResult["ID"]?>', '<?=$arResult["CATALOG_PRICE_ID_1"]?>',
                                                    '<?=$arResult["CATALOG_PRICE_1"]?>', '<?=$arResult["NAME"]?>', '<?=$arResult["DETAIL_PAGE_URL"]?>')"><span class="icon-fav"></span>В избранное</button>
                                            <?
                                        }
                                        ?>
                                    <? else: ?>
                                        <button class="add_to_fav in_fav"><span class="icon-fav"></span>В избранном</button>
                                    <? endif; ?>


                             <? if ($arParams['DISPLAY_COMPARE'])
							{  
								?>
											<label class="compare-list" id="<?=$itemIds['COMPARE_LINK']?>">
                                                <button class="compare-btn" data-entity="compare-checkbox"><span data-entity="compare-title"><?=$arParams['MESS_BTN_COMPARE']?></span></button>
											</label>
								<?
							} ?>
                            </div>
                        </div>

                        <!--  Кнопки-->
                        <div class="row no-gutters px-3 px-md-0">
                           <div class="col-sm-12">
                                <?
                                foreach ($arParams['PRODUCT_PAY_BLOCK_ORDER'] as $blockName)
                                {
                                    switch ($blockName)
                                    {
                                        case 'rating':
                                            if ($arParams['USE_VOTE_RATING'] === 'Y')
                                            {
                                                ?>

                                                    <?
                                                    $APPLICATION->IncludeComponent(
                                                        'bitrix:iblock.vote',
                                                        'stars',
                                                        array(
                                                            'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
                                                            'IBLOCK_ID' => $arParams['IBLOCK_ID'],
                                                            'ELEMENT_ID' => $arResult['ID'],
                                                            'ELEMENT_CODE' => '',
                                                            'MAX_VOTE' => '5',
                                                            'VOTE_NAMES' => array('1', '2', '3', '4', '5'),
                                                            'SET_STATUS_404' => 'N',
                                                            'DISPLAY_AS_RATING' => $arParams['VOTE_DISPLAY_AS_RATING'],
                                                            'CACHE_TYPE' => $arParams['CACHE_TYPE'],
                                                            'CACHE_TIME' => $arParams['CACHE_TIME']
                                                        ),
                                                        $component,
                                                        array('HIDE_ICONS' => 'Y')
                                                    );
                                                    ?>

                                                <?
                                            }

                                            break;

                                        case 'price':
                                            ?>

                                                <?
                                                if ($arParams['SHOW_OLD_PRICE'] === 'Y')
                                                {
                                                    ?>
                                                    <div class="product-item-detail-price-old" id="<?=$itemIds['OLD_PRICE_ID']?>"
                                                         style="display: <?=($showDiscount ? '' : 'none')?>;">
                                                        <?=($showDiscount ? $price['PRINT_RATIO_BASE_PRICE'] : '')?>
                                                    </div>
                                                    <?
                                                }
                                                ?>
                                                <?
                                                if ($arParams['SHOW_OLD_PRICE'] === 'Y')
                                                {
                                                    ?>
                                                    <div class="item_economy_price" id="<?=$itemIds['DISCOUNT_PRICE_ID']?>"
                                                         style="display: <?=($showDiscount ? '' : 'none')?>;">
                                                        <?
                                                        if ($showDiscount)
                                                        {
                                                            echo Loc::getMessage('CT_BCE_CATALOG_ECONOMY_INFO2', array('#ECONOMY#' => $price['PRINT_RATIO_DISCOUNT']));
                                                        }
                                                        ?>
                                                    </div>
                                                    <?
                                                }
                                                ?>

                                            <?
                                            break;

                                        case 'priceRanges':
                                            if ($arParams['USE_PRICE_COUNT'])
                                            {
                                                $showRanges = !$haveOffers && count($actualItem['ITEM_QUANTITY_RANGES']) > 1;
                                                $useRatio = $arParams['USE_RATIO_IN_RANGES'] === 'Y';
                                                ?>
                                                <div class="product-item-detail-info-container"
                                                    <?=$showRanges ? '' : 'style="display: none;"'?>
                                                     data-entity="price-ranges-block">
                                                    <div class="product-item-detail-info-container-title">
                                                        <?=$arParams['MESS_PRICE_RANGES_TITLE']?>
                                                        <span data-entity="price-ranges-ratio-header">
														(<?=(Loc::getMessage(
                                                                'CT_BCE_CATALOG_RATIO_PRICE',
                                                                array('#RATIO#' => ($useRatio ? $measureRatio : '1').' '.$actualItem['ITEM_MEASURE']['TITLE'])
                                                            ))?>)
													</span>
                                                    </div>
                                                    <dl class="product-item-detail-properties" data-entity="price-ranges-body">
                                                        <?
                                                        if ($showRanges)
                                                        {
                                                            foreach ($actualItem['ITEM_QUANTITY_RANGES'] as $range)
                                                            {
                                                                if ($range['HASH'] !== 'ZERO-INF')
                                                                {
                                                                    $itemPrice = false;

                                                                    foreach ($arResult['ITEM_PRICES'] as $itemPrice)
                                                                    {
                                                                        if ($itemPrice['QUANTITY_HASH'] === $range['HASH'])
                                                                        {
                                                                            break;
                                                                        }
                                                                    }

                                                                    if ($itemPrice)
                                                                    {
                                                                        ?>
                                                                        <dt>
                                                                            <?
                                                                            echo Loc::getMessage(
                                                                                    'CT_BCE_CATALOG_RANGE_FROM',
                                                                                    array('#FROM#' => $range['SORT_FROM'].' '.$actualItem['ITEM_MEASURE']['TITLE'])
                                                                                ).' ';

                                                                            if (is_infinite($range['SORT_TO']))
                                                                            {
                                                                                echo Loc::getMessage('CT_BCE_CATALOG_RANGE_MORE');
                                                                            }
                                                                            else
                                                                            {
                                                                                echo Loc::getMessage(
                                                                                    'CT_BCE_CATALOG_RANGE_TO',
                                                                                    array('#TO#' => $range['SORT_TO'].' '.$actualItem['ITEM_MEASURE']['TITLE'])
                                                                                );
                                                                            }
                                                                            ?>
                                                                        </dt>
                                                                        <dd><?=($useRatio ? $itemPrice['PRINT_RATIO_PRICE'] : $itemPrice['PRINT_PRICE'])?></dd>
                                                                        <?
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </dl>
                                                </div>
                                                <?
                                                unset($showRanges, $useRatio, $itemPrice, $range);
                                            }

                                            break;

                                        case 'quantityLimit':
                                            if ($arParams['SHOW_MAX_QUANTITY'] !== 'N')
                                            {
                                                if ($haveOffers)
                                                {
                                                    ?>
                                                    <div class="product-item-detail-info-container" id="<?=$itemIds['QUANTITY_LIMIT']?>" style="display: none;">
                                                        <div class="product-item-detail-info-container-title">
                                                            <?=$arParams['MESS_SHOW_MAX_QUANTITY']?>:
                                                            <span class="product-item-quantity" data-entity="quantity-limit-value"></span>
                                                        </div>
                                                    </div>
                                                    <?
                                                }
                                                else
                                                {
                                                    if (
                                                        $measureRatio
                                                        && (float)$actualItem['CATALOG_QUANTITY'] > 0
                                                        && $actualItem['CATALOG_QUANTITY_TRACE'] === 'Y'
                                                        && $actualItem['CATALOG_CAN_BUY_ZERO'] === 'N'
                                                    )
                                                    {
                                                        ?>
                                                        <div class="product-item-detail-info-container" id="<?=$itemIds['QUANTITY_LIMIT']?>">
                                                            <div class="product-item-detail-info-container-title">
                                                                <?=$arParams['MESS_SHOW_MAX_QUANTITY']?>:
                                                                <span class="product-item-quantity" data-entity="quantity-limit-value">
																<?
                                                                if ($arParams['SHOW_MAX_QUANTITY'] === 'M')
                                                                {
                                                                    if ((float)$actualItem['CATALOG_QUANTITY'] / $measureRatio >= $arParams['RELATIVE_QUANTITY_FACTOR'])
                                                                    {
                                                                        echo $arParams['MESS_RELATIVE_QUANTITY_MANY'];
                                                                    }
                                                                    else
                                                                    {
                                                                        echo $arParams['MESS_RELATIVE_QUANTITY_FEW'];
                                                                    }
                                                                }
                                                                else
                                                                {
                                                                    echo $actualItem['CATALOG_QUANTITY'].' '.$actualItem['ITEM_MEASURE']['TITLE'];
                                                                }
                                                                ?>
															</span>
                                                            </div>
                                                        </div>
                                                        <?
                                                    }
                                                }
                                            }

                                            break;

                                        case 'quantity':
                                            if ($arParams['USE_PRODUCT_QUANTITY'])
                                            {
                                                ?>
                                                <div class="product-item-detail-info-container" style="<?=(!$actualItem['CAN_BUY'] ? 'display: none;' : '')?>"
                                                     data-entity="quantity-block">
                                                    <div class="product-item-detail-info-container-title"><?=Loc::getMessage('CATALOG_QUANTITY')?></div>
                                                    <div class="product-item-amount">
                                                        <div class="product-item-amount-field-container">
                                                            <a class="product-item-amount-field-btn-minus" id="<?=$itemIds['QUANTITY_DOWN_ID']?>"
                                                               href="javascript:void(0)" rel="nofollow">
                                                            </a>
                                                            <input class="product-item-amount-field" id="<?=$itemIds['QUANTITY_ID']?>" type="tel"
                                                                   value="<?=$price['MIN_QUANTITY']?>">
                                                            <a class="product-item-amount-field-btn-plus" id="<?=$itemIds['QUANTITY_UP_ID']?>"
                                                               href="javascript:void(0)" rel="nofollow">
                                                            </a>
                                                            <span class="product-item-amount-description-container">
															<span id="<?=$itemIds['QUANTITY_MEASURE']?>">
																<?=$actualItem['ITEM_MEASURE']['TITLE']?>
															</span>
															<span id="<?=$itemIds['PRICE_TOTAL']?>"></span>
														</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?
                                            }

                                            break;

                                        case 'buttons':
                                            ?>
                                            <div data-entity="main-button-container">
                                                <div id="<?=$itemIds['BASKET_ACTIONS_ID']?>" style="display: <?=($actualItem['CAN_BUY'] ? '' : 'none')?>;">
                                                    <?
                                                    if ($showAddBtn)
                                                    {
                                                        ?>
                                                        <div class="product-item-detail-info-container">
                                                            <a class="btn <?=$showButtonClassName?> product-item-detail-buy-button" id="<?=$itemIds['ADD_BASKET_LINK']?>"
                                                               href="javascript:void(0);">
                                                                <span><?=$arParams['MESS_BTN_ADD_TO_BASKET']?></span>
                                                            </a>
                                                        </div>
                                                        <?
                                                    }

                                                    if ($showBuyBtn)
                                                    {
                                                        ?>
                                                        <div class="product-item-detail-info-container">
                                                            <a class="btn <?=$buyButtonClassName?> product-item-detail-buy-button" id="<?=$itemIds['BUY_LINK']?>"
                                                               href="javascript:void(0);">
                                                                <span><?=$arParams['MESS_BTN_BUY']?></span>
                                                            </a>
                                                        </div>
                                                        <?
                                                    }
                                                    ?>
                                                </div>
                                                <?
                                                if ($showSubscribe)
                                                {
                                                    ?>
                                                    <div class="product-item-detail-info-container">
                                                        <?
                                                        $APPLICATION->IncludeComponent(
                                                            'bitrix:catalog.product.subscribe',
                                                            '',
                                                            array(
                                                                'PRODUCT_ID' => $arResult['ID'],
                                                                'BUTTON_ID' => $itemIds['SUBSCRIBE_LINK'],
                                                                'BUTTON_CLASS' => 'btn btn-default product-item-detail-buy-button',
                                                                'DEFAULT_DISPLAY' => !$actualItem['CAN_BUY'],
                                                                'MESS_BTN_SUBSCRIBE' => $arParams['~MESS_BTN_SUBSCRIBE'],
                                                            ),
                                                            $component,
                                                            array('HIDE_ICONS' => 'Y')
                                                        );
                                                        ?>
                                                    </div>
                                                    <?
                                                }
                                                ?>
                                                <div class="product-item-detail-info-container">
                                                    <a class="btn btn-link product-item-detail-buy-button" id="<?=$itemIds['NOT_AVAILABLE_MESS']?>"
                                                       href="javascript:void(0)"
                                                       rel="nofollow" style="display: <?=(!$actualItem['CAN_BUY'] ? '' : 'none')?>;">
                                                        <?=$arParams['MESS_NOT_AVAILABLE']?>
                                                    </a>
                                                </div>
                                            </div>
                                            <?
                                            break;
                                    }
                                }


                                ?>

                            </div>
                        </div>
                        <?
                        if (!empty($arResult['DISPLAY_PROPERTIES']) || $arResult['SHOW_OFFERS_PROPS'])
                        {
                            ?>

                                <?
                                if (!empty($arResult['DISPLAY_PROPERTIES']))
                                {
                                    $hidedt = 'visible';
                                    $hidedl = 'visible';
                                    $coundt =0;
                                    ?>
                                    <div class="properties">
                                        <h3 class="terms-title">Характеристики</h3>
                                        <div class="terms-wrapper">
                                            <div class="terms-dt">
                                        <?
                                        foreach ($arResult['DISPLAY_PROPERTIES'] as $property)
                                        {  if($coundt >9){$hidedt = 'unvisible';$flagd=1;}
                                            ?>
                                            <div class="<?=$hidedt?>"><?=$property['NAME']?></div>


                                            <?
                                            $coundt++;
                                        }

                                        ?>
                                            </div>
                                            <div class="terms-dl">
                                                <?
                                                $coundl =0;

                                                foreach ($arResult['DISPLAY_PROPERTIES'] as $property)
                                                {   if($coundl >9){$hidedl = 'unvisible';$flagd=1;}
                                                    ?>
                                                    <div class="<?=$hidedl?>"><?=(
                                                        is_array($property['DISPLAY_VALUE'])
                                                            ? implode(' / ', $property['DISPLAY_VALUE'])
                                                            : $property['DISPLAY_VALUE']
                                                        )?>
                                                    </div>


                                                    <?
                                                    $coundl++;
                                                }

                                                unset($property);
                                                ?>

                                            </div>
                                        </div>
                                        <? if($flagd ==1){?><span class="show-all">Развернуть все</span><?}?>
                                    </div>
                                    <?
                                }

                                if ($arResult['SHOW_OFFERS_PROPS'])
                                {
                                    ?>
                                    <dl class="product-item-detail-properties" id="<?=$itemIds['DISPLAY_PROP_DIV']?>"></dl>
                                    <?
                                }
                                ?>

                            <?
                        }
                        ?>








                        <div class="product-item-detail-info-section">
							<?
							foreach ($arParams['PRODUCT_INFO_BLOCK_ORDER'] as $blockName)
							{
								switch ($blockName)
								{
									case 'sku':
										if ($haveOffers && !empty($arResult['OFFERS_PROP']))
										{
											?>
											<div id="<?=$itemIds['TREE_ID']?>">
												<?
												foreach ($arResult['SKU_PROPS'] as $skuProperty)
												{
													if (!isset($arResult['OFFERS_PROP'][$skuProperty['CODE']]))
														continue;

													$propertyId = $skuProperty['ID'];
													$skuProps[] = array(
														'ID' => $propertyId,
														'SHOW_MODE' => $skuProperty['SHOW_MODE'],
														'VALUES' => $skuProperty['VALUES'],
														'VALUES_COUNT' => $skuProperty['VALUES_COUNT']
													);
													?>
													<div class="product-item-detail-info-container" data-entity="sku-line-block">
														<div class="product-item-detail-info-container-title"><?=htmlspecialcharsEx($skuProperty['NAME'])?></div>
														<div class="product-item-scu-container">
															<div class="product-item-scu-block">
																<div class="product-item-scu-list">
																	<ul class="product-item-scu-item-list">
																		<?
																		foreach ($skuProperty['VALUES'] as &$value)
																		{
																			$value['NAME'] = htmlspecialcharsbx($value['NAME']);

																			if ($skuProperty['SHOW_MODE'] === 'PICT')
																			{
																				?>
																				<li class="product-item-scu-item-color-container" title="<?=$value['NAME']?>"
																					data-treevalue="<?=$propertyId?>_<?=$value['ID']?>"
																					data-onevalue="<?=$value['ID']?>">
																					<div class="product-item-scu-item-color-block">
																						<div class="product-item-scu-item-color" title="<?=$value['NAME']?>"
																							style="background-image: url('<?=$value['PICT']['SRC']?>');">
																						</div>
																					</div>
																				</li>
																				<?
																			}
																			else
																			{
																				?>
																				<li class="product-item-scu-item-text-container" title="<?=$value['NAME']?>"
																					data-treevalue="<?=$propertyId?>_<?=$value['ID']?>"
																					data-onevalue="<?=$value['ID']?>">
																					<div class="product-item-scu-item-text-block">
																						<div class="product-item-scu-item-text"><?=$value['NAME']?></div>
																					</div>
																				</li>
																				<?
																			}
																		}
																		?>
																	</ul>
																	<div style="clear: both;"></div>
																</div>
															</div>
														</div>
													</div>
													<?
												}
												?>
											</div>
											<?
										}

										break;

									case 'props':
										if (!empty($arResult['DISPLAY_PROPERTIES']) || $arResult['SHOW_OFFERS_PROPS'])
										{
											?>
											<div class="product-item-detail-info-container">
												<?
												if (!empty($arResult['DISPLAY_PROPERTIES']))
												{
													?>
													<dl class="product-item-detail-properties">
														<?
														foreach ($arResult['DISPLAY_PROPERTIES'] as $property)
														{
															if (isset($arParams['MAIN_BLOCK_PROPERTY_CODE'][$property['CODE']]))
															{
																?>
																<dt><?=$property['NAME']?></dt>
																<dd><?=(is_array($property['DISPLAY_VALUE'])
																		? implode(' / ', $property['DISPLAY_VALUE'])
																		: $property['DISPLAY_VALUE'])?>
																</dd>
																<?
															}
														}
														unset($property);
														?>
													</dl>
													<?
												}

												if ($arResult['SHOW_OFFERS_PROPS'])
												{
													?>
													<dl class="product-item-detail-properties" id="<?=$itemIds['DISPLAY_MAIN_PROP_DIV']?>"></dl>
													<?
												}
												?>
											</div>
											<?
										}

										break;
								}
							}
							?>
						</div>
					

				</div>
			</div>
		</div>
        <div class="row no-gutters bottom-part-product">
            <div class="col-xs-12 col-md-9 no-padding">
                <div class="col-xs-12 description">
                    <h3 class="description-title">Описание</h3>
                    <div class="description-body"><?=$arResult['DETAIL_TEXT'];?></div>
					<div class="mob__banner-prod"><img src="<?=$mobpath;?>" alt=""></div>
                    <div class="ask-wrapper">
                        <div class="ask-form">
                           <span>Задать вопрос о товаре</span>
                        </div>
                    </div>
                </div>


            <?


            $arrFilter = array('IBLOCK_ID'=>1);

            $APPLICATION->IncludeComponent(
	"bitrix:catalog.section", 
	"similar", 
	array(
		"ACTION_VARIABLE" => "action",
		"ADD_PICT_PROP" => "-",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"ADD_TO_BASKET_ACTION" => "ADD",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BACKGROUND_IMAGE" => "-",
		"BASKET_URL" => "/cart/",
		"BROWSER_TITLE" => "-",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"COMPATIBLE_MODE" => "Y",
		"CONVERT_CURRENCY" => "N",
		"CUSTOM_FILTER" => "",
		"DETAIL_URL" => "/catalog/#SECTION_CODE#/#ELEMENT_CODE#/",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_COMPARE" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_ORDER2" => "desc",
		"ENLARGE_PRODUCT" => "STRICT",
		"FILTER_NAME" => "arrFilter",
		"HIDE_NOT_AVAILABLE" => "N",
		"HIDE_NOT_AVAILABLE_OFFERS" => "N",
		"IBLOCK_ID" => "1",
		"IBLOCK_TYPE" => "catalog",
		"INCLUDE_SUBSECTIONS" => "Y",
		"LABEL_PROP" => array(
		),
		"LAZY_LOAD" => "N",
		"LINE_ELEMENT_COUNT" => "4",
		"LOAD_ON_SCROLL" => "N",
		"MESSAGE_404" => "",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"OFFERS_CART_PROPERTIES" => array(
		),
		"OFFERS_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"OFFERS_LIMIT" => "5",
		"OFFERS_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_FIELD2" => "id",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_ORDER2" => "desc",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Товары",
		"PAGE_ELEMENT_COUNT" => "4",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRICE_CODE" => array(
			0 => "base_price",
		),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons,compare",
		"PRODUCT_DISPLAY_MODE" => "N",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPERTIES" => array(
		),
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
		"PRODUCT_SUBSCRIPTION" => "Y",
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"PROPERTY_CODE_MOBILE" => array(
		),
		"RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
		"RCM_TYPE" => "personal",
		"SECTION_CODE" => "",
		"SECTION_ID" => $arResult["SECTION"]["ID"],
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SECTION_URL" => "/catalog/#SECTION_CODE#/",
		"SECTION_USER_FIELDS" => array(
			0 => "",
			1 => "",
		),
		"SEF_MODE" => "N",
		"SET_BROWSER_TITLE" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "Y",
		"SHOW_404" => "N",
		"SHOW_ALL_WO_SECTION" => "N",
		"SHOW_CLOSE_POPUP" => "N",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_FROM_SECTION" => "N",
		"SHOW_MAX_QUANTITY" => "N",
		"SHOW_OLD_PRICE" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"SHOW_SLIDER" => "Y",
		"SLIDER_INTERVAL" => "3000",
		"SLIDER_PROGRESS" => "N",
		"TEMPLATE_THEME" => "blue",
		"USE_ENHANCED_ECOMMERCE" => "N",
		"USE_MAIN_ELEMENT_SECTION" => "N",
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "N",
		"COMPONENT_TEMPLATE" => "similar"
	),
	false
);
            $APPLICATION->IncludeComponent(
                'bitrix:catalog.products.viewed',
                'my_view',
                array(
                    'IBLOCK_MODE' => 'single',
                    'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
                    'IBLOCK_ID' => $arParams['IBLOCK_ID'],
                    'ELEMENT_SORT_FIELD' => $arParams['ELEMENT_SORT_FIELD'],
                    'ELEMENT_SORT_ORDER' => $arParams['ELEMENT_SORT_ORDER'],
                    'ELEMENT_SORT_FIELD2' => $arParams['ELEMENT_SORT_FIELD2'],
                    'ELEMENT_SORT_ORDER2' => $arParams['ELEMENT_SORT_ORDER2'],
                    'PROPERTY_CODE_'.$arParams['IBLOCK_ID'] => $arParams['LIST_PROPERTY_CODE'],
                    'PROPERTY_CODE_'.$recommendedData['OFFER_IBLOCK_ID'] => $arParams['LIST_OFFERS_PROPERTY_CODE'],
                    'PROPERTY_CODE_MOBILE'.$arParams['IBLOCK_ID'] => $arParams['LIST_PROPERTY_CODE_MOBILE'],
                    'BASKET_URL' => $arParams['BASKET_URL'],
                    'ACTION_VARIABLE' => $arParams['ACTION_VARIABLE'].'_cpv',
                    'PRODUCT_ID_VARIABLE' => $arParams['PRODUCT_ID_VARIABLE'],
                    'PRODUCT_QUANTITY_VARIABLE' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
                    'PRODUCT_PROPS_VARIABLE' => $arParams['PRODUCT_PROPS_VARIABLE'],
                    'CACHE_TYPE' => $arParams['CACHE_TYPE'],
                    'CACHE_TIME' => $arParams['CACHE_TIME'],
                    'CACHE_FILTER' => $arParams['CACHE_FILTER'],
                    'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
                    'DISPLAY_COMPARE' => $arParams['USE_COMPARE'],
                    'PRICE_CODE' => $arParams['PRICE_CODE'],
                    'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
                    'SHOW_PRICE_COUNT' => $arParams['SHOW_PRICE_COUNT'],
                    'DETAIL_PAGE_URL' => '/catalog/#SECTION_CODE#/#ELEMENT_CODE#/',
                    'PAGE_ELEMENT_COUNT' => 4,
                    'SECTION_ELEMENT_ID' => $elementId,

                    "SET_TITLE" => "N",
                    "SET_BROWSER_TITLE" => "N",
                    "SET_META_KEYWORDS" => "N",
                    "SET_META_DESCRIPTION" => "N",
                    "SET_LAST_MODIFIED" => "N",
                    "ADD_SECTIONS_CHAIN" => "N",

                    'PRICE_VAT_INCLUDE' => $arParams['PRICE_VAT_INCLUDE'],
                    'USE_PRODUCT_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
                    'ADD_PROPERTIES_TO_BASKET' => (isset($arParams['ADD_PROPERTIES_TO_BASKET']) ? $arParams['ADD_PROPERTIES_TO_BASKET'] : ''),
                    'PARTIAL_PRODUCT_PROPERTIES' => (isset($arParams['PARTIAL_PRODUCT_PROPERTIES']) ? $arParams['PARTIAL_PRODUCT_PROPERTIES'] : ''),
                    'CART_PROPERTIES_'.$arParams['IBLOCK_ID'] => $arParams['PRODUCT_PROPERTIES'],
                    'CART_PROPERTIES_'.$recommendedData['OFFER_IBLOCK_ID'] => $arParams['OFFERS_CART_PROPERTIES'],
                    'ADDITIONAL_PICT_PROP_'.$arParams['IBLOCK_ID'] => $arParams['ADD_PICT_PROP'],
                    'ADDITIONAL_PICT_PROP_'.$recommendedData['OFFER_IBLOCK_ID'] => $arParams['OFFER_ADD_PICT_PROP'],

                    'SHOW_FROM_SECTION' => 'N',
                    'DETAIL_URL' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['element'],
                    'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                    'CURRENCY_ID' => $arParams['CURRENCY_ID'],
                    'HIDE_NOT_AVAILABLE' => $arParams['HIDE_NOT_AVAILABLE'],
                    'HIDE_NOT_AVAILABLE_OFFERS' => $arParams['HIDE_NOT_AVAILABLE_OFFERS'],

                    'LABEL_PROP_'.$arParams['IBLOCK_ID'] => $arParams['LABEL_PROP'],
                    'LABEL_PROP_MOBILE_'.$arParams['IBLOCK_ID'] => $arParams['LABEL_PROP_MOBILE'],
                    'LABEL_PROP_POSITION' => $arParams['LABEL_PROP_POSITION'],
                    'PRODUCT_BLOCKS_ORDER' => $arParams['LIST_PRODUCT_BLOCKS_ORDER'],
                    'PRODUCT_ROW_VARIANTS' => "[{'VARIANT':'3','BIG_DATA':false}]",
                    'ENLARGE_PRODUCT' => $arParams['LIST_ENLARGE_PRODUCT'],
                    'ENLARGE_PROP_'.$arParams['IBLOCK_ID'] => isset($arParams['LIST_ENLARGE_PROP']) ? $arParams['LIST_ENLARGE_PROP'] : '',
                    'SHOW_SLIDER' => $arParams['LIST_SHOW_SLIDER'],
                    'SLIDER_INTERVAL' => isset($arParams['LIST_SLIDER_INTERVAL']) ? $arParams['LIST_SLIDER_INTERVAL'] : '',
                    'SLIDER_PROGRESS' => isset($arParams['LIST_SLIDER_PROGRESS']) ? $arParams['LIST_SLIDER_PROGRESS'] : '',

                    'OFFER_TREE_PROPS_'.$recommendedData['OFFER_IBLOCK_ID'] => $arParams['OFFER_TREE_PROPS'],
                    'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
                    'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
                    'DISCOUNT_PERCENT_POSITION' => $arParams['DISCOUNT_PERCENT_POSITION'],
                    'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
                    'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
                    'MESS_SHOW_MAX_QUANTITY' => (isset($arParams['~MESS_SHOW_MAX_QUANTITY']) ? $arParams['~MESS_SHOW_MAX_QUANTITY'] : ''),
                    'RELATIVE_QUANTITY_FACTOR' => (isset($arParams['RELATIVE_QUANTITY_FACTOR']) ? $arParams['RELATIVE_QUANTITY_FACTOR'] : ''),
                    'MESS_RELATIVE_QUANTITY_MANY' => (isset($arParams['~MESS_RELATIVE_QUANTITY_MANY']) ? $arParams['~MESS_RELATIVE_QUANTITY_MANY'] : ''),
                    'MESS_RELATIVE_QUANTITY_FEW' => (isset($arParams['~MESS_RELATIVE_QUANTITY_FEW']) ? $arParams['~MESS_RELATIVE_QUANTITY_FEW'] : ''),
                    'MESS_BTN_BUY' => (isset($arParams['~MESS_BTN_BUY']) ? $arParams['~MESS_BTN_BUY'] : ''),
                    'MESS_BTN_ADD_TO_BASKET' => (isset($arParams['~MESS_BTN_ADD_TO_BASKET']) ? $arParams['~MESS_BTN_ADD_TO_BASKET'] : ''),
                    'MESS_BTN_SUBSCRIBE' => (isset($arParams['~MESS_BTN_SUBSCRIBE']) ? $arParams['~MESS_BTN_SUBSCRIBE'] : ''),
                    'MESS_BTN_DETAIL' => (isset($arParams['~MESS_BTN_DETAIL']) ? $arParams['~MESS_BTN_DETAIL'] : ''),
                    'MESS_NOT_AVAILABLE' => (isset($arParams['~MESS_NOT_AVAILABLE']) ? $arParams['~MESS_NOT_AVAILABLE'] : ''),
                    'MESS_BTN_COMPARE' => (isset($arParams['~MESS_BTN_COMPARE']) ? $arParams['~MESS_BTN_COMPARE'] : ''),

                    'USE_ENHANCED_ECOMMERCE' => (isset($arParams['USE_ENHANCED_ECOMMERCE']) ? $arParams['USE_ENHANCED_ECOMMERCE'] : ''),
                    'DATA_LAYER_NAME' => (isset($arParams['DATA_LAYER_NAME']) ? $arParams['DATA_LAYER_NAME'] : ''),
                    'BRAND_PROPERTY' => (isset($arParams['BRAND_PROPERTY']) ? $arParams['BRAND_PROPERTY'] : ''),

                    'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
                    'ADD_TO_BASKET_ACTION' => $basketAction,
                    'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
                    'COMPARE_PATH' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare'],
                    'COMPARE_NAME' => $arParams['COMPARE_NAME']
                ),
                $component
            );
            ?>
<!--                LINKS-->
                <div class="col-xs-12 products_links">
                    <ul>
                        <? if (isset($arResult['DISPLAY_PROPERTIES']['brend']['VALUE'])){?>
                            <li><a href="<?=$full_path.$brend_path?>">Все <? print strtolower($sec_title); print ' '.$brend_name; ?> </a></li>
                            <li><a href="/catalog/<?=$brend_path?>">Все товары <?=$brend_name?></a></li>
                        <? }?>
                        <li><a href="<?=$full_path?>">Все <? print strtolower($sec_title); ?> </a></li>
                        <? if (isset($arResult['SECTION']['PATH'][1])){?>
                            <li><a href="<? $res = explode('/',$basePath.$arResult['SECTION']['PATH'][0]['SECTION_PAGE_URL']); echo "http://st-mall.ru/".$res[1]."/".$res[3]."/";?>">Все <? print strtolower($arResult['SECTION']['PATH'][0]['NAME']); ?> </a></li>
                        <? }?>
                    </ul>

                </div>
                <!-- FOOTER-MOBILE -->
                <div class="col-xs-12 fmob-grid-container">
                        <div class="fmob-grid">
                            <div class="f-item-1"><a href="/">Главная</a></div>
                            <div class="f-item-2"><a href="tel:+74950217733">Позвонить</a></div>
                            <div class="f-item-3"><a href="">Написать</a></div>
                            <div class="f-item-4"><a href="/favourites/">Избранное</a></div>
                            <div class="f-item-5"><a href="/cart/">Корзина</a></div>
                        </div>
                </div>
                <!-- FOOTER-MOBILE -->
<!--                BANNER-->
                <div class="col-xs-12 ">
                    <div class="banner">
                        <div class="banner-text-bonus"><span>Регистрируйся и получи скидку 500 руб. на первую покупку,
                            копи бонусы на следующие покупки</span></div>
                        <div class="bonus-wrap"><button>Получить</button></div>
                    </div>
                </div>
            </div>

<!--            RIGHT SIDE-->
            <div class="col-12 col-md-3 no-padding right-sideblock__container">
                <div class="right-sideblock">
                    <div class="delivery-1">
                        <ul> 
                          <div><span>Доставка</span></div>
                            <li>Доставка осуществляется во все города России
                            </li>
                            <li>Вы можете заказать доставку товаров до подъезда или до терминала транспортной компании в  вашем городе </li>
                            <li>Отправка товаров, имеющихся в наличии, осуществляется в течение 2-3 дней
                            </li>
<!--                            <li>Не продавайте запрещенные товары.</li>-->
                        </ul>
                        <a href="/dostavka-i-oplata/">Полные правила доставки</a>
                    </div>
                    
                    <div class="delivery-2">
                        <ul>
                            <div><span>Оплата</span></div>
                            <li>Оплата наличными курьеру для малогабаритных товаров (для Москвы и МО)</li>
                            <li>Безналичная оплата для крупногабаритных товаров по 100% предоплате и для всех товаров с доставкой по России</li>
                        </ul>
                        <a href="/dostavka-i-oplata/">Полные правила оплаты</a>
                    </div>
                    
                    <div class="delivery-3">
                        <ul>
                            <div><span>Возврат</span></div>
                            <li>При возврате товара надлежащего качества Вам возвращается полная стоимость товара за вычетом стоимости доставки и обратной пересылки</li>
                            <li>При возврате товара ненадлежащего качества Вам возвращается полная стоимость товара, доставки и обратной пересылки </li>
                            <li>Для помощи в оформленияи возврата свяжитесь с нашими менеджерами</li>
<!--                            <li>Полностью сохранен товарный вид;<br>сохранены потребительские свойства</li>-->
<!--                            <li>Не нарушены пломбы и фабричные ярлык</li>-->
                        </ul>
                        <a href="/pravila-vozvrata/">Полные правила возврата</a>
                    </div>
                    <div class="delivery-4">
                        <?
                        $APPLICATION->IncludeComponent(
                            "bitrix:catalog.section.list",
                            "my_product_list",
                            array(
                                "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                                "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                                "SECTION_ID" => $arResult['SECTION']['IBLOCK_SECTION_ID'],
                                "SECTION_CODE" => $arResult['ORIGINAL_PARAMETERS']['SECTION_CODE'],
                                "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                                "CACHE_TIME" => $arParams["CACHE_TIME"],
                                "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                                "COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
                                "TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
                                "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
                                "VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
                                "SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
                                "HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
                                "ADD_SECTIONS_CHAIN" => (isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : '')
                            ),
                            $component,
                            array("HIDE_ICONS" => "Y")
                        );?>


                        <a href=""></a>
                    </div>
                </div>
            </div>
        </div>

		<div class="row no-gutters">
			<div class="col-xs-12">
				<?
				if ($haveOffers)
				{
					if ($arResult['OFFER_GROUP'])
					{
						foreach ($arResult['OFFER_GROUP_VALUES'] as $offerId)
						{
							?>
							<span id="<?=$itemIds['OFFER_GROUP'].$offerId?>" style="display: none;">
								<?
								$APPLICATION->IncludeComponent(
									'bitrix:catalog.set.constructor',
									'.default',
									array(
										'IBLOCK_ID' => $arResult['OFFERS_IBLOCK'],
										'ELEMENT_ID' => $offerId,
										'PRICE_CODE' => $arParams['PRICE_CODE'],
										'BASKET_URL' => $arParams['BASKET_URL'],
										'OFFERS_CART_PROPERTIES' => $arParams['OFFERS_CART_PROPERTIES'],
										'CACHE_TYPE' => $arParams['CACHE_TYPE'],
										'CACHE_TIME' => $arParams['CACHE_TIME'],
										'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
										'TEMPLATE_THEME' => $arParams['~TEMPLATE_THEME'],
										'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
										'CURRENCY_ID' => $arParams['CURRENCY_ID']
									),
									$component,
									array('HIDE_ICONS' => 'Y')
								);
								?>
							</span>
							<?
						}
					}
				}
				else
				{
					if ($arResult['MODULES']['catalog'] && $arResult['OFFER_GROUP'])
					{
						$APPLICATION->IncludeComponent(
							'bitrix:catalog.set.constructor',
							'.default',
							array(
								'IBLOCK_ID' => $arParams['IBLOCK_ID'],
								'ELEMENT_ID' => $arResult['ID'],
								'PRICE_CODE' => $arParams['PRICE_CODE'],
								'BASKET_URL' => $arParams['BASKET_URL'],
								'CACHE_TYPE' => $arParams['CACHE_TYPE'],
								'CACHE_TIME' => $arParams['CACHE_TIME'],
								'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
								'TEMPLATE_THEME' => $arParams['~TEMPLATE_THEME'],
								'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
								'CURRENCY_ID' => $arParams['CURRENCY_ID']
							),
							$component,
							array('HIDE_ICONS' => 'Y')
						);
					}
				}
				?>
			</div>
		</div>

		
		<div class="row no-gutters">
			<div class="col-xs-12">
			<div style="display: none;">
				<?

					$res = CIBlockElement::GetList(
				    array(),
				    array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "ID" => $arResult['ID'], "INCLUDE_SUBSECTIONS" => "Y"),
				    false,
				    false,
				    array("ID", "IBLOCK_ID", "LANG_DIR", "DETAIL_PAGE_URL", "PROPERTY_BREND")
				  );

					$tmps = array();
					while($ob = $res->GetNext())
					{
						$tmps["BREND_VAL"] = $ob["PROPERTY_BREND_VALUE"];
					}

					if (!empty($tmps["BREND_VAL"])){
			            if (CModule::IncludeModule('highloadblock')){

			               $hlblock = Bitrix\Highloadblock\HighloadBlockTable::getById(1)->fetch(); // id highload
			               $entity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
			               $entityClass = $entity->getDataClass();

			               $resx = $entityClass::getList(array(
			                   'select' => array('ID','UF_NAME'),
			                   'filter' => array('UF_XML_ID' => $tmps["BREND_VAL"]) // $prop_val - 'marcotozzi'
			               ));

			                if ($erow = $resx->fetch())
			                   $tmps["BREND_NAME"] = $erow['UF_NAME'];  // "Marco Tozzi"

			            }
					}
					print $arResult['DISPLAY_PROPERTIES']['brend']['VALUE'].' '.$arResult['DISPLAY_PROPERTIES']['brend']['DISPLAY_VALUE'].'<br/>';
					//print $arResult['SECTION']['SECTION_PAGE_URL'];
					$basePath = $arResult['SECTION']['LIST_PAGE_URL'];
					$basePath = substr($basePath,0, strlen($basePath)-1);

					$full_path = '';
					$sec_title = '';

					if (isset($arResult['SECTION']['PATH'][1])){
						$full_path = $basePath.$arResult['SECTION']['PATH'][1]['SECTION_PAGE_URL'];
						$sec_title = $arResult['SECTION']['PATH'][1]['NAME'].' '.strtolower($arResult['SECTION']['PATH'][0]['NAME']);
					}
					else{
						$full_path = $basePath.$arResult['SECTION']['PATH'][0]['SECTION_PAGE_URL'];
						$sec_title = $arResult['SECTION']['PATH'][0]['NAME'];
					}

					//print_r ($arResult);

				 ?>
			</div>



			</div>
		</div>
		

		<div class="row no-gutters">
			<div class="col-xs-12">
				<?
				if ($arResult['CATALOG'] && $actualItem['CAN_BUY'] && \Bitrix\Main\ModuleManager::isModuleInstalled('sale'))
				{
					$APPLICATION->IncludeComponent(
						'bitrix:sale.prediction.product.detail',
						'.default',
						array(
							'BUTTON_ID' => $showBuyBtn ? $itemIds['BUY_LINK'] : $itemIds['ADD_BASKET_LINK'],
							'POTENTIAL_PRODUCT_TO_BUY' => array(
								'ID' => isset($arResult['ID']) ? $arResult['ID'] : null,
								'MODULE' => isset($arResult['MODULE']) ? $arResult['MODULE'] : 'catalog',
								'PRODUCT_PROVIDER_CLASS' => isset($arResult['PRODUCT_PROVIDER_CLASS']) ? $arResult['PRODUCT_PROVIDER_CLASS'] : 'CCatalogProductProvider',
								'QUANTITY' => isset($arResult['QUANTITY']) ? $arResult['QUANTITY'] : null,
								'IBLOCK_ID' => isset($arResult['IBLOCK_ID']) ? $arResult['IBLOCK_ID'] : null,

								'PRIMARY_OFFER_ID' => isset($arResult['OFFERS'][0]['ID']) ? $arResult['OFFERS'][0]['ID'] : null,
								'SECTION' => array(
									'ID' => isset($arResult['SECTION']['ID']) ? $arResult['SECTION']['ID'] : null,
									'IBLOCK_ID' => isset($arResult['SECTION']['IBLOCK_ID']) ? $arResult['SECTION']['IBLOCK_ID'] : null,
									'LEFT_MARGIN' => isset($arResult['SECTION']['LEFT_MARGIN']) ? $arResult['SECTION']['LEFT_MARGIN'] : null,
									'RIGHT_MARGIN' => isset($arResult['SECTION']['RIGHT_MARGIN']) ? $arResult['SECTION']['RIGHT_MARGIN'] : null,
								),
							)
						),
						$component,
						array('HIDE_ICONS' => 'Y')
					);
				}

				if ($arResult['CATALOG'] && $arParams['USE_GIFTS_DETAIL'] == 'Y' && \Bitrix\Main\ModuleManager::isModuleInstalled('sale'))
				{
					?>
					<div data-entity="parent-container">
						<?
						if (!isset($arParams['GIFTS_DETAIL_HIDE_BLOCK_TITLE']) || $arParams['GIFTS_DETAIL_HIDE_BLOCK_TITLE'] !== 'Y')
						{
							?>
							<div class="catalog-block-header" data-entity="header" data-showed="false" style="display: none; opacity: 0;">
								<?=($arParams['GIFTS_DETAIL_BLOCK_TITLE'] ?: Loc::getMessage('CT_BCE_CATALOG_GIFT_BLOCK_TITLE_DEFAULT'))?>
							</div>
							<?
						}

						CBitrixComponent::includeComponentClass('bitrix:sale.products.gift');
						$APPLICATION->IncludeComponent(
							'bitrix:sale.products.gift',
							'.default',
							array(
								'PRODUCT_ID_VARIABLE' => $arParams['PRODUCT_ID_VARIABLE'],
								'ACTION_VARIABLE' => $arParams['ACTION_VARIABLE'],

								'PRODUCT_ROW_VARIANTS' => "",
								'PAGE_ELEMENT_COUNT' => 0,
								'DEFERRED_PRODUCT_ROW_VARIANTS' => \Bitrix\Main\Web\Json::encode(
									SaleProductsGiftComponent::predictRowVariants(
										$arParams['GIFTS_DETAIL_PAGE_ELEMENT_COUNT'],
										$arParams['GIFTS_DETAIL_PAGE_ELEMENT_COUNT']
									)
								),
								'DEFERRED_PAGE_ELEMENT_COUNT' => $arParams['GIFTS_DETAIL_PAGE_ELEMENT_COUNT'],

								'SHOW_DISCOUNT_PERCENT' => $arParams['GIFTS_SHOW_DISCOUNT_PERCENT'],
								'DISCOUNT_PERCENT_POSITION' => $arParams['DISCOUNT_PERCENT_POSITION'],
								'SHOW_OLD_PRICE' => $arParams['GIFTS_SHOW_OLD_PRICE'],
								'PRODUCT_DISPLAY_MODE' => 'Y',
								'PRODUCT_BLOCKS_ORDER' => $arParams['GIFTS_PRODUCT_BLOCKS_ORDER'],
								'SHOW_SLIDER' => $arParams['GIFTS_SHOW_SLIDER'],
								'SLIDER_INTERVAL' => isset($arParams['GIFTS_SLIDER_INTERVAL']) ? $arParams['GIFTS_SLIDER_INTERVAL'] : '',
								'SLIDER_PROGRESS' => isset($arParams['GIFTS_SLIDER_PROGRESS']) ? $arParams['GIFTS_SLIDER_PROGRESS'] : '',

								'TEXT_LABEL_GIFT' => $arParams['GIFTS_DETAIL_TEXT_LABEL_GIFT'],

								'LABEL_PROP_'.$arParams['IBLOCK_ID'] => array(),
								'LABEL_PROP_MOBILE_'.$arParams['IBLOCK_ID'] => array(),
								'LABEL_PROP_POSITION' => $arParams['LABEL_PROP_POSITION'],

								'ADD_TO_BASKET_ACTION' => (isset($arParams['ADD_TO_BASKET_ACTION']) ? $arParams['ADD_TO_BASKET_ACTION'] : ''),
								'MESS_BTN_BUY' => $arParams['~GIFTS_MESS_BTN_BUY'],
								'MESS_BTN_ADD_TO_BASKET' => $arParams['~GIFTS_MESS_BTN_BUY'],
								'MESS_BTN_DETAIL' => $arParams['~MESS_BTN_DETAIL'],
								'MESS_BTN_SUBSCRIBE' => $arParams['~MESS_BTN_SUBSCRIBE'],

								'SHOW_PRODUCTS_'.$arParams['IBLOCK_ID'] => 'Y',
								'PROPERTY_CODE_'.$arParams['IBLOCK_ID'] => $arParams['LIST_PROPERTY_CODE'],
								'PROPERTY_CODE_MOBILE'.$arParams['IBLOCK_ID'] => $arParams['LIST_PROPERTY_CODE_MOBILE'],
								'PROPERTY_CODE_'.$arResult['OFFERS_IBLOCK'] => $arParams['OFFER_TREE_PROPS'],
								'OFFER_TREE_PROPS_'.$arResult['OFFERS_IBLOCK'] => $arParams['OFFER_TREE_PROPS'],
								'CART_PROPERTIES_'.$arResult['OFFERS_IBLOCK'] => $arParams['OFFERS_CART_PROPERTIES'],
								'ADDITIONAL_PICT_PROP_'.$arParams['IBLOCK_ID'] => (isset($arParams['ADD_PICT_PROP']) ? $arParams['ADD_PICT_PROP'] : ''),
								'ADDITIONAL_PICT_PROP_'.$arResult['OFFERS_IBLOCK'] => (isset($arParams['OFFER_ADD_PICT_PROP']) ? $arParams['OFFER_ADD_PICT_PROP'] : ''),

								'HIDE_NOT_AVAILABLE' => 'Y',
								'HIDE_NOT_AVAILABLE_OFFERS' => 'Y',
								'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
								'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
								'PRICE_CODE' => $arParams['PRICE_CODE'],
								'SHOW_PRICE_COUNT' => $arParams['SHOW_PRICE_COUNT'],
								'PRICE_VAT_INCLUDE' => $arParams['PRICE_VAT_INCLUDE'],
								'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
								'BASKET_URL' => $arParams['BASKET_URL'],
								'ADD_PROPERTIES_TO_BASKET' => $arParams['ADD_PROPERTIES_TO_BASKET'],
								'PRODUCT_PROPS_VARIABLE' => $arParams['PRODUCT_PROPS_VARIABLE'],
								'PARTIAL_PRODUCT_PROPERTIES' => $arParams['PARTIAL_PRODUCT_PROPERTIES'],
								'USE_PRODUCT_QUANTITY' => 'N',
								'PRODUCT_QUANTITY_VARIABLE' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
								'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
								'POTENTIAL_PRODUCT_TO_BUY' => array(
									'ID' => isset($arResult['ID']) ? $arResult['ID'] : null,
									'MODULE' => isset($arResult['MODULE']) ? $arResult['MODULE'] : 'catalog',
									'PRODUCT_PROVIDER_CLASS' => isset($arResult['PRODUCT_PROVIDER_CLASS']) ? $arResult['PRODUCT_PROVIDER_CLASS'] : 'CCatalogProductProvider',
									'QUANTITY' => isset($arResult['QUANTITY']) ? $arResult['QUANTITY'] : null,
									'IBLOCK_ID' => isset($arResult['IBLOCK_ID']) ? $arResult['IBLOCK_ID'] : null,

									'PRIMARY_OFFER_ID' => isset($arResult['OFFERS'][$arResult['OFFERS_SELECTED']]['ID'])
										? $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]['ID']
										: null,
									'SECTION' => array(
										'ID' => isset($arResult['SECTION']['ID']) ? $arResult['SECTION']['ID'] : null,
										'IBLOCK_ID' => isset($arResult['SECTION']['IBLOCK_ID']) ? $arResult['SECTION']['IBLOCK_ID'] : null,
										'LEFT_MARGIN' => isset($arResult['SECTION']['LEFT_MARGIN']) ? $arResult['SECTION']['LEFT_MARGIN'] : null,
										'RIGHT_MARGIN' => isset($arResult['SECTION']['RIGHT_MARGIN']) ? $arResult['SECTION']['RIGHT_MARGIN'] : null,
									),
								),

								'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
								'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
								'BRAND_PROPERTY' => $arParams['BRAND_PROPERTY']
							),
							$component,
							array('HIDE_ICONS' => 'Y')
						);
						?>
					</div>
					<?
				}

				if ($arResult['CATALOG'] && $arParams['USE_GIFTS_MAIN_PR_SECTION_LIST'] == 'Y' && \Bitrix\Main\ModuleManager::isModuleInstalled('sale'))
				{
					?>
					<div data-entity="parent-container">
						<?
						if (!isset($arParams['GIFTS_MAIN_PRODUCT_DETAIL_HIDE_BLOCK_TITLE']) || $arParams['GIFTS_MAIN_PRODUCT_DETAIL_HIDE_BLOCK_TITLE'] !== 'Y')
						{
							?>
							<div class="catalog-block-header" data-entity="header" data-showed="false" style="display: none; opacity: 0;">
								<?=($arParams['GIFTS_MAIN_PRODUCT_DETAIL_BLOCK_TITLE'] ?: Loc::getMessage('CT_BCE_CATALOG_GIFTS_MAIN_BLOCK_TITLE_DEFAULT'))?>
							</div>
							<?
						}

						$APPLICATION->IncludeComponent(
							'bitrix:sale.gift.main.products',
							'.default',
							array(
								'PAGE_ELEMENT_COUNT' => $arParams['GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT'],
								'LINE_ELEMENT_COUNT' => $arParams['GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT'],
								'HIDE_BLOCK_TITLE' => 'Y',
								'BLOCK_TITLE' => $arParams['GIFTS_MAIN_PRODUCT_DETAIL_BLOCK_TITLE'],

								'OFFERS_FIELD_CODE' => $arParams['OFFERS_FIELD_CODE'],
								'OFFERS_PROPERTY_CODE' => $arParams['OFFERS_PROPERTY_CODE'],

								'AJAX_MODE' => $arParams['AJAX_MODE'],
								'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
								'IBLOCK_ID' => $arParams['IBLOCK_ID'],

								'ELEMENT_SORT_FIELD' => 'ID',
								'ELEMENT_SORT_ORDER' => 'DESC',
								//'ELEMENT_SORT_FIELD2' => $arParams['ELEMENT_SORT_FIELD2'],
								//'ELEMENT_SORT_ORDER2' => $arParams['ELEMENT_SORT_ORDER2'],
								'FILTER_NAME' => 'searchFilter',
								'SECTION_URL' => $arParams['SECTION_URL'],
								'DETAIL_URL' => $arParams['DETAIL_URL'],
								'BASKET_URL' => $arParams['BASKET_URL'],
								'ACTION_VARIABLE' => $arParams['ACTION_VARIABLE'],
								'PRODUCT_ID_VARIABLE' => $arParams['PRODUCT_ID_VARIABLE'],
								'SECTION_ID_VARIABLE' => $arParams['SECTION_ID_VARIABLE'],

								'CACHE_TYPE' => $arParams['CACHE_TYPE'],
								'CACHE_TIME' => $arParams['CACHE_TIME'],

								'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
								'SET_TITLE' => $arParams['SET_TITLE'],
								'PROPERTY_CODE' => $arParams['PROPERTY_CODE'],
								'PRICE_CODE' => $arParams['PRICE_CODE'],
								'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
								'SHOW_PRICE_COUNT' => $arParams['SHOW_PRICE_COUNT'],

								'PRICE_VAT_INCLUDE' => $arParams['PRICE_VAT_INCLUDE'],
								'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
								'CURRENCY_ID' => $arParams['CURRENCY_ID'],
								'HIDE_NOT_AVAILABLE' => 'Y',
								'HIDE_NOT_AVAILABLE_OFFERS' => 'Y',
								'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
								'PRODUCT_BLOCKS_ORDER' => $arParams['GIFTS_PRODUCT_BLOCKS_ORDER'],

								'SHOW_SLIDER' => $arParams['GIFTS_SHOW_SLIDER'],
								'SLIDER_INTERVAL' => isset($arParams['GIFTS_SLIDER_INTERVAL']) ? $arParams['GIFTS_SLIDER_INTERVAL'] : '',
								'SLIDER_PROGRESS' => isset($arParams['GIFTS_SLIDER_PROGRESS']) ? $arParams['GIFTS_SLIDER_PROGRESS'] : '',

								'ADD_PICT_PROP' => (isset($arParams['ADD_PICT_PROP']) ? $arParams['ADD_PICT_PROP'] : ''),
								'LABEL_PROP' => (isset($arParams['LABEL_PROP']) ? $arParams['LABEL_PROP'] : ''),
								'LABEL_PROP_MOBILE' => (isset($arParams['LABEL_PROP_MOBILE']) ? $arParams['LABEL_PROP_MOBILE'] : ''),
								'LABEL_PROP_POSITION' => (isset($arParams['LABEL_PROP_POSITION']) ? $arParams['LABEL_PROP_POSITION'] : ''),
								'OFFER_ADD_PICT_PROP' => (isset($arParams['OFFER_ADD_PICT_PROP']) ? $arParams['OFFER_ADD_PICT_PROP'] : ''),
								'OFFER_TREE_PROPS' => (isset($arParams['OFFER_TREE_PROPS']) ? $arParams['OFFER_TREE_PROPS'] : ''),
								'SHOW_DISCOUNT_PERCENT' => (isset($arParams['SHOW_DISCOUNT_PERCENT']) ? $arParams['SHOW_DISCOUNT_PERCENT'] : ''),
								'DISCOUNT_PERCENT_POSITION' => (isset($arParams['DISCOUNT_PERCENT_POSITION']) ? $arParams['DISCOUNT_PERCENT_POSITION'] : ''),
								'SHOW_OLD_PRICE' => (isset($arParams['SHOW_OLD_PRICE']) ? $arParams['SHOW_OLD_PRICE'] : ''),
								'MESS_BTN_BUY' => (isset($arParams['~MESS_BTN_BUY']) ? $arParams['~MESS_BTN_BUY'] : ''),
								'MESS_BTN_ADD_TO_BASKET' => (isset($arParams['~MESS_BTN_ADD_TO_BASKET']) ? $arParams['~MESS_BTN_ADD_TO_BASKET'] : ''),
								'MESS_BTN_DETAIL' => (isset($arParams['~MESS_BTN_DETAIL']) ? $arParams['~MESS_BTN_DETAIL'] : ''),
								'MESS_NOT_AVAILABLE' => (isset($arParams['~MESS_NOT_AVAILABLE']) ? $arParams['~MESS_NOT_AVAILABLE'] : ''),
								'ADD_TO_BASKET_ACTION' => (isset($arParams['ADD_TO_BASKET_ACTION']) ? $arParams['ADD_TO_BASKET_ACTION'] : ''),
								'SHOW_CLOSE_POPUP' => (isset($arParams['SHOW_CLOSE_POPUP']) ? $arParams['SHOW_CLOSE_POPUP'] : ''),
								'DISPLAY_COMPARE' => (isset($arParams['DISPLAY_COMPARE']) ? $arParams['DISPLAY_COMPARE'] : ''),
								'COMPARE_PATH' => (isset($arParams['COMPARE_PATH']) ? $arParams['COMPARE_PATH'] : ''),
							)
							+ array(
								'OFFER_ID' => empty($arResult['OFFERS'][$arResult['OFFERS_SELECTED']]['ID'])
									? $arResult['ID']
									: $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]['ID'],
								'SECTION_ID' => $arResult['SECTION']['ID'],
								'ELEMENT_ID' => $arResult['ID'],

								'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
								'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
								'BRAND_PROPERTY' => $arParams['BRAND_PROPERTY']
							),
							$component,
							array('HIDE_ICONS' => 'Y')
						);
						?>
					</div>
					<?
				}
				?>
			</div>
		</div>
	</div>
	<!--Small Card-->
	<div class="product-item-detail-short-card-fixed hidden-xs" id="<?=$itemIds['SMALL_CARD_PANEL_ID']?>">
		<div class="product-item-detail-short-card-content-container">
			<table>
				<tr>
					<td rowspan="2" class="product-item-detail-short-card-image">
						<img src="" style="height: 65px;" data-entity="panel-picture">
					</td>
					<td class="product-item-detail-short-title-container" data-entity="panel-title">
						<span class="product-item-detail-short-title-text"><?=$name?></span>
					</td>
					<td rowspan="2" class="product-item-detail-short-card-price">
						<?
						if ($arParams['SHOW_OLD_PRICE'] === 'Y')
						{
							?>
							<div class="product-item-detail-price-old" style="display: <?=($showDiscount ? '' : 'none')?>;"
								data-entity="panel-old-price">
								<?=($showDiscount ? $price['PRINT_RATIO_BASE_PRICE'] : '')?>
							</div>
							<?
						}
						?>
						<div class="product-item-detail-price-current" data-entity="panel-price">
							<?=$price['PRINT_RATIO_PRICE']?>
						</div>
					</td>
					<?
					if ($showAddBtn)
					{
						?>
						<td rowspan="2" class="product-item-detail-short-card-btn"
							style="display: <?=($actualItem['CAN_BUY'] ? '' : 'none')?>;"
							data-entity="panel-add-button">
							<a class="btn <?=$showButtonClassName?> product-item-detail-buy-button"
								id="<?=$itemIds['ADD_BASKET_LINK']?>"
								href="javascript:void(0);">
								<span><?=$arParams['MESS_BTN_ADD_TO_BASKET']?></span>
							</a>
						</td>
						<?
					}

					if ($showBuyBtn)
					{
						?>
						<td rowspan="2" class="product-item-detail-short-card-btn"
							style="display: <?=($actualItem['CAN_BUY'] ? '' : 'none')?>;"
							data-entity="panel-buy-button">
							<a class="btn <?=$buyButtonClassName?> product-item-detail-buy-button" id="<?=$itemIds['BUY_LINK']?>"
								href="javascript:void(0);">
								<span><?=$arParams['MESS_BTN_BUY']?></span>
							</a>
						</td>
						<?
					}
					?>
					<td rowspan="2" class="product-item-detail-short-card-btn"
						style="display: <?=(!$actualItem['CAN_BUY'] ? '' : 'none')?>;"
						data-entity="panel-not-available-button">
						<a class="btn btn-link product-item-detail-buy-button" href="javascript:void(0)"
							rel="nofollow">
							<?=$arParams['MESS_NOT_AVAILABLE']?>
						</a>
					</td>
				</tr>
				<?
				if ($haveOffers)
				{
					?>
					<tr>
						<td>
							<div class="product-item-selected-scu-container" data-entity="panel-sku-container">
								<?
								$i = 0;

								foreach ($arResult['SKU_PROPS'] as $skuProperty)
								{
									if (!isset($arResult['OFFERS_PROP'][$skuProperty['CODE']]))
									{
										continue;
									}

									$propertyId = $skuProperty['ID'];

									foreach ($skuProperty['VALUES'] as $value)
									{
										$value['NAME'] = htmlspecialcharsbx($value['NAME']);
										if ($skuProperty['SHOW_MODE'] === 'PICT')
										{
											?>
											<div class="product-item-selected-scu product-item-selected-scu-color selected"
												title="<?=$value['NAME']?>"
												style="background-image: url('<?=$value['PICT']['SRC']?>'); display: none;"
												data-sku-line="<?=$i?>"
												data-treevalue="<?=$propertyId?>_<?=$value['ID']?>"
												data-onevalue="<?=$value['ID']?>">
											</div>
											<?
										}
										else
										{
											?>
											<div class="product-item-selected-scu product-item-selected-scu-text selected"
												title="<?=$value['NAME']?>"
												style="display: none;"
												data-sku-line="<?=$i?>"
												data-treevalue="<?=$propertyId?>_<?=$value['ID']?>"
												data-onevalue="<?=$value['ID']?>">
												<?=$value['NAME']?>
											</div>
											<?
										}
									}

									$i++;
								}
								?>
							</div>
						</td>
					</tr>
					<?
				}
				?>
			</table>
		</div>
	</div>
	<!--Top tabs-->
	<div class="product-item-detail-tabs-container-fixed hidden-xs" id="<?=$itemIds['TABS_PANEL_ID']?>">
		<ul class="product-item-detail-tabs-list">
			<?
			if ($showDescription)
			{
				?>
				<li class="product-item-detail-tab active" data-entity="tab" data-value="description">
					<a href="javascript:void(0);" class="product-item-detail-tab-link">
						<span><?=$arParams['MESS_DESCRIPTION_TAB']?></span>
					</a>
				</li>
				<?
			}

			if (!empty($arResult['DISPLAY_PROPERTIES']) || $arResult['SHOW_OFFERS_PROPS'])
			{
				?>
				<li class="product-item-detail-tab" data-entity="tab" data-value="properties">
					<a href="javascript:void(0);" class="product-item-detail-tab-link">
						<span><?=$arParams['MESS_PROPERTIES_TAB']?></span>
					</a>
				</li>
				<?
			}

			if ($arParams['USE_COMMENTS'] === 'Y')
			{
				?>
				<li class="product-item-detail-tab" data-entity="tab" data-value="comments">
					<a href="javascript:void(0);" class="product-item-detail-tab-link">
						<span><?=$arParams['MESS_COMMENTS_TAB']?></span>
					</a>
				</li>
				<?
			}
			?>
		</ul>
	</div>

	<meta itemprop="name" content="<?=$name?>" />
	<meta itemprop="category" content="<?=$arResult['CATEGORY_PATH']?>" />
	<?
	if ($haveOffers)
	{
		foreach ($arResult['JS_OFFERS'] as $offer)
		{
			$currentOffersList = array();

			if (!empty($offer['TREE']) && is_array($offer['TREE']))
			{
				foreach ($offer['TREE'] as $propName => $skuId)
				{
					$propId = (int)substr($propName, 5);

					foreach ($skuProps as $prop)
					{
						if ($prop['ID'] == $propId)
						{
							foreach ($prop['VALUES'] as $propId => $propValue)
							{
								if ($propId == $skuId)
								{
									$currentOffersList[] = $propValue['NAME'];
									break;
								}
							}
						}
					}
				}
			}

			$offerPrice = $offer['ITEM_PRICES'][$offer['ITEM_PRICE_SELECTED']];
			?>
			<span itemprop="offers" itemscope itemtype="http://schema.org/Offer">
				<meta itemprop="sku" content="<?=htmlspecialcharsbx(implode('/', $currentOffersList))?>" />
				<meta itemprop="price" content="<?=$offerPrice['RATIO_PRICE']?>" />
				<meta itemprop="priceCurrency" content="<?=$offerPrice['CURRENCY']?>" />
				<link itemprop="availability" href="http://schema.org/<?=($offer['CAN_BUY'] ? 'InStock' : 'OutOfStock')?>" />
			</span>
			<?
		}

		unset($offerPrice, $currentOffersList);
	}
	else
	{
		?>
		<span itemprop="offers" itemscope itemtype="http://schema.org/Offer">
			<meta itemprop="price" content="<?=$price['RATIO_PRICE']?>" />
			<meta itemprop="priceCurrency" content="<?=$price['CURRENCY']?>" />
			<link itemprop="availability" href="http://schema.org/<?=($actualItem['CAN_BUY'] ? 'InStock' : 'OutOfStock')?>" />
		</span>
		<?
	}
	?>

<?
if ($haveOffers)
{
	$offerIds = array();
	$offerCodes = array();

	$useRatio = $arParams['USE_RATIO_IN_RANGES'] === 'Y';

	foreach ($arResult['JS_OFFERS'] as $ind => &$jsOffer)
	{
		$offerIds[] = (int)$jsOffer['ID'];
		$offerCodes[] = $jsOffer['CODE'];

		$fullOffer = $arResult['OFFERS'][$ind];
		$measureName = $fullOffer['ITEM_MEASURE']['TITLE'];

		$strAllProps = '';
		$strMainProps = '';
		$strPriceRangesRatio = '';
		$strPriceRanges = '';

		if ($arResult['SHOW_OFFERS_PROPS'])
		{
			if (!empty($jsOffer['DISPLAY_PROPERTIES']))
			{
				foreach ($jsOffer['DISPLAY_PROPERTIES'] as $property)
				{
					$current = '<dt>'.$property['NAME'].'</dt><dd>'.(
						is_array($property['VALUE'])
							? implode(' / ', $property['VALUE'])
							: $property['VALUE']
						).'</dd>';
					$strAllProps .= $current;

					if (isset($arParams['MAIN_BLOCK_OFFERS_PROPERTY_CODE'][$property['CODE']]))
					{
						$strMainProps .= $current;
					}
				}

				unset($current);
			}
		}

		if ($arParams['USE_PRICE_COUNT'] && count($jsOffer['ITEM_QUANTITY_RANGES']) > 1)
		{
			$strPriceRangesRatio = '('.Loc::getMessage(
					'CT_BCE_CATALOG_RATIO_PRICE',
					array('#RATIO#' => ($useRatio
							? $fullOffer['ITEM_MEASURE_RATIOS'][$fullOffer['ITEM_MEASURE_RATIO_SELECTED']]['RATIO']
							: '1'
						).' '.$measureName)
				).')';

			foreach ($jsOffer['ITEM_QUANTITY_RANGES'] as $range)
			{
				if ($range['HASH'] !== 'ZERO-INF')
				{
					$itemPrice = false;

					foreach ($jsOffer['ITEM_PRICES'] as $itemPrice)
					{
						if ($itemPrice['QUANTITY_HASH'] === $range['HASH'])
						{
							break;
						}
					}

					if ($itemPrice)
					{
						$strPriceRanges .= '<dt>'.Loc::getMessage(
								'CT_BCE_CATALOG_RANGE_FROM',
								array('#FROM#' => $range['SORT_FROM'].' '.$measureName)
							).' ';

						if (is_infinite($range['SORT_TO']))
						{
							$strPriceRanges .= Loc::getMessage('CT_BCE_CATALOG_RANGE_MORE');
						}
						else
						{
							$strPriceRanges .= Loc::getMessage(
								'CT_BCE_CATALOG_RANGE_TO',
								array('#TO#' => $range['SORT_TO'].' '.$measureName)
							);
						}

						$strPriceRanges .= '</dt><dd>'.($useRatio ? $itemPrice['PRINT_RATIO_PRICE'] : $itemPrice['PRINT_PRICE']).'</dd>';
					}
				}
			}

			unset($range, $itemPrice);
		}

		$jsOffer['DISPLAY_PROPERTIES'] = $strAllProps;
		$jsOffer['DISPLAY_PROPERTIES_MAIN_BLOCK'] = $strMainProps;
		$jsOffer['PRICE_RANGES_RATIO_HTML'] = $strPriceRangesRatio;
		$jsOffer['PRICE_RANGES_HTML'] = $strPriceRanges;
	}

	$templateData['OFFER_IDS'] = $offerIds;
	$templateData['OFFER_CODES'] = $offerCodes;
	unset($jsOffer, $strAllProps, $strMainProps, $strPriceRanges, $strPriceRangesRatio, $useRatio);

	$jsParams = array(
		'CONFIG' => array(
			'USE_CATALOG' => $arResult['CATALOG'],
			'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
			'SHOW_PRICE' => true,
			'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'] === 'Y',
			'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'] === 'Y',
			'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
			'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
			'SHOW_SKU_PROPS' => $arResult['SHOW_OFFERS_PROPS'],
			'OFFER_GROUP' => $arResult['OFFER_GROUP'],
			'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
			'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
			'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'] === 'Y',
			'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
			'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
			'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
			'USE_STICKERS' => true,
			'USE_SUBSCRIBE' => $showSubscribe,
			'SHOW_SLIDER' => $arParams['SHOW_SLIDER'],
			'SLIDER_INTERVAL' => $arParams['SLIDER_INTERVAL'],
			'ALT' => $alt,
			'TITLE' => $title,
			'MAGNIFIER_ZOOM_PERCENT' => 200,
			'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
			'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
			'BRAND_PROPERTY' => !empty($arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']])
				? $arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']]['DISPLAY_VALUE']
				: null
		),
		'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
		'VISUAL' => $itemIds,
		'DEFAULT_PICTURE' => array(
			'PREVIEW_PICTURE' => $arResult['DEFAULT_PICTURE'],
			'DETAIL_PICTURE' => $arResult['DEFAULT_PICTURE']
		),
		'PRODUCT' => array(
			'ID' => $arResult['ID'],
			'ACTIVE' => $arResult['ACTIVE'],
			'NAME' => $arResult['~NAME'],
			'CATEGORY' => $arResult['CATEGORY_PATH']
		),
		'BASKET' => array(
			'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
			'BASKET_URL' => $arParams['BASKET_URL'],
			'SKU_PROPS' => $arResult['OFFERS_PROP_CODES'],
			'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
			'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
		),
		'OFFERS' => $arResult['JS_OFFERS'],
		'OFFER_SELECTED' => $arResult['OFFERS_SELECTED'],
		'TREE_PROPS' => $skuProps
	);
}
else
{
	$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
	if ($arParams['ADD_PROPERTIES_TO_BASKET'] === 'Y' && !$emptyProductProperties)
	{
		?>
		<div id="<?=$itemIds['BASKET_PROP_DIV']?>" style="display: none;">
			<?
			if (!empty($arResult['PRODUCT_PROPERTIES_FILL']))
			{
				foreach ($arResult['PRODUCT_PROPERTIES_FILL'] as $propId => $propInfo)
				{
					?>
					<input type="hidden" name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propId?>]" value="<?=htmlspecialcharsbx($propInfo['ID'])?>">
					<?
					unset($arResult['PRODUCT_PROPERTIES'][$propId]);
				}
			}

			$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
			if (!$emptyProductProperties)
			{
				?>
				<table>
					<?
					foreach ($arResult['PRODUCT_PROPERTIES'] as $propId => $propInfo)
					{
						?>
						<tr>
							<td><?=$arResult['PROPERTIES'][$propId]['NAME']?></td>
							<td>
								<?
								if (
									$arResult['PROPERTIES'][$propId]['PROPERTY_TYPE'] === 'L'
									&& $arResult['PROPERTIES'][$propId]['LIST_TYPE'] === 'C'
								)
								{
									foreach ($propInfo['VALUES'] as $valueId => $value)
									{
										?>
										<label>
											<input type="radio" name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propId?>]"
												value="<?=$valueId?>" <?=($valueId == $propInfo['SELECTED'] ? '"checked"' : '')?>>
											<?=$value?>
										</label>
										<br>
										<?
									}
								}
								else
								{
									?>
									<select name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propId?>]">
										<?
										foreach ($propInfo['VALUES'] as $valueId => $value)
										{
											?>
											<option value="<?=$valueId?>" <?=($valueId == $propInfo['SELECTED'] ? '"selected"' : '')?>>
												<?=$value?>
											</option>
											<?
										}
										?>
									</select>
									<?
								}
								?>
							</td>
						</tr>
						<?
					}
					?>
				</table>
				<?
			}
			?>
		</div>
		<?
	}



	$jsParams = array(
		'CONFIG' => array(
			'USE_CATALOG' => $arResult['CATALOG'],
			'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
			'SHOW_PRICE' => !empty($arResult['ITEM_PRICES']),
			'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'] === 'Y',
			'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'] === 'Y',
			'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
			'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
			'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
			'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
			'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'] === 'Y',
			'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
			'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
			'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
			'USE_STICKERS' => true,
			'USE_SUBSCRIBE' => $showSubscribe,
			'SHOW_SLIDER' => $arParams['SHOW_SLIDER'],
			'SLIDER_INTERVAL' => $arParams['SLIDER_INTERVAL'],
			'ALT' => $alt,
			'TITLE' => $title,
			'MAGNIFIER_ZOOM_PERCENT' => 200,
			'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
			'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
			'BRAND_PROPERTY' => !empty($arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']])
				? $arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']]['DISPLAY_VALUE']
				: null
		),
		'VISUAL' => $itemIds,
		'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
		'PRODUCT' => array(
			'ID' => $arResult['ID'],
			'ACTIVE' => $arResult['ACTIVE'],
			'PICT' => reset($arResult['MORE_PHOTO']),
			'NAME' => $arResult['~NAME'],
			'SUBSCRIPTION' => true,
			'ITEM_PRICE_MODE' => $arResult['ITEM_PRICE_MODE'],
			'ITEM_PRICES' => $arResult['ITEM_PRICES'],
			'ITEM_PRICE_SELECTED' => $arResult['ITEM_PRICE_SELECTED'],
			'ITEM_QUANTITY_RANGES' => $arResult['ITEM_QUANTITY_RANGES'],
			'ITEM_QUANTITY_RANGE_SELECTED' => $arResult['ITEM_QUANTITY_RANGE_SELECTED'],
			'ITEM_MEASURE_RATIOS' => $arResult['ITEM_MEASURE_RATIOS'],
			'ITEM_MEASURE_RATIO_SELECTED' => $arResult['ITEM_MEASURE_RATIO_SELECTED'],
			'SLIDER_COUNT' => $arResult['MORE_PHOTO_COUNT'],
			'SLIDER' => $arResult['MORE_PHOTO'],
			'CAN_BUY' => $arResult['CAN_BUY'],
			'CHECK_QUANTITY' => $arResult['CHECK_QUANTITY'],
			'QUANTITY_FLOAT' => is_float($arResult['ITEM_MEASURE_RATIOS'][$arResult['ITEM_MEASURE_RATIO_SELECTED']]['RATIO']),
			'MAX_QUANTITY' => $arResult['CATALOG_QUANTITY'],
			'STEP_QUANTITY' => $arResult['ITEM_MEASURE_RATIOS'][$arResult['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'],
			'CATEGORY' => $arResult['CATEGORY_PATH']
		),
		'BASKET' => array(
			'ADD_PROPS' => $arParams['ADD_PROPERTIES_TO_BASKET'] === 'Y',
			'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
			'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
			'EMPTY_PROPS' => $emptyProductProperties,
			'BASKET_URL' => $arParams['BASKET_URL'],
			'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
			'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
		)
	);
	unset($emptyProductProperties);
}

if ($arParams['DISPLAY_COMPARE'])
{
	$jsParams['COMPARE'] = array(
		'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
		'COMPARE_DELETE_URL_TEMPLATE' => $arResult['~COMPARE_DELETE_URL_TEMPLATE'],
		'COMPARE_PATH' => $arParams['COMPARE_PATH']
	);
}
?>
<script>
	BX.message({
		ECONOMY_INFO_MESSAGE: '<?=GetMessageJS('CT_BCE_CATALOG_ECONOMY_INFO2')?>',
		TITLE_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_TITLE_ERROR')?>',
		TITLE_BASKET_PROPS: '<?=GetMessageJS('CT_BCE_CATALOG_TITLE_BASKET_PROPS')?>',
		BASKET_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_BASKET_UNKNOWN_ERROR')?>',
		BTN_SEND_PROPS: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_SEND_PROPS')?>',
		BTN_MESSAGE_BASKET_REDIRECT: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_BASKET_REDIRECT')?>',
		BTN_MESSAGE_CLOSE: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE')?>',
		BTN_MESSAGE_CLOSE_POPUP: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE_POPUP')?>',
		TITLE_SUCCESSFUL: '<?=GetMessageJS('CT_BCE_CATALOG_ADD_TO_BASKET_OK')?>',
		COMPARE_MESSAGE_OK: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_OK')?>',
		COMPARE_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_UNKNOWN_ERROR')?>',
		COMPARE_TITLE: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_TITLE')?>',
		BTN_MESSAGE_COMPARE_REDIRECT: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_COMPARE_REDIRECT')?>',
		PRODUCT_GIFT_LABEL: '<?=GetMessageJS('CT_BCE_CATALOG_PRODUCT_GIFT_LABEL')?>',
		PRICE_TOTAL_PREFIX: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_PRICE_TOTAL_PREFIX')?>',
		RELATIVE_QUANTITY_MANY: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_MANY'])?>',
		RELATIVE_QUANTITY_FEW: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_FEW'])?>',
		SITE_ID: '<?=SITE_ID?>'
	});

	var <?=$obName?> = new JCCatalogElement(<?=CUtil::PhpToJSObject($jsParams, false, true)?>);
</script>
<?
unset($actualItem, $itemIds, $jsParams);?>



