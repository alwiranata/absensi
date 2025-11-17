<?php
// Ambil nama user dari session
$nama_user = $_SESSION['nama'];
?>

<!-- Welcome Message -->
<div id="welcomeBox" class="bg-[#E99724] text-white p-6 rounded-xl shadow-lg mb-6">
    <h1 class="text-2xl font-bold">Welcome, <?= htmlspecialchars($nama_user) ?> 👋</h1>
</div>

<script>
    // Redirect ke halaman beranda setelah 2 detik
    setTimeout(() => {
        window.location.href = "dashboard.php?page=beranda";
    }, 2000);
</script>
