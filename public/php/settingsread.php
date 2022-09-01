<?php //Авторизация пользователя

//Подключение RedBeanPHP и БД
require 'db.php';

//Проверка авторизации пользователя
if ($_SESSION['auth_user_id']) {
  //Чтение конфигурации из БД
  $configDB = R::findOne('configs', 'userid = ?', [ $_SESSION['auth_user_id'] ] );

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
	'errorText' => 'Текущий пользователь не авторизован!'
  );
  $response = array(
	'error' => $error
  );
};
  
// Отправка JSON-ответа
echo json_encode($response, JSON_UNESCAPED_UNICODE);

?>