<?php

namespace App\Controllers;

use CodeIgniter\Database\Config;

class Home extends BaseController
{
    private $db, $UserInfo;
    public function __construct()
    {
        $this->db = Config::connect();
        $this->UserInfo = $this->db->table('users')->where('id', session()->get('loggedUser'))->get()->getRowObject();
    }

    public function index()
    {
        if ($this->UserInfo->level == "Admin") {
            $data = [
                'title' => 'App Miguna - Home',
                'userinfo' => $this->UserInfo,
            ];
            return view('pages/home/home_admin', $data);
        } elseif ($this->UserInfo->level == "Dokter") {
            $profile = $this->db->table("profile")->get()->getFirstRow();
            $data = [
                'title' => 'App Miguna - Home',
                'userinfo' => $this->UserInfo,
                'profile' => $profile,
            ];
            return view('pages/home/home_dokter', $data);
        } elseif ($this->UserInfo->level == "Admin Cabang") {
            $profile = $this->db->table("profile")->get()->getFirstRow();
            $data = [
                'title' => 'App Miguna - Home',
                'userinfo' => $this->UserInfo,
                'profile' => $profile,
            ];
            return view('pages/home/home_admin_cabang', $data);
        }
    }
}