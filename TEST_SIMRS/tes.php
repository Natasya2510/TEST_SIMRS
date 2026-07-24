<?php

$serverName = "LAPTOP-A14J2JIC\\SQLEXPRESS";
$database = "TEST_SIMRS";

try {
    $conn = new PDO(
        "sqlsrv:Server=$serverName;Database=$database;TrustServerCertificate=true"
    );

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Koneksi berhasil";

} catch (PDOException $e) {
    echo $e->getMessage();
}