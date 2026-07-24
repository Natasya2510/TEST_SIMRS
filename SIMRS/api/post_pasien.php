<?php

include "koneksi.php";

$data = json_decode(file_get_contents("php://input"), true);

if(
    !isset($data['no_rm']) ||
    !isset($data['nama_pasien']) ||
    !isset($data['jenis_kelamin']) ||
    !isset($data['tgl_lahir']) ||
    !isset($data['kode_poliklinik']) ||
    !isset($data['alamat'])
){
    echo json_encode([
        "status"=>false,
        "message"=>"Data tidak lengkap"
    ]);
    exit;
}

$no_rm = $data['no_rm'];

// CEK DUPLIKAT REGISTRASI HARI INI

$cek = $conn->prepare("
SELECT COUNT(*) 
FROM registrasi_pasien
WHERE no_rm = ?
AND CAST(tgl_pendaftaran AS DATE)=CAST(GETDATE() AS DATE)
");

$cek->execute([$no_rm]);

$jumlah = $cek->fetchColumn();

if($jumlah > 0){

    echo json_encode([
        "status"=>false,
        "message"=>"Pasien sudah melakukan registrasi hari ini"
    ]);

    exit;

}

// GENERATE NO PENDAFTARAN

$getNo = $conn->query("
SELECT MAX(no_pendaftaran) 
FROM registrasi_pasien
");

$last = $getNo->fetchColumn();

if($last){

    $no_pendaftaran = str_pad(
        intval($last)+1,
        6,
        "0",
        STR_PAD_LEFT
    );

}else{

    $no_pendaftaran="000001";

}

// INSERT DATA

$sql="
INSERT INTO registrasi_pasien
(
no_pendaftaran,
no_rm,
nama_pasien,
jenis_kelamin,
tgl_lahir,
kode_poliklinik,
alamat,
tgl_pendaftaran
)

VALUES
(
?,?,?,?,?,?,?,GETDATE()
)

";

$stmt=$conn->prepare($sql);

$stmt->execute([
$no_pendaftaran,
$data['no_rm'],
$data['nama_pasien'],
$data['jenis_kelamin'],
$data['tgl_lahir'],
$data['kode_poliklinik'],
$data['alamat']
]);

echo json_encode([
"status"=>true,
"message"=>"Registrasi pasien berhasil",
"no_pendaftaran"=>$no_pendaftaran
],JSON_PRETTY_PRINT);