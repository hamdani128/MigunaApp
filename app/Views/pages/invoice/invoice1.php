<?php
// require ROOTPATH . 'vendor/autoload.php';

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
/* Open the printer; this will change depending on how it is connected */

$connector = new WindowsPrintConnector("ZJ-58");
$printer = new Printer($connector);
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

// Membuat judul
$printer->initialize();
$printer->selectPrintMode(Printer::MODE_DOUBLE_HEIGHT); // Setting teks menjadi lebih besar
$printer->setJustification(Printer::JUSTIFY_CENTER); // Setting teks menjadi rata tengah
$printer->text("Nama Toko\n");
$printer->text("\n");

// Data transaksi
$printer->initialize();
$printer->text("Kasir : Badar Wildanie\n");
$printer->text("Waktu : 13-10-2019 19:23:22\n");

// Membuat tabel
$printer->initialize(); // Reset bentuk/jenis teks
$printer->text("--------------------------------\n");
$printer->text(buatBaris4Kolom("Item", "qty", "Price", "Subs"));
$printer->text("--------------------------------\n");
$printer->text(buatBaris4Kolom("Makaroni 250gr", "2", "15.000", "30.000"));
$printer->text(buatBaris4Kolom("Telur", "2", "5.000", "10.000"));
$printer->text(buatBaris4Kolom("Tepung terigu", "1", "8.200", "16.400"));
$printer->text("--------------------------------\n");
// $printer->text(buatBaris4Kolom("Total", "56.400", '', ''));
$printer->text("Subtotal : 56.400\n");
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
