<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Database\Config;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class TreatmentController extends BaseController
{
    private $db, $UserInfo;
    public function __construct()
    {
        $this->db = Config::connect();
        $this->UserInfo = $this->db->table('users')->where('id', session()->get('loggedUser'))->get()->getRowObject();
    }

    public function GetIDTreatment($unit_id)
    {
        date_default_timezone_set('Asia/jakarta'); # add your city to set local time zone
        $now = date('Y-m-d H:i:s');
        $sql = "SELECT MAX(RIGHT(id_treatment,4)) as KD_MAX FROM treatment WHERE unit_id='" . $unit_id . "'";
        $query = $this->db->query($sql);
        if (!empty($query)) {
            $row = $query->getRow();
            $n = ((int) $row->KD_MAX) + 1;
            $no = sprintf("%04s", $n);
            $kode = "#TD" . $unit_id . "-" . $no;
        } else {
            $kode = "#TD" . $unit_id . "-" . "0001";
        }
        return $kode;
    }

    public function index()
    {

        if ($this->UserInfo->level == 'Admin Cabang') {
            $data = [
                'title' => 'App Miguna - Info Product',
                'kodetreatment' => $this->GetIDTreatment($this->UserInfo->unit_id),
                'userinfo' => $this->UserInfo,
                // '' => $this->db->table('supplier')->where('unit_id', $this->UserInfo->unit_id)->get()->getResultObject(),
            ];
            return view('/pages/treatment/treatment', $data);
        } else {
        }
    }

    public function admin_insert()
    {
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');
        $id_treat = $this->request->getPost('id_treat');
        $nama = $this->request->getPost('nama');
        $harga = $this->request->getPost('harga');
        $kategori = $this->request->getPost('kategori');
        $user_id = $this->UserInfo->id;
        $unit_id = $this->UserInfo->unit_id;

        $data = [
            'id_treatment' => $id_treat,
            'nama' => $nama,
            'harga' => $harga,
            'kategori' => $kategori,
            'unit_id' => $unit_id,
            'user_id' => $user_id,
            'created_at' => $now,
            'updated_at' => $now,
        ];

        $query = $this->db->table('treatment')->insert($data);
        if ($query) {
            $response = [
                'status' => 'success',
                'message' => 'successfully created',
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Error creating',
            ];
        }
        return json_encode($response);
    }

    public function admin_get()
    {
        $unit_id = $this->UserInfo->unit_id;
        $query = $this->db->table('treatment')->where('unit_id', $unit_id)->get()->getResultObject();
        $no = 1;
        if (empty($query)) {
            $data = [
                'no' => "",
                'action' => "",
                'id_treat' => "",
                'nama' => "",
                'harga' => "",
                'kategori' => "",
                'created_at' => "",
            ];
            $response[] = $data;
        } else {
            foreach ($query as $row) {
                $data = [
                    'no' => $no,
                    'action' => "<div class='button-group'><button class='btn btn-md btn-info' onclick='edit_admin_treatment()'><i class='fa fa-edit'></i></button><button class='btn btn-md btn-danger' onclick='delete_admin_treatment()'><i class='fa fa-trash'></i></button></div>",
                    'id_treat' => $row->id_treatment,
                    'nama' => $row->nama,
                    'harga' => $row->harga,
                    'kategori' => $row->kategori,
                    'created_at' => $row->created_at,
                ];
                $response[] = $data;
                $no++;
            }
        }
        return json_encode($response);
    }

    public function admin_edit_show()
    {
        $id_treat = $this->request->getPost('id_treat');
        $query = $this->db->table('treatment')->where('id_treatment', $id_treat)->get()->getRowObject();
        $data = [
            'id_treat' => $query->id_treatment,
            'nama' => $query->nama,
            'harga' => $query->harga,
            'kategori' => $query->kategori,
        ];
        return json_encode($data);
    }

    public function admin_update()
    {
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');
        $id_treat = $this->request->getPost('id_treat');
        $nama = $this->request->getPost('nama');
        $harga = $this->request->getPost('harga');
        $kategori = $this->request->getPost('kategori');
        $user_id = $this->UserInfo->id;
        $unit_id = $this->UserInfo->unit_id;
        $data = [
            'nama' => $nama,
            'harga' => $harga,
            'kategori' => $kategori,
            'unit_id' => $unit_id,
            'user_id' => $user_id,
            'updated_at' => $now,
        ];

        $query = $this->db->table('treatment')->where('id_treatment', $id_treat)->update($data);
        if ($query) {
            $response = [
                'status' => 'success',
                'message' => 'successfully Updated',
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Error Updated',
            ];
        }
        return json_encode($response);
    }

    public function admin_delete()
    {
        $id_treat = $this->request->getPost('id_treat');
        $query = $this->db->table('treatment')->where('id_treatment', $id_treat)->delete();
        if ($query) {
            $response = [
                'status' => 'success',
                'message' => 'successfully Deleted !',
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Error Deleted !',
            ];
        }
        return json_encode($response);
    }

    public function download_format()
    {
        return $this->response->download('source/treatment.xlsx', null);
    }

    public function import_data()
    {
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');
        $user_id = $this->UserInfo->id;
        $unit_id = $this->UserInfo->unit_id;
        $berkas = $this->request->getFile("file_treatment");
        $ext = $berkas->getClientExtension();
        if ($ext == 'xls') {
            $render = new Xls();
        } else {
            $render = new Xlsx();
        }
        $preadsheet = $render->load($berkas);
        $data = $preadsheet->getActiveSheet()->toArray();
        foreach ($data as $x => $row) {
            if ($x == 0) {
                continue;
            }
            $data = [
                'id_treatment' => $row[0],
                'nama' => $row[1],
                'harga' => $row[2],
                'kategori' => $row[3],
                'unit_id' => $unit_id,
                'user_id' => $user_id,
                'created_at' => $now,
                'updated_at' => $now,
            ];
            $query1 = $this->db->table("treatment")->insert($data);
        }
        if ($query1) {
            $response = [
                'status' => 'success',
                'message' => 'success',
            ];
        } else {
            $response = [
                'status' => 'failed',
                'message' => 'failed',
            ];
        }
        return json_encode($response);
    }
}
