<?php
// Pastikan ID user dikirim
if (!isset($_GET['id'])) {
    echo "<h3 class='text-red-500 text-xl'>ID User tidak ditemukan!</h3>";
    exit;
}

$id_user = $_GET['id'];

// Ambil nama user
$user = $conn->query("SELECT nama FROM users WHERE id_user = '$id_user'")->fetch_assoc();

// Ambil data absensi lengkap
$query = "SELECT * FROM absensi WHERE id_user = '$id_user' ORDER BY id_absensi ASC";
$result = $conn->query($query);
?>

<h1 class="text-2xl font-semibold mb-5">
    Detail Absensi • <span class="text-[#E99724]"><?= $user['nama'] ?></span>
</h1>

<table class="w-full border-collapse rounded-xl overflow-hidden shadow">
    <thead>
        <tr class="bg-gray-200 text-left">
            <th class="p-3 text-center">Tgl</th>
            <th class="p-3">Jam Masuk</th>
            <th class="p-3">Jam Pulang</th>
            <th class="p-3">Scan Masuk</th>
            <th class="p-3">Scan Keluar</th>
            <th class="p-3">Terlambat</th>
            <th class="p-3">Plg Cpt</th>
            <th class="p-3">Lembur</th>
            <th class="p-3">Jml Hadir</th>
            <th class="p-3">Pengecualian</th>
            <th class="p-3 text-center">Aksi</th>
        </tr>
    </thead>

    <tbody>
        <?php if ($result->num_rows == 0) { ?>
            <tr>
                <td colspan="12" class="p-4 text-center text-gray-500">Tidak ada data absensi.</td>
            </tr>
        <?php } ?>

        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr class="border-b hover:bg-gray-50">

                <td class="p-3 w-[150px] text-center"><?= $row['tanggal'] ?></td>
                <td class="p-3"><?= substr($row['jam_masuk'], 0, 5) ?></td>
                <td class="p-3"><?= substr($row['jam_pulang'], 0, 5) ?></td>
                <td class="p-3"><?= substr($row['scan_masuk'], 0, 5) ?></td>
                <td class="p-3"><?= substr($row['scan_keluar'], 0, 5) ?></td>
                <td class="p-3"><?= substr($row['terlambat'], 0, 5) ?></td>
                <td class="p-3"><?= substr($row['pulang_cepat'], 0, 5) ?></td>
                <td class="p-3"><?= substr($row['lembur'], 0, 5) ?></td>
                <td class="p-3"><?= substr($row['jml_hadir'], 0, 5) ?></td>
                <td class="p-3"><?= $row['pengecualian'] ?></td>

                <!-- AKSI -->
                <td class="p-3 flex justify-center gap-2">

                    <!-- Edit -->
                    <a href="dashboard.php?page=edit&id=<?= $row['id_absensi'] ?>&user=<?= $id_user ?>"
                        class="w-[30px] h-[30px] flex items-center justify-center 
                        rounded-md border border-green-500 text-green-600">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325" />
                        </svg>
                    </a>

                    <!-- Delete -->
                    <button
                        onclick="openDeleteModal(<?= $row['id_absensi'] ?>)"
                        class="w-[30px] h-[30px] flex items-center justify-center 
                        rounded-md border border-red-500 text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                            <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                        </svg>
                    </button>

                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<div class="mt-5">
    <a href="dashboard.php?page=absensi"
        class="px-4 py-2 bg-gray-300 rounded">
        Kembali
    </a>
</div>

<!-- Modal Delete -->
<div id="deleteModal" class="fixed inset-0  bg-opacity-50 hidden items-center justify-center">
    <div class="bg-white p-6 rounded-lg w-[350px] shadow-xl text-center">
        <p class="text-gray-600 mb-6">
            Hapus Absensi
            <span id="deleteId" class="font-bold text-red-600" hidden></span> ?
        </p>

        <div class="flex justify-center gap-3">
            <button onclick="closeDeleteModal()"
                class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                Batal
            </button>

            <a id="confirmDeleteBtn"
                class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                Hapus
            </a>
        </div>
    </div>
</div>

<script>
    function openDeleteModal(id_absensi) {
        document.getElementById("deleteId").textContent = id_absensi;

        // Kirim parameter yang benar
        document.getElementById("confirmDeleteBtn").href =
            "pages/absensi/delete_absen.php?id=" + id_absensi + "&user=<?= $id_user ?>";

        // Tampilkan modal
        const modal = document.getElementById("deleteModal");
        modal.classList.remove("hidden");
        modal.classList.add("flex");
    }

    function closeDeleteModal() {
        const modal = document.getElementById("deleteModal");
        modal.classList.add("hidden");
        modal.classList.remove("flex");
    }
</script>