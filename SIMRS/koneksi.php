<?php

$serverName = "LAPTOP-A14J2JIC\\SQLEXPRESS";
$database   = "SIMRS";

try {

    $conn = new PDO(
        "sqlsrv:Server=$serverName;Database=$database;TrustServerCertificate=true"
    );

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {

    die("Koneksi database gagal : " . $e->getMessage());

}