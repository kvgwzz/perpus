<?php
$qBooks = mysqli_query($db, "SELECT * FROM book ORDER BY book_title ASC");
?>
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0">
        <h5 class="mb-0 fw-semibold"><i class="fas fa-book me-2"></i> Katalog Buku</h5>
    </div>
    <div class="card-body table-responsive">
        <table class="table align-middle table-hover table-bordered mb-0">
            <thead class="table-light">
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Kategori</th>
                <th>Penerbit</th>
                <th>ISBN</th>
                <th>Tahun</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            <?php $no=1; while($b = mysqli_fetch_assoc($qBooks)): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($b['book_title']) ?></td>
                    <td><?= htmlspecialchars($b['author']) ?></td>
                    <td><?= htmlspecialchars($b['category']) ?></td>
                    <td><?= htmlspecialchars($b['publisher_name']) ?></td>
                    <td><?= htmlspecialchars($b['isbn']) ?></td>
                    <td><?= htmlspecialchars($b['copyright_year']) ?></td>
                    <td>
                        <?php if($b['status']=='1'): ?>
                            <span class="badge bg-success">Tersedia</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Tidak Tersedia</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
