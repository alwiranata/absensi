<?php
include "../../config/db.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "<script>alert('Akses tidak valid'); window.history.back();</script>";
    exit;
}

$id_user      = $_POST['id_user'] ?? '';
$tanggal      = $_POST['tanggal'] ?? '';
$jam_masuk    = $_POST['jam_masuk'] ?? '';
$jam_pulang   = $_POST['jam_pulang'] ?? '';
$scan_masuk   = $_POST['scan_masuk'] ?? '';
$scan_keluar  = $_POST['scan_keluar'] ?? '';
$terlambat    = $_POST['terlambat'] ?? '';
$pulang_cepat = $_POST['pulang_cepat'] ?? '';
$lembur       = $_POST['lembur'] ?? '';
$jml_hadir    = $_POST['jml_hadir'] ?? '';
$pengecualian = $_POST['pengecualian'] ?? '';

// Insert menggunakan prepared statement
$stmt = $conn->prepare("INSERT INTO absensi (id_user, tanggal, jam_masuk, jam_pulang, scan_masuk, scan_keluar, terlambat, pulang_cepat, lembur, jml_hadir, pengecualian)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("issssssssss", $id_user, $tanggal, $jam_masuk, $jam_pulang, $scan_masuk, $scan_keluar, $terlambat, $pulang_cepat, $lembur, $jml_hadir, $pengecualian);

$success = $stmt->execute();
$stmt->close();

if ($success) {
    echo "<script>
        alert('Data absensi berhasil ditambahkan!');
        window.location='../../dashboard.php?page=detail&id=$id_user';
    </script>";
} else {
    echo "<script>
        alert('Gagal menambahkan data: " . $conn->error . "');
        window.history.back();
    </script>";
}
