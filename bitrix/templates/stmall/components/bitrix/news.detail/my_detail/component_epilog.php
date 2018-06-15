<?
$APPLICATION->SetPageProperty("title", $arResult['NAME']);
//Соц. сети
$page = $APPLICATION->GetCurPage();
//CModule::IncludeModule("iblock");
// $res = CIBlockElement::GetList(
//  array(),
//  array("IBLOCK_ID" => "3","ID" => $arResult['ID'])
// );
//vardump($res->Fetch());
// while($ob = $res->Fetch()){
//   vardump($ob);
// }
$APPLICATION->AddHeadString('<meta property="og:title" content="'.$arResult['NAME'].'"/>');
$APPLICATION->AddHeadString('<meta property="og:description" content=""/>');
$APPLICATION->AddHeadString('<meta property="og:image" content=""/>');
$APPLICATION->AddHeadString('<meta property="og:url" content="https://st-mall.ru'.$page.'"/>');
$APPLICATION->AddHeadString('<meta property="og:type" content="website"/>');


// $uri = $APPLICATION->GetCurUri();
// $uri = explode("?",$uri);
// $vkUrl = "https://vk.com/share.php?act=count&index=1&url=https://st-mall.ru".$uri[0];
// $resultVK = file_get_contents($vkUrl);
// $resultVK = str_replace("VK.Share.count(","",$resultVK);
// $resultVK = str_replace("1, ","",$resultVK);
// $resultVK = str_replace(");","",$resultVK);
// $arResult['REPOST_COUNT'] = $resultVK;
//
// CIBlockElement::SetPropertyValuesEx(
//   $arResult['ID'],
//   "3",
//   array("REPOST_COUNT" => $resultVK)
// );

?>
