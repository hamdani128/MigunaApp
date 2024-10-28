<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Database\Config;

class InfouserController extends BaseController
{
    private $db, $UserInfo;

    public function __construct()
    {
        $this->db = Config::connect();
        $this->UserInfo = $this->db->table('users')->where('id', session()->get('loggedUser'))->get()->getRowObject();
    }

    public function index()
    {
        $SQL1 = "SELECT
                a.id as id,
                a.fullname as fullname,
                a.username as username,
                a.email as email,
                a.level as level,
                b.unit as unit,
                a.created_at as created_at
                FROM users a
                LEFT JOIN unit b ON a.unit_id = b.id
                WHERE a.level NOT IN ('Super Admin', 'Admin')
                GROUP BY 1,2,3,4,5,6";
        $cabang = $this->db->table('unit')->select('id, unit')->get()->getResultObject();
        $datauser = $this->db->query($SQL1)->getResultObject();
        $data = [
            'title' => 'App Miguna - Infor Users',
            'userinfo' => $this->UserInfo,
            'cabang' => $cabang,
            'datauser' => $datauser,
        ];
        return view('pages/users/user', $data);
    }

    public function insert()
    {
        date_default_timezone_set('Asia/jakarta'); # add your city to set local time zone
        $now = date('Y-m-d H:i:s');
        $fullname = $this->request->getPost('fullname');
        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $confirm_password = $this->request->getPost('confirm_password');
        $unit_id = $this->request->getPost('unit_id');
        $level = $this->request->getPost('level');

        $data1 = [
            'fullname' => $fullname,
            'username' => $username,
            'email' => $email,
            'password' => md5($confirm_password),
            'level' => $level,
            'unit_id' => $unit_id,
            'created_at' => $now,
            'updated_at' => $now,
        ];

        $data2 = [
            'username' => $username,
            'password' => $confirm_password,
            'created_at' => $now,
        ];

        $query1 = $this->db->table('users')->insert($data1);
        $query2 = $this->db->table('users_password')->insert($data2);

        if ($query1 && $query2) {
            $response = [
                'status' => 'success',
                'message' => 'data successfully',
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'data not found',
            ];
        }
        return json_encode($response);
    }

    public function show_edit()
    {
        $id = $this->request->getPost('id');
        $sql = "SELECT
                a.id as id,
                a.fullname as fullname,
                a.username as username,
                a.email as email,
                a.level as level,
                b.unit as unit,
                c.password as password,
                a.unit_id as unit_id,
                a.created_at as created_at
                FROM users a
                LEFT JOIN unit b ON a.unit_id = b.id
                LEFT JOIN users_password c ON a.username = c.username
                WHERE a.level = 'Admin Cabang' AND a.id = '" . $id . "'
                GROUP BY 1,2,3,4,5,6,7,8,9";
        $query = $this->db->query($sql)->getRowObject();
        $data = [
            'fullname' => $query->fullname,
            'username' => $query->username,
            'email' => $query->email,
            'password' => $query->password,
            'unit_id' => $query->unit_id,
        ];
        return json_encode($data);
    }

    public function update()
    {
        date_default_timezone_set('Asia/jakarta'); # add your city to set local time zone
        $now = date('Y-m-d H:i:s');
        $id = $this->request->getPost('id');
        $fullname = $this->request->getPost('fullname');
        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $confirm_password = $this->request->getPost('confirm_password');
        $unit_id = $this->request->getPost('unit_id');

        $data1 = [
            'fullname' => $fullname,
            'username' => $username,
            'email' => $email,
            'password' => md5($confirm_password),
            'level' => 'Admin Cabang',
            'unit_id' => $unit_id,
            'created_at' => $now,
            'updated_at' => $now,
        ];

        $data2 = [
            'username' => $username,
            'password' => $confirm_password,
            'created_at' => $now,
        ];

        $query1 = $this->db->table('users')->where('id', $id)->update($data1);
        $query2 = $this->db->table('users_password')->insert($data2);

        if ($query1 && $query2) {
            $response = [
                'status' => 'success',
                'message' => 'data successfully',
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'data not found',
            ];
        }
        return json_encode($response);
    }

    public function delete()
    {
        $id = $this->request->getPost('id');
        $datauser = $this->db->table('users')->where('id', $id)->get()->getRowObject();
        $query1 = $this->db->table('users_password')->where("username", $datauser->username)->delete();
        $query2 = $this->db->table('users')->where('id', $id)->delete();
        if ($query1 && $query2) {
            $response = [
                'status' => 'success',
                'message' => 'data successfully',
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'data not found',
            ];
        }
        return json_encode($response);
    }

    public function show_password()
    {
        $id = $this->request->getPost('id');
        $datauser = $this->db->table('users')->where('id', $id)->get()->getRowObject();
        $sql = "SELECT
                a.id as id,
                a.username as username,
                a.password as password,
                b.password as hash,
                a.created_at as created_at
                FROM users_password a
                LEFT JOIN users b ON a.username = b.username
                WHERE a.username = '" . $datauser->username . "'
                GROUP BY 1,2,3,4,5";
        $uqery = $this->db->query($sql)->getResultObject();
        foreach ($uqery as $row) {
            $data[] = $row;
        }
        return json_encode($data);
    }
}
