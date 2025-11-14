<!-- Welcome Message -->
<div id="welcomeBox" class="bg-[#E99724] text-white p-6 rounded-xl shadow-lg mb-6">
    <h1 class="text-2xl font-bold">Selamat Datang, 👋</h1>
    <p class="text-sm mt-1">
        Anda masuk sebagai <b>Administrator</b>. Gunakan menu di sebelah kiri untuk mengelola data sistem.
    </p>
</div>

<script>
    // Redirect ke halaman beranda setelah 2 detik
    setTimeout(() => {
        window.location.href = "dashboard.php?page=beranda";
    }, 2000);
</script>
