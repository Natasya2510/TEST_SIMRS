<?php
include "koneksi.php";

$sql="SELECT RIGHT('000000'+CAST(ISNULL(MAX(CAST(no_pendaftaran AS INT)),0)+1 AS VARCHAR(6)),6) AS no_daftar FROM registrasi_pasien";
$nextNo=$conn->query($sql)->fetch(PDO::FETCH_ASSOC)['no_daftar'];

$poli=$conn->query("SELECT * FROM poliklinik ORDER BY nama_poliklinik");

if(isset($_POST['simpan'])){

$stmt=$conn->prepare("
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
)");

$stmt->execute([
$_POST['no_pendaftaran'],
$_POST['no_rm'],
$_POST['nama_pasien'],
$_POST['jenis_kelamin'],
$_POST['tgl_lahir'],
$_POST['kode_poliklinik'],
$_POST['alamat']
]);

header("Location: admin.php?tambah=1");
exit;

}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Pasien</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
body{
background:#eef2f7;
}
.card{
border:none;
border-radius:15px;
box-shadow:0 5px 20px rgba(0,0,0,.08);
}
.card-header{
background:#198754;
color:#fff;
font-size:22px;
font-weight:bold;
}
label{
font-weight:600;
}
</style>
</head>

<body>

<div class="container py-5">

<div class="card">

<div class="card-header">
<i class="bi bi-person-plus-fill"></i>
Tambah Data Pasien
</div>

<div class="card-body">

<form method="POST">

<div class="row">

<div class="col-md-6 mb-3">
<label>No Pendaftaran</label>
<input type="text" name="no_pendaftaran" class="form-control" value="<?= $nextNo ?>" readonly>
</div>

<div class="col-md-6 mb-3">
<label>No Rekam Medis</label>
<input type="text" name="no_rm" class="form-control" required>
</div>

<div class="col-md-6 mb-3">
<label>Nama Pasien</label>
<input type="text" name="nama_pasien" class="form-control" required>
</div>

<div class="col-md-6 mb-3">
<label>Jenis Kelamin</label>
<select name="jenis_kelamin" class="form-select">
<option value="L">Laki-laki</option>
<option value="P">Perempuan</option>
</select>
</div>

<div class="col-md-6 mb-3">
<label>Tanggal Lahir</label>
<input type="date" name="tgl_lahir" class="form-control" required>
</div>

<div class="col-md-6 mb-3">
<label>Poliklinik</label>
<select name="kode_poliklinik" class="form-select" required>
<option value="">-- Pilih Poliklinik --</option>

<?php while($p=$poli->fetch(PDO::FETCH_ASSOC)){ ?>

<option value="<?= $p['kode_poliklinik'] ?>">
<?= htmlspecialchars($p['nama_poliklinik']) ?>
</option>

<?php } ?>

</select>
</div>

<div class="col-12 mb-3">
<label>Alamat</label>
<textarea name="alamat" rows="3" class="form-control" required></textarea>
</div>

</div>

<div class="d-flex justify-content-end gap-2">
<a href="admin.php" class="btn btn-secondary">
<i class="bi bi-arrow-left"></i>
Kembali
</a>

<button type="submit" name="simpan" class="btn btn-success">
<i class="bi bi-floppy"></i>
Simpan
</button>
</div>

</form>
</div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>