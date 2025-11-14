<table class="w-full border-collapse rounded-xl overflow-hidden">
    <thead>
        <tr class="bg-gray-200 text-left">
            <th class="p-3">Id</th>
            <th class="p-3">Nama</th>
            <th class="p-3 ">Detail</th>
            <th class="p-3 text-center">Aksi</th>
        </tr>
    </thead>

    <tbody>

        <!-- Contoh data — nanti diganti PHP loop -->
        <?php
        // contoh query
        $data = $conn->query("SELECT * FROM users ORDER BY id_user ASC");
        while ($row = $data->fetch_assoc()) {
        ?>
            <tr class="border-b hover:bg-gray-50">
                <td class="p-3"><?php echo $row['id_user']; ?></td>
                <td class="p-3"><?php echo $row['nama']; ?></td>

                <!-- DETAIL -->
                <td class="p-3 ">
                    <a href="dashboard.php?page=detail&id=<?php echo $row['id_user']; ?>">
                        <div class="w-[30px] h-[30px] flex items-center justify-center 
                            rounded-full border border-teal-500 text-teal-600 font-bold">
                            i
                        </div>
                    </a>
                </td>

                <!-- AKSI -->
                <td class="p-3 flex justify-center gap-2">

                    <!-- Tambah -->
                    <a href="dashboard.php?page=add&id=<?php echo $row['id_user']; ?>"
                        class="w-[30px] h-[30px] flex items-center justify-center 
        rounded-md border border-yellow-500 text-yellow-600 font-bold">
                        +
                    </a>

                    <!-- Export -->
                    <a href="dashboard.php?page=export&id=<?php echo $row['id_user']; ?>"
                        class="w-[30px] h-[30px] flex items-center justify-center 
       rounded-md border border-red-500 text-red-600 font-bold">
                        ↑
                    </a>

                    <!-- Import -->
                    <a href="dashboard.php?page=import&id=<?php echo $row['id_user']; ?>"
                        class="w-[30px] h-[30px] flex items-center justify-center 
        rounded-md border border-green-500 text-green-600 font-bold">
                        ↓
                    </a>

                </td>

            </tr>

        <?php } ?>
    </tbody>
</table>