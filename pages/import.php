<?php
include __DIR__ . '../../config/db.php';

$id_user_get = isset($_GET['id']) ? intval($_GET['id']) : null;

if (!$id_user_get) {
    die("ID User tidak ditemukan. Contoh: import.php?id=2");
}

if (isset($_POST['submit'])) {

    if (!empty($_FILES['file']['name'])) {

        $file_tmp = $_FILES['file']['tmp_name'];

        // Baca seluruh isi file sebagai HTML
        $html = file_get_contents($file_tmp);

        // Ambil baris <tr>
        preg_match_all('/<tr.*?>(.*?)<\/tr>/si', $html, $rows);

        $success = 0;
        $failed = 0;
        $skipped = 0;
        $rowNum  = 0;

        foreach ($rows[1] as $tr) {

            // Ambil semua kolom <td>
            preg_match_all('/<t[dh].*?>(.*?)<\/t[dh]>/si', $tr, $cols);
            $data = $cols[1];

            // Skip baris header
            if ($rowNum == 0) {
                $rowNum++;
                continue;
            }

            // Perlu minimal 12 kolom
            if (count($data) < 12) {
                $rowNum++;
                continue;
            }

            // Bersihkan HTML entities
            $data = array_map('strip_tags', $data);

            // Mapping sesuai urutan export
            $csv_id_user  = intval($data[0]);
            $nama_csv     = $data[1];
            $tanggal      = $data[2];
            $jam_masuk    = $data[3];
            $jam_pulang   = $data[4];
            $scan_masuk   = $data[5];
            $scan_keluar  = $data[6];
            $terlambat    = $data[7];
            $pulang_cepat = $data[8];
            $lembur       = $data[9];
            $jml_hadir    = $data[10];
            $pengecualian = $data[11];

            // Skip jika id_user beda
            if ($csv_id_user != $id_user_get) {
                $skipped++;
                $rowNum++;
                continue;
            }

            // Insert
            $stmt = $conn->prepare("
                INSERT INTO absensi (
                    id_user, tanggal, scan_masuk, scan_keluar, terlambat, 
                    pulang_cepat, lembur, jam_masuk, jam_pulang, 
                    jml_hadir, pengecualian, created_at
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
            ");

            $stmt->bind_param(
                "issssssssss",
                $csv_id_user,
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
                echo "Gagal baris $rowNum : " . $stmt->error . "<br>";
            }

            $rowNum++;
        }

        echo "<script>
            alert('Import selesai! Berhasil: $success, Gagal: $failed, Dilewati: $skipped');
            window.location='dashboard.php?page=detail&id=$id_user_get';
        </script>";
        exit;
    }
}
?>

<h1 class="text-2xl font-semibold mb-5">
    Import Absensi • User ID <?= $id_user_get ?>
</h1>

<form method="POST" enctype="multipart/form-data">
    <input type="file" name="file" accept=".xls" class="border p-2 w-full rounded" required>
    <button type="submit" name="submit" class="px-4 py-2 bg-[#E99724] text-white rounded">
        Import
    </button>
</form>