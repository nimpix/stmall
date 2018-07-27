<?
require_once ($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include.php");


if(isset($_POST['id'])){
    $id = $_POST['id'];


    $json = array();
    $json['id'] = "Нет ошибок";

    CModule::IncludeModule('iblock');

    $arFields = array(
        "DELAY" => "N"
    );

    if(CModule::IncludeModule("sale")){

        if(CSaleBasket::Update($id, $arFields)){
           // $json['id'] ="Успешное удаление";
        } else{
           // $json['id'] ="Не отработало удаление";
        }




    }

    header('Content-Type: application/json');
    echo json_encode($json);
}
?>