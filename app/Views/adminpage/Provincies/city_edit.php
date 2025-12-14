<?php $this->extend('layout/sidebar') ?>
<?php $this->section('content') ?>

<h3>Edit Kota/Kabupaten</h3>
<a href="<?= base_url('admin/provinces/' . $province['id']) ?>" class="btn btn-secondary mb-3">← Kembali</a>

<form action="<?= base_url("admin/provinces/{$province['id']}/cities/update/{$city['id']}") ?>" method="post">
    <div class="mb-3">
        <label>Provinsi</label>
        <input type="text" class="form-control" value="<?= esc($province['name']) ?>" disabled>
    </div>
    <div class="mb-3">
        <label class="form-label">Nama Kota/Kabupaten</label>
        <input type="text" name="name" class="form-control" value="<?= old('name', $city['name']) ?>" required>
        <?php if (session()->getFlashdata('errors')['name'] ?? false): ?>
            <small class="text-danger"><?= session()->getFlashdata('errors')['name'] ?></small>
        <?php endif; ?>
    </div>
    <button type="submit" class="btn btn-warning">Update Kota/Kabupaten</button>
</form>

<?php $this->endSection() ?>