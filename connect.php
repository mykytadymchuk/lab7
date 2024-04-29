<?php
    $dsn = "mysql:host=localhost;dbname=lb_pdo_netstat";    // Налаштування підключення
    $user = 'root';
    $pass = '';

    try {
        $dbh = new PDO($dsn, $user, $pass); // Створення підключення
    }

    catch(PDOException $ex) {   // Обробка виключень
        echo $ex->GetMessage();     // Виведення повідомлення про помилку
    }
?>