<?php
include "koneksi.php";
$success = $error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = trim($_POST['firstname']);
    $lastname  = trim($_POST['lastname']);
    $username  = trim($_POST['username']);
    $email     = trim($_POST['email']);
    $password  = trim($_POST['password']);
    $gender    = trim($_POST['gender']);
    $address   = trim($_POST['address']);
    $contact   = trim($_POST['contact']);
    $type      = "siswa";
    $status    = 1;

    if (
        $firstname == "" || $lastname == "" || $username == "" ||
        $email == "" || $password == "" || $gender == "" ||
        $address == "" || $contact == ""
    ) {
        $error = "Semua kolom wajib diisi!";
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
                $success = "Akun berhasil dibuat! Silakan <a href='index.php' class='success-link'><b>login sekarang</b></a>.";
            } else {
                $error = "Registrasi gagal! Silakan coba lagi.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Siswa - Digital Library</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
    .success-message {
        background: #e8f7ea;
        border: 1.5px solid #38c172;
        color: #218838;
        font-weight: 500;
        padding: 14px 18px;
        border-radius: 7px;
        margin-bottom: 18px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .success-message i { color: #38c172; font-size: 1.3em;}
    .success-link { color: #218838; text-decoration: underline; }
    .error-message {
        background: #fff4f4;
        border: 1.5px solid #e3342f;
        color: #e3342f;
        font-weight: 500;
        padding: 14px 18px;
        border-radius: 7px;
        margin-bottom: 18px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .error-message i { color: #e3342f; font-size: 1.3em;}
    </style>
</head>
<body>

    <div class="login-container">
        <div class="login-box">
            <form action="" method="post" autocomplete="off">
                <h2>Daftar Siswa Baru</h2>
                <p class="subtitle">Isi data dengan benar untuk membuat akun</p>

                <?php
                if ($error) {
                    echo '<div class="error-message"><i class="fas fa-exclamation-circle"></i> '.htmlspecialchars($error).'</div>';
                }
                if ($success) {
                    echo '<div class="success-message"><i class="fas fa-check-circle"></i> '.$success.'</div>';
                }
                ?>

                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="firstname" placeholder="Nama Depan" value="<?=isset($_POST['firstname'])?htmlspecialchars($_POST['firstname']):''?>" required>
                </div>
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="lastname" placeholder="Nama Belakang" value="<?=isset($_POST['lastname'])?htmlspecialchars($_POST['lastname']):''?>" required>
                </div>
                <div class="input-group">
                    <i class="fas fa-user-circle"></i>
                    <input type="text" name="username" placeholder="Username" value="<?=isset($_POST['username'])?htmlspecialchars($_POST['username']):''?>" required>
                </div>
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="Email" value="<?=isset($_POST['email'])?htmlspecialchars($_POST['email']):''?>" required>
                </div>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <div class="input-group">
                    <i class="fas fa-venus-mars"></i>
                    <select name="gender" required>
                        <option value="">Jenis Kelamin</option>
                        <option value="L" <?=isset($_POST['gender']) && $_POST['gender']=='L'?'selected':''?>>Laki-laki</option>
                        <option value="P" <?=isset($_POST['gender']) && $_POST['gender']=='P'?'selected':''?>>Perempuan</option>
                    </select>
                </div>
                <div class="input-group">
                    <i class="fas fa-location-dot"></i>
                    <input type="text" name="address" placeholder="Alamat" value="<?=isset($_POST['address'])?htmlspecialchars($_POST['address']):''?>" required>
                </div>
                <div class="input-group">
                    <i class="fas fa-phone"></i>
                    <input type="text" name="contact" placeholder="No. Kontak" value="<?=isset($_POST['contact'])?htmlspecialchars($_POST['contact']):''?>" required>
                </div>

                <button type="submit" class="login-btn" <?= $success?'disabled':''; ?>>Daftar</button>

                <div class="register-link">
                    <p>Sudah punya akun? <a href="index.php">Login</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
