<?php
$alert = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $old_pass = trim($_POST['old_password']);
    $new_pass = trim($_POST['new_password']);
    $new_pass2 = trim($_POST['new_password2']);

    $q = mysqli_query($db, "SELECT password FROM member WHERE member_id='$member_id'");
    $data = mysqli_fetch_assoc($q);

    if (!$old_pass || !$new_pass || !$new_pass2) {
        $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i> Semua field wajib diisi.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>';
    } elseif (!password_verify($old_pass, $data['password'])) {
        $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-times-circle me-2"></i> Password lama salah.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>';
    } elseif (strlen($new_pass) < 6) {
        $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fas fa-lock me-2"></i> Password baru minimal 6 karakter.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>';
    } elseif ($new_pass !== $new_pass2) {
        $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fas fa-exchange-alt me-2"></i> Konfirmasi password baru tidak cocok.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>';
    } else {
        $hash = password_hash($new_pass, PASSWORD_DEFAULT);
        $s = mysqli_query($db, "UPDATE member SET password='$hash' WHERE member_id='$member_id'");
        if ($s) {
            $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> Password berhasil diubah.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>';
        } else {
            $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i> Gagal mengubah password.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>';
        }
    }
}
?>
<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="card border-0 shadow-sm mt-2">
            <div class="card-header bg-white border-0 pb-0">
                <h5 class="mb-0 fw-semibold"><i class="fas fa-key me-2"></i> Ubah Password</h5>
            </div>
            <div class="card-body">
                <?= $alert ?>
                <form method="post" autocomplete="off">
                    <div class="mb-3">
                        <label class="form-label">Password Lama</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" name="old_password" id="old_password" class="form-control" required minlength="6" autocomplete="current-password">
                            <button type="button" class="btn btn-outline-secondary" tabindex="-1" onclick="togglePwd('old_password', this)">
                                <i class="fa fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password Baru</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" name="new_password" id="new_password" class="form-control" required minlength="6" autocomplete="new-password">
                            <button type="button" class="btn btn-outline-secondary" tabindex="-1" onclick="togglePwd('new_password', this)">
                                <i class="fa fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ulangi Password Baru</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" name="new_password2" id="new_password2" class="form-control" required minlength="6" autocomplete="new-password">
                            <button type="button" class="btn btn-outline-secondary" tabindex="-1" onclick="togglePwd('new_password2', this)">
                                <i class="fa fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary px-4 mt-2"><i class="fas fa-save me-2"></i> Simpan Password Baru</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
function togglePwd(field, btn) {
    const input = document.getElementById(field);
    if (input.type === "password") {
        input.type = "text";
        btn.querySelector('i').classList.remove('fa-eye');
        btn.querySelector('i').classList.add('fa-eye-slash');
    } else {
        input.type = "password";
        btn.querySelector('i').classList.add('fa-eye');
        btn.querySelector('i').classList.remove('fa-eye-slash');
    }
}
</script>
