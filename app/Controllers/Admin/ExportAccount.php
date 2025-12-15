<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User\AccountModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class ExportAccount extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $alumni = $db->table('account')
            ->select("
        account.username,
        account.email,
        CASE
            WHEN account.id_role = 1 AND account.id_surveyor IS NOT NULL THEN 'Alumni Surveyor'
            WHEN account.id_role = 1 AND account.id_surveyor IS NULL THEN 'Alumni'
            ELSE role.nama
        END AS role,
        da.nama_lengkap AS nama,
        da.nim,
        jurusan.nama_jurusan,
        prodi.nama_prodi,
        da.angkatan,
        da.tahun_kelulusan,
        da.ipk,
        da.jenisKelamin,
        da.notlp,
        da.alamat,
        account.status
    ")
            ->join('role', 'role.id = account.id_role', 'left')
            ->join('detailaccount_alumni da', 'da.id_account = account.id', 'left')
            ->join('jurusan', 'jurusan.id = da.id_jurusan', 'left')
            ->join('prodi', 'prodi.id = da.id_prodi', 'left')
            ->where('role.nama', 'alumni')
            ->get()
            ->getResultArray();



        // --- PERUSAHAAN ---
        $perusahaan = $db->table('account')
            ->select('
                account.username,
                account.email,
                role.nama as role,
                detailaccoount_perusahaan.nama_perusahaan as nama,
                NULL as nim,
                NULL as nama_jurusan,
                NULL as nama_prodi,
                NULL as angkatan,
                NULL as tahun_kelulusan,
                NULL as ipk,
                NULL as jenisKelamin,
                detailaccoount_perusahaan.noTlp as notlp,
                detailaccoount_perusahaan.alamat1 as alamat,
                account.status
            ')
            ->join('role', 'role.id = account.id_role', 'left')
            ->join('detailaccoount_perusahaan', 'detailaccoount_perusahaan.id_account = account.id', 'left')
            ->where('role.nama', 'perusahaan')
            ->get()->getResultArray();

        // --- ADMIN ---
        $admin = $db->table('account')
            ->select('
                account.username,
                account.email,
                role.nama as role,
                detailaccount_admin.nama_lengkap as nama,
                NULL as nim,
                NULL as nama_jurusan,
                NULL as nama_prodi,
                NULL as angkatan,
                NULL as tahun_kelulusan,
                NULL as ipk,
                NULL as jenisKelamin,
                detailaccount_admin.no_hp as notlp,
                NULL as alamat,
                account.status
            ')
            ->join('role', 'role.id = account.id_role', 'left')
            ->join('detailaccount_admin', 'detailaccount_admin.id_account = account.id', 'left')
            ->where('role.nama', 'admin')
            ->get()->getResultArray();

        // --- KAPRODI ---
        $kaprodi = $db->table('account')
            ->select('
                account.username,
                account.email,
                role.nama as role,
                detailaccount_kaprodi.nama_lengkap as nama,
                NULL as nim,
                jurusan.nama_jurusan,
                prodi.nama_prodi,
                NULL as angkatan,
                NULL as tahun_kelulusan,
                NULL as ipk,
                NULL as jenisKelamin,
                detailaccount_kaprodi.notlp as notlp,
                NULL as alamat,
                account.status
            ')
            ->join('role', 'role.id = account.id_role', 'left')
            ->join('detailaccount_kaprodi', 'detailaccount_kaprodi.id_account = account.id', 'left')
            ->join('jurusan', 'jurusan.id = detailaccount_kaprodi.id_jurusan', 'left')
            ->join('prodi', 'prodi.id = detailaccount_kaprodi.id_prodi', 'left')
            ->where('role.nama', 'kaprodi')
            ->get()->getResultArray();

        // --- ATASAN ---
        $atasan = $db->table('account')
            ->select('
                account.username,
                account.email,
                role.nama as role,
                detailaccount_atasan.nama_lengkap as nama,
                NULL as nim,
                NULL as nama_jurusan,
                NULL as nama_prodi,
                NULL as angkatan,
                NULL as tahun_kelulusan,
                NULL as ipk,
                NULL as jenisKelamin,
                detailaccount_atasan.notlp as notlp,
                NULL as alamat,
                account.status
            ')
            ->join('role', 'role.id = account.id_role', 'left')
            ->join('detailaccount_atasan', 'detailaccount_atasan.id_account = account.id', 'left')
            ->where('role.nama', 'atasan')
            ->get()->getResultArray();

        // --- JABATAN LAINNYA ---
        $lainnya = $db->table('account')
            ->select('
                account.username,
                account.email,
                role.nama as role,
                detailaccount_jabatan_lainnya.nama_lengkap as nama,
                NULL as nim,
                jurusan.nama_jurusan,
                prodi.nama_prodi,
                NULL as angkatan,
                NULL as tahun_kelulusan,
                NULL as ipk,
                NULL as jenisKelamin,
                detailaccount_jabatan_lainnya.notlp as notlp,
                NULL as alamat,
                account.status
            ')
            ->join('role', 'role.id = account.id_role', 'left')
            ->join('detailaccount_jabatan_lainnya', 'detailaccount_jabatan_lainnya.id_account = account.id', 'left')
            ->join('jurusan', 'jurusan.id = detailaccount_jabatan_lainnya.id_jurusan', 'left')
            ->join('prodi', 'prodi.id = detailaccount_jabatan_lainnya.id_prodi', 'left')
            ->where('role.nama', 'jabatan_lainnya')
            ->get()->getResultArray();

        // Gabungkan semua hasil
        $allData = array_merge($alumni, $perusahaan, $admin, $kaprodi, $atasan, $lainnya);

        if (empty($allData)) {
            return redirect()->back()->with('error', 'Tidak ada data untuk diexport.');
        }

        // === EXPORT KE EXCEL ===
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = [
            'Username',
            'Email',
            'Role',
            'Nama Lengkap',
            'NIM',
            'Jurusan',
            'Prodi',
            'Angkatan',
            'Tahun Kelulusan',
            'IPK',
            'Jenis Kelamin',
            'No Telp',
            'Alamat',
            'Status'
        ];

        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '1', $header);
            $col++;
        }

        $row = 2;
        foreach ($allData as $data) {
            $sheet->setCellValue('A' . $row, $data['username']);
            $sheet->setCellValue('B' . $row, $data['email']);
            $sheet->setCellValue('C' . $row, ucfirst($data['role']));
            $sheet->setCellValue('D' . $row, $data['nama']);
            $sheet->setCellValueExplicit('E' . $row, $data['nim'], DataType::TYPE_STRING);
            $sheet->setCellValue('F' . $row, $data['nama_jurusan']);
            $sheet->setCellValue('G' . $row, $data['nama_prodi']);
            $sheet->setCellValue('H' . $row, $data['angkatan']);
            $sheet->setCellValue('I' . $row, $data['tahun_kelulusan']);
            $sheet->setCellValue('J' . $row, $data['ipk']);
            $sheet->setCellValue('K' . $row, $data['jenisKelamin']);
            $sheet->setCellValueExplicit('L' . $row, $data['notlp'], DataType::TYPE_STRING);
            $sheet->setCellValue('M' . $row, $data['alamat']);
            $sheet->setCellValue('N' . $row, ($data['status'] == 1 || strtolower($data['status']) == 'active') ? 'Active' : 'Inactive');
            $row++;
        }

        foreach (range('A', 'N') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $filename = 'semua_account_' . date('Ymd_His') . '.xlsx';
        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }
}
