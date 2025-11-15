<?php
require __DIR__ . '/../../vendor/autoload.php'; // pastikan sudah install PhpSpreadsheet via composer

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include __DIR__ . '/../../config/db.php';

$id_user = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id_user <= 0) {
    die("ID user tidak valid.");
}

// Ambil nama user
$user = $conn->query("SELECT nama FROM users WHERE id_user = $id_user")->fetch_assoc();
$nama_user = $user['nama'] ?? 'Unknown';

// Buat spreadsheet baru
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Header kolom
$sheet->fromArray([
    "id_user","nama","tanggal","jam_masuk","jam_pulang","scan_masuk","scan_keluar",
    "terlambat","pulang_cepat","lembur","jml_hadir","pengecualian"
], NULL, 'A1');

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

// Mulai dari baris 2
$rowIndex = 2;
while ($row = $result->fetch_assoc()) {
    $sheet->setCellValue("A$rowIndex", $row['id_user']);
    $sheet->setCellValue("B$rowIndex", $nama_user);
    $sheet->setCellValue("C$rowIndex", $row['tanggal']);
    $sheet->setCellValue("D$rowIndex", $row['jam_masuk']);
    $sheet->setCellValue("E$rowIndex", $row['jam_pulang']);
    $sheet->setCellValue("F$rowIndex", $row['scan_masuk']);
    $sheet->setCellValue("G$rowIndex", $row['scan_keluar']);
    $sheet->setCellValue("H$rowIndex", $row['terlambat']);
    $sheet->setCellValue("I$rowIndex", $row['pulang_cepat']);
    $sheet->setCellValue("J$rowIndex", $row['lembur']);
    $sheet->setCellValue("K$rowIndex", $row['jml_hadir']);
    $sheet->setCellValue("L$rowIndex", $row['pengecualian']);
    $rowIndex++;
}

// Set header supaya bisa download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=absensi_user_{$id_user}.xlsx");

$writer = new Xlsx($spreadsheet);
$writer->save("php://output");
exit;
