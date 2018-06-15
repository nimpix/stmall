<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/stmall/brands.php");
if (empty($arResult["ALL_ITEMS"]))
	return;

if (file_exists($_SERVER["DOCUMENT_ROOT"].$this->GetFolder().'/themes/'.$arParams["MENU_THEME"].'/colors.css'))
	$APPLICATION->SetAdditionalCSS($this->GetFolder().'/themes/'.$arParams["MENU_THEME"].'/colors.css');

CJSCore::Init();

$menuBlockId = "categories_menu";
?>




    <?$resId = makeHLpropList(); $cnt = 1; ?>

<!--Меню-->
<?
//print "<pre>";
//print_r($arResult['ALL_ITEMS']);
//print "</pre>";
//$_SESSION['myResult2'] = $arResult['ALL_ITEMS'];
unset($_SESSION['myResult2']);
?>
        <div class="dropdown-menu menu-desk">
                <ul id="main-container">
                    <!---->
                    <?foreach($arResult["MENU_STRUCTURE"] as $itemID => $arColumns):?>     <!-- first level-->
                        <?$existPictureDescColomn = ($arResult["ALL_ITEMS"][$itemID]["PARAMS"]["picture_src"] || $arResult["ALL_ITEMS"][$itemID]["PARAMS"]["description"]) ? true : false;?>
                        <? if($arResult["ALL_ITEMS"][$itemID]["PARAMS"]['count_of_el'] == 0) continue;?>
                        <li class="cat<? print $cnt; $cnt++;?>">
                            <a class="link-cat" href="<?=$arResult["ALL_ITEMS"][$itemID]["LINK"]?>" <?if (is_array($arColumns) && count($arColumns) > 0 && $existPictureDescColomn):?>onmouseover="BX.CatalogVertMenu.changeSectionPicture(this);"<?endif?>>
                                <?=$arResult["ALL_ITEMS"][$itemID]["TEXT"]?>
                                <span class="bx_shadow_fix"></span>
                            </a>
                            <div class="dropwrap">
                            <ul class="dropdown-list">
                            <?if (is_array($arColumns) && count($arColumns) > 0):?>
                        <!--  Category 2-->
                            <div class="categ-wrap">
                                <ul class="categories-ul">
                                    <?foreach($arColumns as $key=>$arRow):?>
                                    <? $len = sizeof($arRow);?>

                                                <?foreach($arRow as $itemIdLevel_2=>$arLevel_3):?>  <!-- second level-->
                                            <? if($arResult["ALL_ITEMS"][$itemIdLevel_2]["PARAMS"]['count_of_el'] == 0) {$len--;continue;}?>
                                                    <li class="ul-header">
                                                        <a id="lev-1" href="<? $res = explode("/",$arResult["ALL_ITEMS"][$itemIdLevel_2]["LINK"]); echo "/".$res[1]."/".$res[3]."/";?>" <?if ($existPictureDescColomn):?>ontouchstart="document.location.href = '<?=$arResult["ALL_ITEMS"][$itemIdLevel_2]["LINK"]?>';" onmouseover="BX.CatalogVertMenu.changeSectionPicture(this);"<?endif?> data-picture="<?=$arResult["ALL_ITEMS"][$itemIdLevel_2]["PARAMS"]["picture_src"]?>">
                                                            <?=$arResult["ALL_ITEMS"][$itemIdLevel_2]["TEXT"]?>
                                                        </a>
                                                        <span style="display: none">
								<?=$arResult["ALL_ITEMS"][$itemIdLevel_2]["PARAMS"]["description"]?>
							</span>
                                                        <?if (is_array($arLevel_3) && count($arLevel_3) > 0):?>
                                                            <ul>
                                                                <?foreach($arLevel_3 as $itemIdLevel_3):?>	<!-- third level-->
                                                                    <? if($arResult["ALL_ITEMS"][$itemIdLevel_3]["PARAMS"]['count_of_el'] == 0) continue;?>
                                                                    <li>
                                                                        <a href="<?$res = explode("/",$arResult["ALL_ITEMS"][$itemIdLevel_3]["LINK"]); echo "/".$res[1]."/".$res[4]."/";?>" <?if ($existPictureDescColomn):?>ontouchstart="document.location.href = '<?=$arResult["ALL_ITEMS"][$itemIdLevel_2]["LINK"]?>';return false;" onmouseover="BX.CatalogVertMenu.changeSectionPicture(this);return false;"<?endif?> data-picture="<?=$arResult["ALL_ITEMS"][$itemIdLevel_3]["PARAMS"]["picture_src"]?>">
                                                                            <?=$arResult["ALL_ITEMS"][$itemIdLevel_3]["TEXT"]?>
                                                                        </a>
                                                                        <span style="display: none">
										<?=$arResult["ALL_ITEMS"][$itemIdLevel_3]["PARAMS"]["description"]?>
									</span>

                                                                    </li>
                                                                <?endforeach;?>
                                                            </ul>
                                                        <?endif?>
                                        <!--  Category 2-->
                                                    </li>
                                    <? $len--;?>
                                                <?endforeach;?>

                                    <?endforeach;?>
                                </ul>
                            </div>
                            <?endif?>

                                <!-- Unredable properties-->
                                <?
                                $UrlToId = getSectionIDbyCODE($arResult["ALL_ITEMS"][$itemID]["LINK"]);
                                $res = CIBlockElement::GetList(
                                    array(),
                                    array("IBLOCK_ID" => 1, "SECTION_ID" => $UrlToId, "INCLUDE_SUBSECTIONS" => "Y"),
                                    false,
                                    false,
                                    array("ID", "IBLOCK_ID", "LANG_DIR", "DETAIL_PAGE_URL", "PROPERTY_BREND")
                                );

                                $tmps = array();
                                while($ob = $res->GetNext())
                                {
                                    if(!in_array($ob["PROPERTY_BREND_VALUE"],$tmps)){
                                        $tmps[] = $ob["PROPERTY_BREND_VALUE"];
                                    }
                                }
                                ?>
                                <!-- -->
                                <!-- Redable properties compares makeHLpropList()-->
                                <?if($len ==0){?>
                                <ul class="brands">
                                <? $jj = 0; foreach($tmps as $tmps_val): ?>
                                    <? $jj++; if ($jj == 1): ?>
                                        <div class="brand_title">Бренды</div>
                                    <? endif; ?>
                                    <li><a href="<?=$arResult["ALL_ITEMS"][$itemID]["LINK"].$tmps_val?>"><?=$resId[$tmps_val];?></a></li>
                                <? endforeach;?>
                                </ul>
                                <? }?>



                                </ul>
                            </div>
                        </li>
                    <?endforeach;?>
                    <!--    -->

                <div style="clear: both;"></div>

            <!---->
        </div>
