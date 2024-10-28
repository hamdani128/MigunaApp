<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Database\Config;

class LokasiController extends BaseController
{

    private $db, $userinfo;
    public function __construct()
    {
        $this->db = Config::connect();
        $this->userinfo = $this->db->table('users')->where('id', session()->get('loggedUser'))->get()->getRowObject();
    }

    public function index()
    {
        $data_lokasi = $this->db->table('unit')->get()->getResultObject();
        $data = [
            'title' => 'App Miguna - Lokasi Cabang',
            'userinfo' => $this->userinfo,
            'lokasi' => $data_lokasi,
        ];
        return view('pages/cabang/cabang', $data);
    }

    public function insert()
    {
        date_default_timezone_set('Asia/jakarta'); # add your city to set local time zone
        $now = date('Y-m-d H:i:s');
        $unit = $this->request->getPost('unit');
        $alamat = $this->request->getPost('alamat');
        $kecamatan = $this->request->getPost('kecamatan');
        $kabupaten = $this->request->getPost('kabupaten');
        $provinsi = $this->request->getPost('provinsi');

        $data = [
            'unit' => $unit,
            'alamat' => $alamat,
            'kecamatan' => $kecamatan,
            'kabupaten' => $kabupaten,
            'provinsi' => $provinsi,
            'created_at' => $now,
            'updated_at' => $now,
        ];
        $query = $this->db->table('unit')->insert($data);
        if ($query) {
            $response = [
                'status' => 'success',
                'message' => 'Data Berhasil Disimpan !',
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Data Gagal Disimpan !',
            ];
        }
        return json_encode($response);
    }

    public function edit_show()
    {
        $id = $this->request->getPost('id');
        $query = $this->db->table('unit')->where('id', $id)->get()->getRowObject();
        $data = [
            'unit' => $query->unit,
            'alamat' => $query->alamat,
            'kecamatan' => $query->kecamatan,
            'kabupaten' => $query->kabupaten,
            'provinsi' => $query->provinsi,
        ];
        return json_encode($data);
    }

    public function update()
    {
        $id = $this->request->getPost('id');
        $unit = $this->request->getPost('unit');
        $alamat = $this->request->getPost('alamat');
        $kecamatan = $this->request->getPost('kecamatan');
        $kabupaten = $this->request->getPost('kabupaten');
        $provinsi = $this->request->getPost('provinsi');
        date_default_timezone_set('Asia/jakarta'); # add your city to set local time zone
        $now = date('Y-m-d H:i:s');

        $data = [
            'unit' => $unit,
            'alamat' => $alamat,
            'kecamatan' => $kecamatan,
            'kabupaten' => $kabupaten,
            'provinsi' => $provinsi,
            'updated_at' => $now,
        ];

        $query = $this->db->table('unit')->where('id', $id)->update($data);
        if ($query) {
            $response = [
                'status' => 'success',
                'message' => 'Data Berhasil Dirubah !',
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Data Gagal Dirubah !',
            ];
        }
        return json_encode($response);

    }

    public function delete()
    {
        $id = $this->request->getPost('id');
        $query = $this->db->table('unit')->where('id', $id)->delete();
        if ($query) {
            $response = [
                'status' => 'success',
                'message' => 'Data Berhasil Dihapus !',
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Gagal Berhasil Dihapus !',
            ];
        }
        return json_encode($response);
    }

    public function getdata()
    {
        $query = $this->db->table('unit')->get()->getResultObject();
        foreach ($query as $row) {
            $data['aksi'] = "<button><i class='btn btn-md btn-primary'></i></button>";
            $data['unit'] = $row->unit;
            $data['alamat'] = $row->alamat;
            $data['kecamatan'] = $row->kecamatan;
            $data['kabupaten'] = $row->kabupaten;
            $data['provinsi'] = $row->provinsi;
            $data['created_at'] = $row->created_at;
        }
        $response['data'] = $data;
        return json_encode($response);
    }

}
