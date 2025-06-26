<?php
include_once(__DIR__ . '/../../koneksi.php');

// Ambil data anggota dan buku
$qMember = mysqli_query($db, "SELECT member_id, firstname, lastname FROM member WHERE status=1 ORDER BY firstname");
$qBook = mysqli_query($db, "SELECT book_id, book_title, book_copies FROM book WHERE book_copies > 0 ORDER BY book_title");

// Handle submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $member_id = intval($_POST['member_id']);
    $book_id   = intval($_POST['book_id']);
    $date_borrow = $_POST['date_borrow'];
    $due_date    = $_POST['due_date'];
    $status = 1; // Dipinjam

    if (!$member_id || !$book_id || !$date_borrow || !$due_date) {
        $msg = '<div class="alert alert-warning mb-3">Semua field wajib diisi.</div>';
    } else {
        // Cek stok terbaru (race condition safe)
        $stok = 0;
        $qStok = mysqli_query($db, "SELECT book_copies FROM book WHERE book_id=$book_id");
        if ($d = mysqli_fetch_assoc($qStok)) $stok = (int)$d['book_copies'];

        if ($stok <= 0) {
            $msg = '<div class="alert alert-danger mb-3">Buku ini sudah habis stoknya!</div>';
        } else {
            $simpan1 = mysqli_query($db, "INSERT INTO borrow (member_id, date_borrow, due_date) VALUES ($member_id, '$date_borrow', '$due_date')");
            if ($simpan1) {
                $borrow_id = mysqli_insert_id($db);
                $simpan2 = mysqli_query($db, "INSERT INTO borrowdetails (borrow_id, book_id, borrow_status) VALUES ($borrow_id, $book_id, $status)");
                mysqli_query($db, "UPDATE book SET book_copies = book_copies - 1 WHERE book_id = $book_id");

                // Update status buku
                $qCekStok = mysqli_query($db, "SELECT book_copies FROM book WHERE book_id = $book_id");
                $dataStok = mysqli_fetch_assoc($qCekStok);
                $sisa = (int)$dataStok['book_copies'];
                if ($sisa <= 0) {
                    mysqli_query($db, "UPDATE book SET status='0' WHERE book_id=$book_id");
                } else {
                    mysqli_query($db, "UPDATE book SET status='1' WHERE book_id=$book_id");
                }

                if ($simpan2) {
                    $msg = '<div class="alert alert-success mb-3">Data peminjaman berhasil disimpan.</div>';
                } else {
                    $msg = '<div class="alert alert-danger mb-3">Gagal simpan detail peminjaman.</div>';
                }
            } else {
                $msg = '<div class="alert alert-danger mb-3">Gagal simpan data peminjaman.</div>';
            }
        }
    }
}
?>
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2 align-items-center">
      <div class="col-sm-6">
        <h1 class="mb-0"><i class="fas fa-book-reader text-primary me-2"></i>Tambah Peminjaman</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right bg-white px-2 py-1 rounded shadow-sm">
          <li class="breadcrumb-item"><a href="admin.php">Home</a></li>
          <li class="breadcrumb-item"><a href="admin.php?p=listtransaksi">Data Peminjaman</a></li>
          <li class="breadcrumb-item active">Tambah Peminjaman</li>
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
            <h3 class="card-title mb-0 fw-semibold"><i class="fas fa-book-reader me-2"></i> Form Tambah Peminjaman</h3>
          </div>
          <form method="post" autocomplete="off">
            <div class="card-body px-4 py-4">
              <?php if(isset($msg)) echo $msg; ?>
              <div class="row g-4">
                <!-- Baris 1: Anggota & Buku -->
                <div class="col-md-6">
                  <div class="form-group mb-3">
                    <label for="member_id" class="fw-semibold"><i class="fas fa-user me-1 text-secondary"></i>Nama Anggota <span class="text-danger">*</span></label>
                    <select name="member_id" id="member_id" class="form-control form-control-lg" required>
                      <option value="">-- Pilih Anggota --</option>
                      <?php
                      $qMember2 = mysqli_query($db, "SELECT member_id, firstname, lastname FROM member WHERE status=1 ORDER BY firstname");
                      while($m = mysqli_fetch_assoc($qMember2)): ?>
                        <option value="<?= $m['member_id'] ?>"><?= htmlspecialchars($m['firstname'].' '.$m['lastname']) ?></option>
                      <?php endwhile; ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group mb-3">
                    <label for="book_id" class="fw-semibold"><i class="fas fa-book me-1 text-secondary"></i>Buku <span class="text-danger">*</span></label>
                    <select name="book_id" id="book_id" class="form-control form-control-lg" required>
                      <option value="">-- Pilih Buku Tersedia --</option>
                      <?php
                      $qBook2 = mysqli_query($db, "SELECT book_id, book_title, book_copies FROM book WHERE book_copies > 0 ORDER BY book_title");
                      while($b = mysqli_fetch_assoc($qBook2)): ?>
                        <option value="<?= $b['book_id'] ?>">
                          <?= htmlspecialchars($b['book_title']) ?> (Tersisa: <?= (int)$b['book_copies'] ?>)
                        </option>
                      <?php endwhile; ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row g-4">
                <!-- Baris 2: Tanggal -->
                <div class="col-md-6">
                  <div class="form-group mb-3">
                    <label for="date_borrow" class="fw-semibold"><i class="fas fa-calendar-alt me-1 text-secondary"></i>Tanggal Pinjam <span class="text-danger">*</span></label>
                    <input type="date" name="date_borrow" id="date_borrow" class="form-control form-control-lg" required value="<?= date('Y-m-d') ?>">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group mb-3">
                    <label for="due_date" class="fw-semibold"><i class="fas fa-calendar-check me-1 text-secondary"></i>Jatuh Tempo <span class="text-danger">*</span></label>
                    <input type="date" name="due_date" id="due_date" class="form-control form-control-lg" required>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer bg-light border-top text-end">
              <button type="submit" class="btn btn-primary px-4 me-2"><i class="fas fa-save me-2"></i> Simpan</button>
              <a href="admin.php?p=listtransaksi" class="btn btn-secondary px-4">Batal</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
