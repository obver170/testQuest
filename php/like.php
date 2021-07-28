<?php

function get_likes($idPhoto, $link){
  $sql = "SELECT * From Ip WHERE Photo_idPhoto=$idPhoto;";
  $result = mysqli_query($link, $sql);
  $res = array();
  while ($row = mysqli_fetch_array($result)) {
    // $res[] = $row['name'];
    $res[$row['idIp']] = $row['name'];
  }

  return $res;
}



// Возвращает id лайка, если ip есть в массиве лайков под фото
function isLike($ip, $arr){
  $res = 0;
  foreach($arr as $key => $value){
    if ($value == $ip){
      $res = $key;
    }
  }
  return $res;
}


// Получить все фото пользователя, по id пользователя
function get_photos($id, $link){
    $sql = "SELECT * From Photo WHERE Person_idPerson=$id;";
    $result = mysqli_query($link, $sql);
    $res = array();
    while ($row = mysqli_fetch_array($result)) {
      $idPhoto = $row['idPhoto'];
      $res[$idPhoto]['idPhoto'] = $row['idPhoto'];
      $res[$idPhoto]['name'] = $row['name'];
      $res[$idPhoto]['description'] = $row['description'];
      $res[$idPhoto]['likes'] = get_likes($idPhoto, $link);
      // Количество лайков
      $res[$idPhoto]['count_like'] = count($res[$idPhoto]['likes']);
      }
  return $res;

}

// Получить информацио о фотографии из массива фотографий по ее id
function get_photo($arr, $id){
  $res = 'Такой фотографии не существует';
  $res = $arr[$id];
  foreach ($arr as $row) {
    if ($row['idPhoto'] == $id){
      $res['name'] = $row['name'];
      $res['description'] = $row['description'];
      $res['likes'] = $row['likes'];
      $res['count_like'] = $row['count_like'];
      return $res;
    }
  }
  return $res;
}

// Добавить ip, к фото по ее id
function add_like($name, $idPhoto){
  $user_connect = connect();
  extract($user_connect);
  $link = mysqli_connect($host, $usr, $pass, $db);

  // Убираю точки, чтобы mysql перестал сыпаться
  $name = str_replace('.', '', $name);

  // Работает только с цифрами
  $sql = 'INSERT INTO `Ip` (`name`, `Photo_idPhoto`) VALUES ('.$name.', '.$idPhoto.')';
  $result = mysqli_query($link, $sql);

  return $result;
}

// Убрать лайк
function del_like($idIp){
  $user_connect = connect();
  extract($user_connect);
  $link = mysqli_connect($host, $usr, $pass, $db);
  $sql = 'DELETE FROM Ip WHERE idIp='.$idIp.'';

  $result = mysqli_query($link, $sql);

  return $result;
}



// Добавить лайк если его нет, если есть - удалить
function action($idPhoto){
  $user_connect = connect();
  extract($user_connect);
  $link = mysqli_connect($host, $usr, $pass, $db);

  $likes = get_likes($idPhoto, $link);

  // Для сервера
  $ip = $_SERVER['REMOTE_ADDR'];
  // Для отладки в консоли
  // $ip = '2.2.2.2';
  $ip = str_replace('.', '', $ip);

  $res = False;

  $isL = isLike($ip, $likes);

  if ($isL){
    del_like($isL);
  } else {
    add_like($ip, $idPhoto);
    $res = True;
  }
  return $res;
}

// Вернуть True если стоит лайк
function get_current_isLike($idPhoto){
  $user_connect = connect();
  extract($user_connect);
  $link = mysqli_connect($host, $usr, $pass, $db);

  $likes = get_likes($idPhoto, $link);

  // Для сервера
  $ip = $_SERVER['REMOTE_ADDR'];
  // Для отладки в консоли
  // $ip = '2.2.2.2';
  $ip = str_replace('.', '', $ip);

  $res = True;

  $isL = isLike($ip, $likes);

  if ($isL){
    $res = True;
    } else {
    $res = False;
  }
  return $res;
}
// add_like('2.2.2.2', 1);
// action(1);

// $user_connect = connect();
// extract($user_connect);
// $link = mysqli_connect($host, $usr, $pass, $db);
// $idPhoto = 1;
// $res = get_likes2($idPhoto, $link);
// print_r ($res);
