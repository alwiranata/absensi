<?php
session_start();
include 'config/db.php';

$showToast = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['role'] = $user['role'];

            // Set flag untuk menampilkan toast
            $showToast = true;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">

    <form method="POST" action="" class="bg-white p-8 rounded-lg shadow-lg w-96 flex flex-col items-center">
        <img class="w-20 h-20 mb-4" src="./assets/img/logo.jpg" alt="Logo">

        <?php if (!empty($error)): ?>
            <div class="bg-red-200 text-red-800 px-4 py-2 mb-4 rounded w-full text-center">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <input type="text" name="username" placeholder="Username" class="border border-gray-300 p-2 rounded w-full mb-4" required>
        <input type="password" name="password" placeholder="Password" class="border border-gray-300 p-2 rounded w-full mb-6" required>
        <button type="submit" class="bg-green-600 text-white p-2 rounded-full w-full hover:bg-green-700 transition">Login</button>
    </form>

    <?php if ($showToast): ?>
        <div id="toast" class="fixed top-5 right-5 bg-green-500 text-white px-6 py-3 rounded shadow-lg opacity-0 transition-opacity duration-500">
            Login berhasil! Selamat datang, <?= $_SESSION['nama'] ?>
        </div>
        <script>
            const toast = document.getElementById('toast');
            toast.classList.add('opacity-100');

            // Hilangkan toast dan redirect setelah 2 detik
            setTimeout(() => {
                toast.classList.remove('opacity-100');
                toast.classList.add('opacity-0');
            }, 2000);

            setTimeout(() => {
                window.location.href = 'dashboard.php';
            }, 2200);
        </script>
    <?php endif; ?>

</body>

</html>