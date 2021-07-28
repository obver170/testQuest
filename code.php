<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// include 'php/person.php';
include 'php/date.php';
include 'php/like.php';
include 'php/person.php';


// Передает данные для полключения к БД
function connect(
    $host='localhost',
    $usr='admin1',
    $pass='admin1',
    $db='test_oneway'
  ){

  $conn = array();
  $conn['host'] = $host;
  $conn['usr'] = $usr;
  $conn['pass'] = $pass;
  $conn['db'] = $db;

  return $conn;
}


// Формирует полный ответ
function get_data($id=1){

  $user_connect = connect();
  extract($user_connect);

  $link = mysqli_connect($host, $usr, $pass, $db);

  $person = get_person($id, $link);
  $date = get_all_dates($id, $link);


  $res = array();
  // Ответ
  // Имя
  $res['fName'] = $person['fName'];
  // Фамилия
  $res['sName'] = $person['sName'];
  // Описание
  $res['desc'] = $person['desc'];
  // Город
  $res['city'] = $person['city'];
  // Страна
  $res['country'] = $person['country'];
  // Профессия
  $res['profession'] = $person['profession'];

  //Возраст
  $res['age'] = $date['age'];
  // Количество месяцев до ДР
  $res['month_to_holiday'] = $date['month_to_holiday'];
  // Количество дней до ДР
  $res['days_to_holiday'] = $date['days_to_holiday'];
  // Строка для печати с датой рождения
  $res['human_date'] = $date['human_date'];
  // склонение "дня"
  $res['day'] = $date['day'];
  // склонение "месяца"
  $res['month'] = $date['month'];



  // Информация о фотографиях
  $photos = get_photos($id, $link);
  $photo1 =get_photo($photos, 1);
  $photo2 =get_photo($photos, 2);
  $photo3 =get_photo($photos, 3);
  // Ссылки на фото
  $res['url1'] = $photo1['name'];
  $res['url2'] = $photo2['name'];
  $res['url3'] = $photo3['name'];
  // Количество лайков
  $res['count1'] = $photo1['count_like'];
  $res['count2'] = $photo2['count_like'];
  $res['count3'] = $photo3['count_like'];

  return $res;

}
