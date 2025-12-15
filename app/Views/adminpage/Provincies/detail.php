<?php $this->extend('layout/sidebar') ?>
<?php $this->section('content') ?>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="<?= base_url('css/province-detail.css') ?>" rel="stylesheet">

<div class="detail-page">
    <div class="page-wrapper">
        <div class="page-container">

            <!-- ===== BREADCRUMB & TITLE ===== -->
            <div class="page-header-section mb-4">
                <a href="<?= base_url('admin/provinces') ?>" class="breadcrumb-link">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <h2 class="page-title">
                    <span class="title-icon">📍</span>
                    Kota/Kabupaten di <strong><?= esc($province['name']) ?></strong>
                </h2>
            </div>

            <!-- ===== TOP CONTROL AREA ===== -->
            <div class="controls-section mb-4">
                <form method="get" action="<?= base_url('admin/provinces/' . $province['id']) ?>" class="search-form">
                    <input type="text" name="search" class="form-control" 
                           placeholder="Cari kota/kabupaten..."
                           value="<?= esc($search) ?>">

                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i> Cari
                    </button>

                    <?php if ($search): ?>
                        <a href="<?= base_url('admin/provinces/' . $province['id']) ?>" class="btn btn-outline-info">
                            Reset
                        </a>
                    <?php endif; ?>

                    <!-- ➕ TAMBAH KOTA -->
                    <a href="<?= base_url('admin/provinces/' . $province['id'] . '/cities/create') ?>" 
                       class="btn btn-success">
                        <i class="fas fa-plus"></i> Tambah Kota/Kabupaten
                    </a>
                </form>
            </div>

            <!-- ===== FLASH MESSAGE ===== -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle"></i>
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle"></i>
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- ===== TABLE WRAPPER ===== -->
            <div class="table-container">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th width="80">No</th>
                            <th>Nama Kota/Kabupaten</th>
                            <th width="200">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (empty($cities)): ?>
                            <tr>
                                <td colspan="3" class="text-center empty-state">
                                    <i class="fas fa-inbox empty-icon"></i>
                                    <p>Tidak ada data kota/kabupaten</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php $no = ($pager->getCurrentPage() - 1) * $pager->getPerPage() + 1; ?>
                            <?php foreach ($cities as $city): ?>
                                <tr>
                                    <td data-label="No"><?= $no++ ?></td>

                                    <td data-label="Nama Kota/Kabupaten">
                                        <span class="city-name">
                                            <i class="fas fa-building city-icon"></i>
                                            <?= esc($city['name']) ?>
                                        </span>
                                    </td>

                                    <td data-label="Aksi">
                                        <div class="action-buttons">
                                            <a href="<?= base_url("admin/provinces/{$province['id']}/cities/edit/{$city['id']}") ?>"
                                               class="btn btn-edit btn-sm">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>

                                            <form action="<?= base_url("admin/provinces/{$province['id']}/cities/delete/{$city['id']}") ?>"
                                                  method="post" class="d-inline">
                                                <button type="submit" class="btn btn-delete btn-sm"
                                                        onclick="return confirm('Hapus kota/kabupaten ini?')">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- ===== PAGINATION ===== -->
            <?php if ($pager && $pager->getPageCount() > 1): ?>
                <div class="pagination-wrapper">
                    <?= $pager->links() ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php $this->endSection() ?>