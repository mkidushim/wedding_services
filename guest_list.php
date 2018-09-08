<?php
  header('Access-Control-Allow-Origin: *'); 
  header('Content-Type: X-ACCESS_TOKEN, Access-Control-Allow-Origin, Authorization, Origin, x-requested-with, Content-Type, Content-Range, Content-Disposition, Content-Description');

  include 'connection.php';

  $info = array();
  $sql ="SELECT `name`,`rsvp`,`coming`,`email`,`song`,`message` FROM `guest_list`";
  $res = $m->query($sql);
  while ($e= $res->fetch_assoc()) {
    $coming = $e['coming'];
    $rsvp = $e['rsvp'];
    $e['rsvp'] = 'no';
    if($rsvp == '1'){
      $e['rsvp'] = 'yes';
    }

    $e['coming'] = 'no';
    if($coming == '1'){
      $e['coming'] = 'yes';
    }
    $info[] = $e;
  }

  $response['status'] = 'OK';
  $response['content'] = $info;
  respond($info);


?>