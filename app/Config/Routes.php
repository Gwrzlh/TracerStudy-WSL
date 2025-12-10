<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ===============================
// PUBLIC ROUTES / AUTH  
// ===============================
$routes->get('/login', 'Auth\Auth::login');
$routes->post('/do-login', 'Auth\Auth::doLogin');
$routes->get('/logout', 'Auth\Auth::logout');

$routes->get('/lupapassword', 'Auth\Auth::forgotPassword');
$routes->post('/lupapassword', 'Auth\Auth::sendResetLink');
$routes->get('/resetpassword/(:any)', 'Auth\Auth::resetPassword/$1');
$routes->post('/resetpassword', 'Auth\Auth::doResetPassword');



// ===============================
// ADMIN / TENTANG  
// ===============================
$routes->group('admin', ['filter' => 'adminAuth'], function ($routes) {
    $routes->get('tentang/edit', 'LandingPage\Tentang::edit');
    $routes->post('tentang/update', 'LandingPage\Tentang::update');

});



// ===============================
// LANDING PAGE / PUBLIC
// ===============================
$routes->get('/', 'LandingPage\Homepage::index');
$routes->get('/home', 'LandingPage\LandingPage::home');
$routes->get('tentang', 'LandingPage\Tentang::index');
$routes->get('/kontak', 'LandingPage\Kontak::landing');
$routes->get('event', 'LandingPage\Event::index');
$routes->get('sop', 'LandingPage\Tentang::index');
$routes->get('/respon', 'Kuesioner\UserQuestionController::responseLanding');
$routes->get('/laporan', 'LandingPage\AdminLaporan::showAll');
$routes->get('/laporan/(:num)', 'LandingPage\AdminLaporan::showAll/$1');




// ===============================
// ADMIN / TIPE ORAGANISASI
// ===============================
$routes->group('admin', function($routes){

    // --- Tipe Organisasi ---
    $routes->group('tipeorganisasi', function ($routes) {
        $routes->get('/', 'Organisasi\TipeOrganisasiController::index');
        $routes->get('form', 'Organisasi\TipeOrganisasiController::create');
        $routes->post('insert', 'Organisasi\TipeOrganisasiController::store');
        $routes->get('edit/(:num)', 'Organisasi\TipeOrganisasiController::edit/$1');
        $routes->post('edit/update/(:num)', 'Organisasi\TipeOrganisasiController::update/$1');
        $routes->delete('delete/(:num)', 'Organisasi\TipeOrganisasiController::delete/$1');
    });

});




    // ===============================
    // SATUAN ORGANISASI
    // ===============================
    $routes->group('admin', ['filter' => 'adminAuth','namespace' => 'App\Controllers\Organisasi'], function ($routes) {
    
         // --- Satuan Organisasi ---
    $routes->group('satuanorganisasi', function ($routes) {
        $routes->get('/', 'SatuanOrganisasi::index');
        $routes->get('create', 'SatuanOrganisasi::create');
        $routes->post('store', 'SatuanOrganisasi::store');
        $routes->get('edit/(:num)', 'SatuanOrganisasi::edit/$1');
        $routes->post('update/(:num)', 'SatuanOrganisasi::update/$1');
        $routes->post('delete/(:num)', 'SatuanOrganisasi::delete/$1');

        // AJAX get prodi by jurusan
        $routes->get('getProdi/(:num)', 'SatuanOrganisasi::getProdiByJurusan/$1');
    });




    // ===============================
    // JURUSAN
    // ===============================
    $routes->group('jurusan', function ($routes) {
        $routes->get('/', 'Jurusan::index');
        $routes->get('create', 'Jurusan::create');
        $routes->post('store', 'Jurusan::store');
        $routes->get('edit/(:num)', 'Jurusan::edit/$1');
        $routes->post('update/(:num)', 'Jurusan::update/$1');
        $routes->post('delete/(:num)', 'Jurusan::delete/$1');
    });




    // ===============================
    // PRODI
    // ===============================
    $routes->group('prodi', function ($routes) {
        $routes->get('/', 'ProdiController::index');
        $routes->get('create', 'ProdiController::create');
        $routes->post('store', 'ProdiController::store');
        $routes->get('edit/(:num)', 'ProdiController::edit/$1');
        $routes->post('update/(:num)', 'ProdiController::update/$1');
        $routes->post('delete/(:num)', 'ProdiController::delete/$1');

        // AJAX
        $routes->get('getProdi/(:num)', 'ProdiController::getProdi/$1');
    });

});




// ============================
// ADMIN PENGGUNA ROUTES
// ============================
$routes->group('admin/pengguna', ['filter' => 'adminAuth'], function ($routes) {

    // CRUD Pengguna
    $routes->get('', 'admin\PenggunaController::index');
    $routes->get('tambahPengguna', 'admin\PenggunaController::create');
    $routes->post('tambahPengguna/post', 'admin\PenggunaController::store');
    $routes->get('editPengguna/(:num)', 'admin\PenggunaController::edit/$1');
    $routes->post('update/(:num)', 'admin\PenggunaController::update/$1');
    
    // Delete single & multiple
    $routes->match(['post', 'delete'], 'delete/(:num)', 'admin\PenggunaController::delete/$1');
    $routes->match(['post', 'delete'], 'deleteMultiple', 'admin\PenggunaController::deleteMultiple');

    // Export
    $routes->post('exportSelected', 'admin\PenggunaController::exportSelected');

    // Error logs
    $routes->get('errorLogs', 'admin\PenggunaController::errorLogs');

    // Import & Export akun (auth filter)
    $routes->get('import', 'admin\ImportAccount::index', ['filter' => 'auth']);
    $routes->post('import', 'admin\ImportAccount::import', ['filter' => 'auth']);
    $routes->get('export', 'admin\ExportAccount::index', ['filter' => 'auth']);
});



// ============================
// AJAX / API ROUTES
// ============================
$routes->group('api', function ($routes) {
    $routes->get('cities/province/(:num)', 'admin\PenggunaController::getCitiesByProvince/$1');
    $routes->get('getProdiByJurusan/(:num)', 'admin\PenggunaController::getProdiByJurusan/$1');
});


// ============================
//  Alumni
// ============================
$routes->post('alumni/delete-riwayat', 'Alumni\AlumniController::deleteRiwayat');

$routes->group('admin/relasi-atasan-alumni', ['filter' => 'adminAuth'], function ($routes) {
    $routes->get('/', 'Atasan\RelasiAtasanAlumniController::index'); // Halaman utama
    $routes->get('tambah', 'Atasan\RelasiAtasanAlumniController::create');
    $routes->post('store', 'Atasan\RelasiAtasanAlumniController::store');
    $routes->post('update/(:num)','Atasan\RelasiAtasanAlumniController::update/$1'); // Simpan relasi
    $routes->get('delete/(:num)', 'Atasan\RelasiAtasanAlumniController::delete/$1');
    $routes->post('fetch-alumni', 'Atasan\RelasiAtasanAlumniController::fetchAlumni'); 
});




// =======================================
// PROFIL ADMIN
// =======================================
$routes->group('admin/profil', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Admin\AdminController::profil');

    // Edit Data Profil
    $routes->get('edit/(:num)', 'Admin\AdminController::editProfil/$1');
    $routes->post('update/(:num)', 'Admin\AdminController::updateProfil/$1');

    // Update Foto Profil
    $routes->post('update-foto/(:num)', 'Admin\AdminController::updateFoto/$1');

    // Ubah Password
    $routes->get('ubah-password', 'Admin\AdminController::ubahPassword');
    $routes->post('update-password', 'Admin\AdminController::updatePassword');
});





// ===============================
// ADMIN ROUTES
// ===============================
$routes->group('admin', ['filter' => 'adminAuth'], function ($routes) {

    // Dashboard
    $routes->get('dashboard', 'Admin\AdminController::dashboard');
    $routes->get('welcome-page', 'Admin\AdminWelcomePage::index');
    $routes->post('welcome-page/update', 'Admin\AdminWelcomePage::update');

    // Peringatan
    $routes->post('kirim-peringatan-penilaian', 'Admin\AdminController::kirimPeringatanPenilaian');
    $routes->get('peringatan', 'Admin\AdminController::peringatan');

    // ===============================
    // Kontak
    // ===============================
    $routes->group('kontak', function ($routes) {
        $routes->get('', 'LandingPage\Kontak::index');
        $routes->get('search', 'LandingPage\Kontak::search');
        $routes->get('create', 'LandingPage\Kontak::create');
        $routes->post('store', 'LandingPage\Kontak::store');
        $routes->post('store-multiple', 'LandingPage\Kontak::storeMultiple');
        $routes->get('edit/(:num)', 'LandingPage\Kontak::edit/$1');
        $routes->post('update/(:num)', 'LandingPage\Kontak::update/$1');
        $routes->post('delete/(:num)', 'LandingPage\Kontak::delete/$1');
        $routes->get('deleteKategori/(:segment)', 'LandingPage\Kontak::deletebyKategori/$1');
        $routes->get('getByKategori/(:any)', 'LandingPage\Kontak::getByKategori/$1');
    });

    
    // ===============================
    // Log Activities
    // ===============================
    $routes->group('log_activities', function ($routes) {
        $routes->get('', 'LandingPage\LogController::index');
        $routes->get('export', 'LandingPage\LogController::export');
        $routes->get('dashboard', 'LandingPage\LogController::dashboard');
        $routes->get('manual-archive', 'LandingPage\LogController::manualArchive');
        $routes->get('manual-cleanup', 'LandingPage\LogController::manualCleanup');
    });

    // Email Template
    $routes->get('emailtemplate', 'Admin\AdminEmailTemplateController::index');
    $routes->post('emailtemplate/update/(:num)', 'Admin\AdminEmailTemplateController::update/$1');

    // ===============================
    // Questionnaire / Kuesioner
    // ===============================
    $routes->group('questionnaire', function ($routes) {
        // Questionnaire CRUD
        $routes->get('', 'Kuesioner\QuestionnaireController::index');
        $routes->get('create', 'Kuesioner\QuestionnaireController::create');
        $routes->post('store', 'Kuesioner\QuestionnaireController::store');
        $routes->get('(:num)', 'Kuesioner\QuestionnaireController::show/$1');
        $routes->get('(:num)/edit', 'Kuesioner\QuestionnaireController::edit/$1');
        $routes->post('(:num)/update', 'Kuesioner\QuestionnaireController::update/$1');
        $routes->get('(:num)/delete', 'Kuesioner\QuestionnaireController::delete/$1');
        $routes->post('(:num)/toggle-status', 'Kuesioner\QuestionnaireController::toggleStatus/$1');
        $routes->get('(:num)/preview', 'Kuesioner\QuestionnaireController::preview/$1');
        $routes->get('(:num)/download-pdf', 'Kuesioner\QuestionnaireController::downloadPDF/$1');
        $routes->get('(:num)/export', 'Kuesioner\QuestionnaireController::export/$1');
        $routes->post('import', 'Kuesioner\QuestionnaireController::import');

        // Pages
        $routes->group('(:num)/pages', function ($routes) {
            $routes->get('', 'Kuesioner\QuestionnairePageController::index/$1');
            $routes->get('create', 'Kuesioner\QuestionnairePageController::create/$1');
            $routes->post('store', 'Kuesioner\QuestionnairePageController::store/$1');
            $routes->get('(:num)/edit', 'Kuesioner\QuestionnairePageController::edit/$1/$2');
            $routes->post('(:num)/update', 'Kuesioner\QuestionnairePageController::update/$1/$2');
            $routes->get('(:num)/delete', 'Kuesioner\QuestionnairePageController::delete/$1/$2');

            // Sections
            $routes->group('(:num)/sections', function ($routes) {
                $routes->get('', 'Kuesioner\SectionController::index/$1/$2');
                $routes->get('create', 'Kuesioner\SectionController::create/$1/$2');
                $routes->post('store', 'Kuesioner\SectionController::store/$1/$2');
                $routes->get('(:num)/edit', 'Kuesioner\SectionController::edit/$1/$2/$3');
                $routes->post('(:num)/update', 'Kuesioner\SectionController::update/$1/$2/$3');
                $routes->post('(:num)/delete', 'Kuesioner\SectionController::delete/$1/$2/$3');
                $routes->post('(:num)/moveDown', 'Kuesioner\SectionController::moveDown/$1/$2/$3');
                $routes->post('(:num)/moveUp', 'Kuesioner\SectionController::moveUp/$1/$2/$3');
                $routes->post('(:num)/duplicate', 'Kuesioner\SectionController::duplicate/$1/$2/$3');

                // Questions per section
                $routes->get('(:num)/questions', 'Kuesioner\QuestionnairController::manageSectionQuestions/$1/$2/$3');
                $routes->get('(:num)/questions/get-op/(:num)', 'Kuesioner\QuestionnairController::getQuestionOptions/$1/$2/$3/$4');
                $routes->get('(:num)/questions/get-conditions/(:num)', 'Kuesioner\QuestionnairController::getOption/$1/$2/$3/$4');
                $routes->post('(:num)/questions/store', 'Kuesioner\QuestionnairController::storeSectionQuestion/$1/$2/$3');
                $routes->get('(:num)/questions/get/(:num)', 'Kuesioner\QuestionnairController::getQuestion/$1/$2/$3/$4');
                $routes->post('(:num)/questions/delete/(:num)', 'Kuesioner\QuestionnairController::deleteSectionQuestion/$1/$2/$3/$4');
                $routes->post('(:num)/questions/(:num)/update', 'Kuesioner\QuestionnairController::updateQuestion/$1/$2/$3/$4');
                $routes->post('(:num)/questions/duplicate/(:num)', 'Kuesioner\QuestionnairController::duplicate/$1/$2/$3/$4');
            });
        });
    });

    // Options
    $routes->group('questions/(:num)/options', function ($routes) {
        $routes->get('', 'Kuesioner\QuestionnaireController::manageOptions/$1');
        $routes->post('store', 'Kuesioner\QuestionnaireController::storeOption/$1');
        $routes->post('(:num)/update', 'Kuesioner\QuestionnaireController::updateOption/$1');
        $routes->post('(:num)/delete', 'Kuesioner\QuestionnaireController::deleteOption/$1');
    });

    // Conditions
    $routes->group('questions/(:num)/conditions', function ($routes) {
        $routes->get('', 'Kuesioner\QuestionnaireConditionController::index/$1');
        $routes->get('create', 'Kuesioner\QuestionnaireConditionController::create/$1');
        $routes->post('store', 'Kuesioner\QuestionnaireConditionController::store/$1');
        $routes->get('(:num)/edit', 'Kuesioner\QuestionnaireConditionController::edit/$1/$2');
        $routes->post('(:num)/update', 'Kuesioner\QuestionnaireConditionController::update/$1/$2');
        $routes->post('(:num)/delete', 'Kuesioner\QuestionnaireConditionController::delete/$1/$2');
    });
});




// ===============================
// Admin - Laporan
// ===============================
$routes->group('admin', ['filter' => 'adminAuth'], function ($routes) {
    $routes->get('laporan', 'LandingPage\AdminLaporan::index');
    $routes->get('laporan/create', 'LandingPage\AdminLaporan::create');
    $routes->post('laporan/save', 'LandingPage\AdminLaporan::save');
    $routes->get('laporan/edit/(:num)', 'LandingPage\AdminLaporan::edit/$1');
    $routes->post('laporan/update/(:num)', 'LandingPage\AdminLaporan::update/$1');
    $routes->post('laporan/delete/(:num)', 'LandingPage\AdminLaporan::delete/$1');
});





// ============================
//  Global / Umum
// ============================
$routes->get('email-test', 'LandingPage\EmailTest::index');





// ============================
//  Pengaturan Situs
// ============================
$routes->group('pengaturan-situs', function($routes) {
    $routes->get('/', 'Admin\PengaturanSitus\PengaturanSitus::index');
    $routes->post('save', 'Admin\PengaturanSitus\PengaturanSitus::save');
});

$routes->group('pengaturan-alumni', function($routes) {
    $routes->get('/', 'Admin\PengaturanSitus\PengaturanAlumni::index');
    $routes->post('save', 'Admin\PengaturanSitus\PengaturanAlumni::save');
});

$routes->group('pengaturan-kaprodi', function($routes) {
    $routes->get('/', 'Admin\PengaturanSitus\PengaturanKaprodi::index');
    $routes->post('save', 'Admin\PengaturanSitus\PengaturanKaprodi::save');
});

$routes->group('pengaturan-atasan', function($routes) {
    $routes->get('/', 'Admin\PengaturanSitus\PengaturanAtasan::index');
    $routes->post('save', 'Admin\PengaturanSitus\PengaturanAtasan::save');
});

$routes->group('pengaturan-jabatanlainnya', function($routes) {
    $routes->get('/', 'Admin\PengaturanSitus\PengaturanJabatanLainnya::index');
    $routes->post('save', 'Admin\PengaturanSitus\PengaturanJabatanLainnya::save');
});


// ============================
//  Pengaturan Dashboard
// ============================
$routes->group('pengaturan-dashboard', function($routes) {

    // Dashboard Alumni
    $routes->get('dashboard-alumni', 'Admin\PengaturanSitus\PengaturanDashboard::dashboardAlumni');
    $routes->post('dashboard-alumni/save', 'Admin\PengaturanSitus\PengaturanDashboard::saveDashboardAlumni');

    // Dashboard Kaprodi
    $routes->get('dashboard-kaprodi', 'Admin\PengaturanSitus\PengaturanDashboardKaprodi::index');
    $routes->post('dashboard-kaprodi/save', 'Admin\PengaturanSitus\PengaturanDashboardKaprodi::save');

    // Dashboard Admin
    $routes->get('dashboard-admin', 'Admin\PengaturanSitus\PengaturanDashboardAdmin::index');
    $routes->post('dashboard-admin/save', 'Admin\PengaturanSitus\PengaturanDashboardAdmin::save');

    // Dashboard Jabatan Lainnya
    $routes->get('dashboard-jabatanlainnya', 'Admin\PengaturanSitus\PengaturanDashboardJabatanLainnya::index');
    $routes->post('dashboard-jabatanlainnya/save', 'Admin\PengaturanSitus\PengaturanDashboardJabatanLainnya::save');

    // Dashboard Atasan
    $routes->get('dashboard-atasan', 'Admin\PengaturanSitus\PengaturanDashboardAtasan::index');
    $routes->post('dashboard-atasan/save', 'Admin\PengaturanSitus\PengaturanDashboardAtasan::save');
});





// -------------------------------
// Alumni - NO FILTER (public)
// -------------------------------
$routes->get('alumni/login', 'Alumni\AlumniController::login');
$routes->post('alumni/login', 'Alumni\AlumniController::doLogin');
$routes->get('alumni/logout', 'Alumni\AlumniController::logout');


// ----------------------------------------
// Group Alumni (wajib login)
// ----------------------------------------
$routes->group('alumni', ['filter' => 'alumniAuth'], static function ($routes) {

    // Dashboard
    $routes->get('dashboard', 'Alumni\AlumniController::dashboard');
    $routes->get('dashboard/surveyor', 'Alumni\AlumniController::dashboardSurveyor');

    // Supervisi (alumni surveyor)
    $routes->get('supervisi', 'Alumni\AlumniController::supervisi');

  


    // ----------------------------------------
    // PROFIL ALUMNI BIASA
    // ----------------------------------------
    $routes->get('profil', 'Alumni\AlumniController::profil');
    $routes->post('profil/update', 'Alumni\AlumniController::updateProfil');
    $routes->post('profil/update-foto/(:num)', 'Alumni\AlumniController::updateFoto/$1');

    // Tentang Pekerjaan
    $routes->get('profil/pekerjaan', 'Alumni\AlumniController::pekerjaan');
    $routes->post('profil/pekerjaan/save', 'Alumni\AlumniController::savePekerjaan');

    // Riwayat Pekerjaan
    $routes->get('profil/riwayat', 'Alumni\AlumniController::riwayatPekerjaan');
    $routes->get('profil/riwayat/delete/(:num)', 'Alumni\AlumniController::deleteRiwayat/$1');



    // ----------------------------------------
    // PROFIL SURVEYOR
    // ----------------------------------------
    $routes->group('surveyor', static function ($routes) {

        $routes->get('profil', 'Alumni\AlumniController::profilSurveyor');

        // pakai function yang sama
        $routes->post('profil/update', 'Alumni\AlumniController::updateProfil');
        $routes->post('profil/update-foto/(:num)', 'Alumni\AlumniController::updateFoto/$1');

        // Kuesioner Surveyor
        $routes->get('questionnaires', 'Alumni\AlumniController::questionnairesForSurveyor');
        $routes->get('questionnaire/(:num)', 'Alumni\AlumniController::fillQuestionnaire/$1');
        $routes->post('questionnaire/submit', 'Alumni\AlumniController::submitAnswers');
    });



    // ----------------------------------------
    // Pesan & Notifikasi
    // ----------------------------------------
    $routes->get('notifikasi', 'Alumni\AlumniController::notifikasi');
    $routes->get('notifikasi/tandai/(:num)', 'Alumni\AlumniController::tandaiDibaca/$1');
    $routes->get('notifikasi/hapus/(:num)', 'Alumni\AlumniController::hapusNotifikasi/$1');
    $routes->get('notifikasi/count', 'Alumni\AlumniController::getNotifCount');
    $routes->get('pesan/(:num)', 'Alumni\AlumniController::pesan/$1');
    $routes->post('kirimPesanManual', 'Alumni\AlumniController::kirimPesanManual');
    $routes->get('viewpesan/(:num)', 'Alumni\AlumniController::viewPesan/$1');


    // ----------------------------------------
    // Lihat Teman
    // ----------------------------------------
    $routes->get('lihat_teman', 'Alumni\AlumniController::lihatTeman');


    // ----------------------------------------
    // KUESIONER ALUMNI BIASA
    // ----------------------------------------
    $routes->get('questionnaires', 'Kuesioner\UserQuestionController::index');
    $routes->get('questionnaires/mulai/(:num)', 'Kuesioner\UserQuestionController::mulai/$1');
    $routes->get('questionnaires/lanjutkan/(:num)', 'Kuesioner\UserQuestionController::lanjutkan/$1');
    $routes->get('questioner/lihat/(:num)', 'Kuesioner\UserQuestionController::lihat/$1');
    $routes->post('questionnaires/save-answer', 'Kuesioner\UserQuestionController::saveAnswer');
});




 
$routes->group('atasan', ['filter' => 'atasanFilter'], function ($routes) {

    //Dashboard
    $routes->get('dashboard', 'Atasan\AtasanController::dashboard');

    //Menu Alumni
    $routes->get('alumni', 'Atasan\AtasanController::alumni'); 
    $routes->post('simpan-penilaian/(:num)', 'Atasan\AtasanController::simpanPenilaian/$1'); 

    //Response Alumni
    $routes->get('response-alumni', 'Atasan\AtasanController::responseAlumni');
    $routes->get('response-alumni/lihat/(:num)', 'Atasan\AtasanController::Lihatjawaban/$1');
    $routes->get('alumni/rekap', 'Atasan\AtasanController::rekapPenilaian');

    //Notifikasi & Pesan
    $routes->get('notifikasi', 'Atasan\AtasanController::notifikasi');
    $routes->get('notifikasi/tandai/(:num)', 'Atasan\AtasanController::tandaiDibaca/$1');
    $routes->get('hapusNotifikasi/(:num)', 'Atasan\AtasanController::hapusNotifikasi/$1');
    $routes->get('getNotifCount', 'Atasan\AtasanController::getNotifCount');
    $routes->get('viewPesan/(:num)', 'Atasan\AtasanController::viewPesan/$1');

    //CRUD Perusahaan
    $routes->get('perusahaan', 'Atasan\AtasanController::perusahaan');
    $routes->get('perusahaan/detail/(:num)', 'Atasan\AtasanController::detailPerusahaan/$1');
    $routes->get('perusahaan/edit/(:num)', 'Atasan\AtasanController::editPerusahaan/$1');
    $routes->get('perusahaan/getCitiesByProvince/(:num)', 'Atasan\AtasanController::getCitiesByProvince/$1');
});



// --- Kuesioner Atasan ---
$routes->group('atasan/kuesioner', ['filter' => 'atasanFilter'], function($routes) {
    $routes->get('/',                       'Atasan\AtasanKuesionerController::index');
    $routes->get('daftar-alumni/(:num)',    'Atasan\AtasanKuesionerController::daftarAlumni/$1');
    $routes->get('isi/(:num)/(:num)',       'Atasan\AtasanKuesionerController::mulai/$1/$2');
    $routes->get('lihat/(:num)/(:num)',     'Atasan\AtasanKuesionerController::lihat/$1/$2');
    $routes->get('lanjutkan/(:num)/(:num)', 'Atasan\AtasanKuesionerController::lanjutkan/$1/$2');
    
    //AUTOSAVE + SUBMIT AKHIR
    $routes->post('save-answer','Atasan\AtasanKuesionerController::saveAnswer');
});



// =========================
// AJAX Conditional Logic
// =========================
$routes->get('admin/get-conditional-options', 
    'Kuesioner\QuestionnairController::getConditionalOptions',
    ['as' => 'admin.questioner.getOptions']
);

$routes->get('admin/questionnaire/pages/get-question-options', 
    'Kuesioner\QuestionnairePageController::getQuestionOptions'
);

// Question Options (specific)
$routes->get('admin/questionnaire/(:num)/questions/(:num)/options', 
    'Kuesioner\QuestionController::getQuestionOptions/$1/$2'
);

$routes->get('admin/questionnaire/(:num)/pages/(:num)/sections/(:num)/questions-with-options', 
    'Kuesioner\QuestionController::getQuestionsWithOptions/$1/$2/$3'
);



// =========================
// ADMIN RESPON
// =========================
$routes->group('admin/respon', ['filter' => 'adminAuth'], function ($routes) {

    // Dashboard utama
    $routes->get('/', 'Admin\AdminRespon::index');

    // Respon Atasan
    $routes->get('atasan', 'Admin\AdminResponAtasan::index');
    $routes->get('atasan/detail/(:num)', 'Admin\AdminResponAtasan::detail/$1');
    $routes->get('atasan/delete/(:num)', 'Admin\AdminResponAtasan::delete/$1');

    // Export
    $routes->get('export', 'Admin\AdminRespon::exportExcel');
    $routes->get('exportPdf/(:num)', 'Admin\AdminRespon::exportPdf/$1');

    // Grafik & Detail Jawaban
    $routes->get('grafik', 'Admin\AdminRespon::grafik');
    $routes->get('detail/(:num)', 'Admin\AdminRespon::detail/$1');

    // Allow Edit
    $routes->get('allow_edit/(:num)/(:num)', 'Admin\AdminRespon::allowEdit/$1/$2');

    // ========= AMI =========
    $routes->get('ami', 'Admin\AdminRespon::ami');
    $routes->get('ami/detail/(:segment)', 'Admin\AdminRespon::detailAmi/$1');
    $routes->get('ami/pdf/(:segment)', 'Admin\AdminRespon::exportAmiPdf/$1');

    // Hapus Flag AMI
    $routes->get('remove_from_ami/(:num)', 'Admin\AdminRespon::remove_from_ami/$1');


    // ========= AKREDITASI =========
    $routes->get('akreditasi', 'Admin\AdminRespon::akreditasi');
    $routes->get('akreditasi/detail/(:segment)', 'Admin\AdminRespon::detailAkreditasi/$1');
    $routes->get('akreditasi/pdf/(:segment)', 'Admin\AdminRespon::exportAkreditasiPdf/$1');

    // Hapus Flag Akreditasi
    $routes->get('remove_from_accreditation/(:num)', 'Admin\AdminRespon::remove_from_accreditation/$1');


    // ========= Dynamic Prodi =============
    $routes->get('getProdiByJurusan/(:any)', 'Admin\AdminRespon::getProdiByJurusan/$1');

    // Save Flags AMI & Akreditasi
    $routes->post('saveFlags', 'Admin\AdminRespon::saveFlags');
});




// =======================
// ROUTES KAPRODI
// =======================
$routes->group('kaprodi', ['filter' => 'kaprodiAuth'], function ($routes) {

    // DASHBOARD & PROFIL
    $routes->get('dashboard', 'kaprodi\KaprodiController::dashboard');
    $routes->get('profil', 'kaprodi\KaprodiController::profil');
    $routes->get('profil/edit', 'kaprodi\KaprodiController::editProfil');
    $routes->post('profil/update', 'kaprodi\KaprodiController::updateProfil');

    // DELETE PERTANYAAN (HARUS DITARUH SEBELUM GROUP KUESIONER)
    $routes->get('questioner/delete/(:num)', 'kaprodi\KaprodiController::delete/$1');

    // MENU QUESTIONER
    $routes->get('questioner', 'kaprodi\KaprodiController::questioner');
    $routes->get('questioner/pertanyaan/(:num)', 'kaprodi\KaprodiController::pertanyaan/$1');
    $routes->get('questioner/(:num)/download', 'kaprodi\KaprodiController::downloadPertanyaan/$1');
    $routes->post('questioner/save_flags', 'kaprodi\KaprodiController::saveFlags');
    $routes->post('questioner/addToAkreditasi', 'kaprodi\KaprodiController::addToAkreditasi');
    $routes->post('questioner/addToAmi', 'kaprodi\KaprodiController::addToAmi');

    // FETCH OPTIONS
    $routes->get('kuesioner/pages/getQuestionOptions', 'kaprodi\KaprodiQuestionnairController::getQuestionOptions');

    // QUESTIONNAIRE GROUP
    $routes->group('kuesioner', function ($routes) {

        // CRUD Kuesioner
        $routes->get('', 'kaprodi\KaprodiQuestionnairController::index');
        $routes->get('create', 'kaprodi\KaprodiQuestionnairController::create');
        $routes->post('store', 'kaprodi\KaprodiQuestionnairController::store');
        $routes->get('(:num)', 'kaprodi\KaprodiQuestionnairController::show/$1');
        $routes->get('(:num)/edit', 'kaprodi\KaprodiQuestionnairController::edit/$1');
        $routes->post('(:num)/update', 'kaprodi\KaprodiQuestionnairController::update/$1');
        $routes->get('(:num)/delete', 'kaprodi\KaprodiQuestionnairController::delete/$1');

        // PAGE
        $routes->get('(:num)/pages', 'kaprodi\KaprodiPageController::index/$1');
        $routes->get('(:num)/pages/create', 'kaprodi\KaprodiPageController::create/$1');
        $routes->post('(:num)/pages/store', 'kaprodi\KaprodiPageController::store/$1');
        $routes->get('(:num)/pages/(:num)/edit', 'kaprodi\KaprodiPageController::edit/$1/$2');
        $routes->post('(:num)/pages/(:num)/update', 'kaprodi\KaprodiPageController::update/$1/$2');

        // SECTION
        $routes->get('(:num)/pages/(:num)/sections', 'kaprodi\KaprodiSectionController::index/$1/$2');
        $routes->get('(:num)/pages/(:num)/sections/create', 'kaprodi\KaprodiSectionController::create/$1/$2');
        $routes->post('(:num)/pages/(:num)/sections/store', 'kaprodi\KaprodiSectionController::store/$1/$2');
        $routes->get('(:num)/pages/(:num)/sections/(:num)/edit', 'kaprodi\KaprodiSectionController::edit/$1/$2/$3');
        $routes->post('(:num)/pages/(:num)/sections/(:num)/update', 'kaprodi\KaprodiSectionController::update/$1/$2/$3');

        // QUESTIONS
        $routes->get('(:num)/pages/(:num)/sections/(:num)/questions', 'kaprodi\KaprodiQuestionnairController::manageSectionQuestions/$1/$2/$3');
        $routes->post('(:num)/pages/(:num)/sections/(:num)/questions/store', 'kaprodi\KaprodiQuestionnairController::storeSectionQuestion/$1/$2/$3');
        $routes->get('(:num)/pages/(:num)/sections/(:num)/questions/(:num)', 'kaprodi\KaprodiQuestionnairController::getQuestion/$1/$2/$3/$4');
        $routes->post('(:num)/pages/(:num)/sections/(:num)/questions/(:num)/update', 'kaprodi\KaprodiQuestionnairController::updateQuestion/$1/$2/$3/$4');
        $routes->post('(:num)/pages/(:num)/sections/(:num)/questions/delete/(:num)', 'kaprodi\KaprodiQuestionnairController::deleteSectionQuestion/$1/$2/$3/$4');
        $routes->post('(:num)/pages/(:num)/sections/(:num)/questions/(:num)/duplicate', 'kaprodi\KaprodiQuestionnairController::duplicate/$1/$2/$3/$4');
    });

    // AKREDITASI (FIX NAMESPACE)
    $routes->get('akreditasi', 'kaprodi\KaprodiController::akreditasi');
    $routes->get('akreditasi/detail/(:any)', 'kaprodi\KaprodiController::detailAkreditasi/$1');

    // AMI
    $routes->get('ami', 'kaprodi\KaprodiController::ami');
    $routes->get('ami/detail/(:any)', 'kaprodi\KaprodiController::detailAmi/$1');

    // ALUMNI
    $routes->get('alumni', 'kaprodi\KaprodiController::alumni');
    $routes->get('alumni/export', 'kaprodi\KaprodiController::exportAlumni');
});



// ==================== JABATAN GROUP ====================
$routes->group('jabatan', ['filter' => 'jabatanAuth'], function ($routes) {

    // Dashboard Perusahaan
    $routes->get('dashboard', 'Organisasi\JabatanController::dashboard');

    // Control Panel
    $routes->get('control-panel', 'Organisasi\JabatanController::controlPanel');
    $routes->post('filter-control-panel', 'Organisasi\JabatanController::filterControlPanel');
    $routes->get('get-prodi-by-jurusan', 'Organisasi\JabatanController::getProdiByJurusan');

    // Detail AMI / Akreditasi
    $routes->get('detail-ami', 'Organisasi\JabatanController::detailAmi');
    $routes->get('detail-akreditasi', 'Organisasi\JabatanController::detailAkreditasi');
});

// ==================== PERUSAHAAN DASHBOARD ====================
$routes->get('perusahaan/dashboard', 'Organisasi\PerusahaanController::dashboard');

