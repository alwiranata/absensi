<?php
// Cek halaman aktif dari URL
$current_page = isset($_GET['page']) ? $_GET['page'] : 'beranda';
?>

<div class="fixed  border-r p-3 z-0 border-gray-300 bg-white h-screen">

    <nav class="mt-10">

        <!-- Menu Beranda -->
        <a href="dashboard.php?page=beranda">
            <div class="flex flex-row mt-6 items-center w-[200px] h-[50px] gap-3 p-3 rounded-[15px] cursor-pointer
                <?php echo ($current_page == 'beranda') ? 'bg-[#E99724] text-white' : 'hover:bg-gray-200'; ?>">
                <img class="w-[30px] h-[30px] rounded-full" src="assets/img/beranda.jpg" alt="">
                <p>Beranda</p>
            </div>
        </a>

        <!-- Menu Absensi -->
        <a href="dashboard.php?page=absensi">
            <div class="flex flex-row mt-6 items-center w-[200px] h-[50px] gap-3 p-3 rounded-[15px] cursor-pointer
        <?php echo ($current_page == 'absensi' || $current_page == 'detail' || $current_page == "edit" || $current_page == "add")
            ? 'bg-[#E99724] text-white'
            : 'hover:bg-gray-200'; ?>">

                <img class="w-[30px] h-[30px] rounded-full" src="assets/img/absensi.jpg" alt="">
                <p>Absensi</p>
            </div>
        </a>

        <!-- Menu Profile -->
        <a href="dashboard.php?page=profile">
            <div class="flex flex-row mt-6 items-center w-[200px] h-[50px] gap-3 p-3 rounded-[15px] cursor-pointer
                <?php echo ($current_page == 'profile' || $current_page == 'add_user') ? 'bg-[#E99724] text-white' : 'hover:bg-gray-200'; ?>">
                <img class="w-[30px] h-[30px] rounded-full" src="assets/img/profile.jpg" alt="">
                <p>Profile</p>
            </div>
        </a>

    </nav>

</div>