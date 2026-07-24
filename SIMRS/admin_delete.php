<?php
include "koneksi.php";

if(!isset($_GET['id'])){
header("Location: admin.php");
exit;
}

$id=$_GET['id'];

$stmt=$conn->prepare("DELETE FROM registrasi_pasien WHERE id_registrasi=?");
$stmt->execute([$id]);

header("Location: admin.php?hapus=1");
exit;