<?

//$res = CIBlockElement::GetList(
//array(),
//array("IBLOCK_ID" => 1, "SECTION_ID" => 1, "INCLUDE_SUBSECTIONS" => "Y"),
//false,
//false,
//array("ID", "IBLOCK_ID", "LANG_DIR", "DETAIL_PAGE_URL", "PROPERTY_BREND")
//);
//
//$tmps = array();
//while($ob = $res->GetNext())
//{
//    if(!in_array($ob["PROPERTY_BREND_VALUE"],$tmps)){
//    $tmps[] = $ob["PROPERTY_BREND_VALUE"];
//    }
//}

//get all properties values of property type S - HL Iblock
//return array, containing all property's XML_ID values
function makeHLpropList($HLb_table = 'b_hlbd_book1'){
    $arrRes = array();

if (CModule::IncludeModule('highloadblock')){

    $hlblock = \Bitrix\Highloadblock\HighloadBlockTable::getList(array("filter" => array('TABLE_NAME' => $HLb_table)))->fetch();
    $entity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
    $entityClass = $entity->getDataClass();

    $resx = $entityClass::getList(array('select' => array('ID','UF_NAME', 'UF_XML_ID'), 'filter' => array()));

while ($erow = $resx->fetch())
    $arrRes[$erow['UF_XML_ID']] = $erow['UF_NAME'];
}
    return $arrRes;
}

 //return section ID by its URL path
function getSectionIDbyCODE($catPath = '',$IBLOCK_ID = 1 ){
    $larr = array();
    $larr = explode('/', $catPath);
    $cnt = count($larr);
    $rlink = '';
    if ($cnt > 2)
        $rlink = $larr[$cnt - 2];

    $res = CIBlockSection::GetList(array(), array('IBLOCK_ID' => $IBLOCK_ID, 'CODE' => $rlink, 'SITE_ID' => "s1"));
    $rsection = $res->Fetch();

    return $rsection["ID"];
} 

?>