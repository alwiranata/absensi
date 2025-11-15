<?php
include __DIR__ . '/../../config/db.php';

if (isset($_POST['id_user'], $_POST['nama'], $_POST['username'], $_POST['role'])) {

    $id_user  = intval($_POST['id_user']);
    $nama     = $_POST['nama'];
    $username = $_POST['username'];
    $role     = $_POST['role'];
    $password = $_POST['password'];

    // ===============================
    // CEK DUPLIKAT USERNAME
    // ===============================
    $check = $conn->prepare("SELECT id_user FROM users WHERE username = ? AND id_user != ?");
    $check->bind_param("si", $username, $id_user);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "<script>
            alert('Username sudah digunakan, pilih username lain!');
            window.history.back();
        </script>";
        exit;
    }

    // ===============================
    // UPDATE DATA
    // ===============================

    if (!empty($password)) {
        // Jika password diubah
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET nama=?, username=?, role=?, password=? WHERE id_user=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $nama, $username, $role, $hashed, $id_user);

    } else {
        // Jika password tidak diganti
        $sql = "UPDATE users SET nama=?, username=?, role=? WHERE id_user=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $nama, $username, $role, $id_user);
    }

    if ($stmt->execute()) {
        echo "<script>
            alert('User berhasil diperbarui!');
            window.location='../../dashboard.php?page=profile';
        </script>";
    } else {
        echo "Gagal update user: " . $stmt->error;
    }

} else {
    echo "<script>alert('Form belum lengkap!'); window.history.back();</script>";
}
