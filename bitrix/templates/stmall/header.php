<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
IncludeTemplateLangFile($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/".SITE_TEMPLATE_ID."/header.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/stmall/trainers.php");
CJSCore::Init(array("fx"));
$curPage = $APPLICATION->GetCurPage(true);
$theme = COption::GetOptionString("main", "wizard_eshop_bootstrap_theme_id", "blue", SITE_ID);
?>
<!DOCTYPE html>
<html xml:lang="<?= LANGUAGE_ID ?>" lang="<?= LANGUAGE_ID ?>">
<head>
    <? $APPLICATION->ShowHead();
    $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/style.css");
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery-1.11.1.min.js");
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/script.js");
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/timer.js");
    //$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/vue.js");
   // $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/vue_script.js");
    ?>
    <title><? $APPLICATION->ShowTitle('title'); ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
          integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css"
          integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
  
    <noscript>
        <div><img src="https://mc.yandex.ru/watch/49112977" style="position:absolute; left:-9999px;" alt=""/></div>
    </noscript> <!-- /Yandex.Metrika counter -->
    <script type="text/javascript" src="https://vk.com/js/api/share.js?93" charset="windows-1251"></script>
    <script>
      !function(f,b,e,v,n,t,s)
      {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
      fbq('init', '207484840066549');
      fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=207484840066549&ev=PageView&noscript=1"/></noscript>
    <meta name="yandex-verification" content="d25a619a4b76674e" />
</head>


<body>

<div id="panel"><? $APPLICATION->ShowPanel(); ?></div>
<div class="popback"></div>
<div class="form-1">
    <div class="form-main">
        <? $APPLICATION->IncludeComponent(
            "bitrix:form",
            "my_form",
            array(
                "AJAX_MODE" => "N",
                "AJAX_OPTION_ADDITIONAL" => "",
                "AJAX_OPTION_HISTORY" => "N",
                "AJAX_OPTION_JUMP" => "N",
                "AJAX_OPTION_STYLE" => "Y",
                "CACHE_TIME" => "3600",
                "CACHE_TYPE" => "A",
                "CHAIN_ITEM_LINK" => "",
                "CHAIN_ITEM_TEXT" => "",
                "EDIT_ADDITIONAL" => "N",
                "EDIT_STATUS" => "Y",
                "IGNORE_CUSTOM_TEMPLATE" => "Y",
                "NOT_SHOW_FILTER" => array(
                    0 => "",
                    1 => "",
                ),
                "NOT_SHOW_TABLE" => array(
                    0 => "",
                    1 => "",
                ),
                "RESULT_ID" => $_REQUEST[RESULT_ID],
                "SEF_FOLDER" => "",
                "SEF_MODE" => "Y",
                "SHOW_ADDITIONAL" => "N",
                "SHOW_ANSWER_VALUE" => "N",
                "SHOW_EDIT_PAGE" => "N",
                "SHOW_LIST_PAGE" => "N",
                "SHOW_STATUS" => "Y",
                "SHOW_VIEW_PAGE" => "N",
                "START_PAGE" => "new",
                "SUCCESS_URL" => "/thank-you",
                "USE_EXTENDED_ERRORS" => "N",
                "WEB_FORM_ID" => "1",
                "COMPONENT_TEMPLATE" => "my_form",
                "SEF_URL_TEMPLATES" => array(
                    "new" => "#WEB_FORM_ID#/",
                    "list" => "#WEB_FORM_ID#/list/",
                    "edit" => "#WEB_FORM_ID#/edit/#RESULT_ID#/",
                    "view" => "#WEB_FORM_ID#/view/#RESULT_ID#/",
                ),
            ),
            false
        ); ?>
    </div>
</div>
<div class="form-3">
    <div class="form-main">
        <? $APPLICATION->IncludeComponent(
            "bitrix:form",
            "my_form3",
            array(
                "AJAX_MODE" => "N",
                "AJAX_OPTION_ADDITIONAL" => "",
                "AJAX_OPTION_HISTORY" => "N",
                "AJAX_OPTION_JUMP" => "N",
                "AJAX_OPTION_STYLE" => "Y",
                "CACHE_TIME" => "3600",
                "CACHE_TYPE" => "A",
                "CHAIN_ITEM_LINK" => "",
                "CHAIN_ITEM_TEXT" => "",
                "EDIT_ADDITIONAL" => "N",
                "EDIT_STATUS" => "Y",
                "IGNORE_CUSTOM_TEMPLATE" => "Y",
                "NOT_SHOW_FILTER" => array(
                    0 => "",
                    1 => "",
                ),
                "NOT_SHOW_TABLE" => array(
                    0 => "",
                    1 => "",
                ),
                "RESULT_ID" => $_REQUEST[RESULT_ID],
                "SEF_FOLDER" => "",
                "SEF_MODE" => "Y",
                "SHOW_ADDITIONAL" => "N",
                "SHOW_ANSWER_VALUE" => "N",
                "SHOW_EDIT_PAGE" => "N",
                "SHOW_LIST_PAGE" => "N",
                "SHOW_STATUS" => "Y",
                "SHOW_VIEW_PAGE" => "N",
                "START_PAGE" => "new",
                "SUCCESS_URL" => "/thank-you",
                "USE_EXTENDED_ERRORS" => "N",
                "WEB_FORM_ID" => "3",
                "COMPONENT_TEMPLATE" => "my_form",
                "SEF_URL_TEMPLATES" => array(
                    "new" => "#WEB_FORM_ID#/",
                    "list" => "#WEB_FORM_ID#/list/",
                    "edit" => "#WEB_FORM_ID#/edit/#RESULT_ID#/",
                    "view" => "#WEB_FORM_ID#/view/#RESULT_ID#/",
                ),
            ),
            false
        ); ?>
    </div>
</div>

<div class="back-layer"></div>
<div class="">
<!--    base-->
    <div class="content">
        <!--  Mobile menu-->
        <?$page = $APPLICATION->GetCurPage();
        $flag = strpos($page,'catalog');
        ?>
        <div class="mobile-menu <? $out = ($flag) ? 'menu-green' : ''; echo $out;?>">


            <div class="catalog-dropdown">
                <div id="mobile-drop" class="<?echo (!$flag) ? '':'prod-menu-mobile-drop' ;?>">
                    <div class="menu-bar">
                        <span class="line-bar"></span>
                        <span class="line-bar"></span>
                        <span class="line-bar"></span>
                    </div>
                </div>
            </div>

            <div class="<?echo (!$flag) ? 'logo':'prod-menu-logo' ;?>"><?
            if($flag){
                ?>
                    <div class="product-menu-search">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="SPORT MALL">
                        </div>
                    </div>
                <?
            }
            ?></div>
            <div class="<?echo (!$flag) ? 'separator-menu':'' ;?>"></div>
            <div class="mobile-phone <?echo ($flag) ? 'mobile-phone-white' : '';?>">
                <a href="tel:+74950217733" class="phone">8 (495) 021-77-33</a>
            </div>

            <div class="cart">
                <div class="cart-icons">
                    <span></span>
                    <span><div class="cart-count">0</div></span>
                </div>
                <div class="cart-text">
                    <div></div>
                </div>

            </div>

            <div class="mobile-search <?echo (!$flag) ? '' : 'white-mob-search';?>">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Я ищу...">
                </div>
            </div>
        </div>
        <!--Поиск-->
        <div class="search col-auto mobpanelsearch">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Я ищу...">
            </div>
        </div>
        <!---->
        <!--Дропменю мобайл-->
        <? $APPLICATION->IncludeComponent(
	"adamant:menu", 
	"catalog_vmenu", 
	array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "left",
		"COMPONENT_TEMPLATE" => "catalog_vmenu",
		"DELAY" => "N",
		"MAX_LEVEL" => "3",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MENU_CACHE_TIME" => "360000",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_THEME" => "blue",
		"ROOT_MENU_TYPE" => "left",
		"USE_EXT" => "Y"
	),
	false
); ?>


        <!--Меню сверху-->

        <div class="topblock">
            <div class="container">
                <div class="row  no-gutters justify-content-md-center justify-content-lg-between">
                    <div class="col-lg-auto col-md-3">
                        <span class="mobile-icon"></span>
                        <a href="tel:+74950217733" class="phone">8 (495) 021-77-33</a>
                    </div>
                    <div class="col-lg-auto text-md-center col-md-9 ml-auto">
                        <ul class="mk-menu">
                            <li><a href="/dostavka-i-oplata">Доставка и оплата</a></li>
                            <li><a href="/kak-sdelat-zakaz">Как сделать заказ</a></li>
                            <li><a href="/bonusy">Бонусы</a></li>
                            <li><a href="/favourites">Избранное</a>
                                <div class="wishc">
                                    <?

                                    use Bitrix\Main\Loader;

                                    Loader::includeModule("sale");
                                    $delaydBasketItems = CSaleBasket::GetList(
                                        array(),
                                        array(
                                            "FUSER_ID" => CSaleBasket::GetBasketUserID(),
                                            "LID" => SITE_ID,
                                            "ORDER_ID" => "NULL",
                                            "DELAY" => "Y",
                                        ),
                                        array()
                                    );
                                    echo "<div id ='fav-count'>".$delaydBasketItems."</div>";
                                    ?>
                                </div
                            </li>
                            <li>
                                <? if ($USER->IsAuthorized()) { ?><span href="" id="logined"><? print $USER->GetLogin(
                                ); ?></span>
                                <? } else { ?>
                                    <span href="" id="unlogined">Вход/Регистрация</span>
                                <? } ?>

                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>

        <!--    Всплывающая форма логина-->
        <div class="col-auto">
            <div class="auth">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:system.auth.form",
                    "form",
                    Array(
                        "FORGOT_PASSWORD_URL" => "/forgot/",
                        "PROFILE_URL" => "/profile/",
                        "REGISTER_URL" => "/registration/",
                        "SHOW_ERRORS" => "N",
                    )
                ); ?>
            </div>
        </div>
        <!--    -->

        <!-- Поиск и прочее-->
        <div class="container white-top">
            <div class="row no-gutters">
                <div class="logo"></div>

                <? $APPLICATION->IncludeComponent(
                    "bitrix:search.form",
                    "my_search",
                    Array(
                        "PAGE" => "#SITE_DIR#search/index.php",
                        "USE_SUGGEST" => "N",
                    ),
                    false
                ); ?>
            </div>
            <div class="cart col-sm-auto ml-auto">
                <!--                <div class="cart-icons">-->
                <!--                    <span></span>-->
                <!--                    <span><div class="cart-count">0</div></span>-->
                <? $APPLICATION->IncludeComponent(
	"bitrix:sale.basket.basket.line", 
	"my_basket", 
	array(
		"PATH_TO_BASKET" => SITE_DIR."cart/",
		"PATH_TO_PERSONAL" => SITE_DIR."profile/",
		"SHOW_PERSONAL_LINK" => "N",
		"SHOW_NUM_PRODUCTS" => "Y",
		"SHOW_TOTAL_PRICE" => "Y",
		"SHOW_PRODUCTS" => "N",
		"POSITION_FIXED" => "N",
		"POSITION_HORIZONTAL" => "center",
		"POSITION_VERTICAL" => "bottom",
		"SHOW_AUTHOR" => "N",
		"PATH_TO_REGISTER" => SITE_DIR."registration/",
		"PATH_TO_PROFILE" => SITE_DIR."profile/",
		"COMPONENT_TEMPLATE" => "my_basket",
		"SHOW_EMPTY_VALUES" => "Y",
		"PATH_TO_ORDER" => SITE_DIR."/order/",
		"PATH_TO_AUTHORIZE" => "",
		"HIDE_ON_BASKET_PAGES" => "Y",
		"SHOW_DELAY" => "N",
		"SHOW_REGISTRATION" => "Y"
	),
	false
); ?>
                <!--                </div>-->
                <!--                -->
                <!--                <div class="cart-text">-->
                <!--                    <div><span>Корзина</span><span>18555 р.</span></div>-->
                <!--                </div>-->
            </div>
            <div class="button-call col-sm-auto ml-auto">
                <button>Заказать звонок</button>
            </div>
        </div>

        <!-- Меню desktop-->

        <div class="row no-gutters">
            <nav class="catalog-dropdown col-sm-auto navbar">
                <div class="">
                    <span>Каталог товаров</span>
                    <? $APPLICATION->IncludeComponent(
	"adamant:menu",
	"catalog_vmenu",
	array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "left",
		"COMPONENT_TEMPLATE" => "catalog_vmenu",
		"DELAY" => "N",
		"MAX_LEVEL" => "3",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MENU_CACHE_TIME" => "360000",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_THEME" => "blue",
		"ROOT_MENU_TYPE" => "left",
		"USE_EXT" => "Y"
	),
	false
); ?>

                </div>
            </nav>
            <div class="catalog-menu col-sm-8 col-lg-8 col-md-8 col-xl-auto ml-auto">

                <? $APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"catalog_hmenu", 
	array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "left",
		"COMPONENT_TEMPLATE" => "catalog_hmenu",
		"DELAY" => "N",
		"MAX_LEVEL" => "3",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MENU_CACHE_TIME" => "36000",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_THEME" => "blue",
		"ROOT_MENU_TYPE" => "left",
		"USE_EXT" => "Y"
	),
	false
); ?>
            </div>
        </div>


    </div>


    <? $APPLICATION->ShowViewContent('border-top'); ?>
    <div class="container">

        <? if ($curPage != SITE_DIR.'index.php'): ?>
            <div id="navigation">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:breadcrumb",
                    "my_crumb",
                    Array(
                        "PATH" => "",
                        "SITE_ID" => "s1",
                        "START_FROM" => "0",
                    )
                ); ?>

            </div>


        <? endif ?>
    </div>
