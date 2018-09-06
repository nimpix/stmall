<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
 
global $APPLICATION;
 
$aMenuLinksExt = $APPLICATION->IncludeComponent(
	"bitrix:menu.sections", 
	"", 
	array(
		"IS_SEF" => "Y",
		"ID" => $_REQUEST["ID"],
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "1",
		"SECTION_URL" => "",
		"DEPTH_LEVEL" => "3",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"SEF_BASE_URL" => "/catalog/",
		"SECTION_PAGE_URL" => "#SECTION_CODE_PATH#/",
		"DETAIL_PAGE_URL" => "#SECTION_CODE_PATH#/#ELEMENT_CODE#/"
	),
	false
);
 $aMenuLinks = array_merge($aMenuLinksExt, $aMenuLinks);
?>