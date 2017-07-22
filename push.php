<?php

if (!empty($_GET)) {

  if ($_GET['username'] == 'adminDB' && $_GET['password'] == 'passwordDb') {

    $msisdn = $_GET['msisdn'];
    $trxId = $_GET['trxid'];
    $cost = $_GET['serviceId'];
    $sms = strtolower($_GET['sms']);
    $shortName = $_GET['shortname'];
    $now = date('Y-m-d H-i-s');
    $random = rand(1, 999999999);

    if(substr($msisdn, 0,2) == '62') {
      $idMsisdn = $msisdn;
    } else {
      $idMsisdn = '62' . substr($msisdn, 1);
    }

    $errMsg = 3;
    if (empty($trxId)) {
      $trxId = 'ID-' . $random;
      //$output = array('error' => $errMsg, 'trxid' => 'ID-' . $random);
      //echo http_build_query($output);

      $newsXML = new SimpleXMLElement("<response></response>");
      $newsIntro = $newsXML->addChild('error');
      $newsIntro->addAttribute('code', $errMsg);
      $newsIntro = $newsXML->addChild('trxid');
      $newsIntro->addAttribute('id', 'ID-' . $random);
      Header('Content-type: text/xml');
      echo $newsXML->asXML();
    } else {
      //$output = array('error' => $errMsg = 0;, 'trxid' => $trxId);
      //echo http_build_query($output);

      $newsXML = new SimpleXMLElement("<response></response>");
      $newsIntro = $newsXML->addChild('error');
      $newsIntro->addAttribute('code', $errMsg);
      $newsIntro = $newsXML->addChild('trxid');
      $newsIntro->addAttribute('id', $trxId);
      Header('Content-type: text/xml');
      echo $newsXML->asXML();
    }

    include_once 'db.php';

    // SEND to DR
    $host = 'http://localhost/sms-engine-php-mysql-1/dr/xl?';
    //$host = 'http://122.248.32.27:3000/dr/xl?';

    $options = array("msisdn" => $idMsisdn, "trxid" => $trxId, "trxdate" => $now, "shortcode" => 912345, "stat" => $errMsg);

    $host .= http_build_query($options, '', '&');

    $opts = array('http'=>array('header' => "User-Agent:Mozilla/5.0 (Windows NT 6.2) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.75 Safari/537.1\r\n"));
    $context = stream_context_create($opts);
    $myData = file_get_contents($host,false,$context);

    if ($myData == 'ok') {
      $save = mysqli_query($con, "INSERT INTO inbox (msisdn,sms,date_cr,stat,biaya) VALUES('$idMsisdn','$sms','$now','reply','$cost')");
    }
  }
}
?>
