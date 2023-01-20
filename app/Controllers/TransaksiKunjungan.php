<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Database\Config;
use PHPUnit\Util\Json;

class TransaksiKunjungan extends BaseController
{
    private $db, $UserInfo;
    public function __construct()
    {
        $this->db = Config::connect();
        $this->UserInfo = $this->db->table('users')->where('id', session()->get('loggedUser'))->get()->getRowObject();
    }

    public function index()
    {
        date_default_timezone_set('Asia/Jakarta');
        if ($this->UserInfo->level == 'Dokter' || $this->UserInfo->level == 'Admin' || $this->UserInfo->level == 'Super Admin') {
            $sdm = $this->db->table('sdm')->get()->getResultObject();
            $kunjungan = $this->db->table('antrian_kunjungan')->where('tanggal', date('Y-m-d'))->where('unit_id', $this->UserInfo->unit_id)->countAllResults();
            $selesai_diagnosa = $this->db->table('antrian_kunjungan')->where('status', 'antrian')->where('tanggal', date('Y-m-d'))->where('unit_id', $this->UserInfo->unit_id)->countAllResults();
            $transaksi = $this->db->table('antrian_kunjungan')->where('status', 'Transaksi Selesai')->where('tanggal', date('Y-m-d'))->where('unit_id', $this->UserInfo->unit_id)->countAllResults();
            $data = [
                'title' => 'App Miguna - Kunjungan Pasien',
                'userinfo' => $this->UserInfo,
                'sdm' => $sdm,
                'total_kunjungan' => $kunjungan,
                'total_diagnosa' => $selesai_diagnosa,
                'total_transaksi' => $transaksi,
            ];
            return view('/pages/transaksi/transaksi_kunjungan', $data);
        } else {
        }
    }

    public function getdata()
    {
        if ($this->UserInfo->level == 'Admin Cabang' || $this->UserInfo->level == 'Dokter') {
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
                        WHERE a.unit_id=" . $unit_id . " AND a.tanggal='" . $now . "'";
            $query = $this->db->query($SQL)->getResultObject();
            $no = 1;
            if (count($query) > 0) {
                foreach ($query as $row) {
                    if ($row->status == 'antrian') {
                        $status = "<h5 class='badge badge-boxed  badge-soft-warning'>" . $row->status . "</h5>";
                    } else {
                        $status = "<h5 class='badge badge-boxed  badge-soft-primary'>" . $row->status . "</h5>";
                    }
                    $data = [
                        'no' => $no,
                        'action' => "<div class='button-group'><button class='btn btn-md btn-danger' onclick='delete_transaksi_kunjungan()'><i class='fa fa-trash'></i></button><button class='btn btn-md btn-dark' onclick='diagnosa_pasien_dokter()'><i class='fas fa-user-edit'></i></button><button class='btn btn-md btn-success' onclick='riwayat_transaksi_kunjungan()'><i class='fas fa-id-card'></i></button></div>",
                        'no_antrian' => $row->no_antrian,
                        'id_pasien' => $row->id_pasien,
                        'nama' => $row->nama,
                        'catatan_kunjungan' => $row->catatan_kunjungan,
                        'status' => $status,
                        'tanggal' => $row->tanggal,
                        'created_at' => $row->created_at,
                        'status_asli' => $row->status,
                    ];
                    $no++;
                    $response[] = $data;
                }
            } else {
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
                    'status_asli' => '',
                ];
                $no++;
                $response[] = $data;
            }
        } else {
        }
        return json_encode($response);
    }

    public function add_diagnosa()
    {
        date_default_timezone_set("Asia/Jakarta");
        $now = date('Y-m-d H:i:s');
        $no_antrian = $this->request->getPost("no_antrian");
        $id_pasien = $this->request->getPost("id_pasien");
        $catatan_diagnosa = $this->request->getPost("diagnosa");
        $resep_obat = $this->request->getPost("resep");
        $id_sdm = $this->request->getPost("id_sdm");
        $sdm = $this->request->getPost("sdm");

        $file1 = $_FILES["file1"];
        $file2 = $_FILES["file2"];
        $file3 = $_FILES["file3"];
        $file4 = $_FILES["file4"];
        $randomFileName1 = rand(1, 1000000);
        $randomFileName2 = rand(1, 1000000);
        $randomFileName3 = rand(1, 1000000);
        $randomFileName4 = rand(1, 1000000);

        $fileNameRand1 = $randomFileName1 . ".png";
        $fileNameRand2 = $randomFileName2 . ".png";
        $fileNameRand3 = $randomFileName3 . ".png";
        $fileNameRand4 = $randomFileName4 . ".png";

        move_uploaded_file($file1['tmp_name'], 'upload/' . $fileNameRand1);
        move_uploaded_file($file2['tmp_name'], 'upload/' . $fileNameRand2);
        move_uploaded_file($file3['tmp_name'], 'upload/' . $fileNameRand3);
        move_uploaded_file($file4['tmp_name'], 'upload/' . $fileNameRand4);

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
            'eksekusi_sdm' => $sdm,
            'id_sdm' => $id_sdm,
        ];

        $query1 = $this->db->table('diagnosa')->insert($data1);
        $query2 = $this->db->table('antrian_kunjungan')->where('no_antrian', $no_antrian)->update($data2);

        if ($query1) {
            $response = [
                'status' => 'success',
                'message' => 'Data Successfully Added',
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Data Error',
            ];
        }
        return json_encode($response);
    }

    public function riwayat_tanggal($id_pasien)
    {
        $query1 = $this->db->table("transaksi_treatment")->select("tanggal")->where("pasien_id", $id_pasien)->get()->getResultObject();
        $no = 1;
        if (count($query1) > 0) {
            foreach ($query1 as $row) {
                $data = [
                    'no' => $no++,
                    'action' => "<div class='button-group'><button class='btn btn-md btn-dark' onclick='check_riwayat_tanggal()'><i class='fas fa-check-circle'></i></button></div>",
                    'tanggal' => $row->tanggal,
                    'id_pasien' => $id_pasien,
                ];
                $response[] = $data;
            }
            return json_encode($response);
        } else {
            $data = [
                'no' => "",
                'action' => "",
                'tanggal' => "",
                'id_pasien' => "",
            ];
            $response[] = $data;
            return json_encode($response);
        }
    }

    public function list_detail_riwayat()
    {
        $tanggal = $this->request->getPost("tanggal");
        $id_pasien = $this->request->getPost("id_pasien");
        $diagnosa = $this->db->table("diagnosa")->where("DATE(created_at)", $tanggal)->where("id_pasien", $id_pasien)->get()->getRowObject();
        $treatment = $this->db->table("transaksi_treatment_detail")->where("DATE(created_at)", $tanggal)->where("pasien_id", $id_pasien)->get()->getResultObject();
        $product = $this->db->table("transaksi_treatment_detail_prod")->where("DATE(created_at)", $tanggal)->where("pasien_id", $id_pasien)->get()->getResultObject();

        foreach ($treatment as $row) {
            $datatreat = [
                'kode' => $row->kode,
                'treatment' => $row->treatment,
                'harga' => str_replace(",", ".", number_format($row->harga, 0)),
                'qty' => str_replace(",", ".", number_format($row->qty, 0)),
                'subtotal' => str_replace(",", ".", number_format($row->subtotal, 0)),
                'potongan' => str_replace(",", ".", number_format($row->potongan, 0)),
            ];
            $treat[] = $datatreat;
        }
        foreach ($product as $row) {
            $dataprod = [
                'kode' => $row->kode,
                'nama' => $row->nama,
                'satuan' => $row->satuan,
                'harga' => str_replace(",", ".", number_format($row->harga, 0)),
                'qty' => str_replace(",", ".", number_format($row->qty, 0)),
                'subtotal' => str_replace(",", ".", number_format($row->subtotal, 0)),
                'potongan' => str_replace(",", ".", number_format($row->potongan, 0)),
            ];
            $prod[] = $dataprod;
        }
        $data = [
            'catatan_anamnesa' => $diagnosa->catatan_anamnesa,
            'catatan_obat' => $diagnosa->catatan_obat,
            'img1' => $diagnosa->img1,
            'img2' => $diagnosa->img2,
            'img3' => $diagnosa->img3,
            'img4' => $diagnosa->img4,
            'treatment_detail' => $treat,
            'product_detail' => $prod,
        ];
        return json_encode($data);
    }
}