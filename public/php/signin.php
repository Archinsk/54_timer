<?php //Авторизация пользователя

//Сначала разрешим принимать и отправлять запросы на сервер А
header('Access-Control-Allow-Origin: *');
//Установим типы запросов, которые следует разрешить (все неуказанные будут отклоняться)
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
//Разрешим передавать Cookie и Authorization заголовки для указанновго в Origin домена
header('Access-Control-Allow-Credentials: true');
//Установим заголовки, которые можно будет обрабатывать
header('Access-Control-Allow-Headers: Authorization, Origin, X-Requested-With, Accept, X-PINGOTHER, Content-Type');

//Подключение RedBeanPHP и БД
require 'db.php';

//Запуск сессии
session_start();

//Парсинг входящего JSON'а
$request = json_decode(file_get_contents('php://input'), true);

if ( isset($request) ) {
  //Проверка наличия пользователя в базе и соответствия пароля
  $userDB = R::findOne('users', 'login = ?', array($request['login']) );
  if ( $userDB ) {
    if ( password_verify($request['password'], $userDB->password) ) {
	  $user = array(
	    'id' => $userDB->id,
	    'name' => $userDB->login,
	  );
	  $response = array(
	    'user' => $user
	  );
	  $_SESSION['auth_user_id'] = $userDB->id;
    } else {
	  $error = array(
	    'id' => '2',
	    'type' => 'password',
	    'errorText' => 'Неверно введен пароль!'
	  );
	  $response = array(
	    'error' => $error
	  );
    };
  } else {
    $error = array(
	    'id' => '1',
	    'type' => 'login',
	    'errorText' => 'Пользователь не зарегистрирован!'
	  );
    $response = array(
	  'error' => $error
    );
  };

  //Отправка JSON-ответа
  echo json_encode($response, JSON_UNESCAPED_UNICODE);
}
?>