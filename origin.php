<?php

if (!empty($_GET)) {
    //$username = $_GET['username'];
    //$password = $_GET['password'];
    $msisdn = $_GET['msisdn'];
    $trxId = $_GET['trxid'];
    //$cost = $_GET['serviceId'];
    $sms = strtolower($_GET['sms']);
    //$shortName = $_GET['shortname'];
    $date = new DateTime();
    $now = date_format($date, 'Y-m-d h:i:s');
    $random = rand(1, 999999999);

    $idMsisdn = '62' . substr($msisdn, 1);

    include_once 'db.php';

    //$host = 'http://122.248.32.27:3000/mo/xl?';
    $host = 'http://localhost:3000/mo/xl?';

    $options = array("msisdn" => $idMsisdn, "sms" => $sms, "trxid" => $trxId, "trxdate" => $now, "shortcode" => 912345);
    $host .= http_build_query($options, '', '&');
    $myData = file_get_contents("$host");

    if ($myData == 'MO OK') {
        $save = mysqli_query($con, "INSERT INTO inbox (msisdn,sms,date_cr,stat) VALUES('$idMsisdn','$sms','$now','origin')");

        if ($save) {
            echo $now . ' MO Engine ready ' . $random;
        }
    } else {
        echo $now . ' MO Engine not ready ' . $random;
    }
}
?>
