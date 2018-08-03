<?
function clearCart(){
  $json = array();
  $data = json_decode(file_get_contents('php://input'), true);

  require_once ($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include.php");
  CModule::IncludeModule("main");
  CModule::IncludeModule("sale");

  $json['answer'] = 'Корзина очищена';


   $res = CSaleBasket::GetList(array(), array(
                                  'FUSER_ID' => CSaleBasket::GetBasketUserID(),
                                  'LID' => s1,
                                  'ORDER_ID' => 'null',
                                  'DELAY' => 'N',
                                  'CAN_BUY' => 'Y'));

    while ($row = $res->fetch()) {
       CSaleBasket::Delete($row['ID']);
    }


  echo json_encode($json);
}


clearCart();

?>
