<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Database\Config;

class TransaksiKunjungan extends BaseController
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
            // $datapasien = $this->db->table('pasien')->where('unit_id', $this->UserInfo->unit_id)->get()->getResultObject();
            $data = [
                'title' => 'App Miguna - Kunjungan Pasien',
                'userinfo' => $this->UserInfo,
            ];
            return view('/pages/transaksi/transaksi_kunjungan', $data);
        }else{
            
        }
    }

    public function getdata()
    {
        if($this->UserInfo->level == 'Admin Cabang' || $this->UserInfo->level == 'Dokter Cabang'){
            date_default_timezone_set('Asia/Jakarta');
            $now = date('Y-m-d');
            $unit_id = $this->UserInfo->unit_id;
                $SQL = "SELECT
                        a.id as id,
                        a.no_antrian as no_antrian,
                        a.id_pasien as id_pasien,
                        b.nama as nama,
                        a.catatan_kunjungan as catatan_kunjungan,
                        a.status as status,
                        a.tanggal as tanggal,
                        a.created_at as created_at
                        FROM antrian_kunjungan a 
                        LEFT JOIN pasien b ON a.id_pasien = b.id_pasien 
                        WHERE a.unit_id='" . $unit_id . "' AND a.tanggal='" . $now . "'";
                $query = $this->db->query($SQL)->getResultObject();
                $no=1;
                if(!empty($query)){
                    foreach ($query as $row){
                        if($row->status == 'antrian'){
                            $status = "<h5 class='badge badge-boxed  badge-soft-warning'>".$row->status."</h5>";
                        }
                        $data = [
                            'no' => $no,
                            'action' => "<div class='button-group'><button class='btn btn-md btn-danger' onclick='delete_transaksi_kunjungan()'><i class='fa fa-trash'></i></button><button class='btn btn-md btn-dark' onclick='diagnosa_pasien_dokter()'><i class='fas fa-user-edit'></i></button><button class='btn btn-md btn-success'><i class='fas fa-id-card'></i></button></div>",
                            'no_antrian' => $row->no_antrian,
                            'id_pasien' => $row->id_pasien,
                            'nama' => $row->nama,
                            'catatan_kunjungan' => $row->catatan_kunjungan,
                            'status' => $status,
                            'tanggal' => $row->tanggal,
                            'created_at' => $row->created_at,
                        ];
                        $no++;
                    }
                }else{
                    $data = [
                        'no' => '',
                        'action' => '',
                        'no_antrian' => '',
                        'id_pasien' => '',
                        'nama' => '',
                        'catatan_kunjungan' => '',
                        'status' => '',
                        'tanggal' => '',
                        'created_at' => '',
                    ];
                    $no++;
                }
                $response[] = $data;
                return json_encode($response);
        }else{
            
        }
    }

    public function add_diagnosa()
    {
        date_default_timezone_set("Asia/Jakarta");
        $now = date('Y-m-d H:i:s');
        $no_antrian = $this->request->getPost("no_antrian");
        $id_pasien = $this->request->getPost("id_pasien");
        $catatan_diagnosa = $this->request->getPost("diagnosa");
        $resep_obat = $this->request->getPost("resep");
        
            $file1 = $_FILES["file1"];
        $file2 = $_FILES["file2"];
        $file3 = $_FILES["file3"];
        $file4 = $_FILES["file4"];
        $randomFileName1 = rand(1, 1000000);
        $randomFileName2 = rand(1, 1000000);
        $randomFileName3 = rand(1, 1000000);
        $randomFileName4 = rand(1, 1000000);
        
        $fileNameRand1 = $randomFileName1.".png";
        $fileNameRand2 = $randomFileName2.".png";
        $fileNameRand3 = $randomFileName3.".png";
        $fileNameRand4 = $randomFileName4.".png";
        
        move_uploaded_file($file1['tmp_name'], 'upload/'. $fileNameRand1);
        move_uploaded_file($file2['tmp_name'], 'upload/'. $fileNameRand2);
        move_uploaded_file($file3['tmp_name'], 'upload/'. $fileNameRand3);
        move_uploaded_file($file4['tmp_name'], 'upload/'. $fileNameRand4);
    
        $data1 = [
            'no_kunjungan' => $no_antrian,
            'id_pasien' => $id_pasien,
            'catatan_anamnesa' => $catatan_diagnosa,
            'catatan_obat' => $resep_obat,
            'img1' => $fileNameRand1,
            'img2' => $fileNameRand2,
            'img3' => $fileNameRand3,
            'img4' => $fileNameRand4,
            'user_id' => $this->UserInfo->id,
            'unit_id' => $this->UserInfo->unit_id,
            'created_at' => $now,
            'updated_at' => $now,
        ];

        $data2 = [
            'status' => 'Selesai Diagnosa',
            'eksekusi_sdm' => 'Dr.Eksks',
        ];
        
        $query1 = $this->db->table('diagnosa')->insert($data1);
        $query2 = $this->db->table('antrian_kunjungan')->where('no_antrian', $no_antrian)->update($data2);
        
        if($query1){
            $response = [
                'status' => 'success',
                'message' => 'Data Successfully Added',
            ];
        }else{
            $response = [
                'status' => 'error',
                'message' => 'Data Error',
            ];
        }
        return json_encode($response);
    }
}