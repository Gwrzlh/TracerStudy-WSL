<?php $this->extend('layout/sidebar') ?>
<?php $this->section('content') ?>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="<?= base_url('css/provincies.css') ?>" rel="stylesheet">

<div class="pengguna-page">
    <div class="page-wrapper">
        <div class="page-container">

            <!-- ===== PAGE TITLE ===== -->
            <h2 class="page-title mb-4">Daftar Provinsi Indonesia</h2>

            <!-- ===== TOP CONTROL AREA ===== -->
            <div class="controls-section d-flex flex-column gap-3 mb-4">

                <!-- 🔍 SEARCH BAR -->
                <form method="get" action="<?= base_url('admin/provinces') ?>" class="d-flex gap-2 flex-wrap">
                    <input type="text" name="search" class="form-control" 
                           placeholder="Cari provinsi..."
                           value="<?= esc($search) ?>">

                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i> Cari
                    </button>

                    <?php if ($search): ?>
                        <a href="<?= base_url('admin/provinces') ?>" class="btn btn-outline-info">
                            Reset
                        </a>
                    <?php endif; ?>

                    <!-- ➕ TAMBAH PROVINSI -->
                    <a href="<?= base_url('admin/provinces/create') ?>" class="btn btn-success">
                        <i class="fas fa-plus"></i> Tambah Provinsi
                    </a>
                </form>

            </div> <!-- controls-section -->

            <!-- ===== FLASH MESSAGE ===== -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert">×</button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert">×</button>
                </div>
            <?php endif; ?>

            <!-- ===== TABLE WRAPPER ===== -->
            <div class="table-container">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th width="80">No</th>
                            <th>Nama Provinsi</th>
                            <th width="200">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (empty($provinces)): ?>
                            <tr>
                                <td colspan="3" class="text-center empty-state">
                                    Tidak ada data provinsi
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php $no = ($pager->getCurrentPage() - 1) * $pager->getPerPage() + 1; ?>
                            <?php foreach ($provinces as $province): ?>
                                <tr>
                                    <td data-label="No"><?= $no++ ?></td>

                                    <td data-label="Nama Provinsi">
                                         <a href="<?= base_url('admin/provinces/' . $province['id']) ?>" 
                                                class="text-decoration-none fw-bold text-primary">
                                                <?= esc($province['name']) ?>
                                            </a>
                                    </td>

                                    <td data-label="Aksi">
                                        <a href="<?= base_url("admin/provinces/edit/{$province['id']}") ?>"
                                           class="btn btn-edit btn-sm">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>

                                        <form action="<?= base_url("admin/provinces/delete/{$province['id']}") ?>"
                                              method="post" class="d-inline">
                                            <button type="submit" class="btn btn-delete btn-sm"
                                                    onclick="return confirm('Hapus provinsi ini? Semua kota akan ikut terhapus!')">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- ===== PAGINATION ===== -->
            <?php if ($pager && $pager->getPageCount() > 1): ?>
                <div class="d-flex justify-content-center mt-4">
                    <?= $pager->links() ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php $this->endSection() ?>
