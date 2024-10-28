<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Database\Config;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class ProductController extends BaseController
{
    private $db, $UserInfo;
    public function __construct()
    {
        $this->db = Config::connect();
        $this->UserInfo = $this->db->table('users')->where('id', session()->get('loggedUser'))->get()->getRowObject();
    }

    public function GetIDProductCabang($unit_id)
    {
        date_default_timezone_set('Asia/jakarta'); # add your city to set local time zone
        $now = date('Y-m-d H:i:s');
        $sql = "SELECT MAX(RIGHT(kode,4)) as KD_MAX FROM product WHERE unit_id='" . $unit_id . "'";
        $query = $this->db->query($sql);
        if ($query->getNumRows() > 0) {
            $row = $query->getRow();
            $n = ((int) $row->KD_MAX) + 1;
            $no = sprintf("%04s", $n);
        } else {
            $no = "#PR" . $unit_id . "-" . "0001";
        }
        $kode = "#PR" . $unit_id . "-" . $no;
        return $kode;
    }

    public function index()
    {
        if ($this->UserInfo->level == 'Admin Cabang') {
            $data = [
                'title' => 'App Miguna - Info Product',
                'kodeproduct' => $this->GetIDProductCabang($this->UserInfo->unit_id),
                'userinfo' => $this->UserInfo,
                'supplier' => $this->db->table('supplier')->where('unit_id', $this->UserInfo->unit_id)->get()->getResultObject(),
            ];
            return view('/pages/product/product', $data);
        } else {
        }
    }

    public function product_getdata()
    {
        $unit_id = $this->UserInfo->unit_id;
        $SQL = "SELECT
                a.kode as kode,
                a.nama as nama,
                a.satuan as satuan,
                a.harga as harga,
                a.qty as qty,
                a.subtotal as subtotal,
                b.supplier as supplier,
                a.kategori as kategori
                FROM product a
                LEFT JOIN supplier b ON a.id_supplier = b.id
                WHERE a.unit_id = '" . $unit_id . "'";
        $query = $this->db->query($SQL)->getResultObject();
        $no = 1;
        if (count($query) > 0) {
            foreach ($query as $row) {
                $data = [
                    'no' => $no,
                    'action' => "<div class='button-group'><button class='btn btn-md btn-info' onclick='edit_admin_product()'><i class='fa fa-edit'></i></button><button class='btn btn-md btn-danger' onclick='delete_admin_product()'><i class='fa fa-trash'></i></button></div>",
                    'kode' => $row->kode,
                    'nama' => $row->nama,
                    'satuan' => $row->satuan,
                    'harga' => $row->harga,
                    'qty' => $row->qty,
                    'subtotal' => $row->subtotal,
                    'supplier' => $row->supplier,
                    'kategori' => $row->kategori,
                ];
                $no++;
                $response[] = $data;
            }
            return json_encode($response);
        } else {
            $data = [
                'no' => '',
                'action' => '',
                'kode' => '',
                'nama' => '',
                'satuan' => '',
                'harga' => '',
                'qty' => '',
                'subtotal' => '',
                'supplier' => '',
                'kategori' => '',
            ];
            return json_encode($data);
        }
    }

    public function product_insert()
    {
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');
        $kode = $this->request->getPost('kode');
        $nama = $this->request->getPost('nama');
        $satuan = $this->request->getPost('satuan');
        $harga = $this->request->getPost('harga');
        $qty = $this->request->getPost('qty');
        $subtotal = $this->request->getPost('subtotal');
        $supplier_value = $this->request->getPost('supplier_value');
        $unit_id = $this->UserInfo->unit_id;
        $user_id = $this->UserInfo->id;

        $data = [
            'kode' => $kode,
            'nama' => $nama,
            'satuan' => $satuan,
            'harga' => $harga,
            'qty' => $qty,
            'subtotal' => $subtotal,
            'id_supplier' => $supplier_value,
            'unit_id' => $unit_id,
            'user_id' => $user_id,
            'created_at' => $now,
            'updated_at' => $now,
        ];
        $query = $this->db->table('product')->insert($data);

        if ($query) {
            $response = [
                'status' => 'success',
                'message' => 'Successfully !',
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Error',
            ];
        }
        return json_encode($response);
    }

    public function product_edit_show()
    {
        $kode = $this->request->getPost('kode');
        $query = $this->db->table('product')->where('kode', $kode)->get()->getRowObject();
        $data = [
            'id' => $query->id,
            'kode' => $query->kode,
            'nama' => $query->nama,
            'satuan' => $query->satuan,
            'harga' => $query->harga,
            'qty' => $query->qty,
            'subtotal' => $query->subtotal,
            'id_supplier' => $query->id_supplier,
        ];
        return json_encode($data);
    }

    public function product_update()
    {
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');
        $id = $this->request->getPost('id');
        $kode = $this->request->getPost('kode');
        $nama = $this->request->getPost('nama');
        $satuan = $this->request->getPost('satuan');
        $harga = $this->request->getPost('harga');
        $qty = $this->request->getPost('qty');
        $subtotal = $this->request->getPost('subtotal');
        $supplier_value = $this->request->getPost('supplier_value');
        $unit_id = $this->UserInfo->unit_id;
        $user_id = $this->UserInfo->id;

        $data = [
            'kode' => $kode,
            'nama' => $nama,
            'satuan' => $satuan,
            'harga' => $harga,
            'qty' => $qty,
            'subtotal' => $subtotal,
            'id_supplier' => $supplier_value,
            'unit_id' => $unit_id,
            'user_id' => $user_id,
            'updated_at' => $now,
        ];
        $query = $this->db->table('product')->where('id', $id)->update($data);
        if ($query) {
            $response = [
                'status' => 'success',
                'message' => 'Successfully !',
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Error',
            ];
        }
        return json_encode($response);
    }

    public function product_delete()
    {
        $kode = $this->request->getPost('kode');
        $query = $this->db->table('product')->where('kode', $kode)->delete();
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

    public function supplier_add()
    {
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');
        $nama_supplier = $this->request->getPost('nama_supplier');
        $alamat_supplier = $this->request->getPost('alamat_supplier');
        $no_telepon = $this->request->getPost('no_telepon');
        $email_supplier = $this->request->getPost('email_supplier');
        $unit_id = $this->UserInfo->unit_id;
        $user_id = $this->UserInfo->id;
        $data = [
            'supplier' => $nama_supplier,
            'alamat' => $alamat_supplier,
            'hp' => $no_telepon,
            'email' => $email_supplier,
            'unit_id' => $unit_id,
            'user_id' => $user_id,
            'created_at' => $now,
            'updated_at' => $now,
        ];

        $query = $this->db->table('supplier')->insert($data);
        if ($query) {
            $response = [
                'status' => 'success',
                'message' => 'successfully created',
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'error creating',
            ];
        }
        return json_encode($response);
    }

    public function supplier_getdata()
    {
        $query = $this->db->table('supplier')->where('unit_id', $this->UserInfo->unit_id)->get()->getResultObject();
        $no = 1;
        if (count($query) > 0) {
            foreach ($query as $row) {
                $data = [
                    "no" => $no,
                    "action" => "<div class='button-group'><button class='btn btn-md btn-info' onclick='edit_admin_supplier()'><i class='fa fa-edit'></i></button><button class='btn btn-md btn-danger' onclick='delete_admin_supplier()'><i class='fa fa-trash'></i></button></div>",
                    "supplier" => $row->supplier,
                    "alamat" => $row->alamat,
                    "hp" => $row->hp,
                    "created_at" => $row->created_at,
                ];
                $no++;
                $response[] = $data;
            }
            return json_encode($response);
        } else {
            $data = [
                "no" => '',
                "action" => '',
                "supplier" => '',
                "alamat" => '',
                "hp" => '',
                "created_at" => '',
            ];
            return json_encode($data);
        }
    }

    public function supplier_edit_show()
    {
        $supplier = $this->request->getPost('supplier');
        $query = $this->db->table('supplier')->where('supplier', $supplier)->get()->getRowObject();
        $data = [
            'id' => $query->id,
            'supplier' => $supplier,
            'alamat' => $query->alamat,
            'hp' => $query->hp,
            'email' => $query->email,
        ];
        return json_encode($data);
    }

    public function supplier_update_data()
    {
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');
        $nama_supplier = $this->request->getPost('nama_supplier');
        $alamat_supplier = $this->request->getPost('alamat_supplier');
        $no_telepon = $this->request->getPost('no_telepon');
        $email_supplier = $this->request->getPost('email_supplier');
        $unit_id = $this->UserInfo->unit_id;
        $user_id = $this->UserInfo->id;
        $id = $this->request->getPost('id');

        $data = [
            'supplier' => $nama_supplier,
            'alamat' => $alamat_supplier,
            'hp' => $no_telepon,
            'email' => $email_supplier,
            'user_id' => $user_id,
            'updated_at' => $now,
        ];

        $query = $this->db->table('supplier')->where('id', $id)->update($data);
        if ($query) {
            $response = [
                'status' => 'success',
                'message' => 'successfully Updated !',
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'error Updated',
            ];
        }
        return json_encode($response);
    }

    public function supplier_delete()
    {
        $supplier = $this->request->getPost('supplier');
        $datasupp = $this->db->table('supplier')->where('supplier', $supplier)->get()->getRowObject();
        $id = $datasupp->id;
        $query = $this->db->table('supplier')->where('id', $id)->delete();
        if ($query) {
            $response = [
                'status' => 'success',
                'message' => 'successfully Deleted !',
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'error Deleted !',
            ];
        }
        return json_encode($response);
    }

    public function product_download()
    {
        return $this->response->download('source/product.xlsx', null);
    }

    public function import_data_product()
    {
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');
        $user_id = $this->UserInfo->id;
        $unit_id = $this->UserInfo->unit_id;
        $berkas = $this->request->getFile("file_product");
        $ext = $berkas->getClientExtension();
        if ($ext == 'xls') {
            $render = new Xls();
        } else {
            $render = new Xlsx();
        }
        $preadsheet = $render->load($berkas);
        $data = $preadsheet->getActiveSheet()->toArray();
        foreach ($data as $x => $row) {
            if ($x == 0) {
                continue;
            }
            $data = [
                'kode' => $row[0],
                'nama' => $row[1],
                'satuan' => $row[2],
                'harga' => $row[3],
                'qty' => $row[4],
                'subtotal' => $row[5],
                'kategori' => $row[6],
                'id_supplier' => 0,
                'unit_id' => $unit_id,
                'user_id' => $user_id,
                'created_at' => $now,
                'updated_at' => $now,
            ];
            $query1 = $this->db->table("product")->insert($data);
        }
        if ($query1) {
            $response = [
                'status' => 'success',
                'message' => 'success',
            ];
        } else {
            $response = [
                'status' => 'failed',
                'message' => 'failed',
            ];
        }
        return json_encode($response);
    }

    public function download_format_supplier()
    {
        return $this->response->download('source/supplier.xlsx', null);
    }

    public function import_data_supplier()
    {
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');
        $user_id = $this->UserInfo->id;
        $unit_id = $this->UserInfo->unit_id;
        $berkas = $this->request->getFile("file_supplier");
        $ext = $berkas->getClientExtension();
        if ($ext == 'xls') {
            $render = new Xls();
        } else {
            $render = new Xlsx();
        }
        $preadsheet = $render->load($berkas);
        $data = $preadsheet->getActiveSheet()->toArray();
        foreach ($data as $x => $row) {
            if ($x == 0) {
                continue;
            }
            $data = [
                'supplier' => $row[0],
                'alamat' => $row[1],
                'hp' => $row[2],
                'email' => $row[3],
                'unit_id' => $unit_id,
                'user_id' => $user_id,
                'created_at' => $now,
                'updated_at' => $now,
            ];
            $query1 = $this->db->table("supplier")->insert($data);
        }
        if ($query1) {
            $response = [
                'status' => 'success',
                'message' => 'success',
            ];
        } else {
            $response = [
                'status' => 'failed',
                'message' => 'failed',
            ];
        }
        return json_encode($response);
    }
}
