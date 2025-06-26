<?php
// $user sudah tersedia dari dashboard.php
// Buat statistik sederhana: total peminjaman, buku aktif, buku dikembalikan
$total = $aktif = $kembali = 0;
$qStat = mysqli_query($db, "
    SELECT bd.borrow_status FROM borrow b
    JOIN borrowdetails bd ON b.borrow_id=bd.borrow_id
    WHERE b.member_id='$member_id'
");
while($s = mysqli_fetch_assoc($qStat)) {
    $total++;
    if ($s['borrow_status']==2) $kembali++; else $aktif++;
}
?>
<div class="mb-3">
    <div class="row align-items-center gy-3">
        <div class="col-auto">
            <img src="https://ui-avatars.com/api/?name=<?= urlencode($user['firstname'].' '.$user['lastname']) ?>&background=304ffe&color=fff&rounded=true&size=84"
                 class="rounded-circle border border-3 border-white shadow" alt="Profile" style="width:84px;height:84px;">
        </div>
        <div class="col">
            <h2 class="mb-0 fw-bold">Selamat datang, <span style="color:#304ffe"><?= htmlspecialchars($user['firstname']) ?></span>!</h2>
            <div class="text-muted mt-1" style="font-size:1.08rem;">
                <i class="fas fa-envelope me-1"></i> <?= htmlspecialchars($user['email']) ?>
                &nbsp;|&nbsp;
                <i class="fas fa-phone me-1"></i> <?= htmlspecialchars($user['contact']) ?>
            </div>
            <span class="badge bg-success mt-2 px-3 py-2 fs-6">Status: Aktif</span>
        </div>
    </div>
</div>

<div class="row mt-4 g-3">
    <div class="col-12 col-md-4">
        <div class="card text-bg-primary border-0 shadow-sm">
            <div class="card-body d-flex align-items-center">
                <div class="me-3 fs-2"><i class="fas fa-book"></i></div>
                <div>
                    <div class="fs-4 fw-bold"><?= $total ?></div>
                    <div class="small">Total Peminjaman</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4">
        <div class="card text-bg-warning border-0 shadow-sm">
            <div class="card-body d-flex align-items-center">
                <div class="me-3 fs-2"><i class="fas fa-book-reader"></i></div>
                <div>
                    <div class="fs-4 fw-bold"><?= $aktif ?></div>
                    <div class="small">Masih Dipinjam</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4">
        <div class="card text-bg-success border-0 shadow-sm">
            <div class="card-body d-flex align-items-center">
                <div class="me-3 fs-2"><i class="fas fa-check-circle"></i></div>
                <div>
                    <div class="fs-4 fw-bold"><?= $kembali ?></div>
                    <div class="small">Sudah Dikembalikan</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4 g-3">
    <div class="col-12 col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pb-0">
                <h6 class="mb-0 fw-semibold"><i class="fas fa-user me-2 text-primary"></i> Biodata Siswa</h6>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <i class="fas fa-user fa-fw text-secondary me-3"></i>
                    <div>
                        <div class="fw-semibold"><?= htmlspecialchars($user['firstname'] . ' ' . $user['lastname']) ?></div>
                        <div class="small text-muted">Nama Lengkap</div>
                    </div>
                </div>
                <div class="d-flex align-items-center mb-3">
                    <i class="fas fa-envelope fa-fw text-secondary me-3"></i>
                    <div>
                        <div class="fw-semibold"><?= htmlspecialchars($user['email']) ?></div>
                        <div class="small text-muted">Email</div>
                    </div>
                </div>
                <div class="d-flex align-items-center mb-3">
                    <i class="fas fa-phone fa-fw text-secondary me-3"></i>
                    <div>
                        <div class="fw-semibold"><?= htmlspecialchars($user['contact']) ?></div>
                        <div class="small text-muted">Kontak</div>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <i class="fas fa-map-marker-alt fa-fw text-secondary me-3"></i>
                    <div>
                        <div class="fw-semibold"><?= htmlspecialchars($user['address']) ?></div>
                        <div class="small text-muted">Alamat</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Kamu bisa tambah card lain di sini jika ingin -->
</div>
