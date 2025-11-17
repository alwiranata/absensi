<?php
include __DIR__ . '../../config/db.php';

if (!isset($_GET['id'])) {
    echo "<h3 class='text-red-500 text-xl'>Parameter ID tidak ada!</h3>";
    exit;
}

$id_user = intval($_GET['id']);

// Ambil data user
$query = $conn->prepare("SELECT * FROM users WHERE id_user = ?");
$query->bind_param("i", $id_user);
$query->execute();
$result = $query->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    echo "<h3 class='text-red-500'>User tidak ditemukan!</h3>";
    exit;
}
?>

<h1 class="text-2xl font-semibold mb-5">
    Edit User
</h1>

<form method="POST" action="pages/users/update_user.php">

    <input type="hidden" name="id_user" value="<?= $data['id_user'] ?>">

    <div class="mb-4">
        <label>Nama</label>
        <input type="text" name="nama" value="<?= $data['nama'] ?>"
            class="border p-2 w-full rounded" required>
    </div>

    <div class="mb-4">
        <label>Username</label>
        <input type="text" name="username" value="<?= $data['username'] ?>"
            class="border p-2 w-full rounded">
    </div>

    <div class="mb-4">
        <label>Password (kosongkan jika tidak diganti)</label>
        <input type="password" name="password" class="border p-2 w-full rounded">
    </div>

    <div class="mb-4">
        <label>Role</label>
        <select name="role" class="border p-2 w-full rounded">
            <option value="admin" <?= $data['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
            <option value="user" <?= $data['role'] == 'user' ? 'selected' : '' ?>>User</option>
        </select>
    </div>

    <button type="submit" class="px-4 py-2 bg-[#E99724] text-white rounded">
        Simpan
    </button>

    <a href="dashboard.php?page=profile" class="px-4 py-2 bg-gray-400 rounded">
        Batal
    </a>

</form>