<?php
include "koneksi.php";

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
ORDER BY r.id_registrasi DESC";

$stmt=$conn->query($sql);

$data=$stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    "status"=>true,
    "total"=>count($data),
    "data"=>$data
],JSON_PRETTY_PRINT);