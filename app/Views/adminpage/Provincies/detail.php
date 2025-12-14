<?php $this->extend('layout/sidebar') ?>
<?php $this->section('content') ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>
        <a href="<?= base_url('admin/provinces') ?>" class="text-decoration-none">
            ← Kembali
        </a>
        <i class="fas fa-angle-right mx-2"></i>
        Kota/Kabupaten di <strong><?= esc($province['name']) ?></strong>
    </h2>
    <a href="<?= base_url("admin/provinces/{$province['id']}/cities/create") ?>" class="btn btn-primary">
        + Tambah Kota/Kabupaten
    </a>
</div>
<form method="get" class="mb-4">
    <div class="input-group" style="max-width: 400px;">
        <input type="text" name="search" class="form-control" placeholder="Cari kota/kabupaten..." 
               value="<?= esc($search) ?>">
        <button class="btn btn-primary" type="submit">Cari</button>
        <?php if ($search): ?>
            <a href="<?= base_url("admin/provinces/{$province['id']}") ?>" class="btn btn-outline-secondary">Reset</a>
        <?php endif; ?>
    </div>
</form>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<table class="table table-bordered table-hover">
    <thead class="table-light">
        <tr>
            <th width="80">No</th>
            <th>Nama Kota/Kabupaten</th>
            <th width="150">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($cities)): ?>
            <tr>
                <td colspan="3" class="text-center text-muted">Belum ada kota/kabupaten</td>
            </tr>
        <?php else: ?>
            <?php $no = 1; foreach ($cities as $city): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= esc($city['name']) ?></td>
                <td>
                    <a href="<?= base_url("admin/provinces/{$province['id']}/cities/edit/{$city['id']}") ?>" 
                       class="btn btn-sm btn-warning">Edit</a>
                    <form action="<?= base_url("admin/provinces/{$province['id']}/cities/delete/{$city['id']}") ?>" 
                          method="post" class="d-inline">
                        <button type="submit" class="btn btn-sm btn-danger" 
                                onclick="return confirm('Yakin hapus <?= esc($city['name']) ?>?')">Hapus</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
<!-- Di paling bawah detail.php, sebelum endSection -->
<!-- Pagination -->
<?php if ($pager && $pager->getPageCount() > 1) : ?>
    <div class="d-flex justify-content-center mt-4">
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <?= $pager->links() ?>
            </ul>
        </nav>
    </div>
<?php endif; ?>

<?php $this->endSection() ?>