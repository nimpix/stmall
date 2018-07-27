<?
$json = array();
$data = json_decode(file_get_contents('php://input'), true);
//$json['answer'] = !empty($data['test'])? $data['test'] : "не пришел POST";
//Генерация пароля
function generate_password($number)
{
    $arr = array('a','b','c','d','e','f',
        'g','h','i','j','k','l',
        'm','n','o','p','r','s',
        't','u','v','x','y','z',
        'A','B','C','D','E','F',
        'G','H','I','J','K','L',
        'M','N','O','P','R','S',
        'T','U','V','X','Y','Z',
        '1','2','3','4','5','6',
        '7','8','9','0');
    // Генерируем пароль
    $pass = "";
    for($i = 0; $i < $number; $i++)
    {
        // Вычисляем случайный индекс массива
        $index = rand(0, count($arr) - 1);
        $pass .= $arr[$index];
    }
    return $pass;
}
$pass = generate_password(7);
$login = $data['phone'];
//

//Изменение пользователя
//require_once($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/classes/general/user.php");
require_once ($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include.php");
CModule::IncludeModule("main");
$user = new CUser;
$rsUser = $user->GetByLogin($login);
$arUser = $rsUser->Fetch();

$ID = $user->UPDATE($arUser['ID'],array("PASSWORD"=>$pass));
///////////////////////////



//Ответ сервера
if (intval($ID) > 0){
    //Отправка SMS через CURL
    require_once 'sms.ru.php';

    $smsru = new SMSRU('C59BD0C7-7D69-4949-74BF-600D2894571B'); // Ваш уникальный программный ключ, который можно получить на главной странице

    $data = new stdClass();
    $data->to = $login;
    $message = $pass.' ваш новый пароль для сайта st-mall.ru ';
    $data->text = $message; // Текст сообщения
    $data->from = 'stmall'; // Если у вас уже одобрен буквенный отправитель, его можно указать здесь, в противном случае будет использоваться ваш отправитель по умолчанию
// $data->time = time() + 7*60*60; // Отложить отправку на 7 часов
    $data->translit = 1; // Перевести все русские символы в латиницу (позволяет сэкономить на длине СМС)
// $data->test = 1; // Позволяет выполнить запрос в тестовом режиме без реальной отправки сообщения
// $data->partner_id = '1'; // Можно указать ваш ID партнера, если вы интегрируете код в чужую систему
    $sms = $smsru->send_one($data); // Отправка сообщения и возврат данных в переменную

    if ($sms->status == "OK") { // Запрос выполнен успешно
        $json['answer'] = "Пароль успешно изменен, вам на телефон выслана смс с паролем от вашей учетной записи ";
//    echo "ID сообщения: $sms->sms_id. ";
//    echo "Ваш новый баланс: $sms->balance";
    } else {
        $json['answer'] =  "Ошибка отправки смс";
    }
/////////////////////////

    $json['messcolor'] ="var(--salat)";
}


echo json_encode($json);
/////////////////
?>