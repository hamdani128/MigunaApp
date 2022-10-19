<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Database\Config;
use CodeIgniter\Database\Database;

class AuthController extends BaseController
{
    private $db;
    public function __construct(){
        $this->db = Config::connect();
    }

    public function index()
    {
        return view('/auth/login');
    }

    function login_check()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $UserInfo = $this->db->table('users')->where('username', $username)->get()->getRowObject();
        $hashmd5 = md5($password);
        if(empty($UserInfo->username)){
            $response = [
                'status' => 'username not found',
                'message' => 'Username Anda Tidak Terdaftar !',
            ];
            return json_encode($response);
        }else{
            if($UserInfo->password == $hashmd5){
                $user_id = $UserInfo->id;
                session()->set('loggedUser', $user_id);
                $response = [
                    'status' => 'success',
                    'message' => 'Anda Berhasil Login !',
                ];
                return json_encode($response);
            }else{
                $response = [
                    'status' => 'Password Error',
                    'message' => 'Password Anda Salah !',
                ];
                return json_encode($response);
            }
        }
    }

    public function logout()
    {
        helper(['url', 'form']);
        if (session()->has('loggedUser')) {
            session()->remove('loggedUser');
            return redirect()->to('/auth/login')->with('logout', 'You Are logged Out');
        }

    }

}