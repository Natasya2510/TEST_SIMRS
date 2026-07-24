<?php
include "koneksi.php";

$sqlSummary = "
SELECT
    p.nama_poliklinik,
    COUNT(r.id_registrasi) AS jumlah_pasien
FROM poliklinik p
LEFT JOIN registrasi_pasien r
ON p.kode_poliklinik = r.kode_poliklinik
GROUP BY p.nama_poliklinik
ORDER BY p.nama_poliklinik";

$summary = $conn->query($sqlSummary);

$sql = "
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
ON r.kode_poliklinik = p.kode_poliklinik
ORDER BY r.id_registrasi DESC";

$list = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">

<head>
<meta charset="UTF-8">
<title>Dashboard SIMRS</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

<style>
body{
    background:#eef2f7;
}

.card{
    border:none;
    border-radius:15px;
    box-shadow:0 5px 20px rgba(0,0,0,.08);
}

.table th{
    background:#0d6efd;
    color:#fff;
    text-align:center;
    white-space:nowrap;
}

.table td{
    vertical-align:middle;
}

.title{
    font-size:30px;
    font-weight:bold;
    color:#0d6efd;
}

.btn-lg{
    padding:12px 25px;
}
</style>

</head>

<body>

<div class="container py-5">

<div class="text-center mb-4">
<h1 class="title">
<i class="bi bi-hospital"></i>
SISTEM INFORMASI RUMAH SAKIT
</h1>
</div>

<div class="d-flex justify-content-center gap-3 mb-5">

<a href="registrasi_pasien.php" class="btn btn-success btn-lg">
<i class="bi bi-person-plus-fill"></i>
Registrasi Pasien
</a>

<a href="admin.php" class="btn btn-primary btn-lg">
<i class="bi bi-person-gear"></i>
Data Admin
</a>

</div>

<div class="card mb-5">

<div class="card-header bg-primary text-white">
<h5 class="mb-0">
<i class="bi bi-bar-chart-fill"></i>
Summary Pasien
</h5>
</div>

<div class="card-body">

<div class="table-responsive">

<table class="table table-bordered table-hover">

<thead>

<tr>
<th width="70">No</th>
<th>Poliklinik</th>
<th width="180">Jumlah Pasien</th>
</tr>

</thead>

<tbody>

<?php
$no = 1;

while($row = $summary->fetch(PDO::FETCH_ASSOC)){
?>

<tr>

<td class="text-center">
<?= $no++; ?>
</td>

<td>
<?= htmlspecialchars($row['nama_poliklinik']) ?>
</td>

<td class="text-center">
<span class="badge bg-success fs-6">
<?= $row['jumlah_pasien'] ?>
</span>
</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

<div class="card">

<div class="card-header bg-primary text-white">
<h5 class="mb-0">
<i class="bi bi-people-fill"></i>
List Registrasi Pasien
</h5>
</div>

<div class="card-body">

<div class="table-responsive">

<table class="table table-striped table-hover table-bordered">

<thead>

<tr>
<th>No</th>
<th>No Pendaftaran</th>
<th>No RM</th>
<th>Nama Pasien</th>
<th>JK</th>
<th>Tgl Lahir</th>
<th>Poliklinik</th>
<th>Alamat</th>
<th>Tgl Daftar</th>
</tr>

</thead>

<tbody>

<?php
$no = 1;

while($row = $list->fetch(PDO::FETCH_ASSOC)){
?>

<tr>

<td><?= $no++; ?></td>

<td><?= htmlspecialchars($row['no_pendaftaran']) ?></td>

<td><?= htmlspecialchars($row['no_rm']) ?></td>

<td><?= htmlspecialchars($row['nama_pasien']) ?></td>

<td class="text-center">

<?php
if($row['jenis_kelamin'] == "L"){
    echo "<span class='badge bg-primary'>L</span>";
}else{
    echo "<span class='badge bg-danger'>P</span>";
}
?>

</td>

<td><?= date('d-m-Y', strtotime($row['tgl_lahir'])) ?></td>

<td><?= htmlspecialchars($row['nama_poliklinik']) ?></td>

<td><?= htmlspecialchars($row['alamat']) ?></td>

<td><?= date('d-m-Y H:i', strtotime($row['tgl_pendaftaran'])) ?></td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if(isset($_GET['success'])){ ?>

<script>
Swal.fire({
    icon: 'success',
    title: 'Registrasi Berhasil',
    text: 'Pasien berhasil didaftarkan.',
    confirmButtonColor: '#198754'
});
</script>

<?php } ?>

</body>

</html>