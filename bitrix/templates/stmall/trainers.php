<?
//$section = array(1, 8, 4);
function print_sections($iblock_id = 1, $sections = array()){

    $arFilter = array(
        'IBLOCK_ID' => $iblock_id,
        'ID' => $sections //�������� ID ��������
    );

    $custom_sections = array();
    $custom_section = array();
    $rsSect = CIBlockSection::GetList(array('left_margin' => 'asc'),$arFilter);

    while ($arSect = $rsSect->GetNext())
    {
        $custom_section['NAME'] = $arSect['NAME'];
        $custom_section['ID'] = $arSect['ID'];
        $custom_section['URL'] = $arSect['LIST_PAGE_URL'].$arSect['SECTION_PAGE_URL']."/";
        $custom_section['PICTURE'] = $arSect['PICTURE'];

        $custom_sections[] = $custom_section;
        $tmp = $arSect;
    }

    $cnt =2; //Цвета кнопок
    foreach ($custom_sections as $cs){
        ?>

        <div class="tr-item">
            <div class="img_wrapper">
                <a href="<?=$cs['URL']?>">
                    <?
                    $arFile = CFile::GetFileArray($cs['PICTURE']);
                    if($arFile){
                        $pic_subdir = $arFile["SUBDIR"]; //���������� ����� ��������
                        $pic_filename = $arFile["FILE_NAME"]; //��� �������� � �����������
                        ?>
                        <img src="/upload/<?=$pic_subdir?>/<?=$pic_filename?>"/>
                        <?
                    }
                    ?>
                </a>
            </div>
            <div class="tr-button-<? print $cnt; $cnt++;?>">
                <a href="<?=$cs['URL']?>"><?=$cs['NAME']?></a>
            </div>
        </div>


        <?

    }
}
function getProducts($section){
$tmps = array();
$res = CIBlockElement::GetList(
    array(),
    array("IBLOCK_ID" => 1, "SECTION_ID" => $section, "INCLUDE_SUBSECTIONS" => "Y"),
    false,
    false,
    array("ID", "IBLOCK_ID", "LANG_DIR","PROPERTY_KONSOL","PROPERTY_TIP","PROPERTY_KOLICHESTVO_UROVNEJ_NAGRUZKI","DETAIL_PAGE_URL","CATALOG_GROUP_1", "PROPERTY_MAKSIMALNAYA_SKOROST","PROPERTY_DLINA_POLOTNA","PROPERTY_SHIRINA_POLOTNA","PROPERTY_MOSHCHNOST_DVIGATELYA","PROPERTY_MAKSIMALNYJ_VES_POLZOVATELYA","PREVIEW_PICTURE","NAME")
);

while($ob = $res->GetNext())
{   //Вытаскиваем путь до картинки через ID
    $arFile = CFile::GetFileArray($ob["PREVIEW_PICTURE"]);
    if($arFile){
        $ob["PREVIEW_PICTURE"] = $arFile["SRC"];
    }

    $tmps[] = $ob;
}




//    $tmps["PRICE"] = FormatCurrency($ob["PROPERTY_PRICE_VALUE"], 'RUB'); Форматирование цены

return $tmps;
}
?>

<?
function getSales(){
    $tmps = array();
    $res = CIBlockElement::GetList(
        array(),
        array("IBLOCK_ID" => 1, "INCLUDE_SUBSECTIONS" => "Y"),
        false,
        false,
        array("ID", "IBLOCK_ID", "LANG_DIR","PROPERTY_SISTEMA_NAGRUZKI","PROPERTY_IZMERENIE_PULSA","PROPERTY_KLASS_OBORUDOVANIYA","PROPERTY_OLD_PRICE","PROPERTY_SKIKDA_CHECK","PROPERTY_KONSOL","PROPERTY_TIP","PROPERTY_KOLICHESTVO_UROVNEJ_NAGRUZKI","DETAIL_PAGE_URL","CATALOG_GROUP_1", "PROPERTY_MAKSIMALNAYA_SKOROST","PROPERTY_DLINA_POLOTNA","PROPERTY_SHIRINA_POLOTNA","PROPERTY_MOSHCHNOST_DVIGATELYA","PROPERTY_MAKSIMALNYJ_VES_POLZOVATELYA","PREVIEW_PICTURE","NAME")
    );

    while($ob = $res->GetNext())
    {   //Вытаскиваем путь до картинки через ID

        $arFile = CFile::GetFileArray($ob["PREVIEW_PICTURE"]);
        if($arFile){
            $ob["PREVIEW_PICTURE"] = $arFile["SRC"];
        }
        if($ob['PROPERTY_SKIKDA_CHECK_VALUE'] == 'Да') {
            $tmps[] = $ob;
        }else{continue;}
    }


//    $tmps["PRICE"] = FormatCurrency($ob["PROPERTY_PRICE_VALUE"], 'RUB'); Форматирование цены

    return $tmps;
}

function getCategories($iblock_id = 1,$sections){

    $arFilter = array(
        'IBLOCK_ID' => $iblock_id,
        'ID' => $sections,
        'DEPTH_LEVEL' => 1
    );

    $custom_sections = array();
    $custom_section = array();
    $rsSect = CIBlockSection::GetList(array('left_margin' => 'asc'),$arFilter);

    while ($arSect = $rsSect->GetNext())
    {
        $custom_section['NAME'] = $arSect['NAME'];
        $custom_section['ID'] = $arSect['ID'];
        $custom_section['URL'] = $arSect['LIST_PAGE_URL'].$arSect['SECTION_PAGE_URL']."/";
        $custom_section['PICTURE'] = $arSect['PICTURE'];

        $custom_sections[] = $custom_section;
        $tmp = $arSect;
    }

    $count =0;
    foreach ($custom_sections as $cs){
        if($cs['NAME'] == '000IMPORT') continue;
        ?>

        <div class="col-6 d-flex justify-content-center align-items-center">
            <div class="name-mcat"><?=$cs['NAME']?></div>
                <a href="<?=$cs['URL']?>">
                    <?
                    $arFile = CFile::GetFileArray($cs['PICTURE']);
                    if($arFile){
                        $pic_subdir = $arFile["SUBDIR"]; //���������� ����� ��������
                        $pic_filename = $arFile["FILE_NAME"]; //��� �������� � �����������
                        ?>
                        <div class="fader"></div>
                        <img src="/upload/<?=$pic_subdir?>/<?=$pic_filename?>"/>
                        <?
                    }
                    ?>
                </a>
        </div>


        <? $count++; if($count == 12) break;

    }
}

?>
