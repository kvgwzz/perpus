<?php
include_once(__DIR__ . '/../../koneksi.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) die('ID anggota tidak valid.');

// Ambil data lama
$q = mysqli_query($db, "SELECT * FROM member WHERE member_id = $id LIMIT 1");
$member = mysqli_fetch_assoc($q);
if (!$member) die('Data anggota tidak ditemukan!');

$success = $error = "";

// Proses update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = trim($_POST['firstname']);
    $lastname  = trim($_POST['lastname']);
    $username  = trim($_POST['username']);
    $email     = trim($_POST['email']);
    $gender    = trim($_POST['gender']);
    $address   = trim($_POST['address']);
    $contact   = trim($_POST['contact']);
    $type      = trim($_POST['type']);
    $status    = intval($_POST['status']);
    $password  = trim($_POST['password']);

    // Validasi wajib isi
    if (
        !$firstname || !$lastname || !$username || !$email ||
        !$gender || !$address || !$contact || !$type
    ) {
        $error = "Semua kolom (kecuali password) wajib diisi!";
    } else {
        // Cek email & username unik (kecuali data ini sendiri)
        $cek = mysqli_query($db, "SELECT 1 FROM member WHERE (username='$username' OR email='$email') AND member_id != $id");
        if (mysqli_num_rows($cek) > 0) {
            $error = "Username atau email sudah digunakan anggota lain!";
        } else {
            // Build query
            $sql = "UPDATE member SET
                firstname = '$firstname',
                lastname  = '$lastname',
                username  = '$username',
                email     = '$email',
                gender    = '$gender',
                address   = '$address',
                contact   = '$contact',
                type      = '$type',
                status    = $status";
            if ($password) {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $sql .= ", password = '$hash'";
            }
            $sql .= " WHERE member_id = $id";
            $qUp = mysqli_query($db, $sql);

            if ($qUp) {
                $success = "Data anggota berhasil diperbarui!";
                // Refresh data baru
                $q = mysqli_query($db, "SELECT * FROM member WHERE member_id = $id LIMIT 1");
                $member = mysqli_fetch_assoc($q);
            } else {
                $error = "Gagal update data anggota. Silakan coba lagi!";
            }
        }
    }
}
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Anggota</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="admin.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="admin.php?p=listmember">Data Anggota</a></li>
                    <li class="breadcrumb-item active">Edit Anggota</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content pb-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-info text-white">
                        <h3 class="card-title mb-0 fw-semibold"><i class="fas fa-user-edit me-2"></i> Form Edit Anggota</h3>
                    </div>
                    <form method="post" autocomplete="off">
                        <div class="card-body px-4 py-4">
                            <?php
                            if ($error) echo '<div class="alert alert-danger">'.$error.'</div>';
                            if ($success) echo '<div class="alert alert-success">'.$success.'</div>';
                            ?>
                            <div class="row g-4">
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group mb-3">
                                        <label for="firstname" class="fw-semibold">Nama Depan <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="firstname" name="firstname" required value="<?=htmlspecialchars($member['firstname'])?>">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="lastname" class="fw-semibold">Nama Belakang <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="lastname" name="lastname" required value="<?=htmlspecialchars($member['lastname'])?>">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="username" class="fw-semibold">Username <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="username" name="username" required value="<?=htmlspecialchars($member['username'])?>">
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group mb-3">
                                        <label for="email" class="fw-semibold">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="email" name="email" required value="<?=htmlspecialchars($member['email'])?>">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="contact" class="fw-semibold">No. Telp <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="contact" name="contact" required value="<?=htmlspecialchars($member['contact'])?>">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address" class="fw-semibold">Alamat <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="address" name="address" required value="<?=htmlspecialchars($member['address'])?>">
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group mb-3">
                                        <label for="type" class="fw-semibold">Tipe Anggota <span class="text-danger">*</span></label>
                                        <select class="form-control" id="type" name="type" required>
                                            <option value="Guru" <?=$member['type']=='Guru'?'selected':''?>>Guru</option>
                                            <option value="Siswa" <?=$member['type']=='Siswa'?'selected':''?>>Siswa</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="gender" class="fw-semibold">Jenis Kelamin <span class="text-danger">*</span></label>
                                        <select class="form-control" id="gender" name="gender" required>
                                            <option value="L" <?=$member['gender']=='L'?'selected':''?>>Laki-laki</option>
                                            <option value="P" <?=$member['gender']=='P'?'selected':''?>>Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="status" class="fw-semibold">Status <span class="text-danger">*</span></label>
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="1" <?=$member['status']==1?'selected':''?>>Aktif</option>
                                            <option value="0" <?=$member['status']==0?'selected':''?>>Tidak Aktif</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="password" class="fw-semibold">Password (kosongkan jika tidak diubah)</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Kosongkan jika tidak diubah">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-light border-top text-end">
                            <button type="submit" class="btn btn-info px-4 me-2"><i class="fas fa-save me-2"></i> Simpan Perubahan</button>
                            <a href="admin.php?p=listmember" class="btn btn-secondary px-4">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
