<div class="trbg">
<!-- Верхний блок  -->
<?php include("mk-menu.php"); ?>


<!-- Содержимое -->
<div class="mblock" id="white_cont">
    <div class="container">
    <!--<div class="row"></div> col-xs-12 col-sm-12 col-md-10 col-lg-12-->
        <div class="wbg">

		<div style="display: none;" id="user_role">
			<?php
				$brand_name = '';

				foreach ($user->roles as $user_role){
					if (strstr($user_role, 'administrator') != false){
						print 'admin<br/>';

					}
				}

						$cur_url = $_SERVER['REQUEST_URI'];

						$catalog = 'catalog/';
						$has_brand = 'field_brand_tid_selective%5B%5D=';
						$has_brand2 = 'field_brand_tid_selective[]=';

						//search if we have catalog in the link
						if ((strpos($cur_url, $catalog) !== false)){

							//we have only 1 brand selected - so change the title
							if (substr_count($cur_url, $has_brand) == 1){

								$filters = substr($cur_url, strpos($cur_url, '?')+1);

								$filters_array = explode('&', $filters);

								$selected_brand_id = substr($filters_array[0], strlen($has_brand));

								$brand_term = taxonomy_term_load($selected_brand_id);
								$brand_name = $brand_term->name;
							}
						}
			?>

<?php 	//	if (session_status() != PHP_SESSION_ACTIVE)
			 session_start();
			 $ttt = false;
			 //если нет куки
			 if(!(isset($_COOKIE["personal_products"]))) {

				 //массив наших акционных товаров, содержит название товара
				 $personal_action_products = array();

				 //массив, полученный из куки
				 $result_array = array();

			   	 //получаем массив данных из представления, выбирающего акционные товары
				 $ar_view = views_get_view_result('action_products', 'block');

				 foreach ($ar_view as $prod){
				 	$add_pos = rand(0, 1);

				 	//добавляем случайно выпавшие 50% товаров из имеющегося массива
				 	if ($add_pos == 1)
					 $personal_action_products[] = $prod->node_title;
				 }


				 $day_time = 24*60*60; //полные сутки
				 $exp_time = 19*60*60; //время, когда истекает акция - 7 вечера
				 $cur_date = date('H')*60*60 + date('i')*60 + 60;

				 //вычисляем время, когда должны истекать куки
				 if ($cur_date < $exp_time){ //время меньше 7 вечера
				 	$cookie_exp = $exp_time - $cur_date;
				 }
				 else {//время больше 7 вечера, ставим до следующего вечера
				 	$cookie_exp = $exp_time + $day_time - $cur_date;
				 }
				 $tm = time()+10800+$cookie_exp;

			 	foreach ($personal_action_products as $nm => $vl){
					$ttt = setcookie("personal_products[".$nm."]", $vl, $tm, '/', 'wildsportprof.ru', true, true); //прибавляем 3 часа - 10800, т.к. у нас UTC +3
			 	}


			 	//в итговый массив помещаем сформированную случайную выборку,
			 	//т.к. первый раз только что сформированные куки не считываются, поскольку странца уже загружена
			    $_SESSION['action_products'] = $personal_action_products;
			 }
			 else {
			 	//получаем массив из куки
			 	$_SESSION['action_products'] = $_COOKIE["personal_products"];
			 }
?>


<div style="display: none;"><?php
/*
if ($ttt == false){
	print 'false';
}
else
{print $ttt;}

print '<br/>cookie exp: '.$cookie_exp.'<br/>';
$tm = time()+10800 + $cookie_exp;
print 'all: '.$tm.'<br/>';
print 'time: '.time().'<br/>';

 print_r ($_COOKIE["personal_products"]); */?></div>
		</div>

           <div class="tabs"><?php print render($tabs); ?></div>
           <?php if (!empty($help)) { echo $help; } ?>
           <?php if (!empty($messages)) { echo $messages; } ?>



			 <?php $termid = arg(2); $parentids = taxonomy_get_parents_all($termid); ?>
   			 <?php if (!empty($parentids[1]->tid)){
					echo '<div id="cat_menu">';
					print views_embed_view('subcat', $display_id = 'default', $parentids[1]->tid);
					echo '</div>';
          echo '<script>
          function scrollToProduct(width){
                var offsetTop;
                if (jQuery("div").is(".mk-goods")){offsetTop = jQuery(".mk-goods:nth-child(1)").offset().top};
                if(width<768){
                //jQuery("body").scrollTop(offsetTop);
                jQuery("html,body").animate({scrollTop: offsetTop-160},500)
                 return false;
                }
            	}

             jQuery(document).ready(function(){
                 var bodyWidth = document.body.clientWidth;
                 scrollToProduct(bodyWidth);
             });
          </script>';
			 }?>

            <?php print render($page['top_items']); ?>
           <div class="bcrumbs"><?php print $breadcrumb; ?></div>



            <h1><?php print $title;

		   		if ($brand_name != '')
		   			print ' '.$brand_name;

		   ?></h1>
       <div class="filter-sort-wrapper">

     <div class="mob-sort-wrap" align="center"><div class="mobile-sort">Сортировка<i class="fas fa-caret-down sort-icon"></i><i class="fas fa-caret-up sort-icon" style="display:none;"></i></div></div>

       <div class="mobile-sort-list">

       </div>

      <div class="mob-filter-wrap" align="center"><div class="mobile-filter">Фильтр<i class="fas fa-caret-down filter-icon"></i><i class="fas fa-caret-up filter-icon" style="display:none;"></i></div></div>
         </div>
           <?php
          // if($user->uid  == 1) include("mk_filter.php");
        		print render($page['term_filter']);
           ?>

           <div id="cat_menu" class="mk-sub-cat">
             <?php
				$subcat = render($page['cat_menu']);
				print $subcat;
			 ?>
           </div>

<script>
(function ($) {
	var lvl2_terms = [ //массив всех значений только второго уровня
		'509', //Insight Gym IG-500
		'515', //Insight Gym IG-515
		'511', //Insight Gym IG-600
		'512', //Insight Gym IG-650
		'510', //Insight Gym IG-700
		'513', //Insight Gym IG-800
		'514', //Insight Gym IG-900
		'495', //Steel Fitness BD
		'494', //Steel Fitness SP
		'260', //Matrix G1
		'259', //Matrix Aura G3
		'257', //Matrix Magnum
		'258', //Matrix Ultra G7
		'256', //Matrix Versa
   		'90', //Aerofit IT
   		'89', //Aerofit IF
   		'94', //Aerofit Plate load
   		'95', //Aerofit NEO
   		'93', //Aerofit Sterling
   		'17', //Aerofit Plamax
   		'11', //Impulse
   		'499', //Life Strong S
   		'497', //Life Strong BW
   		'498', //Life Strong BS
   		'285', //Vasil Gym
   		'283', //Vasil Neo
   		'284', //Vasil Sway
		'141', //Vertex EWS
		'242' //Vertex NWS
	];

	/*перемещаем панель с фильтрами*/
	el1 = $("#views-exposed-form-taxonomy-term-page");
	$(el1).addClass("mk-box-selective");
	el2 = $("#views-exposed-form-taxonomy-term-page").clone().removeClass("mk-box-selective");
	$(el1).before(el2);
	var newbox = $(el1).before("<div class='mk-brand-box'></div>");
	$(el2).appendTo($(".mk-brand-box"));

	/*
	$(".mk-brand-box input[type='checkbox']").each(function () {
		if ((jQuery.inArray($(this).val(), lvl2_terms) > -1 ) && ($(location).attr('href').indexOf('/seria/') < 0)){
			$(this).parent('.form-item').css({'display':'none'});
		}

	});  */

}(jQuery));
</script>

           <?php print render($page['content']); ?>

		<?php print render($page['banner_planning']); ?>


<script>
(function ($) {
	var banner_cont = '';
	$('.views-widget-sort-by label').html('Цена');
	/*JS MK*/
	//перемещение верхнего пагинатора списка товаров к блоку сортировки по цене
	$(".pager-next a").html(">");
	$(".pager-previous a").html("<");
	var el1 = $('ul.pager');
	var el2 = $('#white_cont #views-exposed-form-taxonomy-term-page .views-exposed-widgets');
	if ($(document).width() > 500 ){ $($(el1[0]).parent(".item-list")).clone().appendTo(el2);}
	$(el1).css('display','inline-table');
	$(".item-list").fadeIn(1);

  if ($(document).width() < 992 ){
          //Перемещение фильтров
    $(".view-display-id-default").prependTo(".mk-sub-cat").insertBefore("#block-views-exp-taxonomy-term-page");
    $(".view-id-mcatin").attr("align","center").appendTo(".mk-sub-cat").insertAfter(".block-views-exp-taxonomy-term-page");
    $(".view-header").insertAfter(".bcrumbs+h1").css("padding","20px");
    $(".mob-filter-wrap").insertBefore(".mk-sub-cat");
  }

 	if ($(document).width() < 768 ){
    //Перемещение баннера 3D расстановки повыше
    $(".mbanner-planner").appendTo(".mk-goods:nth-child(5)");
  }

  	if ($(document).width() > 768 ){
       var cat_menu = $("#cat_menu .mk-brand-box + .ctools-auto-submit-full-form");
        $(".view-taxonomy-term .view-content").prepend(cat_menu).addClass("with-new-pagination");

     }

//$('<div class="banner_taxonomy" style="display:none;">'+banner_cont+'</div>').insertAfter(".mk-goods:nth-child(4)");

	//Фильтр кнопка в мобильной версии
 $(".mobile-filter").click(function(){
      $(".mk-sub-cat").stop(true,true);
      $(".mk-sub-cat").slideToggle();
       $(".filter-icon").stop(true,true);
      $(".filter-icon").slideToggle(100);
 });
  $(".mobile-sort").click(function(){
      $(".mobile-sort-list").stop(true,true);
      $(".mobile-sort-list").slideToggle();
       $(".sort-icon").stop(true,true);
      $(".sort-icon").slideToggle(100);
 });


}(jQuery));
</script>

           <?php
		   //логика для вывода "узнать цену только для определенных категорий товаров и пользователей"

		   $hide_prices = array( //массив скрываемых значений (вместе с внутренними - второго уровня)
				'262', //Star Trac
				'255', //Matrix
				'260', //Matrix G1
				'259', //Matrix Aura G3
				'257', //Matrix Magnum
				'258', //Matrix Ultra G7
				'256', //Matrix Versa
				'261', //Vertex
				'141', //Vertex EWS
				'142', //Vertex NWS
				'145', //Bronze Gym
				'91', //Impulse Elite
				'92', //Inotec
		   		'240', //Aerofit
		   		'90', //Aerofit IT
		   		'89', //Aerofit IF
		   		'94', //Aerofit Plate load
		   		'95', //Aerofit NEO
		   		'93', //Aerofit Sterling
		   		'17', //Aerofit Plamax
		   		'11' //Impulse
	   		);



		   if (in_array($termid, $hide_prices)){

					$print_script = true;

					foreach ($user->roles as $user_role){
						if (strstr($user_role, 'administrator') != false){
							$print_script = false;
						}
					}

			?>

				<?php
					if ($print_script){

				?>

           	<script>
				(function ($) {

				    $(".view-id-taxonomy_term  .views-row").each(function () {
				        price_div = $(this).find('.views-field-sell-price .uc-price');
				        price_text = price_div.html();
				        prod_title = $(this).find('.views-field-title a').html();

				           price_div.html('<a class="know_price" data-title="'+prod_title+'">Узнать цену</a>');
				        //   $(this).find('.views-field-addtocartlink').html('');
				        //   $(this).find('.views-field-ops').html('');


				        list_price_div = $(this).find('.views-field-list-price .uc-price');

				        if (list_price_div.html() == '0 р.')
				            list_price_div.html('');

				    });

				}(jQuery));
	   		</script>
           <? 		}
		   		}
		    ?>

           <div id="table_calculate">
                <?php print render($page['table_calculate']); ?>
           </div>

          <?php /*
           <div id="articles_bottom">
                <?php print render($page['articles_bottom']); ?>
           </div>

           */?>

        </div>

        <!---
        <div class="mk-right-filter col-xs-12 col-sm-12 col-md-2 col-lg-2" style="padding-left:0;padding-right:0;display:none;">
        	<?php //print render($page['mk-right-filter-block']); ?>
        </div> ---->




    </div>
</div>
<div style="clear: both;"></div>

<!-- Остались вопросы  -->
<div class="mblock homepage" id="main_quest">
    <div class="container"><?php print render($page['main_quest']); ?></div>
</div>
<div style="clear: both;"></div>

<!-- Меню футера и контакты -->
<div class="mblock" id="main_fmenu">
   <div class="container">

        <div class="fblock fbl1">
            <div class="fb_title">Каталог</div>
            <?php print render($page['fblock1']); ?>
        </div>

        <div class="fblock fbl2">
            <div class="fb_title">Меню</div>
            <?php print render($page['fblock2']); ?>
        </div>

        <div class="fblock fbl3">
            <div class="fb_title">Контакты</div>
            <?php print render($page['fblock3']); ?>
        </div>

        <div class="fblock fbl4">
            <div class="fb_title">Мы принимаем к оплате</div>
            <?php print render($page['fblock4']); ?>
        </div>

</div>
</div>
<div style="clear: both;"></div>

<!--Кнопки на черном фоне мобильная версия-->
<div class="mob-bnts">
          <a href="tel:+7 (495) 132-21-53"><button id="footer-call">позвонить</button></a>
          <a><button id="footer-custom">заказ звонка</button></a>
</div>
<div style="clear: both;"></div>

<!-- Футер -->
<div class="mblock" id="footer">
    <div class="container">
        <div class="copy"><?php print render($page['fcopy']); ?></div>

        <div class="created"><?php print render($page['fcreated']); ?></div>
    </div>
</div>


<div style="clear: both;"></div>


<!-- Всплывающие формы -->
<div id="pform1" class="pop_up">
    <div class="container">
        <div class="pform" id="popup_form">
            <div class="ftitle">Заказать звонок</div>
            <div style="clear: both;"></div>
                <?php print render($page['popup_call']); ?>
            <div class="fclose">
                <div class="fone"></div>
                <div class="ftwo"></div>
            </div>
        </div>
    </div>
</div>


<div id="pform2" class="pop_up">
    <div class="container">
        <div class="pform" id="popup_form">
            <div class="ftitle">Узнать цену</div>
            <div style="clear: both;"></div>
                <?php print render($page['popup_call2']); ?>
            <div class="fclose">
                <div class="fone"></div>
                <div class="ftwo"></div>
            </div>
        </div>
    </div>
</div>

</div>
