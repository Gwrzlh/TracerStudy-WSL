<?php $this->extend('layout/sidebar') ?>
<?php $this->section('content') ?>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="<?= base_url('css/city-form.css') ?>" rel="stylesheet">

<div class="form-page">
    <div class="page-wrapper">
        <div class="page-container">

            <!-- ===== BREADCRUMB ===== -->
            <div class="breadcrumb-section mb-3">
                <a href="<?= base_url('admin/provinces/' . $province['id']) ?>" class="breadcrumb-link">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar Provinsi
                </a>
            </div>

            <!-- ===== PAGE HEADER ===== -->
            <div class="page-header mb-4">
                <div class="header-icon icon-warning">
                    <i class="fas fa-edit"></i>
                </div>
                <div class="header-text">
                    <h1 class="page-title">Edit Kota/Kabupaten</h1>
                    <p class="page-subtitle">Ubah data kota/kabupaten yang sudah ada</p>
                </div>
            </div>

            <!-- ===== FLASH MESSAGE ===== -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle"></i>
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- ===== FORM CARD ===== -->
            <div class="form-card">
                <form action="<?= base_url("admin/provinces/{$province['id']}/cities/update/{$city['id']}") ?>" method="post">
                    
                    <!-- Form Group: Provinsi (Disabled) -->
                    <div class="form-group">
                        <label for="province" class="form-label">
                            <i class="fas fa-map-marked-alt label-icon"></i>
                            Provinsi
                        </label>
                        <input 
                            type="text" 
                            id="province"
                            class="form-input form-input-disabled"
                            value="<?= esc($province['name']) ?>" 
                            disabled>
                        <div class="form-hint">
                            <i class="fas fa-info-circle"></i>
                            Provinsi tidak dapat diubah pada form ini
                        </div>
                    </div>

                    <!-- Form Group: Nama Kota -->
                    <div class="form-group">
                        <label for="name" class="form-label">
                            <i class="fas fa-building label-icon"></i>
                            Nama Kota/Kabupaten
                            <span class="required-mark">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="name"
                            name="name" 
                            class="form-input <?= (session()->getFlashdata('errors')['name'] ?? false) ? 'is-invalid' : '' ?>"
                            value="<?= old('name', $city['name']) ?>"
                            placeholder="Contoh: Bandung atau Kabupaten Bandung"
                            required>
                        
                        <?php if (session()->getFlashdata('errors')['name'] ?? false): ?>
                            <div class="error-message">
                                <i class="fas fa-exclamation-triangle"></i>
                                <?= session()->getFlashdata('errors')['name'] ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="form-hint">
                            <i class="fas fa-info-circle"></i>
                            Masukkan nama kota atau kabupaten dengan format yang benar
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="form-actions">
                        <a href="<?= base_url('admin/provinces/' . $province['id']) ?>" class="btn btn-cancel">
                            <i class="fas fa-times"></i>
                            Batal
                        </a>
                        <button type="submit" class="btn btn-submit btn-warning-gradient">
                            <i class="fas fa-save"></i>
                            Update Kota/Kabupaten
                        </button>
                    </div>

                </form>
            </div>

            <!-- ===== INFO BOX ===== -->
            <div class="info-box mt-4">
                <div class="info-icon">
                    <i class="fas fa-lightbulb"></i>
                </div>
                <div class="info-content">
                    <h3 class="info-title">Tips:</h3>
                    <ul class="info-list">
                        <li>Pastikan nama kota/kabupaten ditulis dengan benar dan lengkap</li>
                        <li>Gunakan huruf kapital di awal setiap kata</li>
                        <li>Perubahan akan langsung terlihat di daftar kota</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>

<?php $this->endSection() ?>