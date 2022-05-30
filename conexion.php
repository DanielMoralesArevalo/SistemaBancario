<?php
    $servername = "banksystem-daniel.database.windows.net";
    $connectioninfo = array("Database"=>"BankSystem", "UID"=>"dev", "PWD"=>"Daniel123456", "CharacterSet"=>"UTF-8");
    $conn = sqlsrv_connect($servername, $connectioninfo);

    if ($conn === false) {
        echo "Error connecting to server";
        die(print_r(sqlsrv_errors(), true));
    }
?>
