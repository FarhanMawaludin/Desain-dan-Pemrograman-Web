<?php
include 'partials/header.php';

$prestasiController = new PrestasiController($conn);
$id_mahasiswa = $_SESSION['user']['id_mahasiswa'];

$prestasiList = $prestasiController->showPrestasi($id_mahasiswa);

?>

<div class="info">
    <p class="info-text">Home - Prestasi</p>
</div>

<div class="card p-4" style="margin: 50px 84px 50px 84px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="card-title fw-semibold mb-0 fs-4" style="color: #475261;">
            List Prestasi
        </h5>
        <div class="d-flex align-items-center gap-3">
            <div class="input-group" style="max-width: 300px;">
                <button class="btn btn-primary" type="button"
                    style="color: white; background-color: #244282; outline: none; border: none;">
                    <i class="fas fa-search"></i>
                </button>
                <input class="form-control" placeholder="Search Prestasi" type="text" />
            </div>
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-primary d-flex justify-content-center align-items-center gap-2"
                    style="color: white; background-color: #244282; outline: none; border: none;">
                    <i class="fas fa-plus"></i>
                    <a href="index.php?page=tambahprestasi" style="text-decoration: none; color: white;">
                        <p class="mb-0">Tambah</p>
                    </a>
                </button>
            </div>
        </div>
    </div>
    <table class="table table-hover ">
        <thead>
            <tr>
                <th>Juara</th>
                <th>Lomba</th>
                <th>Tingkat</th>
                <th>Tempat Kompetisi</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($prestasiList)) : ?>
                <?php foreach ($prestasiList as $prestasi) : ?>
                    <tr>
                        <!-- Kolom Juara -->
                        <td class="align-middle text-left">
                            <?= htmlspecialchars($prestasi['juara']); ?>
                        </td>

                        <!-- Kolom Jenis Kompetisi -->
                        <td class="align-middle text-left">
                            <?= htmlspecialchars($prestasi['jenis_kompetisi']); ?>
                        </td>

                        <!-- Kolom Tingkat Kompetisi -->
                        <td class="align-middle text-left">
                            <?= htmlspecialchars($prestasi['tingkat_kompetisi']); ?>
                        </td>

                        <!-- Kolom Waktu Pelaksanaan -->


                        <!-- Kolom Tempat Kompetisi -->
                        <td class="align-middle text-left">
                            <?= htmlspecialchars($prestasi['tempat_kompetisi']); ?>
                        </td>

                        <!-- Kolom Status Pengajuan -->
                        <td class="align-middle text-left">
                            <span style="
                        background-color: <?=
                                            $prestasi['status_pengajuan'] === 'disetujui' ? '#DCFCE7' : ($prestasi['status_pengajuan'] === 'ditolak' ? '#FEE2E2' : '#EAEDEF'); ?>; 
                        color: <?=
                                $prestasi['status_pengajuan'] === 'disetujui' ? '#166534' : ($prestasi['status_pengajuan'] === 'ditolak' ? '#991B1B' : '#212529'); ?>; 
                        padding: 4px 8px; 
                        border-radius: 4px; 
                        font-size: 14px; 
                        font-weight: bold;
                        display: inline-block;
                    ">
                                <?= htmlspecialchars($prestasi['status_pengajuan']); ?>
                            </span>
                        </td>

                        <!-- Kolom Actions -->
                        <td class="align-middle text-left">
                            <div class="d-flex align-items-center justify-content-start gap-1">
                                <!-- Tombol Detail -->
                                <a href="index.php?page=prestasidetail&id_prestasi=<?php echo $prestasi['id_prestasi']; ?>" class="btn btn-outline-primary btn-xs">
                                    <i class="fas fa-file-alt"></i>
                                </a>

                                <!-- Tombol Edit -->
                                <a href="index.php?page=prestasiedit&id_prestasi=<?php echo $prestasi['id_prestasi']; ?>" class="btn btn-outline-warning btn-xs">
                                    <i class="fas fa-edit"></i>
                                </a>

                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <!-- Pesan Jika Tidak Ada Data -->
                <tr>
                    <td colspan="7" class="text-center">
                        Tidak ada data prestasi tersedia.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <select class="form-select" style="width: 70px;">
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="30">30</option>
            </select>
        </div>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item">
                    <a aria-label="Previous" class="page-link" href="#">
                        <span aria-hidden="true">«</span>
                    </a>
                </li>
                <li class="page-item active">
                    <a class="page-link" href="#">1</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">2</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">...</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">10</a>
                </li>
                <li class="page-item">
                    <a aria-label="Next" class="page-link" href="#">
                        <span aria-hidden="true">»</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>

<?php include 'partials/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>