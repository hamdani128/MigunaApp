<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Database\Config;

class PasienController extends BaseController
{
    private $db,$UserInfo;
    public function __construct() 
    {
        $this->db = Config::connect();
        $this->UserInfo = $this->db->table('users')->where('id', session()->get('loggedUser'))->get()->getRowObject();
    }
    
    public function index()
    {   
        if($this->UserInfo->level == 'Admin Cabang'){
            $datapasien = $this->db->table('pasien')->where('unit_id', $this->UserInfo->unit_id)->get()->getResultObject();
            $data = [
                'title' => 'App Miguna - Pasien',
                'userinfo' => $this->UserInfo,
                'datapasien' => $datapasien,
            ];
            return view('/pages/pasien/pasien', $data);
        }else{
            
        }
        
    }

    public function GetIDPasienCabang($unit_id, $registri)
    {
        date_default_timezone_set('Asia/jakarta'); # add your city to set local time zone
        $now = date('Y-m-d H:i:s');
        $sql = "SELECT MAX(RIGHT(id_pasien,4)) as KD_MAX FROM pasien WHERE registri='" . $registri . "' AND unit_id='" . $unit_id . "'";
        $query = $this->db->query($sql);
        if ($query->getNumRows() > 0) {
            $row = $query->getRow();
            $n = ((int)$row->KD_MAX) + 1;
            $no = sprintf("%04s", $n);
        } else {
            $no = "0001";
        }
        $kode = 'P'. $unit_id . "-" . date('Ymd') . $no;
        return $kode;
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
            'unit_id' => $unit_id,
            'user_id' => $userid,
            'created_at' => $now,
            'updated_at' => $now
        ];

        $query = $this->db->table('pasien')->insert($data);
        if($query){
            $response = [
                'status' => 'success',
                'message' => 'Data saved successfully',
            ];
        }else{
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
        $query = $this->db->table('pasien')->get()->getResultObject();
        $no=1;
        foreach ($query as $row){
            $data = [
                    'no' => $no,
                    'action' =>'<div class="button-group"><button class="btn btn-md btn-info" onclick="edit_admin_pasien()"><i class="fa fa-edit"></i></button><button class="btn btn-md btn-danger"><i class="fa fa-trash"></i></button><button class="btn btn-md btn-warning"><i class="fa fa-list"></i></button></div>',
                    'id_pasien' => $row->id_pasien,
                    'nik' => $row->nik,
                    'nama' => $row->nama,
                    'usia' => $row->usia,
                    'alamat' => $row->alamat,
                    'jk' => $row->jk,
                    'pekerjaan' => $row->pekerjaan,
                    'registri' => $row->registri,
                    'created_at' => $row->created_at,
            ];
            $response[] = $data; 
            $no++;
        }
        return json_encode($response);
    }

}