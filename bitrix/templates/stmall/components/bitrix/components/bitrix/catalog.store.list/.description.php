<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("CP_CATALOG_STORE_CSL_NAME"),
	"DESCRIPTION" => GetMessage("CP_CATALOG_STORE_CSL_DESCRIPTION"),
	"ICON" => "/images/store_list.gif",
	"CACHE_PATH" => "Y",
	"SORT" => 20,
	"PATH" => array(
		"ID" => "e-store",
		"NAME" => GetMessage('CP_CATALOG_STORE_MAIN_SECTION'),
		"CHILD" => array(
			"ID" => "catalog-store",
			"NAME" => GetMessage("CP_CATALOG_STORE_STORE_SECTION"),
			"SORT" => 500,
		)
	)
);
?>