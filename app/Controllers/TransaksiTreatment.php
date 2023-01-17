<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Database\Config;
use CodeIgniter\Entity\Cast\JsonCast;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class TransaksiTreatment extends BaseController
{

    private $db, $UserInfo;
    public function __construct()
    {
        $this->db = Config::connect();
        $this->UserInfo = $this->db->table('users')->where('id', session()->get('loggedUser'))->get()->getRowObject();
    }

    public function getIDTransaksi($id_unit)
    {
        date_default_timezone_set('Asia/Jakarta');
        $SQL = "SELECT MAX(RIGHT(transaksi_id, 4)) as kode FROM transaksi_treatment WHERE unit_id ='" . $id_unit . "' AND tanggal='"  . date('Y-m-d') . "'";
        $row = $this->db->query($SQL)->getRowObject();
        if ($row->kode !== "") {
            $kodeBarang = $row->kode;
            // mengambil angka dari kode barang terbesar, menggunakan fungsi substr dan diubah ke integer dengan (int)
            $urutan = (int)$kodeBarang;
            $urutan++;
            // nomor yang diambil akan ditambah 1 untuk menentukan nomor urut berikutnya
            $no = sprintf("%04s", $urutan);
            $huruf = "TRID-" . $id_unit . "-" . date('Ymd');
            $kodeBarang = $huruf . $no;
        } else {
            $kodeBarang = "TRID-" . $id_unit . "-" . date('Ymd') . "0001";
        }
        return $kodeBarang;
    }

    public function index()
    {
        date_default_timezone_set('Asia/Jakarta');
        if ($this->UserInfo->level == 'Admin Cabang') {
            $kategori_treat = $this->db->table('treatment')->select('kategori')->groupBy('kategori')->orderBy('kategori', 'ASC')->get()->getResult();
            $list_treat = $this->db->table('treatment')->select('id,nama,kategori')->orderBy('kategori', 'ASC')->orderBy('nama', 'ASC')->get()->getResult();
            $list_product = $this->db->table('product')->where('unit_id', $this->UserInfo->unit_id)->orderBy('nama', 'ASC')->get()->getResultObject();
            $list_antrian = $this->db->table('antrian_kunjungan')->where('status', 'Selesai Diagnosa')->where('unit_id', $this->UserInfo->unit_id)->where('tanggal', date('Y-m-d'))->get()->getResultObject();
            $sql1 = "SELECT
                    a.*,
                    b.nama,
                    b.nik
                    FROM transaksi_treatment a
                    LEFT JOIN pasien b ON a.pasien_id=b.id_pasien
                    WHERE a.tanggal='" . date('Y-m-d') . "' AND a.unit_id='" . $this->UserInfo->unit_id . "'";
            $transaksi_treatment = $this->db->query($sql1)->getResultObject();
            $data = [
                'title' => 'App Miguna - Transaksi Treatment',
                'id_transaksi' => $this->getIDTransaksi($this->UserInfo->unit_id),
                'userinfo' => $this->UserInfo,
                'kategori_treat' => $kategori_treat,
                'list_treat' => $list_treat,
                'list_product' => $list_product,
                'list_antrian' => $list_antrian,
                'transaksi_treat' => $transaksi_treatment,
            ];
            return view('/pages/transaksi/transaksi_treat', $data);
        } else {
        }
    }

    public function getdata_filter()
    {
        $unit_id = $this->UserInfo->unit_id;
        $query = $this->db->table('treatment')->where('unit_id', $unit_id)->get()->getResultObject();
        $no = 1;
        if (empty($query)) {
            $data = [
                'no' => "",
                'action' => "",
                'id_treat' => "",
                'nama' => "",
                'harga' => "",
            ];
            $response[] = $data;
        } else {
            foreach ($query as $row) {
                $data = [
                    'no' => $no,
                    'action' => "<div class='button-group'><button class='btn btn-md btn-dark' onclick='masukkan_list_treat()'><i class='fa fa-edit'></i></button></div>",
                    'id_treat' => $row->id_treatment,
                    'nama' => $row->nama,
                    'harga' => $row->harga,
                ];
                $response[] = $data;
                $no++;
            }
        }
        return json_encode($response);
    }

    public function value_treat()
    {
        $id = $this->request->getPost("id_treat");
        $value = $this->db->table('treatment')->where('id', $id)->get()->getRowObject();
        $data['kode'] = $value->id_treatment;
        $data['harga'] = $value->harga;
        return json_encode($data);
    }

    public function value_prod()
    {
        $id = $this->request->getPost("id_prod");
        $value = $this->db->table('product')->where('id', $id)->get()->getRowObject();
        $data['kode'] = $value->kode;
        $data['harga'] = $value->harga;
        $data['satuan'] = $value->satuan;
        $data['qty'] = $value->qty;
        return json_encode($data);
    }

    public function get_no_antrian()
    {
        date_default_timezone_set('Asia/Jakarta');
        $no_antrian = $this->request->getPost("no_antrian");
        $SQL = "SELECT
                a.no_kunjungan as no_kunjungan,
                a.id_pasien as id_pasien,
                b.nama as nama,
                a.catatan_anamnesa as catatan_anamnesa,
                a.catatan_obat as catatan_obat
                FROM diagnosa a 
                LEFT JOIN pasien b ON a.id_pasien = b.id_pasien
                WHERE a.no_kunjungan = '" . $no_antrian . "'
                ";
        $value = $this->db->query($SQL)->getRowObject();
        $data['id_pasien'] = $value->id_pasien;
        $data['nama'] = $value->nama;
        $data['catatan_anamnesa'] = $value->catatan_anamnesa;
        $data['catatan_obat'] = $value->catatan_obat;
        return json_encode($data);
    }

    public function pay_transaksi_detail_treat()
    {
        date_default_timezone_set('Asia/Jakarta');
        $user_id = $this->UserInfo->id;
        $unit_id = $this->UserInfo->unit_id;
        $now = date('Y-m-d H:i:s');
        $transaksi_id = $this->request->getPost("transaksi_id");
        $no_antrian = $this->request->getPost("no_antrian");
        $pasien_id = $this->request->getPost("pasien_id");
        $kode = $this->request->getPost("kode");
        $treatment = $this->request->getPost("treatment");
        $harga = $this->request->getPost("harga");
        $qty = $this->request->getPost("qty");
        $subtotal = $this->request->getPost("subtotal");
        $potongan = $this->request->getPost("potongan");
        $data = [
            'transaksi_id' => $transaksi_id,
            'no_antrian' => $no_antrian,
            'pasien_id' => $pasien_id,
            'kode' => $kode,
            'treatment' => $treatment,
            'harga' => $harga,
            'qty' => $qty,
            'subtotal' => $subtotal,
            'potongan' => $potongan,
            'desc' => "",
            'user_id' => $user_id,
            'unit_id' => $unit_id,
            'created_at' => $now,
            'updated_at' => $now,
        ];
        $query = $this->db->table("transaksi_treatment_detail")->insert($data);
    }

    public function pay_transaksi_detail_prod()
    {
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');
        $user_id = $this->UserInfo->id;
        $unit_id = $this->UserInfo->unit_id;
        $now = date('Y-m-d H:i:s');
        $transaksi_id = $this->request->getPost("transaksi_id");
        $no_antrian = $this->request->getPost("no_antrian");
        $pasien_id = $this->request->getPost("pasien_id");
        $kode = $this->request->getPost("kode");
        $nama = $this->request->getPost("nama");
        $satuan = $this->request->getPost("satuan");
        $harga = $this->request->getPost("harga");
        $qty = $this->request->getPost("qty");
        $subtotal = $this->request->getPost("subtotal");
        $potongan = $this->request->getPost("potongan");
        $data = [
            'transaksi_id' => $transaksi_id,
            'no_antrian' => $no_antrian,
            'pasien_id' => $pasien_id,
            'kode' => $kode,
            'nama' => $nama,
            'satuan' => $satuan,
            'harga' => $harga,
            'qty' => $qty,
            'subtotal' => $subtotal,
            'potongan' => $potongan,
            'desc' => "",
            'user_id' => $user_id,
            'unit_id' => $unit_id,
            'created_at' => $now,
            'updated_at' => $now,
        ];
        $query = $this->db->table("transaksi_treatment_detail_prod")->insert($data);
    }

    public function pay_transaksi()
    {
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');
        $user_id = $this->UserInfo->id;
        $unit_id = $this->UserInfo->unit_id;

        $transaksi_id = $this->request->getPost("transaksi_id");
        $no_antrian = $this->request->getPost("no_antrian");
        $pasien_id = $this->request->getPost("pasien_id");
        $qty = $this->request->getPost("qty");
        $subtotal = $this->request->getPost("subtotal");
        $potongan = $this->request->getPost("potongan");
        $metode_bayar = $this->request->getPost("metode_bayar");
        $jumlah_dibayar = $this->request->getPost("jumlah_dibayar");
        $kembalian = $this->request->getPost("kembalian");

        $data = [
            'transaksi_id' => $transaksi_id,
            'no_antrian' => $no_antrian,
            'pasien_id' => $pasien_id,
            'tanggal' => date("Y-m-d"),
            'qty' => $qty,
            'subtotal' => $subtotal,
            'potongan' => $potongan,
            'desc_pot' => "",
            'metode_bayar' => $metode_bayar,
            'no_transaksi' => "",
            'img' => "",
            'jumlah_dibayar' => $jumlah_dibayar,
            'kembalian' => $kembalian,
            'deskripsi' => "",
            'user_id' => $user_id,
            'unit_id' => $unit_id,
            'created_at' => $now,
            'updated_at' => $now,
        ];

        // var_dump($data);
        $data2 = [
            'status' => 'Transaksi Selesai',
            'updated_at' => $now,
        ];

        $query = $this->db->table("transaksi_treatment")->insert($data);
        $query2 = $this->db->table('antrian_kunjungan')->where('no_antrian', $no_antrian)->update($data2);
        if ($query && $query2) {
            $response = [
                'status' => 'success',
                'message' => 'Success',
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Error',
            ];
        }
        return json_encode($response);
    }

    public function pay_transaksi_debit()
    {
        date_default_timezone_set('Asia/jakarta');
        $now = date('Y-m-d H:i:s');
        $user_id = $this->UserInfo->id;
        $unit_id = $this->UserInfo->unit_id;
        $id_transaksi = $this->request->getPost("id_transaksi");
        $no_antrian = $this->request->getPost("no_antrian");
        $pasien_id = $this->request->getPost("pasien_id");
        $qty = $this->request->getPost("qty");
        $subtotal = $this->request->getPost("subtotal");
        $potongan = $this->request->getPost("potongan");
        $deskripsi = $this->request->getPost("deskripsi");
        $metode_bayar = $this->request->getPost("metode_bayar");
        $jumlah_dibayar = $this->request->getPost("jumlah_dibayar");
        $kembalian = $this->request->getPost("kembalian");
        $no_debit = $this->request->getPost("no_debit");
        $filename = $_FILES['img'];
        $randomFileName = rand(1, 1000000);
        $ext = pathinfo($filename['name'], PATHINFO_EXTENSION);
        $fileNameRand = $randomFileName . '.' . $ext;
        move_uploaded_file($filename['tmp_name'], 'upload/' . $fileNameRand);
        $data = [
            'transaksi_id' => $id_transaksi,
            'no_antrian' => $no_antrian,
            'pasien_id' => $pasien_id,
            'tanggal' => date('Y-m-d'),
            'qty' => $qty,
            'subtotal' => $subtotal,
            'potongan' => $potongan,
            'desc_pot' => $deskripsi,
            'metode_bayar' => $metode_bayar,
            'no_transaksi' => $no_debit,
            'img' => $fileNameRand,
            'jumlah_dibayar' => $jumlah_dibayar,
            'kembalian' => $kembalian,
            'deskripsi' => $deskripsi,
            'user_id' => $user_id,
            'unit_id' => $unit_id,
            'created_at' => $now,
            'updated_at' => $now,
        ];
        $data2 = [
            'status' => 'Transaksi Selesai',
            'updated_at' => $now,
        ];

        $query = $this->db->table('transaksi_treatment')->insert($data);
        $query2 = $this->db->table('antrian_kunjungan')->where('no_antrian', $no_antrian)->update($data2);

        if ($query && $query2) {
            $response = [
                'status' => 'success',
                'message' => 'Success',
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Error',
            ];
        }
        return json_encode($response);
    }

    public function list_transaksi()
    {
        $transaksi_id = $this->request->getPost('transaksi_id');
        $SQL = "SELECT
                a.*,
                b.nama,
                b.nik
                FROM transaksi_treatment a
                LEFT JOIN pasien b ON a.pasien_id = b.id_pasien
                WHERE a.transaksi_id = '" . $transaksi_id . "'";
        $value = $this->db->query($SQL)->getRowObject();

        $SQL1 = "SELECT
                a.*
                FROM transaksi_treatment_detail a
                WHERE a.transaksi_id = '" . $transaksi_id . "'";
        $value1 = $this->db->query($SQL1)->getResultObject();
        foreach ($value1 as $row) {
            $treat[] = $row;
        }

        $SQL2 = "SELECT
                a.*
                FROM transaksi_treatment_detail_prod a
                WHERE a.transaksi_id = '" . $transaksi_id . "'";
        $value2 = $this->db->query($SQL2)->getResultObject();
        foreach ($value2 as $row) {
            $prod[] = $row;
        }

        $data = [
            'transaksi_id' => $transaksi_id,
            'no_antrian' => $value->no_antrian,
            'pasien_id' => $value->pasien_id,
            'nik' => $value->nik,
            'nama' => $value->nama,
            'qty' => $value->qty,
            'subtotal' => $value->subtotal,
            'potongan' => $value->potongan,
            'metode_bayar' => $value->metode_bayar,
            'no_debit' => $value->no_transaksi,
            'jumlah_dibayar' => $value->jumlah_dibayar,
            'kembalian' => $value->kembalian,
            'treatment' => $treat,
            'product' => $prod,
        ];
        return json_encode($data);
    }

    public function getdata_visit()
    {
        date_default_timezone_set('Asia/Jakarta');
        if ($this->UserInfo->level == 'Admin Cabang') {
            $SQL = "SELECT 
                    COUNT(*) as jumlah
                    FROM 
                    transaksi_treatment 
                    WHERE unit_id ='" . $this->UserInfo->unit_id . "'
                    AND tanggal='"  . date('Y-m-d') . "'";
            $jumlah = $this->db->query($SQL)->getRowObject()->jumlah;
            $data['jumlah'] = $jumlah;
            return json_encode($data);
        }
    }

    public function getdata_potsub()
    {
        date_default_timezone_set('Asia/Jakarta');
        if ($this->UserInfo->level == 'Admin Cabang') {
            $SQL = "SELECT 
                    SUM(potongan) as jlh_potongan,
                    SUM(subtotal) as jlh_subtotal
                    FROM 
                    transaksi_treatment 
                    WHERE unit_id ='" . $this->UserInfo->unit_id . "'
                    AND tanggal='"  . date('Y-m-d') . "'";
            $jlh_potongan = $this->db->query($SQL)->getRowObject()->jlh_potongan;
            $jlh_subtotal = $this->db->query($SQL)->getRowObject()->jlh_subtotal;
            $data['jumlah_potongan'] = $jlh_potongan;
            $data['jumlah_subtotal'] = $jlh_subtotal;
            $data['total'] = $jlh_subtotal + $jlh_potongan;
            return json_encode($data);
        }
    }

    public function invoice()
    {
        $connector = new WindowsPrintConnector("ZJ-58");
        $printer = new Printer($connector);
        $no_trans = $_GET['no_transaksi'];
        $value_row = $this->db->table("transaksi_treatment")->where("transaksi_id", $no_trans)->get()->getRowObject();
        $value_treat = $this->db->table("transaksi_treatment_detail")->where("transaksi_id", $no_trans)->get()->getResult();
        $value_prod = $this->db->table("transaksi_treatment_detail_prod")->where("transaksi_id", $no_trans)->get()->getResult();
        function buatBaris4Kolom($kolom1, $kolom2, $kolom3, $kolom4)
        {
            // Mengatur lebar setiap kolom (dalam satuan karakter)
            $lebar_kolom_1 = 15;
            $lebar_kolom_2 = 3;
            $lebar_kolom_3 = 8;
            $lebar_kolom_4 = 10;

            // Melakukan wordwrap(), jadi jika karakter teks melebihi lebar kolom, ditambahkan \n 
            $kolom1 = wordwrap($kolom1, $lebar_kolom_1, "\n", true);
            $kolom2 = wordwrap($kolom2, $lebar_kolom_2, "\n", true);
            $kolom3 = wordwrap($kolom3, $lebar_kolom_3, "\n", true);
            $kolom4 = wordwrap($kolom4, $lebar_kolom_4, "\n", true);

            // Merubah hasil wordwrap menjadi array, kolom yang memiliki 2 index array berarti memiliki 2 baris (kena wordwrap)
            $kolom1Array = explode("\n", $kolom1);
            $kolom2Array = explode("\n", $kolom2);
            $kolom3Array = explode("\n", $kolom3);
            $kolom4Array = explode("\n", $kolom4);

            // Mengambil jumlah baris terbanyak dari kolom-kolom untuk dijadikan titik akhir perulangan
            $jmlBarisTerbanyak = max(count($kolom1Array), count($kolom2Array), count($kolom3Array), count($kolom4Array));

            // Mendeklarasikan variabel untuk menampung kolom yang sudah di edit
            // $hasilBaris = ;

            // Melakukan perulangan setiap baris (yang dibentuk wordwrap), untuk menggabungkan setiap kolom menjadi 1 baris 
            for ($i = 0; $i < $jmlBarisTerbanyak; $i++) {

                // memberikan spasi di setiap cell berdasarkan lebar kolom yang ditentukan, 
                $hasilKolom1 = str_pad((isset($kolom1Array[$i]) ? $kolom1Array[$i] : ""), $lebar_kolom_1, " ");
                $hasilKolom2 = str_pad((isset($kolom2Array[$i]) ? $kolom2Array[$i] : ""), $lebar_kolom_2, " ");

                // memberikan rata kanan pada kolom 3 dan 4 karena akan kita gunakan untuk harga dan total harga
                $hasilKolom3 = str_pad((isset($kolom3Array[$i]) ? $kolom3Array[$i] : ""), $lebar_kolom_3, " ", STR_PAD_LEFT);
                $hasilKolom4 = str_pad((isset($kolom4Array[$i]) ? $kolom4Array[$i] : ""), $lebar_kolom_4, " ", STR_PAD_LEFT);

                // Menggabungkan kolom tersebut menjadi 1 baris dan ditampung ke variabel hasil (ada 1 spasi disetiap kolom)
                $hasilBaris[] = $hasilKolom1 . " " . $hasilKolom2 . " " . $hasilKolom3 . " " . $hasilKolom4;
            }

            // Hasil yang berupa array, disatukan kembali menjadi string dan tambahkan \n disetiap barisnya.
            return implode($hasilBaris) . "\n";
        }
        $img = EscposImage::load("assets/images/paid.png");
        $imgModes = [
            Printer::IMG_DEFAULT,
            Printer::IMG_DOUBLE_WIDTH,
            Printer::IMG_DOUBLE_HEIGHT,
            Printer::IMG_DOUBLE_WIDTH | Printer::IMG_DOUBLE_HEIGHT
        ];
        // Membuat judul
        $printer->initialize();
        $printer->selectPrintMode(Printer::MODE_DOUBLE_HEIGHT); // Setting teks menjadi lebih besar
        $printer->setJustification(Printer::JUSTIFY_CENTER); // Setting teks menjadi rata tengah
        $printer->bitImageColumnFormat($img, 0);
        $printer->text("Nama Toko\n");
        $printer->text("\n");

        // Data transaksi
        $printer->initialize();
        $printer->text("No.Invoice : " . $no_trans . "\n");
        $printer->text("Kasir : " . $this->UserInfo->fullname . "\n");
        $printer->text("Waktu : " . $value_row->created_at . "\n");
        $printer->text("Metode  : " . $value_row->metode_bayar . "\n");
        // Membuat tabel
        $printer->initialize(); // Reset bentuk/jenis teks
        $printer->text("--------------------------------\n");
        $printer->text(buatBaris4Kolom("Item", "qty", "Subs", "Pot"));
        $printer->text("--------------------------------\n");
        foreach ($value_treat as $row) {
            $printer->text(buatBaris4Kolom($row->treatment, $row->qty, number_format($row->subtotal, 0), number_format($row->potongan, 0)));
            // $printer->text(buatBaris4Kolom("Telur", "2", "5.000", "10.000"));
            // $printer->text(buatBaris4Kolom("Tepung terigu", "1", "8.200", "16.400"));
        }

        foreach ($value_prod as $row) {
            $printer->text(buatBaris4Kolom($row->nama, $row->qty, number_format($row->subtotal, 0), number_format($row->potongan, 0)));
            // $printer->text(buatBaris4Kolom("Telur", "2", "5.000", "10.000"));
            // $printer->text(buatBaris4Kolom("Tepung terigu", "1", "8.200", "16.400"));
        }
        $printer->text("--------------------------------\n");
        // $printer->text(buatBaris4Kolom("Total", "56.400", '', ''));
        $printer->text("Subtotal : " . number_format($value_row->subtotal, 0) . "\n");
        $printer->text("Potongan : " . number_format($value_row->potongan, 0) . "\n");
        $printer->text("Jumlah Dibayar : " . number_format($value_row->jumlah_dibayar, 0) . "\n");
        $printer->text("Kembalian : " . number_format($value_row->kembalian, 0) . "\n");
        $printer->text("\n");

        // Pesan penutup
        $printer->initialize();
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("Terima kasih telah berbelanja\n");
        $printer->text("http://badar-blog.blogspot.com\n");
        $printer->feed(1);
        $printer->qrCode("19349284", Printer::QR_ECLEVEL_Q, '8');
        $printer->setJustification();
        $printer->feed(2); // mencetak 5 baris kosong agar terangkat (pemotong kertas saya memiliki jarak 5 baris dari toner)
        $printer->close();
    }
}