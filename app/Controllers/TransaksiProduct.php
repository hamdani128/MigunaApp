<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Database\Config;

class TransaksiProduct extends BaseController
{
    private $db, $UserInfo;
    public function __construct()
    {
        $this->db = Config::connect();
        $this->UserInfo = $this->db->table('users')->where('id', session()->get('loggedUser'))->get()->getRowObject();
    }

    public function TransaksiID($unit_id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $SQL = "SELECT MAX(RIGHT(no_transaksi, 4)) as kode FROM transaksi_produk WHERE unit_id ='" . $unit_id . "' AND date='"  . date('Y-m-d') . "'";
        $row = $this->db->query($SQL)->getRowObject();
        if ($row->kode !== "") {
            $kodeBarang = $row->kode;
            // mengambil angka dari kode barang terbesar, menggunakan fungsi substr dan diubah ke integer dengan (int)
            $urutan = (int)$kodeBarang;
            $urutan++;
            // nomor yang diambil akan ditambah 1 untuk menentukan nomor urut berikutnya
            $no = sprintf("%04s", $urutan);
            $huruf = "TRP-" . $unit_id . "-" . date('Ymd');
            $kodeBarang = $huruf . $no;
        } else {
            $kodeBarang = "TRP-" . $unit_id . "-" . date('Ymd') . "0001";
        }
        return $kodeBarang;
    }

    public function index()
    {
        date_default_timezone_set('Asia/jakarta');
        if ($this->UserInfo->level == 'Admin Cabang') {
            $list_product = $this->db->table("product")->where("unit_id", $this->UserInfo->unit_id)->orderBy("nama", "ASC")->get()->getResultObject();
            $TransaksiProduct = $this->db->table("transaksi_produk")->where("unit_id", $this->UserInfo->unit_id)->where("date", date('Y-m-d'))->get()->getResultObject();
            $data = [
                'title' => 'App Miguna - Transaksi Product',
                'userinfo' => $this->UserInfo,
                'kode_transaksi' => $this->TransaksiID($this->UserInfo->unit_id),
                'list_product' => $list_product,
                'transaksi' => $TransaksiProduct,
            ];
            return view('/pages/transaksi/transaksi_prod', $data);
        }
    }

    public function list_item()
    {
        $item = $this->request->getPost("item");
        $sql = "SELECT
                kode,
                nama,
                harga,
                satuan,
                qty,
                subtotal
                FROM product
                WHERE nama like '%" . $item . "%'
                GROUP BY 1,2,3,4,5";
        $value = $this->db->query($sql)->getRowObject();
        return json_encode($value);
        // var_dump($value);
    }

    public function pay_transaksi_detail()
    {
        date_default_timezone_set('Asia/Jakarta');
        $no_transaksi = $this->request->getPost("no_transaksi");
        $kode = $this->request->getPost("kode");
        $nama = $this->request->getPost("nama");
        $satuan = $this->request->getPost("satuan");
        $harga = $this->request->getPost("harga");
        $qty = $this->request->getPost("qty");
        $subtotal = $this->request->getPost("subtotal");
        $potongan = $this->request->getPost("potongan");
        $deskripsi = $this->request->getPost("desc");
        $user_id = $this->UserInfo->id;
        $unit_id = $this->UserInfo->unit_id;
        $date = date("Y-m-d");

        $data = [
            'no_transaksi' => $no_transaksi,
            'date' => $date,
            'kode' => $kode,
            'nama' => $nama,
            'satuan' => $satuan,
            'harga' => $harga,
            'qty' => $qty,
            'subtotal' => $subtotal,
            'potongan' => $potongan,
            'deskripsi' => $deskripsi,
            'user_id' => $user_id,
            'unit_id' => $unit_id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $this->db->table("transaksi_produk_detail")->insert($data);
    }

    public function getdata_pasien()
    {
        $unit_id = $this->UserInfo->unit_id;
        $query = $this->db->table('pasien')->where('unit_id', $unit_id)->get()->getResultObject();
        $no = 1;
        if (empty($query)) {
            $data = [
                'no' => '',
                'action' => '',
                'id_pasien' => '',
                'nik' => '',
                'nama' => '',
                'usia' => '',
                'alamat' => '',
                'jk' => '',
                'pekerjaan' => '',
                'hp' => '',
                'registri' => '',
                'created_at' => '',
            ];
            $response = $data;
        } else {
            foreach ($query as $row) {
                $data = [
                    'no' => $no,
                    'action' => "<div class='button-group'><button class='btn btn-md btn-dark' onclick='pilih_konsumen()'><i class='fas fa-user-friends'></i></button></div>",
                    'id_pasien' => $row->id_pasien,
                    'nik' => $row->nik,
                    'nama' => $row->nama,
                    'usia' => $row->usia,
                    'alamat' => $row->alamat,
                    'jk' => $row->jk,
                    'pekerjaan' => $row->pekerjaan,
                    'hp' => $row->hp,
                    'registri' => $row->registri,
                    'created_at' => $row->created_at,
                ];
                $response[] = $data;
                $no++;
            }
        }
        return json_encode($response);
    }



    public function pay_debit()
    {
        date_default_timezone_set("Asia/jakarta");
        $date = date('Y-m-d H:i:s');
        $no_transaksi = $this->request->getPost("no_transaksi");
        $metode_bayar = $this->request->getPost("metode_bayar");
        $qty = $this->request->getPost("qty");
        $potongan = $this->request->getPost('potongan');
        $subtotal = $this->request->getPost('subtotal');
        $deskripsi = $this->request->getPost('deskripsi');
        $kategori_konsumen = $this->request->getPost('konsumen');
        $pasien_id = $this->request->getPost('pasien_id');
        $nama = $this->request->getPost("nama");
        $hp = $this->request->getPost("hp");
        $alamat = $this->request->getPost("alamat");
        $nik = $this->request->getPost("nik");
        $img = $this->request->getFile("img");
        $jumlah_dibayar = $this->request->getPost('jumlah_dibayar');
        $kembalian = $this->request->getPost('kembalian');
        $transaksi_debit = $this->request->getPost('no_transaksi_debit');
        $fileName = $img->getRandomName();
        $img->move('upload', $fileName);
        $user_id = $this->UserInfo->id;
        $unit_id = $this->UserInfo->unit_id;
        $data = [
            'no_transaksi' => $no_transaksi,
            'date' => $date,
            'metode_bayar' => $metode_bayar,
            'file' => $fileName,
            'no_transaksi_debit' => $transaksi_debit,
            'qty' => $qty,
            'subtotal' => $subtotal,
            'potongan' => $potongan,
            'dibayar' => $jumlah_dibayar,
            'kembalian' => $kembalian,
            'deskripsi' => $deskripsi,
            'kategori' => $kategori_konsumen,
            'pasien_id' => $pasien_id,
            'nama' => $nama,
            'hp' => $hp,
            'alamat' => $alamat,
            'nik' => $nik,
            'user_id' => $user_id,
            'unit_id' => $unit_id,
            'created_at' => $date,
            'updated_at' => $date,
        ];
        $query = $this->db->table("transaksi_produk")->insert($data);
        if ($query) {
            $response = [
                'status' => 'success',
                'message' => "success",
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => "error",
            ];
        }
        return json_encode($response);
    }

    public function pay_cash()
    {
        date_default_timezone_set("Asia/jakarta");
        $date = date('Y-m-d H:i:s');
        $no_transaksi = $this->request->getPost("no_transaksi");
        $metode_bayar = $this->request->getPost("metode_bayar");
        $qty = $this->request->getPost("qty");
        $potongan = $this->request->getPost('potongan');
        $subtotal = $this->request->getPost('subtotal');
        $deskripsi = $this->request->getPost('deskripsi');
        $kategori_konsumen = $this->request->getPost('konsumen');
        $pasien_id = $this->request->getPost('pasien_id');
        $nama = $this->request->getPost("nama");
        $hp = $this->request->getPost("hp");
        $alamat = $this->request->getPost("alamat");
        $nik = $this->request->getPost("nik");
        // $img = $this->request->getFile("img");
        $jumlah_dibayar = $this->request->getPost('jumlah_dibayar');
        $kembalian = $this->request->getPost('kembalian');
        $transaksi_debit = $this->request->getPost('no_transaksi_debit');
        $fileName = "";
        // $img->move('upload', $fileName);
        $user_id = $this->UserInfo->id;
        $unit_id = $this->UserInfo->unit_id;
        $data = [
            'no_transaksi' => $no_transaksi,
            'date' => $date,
            'metode_bayar' => $metode_bayar,
            'file' => $fileName,
            'no_transaksi_debit' => $transaksi_debit,
            'qty' => $qty,
            'subtotal' => $subtotal,
            'potongan' => $potongan,
            'dibayar' => $jumlah_dibayar,
            'kembalian' => $kembalian,
            'deskripsi' => $deskripsi,
            'kategori' => $kategori_konsumen,
            'pasien_id' => $pasien_id,
            'nama' => $nama,
            'hp' => $hp,
            'alamat' => $alamat,
            'nik' => $nik,
            'user_id' => $user_id,
            'unit_id' => $unit_id,
            'created_at' => $date,
            'updated_at' => $date,
        ];
        $query = $this->db->table("transaksi_produk")->insert($data);
        if ($query) {
            $response = [
                'status' => 'success',
                'message' => "success",
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => "error",
            ];
        }
        return json_encode($response);
    }

    public function list_transaksi()
    {
        $no_transaksi = $this->request->getPost('no_transaksi');
        $data_transaksi = $this->db->table('transaksi_produk')->where('no_transaksi', $no_transaksi)->get()->getRowObject();
        $detail_transaksi = $this->db->table('transaksi_produk_detail')->where('no_transaksi', $no_transaksi)->get()->getResultObject();
        foreach ($detail_transaksi as $row) {
            $prod[] = $row;
        }
        $data = [
            'date' => $data_transaksi->date,
            'kategori_konsumen' => $data_transaksi->kategori,
            'id_pasien' => $data_transaksi->pasien_id,
            'nama'  => $data_transaksi->nama,
            'nik' => $data_transaksi->nik,
            'hp' => $data_transaksi->hp,
            'alamat' => $data_transaksi->alamat,
            'metode_bayar' => $data_transaksi->metode_bayar,
            'jumlah_dibayar' => $data_transaksi->dibayar,
            'kembalian' => $data_transaksi->kembalian,
            'qty' => $data_transaksi->qty,
            'subtotal' => $data_transaksi->subtotal,
            'product' => $prod,
        ];
        return json_encode($data);
    }

    public function delete()
    {
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');
        $no_transaksi = $this->request->getPost("no_transaksi");
        $query1 = $this->db->table('transaksi_produk')->where('no_transaksi', $no_transaksi)->delete();
        $query2 = $this->db->table('transaksi_produk_detail')->where('no_transaksi', $no_transaksi)->delete();
        if ($query1 && $query2) {
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
}