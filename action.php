<?php
include 'code.php';
// $idPhoto = $_POST['text'];
// echo $_SERVER['REMOTE_ADDR'];


$text = $_POST['text'];
// $output = wordwrap($text, 60, "<br>");
// get_data(1);
action(1);
$output = $_SERVER['REMOTE_ADDR'];
// $output = get_data(1);
echo $output;

// $json = $output($data);
// echo $json;
// $res = action(1);

// $id = $_GET['id'];
// $data['id'] = $id;
// $json = json_encode($data);
// echo $json;
// exit();



?>
