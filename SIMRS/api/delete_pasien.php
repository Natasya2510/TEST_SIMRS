<?php

include "koneksi.php";

if(!isset($_GET['id'])){

echo json_encode([
"status"=>false,
"message"=>"ID wajib diisi"
]);

exit;
}

$id=$_GET['id'];

$stmt=$conn->prepare("
DELETE FROM registrasi_pasien
WHERE id_registrasi=?
");

$stmt->execute([$id]);

echo json_encode([
"status"=>true,
"message"=>"Data berhasil dihapus"
],JSON_PRETTY_PRINT);