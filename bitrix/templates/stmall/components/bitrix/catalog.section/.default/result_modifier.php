<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogSectionComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();

$arSection = CIblockSection::GetById($arResult["ID"])->GetNext();
$arResult['SECTION_PAGE_URL'] = $arSection['SECTION_PAGE_URL'];
$cp = $this->__component; 
if (is_object($cp))
$cp->SetResultCacheKeys(array('SECTION_PAGE_URL'));