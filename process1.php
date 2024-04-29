<?php
    include("connect.php");
    $clientName = $_GET["clientName"];

    try {
        $sqlSelect = "select id_seanse, client.name, start, stop,
        in_traffic, out_traffic from seanse inner join client on
        seanse.fid_client = client.id_client where client.name = :clientName";

        $stmt = $dbh->prepare($sqlSelect);
        $stmt->bindValue(":clientName", $clientName);
        $stmt->execute();
        $res = $stmt->fetchAll();

        foreach($res as $row) {
            echo "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td>
            <td>$row[4]</td><td>$row[5]</td></tr>";
        }
    }

    catch(PDOException $ex) {   // Обробка виключень
        echo $ex->GetMessage();     // Виведення повідомлення про помилку
    }

    $dbh = null;
?>