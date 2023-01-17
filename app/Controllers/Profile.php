<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Database\Config;
use PHPUnit\Util\Json;

class Profile extends BaseController
{
    private $db, $UserInfo;
    public function __construct()
    {
        $this->db = Config::connect();
        $this->UserInfo = $this->db->table('users')->where('id', session()->get('loggedUser'))->get()->getRowObject();
    }
    public function index()
    {
        $data = [
            'title' => 'App Miguna - Profile',
            'userinfo' => $this->UserInfo,
        ];
        return view('pages/profile/profile', $data);
    }

    public function check()
    {
        $query = $this->db->table('profile')->where('unit_id', $this->UserInfo->unit_id)->get()->getRowObject();
        if (empty($query)) {
            $data = [
                'nama' => '',
                'alamat' => '',
                'no_hp' => '',
                'file' => '',
            ];
        } else {
            $data = [
                'nama' => $query->nama,
                'alamat' => $query->alamat,
                'no_hp' => $query->no_hp,
                'file' => $query->file,
            ];
        }
        return json_encode($data);
    }

    public function insert_profile()
    {
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');
        $nama = $this->request->getPost("nama");
        $alamat = $this->request->getPost("alamat");
        $no_hp = $this->request->getPost("no_hp");
        $data = [
            'nama' => $nama,
            'alamat' => $alamat,
            'no_hp' => $no_hp,
            'file' => '',
            'unit_id' => $this->UserInfo->unit_id,
            'created_at' => $now,
        ];

        $query = $this->db->table('profile')->insert($data);
        if ($query) {
            $response = [
                'status' => 'success',
                'message' => 'success',
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'error',
            ];
        }
        return json_encode($response);
    }

    public function change_photo()
    {

        date_default_timezone_set('Asia/jakarta');
        $value = $this->db->table("profile")->where('unit_id', $this->UserInfo->unit_id)->get()->getRowObject();
        $id = $value->id;
        $img = $this->request->getFile('img');
        $fileRandome = $img->getRandomName();
        $img->move('upload', $fileRandome);
        $data = [
            'file' => $fileRandome,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $query = $this->db->table('profile')->where('id', $id)->update($data);
        if ($query) {
            $response = [
                'status' => 'success',
                'message' => 'success',
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'error'
            ];
        }
        return json_encode($response);
    }
}