<?php
include __DIR__ . '/../../config/db.php';

if (isset($_POST['id_user'], $_POST['nama'], $_POST['username'], $_POST['password'], $_POST['role'])) {

    $id_user  = intval($_POST['id_user']);
    $nama     = $_POST['nama'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // hash password
    $role     = $_POST['role'];

    // ============================
    // VALIDASI DUPLIKAT ID_USER
    // ============================
    $check_id = $conn->prepare("SELECT id_user FROM users WHERE id_user = ?");
    $check_id->bind_param("i", $id_user);
    $check_id->execute();
    $check_id->store_result();

    if ($check_id->num_rows > 0) {
        echo "<script>
            alert('ID User $id_user sudah ada di database! Silakan gunakan ID lain.');
            window.history.back();
        </script>";
        exit;
    }

    // ============================
    // VALIDASI DUPLIKAT USERNAME
    // ============================
    $check_username = $conn->prepare("SELECT username FROM users WHERE username = ?");
    $check_username->bind_param("s", $username);
    $check_username->execute();
    $check_username->store_result();

    if ($check_username->num_rows > ) {
        echo "<script>
            alert('Username $username sudah digunakan! Silakan pilih username lain.');
            window.history.back();
        </script>";
        exit;
    }

    // ============================
    // INSERT DATA USER
    // ============================
    $stmt = $conn->prepare("INSERT INTO users (id_user, nama, username, password, role) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $id_user, $nama, $username, $password, $role);

    if ($stmt->execute()) {
        echo "<script>
            alert('User berhasil ditambahkan');
            window.location='../../dashboard.php?page=add_user';
        </script>";
    } else {
        echo "Gagal menambahkan user: " . $stmt->error;
    }

} else {
    echo "<script>alert('Form belum lengkap'); window.history.back();</script>";
}
?>
