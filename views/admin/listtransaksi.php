<?php
// Debug path & koneksi
echo "<pre>";
echo "DIR: " . __DIR__ . PHP_EOL;
echo "FILE: " . realpath(__DIR__ . '/../../koneksi.php') . PHP_EOL;
echo "</pre>";

// Validasi file koneksi
if (!file_exists(__DIR__ . '/../../koneksi.php')) {
    die('File koneksi.php TIDAK DITEMUKAN di: ' . __DIR__ . '/../../koneksi.php');
}
include_once(__DIR__ . '/../../koneksi.php');

// OPTIONAL: Jika ingin include login.php juga
// if (file_exists(__DIR__ . '/../../login.php')) {
//     include_once(__DIR__ . '/../../login.php');
// }

// Validasi koneksi
if (!isset($db) || !$db) {
    die("Koneksi ke database gagal.");
}
?>
<!-- Mulai HTML -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Data Peminjaman Buku</h1>
      </div>
      <div class="col-sm-6 text-right">
        <a href="admin.php?p=addborrow" class="btn btn-primary">Tambah Peminjaman</a>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="card">
    <div class="card-body">
      <table id="example1" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Anggota</th>
            <th>Judul Buku</th>
            <th>Tanggal Pinjam</th>
            <th>Jatuh Tempo</th>
            <th>Tanggal Kembali</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
<?php
$query = mysqli_query($db, "SELECT b.borrow_id, m.firstname, m.lastname, bk.book_title, b.date_borrow, b.due_date,
                                bd.date_return, bd.borrow_status
                                FROM borrow b
                                JOIN member m ON b.member_id = m.member_id
                                JOIN borrowdetails bd ON b.borrow_id = bd.borrow_id
                                JOIN book bk ON bd.book_id = bk.book_id
                                ORDER BY b.date_borrow DESC");

if (!$query) {
    echo '<tr><td colspan="8">Query gagal: ' . htmlspecialchars(mysqli_error($db)) . '</td></tr>';
} else {
    $no = 1;
    while ($row = mysqli_fetch_assoc($query)) {
        echo '<tr>';
        echo '<td>' . $no++ . '</td>';
        echo '<td>' . htmlspecialchars($row['firstname'] . ' ' . $row['lastname']) . '</td>';
        echo '<td>' . htmlspecialchars($row['book_title']) . '</td>';
        echo '<td>' . htmlspecialchars($row['date_borrow']) . '</td>';
        echo '<td>' . htmlspecialchars($row['due_date']) . '</td>';
        echo '<td>' . (isset($row['date_return']) ? htmlspecialchars($row['date_return']) : '-') . '</td>';
        echo '<td>';
            if ($row['borrow_status'] == 'returned') {
                echo '<span class="badge bg-success">Dikembalikan</span>';
            } else {
                echo '<span class="badge bg-warning">Dipinjam</span>';
            }
        echo '</td>';
        echo '<td>
                <a href="admin.php?p=editborrow&id=' . $row['borrow_id'] . '" class="btn btn-sm btn-warning">Edit</a>
                <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#hapusModal' . $row['borrow_id'] . '">Hapus</button>
              </td>';
        echo '</tr>';

        // Modal Konfirmasi Hapus
        echo '<div class="modal fade" id="hapusModal' . $row['borrow_id'] . '" tabindex="-1">
                <div class="modal-dialog">
                  <form method="POST" action="views/admin/deleteborrow.php">
                    <input type="hidden" name="borrow_id" value="' . $row['borrow_id'] . '">
                    <div class="modal-content">
                      <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                      </div>
                      <div class="modal-body">
                        Yakin ingin menghapus transaksi ini?
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>';
    }
}
?>
        </tbody>
      </table>
    </div>
  </div>
</section>
