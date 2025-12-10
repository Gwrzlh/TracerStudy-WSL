<?php

namespace App\Controllers\Organisasi;

use App\Models\Organisasi\JurusanModel;
use App\Models\Organisasi\SatuanOrganisasiModel;
use App\Models\Organisasi\Prodi;
use CodeIgniter\Controller;

class Jurusan extends Controller
{
    public function index()
    {
        $jurusanModel = new JurusanModel();
        $satuanModel  = new SatuanOrganisasiModel();
        $prodiModel   = new Prodi();

        // Ambil keyword dari GET
        $keyword = $this->request->getGet('keyword');

        // Query untuk badge (hitung total tanpa filter)
        $data['count_satuan']  = $satuanModel->countAll();
        $data['count_jurusan'] = $jurusanModel->countAll();
        $data['count_prodi']   = $prodiModel->countAll();

        // Filter jika ada keyword (pencarian berdasarkan nama_jurusan)
        if ($keyword) {
            $jurusanModel->like('nama_jurusan', $keyword);
        }

        // Ambil data jurusan
        $data['jurusan'] = $jurusanModel->findAll();
        $data['keyword'] = $keyword; // supaya input search tetap terisi

        return view('adminpage/organisasi/satuanorganisasi/jurusan/index', $data);
    }

    public function create()
    {
        return view('adminpage/organisasi/satuanorganisasi/jurusan/create');
    }

   public function store()
{
    $jurusanModel = new \App\Models\Organisasi\Jurusan();

    $data = [
        'nama_jurusan' => $this->request->getPost('nama_jurusan'),
        'singkatan'    => strtoupper(trim($this->request->getPost('singkatan')))
    ];

    if (!$jurusanModel->insert($data)) {
        return redirect()->back()->with('errors', $jurusanModel->errors());
    }

    return redirect()->to('/admin/jurusan')->with('success', 'Jurusan berhasil ditambahkan');
}


    public function edit($id)
    {
        $model = new JurusanModel();
        $data['jurusan'] = $model->find($id);
        return view('adminpage/organisasi/satuanorganisasi/jurusan/edit', $data);
    }

    public function update($id)
{
    $model = new JurusanModel();

    $data = [
        'nama_jurusan' => $this->request->getPost('nama_jurusan'),
        'singkatan'    => strtoupper(trim($this->request->getPost('singkatan')))
    ];

    $model->update($id, $data);

    return redirect()->to('/admin/jurusan')->with('success', 'Data jurusan berhasil diperbarui.');
}


  public function delete($id)
{
    $jurusanModel = new \App\Models\Organisasi\JurusanModel();
    $satuanModel = new \App\Models\Organisasi\SatuanOrganisasiModel(); // pastikan model tabel anak

    $dataJurusan = $jurusanModel->find($id);

    if (!$dataJurusan) {
        return redirect()->to('/admin/jurusan')->with('error', 'Data jurusan tidak ditemukan.');
    }

    // Hapus semua data anak yang terkait
    $satuanModel->where('id_jurusan', $id)->delete();

    // Baru hapus data jurusan
    $jurusanModel->delete($id);

    return redirect()->to('/admin/jurusan')->with('success', 'Data jurusan beserta data terkait berhasil dihapus.');
}


}
