<?php
include "koneksi.php";

$total = $conn->query("SELECT COUNT(*) FROM registrasi_pasien")->fetchColumn();
$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : "";

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
ON r.kode_poliklinik = p.kode_poliklinik";

if ($keyword != "") {
    $sql .= "
    WHERE
        r.no_pendaftaran LIKE :keyword OR
        r.no_rm LIKE :keyword OR
        r.nama_pasien LIKE :keyword";
}

$sql .= " ORDER BY r.id_registrasi ASC";

$stmt = $conn->prepare($sql);

if ($keyword != "") {
    $stmt->bindValue(":keyword", "%".$keyword."%");
}

$stmt->execute();

// $total = $stmt->rowCount();
?>

<!DOCTYPE html>
<html lang="id">

<head>
<meta charset="UTF-8">
<title>Data Admin</title>

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
    white-space:nowrap;
}

.title{
    color:#0d6efd;
    font-weight:bold;
}

.badge{
    font-size:13px;
}

.alert{
    height:38px;
    display:flex;
    align-items:center;
    padding:0 20px;
    margin-bottom:0;
}
</style>

</head>

<body>

<div class="container py-5">

<div class="card">

<div class="card-body">

<div class="d-flex justify-content-between align-items-center mb-4">

<h2 class="title">
<i class="bi bi-person-gear"></i>
Data Admin
</h2>

<div>

<a href="dashboard.php" class="btn btn-secondary">
<i class="bi bi-house"></i>
Dashboard
</a>

<a href="admin_add.php" class="btn btn-success">
<i class="bi bi-person-plus"></i>
Tambah Pasien
</a>

</div>

</div>

<div class="row mb-4">

<div class="col-md-6">

<div class="alert alert-primary mb-0">
<b>Total Data :  <?= $total ?> Pasien </b>
</div>

</div>

<div class="col-md-6">

<form method="GET">

<div class="input-group">

<input
type="text"
name="keyword"
class="form-control"
placeholder="Cari No RM / No Pendaftaran / Nama..."
value="<?= htmlspecialchars($keyword) ?>">

<button class="btn btn-primary">
<i class="bi bi-search"></i>
Cari
</button>

<?php if($keyword!=""){ ?>

<a href="admin.php" class="btn btn-outline-secondary">
Reset
</a>

<?php } ?>

</div>

</form>

</div>

</div>

<div class="table-responsive">

<table class="table table-bordered table-hover table-striped">

<thead>

<tr>

<th width="120">Aksi</th>
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

while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
?>

<tr>
<td class="text-center">
<a href="admin_update.php?id=<?= $row['id_registrasi'] ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
<a href="admin_delete.php?id=<?= $row['id_registrasi'] ?>" class="btn btn-danger btn-sm btn-hapus"><i class="bi bi-trash"></i></a>
</td>
<td><?= $no++; ?></td>
<td><?= htmlspecialchars($row['no_pendaftaran']) ?></td>
<td><?= htmlspecialchars($row['no_rm']) ?></td>
<td><?= htmlspecialchars($row['nama_pasien']) ?></td>
<td class="text-center">
<?php if($row['jenis_kelamin']=="L"){ ?>
<span class="badge bg-primary">L</span>
<?php }else{ ?>
<span class="badge bg-danger">P</span>
<?php } ?>
</td>
<td><?= date('d-m-Y',strtotime($row['tgl_lahir'])) ?></td>
<td><?= htmlspecialchars($row['nama_poliklinik']) ?></td>
<td><?= htmlspecialchars($row['alamat']) ?></td>
<td><?= date('d-m-Y H:i',strtotime($row['tgl_pendaftaran'])) ?></td>
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

<script>
document.querySelectorAll(".btn-hapus").forEach(function(btn){
btn.addEventListener("click",function(e){
e.preventDefault();
let url=this.href;
Swal.fire({
title:"Hapus Data?",
text:"Data pasien akan dihapus permanen.",
icon:"warning",
showCancelButton:true,
confirmButtonColor:"#dc3545",
cancelButtonColor:"#6c757d",
confirmButtonText:"Ya, Hapus",
cancelButtonText:"Batal"
}).then((result)=>{
if(result.isConfirmed){
window.location=url;
}
});
});
});
</script>

<?php if(isset($_GET['tambah'])){ ?>
<script>
Swal.fire({
icon:"success",
title:"Berhasil",
text:"Data pasien berhasil ditambahkan.",
confirmButtonColor:"#198754"
});
</script>
<?php } ?>

<?php if(isset($_GET['update'])){ ?>
<script>
Swal.fire({
icon:"success",
title:"Berhasil",
text:"Data pasien berhasil diperbarui.",
confirmButtonColor:"#198754"
});
</script>
<?php } ?>

<?php if(isset($_GET['hapus'])){ ?>
<script>
Swal.fire({
icon:"success",
title:"Berhasil",
text:"Data pasien berhasil dihapus.",
confirmButtonColor:"#198754"
});
</script>
<?php } ?>

</body>
</html>