<?php

$serverName = "LAPTOP-A14J2JIC\\SQLEXPRESS";
$database   = "TEST_SIMRS";

try {
    $conn = new PDO(
        "sqlsrv:Server=$serverName;Database=$database;TrustServerCertificate=true"
    );

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET ANSI_NULLS ON");
    $conn->exec("SET QUOTED_IDENTIFIER ON");

} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}