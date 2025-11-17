<?php
if (!isset($_GET['id']) || !isset($_GET['user'])) {
    echo "<h3 class='text-red-500 text-xl'>Parameter tidak lengkap!</h3>";
    exit;
}

$id_absensi = $_GET['id'];
$id_user = $_GET['user'];

// Ambil data absensi
$query = $conn->query("SELECT * FROM absensi WHERE id_absensi = '$id_absensi' AND id_user = '$id_user'");
$data = $query->fetch_assoc();

if (!$data) {
    echo "<h3 class='text-red-500'>Data absensi tidak ditemukan!</h3>";
    exit;
}
?>

<h1 class="text-2xl font-semibold mb-5">
    Edit Absensi • ID <?= $id_absensi ?>
</h1>

<form method="POST" action="pages/absensi/update_absen.php">
    
    <input type="hidden" name="id_absensi" value="<?= $id_absensi ?>">
    <input type="hidden" name="id_user" value="<?= $id_user ?>">

    <div class="mb-4">
        <label>Tanggal</label>
        <input type="date" name="tanggal" value="<?= $data['tanggal'] ?>" class="border p-2 w-full rounded">
    </div>

    <div class="mb-4">
        <label>Jam Masuk</label>
        <input type="time" name="jam_masuk" value="<?= $data['jam_masuk'] ?>" class="border p-2 w-full rounded">
    </div>

    <div class="mb-4">
        <label>Jam Pulang</label>
        <input type="time" name="jam_pulang" value="<?= $data['jam_pulang'] ?>" class="border p-2 w-full rounded">
    </div>

    <div class="mb-4">
        <label>Scan Masuk</label>
        <input type="time" name="scan_masuk" value="<?= $data['scan_masuk'] ?>" class="border p-2 w-full rounded">
    </div>

    <div class="mb-4">
        <label>Scan Keluar</label>
        <input type="time" name="scan_keluar" value="<?= $data['scan_keluar'] ?>" class="border p-2 w-full rounded">
    </div>

    <div class="mb-4">
        <label>Terlambat</label>
        <input type="time" name="terlambat" value="<?= $data['terlambat'] ?>" class="border p-2 w-full rounded">
    </div>

    <div class="mb-4">
        <label>Pulang Cepat</label>
        <input type="time" name="pulang_cepat" value="<?= $data['pulang_cepat'] ?>" class="border p-2 w-full rounded">
    </div>

    <div class="mb-4">
        <label>Lembur</label>
        <input type="time" name="lembur" value="<?= $data['lembur'] ?>" class="border p-2 w-full rounded">
    </div>

    <div class="mb-4">
        <label>Jumlah Hadir</label>
        <input type="time" name="jml_hadir" value="<?= $data['jml_hadir'] ?>" class="border p-2 w-full rounded">
    </div>

    <div class="mb-4">
        <label>Pengecualian</label>
        <input type="text" name="pengecualian" value="<?= $data['pengecualian'] ?>" class="border p-2 w-full rounded">
    </div>

    <button type="submit" class="px-4 py-2 bg-[#E99724] text-white rounded">
        Simpan
    </button>

    <a href="dashboard.php?page=detail&id=<?= $id_user ?>" class="px-4 py-2 bg-gray-400 rounded">
        Batal
    </a>

</form>
