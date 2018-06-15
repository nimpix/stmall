<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (empty($arResult["ALL_ITEMS"]))
	return;

if (file_exists($_SERVER["DOCUMENT_ROOT"].$this->GetFolder().'/themes/'.$arParams["MENU_THEME"].'/colors.css'))
	$APPLICATION->SetAdditionalCSS($this->GetFolder().'/themes/'.$arParams["MENU_THEME"].'/colors.css');

CJSCore::Init();

$menuBlockId = "categories_menu";
?>

<!--<div style="display: block;">-->
<!--    --><?// print "<pre>";?>
<!--	--><?// print_r ($arResult["ALL_ITEMS"]); ?>
<!--    --><?// print "</pre>";?>
<!--</div>-->
<!--Меню-->

            <ul>
                <li><span><a href="/">Главная</span></a></li>
                <?foreach($arResult["MENU_STRUCTURE"] as $itemID => $arColumns):?>
                    <? if($itemID == 1462823261 || $itemID == 746775971 || $itemID == 3704184893 || $itemID == 2510153524 || $itemID == 388746853){}else{continue;} ?>
<!--                    --><?// if($itemID == 1462823261 || $itemID == 746775971 || $itemID == 3704184893 || $itemID == 835458614 || $itemID == 388746853){}else{continue;} ?>
                        <li>
                            <a class="link-cat" href="<?=$arResult["ALL_ITEMS"][$itemID]["LINK"]?>" <?if (is_array($arColumns) && count($arColumns) > 0 && $existPictureDescColomn):?>onmouseover="BX.CatalogVertMenu.changeSectionPicture(this);"<?endif?>>
                                <?=$arResult["ALL_ITEMS"][$itemID]["TEXT"]?>
                            </a>
                        </li>
                    <?endforeach;?>
            </ul>


            <!---->


