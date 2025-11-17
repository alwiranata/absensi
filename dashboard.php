<?php
session_start();

// Jika login belum ada → arahkan ke halaman login
// if (!isset($_SESSION['id_user'])) {
//     header("Location: index.php");
//     exit;
// }

// Include koneksi & layout
include 'config/db.php';
include 'includes/header.php';
include 'includes/sidebar.php';
?>

<!-- KONTEN UTAMA DASHBOARD -->
<div class="ml-64 mt-20 p-8">

    <?php
    // ==================== ROUTER ====================

    // Daftar halaman yang diizinkan
    $allowed_pages = [
        'beranda',
        'absensi',
        'profile',
        'detail',
        'rekap',
        'add',
        'add_user',
        'edit_user',
        'edit',
        'export',
        'import'
    ];

    // Cek apakah ada parameter page
    if (isset($_GET['page'])) {

        $page = $_GET['page'];

        // Jika halaman ada & valid
        if (in_array($page, $allowed_pages)) {
            include "pages/$page.php";
        } else {
            echo "<h2 class='text-xl font-semibold text-red-500'>⚠ Halaman tidak ditemukan!</h2>";
        }
    } else {
        include "pages/welcome.php"; // Default halaman
    }
    ?>

</div>

<?php include 'includes/footer.php'; ?>