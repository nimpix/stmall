<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @global CMain $APPLICATION */
if (isset($arParams["USE_FILTER"]) && $arParams["USE_FILTER"]=="Y")
{
	$arParams["FILTER_NAME"] = trim($arParams["FILTER_NAME"]);
	if ($arParams["FILTER_NAME"] === '' || !preg_match("/^[A-Za-z_][A-Za-z01-9_]*$/", $arParams["FILTER_NAME"]))
		$arParams["FILTER_NAME"] = "arrFilter";
}
else
	$arParams["FILTER_NAME"] = "";
/////////////////////////////////////////////////////
// Фикс фильтра
// if (CModule::IncludeModule("iblock")){


$propertyList = array();



//split url to params and get their ID's and values

/////////////////////////////////////////////////////

//default gifts
if(empty($arParams['USE_GIFTS_SECTION']))
{
	$arParams['USE_GIFTS_SECTION'] = 'Y';
}
if(empty($arParams['GIFTS_SECTION_LIST_PAGE_ELEMENT_COUNT']))
{
	$arParams['GIFTS_SECTION_LIST_PAGE_ELEMENT_COUNT'] = 3;
}
if(empty($arParams['GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT']))
{
	$arParams['GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT'] = 4;
}
if(empty($arParams['GIFTS_DETAIL_PAGE_ELEMENT_COUNT']))
{
	$arParams['GIFTS_DETAIL_PAGE_ELEMENT_COUNT'] = 4;
}

$arParams['ACTION_VARIABLE'] = (isset($arParams['ACTION_VARIABLE']) ? trim($arParams['ACTION_VARIABLE']) : 'action');
if ($arParams["ACTION_VARIABLE"] == '' || !preg_match("/^[A-Za-z_][A-Za-z01-9_]*$/", $arParams["ACTION_VARIABLE"]))
	$arParams["ACTION_VARIABLE"] = "action";

$smartBase = ($arParams["SEF_URL_TEMPLATES"]["section"]? $arParams["SEF_URL_TEMPLATES"]["section"]: "#SECTION_ID#/");
$arDefaultUrlTemplates404 = array(
	"sections" => "",
	"section" => "#SECTION_ID#/",
	"element" => "#SECTION_ID#/#ELEMENT_ID#/",
	"compare" => "compare.php?action=COMPARE",
	"smart_filter" => $smartBase."filter/#SMART_FILTER_PATH#/apply/"
);

$arDefaultVariableAliases404 = array();

$arDefaultVariableAliases = array();

$arComponentVariables = array(
	"SECTION_ID",
	"SECTION_CODE",
	"ELEMENT_ID",
	"ELEMENT_CODE",
	"action",
);

if($arParams["SEF_MODE"] == "Y")
{
	$arVariables = array();

	$engine = new CComponentEngine($this);
	if (\Bitrix\Main\Loader::includeModule('iblock'))
	{
		$engine->addGreedyPart("#SECTION_CODE_PATH#");
		$engine->addGreedyPart("#SMART_FILTER_PATH#");
		$engine->setResolveCallback(array("CIBlockFindTools", "resolveComponentEngine"));
	}
	$arUrlTemplates = CComponentEngine::makeComponentUrlTemplates($arDefaultUrlTemplates404, $arParams["SEF_URL_TEMPLATES"]);
	$arVariableAliases = CComponentEngine::makeComponentVariableAliases($arDefaultVariableAliases404, $arParams["VARIABLE_ALIASES"]);
	
	$componentPage = $engine->guessComponentPath(
		$arParams["SEF_FOLDER"],
		$arUrlTemplates,
		$arVariables
	);
///////////////////////

	//get all iblock properties
	//return array of properties, containing ID, CODE and PROPERTY_TYPE
function getIBpropList($IBLOCK_ID = 1){
		$arrRes = array();
		$aTMP = array();
		$properties = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=> 1));
		while ($prop_fields = $properties->GetNext())
		{
			$aTMP['ID'] = $prop_fields['ID'];
			$aTMP['CODE'] = $prop_fields['CODE'];
			$aTMP['PROPERTY_TYPE'] = $prop_fields['PROPERTY_TYPE']; //L - list, F - photo, S -HL block, N - natural value
			$aTMP['TABLE_NAME'] = $prop_fields['USER_TYPE_SETTINGS']['TABLE_NAME'];
			$arrRes[] = $aTMP;
		}
		return $arrRes;
	}


	//get all properties values of property type L - list
	//return array, containing all property's XML_ID values
	function makePropList($L_ID){
		$arrRes = array();
		$UserField = CIBlockPropertyEnum::GetList(array(), array("PROPERTY_ID" => $L_ID));
		while ($UserFieldAr = $UserField->GetNext())
		{
		  $arrRes[] = $UserFieldAr['XML_ID'];
		}
		return $arrRes;
	}

	//get all properties values of property type S - HL Iblock
	//return array, containing all property's XML_ID values
	function makemineHLpropList($HLb_table){
		$arrRes = array();

		if (CModule::IncludeModule('highloadblock')){

			$hlblock = \Bitrix\Highloadblock\HighloadBlockTable::getList(array("filter" => array('TABLE_NAME' => $HLb_table)))->fetch();
			$entity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
			$entityClass = $entity->getDataClass();

			$resx = $entityClass::getList(array('select' => array('ID','UF_NAME', 'UF_XML_ID'), 'filter' => array()));

			while ($erow = $resx->fetch())
			  $arrRes[] = $erow['UF_XML_ID'];
		}
		return $arrRes;
	}


	//get all properties values of IBLOCK into array
	//return array, of props CODEs, each of it contain all property's XML_ID values
	function makePropValArray($IBLOCK_ID = 1){
		$arrRes = array();
		$prop_list = array();
		$prop_val = array();

		//get all props of IBLOCK
		$prop_list = getIBpropList($IBLOCK_ID);


		//making result array of both list and HL properties
		foreach ($prop_list as $id => $prop){

			if ($prop['PROPERTY_TYPE'] == 'L'){
				$arrRes[$prop['ID']] = makePropList($prop['ID']);
			}

			if (($prop['PROPERTY_TYPE'] == 'S') && ($prop['TABLE_NAME'] != '')) {
				$arrRes[$prop['ID']] = makemineHLpropList($prop['TABLE_NAME']);
			}
		}
        $propertyList = $arrRes;
		return $arrRes;
	}

function searchForProperty($lookupValue)
{
	//if we have empty property values array - fill it from our IBLOCK

	$propertyList = makePropValArray(1);
	
	$result = false;
	//search for property ID by one of his values
	foreach($propertyList as $pID => $pValue)
	{
		if (in_array($lookupValue, $pValue)){
			$result = true;
		}
	}

	return $result;

}

/////////////////////////////////////////////////////
function getFilterPath($url)
{
	$parts = explode('/',$url);
	$newparts = array_slice($parts,3);
	array_pop($newparts);


	foreach ($newparts as $smartPart)
	{		
	  	$smartPart = preg_split("/-(ot|do|is|ili)-/", $smartPart, -1, PREG_SPLIT_DELIM_CAPTURE);

			foreach ($smartPart as $smartElement)
			{
			
				if (preg_match("/^po_cene(.+)$/", $smartElement, $match))
					$result = true;
				elseif (in_array('ot', $smartPart) || in_array('do', $smartPart) || in_array('ili', $smartPart) ){
					$result = true;
					}
				elseif(searchForProperty($smartElement)){
					$result = true;
				}else{
					$result = false;
					break;
				}

			}
		
		}
		
		return $result;
}


	if ($componentPage === "smart_filter")
		$componentPage = "section";

	$filt_array = getFilterPath($_SERVER['REQUEST_URI']);


	if($filt_array){
		$componentPage = "section";
	}
/////////////////////////////////////////////////////////
	if(!$componentPage && isset($_REQUEST["q"]))
		$componentPage = "search";

	$b404 = false;
	if(!$componentPage)
	{
		$componentPage = "sections";
		$b404 = true;
	}

	if($componentPage == "section")
	{
		if (isset($arVariables["SECTION_ID"]))
			$b404 |= (intval($arVariables["SECTION_ID"])."" !== $arVariables["SECTION_ID"]);
		else
			$b404 |= !isset($arVariables["SECTION_CODE"]);
	}

	if($b404 && CModule::IncludeModule('iblock'))
	{
		$folder404 = str_replace("\\", "/", $arParams["SEF_FOLDER"]);
		if ($folder404 != "/")
			$folder404 = "/".trim($folder404, "/ \t\n\r\0\x0B")."/";
		if (substr($folder404, -1) == "/")
			$folder404 .= "index.php";

		if ($folder404 != $APPLICATION->GetCurPage(true))
		{
			\Bitrix\Iblock\Component\Tools::process404(
				""
				,($arParams["SET_STATUS_404"] === "Y")
				,($arParams["SET_STATUS_404"] === "Y")
				,($arParams["SHOW_404"] === "Y")
				,$arParams["FILE_404"]
			);
		}
	}
	//if(convertUrlToCheckMine($_SERVER["REQUEST_URI"])) {$componentPage = "section"; $arVariables['ELEMENT_CODE'] = "";}

	CComponentEngine::initComponentVariables($componentPage, $arComponentVariables, $arVariableAliases, $arVariables);
	$arResult = array(
		"FOLDER" => $arParams["SEF_FOLDER"],
		"URL_TEMPLATES" => $arUrlTemplates,
		"VARIABLES" => $arVariables,
		"ALIASES" => $arVariableAliases
	);
//$_SESSION["eldi"] = $arVariables;
}
else
{
	$arVariables = array();

	$arVariableAliases = CComponentEngine::makeComponentVariableAliases($arDefaultVariableAliases, $arParams["VARIABLE_ALIASES"]);
	CComponentEngine::initComponentVariables(false, $arComponentVariables, $arVariableAliases, $arVariables);

	$componentPage = "";

	$arCompareCommands = array(
		"COMPARE",
		"DELETE_FEATURE",
		"ADD_FEATURE",
		"DELETE_FROM_COMPARE_RESULT",
		"ADD_TO_COMPARE_RESULT",
		"COMPARE_BUY",
		"COMPARE_ADD2BASKET"
	);




	if(isset($arVariables["action"]) && in_array($arVariables["action"], $arCompareCommands))
		$componentPage = "compare";
	elseif(isset($arVariables["ELEMENT_ID"]) && intval($arVariables["ELEMENT_ID"]) > 0)
		$componentPage = "element";
	elseif(isset($arVariables["ELEMENT_CODE"]) && strlen($arVariables["ELEMENT_CODE"]) > 0)
		$componentPage = "element";
	elseif(isset($arVariables["SECTION_ID"]) && intval($arVariables["SECTION_ID"]) > 0)
		$componentPage = "section";
	elseif(isset($arVariables["SECTION_CODE"]) && strlen($arVariables["SECTION_CODE"]) > 0)
		$componentPage = "section";
	elseif(isset($_REQUEST["q"]))
	$componentPage = "search";
	else
	$componentPage = "sections";

	// Вывести все товары на странице каталога
	// if ($componentPage == 'sections') {
	//     $componentPage = 'section';
	// }

	// if($_SERVER["REQUEST_URI"] == '/catalog/'){
	// 	 $componentPage = 'section';
	//    $_SESSION['comPage1'] = $componentPage;
	// }

	$currentPage = htmlspecialcharsbx($APPLICATION->GetCurPage())."?";
	$arResult = array(
		"FOLDER" => "",
		"URL_TEMPLATES" => array(
			"section" => $currentPage.$arVariableAliases["SECTION_ID"]."=#SECTION_ID#",
			"element" => $currentPage.$arVariableAliases["SECTION_ID"]."=#SECTION_ID#"."&".$arVariableAliases["ELEMENT_ID"]."=#ELEMENT_ID#",
			"compare" => $currentPage."action=COMPARE",
		),
		"VARIABLES" => $arVariables,
		"ALIASES" => $arVariableAliases
	);

}


//if(!convertUrlToCheckMine($_SERVER["REQUEST_URI"])) $componentPage = "section";



$this->IncludeComponentTemplate($componentPage);
