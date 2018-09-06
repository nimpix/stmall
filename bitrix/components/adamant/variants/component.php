<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();


   $arResult['section_ids'] = $arParams['TEMPLATE_SECTION'];

   $arFilter = array(
    'IBLOCK_ID' => 1,
    'ID' => $arResult['section_ids'] //�������� ID ��������
   );

    $custom_sections = array();
    $custom_section = array();

   if ($this->startResultCache())
   {    
        $rsSect = CIBlockSection::GetList(array('left_margin' => 'asc'),$arFilter);

        while ($arSect = $rsSect->GetNext())
        {
            $custom_section['NAME'] = $arSect['NAME'];
            $custom_section['ID'] = $arSect['ID'];
            $custom_section['URL'] = $arSect['LIST_PAGE_URL'].$arSect['SECTION_PAGE_URL'];
            $custom_section['PICTURE'] = $arSect['PICTURE'];

            $custom_sections[] = $custom_section;
            
        }

        $arResult['custom_sections'] = $custom_sections;
        $arResult['other']['title'] = $arParams['TEMPLATE_TITLE'];
        $arResult['other']['img'] = $arParams['TEMPLATE_URL_MAIN'];
        $arResult['other']['button_name'] = $arParams['TEMPLATE_BTN_NAME'];
        $arResult['other']['detail_url'] = $arParams['TEMPLATE_URL'];
        $arResult['other']['align'] = $arParams['TEMPLATE_ALIGN'];

        foreach ($arResult['custom_sections'] as $cs){
            $arFile = CFile::GetFileArray($cs['PICTURE']);
            if($arFile){
                $arResult['other']["SUBDIR"][$cs['NAME']] = $arFile["SUBDIR"]; //���������� ����� ��������
                $arResult['other']["FILE_NAME"][$cs['NAME']] = $arFile["FILE_NAME"]; //��� �������� � �����������
            }
         }
        
        $this->endResultCache();
   }

    $this->IncludeComponentTemplate();

?>