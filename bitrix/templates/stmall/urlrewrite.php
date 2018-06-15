<?
$arUrlRewrite = array(
	array(
		"CONDITION" => "#^/bitrix/services/ymarket/#",
		"RULE" => "",
		"ID" => "",
		"PATH" => "/bitrix/services/ymarket/index.php",
	),
	array(
		"CONDITION" => "#^/mytestpersonal/order/#",
		"RULE" => "",
		"ID" => "bitrix:sale.personal.order",
		"PATH" => "/mytestpersonal/order/index.php",
	),
	array(
		"CONDITION" => "#^/mytestpersonal/#",
		"RULE" => "",
		"ID" => "bitrix:sale.personal.section",
		"PATH" => "/mytestpersonal/index.php",
	),
	array(
		"CONDITION" => "#^/mytestcatalog/#",
		"RULE" => "",
		"ID" => "bitrix:catalog",
		"PATH" => "/mytestcatalog/index.php",
	),
	array(
		"CONDITION" => "#^/myteststore/#",
		"RULE" => "",
		"ID" => "bitrix:catalog.store",
		"PATH" => "/myteststore/index.php",
	),
	array(
		"CONDITION" => "#^/mytestnews/#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => "/mytestnews/index.php",
	),
	array(
		"CONDITION" => "#^/catalog/#",
		"RULE" => "",
		"ID" => "adamant:catalog",
		"PATH" => "/catalog/index.php",
	),
	array(
		"CONDITION" => "#^/forum/#",
		"RULE" => "",
		"ID" => "bitrix:forum",
		"PATH" => "/forum/index.php",
	),
	array(
		"CONDITION" => "#^/news/#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => "/news/index.php",
	),
	array(
		"CONDITION" => "#^#",
		"RULE" => "",
		"ID" => "bitrix:form",
		"PATH" => "/bitrix/templates/stmall/header.php",
	),
	array(
		"CONDITION" => "#^#",
		"RULE" => "",
		"ID" => "bitrix:form",
		"PATH" => "/bitrix/templates/stmall/components/bitrix/catalog.element/product/template.php",
	),
);

?>