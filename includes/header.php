<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Jika user belum login, redirect ke login
if (!isset($_SESSION['id_user'])) {
    header("Location: index.php");
    exit;
}

// Ambil data user dari session
$nama_user = $_SESSION['nama'];
$role_user = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Absensi</title>
</head>

<body>
    <header>
        <div class="fixed z-10 top-0 w-full flex flex-row justify-between gap-3 p-3 border-b border-gray-300 bg-white">

            <!-- Logo dan Judul -->
            <div class="flex flex-row items-center gap-3 p-3">
                <img class="w-[30px] h-[30px] rounded-full" src="assets/img/logo.jpg" alt="">
                <p>Rekap Absensi</p>
            </div>

            <!-- User Info -->
            <div class="relative flex flex-row items-center gap-3 p-3">
                <!-- Nama & Role dinamis -->
                <p><?= htmlspecialchars($nama_user) ?> (<?= htmlspecialchars($role_user) ?>)</p>
                <img class="w-[40px] h-[40px] rounded-full" src="assets/img/profile.jpg" alt="">

                <!-- Dropdown Toggle -->
                <svg id="dropdownToggle" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down cursor-pointer" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708" />
                </svg>

                <!-- Dropdown Menu -->
                <div id="dropdownMenu" class="hidden absolute right-0 mt-12 w-32 bg-white border border-gray-300 rounded shadow-lg">
                    <a href="logout.php" class="block px-4 py-2 hover:bg-gray-100">Logout</a>
                </div>
            </div>
        </div>
    </header>

    <script>
        const toggle = document.getElementById('dropdownToggle');
        const menu = document.getElementById('dropdownMenu');

        toggle.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });

        // Klik di luar menu untuk menutup
        window.addEventListener('click', (e) => {
            if (!toggle.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });
    </script>

