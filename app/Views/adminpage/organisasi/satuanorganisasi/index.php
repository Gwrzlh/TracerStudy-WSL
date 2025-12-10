<?php
$orgText = get_setting('org_button_text', 'Tambah Satuan Organisasi');
?>

<?= $this->extend('layout/sidebar') ?>
<?= $this->section('content') ?>

<link rel="stylesheet" href="<?= base_url('css/organisasi/satuanorganisasi.css') ?>">

<div class="main-container">
    <div class="page-container">

        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Satuan Organisasi</h1>
            <div class="header-actions">
                <a href="<?= base_url('admin/satuanorganisasi/create') ?>" class="btn-primary">
                    <span class="btn-icon">+</span> <?= esc($orgText) ?>
                </a>
            </div>
        </div>

       <!-- Tabs -->
<div class="tab-container">
    <a href="<?= site_url('/admin/satuanorganisasi') ?>" class="tab-link active">
        Satuan Organisasi (<?= esc($count_satuan) ?>)
    </a>

    <a href="<?= site_url('/admin/jurusan') ?>" class="tab-link">
        Jurusan (<?= esc($count_jurusan) ?>)
    </a>

    <a href="<?= site_url('/admin/prodi') ?>" class="tab-link">
        Prodi (<?= esc($count_prodi) ?>)
    </a>
</div>


        <!-- Search -->
        <form method="get" action="<?= site_url('/admin/satuanorganisasi') ?>" class="search-form">
            <div class="search-box">
                <input type="text" name="keyword" value="<?= esc($keyword ?? '') ?>"
                    placeholder="Cari nama, singkatan, tipe, jurusan..." class="search-input">
                <button type="submit" class="search-button">Search</button>
            </div>
        </form>

        <!-- Content Card -->
        <div class="content-card">
            <div class="table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Nama Satuan</th>
                            <th>Singkatan</th>
                            <th>Slug</th>
                            <th>Tipe Organisasi</th>
                            <th class="action-column">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($satuan)): ?>
                            <?php foreach ($satuan as $row): ?>
                                <tr>
                                    <td class="name-cell" onclick="toggleDetail(<?= $row['id'] ?>)"
                                        style="cursor:pointer; color:#3b82f6; font-weight:600;">
                                        <?= esc($row['nama_satuan']) ?>
                                    </td>
                                    <td><?= esc($row['nama_singkatan']) ?></td>
                                    <td><?= esc($row['nama_slug']) ?></td>
                                    <td><span class="group-badge"><?= esc($row['nama_tipe'] ?? '-') ?></span></td>
                                    <td class="action-cell">
                                        <div class="action-buttons">
                                            
                                            
                                             <!-- Edit -->
                                            <a href="<?= base_url('admin/satuanorganisasi/edit/' . $row['id']) ?>" 
                                               class="btn-edit" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <!-- Delete -->
                                           <form action="<?= site_url('/admin/satuanorganisasi/delete/' . $row['id']) ?>"

                                                  method="post" style="display: inline;" class="delete-form">
                                                <?= csrf_field() ?>
                                                <button type="button" class="btn-delete"
                                                    onclick="confirmDelete(this)" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>

                                <!-- Detail row -->
                                <tr id="detail-<?= $row['id'] ?>" class="detail-row" style="display:none; background:#f9fafb;">
                                    <td colspan="5" style="padding:15px;">
                                        <div class="detail-box">
                                            <b>Prodi:</b><br>
                                            <?php if (!empty($row['prodi_list'])): ?>
                                                <?php foreach ($row['prodi_list'] as $p): ?>
                                                    <span class="prodi-badge">
                                                        <?= esc($p['nama_prodi']) ?>
                                                    </span>
                                                <?php endforeach ?>
                                            <?php else: ?>
                                                <span style="color:#6c757d;">Tidak ada Prodi</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>

                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="empty-state">
                                    <div class="empty-content">
                                        <i class="fas fa-sitemap"></i>
                                        <p>Belum ada data satuan organisasi</p>
                                        <small>Klik tombol "+ Tambah" untuk menambah data baru</small>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>

                </table>
            </div>
        </div>

    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function confirmDelete(button) {
    const form = button.closest("form");
    Swal.fire({
        title: 'Yakin hapus?',
        text: "Data yang dihapus tidak bisa dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) form.submit();
    })
}

function toggleDetail(id) {
    const row = document.getElementById("detail-" + id);

    document.querySelectorAll(".detail-row").forEach(el => {
        if (el.id !== "detail-" + id) el.style.display = "none";
    });

    row.style.display = (row.style.display === "none" || row.style.display === "")
        ? "table-row" : "none";
}
</script>

<?= $this->endSection() ?>
