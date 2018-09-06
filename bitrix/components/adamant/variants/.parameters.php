<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;
use Bitrix\Iblock;

Loader::includeModule('iblock');

$arSectionList = array();

$rsSections = CIBlockSection::GetList(array(),array('IBLOCK_ID' => 1, 'DEPTH_LEVEL' => '1', 'ACTIVE' => 'Y'));
   while ($arSect = $rsSections->Fetch())
   {
     $arSectionList[$arSect['ID']] = $arSect['NAME'];
   }

$arComponentParameters = array(
    "GROUPS" => array(
        "BASE" => array(
            "NAME" => GetMessage("Основные настройки секций")
        )
    ),
    "PARAMETERS" => array(
        "TEMPLATE_SECTION" => array(
            "PARENT" => "BASE",
            "NAME" => "Список секций",
            "TYPE" => "LIST",
            "MULTIPLE" => "Y",
            "VALUES" => $arSectionList,
        ),
        "TEMPLATE_URL" => array(
            "PARENT" => "BASE",
            "NAME" => "Ссылка на детальную страницу",
            "TYPE" => "STRING",
            "MULTIPLE" => "N"
        ),
        "TEMPLATE_URL_MAIN" => array(
            "PARENT" => "BASE",
            "NAME" => "Ссылка на основную картинку",
            "TYPE" => "STRING",
            "MULTIPLE" => "N"
        ),
        "TEMPLATE_TITLE" => array(
            "PARENT" => "BASE",
            "NAME" => "Название раздела",
            "TYPE" => "STRING",
            "MULTIPLE" => "N"
        ),
        "TEMPLATE_BTN_NAME" => array(
            "PARENT" => "BASE",
            "NAME" => "Надпись для перехода",
            "TYPE" => "STRING",
            "MULTIPLE" => "N"
        ),
        "TEMPLATE_ALIGN" => array(
            "PARENT" => "BASE",
            "NAME" => "Выравнивание основного блока",
            "TYPE" => "LIST",
            "MULTIPLE" => "N",
            "VALUES" => ["" => "Слева", "right-trainer" =>"Справа"],
        )
    ),
);
?>