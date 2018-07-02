<?php
header('Access-Control-Allow-Origin: *'); 
header('Content-Type: X-ACCESS_TOKEN, Access-Control-Allow-Origin, Authorization, Origin, x-requested-with, Content-Type, Content-Range, Content-Disposition, Content-Description');
include 'connection.php';

$_REQUEST = json_decode(file_get_contents('php://input'), true);

if(!isset($_REQUEST['name'])){
  $response['content'] ='Missing name.';
  respond($response);
}

extract($_REQUEST);
$name = cleanInput($name);

$info = array();

$sql ="SELECT `name`,`id` FROM `guest_list` WHERE `name` != '$name' AND `plus_one`='0' AND `rsvp`='0' ORDER BY `name` ASC";
$res = $m->query($sql);
while ($e= $res->fetch_assoc()) {
  $info[] = $e;
}

$response['status'] = 'OK';
$response['content'] = $info;
respond($info);
?>