var OFFER_SIZE = '';

//функция добавляет товар в отложенные по клику "добавить в избранное". Вызывается из add_to_delay.php в корне темы
function to_delay(p_id, pp_id, p, name, dpu, size, color) {
  name = escape(name);
  size = size || '';
  color = color || '';

  if (OFFER_SIZE != '')
    size = OFFER_SIZE;

  $.ajax({
    type: "GET",
    url: "/bitrix/templates/stmall/to_delay.php",
    data: ({
      p_id: p_id,
      pp_id: pp_id,
      p: p,
      name: name,
      size: size,
      color: color
    }),
    success: function(data) {
      $('.add_to_fav').addClass('in_fav');
      $('.add_to_fav').html('<span class="icon-fav"></span>В избранном');
    },
    error: function(xhr, textStatus) {
      console.log([xhr.status, textStatus]);
    }
  });
}


(function($) {

  $(document).on('click', '#main-container>li', function() {
    let href = $(this).find('.link-cat').attr('href');
    location.href = href;
  });

  $(document).on('change', '.max-price', function() {
    $('.max-price-cont').html($(this).val());
  });

  //Добавлениче счетчика и цены в корзину сверху
  //В списке
  $(document).on('click', '.product-item-pos .btn-md', function() {
    let count = parseInt($('#cart-count').val());
    let old_price = $('#cart-price').val();
    let count_price = $(this).parent().parent().parent().find('.product-item-price-container .product-item-price-old').html();
    count_price = count_price.replace('руб.', '').replace(/\s/g, '');
    old_price = old_price.replace().replace(/\s/g, '');
    old_price = parseInt(old_price);
    count_price = parseInt(count_price);
    count++;
    count_price += old_price;
    if (!$(this).hasClass('pushed-btn')) {
      $('#cart-count').val(count);
      $('.cart-count').html(count);
      $('#cart-price').val(count_price);
      $('.cart-price').html(count_price + " " + "р.");
      $(this).addClass('pushed-btn');
    } else {
      $('#cart-count').val(count);
      $('.cart-count').html(count);
      $('#cart-price').val(count_price);
      $('.cart-price').html(count_price + " " + "р.");
      return false;
    }

  });
  //В товаре
  $(document).on('click', '.product-item-detail-buy-button', function() {
    let count = parseInt($('#cart-count').val());
    let old_price = $('#cart-price').val();
    let count_price = $('.product-item-detail-price-current').html().split('</span>');
    count_price = count_price[1];
    count_price = count_price.replace('руб.', '').replace(/\s/g, '');
    old_price = old_price.replace().replace(/\s/g, '');
    old_price = parseInt(old_price);
    count_price = parseInt(count_price);
    count++;
    count_price += old_price;
    if (!$(this).hasClass('pushed-btn')) {
      $('#cart-count').val(count);
      $('.cart-count').html(count);
      $('#cart-price').val(count_price);
      $('.cart-price').html(count_price + " " + "р.");
      $(this).addClass('pushed-btn');
    } else {
      $('#cart-count').val(count);
      $('.cart-count').html(count);
      $('#cart-price').val(count_price);
      $('.cart-price').html(count_price + " " + "р.");
      return false;
    }

  });
  //в КОрзине плюс и минус , сделать

  //Форма вариант
  $(document).on('click', '.variant', function() {
    let variant = $(this).parent().find('h3').html();
    $('.form-3 .form-group input[type=hidden]').val(variant);
    $('.popback,.form-3').fadeIn();
  });
  $(document).on('click','.favor .basket-item-actions-remove',function () {
  location.href = location;
  });

  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  $(document).on('ready', function() {
    //Махинации в мобильной версии
    if(document.body.clientWidth < 769){
      $('.mobile-phone a').empty();
    }


    $('.product-image').click(function(){
      if($(this).hasClass('popped-img')){
          $(this).removeClass('popped-img');
          $('.popback').fadeOut();
          $('body').css('overflow','visible');
      }else{
      $('.popback').fadeIn();
      $(this).addClass('popped-img');
      }
    });
    $('.product-item-detail-slider-close').click(function () {
        $('.product-image').removeClass('popped-img');
        $('.popback').fadeOut();
    });

    $('.add_to_fav').click(function () {
        if($(this).hasClass('in_fav')){
          return false;
        }else{
          let  cnt = $('#fav-count').html();
          cnt = parseInt(cnt);
          $('#fav-count').html(cnt+1);
        }
    });

    //$('.bx-breadcrumb .catalog-item:nth-child(2) a span').text('Все товары');
    if(location.href == 'http://st-mall.ru/catalog/'){
      $('.bx-breadcrumb:nth-child(2) span').css('color','var(--color-main)');
    }



    //меняем текс meta- в catalog.section .default в разделе Защита
    if($('div').is('.meta-text-cat')){
      let metaText = $('.meta-text-cat').html();
      let newText = metaText.replace(/Защита/g,"защиту");
      $('.meta-text-cat').html(newText);
    }
    //Страница избранное сообщение
    if ($(document).find("title").text() == "Избранное") {
      if ($('font').is('.errortext2')) {
        if ($('.errortext2').text() == "Ваша корзина пуста") $('.errortext').text("Ваш список избранного пуст");
        $('.errortext2').wrap('<div class="error-wrap"></div>');
        $('.favor .error-wrap').parent().addClass('fav-p');
        $('.error-wrap').append('<span>Подберите что-нибудь подходящее в каталоге</span>')
        $('.error-wrap').append('<button class="go-back-cat">Перейти в каталог</button>')
      }
      $('.go-back-cat').click(() => {
        location.href = 'http://st-mall.ru/catalog/';
      });
    }
    //Страница корзины сообщение
    if ($(document).find("title").text() == "Корзина") {
      if ($('font').is('.errortext2')) {
         if ($('.errortext2').text() == "Ваша корзина пуста") $('.errortext').text("Ваша корзина пуста");
        $('.errortext2').wrap('<div class="error-wrap"></div>');
        $('.cart-container .error-wrap').parent().addClass('fav-p');
        $('.error-wrap').append('<span>Подберите что-нибудь подходящее в каталоге</span>')
        $('.error-wrap').append('<button class="go-back-cat">Перейти в каталог</button>')
      }
      $('.go-back-cat').click(() => {
        location.href = 'http://st-mall.ru/catalog/';
      });
    }
    //

    $.each($('.lowecase-title'), function() {
      let lowecaseTitle = $(this).text().toLowerCase();
      $(this).text(lowecaseTitle);
    });


    $('.rating-item').click(function() {
      location.href = $(this).find('.price-and-button a').attr('href');
    });

    $('.cart').click(function() {
      location.href = 'http://st-mall.ru/cart/';
    });

    $('.bonus button').click(function() {
      $('html').animate({
        scrollTop: 0
      }, 500);
    });

    //Кнопка на баннере
    $('.banner-wrap button').click(function() {
      location.href = 'http://st-mall.ru/catalog/begovye-dorozhki/';
    });

    //Форма
    $('.button-call button,#footer-call').click(function() {
      $('.popback,.form-1').fadeIn();
    });
    $('.ask-form span').click(function() {
      $('.popback,.form-2').fadeIn();
    });



    $('.popback').click(function() {
      if($('.product-item-detail-slider-container').hasClass('popup')){
          $('.product-item-detail-slider-container').removeClass('popup');
          $('.product-image').removeClass('popped-img');
          $('body').css('overflow','visible');
      }
      $(this).fadeOut();
      $('.form-1,.form-2,.form-3').fadeOut();
    });

    $('#form-close').click(function(e) {
      e.preventDefault();
      $('.popback').fadeOut();
      $('.form-1,.form-2,.form-3').fadeOut();
    });
    $('.form-2 #form-close').click(function(e) {
      e.preventDefault();
      $('.popback').fadeOut();
      $('.form-2').fadeOut();
    });
    $('.form-3 #form-close').click(function(e) {
      e.preventDefault();
      $('.popback').fadeOut();
      $('.form-3').fadeOut();
    });

    //Добавляем обязательные поля в форму ID-1,2,3
    $(".form-1 #input2").attr("required", true);
    $(".form-2 #input1").attr("required", true);
    $(".form-3 #input2").attr("required", true);
    //



    $(".section-list-wrapper i").click(function() {
      $(this).parent().toggleClass('active-carret');
      $(this).toggleClass('fa-caret-up');
      $(this).parent().find("ul").stop(true, true).slideToggle();
    });

    $('.catalog-dropdown .menu-desk #main-container>li').mouseenter(function() {
      let cls = $(this).attr('class');
      cls = cls.split(' ');
      $(this).addClass('cat-active').addClass(cls[0] + 'g');
      $('.catalog-dropdown .menu-desk #main-container>li').addClass('shadow-right');
    });
    $('.catalog-dropdown .menu-desk #main-container>li').mouseout(function() {
      let cls = $(this).attr('class');
      cls = cls.split(' ');
      $(this)[0].className = '';
      $(this)[0].className = cls[0];
      $(this).removeClass('cat-active');
    });


    //при наведении на раздел главной
    // $('.tr-item .img_wrapper a img').mouseenter(function () {
    //    $(this).animate({
    //     width:"110%",height:"110%"},
    //        500,
    //        'linear'
    //    );
    // });

    //Desktop-menu
    $('.catalog-dropdown').hover(function() {
      $('.catalog-dropdown .menu-desk').stop(true, true).slideToggle();
    });
    $('.menu-desk #main-container li').hover(function() {
      $(this).find('.dropwrap').toggleClass('active-list');
    });


    if (document.body.clientWidth <= 992) {
      if ($(".trainer").hasClass('right-trainer')) {
        $('.trainer').removeClass('right-trainer');
      }
    }

    //Mobile menu
    if (document.body.clientWidth <= 788) {
      $('.catalog-dropdown').click(function() {
        if ($('.mob-menu').hasClass('collapsed-menu')) {
          $('.mob-menu').stop(true, true).removeClass('collapsed-menu').slideUp();
        } else {
          $('.mob-menu').stop(true, true).addClass('collapsed-menu').slideDown();
        }
      });
    }

    //Фикс ссылок в меню
    $('#main-container>li').click(() => {
      let href = $(this).find('.link-cat').attr('href');
      location.href = href;
    });

    $(".logo").click(() => {
      location.href = '/';
    });



    //	Мобильный поиск
    $('.mobile-menu .mobile-search').click(() => {
      if ($('.mobpanelsearch').hasClass('active-search')) {
        $('.mobpanelsearch').removeClass('active-search').fadeOut();
      } else {
        $('.mobpanelsearch').addClass('active-search').fadeIn();
      }
    });
    //Меняем desktop меню на mobile меню
    if (document.body.clientWidth < 789) {
      $('.menu-desk').addClass('mob-menu').removeClass('menu-desk');
    }

    $('.product-item-detail-buy-button').click(() => {
      let count = $('.buy_cnt span').html();
      $('.buy_cnt span').html(+count + 1);
    });

    $('#unlogined,#logined').click(() => {
      $('.auth,.back-layer').fadeToggle();
    });
    $('.fa-window-close').click(() => {
      $('.auth,.back-layer').fadeOut();
    });
    $('.back-layer').click(() => {
      $('.auth,.back-layer').fadeOut();
    });


    //Галки в фильтре
    $('.bx-filter-param-text').click(function() {

      if ($(this).hasClass('active-check')) {
        $(this).parent().find('.flagcheck').css('display', 'none');
        $(this).removeClass('active-check');
      } else {
        $(this).addClass('active-check');
        $(this).parent().find('.flagcheck').css('display', 'block');
      }
    });
    $(document).on('click', '.flagcheck', function() {

      if ($(this).parent().find('.bx-filter-param-text').hasClass('active-check')) {
        $(this).parent().find('.bx-filter-param-text').removeClass('active-check');
        $(this).css('display', 'none');
      } else {
        $(this).parent().find('.bx-filter-param-text').addClass('active-check');
        $(this).css('display', 'block');
      }
    });

    $('.bx-filter-input-checkbox input[checked=checked]').parent().find('.bx-filter-param-text').addClass('active-check');
    $('.bx-filter-input-checkbox input[checked=checked]').parent().find('.flagcheck').css('display', 'block');
    //
    //Аккордеоны в section-list в каталоге
    // $.each($('.section-list-wrapper'), function() {
    //   let current = $(this).find("li ul");
    //   let newItem = current.parent().find('>.bx_sitemap_li_title');
    //   if (current.length > 0) {
    //     $('<i class="fa fa-caret-down" aria-hidden="true"></i>').insertAfter(newItem);
    //   }
    // });
    //Открываем первые три(1-й уже открыт)
    $('.bx-filter-section .bx-filter-parameters-box .tcount1,.bx-filter-section .bx-filter-parameters-box .tcount2').addClass('active-title');
    $('.active-title').find('.fa-caret-down').removeClass('fa-caret-down').addClass('fa-caret-up');
    //Свертывание в фильтре
    $('.bx-filter-parameters-box-title').click(function() {
      $(this).parent().find('.bx-filter-block').stop(true, true).slideToggle();
      $(this).find('i').toggleClass('fa-caret-up').toggleClass('fa-caret-down');
    });

    // $('#main-container .dropdown-list').wrap('<div class="dropwrap"></div>');

    $('.product-item-detail-slider-image img').click(function(e) {
      return false;
    });

    //Сворачивание характеристик в товаре
    $('.show-all').click(function() {
      if ($('.terms-wrapper').hasClass('collapsed-show')) {
        $('.terms-wrapper').removeClass('collapsed-show');

        $(this).html('Развернуть все');
      } else {
        $(this).html('Свернуть');
        $('.terms-wrapper').addClass('collapsed-show');
      }
    });

    $('.catalog').parent().addClass('no-gutters');



  });

}(jQuery));