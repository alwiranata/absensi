<h1 class="text-2xl font-semibold mb-5">
    Tambah User
</h1>

<form method="POST" action="pages/users/insert_user.php">

    <div class="mb-4">
        <label>ID User</label>
        <input type="number" name="id_user" class="border p-2 w-full rounded" required>
    </div>

    <div class="mb-4">
        <label>Nama</label>
        <input type="text" name="nama" class="border p-2 w-full rounded" required>
    </div>

    <div class="mb-4">
        <label>Username</label>
        <input type="text" name="username" class="border p-2 w-full rounded" >
    </div>

    <div class="mb-4">
        <label>Password</label>
        <input type="password" name="password" class="border p-2 w-full rounded" >
    </div>

    <div class="mb-4">
        <label>Role</label>
        <select name="role" class="border p-2 w-full rounded" required>
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>
    </div>

    <button type="submit" class="px-4 py-2 bg-[#E99724] text-white rounded">
        Tambah
    </button>

    <a href="dashboard.php?page=profile" class="px-4 py-2 bg-gray-400 rounded">
        Batal
    </a>

</form>