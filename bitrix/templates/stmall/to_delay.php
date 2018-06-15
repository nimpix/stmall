<? require_once ($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include.php");


if (!function_exists('utf8_urldecode') ) {
  function utf8_urldecode($str) {
    $str = preg_replace("/%u([0-9a-f]{3,4})/i","&#x\\1;",urldecode($str));
    return html_entity_decode($str,null,'cp1251');
  }
}

if (CModule::IncludeModule("sale") && (CModule::IncludeModule("catalog"))) {
   $arFields = array(
      "PRODUCT_ID" => $_REQUEST['p_id'],
      "PRICE" => $_REQUEST['p'],
      "CURRENCY" => "RUB",
      "QUANTITY" => 1,
      "LID" => 's1',
      "DELAY" => "Y",
      "CAN_BUY" => "Y",
      "NAME" => utf8_urldecode($_REQUEST['name']),
      "MODULE" => "sale",
      "DETAIL_PAGE_URL" => $_REQUEST['dpu'],
);

  $arProps = array();

  if ($_REQUEST['color'] != '')
  $arProps[] = array(
    "NAME" => "Цвет",
    "CODE" => "COLOR_REF",
    "VALUE" => $_REQUEST['color']
  );

  if ($_REQUEST['size'] != '')
  $arProps[] = array(
    "NAME" => "Размер",
    "CODE" => "SIZES_SHOES",
    "VALUE" => $_REQUEST['size']
  );

  $arFields["PROPS"] = $arProps;

   $arFields = array("DELAY" => "Y");
$rt = CSaleBasket::Update(Add2BasketByProductID($_REQUEST['p_id'], 1), $arFields);

    echo 'Товар успешно добавлен в избранное!';
}
?>
