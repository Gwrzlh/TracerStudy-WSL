<?php $this->extend('layout/sidebar') ?>
<?php $this->section('content') ?>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="<?= base_url('css/province-edit.css') ?>" rel="stylesheet">
<style>/* =========================================
   PROVINCE EDIT PAGE - MODERN DESIGN
   Konsisten dengan tampilan lainnya
========================================= */

/* Reset & Base */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.edit-page {
    background: #f8fafc;
    min-height: 100vh;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
}

/* =========================================
   PAGE WRAPPER & CONTAINER
========================================= */
.page-wrapper {
    padding: 32px;
    max-width: 900px;
    margin: 0 auto;
}

.page-container {
    background: white;
    border-radius: 16px;
    padding: 32px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06), 0 1px 2px rgba(0, 0, 0, 0.04);
}

/* =========================================
   BREADCRUMB
========================================= */
.breadcrumb-section {
    margin-bottom: 20px;
}

.breadcrumb-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #64748b;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    padding: 8px 16px;
    border-radius: 8px;
    transition: all 0.2s ease;
    background: #f1f5f9;
}

.breadcrumb-link:hover {
    background: #e2e8f0;
    color: #334155;
    transform: translateX(-4px);
}

.breadcrumb-link i {
    font-size: 12px;
}

/* =========================================
   PAGE HEADER
========================================= */
.page-header {
    display: flex;
    align-items: center;
    gap: 20px;
    padding-bottom: 24px;
    border-bottom: 2px solid #e2e8f0;
}

.header-icon {
    width: 64px;
    height: 64px;
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.header-icon i {
    font-size: 28px;
    color: white;
}

.header-text {
    flex: 1;
}

.page-title {
    font-size: 28px;
    font-weight: 700;
    color: #1e293b;
    margin: 0 0 4px 0;
}

.page-subtitle {
    font-size: 14px;
    color: #64748b;
    margin: 0;
    font-weight: 400;
}

/* =========================================
   ALERT MESSAGES
========================================= */
.alert {
    padding: 16px 20px;
    border-radius: 12px;
    border: none;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 14px;
    font-weight: 500;
}

.alert i {
    font-size: 18px;
}

.alert-danger {
    background: #fee2e2;
    color: #991b1b;
    border-left: 4px solid #ef4444;
}

.alert .btn-close {
    background: transparent;
    opacity: 0.6;
    transition: opacity 0.2s;
    margin-left: auto;
}

.alert .btn-close:hover {
    opacity: 1;
}

/* =========================================
   FORM CARD
========================================= */
.form-card {
    background: #f8fafc;
    border-radius: 12px;
    padding: 28px;
    border: 1px solid #e2e8f0;
    margin-top: 24px;
}

/* =========================================
   FORM GROUP
========================================= */
.form-group {
    margin-bottom: 28px;
}

/* Form Label */
.form-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    font-weight: 600;
    color: #334155;
    margin-bottom: 10px;
}

.label-icon {
    color: #3b82f6;
    font-size: 16px;
}

.required-mark {
    color: #ef4444;
    font-weight: 700;
    margin-left: 2px;
}

/* Form Input */
.form-input {
    width: 100%;
    padding: 14px 18px;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    font-size: 15px;
    color: #334155;
    background: white;
    transition: all 0.2s ease;
    font-family: 'Inter', sans-serif;
}

.form-input:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
}

.form-input::placeholder {
    color: #94a3b8;
}

/* Invalid Input */
.form-input.is-invalid {
    border-color: #ef4444;
    background: #fef2f2;
}

.form-input.is-invalid:focus {
    border-color: #dc2626;
    box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
}

/* Error Message */
.error-message {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-top: 10px;
    padding: 12px 16px;
    background: #fee2e2;
    border-left: 3px solid #ef4444;
    border-radius: 8px;
    color: #991b1b;
    font-size: 13px;
    font-weight: 500;
}

.error-message i {
    color: #ef4444;
    font-size: 14px;
}

/* Form Hint */
.form-hint {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-top: 10px;
    padding: 10px 14px;
    background: #dbeafe;
    border-left: 3px solid #3b82f6;
    border-radius: 8px;
    color: #1e40af;
    font-size: 12px;
    font-weight: 500;
}

.form-hint i {
    color: #3b82f6;
    font-size: 13px;
}

/* =========================================
   FORM ACTIONS (Buttons)
========================================= */
.form-actions {
    display: flex;
    gap: 12px;
    margin-top: 32px;
    padding-top: 24px;
    border-top: 1px solid #e2e8f0;
}

.form-actions .btn {
    flex: 1;
    padding: 14px 24px;
    border-radius: 10px;
    font-size: 15px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    text-decoration: none;
}

.form-actions .btn i {
    font-size: 16px;
}

/* Cancel Button */
.btn-cancel {
    background: white;
    color: #64748b;
    border: 2px solid #e2e8f0;
}

.btn-cancel:hover {
    background: #f8fafc;
    border-color: #cbd5e1;
    color: #475569;
    transform: translateY(-1px);
}

/* Submit Button */
.btn-submit {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.btn-submit:hover {
    background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    box-shadow: 0 6px 16px rgba(59, 130, 246, 0.4);
    transform: translateY(-2px);
}

.btn-submit:active,
.btn-cancel:active {
    transform: translateY(0);
}

/* =========================================
   INFO BOX
========================================= */
.info-box {
    display: flex;
    gap: 20px;
    padding: 20px 24px;
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    border-left: 4px solid #f59e0b;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(245, 158, 11, 0.15);
}

.info-icon {
    width: 48px;
    height: 48px;
    background: white;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.info-icon i {
    font-size: 24px;
    color: #f59e0b;
}

.info-content {
    flex: 1;
}

.info-title {
    font-size: 16px;
    font-weight: 700;
    color: #78350f;
    margin: 0 0 10px 0;
}

.info-list {
    margin: 0;
    padding-left: 20px;
    color: #92400e;
    font-size: 13px;
    line-height: 1.6;
}

.info-list li {
    margin-bottom: 6px;
}

.info-list li:last-child {
    margin-bottom: 0;
}

/* =========================================
   RESPONSIVE DESIGN
========================================= */
@media (max-width: 768px) {
    .page-wrapper {
        padding: 16px;
    }

    .page-container {
        padding: 20px;
        border-radius: 12px;
    }

    .page-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
    }

    .header-icon {
        width: 56px;
        height: 56px;
    }

    .header-icon i {
        font-size: 24px;
    }

    .page-title {
        font-size: 22px;
    }

    .page-subtitle {
        font-size: 13px;
    }

    .form-card {
        padding: 20px;
    }

    .form-actions {
        flex-direction: column-reverse;
    }

    .form-actions .btn {
        width: 100%;
    }

    .info-box {
        flex-direction: column;
        gap: 16px;
    }

    .info-icon {
        width: 44px;
        height: 44px;
    }

    .info-icon i {
        font-size: 20px;
    }
}

@media (max-width: 480px) {
    .breadcrumb-link {
        font-size: 13px;
        padding: 6px 12px;
    }

    .page-title {
        font-size: 20px;
    }

    .form-input {
        padding: 12px 16px;
        font-size: 14px;
    }

    .form-label {
        font-size: 13px;
    }

    .form-hint,
    .error-message {
        font-size: 11px;
        padding: 8px 12px;
    }
}</style>
<div class="edit-page">
    <div class="page-wrapper">
        <div class="page-container">

            <!-- ===== BREADCRUMB ===== -->
            <div class="breadcrumb-section mb-3">
                <a href="<?= base_url('admin/provinces') ?>" class="breadcrumb-link">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar Provinsi
                </a>
            </div>

            <!-- ===== PAGE TITLE ===== -->
            <div class="page-header mb-4">
                <div class="header-icon">
                    <i class="fas fa-edit"></i>
                </div>
                <div class="header-text">
                    <h1 class="page-title">Edit Provinsi</h1>
                    <p class="page-subtitle">Ubah data provinsi yang sudah ada</p>
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
                <form action="<?= base_url('admin/provinces/update/' . $province['id']) ?>" method="post">
                    
                    <!-- Form Group: Nama Provinsi -->
                    <div class="form-group">
                        <label for="name" class="form-label">
                            <i class="fas fa-map-marker-alt label-icon"></i>
                            Nama Provinsi
                            <span class="required-mark">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="name"
                            name="name" 
                            class="form-input <?= (session()->getFlashdata('errors')['name'] ?? false) ? 'is-invalid' : '' ?>"
                            value="<?= old('name', $province['name']) ?>"
                            placeholder="Contoh: Jawa Barat"
                            required>
                        
                        <?php if (session()->getFlashdata('errors')['name'] ?? false): ?>
                            <div class="error-message">
                                <i class="fas fa-exclamation-triangle"></i>
                                <?= session()->getFlashdata('errors')['name'] ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="form-hint">
                            <i class="fas fa-info-circle"></i>
                            Masukkan nama provinsi dengan format yang benar
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="form-actions">
                        <a href="<?= base_url('admin/provinces') ?>" class="btn btn-cancel">
                            <i class="fas fa-times"></i>
                            Batal
                        </a>
                        <button type="submit" class="btn btn-submit">
                            <i class="fas fa-save"></i>
                            Update Provinsi
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
                        <li>Pastikan nama provinsi ditulis dengan benar dan lengkap</li>
                        <li>Gunakan huruf kapital di awal setiap kata</li>
                        <li>Perubahan akan mempengaruhi semua data kota yang terkait</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>

<?php $this->endSection() ?>