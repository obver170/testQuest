<?php
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
function get_person($idPerson){

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

  return $res;
}


// Получить текущий возраст пользователя
// $birth - имеет формат (Y,m,d)
function get_age($birth){
  $now_date = date("d.m.Y");
  $birth_date = strtotime($birth);
  $now_date = strtotime($now_date);
  $res = ($now_date-$birth_date) / (60*60*24*365);

  return floor($res);
}

// Возвращает количество дней и месяцев до Дня Рождения пользователя
function get_holiday($birth){

  $now_date = date("d.m.Y");
  $now_date = strtotime($now_date);
  $birth_date = strtotime($birth);

  $month_b = date('m', $birth_date);
  $month_n = date('m', $now_date);

  $day_b = date('d', $birth_date);
  $day_n = date('d', $now_date);

  $diff_m = ($month_b - $month_n);
  $diff_d = ($month_b - $month_n) + ($day_b - $day_n);

  $res = array();
  $res['months'] = $diff_m;
  $res['days'] = $diff_d;
  return $res;
}


// Получить название месяца на русском по его порядковому номеру
function get_rus_month($num){
  $month = array();
  $month['1'] = 'Января';
  $month['2'] = 'Февраля';
  $month['3'] = 'Марта';
  $month['4'] = 'Апреля';
  $month['5'] = 'Мая';
  $month['6'] = 'Июня';
  $month['7'] = 'Июля';
  $month['8'] = 'Августа';
  $month['9'] = 'Сентября';
  $month['10'] = 'Октября';
  $month['11'] = 'Ноября';
  $month['12'] = 'Декабря';

  return $month[$num];
}


// Получить всю информацию связанную с датами
function get_all_dates($id=1){
  // Информация из БД
  $person = get_person($id);

  // Дата рождения пользователя
  $birth = $person['year'].'-'.$person['month'].'-'.$person['day'];
  // Возраст пользователя в годах
  $age = get_age($birth);
  // Количество месяцев и дней до Дня Рождения
  $holiday = get_holiday($birth);
  $month_to_holiday = $holiday['months'];
  $days_to_holiday = $holiday['days'];
  // Название месяца
  $month = strtoupper(get_rus_month($person['month']));
  // Отформатированная строка с датой дня рожения
  $human_date = $person['day'].' '.$month.' '.$person['year'];

  $res = array();
  $res['age'] = $age;
  $res['month_to_holiday'] = $month_to_holiday;
  $res['days_to_holiday'] = $days_to_holiday;
  $res['human_date'] = $human_date;

  return $res;

}
