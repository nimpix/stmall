<?
CModule::IncludeModule("forum");
$res = CForumMessage::GetList(
  array(),
  array(),
  false,
  0
);
$arr_ob = array();

while($ob = $res->GetNext()){

  $ID = $ob['PARAM2'];
  $arr_ob[$ID][] = $ob['TOPIC_ID'];

}
foreach ($arResult['ITEMS'] as $k => &$items) {

  foreach ($arr_ob as $key => $value) {
    if($key == $items['ID']) {
      $items[FMSG_COUNT] = count($value)-1;
    }
  }

}
?>
