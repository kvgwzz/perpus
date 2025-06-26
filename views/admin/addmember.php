<?php
include_once(__DIR__ . '/../../koneksi.php');

$success = $error = "";

// Handle submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = trim($_POST['firstname']);
    $lastname  = trim($_POST['lastname']);
    $username  = trim($_POST['username']);
    $email     = trim($_POST['email']);
    $password  = trim($_POST['password']);
    $password2 = trim($_POST['password2']);
    $gender    = trim($_POST['gender']);
    $address   = trim($_POST['address']);
    $contact   = trim($_POST['contact']);
    $type      = trim($_POST['type']);
    $status    = 1;

    // Validasi wajib isi
    if (
        !$firstname || !$lastname || !$username || !$email ||
        !$password || !$password2 || !$gender || !$address || !$contact || !$type
    ) {
        $error = "Semua kolom wajib diisi!";
    } elseif ($password !== $password2) {
        $error = "Konfirmasi password tidak cocok!";
    } else {
        $cek = mysqli_query($db, "SELECT 1 FROM member WHERE username='$username' OR email='$email'");
        if (mysqli_num_rows($cek) > 0) {
            $error = "Username atau email sudah terdaftar!";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $q = mysqli_query($db, "INSERT INTO member 
                (firstname, lastname, username, email, password, gender, address, contact, type, status)
                VALUES (
                    '$firstname', '$lastname', '$username', '$email', '$hash', '$gender', '$address', '$contact', '$type', $status
                )"
            );
            if ($q) {
                $success = "Anggota baru berhasil ditambahkan!";
            } else {
                $error = "Gagal menambahkan anggota. Silakan coba lagi.";
            }
        }
    }
}
?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Tambah Anggota Baru</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="admin.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="admin.php?p=listmember">Data Anggota</a></li>
                    <li class="breadcrumb-item active">Tambah Anggota</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content pb-4">
    <div class="container-fluid">
        <div class="row">
            <!-- Full width for xl and up, half for md/down, single for mobile -->
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title mb-0 fw-semibold"><i class="fas fa-user-plus me-2"></i> Form Tambah Anggota</h3>
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
                                        <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Nama Depan" required value="<?=isset($_POST['firstname'])?htmlspecialchars($_POST['firstname']):''?>">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="lastname" class="fw-semibold">Nama Belakang <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Nama Belakang" required value="<?=isset($_POST['lastname'])?htmlspecialchars($_POST['lastname']):''?>">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="username" class="fw-semibold">Username <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Username Unik" required value="<?=isset($_POST['username'])?htmlspecialchars($_POST['username']):''?>">
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group mb-3">
                                        <label for="email" class="fw-semibold">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Email valid" required value="<?=isset($_POST['email'])?htmlspecialchars($_POST['email']):''?>">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="contact" class="fw-semibold">No. Telp <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="contact" name="contact" placeholder="Contoh: 08123456789" required value="<?=isset($_POST['contact'])?htmlspecialchars($_POST['contact']):''?>">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address" class="fw-semibold">Alamat <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="address" name="address" placeholder="Alamat lengkap" required value="<?=isset($_POST['address'])?htmlspecialchars($_POST['address']):''?>">
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group mb-3">
                                        <label for="type" class="fw-semibold">Tipe Anggota <span class="text-danger">*</span></label>
                                        <select class="form-control" id="type" name="type" required>
                                            <option value="">Pilih Tipe</option>
                                            <option value="Guru" <?=isset($_POST['type']) && $_POST['type']=='Guru'?'selected':''?>>Guru</option>
                                            <option value="Siswa" <?=isset($_POST['type']) && $_POST['type']=='Siswa'?'selected':''?>>Siswa</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="gender" class="fw-semibold">Jenis Kelamin <span class="text-danger">*</span></label>
                                        <select class="form-control" id="gender" name="gender" required>
                                            <option value="">Pilih</option>
                                            <option value="L" <?=isset($_POST['gender']) && $_POST['gender']=='L'?'selected':''?>>Laki-laki</option>
                                            <option value="P" <?=isset($_POST['gender']) && $_POST['gender']=='P'?'selected':''?>>Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="password" class="fw-semibold">Password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Password (min. 6 karakter)" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="password2" class="fw-semibold">Konfirmasi Password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" id="password2" name="password2" placeholder="Ulangi password" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-light border-top text-end">
                            <button type="submit" class="btn btn-primary px-4 me-2"><i class="fas fa-save me-2"></i> Simpan</button>
                            <a href="admin.php?p=listmember" class="btn btn-secondary px-4">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
