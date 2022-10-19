<?php

namespace App\Controllers;

use CodeIgniter\Database\Config;

class Home extends BaseController
{
    private $db,$UserInfo;
    public function __construct()
    {
        $this->db = Config::connect();
        $this->UserInfo = $this->db->table('users')->where('id', session()->get('loggedUser'))->get()->getRowObject();
    }

    public function index()
    {
        $data = [
            'title' => 'App Miguna - Home',
            'userinfo' => $this->UserInfo,
        ];
        return view('pages/index', $data);
    }
}