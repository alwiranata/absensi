<?php
// Koneksi database
include __DIR__ . '../../config/db.php';

// Ambil id_user dari URL
$id_user_get = isset($_GET['id']) ? intval($_GET['id']) : null;

if (!$id_user_get) {
    die("ID User tidak ditemukan di URL. Contoh: import.php?id=2");
}

if (isset($_POST['submit'])) {

    if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != '') {

        $file_name = $_FILES['file']['tmp_name'];

        if (($handle = fopen($file_name, "r")) !== FALSE) {

            $row = 0;
            $success = 0;
            $failed = 0;
            $skipped = 0;

            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                // Skip header
                if ($row == 0) {
                    $row++;
                    continue;
                }

                // Ambil id_user dari CSV
                $csv_id_user = isset($data[0]) ? intval($data[0]) : null;

                // Jika id_user di CSV berbeda dari id_user yang dipilih, skip
                if ($csv_id_user !== $id_user_get) {
                    $skipped++;
                    $row++;
                    continue;
                }

                // Ambil data CSV lainnya
                $tanggal       = $data[1] ?? '';
                $jam_masuk     = $data[2] ?? '00:00';
                $jam_pulang    = $data[3] ?? '00:00';
                $scan_masuk    = $data[4] ?? '00:00';
                $scan_keluar   = $data[5] ?? '00:00';
                $terlambat     = $data[6] ?? '00:00';
                $pulang_cepat  = $data[7] ?? '00:00';
                $lembur        = $data[8] ?? '00:00';
                $jml_hadir     = $data[9] ?? '00:00';
                $pengecualian  = $data[10] ?? '';

                // Filter baris kosong atau tanggal tidak valid
                if ($tanggal == "" || $tanggal == "0000-00-00" || strtotime($tanggal) === false) {
                    $row++;
                    continue;
                }

                if (
                    $jam_masuk == "00:00" && $jam_pulang == "00:00" &&
                    $scan_masuk == "00:00" && $scan_keluar == "00:00" &&
                    $terlambat == "00:00" && $pulang_cepat == "00:00" &&
                    $lembur == "00:00" && $jml_hadir == "00:00"
                ) {
                    $row++;
                    continue;
                }

                // INSERT DATA
                $stmt = $conn->prepare("
                    INSERT INTO absensi (
                        id_user, tanggal, scan_masuk, scan_keluar, terlambat, pulang_cepat,
                        lembur, jam_masuk, jam_pulang, jml_hadir, pengecualian, created_at
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
                ");

                $stmt->bind_param(
                    "issssssssss",
                    $id_user_get,
                    $tanggal,
                    $scan_masuk,
                    $scan_keluar,
                    $terlambat,
                    $pulang_cepat,
                    $lembur,
                    $jam_masuk,
                    $jam_pulang,
                    $jml_hadir,
                    $pengecualian
                );

                if ($stmt->execute()) {
                    $success++;
                } else {
                    $failed++;
                    echo "Gagal baris ke-$row: " . $stmt->error . "<br>";
                }

                $row++;
            }

            fclose($handle);

            echo "<script>
                alert('Import selesai! Berhasil: $success, Gagal: $failed, Dilewati karena id_user berbeda: $skipped');
                window.location='dashboard.php?page=detail&id=$id_user_get';
            </script>";
        }
    } else {
        echo "<script>alert('Silakan pilih file CSV'); window.history.back();</script>";
    }
} else {
?>
    <h1 class="text-2xl font-semibold mb-5">
        Import Absensi • User ID <?= $id_user_get ?>
    </h1>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-4">
            <label>Pilih file CSV</label>
            <input type="file" name="file" accept=".csv"
                class="border p-2 w-full rounded" required>
        </div>
        <button type="submit" name="submit"
            class="px-4 py-2 bg-[#E99724] text-white rounded">
            Import
        </button>
    </form>
<?php
}
?>