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
<? $arParams["DISPLAY_PICTURE"] = "Y";
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/templates/stmall/shareVK.php');
?>

<h1 class="fitness-h1">Фитнес-блог для новичков и профи</h1>

<div class="col-xs-12">
  <?$APPLICATION->IncludeComponent(
      "bitrix:search.form",
      "",
      Array(
          "PAGE" => "#SITE_DIR#serfing/index.php",
          "USE_SUGGEST" => "N"
      ),
      false
  );?>
</div>

<div class="col-xs-12 rubricks">Выберите рубрику
    <?
    if(!CModule::IncludeModule("iblock"))
        return;


    $arFilter = array(
        "IBLOCK_ID" => 3
    );

    $arSort = array(
        "ID" => "DESC"
    );
    $rsSections = CIBlockSection::GetList($arSort, $arFilter); //Получили список разделов из инфоблока
    $rsSections->SetUrlTemplates(); //Получили строку URL для каждого из разделов (по формату из настроек инфоблока)
    while($arSection = $rsSections->GetNext())
    {
        ?>
        <a href="<?=$arSection['SECTION_PAGE_URL']?>">
        <div class="input-group">
             <input type="checkbox">
             <?=$arSection['SEARCHABLE_CONTENT']?>
            </div></a>
        <?
    }

    ?>
</div>

<div class="news-sorted col-xs-12">Отсортируйте статьи
    <ul>
      <li><a href="/news/?&sortdate=DESC">Свежие</a></li>
      <li><a href="/news/">Активно обсуждают</a></li>
      <li><a href="/news/">Репостят</a></li>
      <li><a href="/news/">Не сортировать</a></li>
    </ul>
</div>
<div class="news-finded col-xs-12">Нашлось <?=count($arResult['ITEMS'])?> материала</div>



  <div class="col-xs-12">
    <?foreach($arResult["ITEMS"] as $arItem):?>
    <div class="col-xs-12 rec-item">
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
  
    <div class="clearfix"> </div>
    <div style="clear:both;">
        <? //ПОЛУЧАЕМ И ВЫВОДИМ КОЛИЧЕСТВО ПРОСМОТРОВ
        $db_props = CIBlockElement::GetProperty(3, $arItem['ID'], array(), array("CODE"=>"COUNTER"));
        $ar_props = $db_props->Fetch();
        !empty($ar_props['VALUE'])? $count = $ar_props['VALUE']: $count = 0;
        echo "Количество просмотров ".$count;
        if(empty($arItem['FMSG_COUNT'])) $arItem['FMSG_COUNT'] = 0;
        echo "<br>Количество сообщений ".$arItem['FMSG_COUNT'];
        $countShare = getShareCount($arItem['ID'],$arItem["DETAIL_PAGE_URL"]);
        echo "<br>Количество репостов ".$countShare;
        ?>
    </div>
    <?endforeach;?>

  </div>
