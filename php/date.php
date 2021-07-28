<?php

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

// Приводит в правильную форму слово день в зависимости от его порядкового номера
function human_days($num){
  $res = 'дней';
  $one = [1,21,31];
  $two = [2, 3, 4, 22, 23, 24, 25];

  if (in_array($num, $one)) {
    $res = 'день';
    return $res;
  }
  if (in_array($num, $two)) {
    $res = 'дня';
  }

  return $res;
}


// Приводит в правильную форму слово месяц в зависимости от его порядкового номера
function human_month($num){
  $res = 'месяцев';
  $one = [2, 3, 4];

  if ($num == 1) {
    $res = 'месяц';
    return $res;
  }
  if (in_array($num, $one)) {
    $res = 'месяца';
  }

  return $res;
}


// Получить всю информацию связанную с датами по id пользователя
function get_all_dates($id, $link){
  // Информация из БД
  $person = get_person($id, $link);

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

  $h_day = human_days($days_to_holiday);
  $h_month = human_month($month_to_holiday);


  $res = array();
  $res['age'] = $age;
  $res['month_to_holiday'] = $month_to_holiday;
  $res['days_to_holiday'] = $days_to_holiday;
  $res['human_date'] = $human_date;
  $res['day'] = $h_day;
  $res['month'] = $h_month;
  return $res;

}
