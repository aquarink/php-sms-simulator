<?php

if (!empty($_GET)) {
    $msisdn = $_GET['msisdn'];
    $sms = strtolower($_GET['sms']);
    $trxId = $_GET['trxid'];
    $date = $_GET['trxdate'];
    $shortcode = $_GET['shortcode'];
    $now = date('Y-m-d H-i-s');
    $random = rand(1, 999999999);

    if(substr($msisdn, 0,2) == '62') {
      $idMsisdn = $msisdn;
    } else {
      $idMsisdn = '62' . substr($msisdn, 1);
    }

    include_once 'db.php';

    $host = 'http://localhost/sms-engine-php-mysql-1/mo/xl?';
    //$host = 'http://122.248.32.27:3008/mo/xl?';

    $options = array("msisdn" => $idMsisdn, "sms" => $sms, "trxid" => $trxId, "trxdate" => $date, "shortcode" => $shortcode);
    $host .= http_build_query($options, '', '&');

    $opts = array('http'=>array('header' => "User-Agent:Mozilla/5.0 (Windows NT 6.2) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/21.0.1180.75 Safari/537.1\r\n"));
    $context = stream_context_create($opts);
    $myData = file_get_contents($host,false,$context);

    if ($myData == 'ok') {
        $save = mysqli_query($con, "INSERT INTO inbox (msisdn,sms,date_cr,stat) VALUES('$idMsisdn','$sms','$now','origin')");

        if ($save) {
            echo $now . ' MO Engine ready ' . $random;
        }
    } else {
      //echo $host;
        echo $now . ' MO Engine not ready ' . $random;
    }
}
?>
