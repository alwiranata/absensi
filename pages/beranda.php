<?php
// Query jumlah user
$qUser = $conn->query("SELECT COUNT(*) AS total_user FROM users WHERE role='user'");
$dataUser = $qUser->fetch_assoc();

// Query jumlah admin
$qAdmin = $conn->query("SELECT COUNT(*) AS total_admin FROM users WHERE role='admin'");
$dataAdmin = $qAdmin->fetch_assoc();
?>

<div class="flex flex-row justify-around mt-5 gap-3">
    <div class="w-[300px] h-[150px] bg-[#E99724] text-white flex flex-row justify-center items-center gap-3 rounded-[10px]">
        <img class=" w-[40px] h-[40px] rounded-full" src="assets/img/profile.jpg" alt="">
        <p class="text-[16px]"><?php echo $dataUser['total_user']; ?> User</p>
    </div>

    <div class="w-[300px] h-[150px] bg-[#E99724] text-white flex flex-row justify-center items-center gap-3 rounded-[10px]">
        <img class="w-[40px] h-[40px] rounded-full" src="assets/img/profile.jpg" alt="">
        <p class="text-[16px]"><?php echo $dataAdmin['total_admin']; ?> Admin</p>
    </div>
</div>