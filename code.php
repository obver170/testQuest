<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// include 'php/person.php';
include 'php/date.php';
include 'php/like.php';


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


// Получить название
function get_name($table, $id, $link){
  $col = 'id'.$table;
  $sql = "SELECT * FROM $table WHERE $col = $id";

  $result = mysqli_query($link, $sql);
  $row = mysqli_fetch_array($result);

  return $row['name'];
}

// Получить id страны по id города
function get_id_country($idCity, $link){
  $sql = "SELECT * FROM City WHERE idCity = $idCity";

  $result = mysqli_query($link, $sql);
  $row = mysqli_fetch_array($result);

  $idCountry = $row['Country_idCountry'];

  return $idCountry;
}

// Получить id дня, месяца, года
function get_ids_date($idDate, $link){
  $sql = "SELECT * FROM Date WHERE idDate = $idDate";
  $result = mysqli_query($link, $sql);
  $row = mysqli_fetch_array($result);

  $res = array();
  $res['idDay'] = $row['Day_idDay'];
  $res['idMonth'] = $row['Month_idMonth'];
  $res['idYear'] = $row['Year_idYear'];

  return $res;
}

// Подключиться к БД, получить, распарсить данные по id пользователя
function get_person($idPerson=1){


  $user_connect = connect();
  extract($user_connect);

  $link = mysqli_connect($host, $usr, $pass, $db);

  $sql = "SELECT * FROM Person WHERE idPerson = $idPerson";
  $result = mysqli_query($link, $sql);
  $row = mysqli_fetch_array($result);

  // Имя, фамилия, описание
  $fName = $row['first_name'];
  $sName = $row['second_name'];
  $desc = $row['description'];

  // Город и страна
  $idCity = $row['City_idCity'];
  $city = get_name('City', $idCity, $link);
  $idCountry = get_id_country($idCity, $link);
  $country = get_name('Country', $idCountry, $link);

  // Дата рождения
  $idDate = $row['Date_idDate'];
  // Получить id дня, месяца, года
  $idsDate = get_ids_date($idDate, $link);
  $idDay = $idsDate['idDay'];
  $idMonth = $idsDate['idMonth'];
  $idYear = $idsDate['idYear'];
  // Получить названия дня, месяца, года
  $day = get_name('Day', $idDay, $link);
  $month = get_name('Month', $idMonth, $link);
  $year = get_name('Year', $idYear, $link);

  // Профессия
  $idProfession = $row['Profession_idProfession'];
  $profession = get_name('Profession', $idProfession, $link);

  // Ответ
  $res = array();
  $res['fName'] = $fName;
  $res['sName'] = $sName;
  $res['desc'] = $desc;
  $res['city'] = $city;
  $res['country'] = $country;
  $res['day'] = $day;
  $res['month'] = $month;
  $res['year'] = $year;
  $res['profession'] = $profession;

  $photos = get_photos($idPerson, $link);

  return $res;
}


// Формирует полный ответ
function get_data($id=1){

  $user_connect = connect();
  extract($user_connect);

  $link = mysqli_connect($host, $usr, $pass, $db);

  $person = get_person($id);
  $date = get_all_dates($id);


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
  $res['count2'] = $photo1['count_like'];
  $res['count3'] = $photo1['count_like'];


  return $res;

}



// add_like("2.2.2.2", 1);
del_like(7);
