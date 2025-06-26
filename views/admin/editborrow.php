<?php
include_once(__DIR__ . '/../../koneksi.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) die("Transaksi tidak valid.");

// Ambil data transaksi & detail
$q = mysqli_query($db, "SELECT b.borrow_id, m.firstname, m.lastname, bk.book_id, bk.book_title, b.date_borrow, b.due_date, bd.date_return, bd.borrow_status
                        FROM borrow b
                        JOIN member m ON b.member_id = m.member_id
                        JOIN borrowdetails bd ON b.borrow_id = bd.borrow_id
                        JOIN book bk ON bd.book_id = bk.book_id
                        WHERE b.borrow_id = $id LIMIT 1");
$data = mysqli_fetch_assoc($q);
if (!$data) die("Data transaksi tidak ditemukan.");

// Untuk select
$status_options = [
    1 => "Dipinjam",
    2 => "Dikembalikan",
    3 => "Hilang"
];

$msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date_return = $_POST['date_return'];
    $borrow_status = intval($_POST['borrow_status']);
    $old_status = intval($_POST['old_status']);
    $book_id = intval($data['book_id']);

    // Proses update status dan tanggal kembali
    $upd = mysqli_query($db, "UPDATE borrowdetails SET date_return=" . 
        ($date_return ? "'$date_return'" : "NULL") . 
        ", borrow_status=$borrow_status WHERE borrow_id=$id");

    // Logika stok buku
    if ($upd) {
        // Jika status diubah dari Dipinjam/Hilang -> Dikembalikan, tambahkan stok & update status buku
        if (($old_status != 2) && ($borrow_status == 2)) {
            mysqli_query($db, "UPDATE book SET book_copies = book_copies + 1 WHERE book_id=$book_id");
            // Jika stok > 0, status buku jadi tersedia
            $qCekStok = mysqli_query($db, "SELECT book_copies FROM book WHERE book_id=$book_id");
            $stok = mysqli_fetch_assoc($qCekStok)['book_copies'];
            if ($stok > 0) {
                mysqli_query($db, "UPDATE book SET status='1' WHERE book_id=$book_id");
            }
        }
        // Jika status diubah dari Dikembalikan -> Dipinjam, kurangi stok
        if (($old_status == 2) && ($borrow_status == 1)) {
            mysqli_query($db, "UPDATE book SET book_copies = book_copies - 1 WHERE book_id=$book_id");
            // Jika stok habis, status buku tidak tersedia
            $qCekStok = mysqli_query($db, "SELECT book_copies FROM book WHERE book_id=$book_id");
            $stok = mysqli_fetch_assoc($qCekStok)['book_copies'];
            if ($stok <= 0) {
                mysqli_query($db, "UPDATE book SET status='0' WHERE book_id=$book_id");
            }
        }
        // Jika status jadi Hilang, stok tidak berubah
        $msg = '<div class="alert alert-success">Data transaksi berhasil diperbarui.</div>';
        // Refresh data
        $q = mysqli_query($db, "SELECT b.borrow_id, m.firstname, m.lastname, bk.book_id, bk.book_title, b.date_borrow, b.due_date, bd.date_return, bd.borrow_status
                                FROM borrow b
                                JOIN member m ON b.member_id = m.member_id
                                JOIN borrowdetails bd ON b.borrow_id = bd.borrow_id
                                JOIN book bk ON bd.book_id = bk.book_id
                                WHERE b.borrow_id = $id LIMIT 1");
        $data = mysqli_fetch_assoc($q);
    } else {
        $msg = '<div class="alert alert-danger">Gagal memperbarui data transaksi.</div>';
    }
}
?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-6">
                <h1 class="mb-0"><i class="fas fa-edit text-primary me-2"></i>Edit Transaksi Peminjaman</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right bg-white px-2 py-1 rounded shadow-sm">
                    <li class="breadcrumb-item"><a href="admin.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="admin.php?p=listtransaksi">Data Peminjaman</a></li>
                    <li class="breadcrumb-item active">Edit Transaksi</li>
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
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title mb-0 fw-semibold"><i class="fas fa-edit me-2"></i> Edit Transaksi Peminjaman</h3>
                    </div>
                    <form method="post" autocomplete="off">
                        <div class="card-body px-4 py-4">
                            <?php if($msg) echo $msg; ?>
                            <div class="row g-4 mb-3">
                                <div class="col-md-3">
                                    <div class="small text-muted fw-bold">Nama Anggota</div>
                                    <div class="fw-semibold"><?= htmlspecialchars($data['firstname'].' '.$data['lastname']) ?></div>
                                </div>
                                <div class="col-md-3">
                                    <div class="small text-muted fw-bold">Judul Buku</div>
                                    <div class="fw-semibold"><?= htmlspecialchars($data['book_title']) ?></div>
                                </div>
                                <div class="col-md-3">
                                    <div class="small text-muted fw-bold">Tanggal Pinjam</div>
                                    <div><?= htmlspecialchars($data['date_borrow']) ?></div>
                                </div>
                                <div class="col-md-3">
                                    <div class="small text-muted fw-bold">Jatuh Tempo</div>
                                    <div><?= htmlspecialchars($data['due_date']) ?></div>
                                </div>
                            </div>
                            <hr class="mb-4">
                            <div class="mb-4">
                                <label class="form-label fw-semibold"><i class="fas fa-calendar-check me-2"></i>Tanggal Kembali</label>
                                <input type="date" name="date_return" class="form-control form-control-lg" value="<?= htmlspecialchars($data['date_return']??'') ?>">
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-semibold"><i class="fas fa-flag me-2"></i>Status</label>
                                <select name="borrow_status" class="form-control form-control-lg" required>
                                    <?php foreach($status_options as $k=>$v): ?>
                                        <option value="<?= $k ?>" <?= ($data['borrow_status']==$k?'selected':'') ?>><?= $v ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <input type="hidden" name="old_status" value="<?= htmlspecialchars($data['borrow_status']) ?>">
                        </div>
                        <div class="card-footer bg-light border-top text-end">
                            <button type="submit" class="btn btn-primary px-4 me-2"><i class="fas fa-save me-2"></i> Simpan Perubahan</button>
                            <a href="admin.php?p=listtransaksi" class="btn btn-secondary px-4">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
