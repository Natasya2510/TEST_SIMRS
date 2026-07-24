<?php

include "koneksi.php";

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM pasien WHERE id_pasien = ?");
$stmt->execute([$id]);

header("Location: pasien.php");
exit;