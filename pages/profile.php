<?php
// Koneksi database
include __DIR__ . '../../config/db.php';

// Proses delete
if (isset($_GET['delete'])) {
    $id_delete = intval($_GET['delete']);
    $conn->query("DELETE FROM users WHERE id_user = $id_delete");
    echo "<script>alert('User berhasil dihapus'); window.location='dashboard.php?page=users';</script>";
}

// Proses add / edit
if (isset($_POST['save_user'])) {
    $id_user = intval($_POST['id_user'] ?? 0);
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // hash password
    $role = $_POST['role'];

    if ($id_user > 0) {
        // Edit
        $stmt = $conn->prepare("UPDATE users SET nama=?, username=?, password=?, role=? WHERE id_user=?");
        $stmt->bind_param("ssssi", $nama, $username, $password, $role, $id_user);
        $stmt->execute();
        echo "<script>alert('User berhasil diupdate'); window.location='dashboard.php?page=users';</script>";
    } else {
        // Add
        $stmt = $conn->prepare("INSERT INTO users (nama, username, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nama, $username, $password, $role);
        $stmt->execute();
        echo "<script>alert('User berhasil ditambahkan'); window.location='dashboard.php?page=users';</script>";
    }
}

// Ambil data user untuk tabel
$data = $conn->query("SELECT * FROM users ORDER BY id_user ASC");
?>



<a href="dashboard.php?page=add_user"
    class="px-4 py-2 bg-[#E99724] text-white rounded-full mb-4 inline-block">+ Tambah User
</a>


<table class="w-full border-collapse rounded-xl overflow-hidden">
    <thead>
        <tr class="bg-gray-200 text-left">
            <th class="p-3">Id</th>
            <th class="p-3">Nama</th>
            <th class="p-3">Username</th>
            <th class="p-3">Role</th>
            <th class="p-3 text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $data->fetch_assoc()) { ?>
            <tr class="border-b hover:bg-gray-50">
                <td class="p-3"><?= $row['id_user'] ?></td>
                <td class="p-3"><?= $row['nama'] ?></td>
                <td class="p-3"><?= $row['username'] ?></td>
                <td class="p-3"><?= $row['role'] ?></td>
                <td class="p-3 flex justify-center gap-2">
                    <!-- Edit -->
                    <a href="dashboard.php?page=edit_user&id=<?= $row['id_user'] ?>"
                        class="w-[30px] h-[30px] flex items-center justify-center rounded-md border border-green-500 text-green-600 font-bold">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325" />
                        </svg>
                    </a>

                    <!-- Delete User -->
                    <button
                        onclick="openDeleteUserModal(<?= $row['id_user'] ?>)"
                        class="w-[30px] h-[30px] flex items-center justify-center rounded-md border border-red-500 text-red-600 font-bold">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                            <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1z" />
                        </svg>
                    </button>

                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<!-- Modal Delete User -->
<div id="deleteUserModal" class="fixed inset-0 bg-opacity-50 hidden items-center justify-center">
    <div class="bg-white p-6 rounded-lg w-[350px] shadow-xl text-center">
        <p class="text-gray-600 mb-6">
            Hapus User
            <span id="deleteUserId" class="font-bold text-red-600"></span> ?
        </p>

        <div class="flex justify-center gap-3">
            <button onclick="closeDeleteUserModal()"
                class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                Batal
            </button>

            <a id="confirmDeleteUserBtn"
                class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                Hapus
            </a>
        </div>
    </div>
</div>

<script>
    function openDeleteUserModal(id_user) {
        // Tampilkan ID user di modal
        document.getElementById("deleteUserId").textContent = id_user;

        // Set href tombol Hapus sesuai id_user
        document.getElementById("confirmDeleteUserBtn").href =
            "pages/users/delete_user.php?id=" + id_user;

        // Tampilkan modal
        const modal = document.getElementById("deleteUserModal");
        modal.classList.remove("hidden");
        modal.classList.add("flex");
    }

    function closeDeleteUserModal() {
        // Sembunyikan modal
        const modal = document.getElementById("deleteUserModal");
        modal.classList.add("hidden");
        modal.classList.remove("flex");
    }
</script>