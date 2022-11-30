<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Database\Config;

class SDMController extends BaseController
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
            ];  
            return view('/pages/sdm/sdm', $data);
        }else{
            
        }
    }

    public function getdata()
    {
            if($this->UserInfo->level == 'Admin Cabang'){
                $datasdm = $this->db->table("sdm")->where('unit_id', $this->UserInfo->unit_id)->get()->getResultObject();
                $no=1;
                if(empty($datasdm)){
                    $data = [
                        'no' => '',
                        'action' => '',
                        'nama' => '',
                        'status' => '',
                        'jk' => '',
                        'created_at' => '',
                    ];
                    $response = $data;
                }else{  
                    foreach ($datasdm as $row){
                        $data = [
                                'no' => $no,
                                'action' =>"<div class='button-group'><button class='btn btn-md btn-info' onclick='edit_admin_sdm()'><i class='fa fa-edit'></i></button><button class='btn btn-md btn-danger' onclick='delete_admin_sdm()'><i class='fa fa-trash'></i></button></div>",
                                'nama' => $row->nama,
                                'status' => $row->status,
                                'jk' => $row->jk,
                                'created_at' => $row->created_at,
                        ];
                        $response[] = $data; 
                        $no++;
                }
            }
            
            }else{
                $datasdm = $this->db->table("sdm")->get()->getResultObject();
                $no=1;
                if(empty($datasdm)){
                    $data = [
                        'no' => '',
                        'action' => '',
                        'nama' => '',
                        'status' => '',
                        'jk' => '',
                        'created_at' => '',
                    ];
                    $response = $data;
                }else{
                    foreach ($datasdm as $row){
                        $id = $row->id;
                        $data = [
                                'no' => $no,
                                'action' =>"<div class='button-group'><button class='btn btn-md btn-info' onclick='edit_admin_sdm()'><i class='fa fa-edit'></i></button><button class='btn btn-md btn-danger' onclick='delete_admin_sdm()'><i class='fa fa-trash'></i></button></div>",
                                'id_pasien' => $row->id_pasien,
                                'nama' => $row->nama,
                                'status' => $row->status,
                                'jk' => $row->jk,
                                'created_at' => $row->created_at,
                        ];
                        $response[] = $data; 
                        $no++;
                }
            }
        }
        return json_encode($response);
    }

    public function insert()
    {
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');
        $nama = $this->request->getPost("nama");
        $status = $this->request->getPost("cmb_status");
        $jabatan = $this->request->getPost("cmb_status_text");
        $jk = $this->request->getPost("jk");

        $data = [
            'nama' => $nama,
            'status' => $status,
            'jabatan' => $jabatan,
            'jk' => $jk,
            'user_id' => $this->UserInfo->id,
            'unit_id' => $this->UserInfo->unit_id,
            'created_at' => $now,
            'updated_at' => $now,
        ];

        $query = $this->db->table('sdm')->insert($data);

        if($query){
            $response = [
                'status' => 'success',
                'message' => 'Success',
            ];
        }else{
            $response = [
                'status' => 'error',
                'message' => 'Error',
            ];
        }
        return json_encode($response);
    }


    public function edit_show()
    {
        $nama = $this->request->getPost("nama");
        $unit_id = $this->UserInfo->unit_id;
        $value = $this->db->table('sdm')->where('nama', $nama)->where('unit_id', $unit_id)->get()->getRowObject();
        $data = [
            'id' => $value->id,
            'nama' => $value->nama,
            'status' => $value->status,
            'jabatan' => $value->jabatan,
            'jk' => $value->jk,
        ];
        return json_encode($data);
    }

}