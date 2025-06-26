<?php
session_start();
include_once "../../koneksi.php";
if(!isset($_SESSION['member_id']) || $_SESSION['role'] !== 'user'){
    header("Location: ../../login.php");
    exit();
}
$member_id = $_SESSION['member_id'];
$qUser = mysqli_query($db, "SELECT * FROM member WHERE member_id='$member_id' LIMIT 1");
$user = mysqli_fetch_assoc($qUser);

$page = isset($_GET['page']) ? $_GET['page'] : 'home';
// Mapping file yang boleh diakses
$allowed_pages = [
    'home'    => 'home.php',
    'profile' => 'profile.php',
    'katalog' => 'katalog.php',
    'riwayat' => 'riwayat.php',
    'password'=> 'password.php'
];
$page_file = isset($allowed_pages[$page]) ? $allowed_pages[$page] : 'home.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Siswa | Digital Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <style>
        body {background: #f7f9fb;}
        .sidebar {
            background: #304ffe; min-height: 100vh; color: #fff;
        }
        .sidebar .nav-link, .sidebar .nav-link.active {
            color: #fff; font-weight: 500;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: #1e40af;
        }
        .profile-img {width: 72px; height: 72px; object-fit: cover; border-radius: 50%; border: 3px solid #fff; margin-bottom:10px;}
        .user-name {font-size:1.25rem;font-weight:600;}
        .user-role {font-size: 0.95rem; color: #b4cdfa;}
        @media (max-width: 991.98px) {.sidebar {min-height: auto;}}
        .table-responsive {margin-top: 1.5rem;}
        .badge-status {font-size:0.93rem; padding:6px 14px;}
        .logout-btn {color:#fff;} .logout-btn:hover {color:#ffcdd2;}
        main.col {padding-bottom:40px;}
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row flex-nowrap">
        <!-- Sidebar -->
        <div class="col-auto col-lg-3 col-xl-2 px-sm-2 px-0 sidebar d-flex flex-column justify-content-between">
            <div>
                <div class="d-flex flex-column align-items-center py-4">
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($user['firstname'].' '.$user['lastname']); ?>&background=304ffe&color=fff&rounded=true&size=72"
                         class="profile-img" alt="Profile">
                    <div class="user-name"><?= htmlspecialchars($user['firstname'] . ' ' . $user['lastname']) ?></div>
                    <div class="user-role">Siswa</div>
                </div>
                <hr style="border-top:1.5px solid #5f7cff;">
                <nav class="nav flex-column mb-3">
                    <a class="nav-link<?= ($page=='home'?' active':'') ?>" href="dashboard.php?page=home"><i class="fas fa-home me-2"></i> Dashboard</a>
                    <a class="nav-link<?= ($page=='katalog'?' active':'') ?>" href="dashboard.php?page=katalog"><i class="fas fa-book me-2"></i> Katalog Buku</a>
                    <a class="nav-link<?= ($page=='riwayat'?' active':'') ?>" href="dashboard.php?page=riwayat"><i class="fas fa-history me-2"></i> Riwayat Peminjaman</a>
                    <a class="nav-link<?= ($page=='profile'?' active':'') ?>" href="dashboard.php?page=profile"><i class="fas fa-user-edit me-2"></i> Edit Profil</a>
                    <a class="nav-link<?= ($page=='password'?' active':'') ?>" href="dashboard.php?page=password"><i class="fas fa-key me-2"></i> Ubah Password</a>
                    <a class="nav-link logout-btn mt-4" href="../../logout.php"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
                </nav>
            </div>
            <div class="d-none d-lg-block text-center pb-3" style="font-size:0.92rem; color:#b3c6ff;">
                &copy; <?= date('Y') ?> Digital Library
            </div>
        </div>
        <!-- /Sidebar -->
        <main class="col py-3">
            <?php include $page_file; ?>
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
