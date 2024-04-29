<?php
    include("connect.php");
    $startTime = $_GET["startTime"];
    $stopTime = $_GET["stopTime"]; 

    try {
        $sqlSelect = "select id_seanse, client.name, start, stop, in_traffic, out_traffic from seanse inner join client
        on seanse.fid_client = client.id_client where start >= :startTime and stop <= :stopTime;";

        $stmt = $dbh->prepare($sqlSelect);
        $stmt->bindValue(":startTime", $startTime);
        $stmt->bindValue(":stopTime", $stopTime);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_OBJ);

        echo json_encode($res);

    }

    catch(PDOException $ex) {   // Обробка виключень
        echo $ex->GetMessage();     // Виведення повідомлення про помилку
    }

    $dbh = null;
?>