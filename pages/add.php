<?php
if (!isset($_GET['id'])) {
    echo "<h3 class='text-red-500'>Parameter user tidak lengkap!</h3>";
    exit;
}

$id_user = $_GET['id'];
?>

<h1 class="text-2xl font-semibold mb-5">
    Tambah Absensi • User ID <?= $id_user ?>
</h1>

<form method="POST" action="pages/absensi/insert_absen.php">

    <input type="hidden" name="id_user" value="<?= $id_user ?>">

    <div class="mb-4">
        <label>Tanggal</label>
        <input type="date" name="tanggal" class="border p-2 w-full rounded" required>
    </div>

    <div class="mb-4">
        <label>Jam Masuk</label>
        <input type="time" name="jam_masuk" class="border p-2 w-full rounded" required>
    </div>

    <div class="mb-4">
        <label>Jam Pulang</label>
        <input type="time" name="jam_pulang" class="border p-2 w-full rounded">
    </div>

    <div class="mb-4">
        <label>Scan Masuk</label>
        <input type="time" name="scan_masuk" class="border p-2 w-full rounded">
    </div>

    <div class="mb-4">
        <label>Scan Keluar</label>
        <input type="time" name="scan_keluar" class="border p-2 w-full rounded">
    </div>

    <div class="mb-4">
        <label>Terlambat</label>
        <input type="time" name="terlambat" class="border p-2 w-full rounded">
    </div>

    <div class="mb-4">
        <label>Pulang Cepat</label>
        <input type="time" name="pulang_cepat" class="border p-2 w-full rounded">
    </div>

    <div class="mb-4">
        <label>Lembur</label>
        <input type="time" name="lembur" class="border p-2 w-full rounded">
    </div>

    <div class="mb-4">
        <label>Jumlah Hadir</label>
        <input type="time" name="jml_hadir" class="border p-2 w-full rounded">
    </div>

    <div class="mb-4">
        <label>Pengecualian</label>
        <input type="text" name="pengecualian" class="border p-2 w-full rounded">
    </div>

    <button type="submit" class="px-4 py-2 bg-[#E99724] text-white rounded">
        Tambah
    </button>

    <a href="dashboard.php?page=detail&id=<?= $id_user ?>" class="px-4 py-2 bg-gray-400 rounded">
        Batal
    </a>

</form>