<table class="w-full border-collapse rounded-xl overflow-hidden">
    <thead>
        <tr class="bg-gray-200 text-left">
            <th class="p-3">Id</th>
            <th class="p-3">Nama</th>
            <th class="p-3">Detail</th>
            <th class="p-3 text-center">Aksi</th>
        </tr>
    </thead>

    <tbody>
        <?php
        // Ambil semua user
        $data = $conn->query("SELECT * FROM users ORDER BY id_user ASC");
        while ($row = $data->fetch_assoc()) {

            // Skip jika role admin
            if ($row['role'] === 'admin') {
                continue;
            }
        ?>
            <tr class="border-b hover:bg-gray-50">
                <td class="p-3"><?= $row['id_user'] ?></td>
                <td class="p-3"><?= $row['nama'] ?></td>

                <!-- DETAIL -->
                <td class="p-3">
                    <a href="dashboard.php?page=detail&id=<?= $row['id_user'] ?>">
                        <div class="w-[30px] h-[30px] flex items-center justify-center 
                            rounded-full border border-teal-500 text-teal-600 font-bold">
                            i
                        </div>
                    </a>
                </td>

                <!-- AKSI -->
                <td class="p-3 flex justify-center gap-2">
                    <!-- Tambah -->
                    <a href="dashboard.php?page=add&id=<?= $row['id_user'] ?>"
                        class="w-[30px] h-[30px] flex items-center justify-center 
                        rounded-md border border-yellow-500 text-yellow-600 font-bold">
                        +
                    </a>

                    <!-- Export -->
                    <a href="pages/absensi/export_absen.php?id=<?= $row['id_user'] ?>"
                        class="w-[30px] h-[30px] flex items-center justify-center 
                        rounded-md border border-red-500 text-red-600 font-bold">
                        ↑
                    </a>

                    <!-- Import -->
                    <a href="dashboard.php?page=import&id=<?= $row['id_user'] ?>"
                        class="w-[30px] h-[30px] flex items-center justify-center 
                        rounded-md border border-green-500 text-green-600 font-bold">
                        ↓
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>