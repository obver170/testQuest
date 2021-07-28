<?php
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
function get_person($idPerson=1, $link){



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
