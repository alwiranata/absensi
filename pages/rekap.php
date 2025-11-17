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

// ======================
// FUNGSI & VARIABLE TOTAL
// ======================

$total_terlambat = 0;
$total_pulang_cepat = 0;
$total_lembur = 0;
$total_hadir = 0;

// ubah HH:MM jadi menit
function toMinutes($time)
{
    if (!$time || $time == "00:00" || $time == "") return 0;
    $ex = explode(":", $time);
    return ($ex[0] * 60) + $ex[1];
}

// ubah menit ke HH:MM
function toHHMM($minutes)
{
    return sprintf("%02d:%02d", floor($minutes / 60), $minutes % 60);
}

// =======================
// PROSES HITUNG TOTAL
// =======================
while ($row = $result->fetch_assoc()) {

    // Hitung total terlambat
    $total_terlambat += toMinutes(substr($row['terlambat'], 0, 5));

    // Hitung total pulang cepat
    $total_pulang_cepat += toMinutes(substr($row['pulang_cepat'], 0, 5));

    // Hitung total lembur
    $total_lembur += toMinutes(substr($row['lembur'], 0, 5));

    if (!empty($row['jml_hadir']) && $row['jml_hadir'] != "00:00") {
        $total_hadir++;
    }
}

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail Absensi</title>
    <link rel="stylesheet" href="https://cdn.tailwindcss.com">
</head>

<body>

    <h1 class="text-2xl font-semibold mb-5">
        Rekap Absensi • <span class="text-[#E99724]"><?= $user['nama'] ?></span>
    </h1>

    <div class=" w-[400px]">

        <table class="w-full border-collapse rounded-xl overflow-hidden shadow">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-3 text-left">Keterangan</th>
                    <th class="p-3 text-center">Total</th>
                </tr>
            </thead>

            <tbody>
                <tr class="border-b">
                    <td class="p-3">Total Terlambat</td>
                    <td class="p-3 text-center"><?= toHHMM($total_terlambat) ?></td>
                </tr>

                <tr class="border-b">
                    <td class="p-3">Total Pulang Cepat</td>
                    <td class="p-3 text-center"><?= toHHMM($total_pulang_cepat) ?></td>
                </tr>

                <tr class="border-b">
                    <td class="p-3">Total Lembur</td>
                    <td class="p-3 text-center"><?= toHHMM($total_lembur) ?></td>
                </tr>

                <tr class="border-b">
                    <td class="p-3">Total Hadir</td>
                    <td class="p-3 text-center"><?= $total_hadir ?> Hari</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="mt-5">
        <a href="dashboard.php?page=absensi"
            class="px-4 py-2 bg-gray-300 rounded">
            Kembali
        </a>
    </div>
</body>

</html>