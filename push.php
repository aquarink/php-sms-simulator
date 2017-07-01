<?php

if (!empty($_GET)) {

    if ($_GET['username'] == 'adminDB' && $_GET['password'] == 'passwordDb') {

        $msisdn = $_GET['msisdn'];
        $trxId = $_GET['trxid'];
        $cost = $_GET['serviceId'];
        $sms = strtolower($_GET['sms']);
        $shortName = $_GET['shortname'];
        $date = new DateTime();
        $now = date_format($date, 'Y-m-d h:i:s');
        $random = rand(1, 999999999);

        $idMsisdn = '62' . substr($msisdn, 1);

        include_once 'db.php';


        $save = mysqli_query($con, "INSERT INTO inbox (msisdn,sms,date_cr,stat,biaya) VALUES('$idMsisdn','$sms','$now','reply','$cost')");
        if ($save) {
            if (empty($trxId)) {
                echo 'ID-' . $random;
                $trxId = 'ID-' . $random;
            } else {
                echo 'ok';
            }

            // SEND to DR
            //$host = 'http://122.248.32.27:3000/dr/xl?';
            $host = 'http://localhost:3000/dr/xl?';

            $options = array("msisdn" => $idMsisdn, "trxid" => $trxId, "trxdate" => $now, "shortcode" => 912345, "stat" => 2);
            $host .= http_build_query($options, '', '&');
            $myData = file_get_contents("$host");
        }
    }
}
?>
