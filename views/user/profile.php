<?php
$alert = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fname = trim($_POST['firstname']);
    $lname = trim($_POST['lastname']);
    $email = trim($_POST['email']);
    $kontak = trim($_POST['contact']);
    $alamat = trim($_POST['address']);
    if ($fname && $lname && $email && $kontak && $alamat) {
        $s = mysqli_query($db, "UPDATE member SET firstname='$fname', lastname='$lname', email='$email', contact='$kontak', address='$alamat' WHERE member_id='$member_id'");
        if ($s) {
            $user['firstname'] = $fname; $user['lastname'] = $lname; $user['email'] = $email; $user['contact'] = $kontak; $user['address'] = $alamat;
            $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i> Profil berhasil diperbarui.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>';
        } else {
            $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i> Gagal memperbarui profil.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>';
        }
    } else {
        $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i> Semua field harus diisi!
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>';
    }
}
?>
<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="card border-0 shadow-sm mt-2">
            <div class="card-header bg-white border-0 pb-0">
                <h5 class="mb-0 fw-semibold"><i class="fas fa-user-edit me-2"></i> Edit Profil</h5>
            </div>
            <div class="card-body">
                <?= $alert ?>
                <form method="post" autocomplete="off">
                    <div class="mb-3">
                        <label class="form-label">Nama Depan</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" name="firstname" class="form-control" required value="<?= htmlspecialchars($user['firstname']) ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Belakang</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" name="lastname" class="form-control" required value="<?= htmlspecialchars($user['lastname']) ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($user['email']) ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No. Kontak</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            <input type="text" name="contact" class="form-control" required value="<?= htmlspecialchars($user['contact']) ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                            <input type="text" name="address" class="form-control" required value="<?= htmlspecialchars($user['address']) ?>">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save me-2"></i> Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
