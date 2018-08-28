<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/**
 * @global CMain $APPLICATION
 */

global $APPLICATION;

//delayed function must return a string
if(empty($arResult))
	return "";

$strReturn = '';

//we can't use $APPLICATION->SetAdditionalCSS() here because we are inside the buffered function GetNavChain()
$css = $APPLICATION->GetCSSArray();
if(!is_array($css) || !in_array("/bitrix/css/main/font-awesome.css", $css))
{
	$strReturn .= '<link href="'.CUtil::GetAdditionalFileURL("/bitrix/css/main/font-awesome.css").'" type="text/css" rel="stylesheet" />'."\n";
}
$page = $APPLICATION->GetCurPage();
$flag = strpos($page,'catalog');
$bc = ($flag) ? 'bx-breadcrumb-prod' : '' ;
$strReturn .= '<div class="bx-breadcrumb '.$bc.'" style="margin:28px 0 !important;">';

$itemSize = count($arResult);
$server_address = $_SERVER['REQUEST_URI'];
$pos = strpos($server_address,'catalog');
$strReturn .= '<div class="bx-breadcrumb-item return-link"><span>Вернуться на страницу : </span></div>';
if($pos == 1) {$pr_cat = 'catalog-item';}else{ $pr_cat = '';}
$cnt_br = 0;
for($index = 0; $index < $itemSize; $index++)
{
	$title = htmlspecialcharsex($arResult[$index]["TITLE"]);
	if($pos == 1 && $cnt_br == 1) $title = "Все товары";
	$cnt_br++;
	$nextRef = ($index < $itemSize-2 && $arResult[$index+1]["LINK"] <> ""? ' itemref="bx_breadcrumb_'.($index+1).'"' : '');
	$child = ($index > 0? ' itemprop="child"' : '');



	if($arResult[$index]["LINK"] <> "" && $index != $itemSize-1)
	{
		$strReturn .= '
			<div class="'.$pr_cat.' bx-breadcrumb-item" id="bx_breadcrumb_'.$index.'" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"'.$child.$nextRef.'>
				'.$arrow.'
				<a href="'.$arResult[$index]["LINK"].'" title="'.$title.'" itemprop="url">
					<span itemprop="title">'.$title.'</span>
				</a>
			</div>';
	}
	else
	{
		$strReturn .= '
			<div class="bx-breadcrumb-item bx-breadcrumb-item-last">
				<a href="'.$arResult[$index]["LINK"].'" title="'.$title.'" itemprop="url">
					<span style="color:var(--salat);margin-top:1px;display:block;text-decoration:none;" itemprop="title">'.$title.'</span>
				</a>	
			</div>';//'.$title.'
	}
}

$strReturn .= '<div style="clear:both"></div></div>';

return $strReturn;
?>