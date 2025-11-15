<?php
include '../../config/db.php';

$id_absensi = $_POST['id_absensi'];
$id_user = $_POST['id_user'];

$tanggal = $_POST['tanggal'];
$jam_masuk = $_POST['jam_masuk'];
$jam_pulang = $_POST['jam_pulang'];
$scan_masuk = $_POST['scan_masuk'];
$scan_keluar = $_POST['scan_keluar'];
$terlambat = $_POST['terlambat'];
$pulang_cepat = $_POST['pulang_cepat'];
$lembur = $_POST['lembur'];
$jml_hadir = $_POST['jml_hadir'];
$pengecualian = $_POST['pengecualian'];

$update = "
UPDATE absensi SET 
    tanggal = '$tanggal',
    jam_masuk = '$jam_masuk',
    jam_pulang = '$jam_pulang',
    scan_masuk = '$scan_masuk',
    scan_keluar = '$scan_keluar',
    terlambat = '$terlambat',
    pulang_cepat = '$pulang_cepat',
    lembur = '$lembur',
    jml_hadir = '$jml_hadir',
    pengecualian = '$pengecualian'
WHERE id_absensi = '$id_absensi' AND id_user = '$id_user'
";

$conn->query($update);
if ($update){
    echo "<script>
        alert('Data berhasil diperbarui')
        window.location='../../dashboard.php?page=detail&id=$id_user';
    </script>";
} else {
    echo "<script>
        alert('Data gagal diperbarui')
        window.location='../../dashboard.php?page=detail&id=$id_user';
    </script>";
}

