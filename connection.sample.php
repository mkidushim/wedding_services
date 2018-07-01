<?php   

  $dbHost = 'localhost';
  $dbUser = '';
  $dbPass = '';
  $dbName = 'wedding';

  $response = array(
    'status'=>'NO',
    'content'=>'',
  );

  $m = new mysqli($dbHost,$dbUser,$dbPass,$dbName);

  if ($m->connect_errno){
    $response['content'] = 'Error connectiong to the database.';
    respond($response);
    exit;
  }
  //respond function
  function respond($response){
    global $m;    
    $resp = json_encode($response);
    echo $resp;
    exit;
  }
  function cleanInput($v){
    global $m;
    $v = stripslashes($v);
    $v = $m->real_escape_string($v);
    $v = trim($v);
    return $v;
  } 
?>
