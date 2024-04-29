<?php
    header("Content-Type: text/xml");
    include("connect.php");

    try {
        $sqlSelect = "select * from client where balance < ?";

        $stmt = $dbh->prepare($sqlSelect);
        $stmt->bindValue(1, 0);
        $stmt->execute();
        $res = $stmt->fetchAll();

        echo '<?xml version="1.0" encoding="UTF-8"?>';
        echo "<root>";
        foreach($res as $row) {
            echo "<row><id>$row[0]</id><name>$row[1]</name><login>$row[2]</login><password>$row[3]</password>
            <ip>$row[4]</ip><balance>$row[5]</balance></row>";
        }
        echo "</root>";
    }

    catch(PDOException $ex) {   // Обробка виключень
        echo $ex->GetMessage();     // Виведення повідомлення про помилку
    }

    $dbh = null;
?>