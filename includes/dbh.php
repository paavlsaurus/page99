<?php


// $dsn = "mysql:host=localhost;dbname=mewxkcxn_database";
// $dbusername = "mewxkcxn_database";
// $dbpassword = "SuperZajímavýHeslo";

$dsn = "mysql:host=localhost;dbname=database";
$dbusername = "root";
$dbpassword = "";

try{
    $pdo = new PDO($dsn,$dbusername,$dbpassword); 
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
