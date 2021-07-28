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
  $res['fName'] = $person['fName'];
  $res['sName'] = $person['sName'];
  $res['desc'] = $person['desc'];
  $res['city'] = $person['city'];
  $res['country'] = $person['country'];
  $res['day'] = $person['day'];
  $res['month'] = $person['month'];
  $res['year'] = $person['year'];
  $res['profession'] = $person['profession'];

  $res['age'] = $date['age'];
  $res['month_to_holiday'] = $date['month_to_holiday'];
  $res['days_to_holiday'] = $date['days_to_holiday'];
  $res['human_date'] = $date['human_date'];

  // Начальная информация о фотографиях
  $photos = get_photos($id, $link);
  $photo1 =get_photo($photos, 1);
  $photo2 =get_photo($photos, 2);
  $photo3 =get_photo($photos, 3);
  $res['url1'] = $photo1['name'];
  $res['url2'] = $photo2['name'];
  $res['url3'] = $photo3['name'];
  $res['count1'] = $photo1['count_like'];
  $res['count2'] = $photo2['count_like'];
  $res['count3'] = $photo3['count_like'];

  return $res;

}
