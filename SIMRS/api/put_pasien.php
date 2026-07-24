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

$data=json_decode(
file_get_contents("php://input"),
true
);

$sql="
UPDATE registrasi_pasien
SET alamat=?, kode_poliklinik=?
WHERE id_registrasi=?
";

$stmt=$conn->prepare($sql);

$stmt->execute([

$data['alamat'],
$data['kode_poliklinik'],
$id
]);

echo json_encode([
"status"=>true,
"message"=>"Data berhasil diperbarui"
],JSON_PRETTY_PRINT);