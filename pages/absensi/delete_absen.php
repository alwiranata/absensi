<?php
include "../../config/db.php";

if (!isset($_GET['id']) || !isset($_GET['user'])) {
    echo "<script>alert('Parameter tidak lengkap'); window.history.back();</script>";
    exit;
}

$id_absensi = $_GET['id'];
$id_user    = $_GET['user'];

$delete = $conn->query("DELETE FROM absensi WHERE id_absensi='$id_absensi'");

if ($delete) {
    echo "<script>
        alert('Data berhasil dihapus!');
        window.location='../../dashboard.php?page=detail&id=$id_user';
    </script>";
} else {
    echo "<script>
        alert('Gagal menghapus data!');
           window.location='../../dashboard.php?page=detail&id=$id_user';
    </script>";
}
