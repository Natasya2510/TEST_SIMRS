<?php
include "koneksi.php";

if(!isset($_GET['id'])){
    echo json_encode([
        "status"=>false,
        "message"=>"Parameter id wajib diisi."
    ]);
    exit;
}

$sql="
SELECT
r.id_registrasi,
r.no_pendaftaran,
r.no_rm,
r.nama_pasien,
r.jenis_kelamin,
r.tgl_lahir,
p.nama_poliklinik,
r.alamat,
r.tgl_pendaftaran
FROM registrasi_pasien r
INNER JOIN poliklinik p
ON r.kode_poliklinik=p.kode_poliklinik
WHERE r.id_registrasi=?";

$stmt=$conn->prepare($sql);
$stmt->execute([$_GET['id']]);

$data=$stmt->fetch(PDO::FETCH_ASSOC);

if(!$data){
    echo json_encode([
        "status"=>false,
        "message"=>"Data tidak ditemukan."
    ]);
    exit;
}

echo json_encode([
    "status"=>true,
    "data"=>$data
],JSON_PRETTY_PRINT);