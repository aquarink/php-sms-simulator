<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Mobiwin Simulator Telco</title>
    </head>
    <body>
    <center>
        <?php include_once 'db.php'; ?>
        <h1>SIMULATOR TELCO</h1>
        <br>
        <h2>
            Total MSISDN : 
            <?php
            $msisdn = mysqli_query($con, "SELECT DISTINCT msisdn FROM inbox");
            echo number_format(mysqli_num_rows($msisdn));
            ?>
        </h2>
        <br>
        <h2>
            Total Pesan Terkirim : 
            <?php
            $smsKirim = mysqli_query($con, "SELECT * FROM inbox WHERE stat = 'origin'");
            echo number_format(mysqli_num_rows($smsKirim));
            ?>
        </h2>
        <br>
        <h2>
            Total Pesan Diterima : 
            <?php
            $smsTerima = mysqli_query($con, "SELECT * FROM inbox WHERE stat = 'reply'");
            echo number_format(mysqli_num_rows($smsTerima));
            ?>
        </h2>
    </center>
</body>
</html>
