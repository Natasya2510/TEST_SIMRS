<?php
include "koneksi.php";

if(!isset($_GET['id'])){
header("Location: admin.php");
exit;
}

$id=$_GET['id'];

$stmt=$conn->prepare("SELECT * FROM registrasi_pasien WHERE id_registrasi=?");
$stmt->execute([$id]);
$data=$stmt->fetch(PDO::FETCH_ASSOC);

if(!$data){
die("Data tidak ditemukan.");
}

$poli=$conn->query("SELECT * FROM poliklinik ORDER BY nama_poliklinik");

if(isset($_POST['update'])){

$stmt=$conn->prepare("
UPDATE registrasi_pasien SET
no_rm=?,
nama_pasien=?,
jenis_kelamin=?,
tgl_lahir=?,
kode_poliklinik=?,
alamat=?
WHERE id_registrasi=?
");

$stmt->execute([
$_POST['no_rm'],
$_POST['nama_pasien'],
$_POST['jenis_kelamin'],
$_POST['tgl_lahir'],
$_POST['kode_poliklinik'],
$_POST['alamat'],
$id
]);

header("Location: admin.php?update=1");
exit;

}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Pasien</title>
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
background:#ffc107;
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
<i class="bi bi-pencil-square"></i>
Edit Data Pasien
</div>

<div class="card-body">

<form method="POST">

<div class="row">

<div class="col-md-6 mb-3">
<label>No Pendaftaran</label>
<input type="text" class="form-control" value="<?= htmlspecialchars($data['no_pendaftaran']) ?>" readonly>
</div>

<div class="col-md-6 mb-3">
<label>No Rekam Medis</label>
<input type="text" name="no_rm" class="form-control" value="<?= htmlspecialchars($data['no_rm']) ?>" required>
</div>

<div class="col-md-6 mb-3">
<label>Nama Pasien</label>
<input type="text" name="nama_pasien" class="form-control" value="<?= htmlspecialchars($data['nama_pasien']) ?>" required>
</div>

<div class="col-md-6 mb-3">
<label>Jenis Kelamin</label>
<select name="jenis_kelamin" class="form-select">
<option value="L" <?= $data['jenis_kelamin']=="L"?"selected":"" ?>>Laki-laki</option>
<option value="P" <?= $data['jenis_kelamin']=="P"?"selected":"" ?>>Perempuan</option>
</select>
</div>

<div class="col-md-6 mb-3">
<label>Tanggal Lahir</label>
<input type="date" name="tgl_lahir" class="form-control" value="<?= date('Y-m-d',strtotime($data['tgl_lahir'])) ?>" required>
</div>

<div class="col-md-6 mb-3">
<label>Poliklinik</label>
<select name="kode_poliklinik" class="form-select" required>
<option value="">-- Pilih Poliklinik --</option>

<?php while($p=$poli->fetch(PDO::FETCH_ASSOC)){ ?>
<option value="<?= $p['kode_poliklinik'] ?>" <?= $p['kode_poliklinik']==$data['kode_poliklinik']?"selected":"" ?>>
<?= htmlspecialchars($p['nama_poliklinik']) ?>
</option>
<?php } ?>

</select>
</div>

<div class="col-12 mb-3">
<label>Alamat</label>
<textarea name="alamat" rows="3" class="form-control" required><?= htmlspecialchars($data['alamat']) ?></textarea>
</div>

</div>

<div class="d-flex justify-content-end gap-2">

<a href="admin.php" class="btn btn-secondary">
<i class="bi bi-arrow-left"></i>
Kembali
</a>

<button type="submit" name="update" class="btn btn-warning">
<i class="bi bi-floppy"></i>
Update
</button>

</div>
</form>
</div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>