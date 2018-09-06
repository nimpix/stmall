<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');


CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");


$APPLICATION->SetTitle("404 Not Found");

$APPLICATION->IncludeComponent("bitrix:main.map", ".default", Array(
	"LEVEL"	=>	"3",
	"COL_NUM"	=>	"2",
	"SHOW_DESCRIPTION"	=>	"Y",
	"SET_TITLE"	=>	"Y",
	"CACHE_TIME"	=>	"36000000"
	)
);
?>
<div class="container">
	<div class="row justify-content-center">
		<div class="col-xs-12">
		<div class="error-wrap error404">
			<font class="errortext2">Страница по данному адресу не найдена</font>
			<span>Введите правильный адрес страницы или продолжите покупки в нашем магазине</span>
			<button class="go-back-cat" onclick="location.href='https://st-mall.ru/catalog/'">Перейти в каталог</button>
		</div>
		</div>
	</div>
</div>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/stmall/footer.php");?>
