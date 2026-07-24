<?php

include "koneksi.php";

if (isset($_POST['simpan'])) {

    $sql = "INSERT INTO pasien
    (
        no_rm,
        nik,
        nama,
        jenis_kelamin,
        tempat_lahir,
        tanggal_lahir,
        alamat,
        no_hp,
        gol_darah,
        agama,
        pekerjaan
    )
    VALUES
    (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        $_POST['no_rm'],
        $_POST['nik'],
        $_POST['nama'],
        $_POST['jk'],
        $_POST['tempat_lahir'],
        $_POST['tanggal_lahir'],
        $_POST['alamat'],
        $_POST['hp'],
        $_POST['gol_darah'],
        $_POST['agama'],
        $_POST['pekerjaan']
    ]);

    header("Location: pasien.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>Tambah Pasien</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#f5f7fb;
}

.card{
    border:none;
    border-radius:15px;
    box-shadow:0 5px 20px rgba(0,0,0,.08);
}

.card-header{
    background:#0d6efd;
    color:white;
    font-size:22px;
    font-weight:bold;
}

label{
    font-weight:600;
}

.btn{
    min-width:120px;
}

</style>

</head>

<body>

<div class="container py-5">

<div class="card">

<div class="card-header">
    ➕ Tambah Pasien
</div>

<div class="card-body">

<form method="POST">

<div class="row">

<div class="col-md-6 mb-3">
<label>No. RM</label>
<input type="text" name="no_rm" class="form-control" required>
</div>

<div class="col-md-6 mb-3">
<label>NIK</label>
<input type="text" name="nik" class="form-control" required>
</div>

<div class="col-md-6 mb-3">
<label>Nama Pasien</label>
<input type="text" name="nama" class="form-control" required>
</div>

<div class="col-md-6 mb-3">
<label>Jenis Kelamin</label>
<select name="jk" class="form-select">
    <option value="L">Laki-laki</option>
    <option value="P">Perempuan</option>
</select>
</div>

<div class="col-md-6 mb-3">
<label>Tempat Lahir</label>
<input type="text" name="tempat_lahir" class="form-control" required>
</div>

<div class="col-md-6 mb-3">
<label>Tanggal Lahir</label>
<input type="date" name="tanggal_lahir" class="form-control" required>
</div>

<div class="col-md-6 mb-3">
<label>No. HP</label>
<input type="text" name="hp" class="form-control" required>
</div>

<div class="col-md-6 mb-3">
<label>Golongan Darah</label>
<select name="gol_darah" class="form-select">
    <option value="A">A</option>
    <option value="B">B</option>
    <option value="AB">AB</option>
    <option value="O">O</option>
</select>
</div>

<div class="col-md-6 mb-3">
<label>Agama</label>
<select name="agama" class="form-select">
    <option value="Islam">Islam</option>
    <option value="Kristen">Kristen</option>
    <option value="Katolik">Katolik</option>
    <option value="Hindu">Hindu</option>
    <option value="Buddha">Buddha</option>
    <option value="Konghucu">Konghucu</option>
</select>
</div>

<div class="col-md-6 mb-3">
<label>Pekerjaan</label>
<input type="text" name="pekerjaan" class="form-control" required>
</div>

<div class="col-12 mb-3">
<label>Alamat</label>
<textarea name="alamat" rows="3" class="form-control" required></textarea>
</div>

</div>

<div class="d-flex justify-content-end gap-2">

<a href="pasien.php" class="btn btn-secondary">
← Kembali
</a>

<button type="submit" name="simpan" class="btn btn-primary">
💾 Simpan
</button>

</div>

</form>

</div>

</div>

</div>

</body>

</html>