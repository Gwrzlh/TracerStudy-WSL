<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Support\Provincies;
use App\Models\Support\Cities;

class ProvinciesController extends BaseController
{
    protected $provinciesModel;
    protected $citiesModel;

    public function __construct()
    {
        $this->provinciesModel = new Provincies();
        $this->citiesModel = new Cities();
    }

    public function index()
    {
        $pager = \Config\Services::pager();

        $query = $this->_getProvincesQuery();

        $data = [
            'provinces' => $query->paginate(15), // 15 per halaman
            'pager'     => $this->provinciesModel->pager,
            'search'    => $this->request->getGet('search') ?? ''
        ];

        return view('adminpage/Provincies/index', $data);
    }
    
    public function getCitiesByProvince($provinceId): ResponseInterface
    {
        $cities = $this->citiesModel->where('province_id', $provinceId)->findAll();
        return $this->response->setJSON($cities);
    }

    public function create()
    {
        return view('adminpage/Provincies/Create');
    }

    public function store()
    {
        // Validation rules
        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required|min_length[3]|is_unique[provinces.name]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
        ];

        $this->provinciesModel->insert($data);

        return redirect()->to('/admin/provinces')->with('success', 'Province created successfully.');
    }

    public function edit($id)
    {
        $data['province'] = $this->provinciesModel->find($id);
        if (!$data['province']) {
            return redirect()->to('/admin/provinces')->with('error', 'Province not found.');
        }
        return view('adminpage/Provincies/edit', $data);
    }

    public function update($id)
    {
        $province = $this->provinciesModel->find($id);
        if (!$province) {
            return redirect()->to('/admin/provinces')->with('error', 'Province not found.');
        }

        // Validation rules (allow same name if unchanged)
        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required|min_length[3]|is_unique[provinces.name,id,' . $id . ']',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
        ];

        $this->provinciesModel->update($id, $data);

        return redirect()->to('/admin/provinces')->with('success', 'Province updated successfully.');
    }

    public function delete($id)
    {
        $province = $this->provinciesModel->find($id);
        if (!$province) {
            return redirect()->to('/admin/provinces')->with('error', 'Province not found.');
        }

        // Optional: Check if there are cities linked, prevent delete if any
        $citiesCount = $this->citiesModel->where('province_id', $id)->countAllResults();
        if ($citiesCount > 0) {
            return redirect()->to('/admin/provinces')->with('error', 'Cannot delete province with associated cities.');
        }

        $this->provinciesModel->delete($id);

        return redirect()->to('/admin/provinces')->with('success', 'Province deleted successfully.');
    }
    public function detail($provinceId)
    {
        $province = $this->provinciesModel->find($provinceId);
        if (!$province) {
            return redirect()->to('/admin/provinces')->with('error', 'Provinsi tidak ditemukan');
        }

        $query = $this->_getCitiesQuery($provinceId);

        $data = [
            'province' => $province,
            'cities'   => $query->paginate(20), // 20 kota per halaman
            'pager'    => $this->citiesModel->pager,
            'search'   => $this->request->getGet('search') ?? ''
        ];

        return view('adminpage/Provincies/detail', $data);
    }

    // === CRUD Kota ===
    public function createCity($provinceId)
    {
        $data['province'] = $this->provinciesModel->find($provinceId);
        if (!$data['province']) {
            return redirect()->to('/admin/provinces')->with('error', 'Provinsi tidak ditemukan');
        }
        return view('adminpage/Provincies/city_create', $data);
    }

    public function storeCity($provinceId)
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required|min_length[3]|is_unique[cities.name,province_id,' . $provinceId . ']',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->citiesModel->insert([
            'province_id' => $provinceId,
            'name'        => $this->request->getPost('name')
        ]);

        return redirect()->to("/admin/provinces/{$provinceId}")->with('success', 'Kota/Kabupaten berhasil ditambahkan');
    }

    public function editCity($provinceId, $cityId)
    {
        $data['province'] = $this->provinciesModel->find($provinceId);
        $data['city']     = $this->citiesModel->find($cityId);

        if (!$data['province'] || !$data['city']) {
            return redirect()->to('/admin/provinces')->with('error', 'Data tidak ditemukan');
        }

        return view('adminpage/Provincies/city_edit', $data);
    }

    public function updateCity($provinceId, $cityId)
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required|min_length[3]|is_unique[cities.name,id,' . $cityId . ']',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->citiesModel->update($cityId, [
            'name' => $this->request->getPost('name')
        ]);

        return redirect()->to("/admin/provinces/{$provinceId}")->with('success', 'Kota/Kabupaten berhasil diupdate');
    }

    public function deleteCity($provinceId, $cityId)
    {
        $this->citiesModel->delete($cityId);
        return redirect()->to("/admin/provinces/{$provinceId}")->with('success', 'Kota/Kabupaten berhasil dihapus');
    }
    private function _getProvincesQuery()
    {
        $search = $this->request->getGet('search');
        $builder = $this->provinciesModel->select('id, name');

        if ($search) {
            $builder->like('name', $search, 'both');
        }

        return $builder->orderBy('name', 'ASC');
    }

    // Untuk search & pagination kota di halaman detail
    private function _getCitiesQuery($provinceId)
    {
        $search = $this->request->getGet('search');
        $builder = $this->citiesModel->where('province_id', $provinceId);

        if ($search) {
            $builder->like('name', $search, 'both');
        }

        return $builder->orderBy('name', 'ASC');
    }
}
