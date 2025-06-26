<?php
session_start();
include "koneksi.php";

if (isset($_POST['submit'])) {

    $user = $_POST['user'];
    $pass = $_POST['password'];

    if (empty($user) || empty($pass)) {
        header("Location: login.php?error=empty");
        exit();
    }

    // Cek ke tabel admin/users dulu
    $sql = "SELECT * FROM users WHERE username = ?";
    if ($stmt = mysqli_prepare($db, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $user);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) == 1) {
            $data_user = mysqli_fetch_assoc($result);
            if (password_verify($pass, $data_user['password'])) {
                session_regenerate_id(true);
                $_SESSION['user_id'] = $data_user['user_id'];
                $_SESSION['sesi'] = $data_user['username'];
                $_SESSION['role'] = "admin";
                header("Location: admin.php");
                exit();
            }
        }
        mysqli_stmt_close($stmt);
    }

    // Jika tidak ketemu di users/admin, cek ke member/user
    $sql2 = "SELECT * FROM member WHERE username = ? AND status=1";
    if ($stmt2 = mysqli_prepare($db, $sql2)) {
        mysqli_stmt_bind_param($stmt2, "s", $user);
        mysqli_stmt_execute($stmt2);
        $result2 = mysqli_stmt_get_result($stmt2);

        if (mysqli_num_rows($result2) == 1) {
            $data_member = mysqli_fetch_assoc($result2);
            if (password_verify($pass, $data_member['password'])) {
                session_regenerate_id(true);
                $_SESSION['member_id'] = $data_member['member_id'];
                $_SESSION['sesi'] = $data_member['username'];
                $_SESSION['role'] = "user";
                // PERBAIKI PATH DI SINI:
                header("Location: views/user/dashboard.php");
                exit();
            } else {
                header("Location: login.php?error=wrongpassword");
                exit();
            }
        }
        mysqli_stmt_close($stmt2);
    }

    // Jika gagal login ke dua-duanya
    header("Location: login.php?error=nouser");
    exit();

} else {
    header("Location: login.php");
    exit();
}
?>
