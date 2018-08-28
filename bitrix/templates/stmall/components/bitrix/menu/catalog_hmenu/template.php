<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (empty($arResult["ALL_ITEMS"]))
	return;

if (file_exists($_SERVER["DOCUMENT_ROOT"].$this->GetFolder().'/themes/'.$arParams["MENU_THEME"].'/colors.css'))
	$APPLICATION->SetAdditionalCSS($this->GetFolder().'/themes/'.$arParams["MENU_THEME"].'/colors.css');

CJSCore::Init();

$menuBlockId = "categories_menu";
?>

                <!--Меню-->

                <ul>
                    <li>
                        <span>
                        <a href="/">Главная</a>
                        </span>
                    </li>
                    <li>
                        <span>
                        <a href="https://st-mall.ru/catalog/begovye-dorozhki/">Беговые дорожки</a>
                        </span>
                    </li>
                    <li>
                        <span>
                        <a href="https://st-mall.ru/catalog/velotrenazhery/">Велотренажеры</a>
                        </span>
                    </li>
                    <li>
                        <span>
                        <a href="/catalog/professionalnye-silovye-trenazhery/">Тренажеры для фитнес клуба</a>
                        </span>
                    </li>
                    <li>
                        <span>
                        <a href="/catalog/silovye-trenazhery/">Силовые тренажеры</a>
                        </span>
                    </li>
                </ul>


                <!-- <?//foreach($arResult["MENU_STRUCTURE"] as $itemID => $arColumns):?> 
                    <? //if($itemID == 2072786578  || $itemID == 1129070302 || $itemID == 1462823261 || $itemID == 746775971 || $itemID == 3704184893 || $itemID == 2510153524 || $itemID == 388746853){}else{continue;} ?>
                <?// if($itemID == 1462823261 || $itemID == 746775971 || $itemID == 3704184893 || $itemID == 835458614 || $itemID == 388746853){}else{continue;} ?>
                        <li>
                            <a class="link-cat" href="<?//=$arResult["ALL_ITEMS"][$itemID]["LINK"]?>" <?//if (is_array($arColumns) && count($arColumns) > 0 && $existPictureDescColomn):?>onmouseover="BX.CatalogVertMenu.changeSectionPicture(this);"<?//endif?>>
                                <?//=$arResult["ALL_ITEMS"][$itemID]["TEXT"]?>
                            </a>
                        </li>-->
                <?//endforeach;?>

                    <!---->