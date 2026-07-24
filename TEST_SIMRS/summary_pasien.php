<?php
include "koneksi.php";

$sql = "SELECT * FROM poli";
$query = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Pasien</title>

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

        .table th{
            background:#0d6efd;
            color:white;
            white-space:nowrap;
        }

        .table td{
            vertical-align:middle;
            white-space:nowrap;
        }

        h2{
            font-weight:bold;
        }

        .badge{
            font-size:13px;
        }
    </style>

</head>

<body>

<div class="container py-5">

<div class="card">

<div class="card-body">

<div class="d-flex justify-content-between align-items-center mb-4">

<h2>📋 Data Poliklinik</h2>

<a href="tambah.php" class="btn btn-primary">
    + Tambah Pasien
</a>

</div>

<div class="table-responsive">

<table class="table table-bordered table-hover table-striped align-middle">

<thead>

<tr>

<th>No</th>
<th>Poliklinik</th>
<th>Jumlah Pasien</th>

</tr>

</thead>

<tbody>

<?php
$no=1;

while($row=$query->fetch(PDO::FETCH_ASSOC)){
?>

<tr>

<td><?= $no++ ?></td>

<td><?= htmlspecialchars($row['nama_poli']) ?></td>

<td><?= htmlspecialchars($row['jumlah_pasien']) ?></td>
</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

</div>

</body>

</html>