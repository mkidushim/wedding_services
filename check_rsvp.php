<?php
header('Access-Control-Allow-Origin: *'); 
header('Content-Type: X-ACCESS_TOKEN, Access-Control-Allow-Origin, Authorization, Origin, x-requested-with, Content-Type, Content-Range, Content-Disposition, Content-Description');
include 'connection.php';
$_REQUEST = json_decode(file_get_contents('php://input'), true);
$params = ['name'];
foreach ($params as $key => $value) {
  if(!isset($_REQUEST[$value])){
    $response['content'] = 'Error missing '.$value;
    respond($response);
  }
  $_REQUEST[$value] = cleanInput($_REQUEST[$value]);
  $object[$value] = $_REQUEST[$value];
}
extract($object);

$info = array();

//Message to be sent until invitations are sent out.
$response['content'] = 'Please come back when you have received your invites.';
respond($response);



$sql ="SELECT * FROM `guest_list` WHERE `name`='$name' AND `rsvp`='1'";
$res = $m->query($sql);
if($res->num_rows > 0){
  $response['content'] = 'It looks like you have already submitted an RSVP. If you need to make a change or feel you have reach this in error, please contact Mike Kidushim at mkidushim@gmail.com or (949)302-7401.';
  respond($response);
}
$sql ="SELECT * FROM `guest_list` WHERE `name`='$name'";
$res = $m->query($sql);
if($res->num_rows < 1){
  $response['content'] = 'It looks like your name is not on the guest list.  If you feel you have reached this in error, please contact Mike Kidushim at mkidushim@gmail.com or (949)302-7401';
  respond($response);
}
$info = $res->fetch_assoc();

$uid = $info['id'];
$email = $info['email'];
$info['token'] = md5($name);
$info['email'] =$email;
$info['name'] =$name;


respond($info);
?>