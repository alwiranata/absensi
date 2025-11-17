<?php
$role_user = $_SESSION['role']; // pastikan session sudah dimulai
?>

<table class="w-full border-collapse rounded-xl overflow-hidden">
    <thead>
        <tr class="bg-gray-200 text-left">
            <th class="p-3">Id</th>
            <th class="p-3">Nama</th>
            <th class="p-3">Detail</th>
            <th class="p-3">Rekap</th>
            <?php if ($role_user === 'admin'): ?>
                <th class="p-3 text-center">Aksi</th>
            <?php endif; ?>
        </tr>
    </thead>

    <tbody>
        <?php
        $data = $conn->query("SELECT * FROM users ORDER BY id_user ASC");
        while ($row = $data->fetch_assoc()) {

            // Skip jika role admin
            if ($row['role'] === 'admin') continue;
        ?>
            <tr class="border-b hover:bg-gray-50">
                <td class="p-3"><?= $row['id_user'] ?></td>
                <td class="p-3"><?= $row['nama'] ?></td>

                <!-- DETAIL -->
                <td class="p-3">
                    <a href="dashboard.php?page=detail&id=<?= $row['id_user'] ?>">
                        <div class="w-[30px] h-[30px] flex items-center justify-center 
                            rounded-full border border-blue-500 text-blue-600 font-bold">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear" viewBox="0 0 16 16">
                                <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492M5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0" />
                                <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115z" />
                            </svg>
                        </div>
                    </a>
                </td>

                <!-- Info -->
                <td class="p-3">
                    <a href="dashboard.php?page=rekap&id=<?= $row['id_user'] ?>">
                        <div class="w-[30px] h-[30px] flex items-center justify-center 
                            rounded-full border border-teal-600 text-teal-700 font-bold">
                            i
                        </div>
                    </a>
                </td>

                <!-- AKSI hanya untuk admin -->
                <?php if ($role_user === 'admin'): ?>
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
                <?php endif; ?>
            </tr>
        <?php } ?>
    </tbody>
</table>