<?php
include __DIR__ . '/../../config/db.php';

$id_user = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id_user <= 0) {
    die("ID user tidak valid.");
}

// Ambil nama user
$user = $conn->query("SELECT nama FROM users WHERE id_user = $id_user")->fetch_assoc();
$nama_user = $user['nama'] ?? 'Unknown';

// Nama file
$filename = "absensi_user_{$id_user}.xls";

// Header supaya browser mendownload
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$filename\"");

echo '<table border="1" cellpadding="5" cellspacing="0">';
echo '<tr">';
echo "<th style='background-color: #E99724; color:white;'>Id User</th>";
echo "<th style='background-color: #E99724; color:white;'>Nama</th>";
echo "<th style='background-color: #E99724; color:white;'>Tanggal</th>";
echo "<th style='background-color: #E99724; color:white;'>Jam Masuk</th>";
echo "<th style='background-color: #E99724; color:white;'>Jam Pulang</th>";
echo "<th style='background-color: #E99724; color:white;'>Scan Masuk</th>";
echo "<th style='background-color: #E99724; color:white;'>Scan Keluar</th>";
echo "<th style='background-color: #E99724; color:white;'>Terlambat</th>";
echo "<th style='background-color: #E99724; color:white;'>Pulang Cepat</th>";
echo "<th style='background-color: #E99724; color:white;'>Lembur</th>";
echo "<th style='background-color: #E99724; color:white;'>Jumlah Hadir</th>";
echo "<th style='background-color: #E99724; color:white;'>Pengecualian</th>";
echo '</tr>';

// Ambil data absensi
$stmt = $conn->prepare("
    SELECT id_user, tanggal, jam_masuk, jam_pulang, scan_masuk, scan_keluar,
           terlambat, pulang_cepat, lembur, jml_hadir, pengecualian
    FROM absensi
    WHERE id_user = ?
    ORDER BY tanggal ASC
");
$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result();

// Tulis data
while ($row = $result->fetch_assoc()) {
    echo '<tr>';
    echo "<td>{$row['id_user']}</td>";
    echo "<td>{$nama_user}</td>";
    echo "<td>{$row['tanggal']}</td>";
    echo "<td>{$row['jam_masuk']}</td>";
    echo "<td>{$row['jam_pulang']}</td>";
    echo "<td>{$row['scan_masuk']}</td>";
    echo "<td>{$row['scan_keluar']}</td>";
    echo "<td>{$row['terlambat']}</td>";
    echo "<td>{$row['pulang_cepat']}</td>";
    echo "<td>{$row['lembur']}</td>";
    echo "<td>{$row['jml_hadir']}</td>";
    echo "<td>{$row['pengecualian']}</td>";
    echo '</tr>';
}

echo '</table>';
exit;
