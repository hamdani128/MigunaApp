<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Database\Config;

class RiwayatController extends BaseController
{

    private $db, $UserInfo;
    public function __construct()
    {
        $this->db = Config::connect();
        $this->UserInfo = $this->db->table('users')->where('id', session()->get('loggedUser'))->get()->getRowObject();
    }

    public function index()
    {
        if ($this->UserInfo->level == 'Admin Cabang') {
            $datakunjungan = $this->db->table('antrian_kunjungan')->where('unit_id', $this->UserInfo->unit_id)->where('tanggal', date('Y-m-d'))->get()->getResultObject();
            $data = [
                'title' => 'App Miguna - Kunjungan Pasien',
                'datakunjungan' => $datakunjungan,
                'userinfo' => $this->UserInfo,
            ];
            return view('pages/kunjungan/kunjungan', $data);
        }
    }

    public function admin_getdata()
    {
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
                WHERE a.unit_id='" . $unit_id . "' ORDER BY a.tanggal DESC";
        $query = $this->db->query($SQL)->getResultObject();
        $no = 1;
        if (!empty($query)) {
            foreach ($query as $row) {
                if ($row->status == 'antrian') {
                    $status = "<h5 class='badge badge-boxed  badge-soft-warning'>" . $row->status . "</h5>";
                } else {
                    $status = "<h5 class='badge badge-boxed  badge-soft-info'>" . $row->status . "</h5>";
                }
                $data = [
                    'no' => $no,
                    'action' => "<div class='button-group'><button class='btn btn-md btn-success'><i class='fas fa-id-card'></i></button></div>",
                    'tanggal' => $row->tanggal,
                    'no_antrian' => $row->no_antrian,
                    'id_pasien' => $row->id_pasien,
                    'nama' => $row->nama,
                    'catatan_kunjungan' => $row->catatan_kunjungan,
                    'status' => $status,
                    'created_at' => $row->created_at,
                ];
                $response[] = $data;
                $no++;
            }
            return json_encode($response);
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
            ];
            $no++;
            return json_encode($data);
        }
    }

    public function admin_delete()
    {
        $no_antrian = $this->request->getPost('no_antrian');
        // $tanggal = $this->request->getPost('tanggal');
        $query = $this->db->table('antrian_kunjungan')->where('no_antrian', $no_antrian)->delete();
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

    public function filter_getdata($mulai, $sampai)
    {

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
                WHERE a.unit_id='" . $unit_id . "' AND a.tanggal BETWEEN '" . $mulai . "' AND '" . $sampai . "' 
                ORDER BY a.tanggal DESC";
        $query = $this->db->query($SQL)->getResultObject();
        $no = 1;
        if (!empty($query)) {
            foreach ($query as $row) {
                if ($row->status == 'antrian') {
                    $status = "<h5 class='badge badge-boxed  badge-soft-warning'>" . $row->status . "</h5>";
                } else {
                    $status = "<h5 class='badge badge-boxed  badge-soft-info'>" . $row->status . "</h5>";
                }
                $data = [
                    'no' => $no,
                    'action' => "<div class='button-group'><button class='btn btn-md btn-success'><i class='fas fa-id-card'></i></button></div>",
                    'tanggal' => $row->tanggal,
                    'no_antrian' => $row->no_antrian,
                    'id_pasien' => $row->id_pasien,
                    'nama' => $row->nama,
                    'catatan_kunjungan' => $row->catatan_kunjungan,
                    'status' => $status,
                    'created_at' => $row->created_at,
                ];
                $response[] = $data;
                $no++;
            }
            return json_encode($response);
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
            ];
            $no++;
            return json_encode($data);
        }
    }
}