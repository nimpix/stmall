<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
$APPLICATION->SetPageProperty("description", "Новый интернет-магазин спортивных тренажеров Sport Mall. ➤ Больше 10 000 спортивных тренажеров в интернет-магазине ➤  Бережная доставка ➤ Скидка 500 руб. при первой покупке!");
$APPLICATION->SetPageProperty("keywords", "интернет-магазин спортивных тренажеров");
$APPLICATION->SetPageProperty("title", "Интернет-магазин спортивных тренажеров для дома и зала");
$APPLICATION->SetTitle("");
?><? global $USER;
?>

<!-- Баннер -->
<div class="container-fluid main-banner">
	<div class="container">
		<div class="row banner-wrap">
			<div class="banner-text col-lg-8 col-md-auto">
				<div>
					<h1>Покупайте прямо сейчас!</h1>
					<h3>Беговые дорожки</h3>
					<span>Качественное оборудование по доступным ценам</span> <button>Выбрать</button>
				</div>
			</div>
			<div class="banner-img col-lg-4 col-md-auto">
 <img src="/bitrix/templates/stmall/images/banner-img.png" alt="">
			</div>
		</div>
	</div>
</div>
 <!----> <!--Скидки-->
<div class="container sales">
	<div class="row">
		<div class="col-lg-12 text-center pt60">
			<h3>Займитесь своим здоровьем сегодня!</h3>
			<div class="sale-text">
				 Каждый день реальные <span>скидки!</span>
			</div>
		</div>
	</div>
	<div class="row ">
		<div class="sales-col">
            <?$rs = getSales();$timer = 1;?>
			 <? foreach($rs as $sale):?> <a href="/catalog/<?=$sale['DETAIL_PAGE_URL']?>">
			<div class="item-sale">
				<div class="image-sales">
 <img width="200px" src="<?=$sale['PREVIEW_PICTURE']?>" height="220px" alt=""><span>До окончания<br>
					 скидки осталось:</span>
				</div>
				<div class="descrip-sales">
					<h3><?=$sale['NAME']?></h3>
					<div class="prices">
 <span id="price-new"><?=round($sale['CATALOG_PRICE_1']);?> р</span> <span id="price-old"><?=round($sale['PROPERTY_OLD_PRICE_VALUE']);?> р</span>
					</div>
					<ul class="item-text"><? $countProp = 0;?>
						 <? if(!empty($sale['PROPERTY_MAKSIMALNAYA_SKOROST_VALUE'])){ $countProp++; if($countProp>6) goto endProp;?>
						<li>Скорость :<span> <?=$sale['PROPERTY_MAKSIMALNAYA_SKOROST_VALUE']?> км/ч</span></li>
						 <? }?>
                        <? if(!empty($sale['PROPERTY_DLINA_POLOTNA_VALUE'])&&!empty($sale['PROPERTY_SHIRINA_POLOTNA_VALUE'])){ $countProp++; if($countProp>6) goto endProp;?>
						<li>Полотно :<span> <?=$sale['PROPERTY_DLINA_POLOTNA_VALUE']?>x<?=$sale['PROPERTY_SHIRINA_POLOTNA_VALUE']?> см</span></li>
						 <? }?> <?
                        if(!empty($sale['PROPERTY_MAKSIMALNYJ_VES_POLZOVATELYA_VALUE'])){ $countProp++; if($countProp>6) goto endProp;?>
						<li>Макс. вес :<span> <?=$sale['PROPERTY_MAKSIMALNYJ_VES_POLZOVATELYA_VALUE']?> кг</span></li>
						 <? }?> <?
                        if(!empty($sale['PROPERTY_MOSHCHNOST_DVIGATELYA_VALUE'])){ $countProp++; if($countProp>6) goto endProp;?>
						<li>Мощность :<span> <?=$sale['PROPERTY_MOSHCHNOST_DVIGATELYA_VALUE']?> л.с.</span></li>
						 <? }?>
                        <? if(!empty($sale['PROPERTY_TIP_VALUE'])){ $countProp++; if($countProp>6) goto endProp;?>
						<li>Тип :<span> <?=$sale['PROPERTY_TIP_VALUE']?></span></li>
						 <? }?> <?
                        if(!empty($sale['PROPERTY_KOLICHESTVO_UROVNEJ_NAGRUZKI_VALUE'])){ $countProp++; if($countProp>6) goto endProp;?>
						<li>Кол-во уровней :<span> <?=$sale['PROPERTY_KOLICHESTVO_UROVNEJ_NAGRUZKI_VALUE']?></span></li>
						 <? }?> <?
                        if(!empty($sale['PROPERTY_KONSOL_VALUE'])){ $countProp++; if($countProp>6) goto endProp;?>
						<li>Консоль :<span> <?=$sale['PROPERTY_KONSOL_VALUE']?></span></li>
						 <? }?> <?
                        if(!empty($sale['PROPERTY_KLASS_OBORUDOVANIYA_VALUE'])){ $countProp++; if($countProp>6) goto endProp;?>
						<li>Класс оборудования :<span> <?=$sale['PROPERTY_KLASS_OBORUDOVANIYA_VALUE']?></span></li>
						 <? }?> <?
                        if(!empty($sale['PROPERTY_IZMERENIE_PULSA_VALUE'])){ $countProp++; if($countProp>6) goto endProp;?>
						<li>Измерение пульса :<span> <?=$sale['PROPERTY_IZMERENIE_PULSA_VALUE']?></span></li>
						 <? }?> <?
                        if(!empty($sale['PROPERTY_SISTEMA_NAGRUZKI_VALUE'])){ $countProp++; if($countProp>6) goto endProp;?>
						<li>Система нагрузки :<span> <?=$sale['PROPERTY_SISTEMA_NAGRUZKI_VALUE']?></span></li>
						 <? }?>
                        <? endProp: ;?>
					</ul>
					<div class="timer" id="timer<?=$timer?>">
                        <?if($timer == 1){?>
<!--                        <script src="http://megatimer.ru/s/06698c52ed1f13365f2646af2ed0eed4.js"></script>-->

                        <?}else if($timer ==2){?>
<!--                            <script src="http://megatimer.ru/s/0f39f217d7dfbc1844ff701ee8525599.js"></script>-->
                        <?}else if($timer ==3){?>
<!--                            <script src="http://megatimer.ru/s/b2b80383bb49bd50c1d3b9bd47eebc6f.js"></script>-->
                        <?}?>
					</div>
                    <?$timer++;?>
				</div>
			</div>
 </a>
			<?endforeach;?>
		</div>
	</div>
</div>

    <!----> <!--Секция тренажеров левый-->
    <div class="container" id="title-cat">
        <div class="row">
            <h3>Тренажеры для похудения</h3>
            <button class="variant">Варианты</button>
        </div>
    </div>
    <div class="trainer">
        <div class="trainer-img">
            <div class="tr-item" style="background:url('/bitrix/templates/stmall/images/tr1.png') no-repeat center;">
                <a href="" class="href-one">Для тех кто хочет похудеть</a>
            </div>
            <? print_sections($iblock_id,array(1, 4, 3)); ?>
        </div>
        <div style="height:400px;">
        </div>
    </div>
    <!---->
    <!----> <!--Секция тренажеров правый-->
<div class="container" id="title-cat">
	<div class="row">
		<h3>Качаем пресс</h3>
        <button class="variant">Варианты</button>
	</div>
</div>
<div class="trainer right-trainer">
	<div class="trainer-img">
		<div class="tr-item" style="background:url('/bitrix/templates/stmall/images/press3.jpg') no-repeat center;">
 <a href="" class="href-one">Для тех кто хочет накать пресс</a>
		</div>
		 <? print_sections($iblock_id,array(100,10,208)); ?>
	</div>
	<div style="height:400px;">
	</div>
</div>
 <!----> <!--Секция тренажеров левый-->
<div class="container" id="title-cat">
	<div class="row">
		<h3>Качаем ягодицы</h3>
        <button class="variant">Варианты</button>
	</div>
</div>
<div class="trainer">
	<div class="trainer-img">
		<div class="tr-item" style="background:url('/bitrix/templates/stmall/images/yagodicy.jpg') no-repeat center;">
 <a href="" class="href-one">Для тех кто хочет накачать ягодицы</a>
		</div>
		 <? print_sections($iblock_id,array(14, 11, 4)); ?>
	</div>
	<div style="height:400px;">
	</div>
</div>
 <!----> <!--Секция тренажеров правый-->
<div class="container" id="title-cat">
	<div class="row">
		<h3>Качаем спину</h3>
        <button class="variant">Варианты</button>
	</div>
</div>
<div class="trainer right-trainer">
	<div class="trainer-img">
		<div class="tr-item" style="background:url('/bitrix/templates/stmall/images/spina1.jpg') no-repeat center;">
 <a href="" class="href-one">Для тех кто хочет накачать спину</a>
		</div>
		 <? print_sections($iblock_id,array(236, 87, 11)); ?>
	</div>
	<div style="height:400px;">
	</div>
</div>
 <!----> <!--Топ месяца-->
<div class="container">
	<div class="row">
		<div class="top-title col">
			 Топ месяца по беговым дорожкам
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
		 <? $res = getProducts(1);
           ?>
		<div class="rating">
			 <? $count=0; ?> <? foreach($res as $product):?>
			<div class="rating-item">
				<div class="angle-rat">
					<ul>
						 <? if(!empty($product['PROPERTY_MAKSIMALNAYA_SKOROST_VALUE'])){ ?>
						<li>Скорость :<span> <?=$product['PROPERTY_MAKSIMALNAYA_SKOROST_VALUE']?> км/ч</span></li>
						 <? }?> <? if(!empty($product['PROPERTY_DLINA_POLOTNA_VALUE'])&&!empty($product['PROPERTY_SHIRINA_POLOTNA_VALUE'])){ ?>
						<li>Полотно :<span> <?=$product['PROPERTY_DLINA_POLOTNA_VALUE']?>x<?=$product['PROPERTY_SHIRINA_POLOTNA_VALUE']?> см</span></li>
						 <? }?> <? if(!empty($product['PROPERTY_MAKSIMALNYJ_VES_POLZOVATELYA_VALUE'])){ ?>
						<li>Макс. вес :<span> <?=$product['PROPERTY_MAKSIMALNYJ_VES_POLZOVATELYA_VALUE']?> кг</span></li>
						 <? }?> <? if(!empty($product['PROPERTY_MOSHCHNOST_DVIGATELYA_VALUE'])){ ?>
						<li>Мощность :<span> <?=$product['PROPERTY_MOSHCHNOST_DVIGATELYA_VALUE']?> л.с.</span></li>
						 <? }?> <? if(!empty($product['PROPERTY_TIP_VALUE'])){ ?>
						<li>Тип :<span> <?=$product['PROPERTY_TIP_VALUE']?></span></li>
						 <? }?> <? if(!empty($product['PROPERTY_KOLICHESTVO_UROVNEJ_NAGRUZKI_VALUE'])){ ?>
						<li>Кол-во уровней :<span> <?=$product['PROPERTY_KOLICHESTVO_UROVNEJ_NAGRUZKI_VALUE']?></span></li>
						 <? }?> <?// if(!empty($product['PROPERTY_KONSOL_VALUE'])){ ?><!--<li>Консоль :<span> --><?//=$product['PROPERTY_KONSOL_VALUE']?><!--</span></li>--><?// }?>
					</ul>
				</div>
				<div class="img-wrapper">
 <img width="223px" src="<?=$product['PREVIEW_PICTURE']?>" height="215px" alt="">
					<div class="rat-item-title">
						 <?=$product['NAME']?>
					</div>
				</div>
				<div class="price-and-button">
					<div class="rat-price">
						 <?=round($product['CATALOG_PRICE_1']);?> р
					</div>
 <a href="/catalog/<?=$product['DETAIL_PAGE_URL']?>"><button class="rat-cart">В корзину</button></a>
				</div>
			</div>
			 <? if($count==3){break;} $count++;?> <?endforeach;?>
		</div>
	</div>
</div>
 <!----> <!--Топ месяца-->
<div class="top-title">
	 Топ месяца по велотренажерам
</div>
<div class="container" style="margin-bottom: 100px;">
	<div class="row">
		 <? $res = getProducts(4); ?>
		<div class="rating">
			 <? $count=0; ?> <? foreach($res as $product):?>
			<div class="rating-item">
				<div class="angle-rat">
					<ul>
						 <? if(!empty($product['PROPERTY_MAKSIMALNAYA_SKOROST_VALUE'])){ ?>
						<li>Скорость :<span> <?=$product['PROPERTY_MAKSIMALNAYA_SKOROST_VALUE']?> км/ч</span></li>
						 <? }?> <? if(!empty($product['PROPERTY_DLINA_POLOTNA_VALUE'])&&!empty($product['PROPERTY_SHIRINA_POLOTNA_VALUE'])){ ?>
						<li>Полотно :<span> <?=$product['PROPERTY_DLINA_POLOTNA_VALUE']?>x<?=$product['PROPERTY_SHIRINA_POLOTNA_VALUE']?> см</span></li>
						 <? }?> <? if(!empty($product['PROPERTY_MAKSIMALNYJ_VES_POLZOVATELYA_VALUE'])){ ?>
						<li>Макс. вес :<span> <?=$product['PROPERTY_MAKSIMALNYJ_VES_POLZOVATELYA_VALUE']?> кг</span></li>
						 <? }?> <? if(!empty($product['PROPERTY_MOSHCHNOST_DVIGATELYA_VALUE'])){ ?>
						<li>Мощность :<span> <?=$product['PROPERTY_MOSHCHNOST_DVIGATELYA_VALUE']?> л.с</span></li>
						 <? }?> <? if(!empty($product['PROPERTY_TIP_VALUE'])){ ?>
						<li>Тип :<span> <?=$product['PROPERTY_TIP_VALUE']?></span></li>
						 <? }?> <? if(!empty($product['PROPERTY_KOLICHESTVO_UROVNEJ_NAGRUZKI_VALUE'])){ ?>
						<li>Кол-во уровней :<span> <?=$product['PROPERTY_KOLICHESTVO_UROVNEJ_NAGRUZKI_VALUE']?></span></li>
						 <? }?> <? if(!empty($product['PROPERTY_KONSOL_VALUE'])){ ?>
						<li>Консоль :<span> <?=$product['PROPERTY_KONSOL_VALUE']?></span></li>
						 <? }?>
					</ul>
				</div>
				<div class="img-wrapper">
 <img width="223px" src="<?=$product['PREVIEW_PICTURE']?>" height="215px" alt="">
					<div class="rat-item-title">
						 <?=$product['NAME']?>
					</div>
				</div>
				<div class="price-and-button">
					<div class="rat-price">
						 <?=round($product['CATALOG_PRICE_1']);?> р
					</div>
 <a href="/catalog/<?=$product['DETAIL_PAGE_URL']?>"><button class="rat-cart">В корзину</button></a>
				</div>
			</div>
			 <? if($count==3){break;} $count++;?> <?endforeach;?>
		</div>
	</div>
</div>
 <!--    </div>--> <!---->
<div class="container-fluid bonus">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-lg-auto">
				 <span>Регистрируйся и получи скидку 500 руб. на первую покупку</span> <span>Копи бонусы на следующие покупки</span>
			</div>
			<div class="col-sm-12 col-lg-2">
 <button>Получить</button>
			</div>
		</div>
	</div>
</div>
 <!--Рекомендации-->
<div class="container" id="recomend">
	<h3>Рекомендации по тренировкам дома</h3>

    <?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"my_news",
	array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "N",
		"COMPONENT_TEMPLATE" => "my_news",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "N",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "3",
		"IBLOCK_TYPE" => "news",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "Y",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "3",
		"PAGER_BASE_LINK_ENABLE" => "Y",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "Y",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Новости",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "200",
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC",
		"PAGER_BASE_LINK" => "",
		"PAGER_PARAMS_NAME" => "arrPager",
		"STRICT_SECTION_CHECK" => "N"
	),
	false
);?>

	<div class="row more justify-content-center">
		<div class="col-auto align-self-center">
            <a href="http://st-mall.ru/news/"><button>Больше</button></a>
		</div>
	</div>
</div>

<?require($_SERVER['DOCUMENT_ROOT'].'/bitrix/templates/stmall/footer.php');
?>