<?php
include "koneksi.php";

/* ============================
   Generate No. Pendaftaran
============================ */

$sql = "SELECT MAX(no_pendaftaran) AS no_terakhir
        FROM registrasi_pasien";
$stmt = $conn->query($sql);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if ($data['no_terakhir'] == NULL) {
    $no_pendaftaran = "000001";
} else {
    $urut = (int)$data['no_terakhir'];
    $urut++;
    $no_pendaftaran = str_pad($urut, 6, "0", STR_PAD_LEFT);
}

/* ============================
   Data Poliklinik
============================ */

$sqlPoli = "SELECT * FROM poliklinik ORDER BY nama_poliklinik";
$poli = $conn->query($sqlPoli);

/* ============================
   Simpan Registrasi
============================ */

if (isset($_POST['simpan'])) {

    $cek = $conn->prepare("
        SELECT COUNT(*) 
        FROM registrasi_pasien
        WHERE no_rm=?
    ");

    $cek->execute([
        $_POST['no_rm']
    ]);

    if ($cek->fetchColumn() > 0) {

        $error = "No Rekam Medis sudah terdaftar.";

    } else {

        $stmt = $conn->prepare("
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
        ");

        $stmt->execute([
            $no_pendaftaran,
            $_POST['no_rm'],
            $_POST['nama_pasien'],
            $_POST['jenis_kelamin'],
            $_POST['tgl_lahir'],
            $_POST['kode_poliklinik'],
            $_POST['alamat']
        ]);

        header("Location: dashboard.php?success=1");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
<meta charset="UTF-8">
<title>Registrasi Pasien</title>
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

.card-header{
    background:#198754;
    color:white;
    font-size:24px;
    font-weight:bold;
}

label{
    font-weight:600;
}

.btn{
    min-width:130px;
}

</style>

</head>

<body>

<div class="container py-5">

<div class="card">

<div class="card-header">
<i class="bi bi-person-plus-fill"></i>
Registrasi Pasien
</div>

<div class="card-body">

<?php if(isset($error)){ ?>
<div class="alert alert-danger alert-dismissible fade show">
    <?= $error ?>
    <button class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php } ?>

<form method="POST">

<div class="row">

<div class="col-md-6 mb-3">
<label>No. Pendaftaran</label>
<input type="text" name="no_pendaftaran" class="form-control" value="<?= $no_pendaftaran ?>" readonly>
</div>

<div class="col-md-6 mb-3">
<label>No. Rekam Medis</label>
<input type="text" name="no_rm" class="form-control" required autofocus>
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
<?php while($rowPoli=$poli->fetch(PDO::FETCH_ASSOC)){ ?>
<option value="<?= $rowPoli['kode_poliklinik'] ?>">
    <?= htmlspecialchars($rowPoli['nama_poliklinik']) ?>
</option>
<?php } ?>
</select>
</div>

<div class="col-12 mb-3">
<label>Alamat</label>
<textarea name="alamat" class="form-control" rows="3" required></textarea>
</div>

</div>

<div class="d-flex justify-content-end gap-2">

<a href="dashboard.php" class="btn btn-secondary">
<i class="bi bi-arrow-left"></i>
Kembali
</a>

<button type="submit" name="simpan" class="btn btn-success">
<i class="bi bi-save"></i>
Simpan
</button>
</div>
</form>
</div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script></body>
</html>