<!--Мета-тэги для каталога-->
<?
$_SESSION['arName'] = $_SESSION['arName']." ".$_SESSION['brand_name_title'];
$arResult['NAME'] = $_SESSION['PROD_NAME']." ".$_SESSION['brand_name_title'];
$arResult['PRICES']['base_price']['PRINT_VALUE'] = $_SESSION['PROD_PRICE'];
//Для продукта теги
if(isset($_SESSION['PROD_NAME']) && isset($_SESSION['PROD_PRICE'])){
    unset($_SESSION['PROD_NAME']);
    unset($_SESSION['PROD_PRICE']);
    
    $APPLICATION->SetPageProperty("title", $arResult['NAME']." купить в интернет-магазине");
    $APPLICATION->SetPageProperty("description", strtolower($arResult['NAME']).' за '.$arResult['PRICES']['base_price']['PRINT_VALUE'].' в интернет-магазине Sport Mall. ➤ Доставка по России от 7 дней. ➤ Можно купить онлайн за 5 минут.');
    $APPLICATION->SetPageProperty("keywords", strtolower($arResult['NAME']));
}
else { //Тэги для каталога
    $arResult['NAV_RESULT'] = $_SESSION['arNav_RESULT'];
    $arResult['NAME'] = $_SESSION['arName'];
    $arResult['DEPTH_LEVEL'] = $_SESSION['DEPTH'];
    $arResult['IPROPERTY_VALUES']['SECTION_PAGE_TITLE'] = $_SESSION['SECTION_PAGE_TITLE'];
    $arResult['IPROPERTY_VALUES']['SECTION_META_TITLE'] = $_SESSION['SECTION_META_TITLE'];
    $arResult['IPROPERTY_VALUES']['ELEMENT_META_TITLE'] = $_SESSION['ELEMENT_META_TITLE'];
    $a = $_SESSION['PAGEN_1'];
    $_GET['PAGEN_1'] = $a;
    $arResult['ORIGINAL_PARAMETERS']['CURRENT_BASE_PAGE'] = $_SESSION['catalog_url'];

//Находим минимальную цену на странице
    $price_array = array();
    foreach ($arResult['NAV_RESULT']->arResult as $value) {
        array_push($price_array, round($value['CATALOG_PRICE_1']));
    }
    $min_price = min($price_array);

//В зависимости от уровня вложенности выбираем переменную
    if ($arResult['DEPTH_LEVEL'] == 2) {
        $arResult['NAME'] = $arResult['IPROPERTY_VALUES']['SECTION_PAGE_TITLE'];
        if (empty($arResult['NAME'])) $arResult['NAME'] = $arResult['IPROPERTY_VALUES']['SECTION_META_TITLE'];

        //Устанавливаем мета-тэги

        //Тайтл в пагинации
        if (!empty($_GET['PAGEN_1'])) {
            $APPLICATION->SetPageProperty("title", $arResult['NAME'] . " в магазине Sport Mall, страница " . $_GET['PAGEN_1']);
        } else {
            $APPLICATION->SetPageProperty("title", "Купить " . strtolower($arResult['NAME']) . " с доставкой в интернет-магазине");
        }

        $APPLICATION->SetPageProperty("description", 'Купить ' . strtolower($arResult['NAME']) . ' от ' . $min_price . ' р. в интернет-магазине Sport Mall. ➤ Поможем подобрать ' . strtolower($arResult['NAME']) . ' и отправим в ваш город. ➤ Доставка по России, Казахстану, Белоруссии.');
        $APPLICATION->SetPageProperty("keywords", strtolower($arResult['NAME']));
    } elseif ($arResult['DEPTH_LEVEL'] == 3) {
        //Тайтл в пагинации
        if (!empty($_GET['PAGEN_1'])) {
            $APPLICATION->SetPageProperty("title", $arResult['NAME'] . " в магазине Sport Mall, страница " . $_GET['PAGEN_1']);
        } else {
            $APPLICATION->SetPageProperty("title", "Купить " . strtolower($arResult['NAME']) . " с доставкой в интернет-магазине");
        }

        $APPLICATION->SetPageProperty("description", 'Купить ' . strtolower($arResult['NAME']) . ' от ' . $min_price . ' р. в интернет-магазине Sport Mall. ➤ Поможем подобрать ' . strtolower($arResult['NAME']) . ' и отправим в ваш город. ➤ Доставка по России, Казахстану, Белоруссии.');
        $APPLICATION->SetPageProperty("keywords", strtolower($arResult['NAME']));
    } elseif ($arResult['DEPTH_LEVEL'] == 4) {
        $arResult['NAME'] = $arResult['IPROPERTY_VALUES']['SECTION_PAGE_TITLE'];
        if (empty($arResult['NAME'])) $arResult['NAME'] = $arResult['IPROPERTY_VALUES']['ELEMENT_META_TITLE'];

        //Тайтл в пагинации
        if (!empty($_GET['PAGEN_1'])) {
            $APPLICATION->SetPageProperty("title", $arResult['NAME'] . " в магазине Sport Mall, страница " . $_GET['PAGEN_1']);
        } else {
            $APPLICATION->SetPageProperty("title", "Купить " . strtolower($arResult['NAME']) . " с доставкой в интернет-магазине");
        }

        $APPLICATION->SetPageProperty("description", 'Купить ' . strtolower($arResult['NAME']) . ' от ' . $min_price . ' р. в интернет-магазине Sport Mall. ➤ Поможем подобрать ' . strtolower($arResult['NAME']) . ' и отправим в ваш город. ➤ Доставка по России, Казахстану, Белоруссии.');
        $APPLICATION->SetPageProperty("keywords", strtolower($arResult['NAME']));
    } else {
        //Устанавливаем мета-тэги
        //Тайтл в пагинации

        if (!empty($_GET['PAGEN_1'])) {
            $APPLICATION->SetPageProperty("title", $arResult['NAME'] . " в магазине Sport Mall, страница " . $_GET['PAGEN_1']);
        } else {
            $APPLICATION->SetPageProperty("title", "Купить " . strtolower($arResult['NAME']) . " с доставкой в интернет-магазине");
        }

        $APPLICATION->SetPageProperty("description", 'Купить ' . strtolower($arResult['NAME']) . ' от ' . $min_price . ' р. в интернет-магазине Sport Mall. ➤ Поможем подобрать ' . strtolower($arResult['NAME']) . ' и отправим в ваш город. ➤ Доставка по России, Казахстану, Белоруссии.');
        $APPLICATION->SetPageProperty("keywords", strtolower($arResult['NAME']));
    }
    // для /catalog/
    if($arResult['ORIGINAL_PARAMETERS']['CURRENT_BASE_PAGE'] == '/catalog/'){
        $APPLICATION->SetPageProperty("description", 'Купить спортивные тренажеры в интернет-магазине Sport Mall. ➤ Поможем подобрать и отправим в ваш город. ➤ Доставка по России, Казахстану, Белоруссии.');
        $APPLICATION->SetPageProperty("keywords", "каталог спортивных тренажеров");
    }
}

?>
