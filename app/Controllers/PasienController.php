<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Database\Config;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class PasienController extends BaseController
{
    private $db, $UserInfo, $timenow;
    public function __construct()
    {
        date_default_timezone_set('Asia/jakarta');
        $this->db = Config::connect();
        $this->UserInfo = $this->db->table('users')->where('id', session()->get('loggedUser'))->get()->getRowObject();
        $this->timenow = date('Y-m-d H:i:s');
    }

    public function GetIDPasienCabang($unit_id, $registri)
    {
        date_default_timezone_set('Asia/jakarta'); # add your city to set local time zone
        $now = date('Y-m-d H:i:s');
        $sql = "SELECT MAX(RIGHT(id_pasien,4)) as KD_MAX FROM pasien WHERE registri='" . $registri . "' AND unit_id='" . $unit_id . "'";
        $query = $this->db->query($sql);
        if ($query->getNumRows() > 0) {
            $row = $query->getRow();
            $n = ((int) $row->KD_MAX) + 1;
            $no = sprintf("%04s", $n);
        } else {
            $no = "0001";
        }
        $kode = '#P' . $unit_id . "-" . date('Ymd') . $no;
        return $kode;
    }

    public function GetIDPasienKunjungan($unit_id)
    {
        date_default_timezone_set('Asia/jakarta'); # add your city to set local time zone
        $now = date('Y-m-d H:i:s');
        $sql = "SELECT MAX(RIGHT(no_antrian,4)) as KD_MAX FROM antrian_kunjungan WHERE unit_id='" . $unit_id . "' AND tanggal='" . date('Y-m-d') . "'";
        $query = $this->db->query($sql);
        if ($query->getNumRows() > 0) {
            $row = $query->getRow();
            $n = ((int) $row->KD_MAX) + 1;
            $no = sprintf("%04s", $n);
        } else {
            $no = "0001";
        }
        $kode = 'ANT' . $unit_id . "-" . date('Ymd') . $no;
        return $kode;
    }

    public function index()
    {
        if ($this->UserInfo->level == 'Admin Cabang') {
            $datapasien = $this->db->table('pasien')->where('unit_id', $this->UserInfo->unit_id)->get()->getResultObject();
            $data = [
                'title' => 'App Miguna - Pasien',
                'userinfo' => $this->UserInfo,
                'datapasien' => $datapasien,
                'no_antrian' => $this->GetIDPasienKunjungan($this->UserInfo->unit_id),
            ];
            return view('/pages/pasien/pasien', $data);
        } else {
        }
    }

    public function admin_insert()
    {
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');
        $nik = $this->request->getPost('nik');
        $nama = $this->request->getPost('nama');
        $usia = $this->request->getPost('usia');
        $alamat = $this->request->getPost('alamat');
        $jk = $this->request->getPost('jk');
        $pekerjaan = $this->request->getPost('pekerjaan');
        $hp = $this->request->getPost('hp');
        $registri = $this->request->getPost('registri');
        //
        $userid = $this->UserInfo->id;
        $unit_id = $this->UserInfo->unit_id;
        $id_pasien = $this->GetIDPasienCabang($unit_id, $registri);

        $data = [
            'id_pasien' => $id_pasien,
            'nik' => $nik,
            'nama' => $nama,
            'usia' => $usia,
            'alamat' => $alamat,
            'jk' => $jk,
            'pekerjaan' => $pekerjaan,
            'registri' => $registri,
            'hp' => $hp,
            'unit_id' => $unit_id,
            'user_id' => $userid,
            'created_at' => $now,
            'updated_at' => $now,
        ];

        $query = $this->db->table('pasien')->insert($data);
        if ($query) {
            $response = [
                'status' => 'success',
                'message' => 'Data saved successfully',
            ];
        } else {
            $reponse = [
                'status' => 'error',
                'message' => 'Error saving data',
            ];
        }
        return json_encode($response);
    }

    public function admin_getdata()
    {
        $unit_id = $this->UserInfo->unit_id;
        $query = $this->db->table('pasien')->where('unit_id', $unit_id)->get()->getResultObject();
        $no = 1;
        if (empty($query)) {
            $data = [
                'no' => '',
                'action' => '',
                'id_pasien' => '',
                'nik' => '',
                'nama' => '',
                'usia' => '',
                'alamat' => '',
                'jk' => '',
                'pekerjaan' => '',
                'hp' => '',
                'registri' => '',
                'created_at' => '',
            ];
            $response = $data;
        } else {
            foreach ($query as $row) {
                $data = [
                    'no' => $no,
                    'action' => "<div class='button-group'><button class='btn btn-md btn-info' onclick='edit_admin_pasien()'><i class='fa fa-edit'></i></button><button class='btn btn-md btn-danger' onclick='delete_admin_pasien()'><i class='fa fa-trash'></i></button><button class='btn btn-md btn-dark' onclick='antrian_pasien_admin()'><i class='fas fa-user-friends'></i></button><button class='btn btn-md btn-success' onclick='riwayat_transaksi_kunjungan_pasien()'><i class='fas fa-id-card'></i></button></div>",
                    'id_pasien' => $row->id_pasien,
                    'nik' => $row->nik,
                    'nama' => $row->nama,
                    'usia' => $row->usia,
                    'alamat' => $row->alamat,
                    'jk' => $row->jk,
                    'pekerjaan' => $row->pekerjaan,
                    'hp' => $row->hp,
                    'registri' => $row->registri,
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
        $id_pasien = $this->request->getPost('id_pasien');
        $query = $this->db->table('pasien')->where('id_pasien', $id_pasien)->get()->getRowObject();
        $data = [
            'nik' => $query->nik,
            'nama' => $query->nama,
            'usia' => $query->usia,
            'alamat' => $query->alamat,
            'jk' => $query->jk,
            'pekerjaan' => $query->pekerjaan,
            'hp' => $query->hp,
            'registri' => $query->registri,
        ];
        return json_encode($data);
    }

    public function admin_update()
    {
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');
        $id_pasien = $this->request->getPost('id_pasien');
        $nik = $this->request->getPost('nik');
        $nama = $this->request->getPost('nama');
        $usia = $this->request->getPost('usia');
        $alamat = $this->request->getPost('alamat');
        $jk = $this->request->getPost('jk');
        $pekerjaan = $this->request->getPost('pekerjaan');
        $hp = $this->request->getPost('hp');
        $registri = $this->request->getPost('registri');
        $userid = $this->UserInfo->id;

        $data = [
            'nik' => $nik,
            'nama' => $nama,
            'usia' => $usia,
            'alamat' => $alamat,
            'jk' => $jk,
            'pekerjaan' => $pekerjaan,
            'registri' => $registri,
            'hp' => $hp,
            'user_id' => $userid,
            'updated_at' => $now,
        ];

        $query = $this->db->table('pasien')->where('id_pasien', $id_pasien)->update($data);
        if ($query) {
            $response = [
                'status' => 'success',
                'message' => 'Update successfuly',
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'errorfuly',
            ];
        }
        return json_encode($response);
    }

    public function admin_delete()
    {
        $id_pasien = $this->request->getPost('id_pasien');
        $query = $this->db->table('pasien')->where('id_pasien', $id_pasien)->delete();
        if ($query) {
            $response = [
                'status' => 'success',
                'message' => 'Successfully !',
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Error !',
            ];
        }
        return json_encode($response);
    }

    public function admin_antrian_kunjungan()
    {
        date_default_timezone_set('Asia/Jakarta');
        $id_pasien = $this->request->getPost('id_pasien');
        $no_kunjungan = $this->request->getPost('no_kunjungan');
        $nama_pasien = $this->request->getPost('nama_pasien');
        $catatan = $this->request->getPost('catatan');

        $dataantrian = $this->db->table('antrian_kunjungan')->where('id_pasien', $id_pasien)->where('tanggal', date('Y-m-d'))->get()->getRowObject();
        $datapasien = $this->db->table('pasien')->where('id_pasien', $id_pasien)->get()->getRowObject();
        $pasien_id = $datapasien->id;
        $userid = $this->UserInfo->id;
        $unit_id = $this->UserInfo->unit_id;

        if (empty($dataantrian)) {
            $data = [
                'no_antrian' => $no_kunjungan,
                'pasien_id' => $pasien_id,
                'id_pasien' => $id_pasien,
                'tanggal' => date('Y-m-d'),
                'catatan_kunjungan' => $catatan,
                'status' => 'antrian',
                'user_id' => $userid,
                'unit_id' => $unit_id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $query = $this->db->table('antrian_kunjungan')->insert($data);
            if ($query) {
                $response = [
                    'status' => 'success',
                    'message' => 'successfully !',
                ];
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'Error ! ',
                ];
            }
        } else {
            $response = [
                'status' => 'anyway',
                'message' => 'Data Sudah Dimasukkan Ke Antrian ! ',
            ];
        }
        return json_encode($response);
    }

    public function admin_download()
    {
        return $this->response->download('source/pasien.xlsx', null);
    }

    public function import_data_guru()
    {
        date_default_timezone_set('Asia/Jakarta');
        $user_id = $this->UserInfo->id;
        $unit_id = $this->UserInfo->unit_id;
        $berkas = $this->request->getFile("file_pasien");
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
                'id_pasien' => $row[0],
                'nik' => $row[1],
                'nama' => $row[2],
                'usia' => $row[3],
                'alamat' => $row[4],
                'jk' => $row[5],
                'pekerjaan' => $row[6],
                'hp' => $row[7],
                'registri' => $row[8],
                'unit_id' => $unit_id,
                'user_id' => $user_id,
                'created_at' => $this->timenow,
                'updated_at' => $this->timenow,
            ];
            $query1 = $this->db->table("pasien")->insert($data);
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
