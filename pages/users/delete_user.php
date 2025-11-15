<?php
include "../../config/db.php";

if (!isset($_GET['id'])) {
    echo "<script>alert('ID User tidak ditemukan!'); window.history.back();</script>";
    exit;
}

$id_user = intval($_GET['id']);

// Hapus user menggunakan prepared statement
$stmt = $conn->prepare("DELETE FROM users WHERE id_user = ?");
$stmt->bind_param("i", $id_user);

if ($stmt->execute()) {
    echo "<script>
        alert('User berhasil dihapus!');
        window.location='../../dashboard.php?page=profile';
    </script>";
} else {
    echo "<script>
        alert('Gagal menghapus user!');
        window.location='../../dashboard.php?page=profile';
    </script>";
}
