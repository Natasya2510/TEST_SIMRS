<?php
$serverName="LAPTOP-A14J2JIC\\SQLEXPRESS";
$database="SIMRS";

try{
    $conn=new PDO("sqlsrv:Server=$serverName;Database=$database;TrustServerCertificate=true");
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    http_response_code(500);
    echo json_encode([
        "status"=>false,
        "message"=>$e->getMessage()
    ]);
    exit;
}

header("Content-Type: application/json");