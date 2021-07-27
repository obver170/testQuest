<?php

// видеть все ошибки!
// ini_set('display_errors',1);
// error_reporting(E_ALL);
 // подключаем настройки
// require_once 'connect.php';

// включаем режим информирования об ошибках
// mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = "localhost";
$user = 'admin1';
$password = 'admin1';
$database = 'test_oneway';


$link = mysqli_connect($host, $user, $password, $database);


// выполняем операции с базой данных
$sql = "SELECT * FROM Person";
$result = mysqli_query($link, $sql);
printf("Select вернул %d строк.\n", mysqli_num_rows($result));
// printf(serialize($result['second_name']));
// $row = $result->fetch_assoc()
while ($row = mysqli_fetch_array($result)) {
    echo "Имя: {$row['first_name']}: Фамилия: {$row['second_name']}";
  }

// echo "Выполнение запроса прошло успешно";
// в большинстве случаев закрывать подключение не надо
