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

// echo '--------------------------';
// var_dump($request);
// var_dump($_SESSION);
// echo '--------------------------';

if ( isset($request) ) {
  //Проверка авторизации пользователя
  if ($_SESSION['auth_user_id']) {
	//Чтение конфигурации из БД
	$config = R::findOne('configs', 'userid = ?', [ $_SESSION['auth_user_id'] ] );
	
	// Проверка существующей записи
	if ( !$config ) {
	  $config = R::dispense('configs');
	    $config->userid = $_SESSION['auth_user_id'];
	};

	// Установка конфигурации
	$config->schemes = json_encode($request['schemes'], JSON_UNESCAPED_UNICODE);
    $config->selectedscheme = json_encode($request['selectedTrainingScheme'], JSON_UNESCAPED_UNICODE);
    $config->configinterface = json_encode($request['interface'], JSON_UNESCAPED_UNICODE);
    $config->sounds = json_encode($request['sounds'], JSON_UNESCAPED_UNICODE);
	//Запись конфигурации в БД
	$configIdDB = R::store($config);
	
	// Поиск свежей записи
	$configDB = R::findOne('configs', 'id = ?', [ $configIdDB ] );
	
	// Формирование ответа
	$configAuth = array(
	  'schemes' => json_decode( $configDB->schemes, true),
	  'selectedTrainingScheme' => json_decode( $configDB->selectedscheme, true),
	  'interface' => json_decode( $configDB->configinterface, true),
	  'sounds' => json_decode( $configDB->sounds, true),
	);
	$response = array(
	  'config' => $configAuth
    );
  } else {
	$error = array(
	  'id' => '10',
	  'type' => 'auth',
	  'errorText' => 'Пользователь не авторизован'
	);
	$response = array(
	  'error' => $error
	);
  };
  
  // Отправка JSON-ответа
  echo json_encode($response, JSON_UNESCAPED_UNICODE);
}
?>