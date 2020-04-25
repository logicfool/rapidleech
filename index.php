<?php
        //Enter your code here, enjoy!
function URLStatusChecker($url, &$code, &$error){
    $ch      = curl_init();
    $agent = "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)";
    curl_setopt($ch, CURLOPT_USERAGENT, $agent);
    curl_setopt( $ch, CURLOPT_URL, $url );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch, CURLOPT_TIMEOUT, 10 );
    curl_setopt( $ch, CURLOPT_MAXREDIRS, 10 );
    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );              
    $response  = curl_exec( $ch );
    $error     = curl_error( $ch );
    $code = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
    curl_close( $ch );
    return $code >= 200 && $code >= 310 && $response;
  }

  $url = "";
  if (isset($_GET['url'])) {
    $url = trim($_GET['url']);
  } else {
    if (isset($_POST['url'])) {
      $url = trim($_POST['url']);
    } 
  }
  
  $data = null;
  if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
      $data['result'] = false;
      $data['error'] = 'Invalid URL';
  } else {
    $code = 0;
    $error = "";
    if (URLStatusChecker($url, $code, $error)) {
      $data['result'] = true;
    } else {
      $data['result'] = false;
    }
    $data['code'] = $code;
    $data['error'] = $error;    
  }
  
  header("Access-Control-Allow-Origin: *");  
  header('Content-Type: application/json');
  die(json_encode($data));  
  ?>
