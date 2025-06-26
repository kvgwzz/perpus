<?php
$qTrans = mysqli_query($db, "
    SELECT bk.book_title, b.date_borrow, b.due_date, bd.date_return, bd.borrow_status
    FROM borrow b
    JOIN borrowdetails bd ON b.borrow_id = bd.borrow_id
    JOIN book bk ON bd.book_id = bk.book_id
    WHERE b.member_id = '$member_id'
    ORDER BY b.date_borrow DESC
");
?>
<div class="card border-0 shadow-sm mt-4">
    <div class="card-header bg-white border-0">
        <h5 class="mb-0 fw-semibold"><i class="fas fa-history me-2"></i> Riwayat Peminjaman Buku</h5>
    </div>
    <div class="card-body table-responsive">
        <table class="table align-middle table-hover table-bordered mb-0">
            <thead class="table-light">
            <tr>
                <th>No</th>
                <th>Judul Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Jatuh Tempo</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $no = 1; $adaData = false;
            while ($row = mysqli_fetch_assoc($qTrans)) {
                $adaData = true;
                echo "<tr>";
                echo "<td>".$no++."</td>";
                echo "<td>".htmlspecialchars($row['book_title'])."</td>";
                echo "<td>".htmlspecialchars($row['date_borrow'])."</td>";
                echo "<td>".htmlspecialchars($row['due_date'])."</td>";
                echo "<td>".($row['date_return'] ? htmlspecialchars($row['date_return']) : "-")."</td>";
                echo "<td>";
                if ($row['borrow_status']==2) {
                    echo '<span class="badge bg-success badge-status">Dikembalikan</span>';
                } else {
                    echo '<span class="badge bg-warning text-dark badge-status">Dipinjam</span>';
                }
                echo "</td>";
                echo "</tr>";
            }
            if(!$adaData){
                echo '<tr><td colspan="6" class="text-center text-secondary">Belum ada riwayat peminjaman.</td></tr>';
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
