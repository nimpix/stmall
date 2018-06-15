<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<? $arParams["DISPLAY_PICTURE"] = "Y";?>



<div class="recomendations">
    <?foreach($arResult["ITEMS"] as $arItem):?>
    <div class="rec-item">
        <a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img
                    class="preview_picture"
                    border="0"
                    src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"
                    width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>"
                    height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>"
                    alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
                    title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
                    style="float:left"
            /></a>
        <div id="rec-block-1">
            <?echo $arItem["DISPLAY_ACTIVE_FROM"]?> <button> <?
                $res = CIBlockSection::GetByID($arItem['IBLOCK_SECTION_ID']);
                if($ar_res = $res->GetNext())
                    echo $ar_res['NAME'];
                ?></button>
        </div>
        <div id="rec-block-2">
            <a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?echo $arItem["NAME"]?></a>
        </div>
    </div>
    <?endforeach;?>
    <?foreach($arItem["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>
        <small>
            <?=$arProperty["NAME"]?>:&nbsp;
            <?if(is_array($arProperty["DISPLAY_VALUE"])):?>
                <?=implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);?>
            <?else:?>
                <?=$arProperty["DISPLAY_VALUE"];?>
            <?endif?>
        </small><br />
    <?endforeach;?>
</div>