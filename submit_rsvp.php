<?php
header('Access-Control-Allow-Origin: *'); 
header('Content-Type: X-ACCESS_TOKEN, Access-Control-Allow-Origin, Authorization, Origin, x-requested-with, Content-Type, Content-Range, Content-Disposition, Content-Description');
include 'connection.php';
$_REQUEST = json_decode(file_get_contents('php://input'), true);
$params = ['rsvp'];
$params2 = ['id','name','email','song','message'];
foreach ($params as $key => $value) {
  if(!isset($_REQUEST[$value])){
    $response['content'] = 'Error missing '.$value;
    respond($response);
  }
  $_REQUEST[$value] = json_decode($_REQUEST[$value],1);
  $object[$value] = $_REQUEST[$value];
}

extract($_REQUEST);
$plus_one_g = '-1';
foreach ($rsvp as $key => $value) {
  foreach ($params2 as $key2 => $value2) {
    if($plus_one_g == '1' && $key == '1' && $value2 == 'id'){
      continue;
    }
    if($value[$value2] == null){
      $value[$value2] = '';
    }
    if(!isset($value[$value2])){
      $response['content'] = $value2;
      respond($response);
    }
    $value[$value2] = cleanInput($value[$value2]);
  }
  extract($value);
  if($key == 0){
    $plus_one_g = $plus_one;
  }
  if($key != 0 && $plus_one == '1'){
    $sql = "INSERT INTO `guest_list` (`name`,`email`,`song`,`message`,`rsvp`,`coming`) VALUES('$name','$email','$song','$message','1','$coming')";
  }else{
    if($key == 0){
      $sql = "UPDATE `guest_list` SET `email`='$email',`song`='$song',`message`='$message',`rsvp`='1',`coming`='$coming' WHERE `id`='$id'";  
    }
    $sql = "UPDATE `guest_list` SET `email`='$email',`song`='$song',`message`='$message',`rsvp`='1',`coming`='$coming' WHERE `id`='$id'";
  }
  if(!$m->query($sql)){
    $response['content'] = 'Query error could not add guests';
    respond($response);
  };
}
$response['status'] = 'OK';
$response['content'] = $object;
respond($response);
?>