<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Database\Config;

class SettingAdmin extends BaseController
{
    private $db, $UserInfo, $timenow;
    public function __construct()
    {
        date_default_timezone_set('Asia/jakarta');
        $this->db = Config::connect();
        $this->UserInfo = $this->db->table('users')->where('id', session()->get('loggedUser'))->get()->getRowObject();
        $this->timenow = date('Y-m-d H:i:s');
    }
    public function index()
    {
        if ($this->UserInfo->level == 'Admin Cabang') {
            // $data = [
            //     'title' => 'App Miguna - Settings Admin',
            //     'userinfo' => $this->UserInfo,
            // ];
            // return view('/pages/settings/settings_admin', $data);
            $getprt = printer_list(PRINTER_ENUM_LOCAL | PRINTER_ENUM_SHARED);
            $printers = serialize($getprt);
            $printers = unserialize($printers);
            //print_r($printers);
            echo '<select name="printers">';
            foreach ($printers as $PrintDest)
                echo "<option value=" . $PrintDest["NAME"] . ">" . explode(",", $PrintDest["DESCRIPTION"])[1] . "</option>";
            echo '</select>';
        } else {
        }
    }
}
