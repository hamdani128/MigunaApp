$(document).ready(function () {
    $('#table-transaksi-product').DataTable();
});

function Summary() {

}

function call_add_transaksi_prod() {
    $("#my-modal").modal("show");
}

function awal() {
    $("#kode").val("");
    $("#cmb_prod").val("");
    $("#satuan").val("");
    $("#harga").val("");
    $("#qty").val("");
    $("#subtotal").val("");
    $("#potongan").val("");
    $("#sub_dipotong").val("");
    $("#sub_discount").val("");
    document.getElementById("desc_1").innerText = "";
}

function OnChangeQty() {
    var qty = $("#qty").val().replace(',', '').replace('.', '');
    var harga = $("#harga").val().replace(',', '').replace('.', '');
    var subtotal = qty * harga;
    $("#subtotal").val(new Intl.NumberFormat().format(subtotal));
}

function OnchangeProductByName() {
    var item = $("#cmb_prod").val();
    if (item == "") {
        swal.fire({
            type: "warning",
            title: "Alert !",
            text: "Data list Item Tidak Boleh Kosong !",
        });
    } else {
        $.ajax({
            url: "/transaksi/product/list_detail_item",
            type: "POST",
            data: {
                item: item,
            },
            dataType: "json",
            success: function (data) {
                $("#kode").val(data.kode);
                $("#satuan").val(data.satuan);
                $("#harga").val(new Intl.NumberFormat().format(data.harga));
                $("#qty").val(1);
                $("#subtotal").val(new Intl.NumberFormat().format(data.harga * 1));
                $("#potongan").val(0)
            }
        });
    }
}

function potongan_nilai() {
    var qty = $("#qty").val().replace('.', '').replace(',', '');
    var potongan = $("#sub_dipotong").val().replace('.', '').replace(',', '');
    var harga = $("#harga").val().replace('.', '').replace(',', '');
    var hasil = (qty * harga) - potongan;
    $("#potongan").val(new Intl.NumberFormat().format(potongan));
    $("#subtotal").val(new Intl.NumberFormat().format(hasil));
    document.getElementById("desc_1").innerHTML = "Potongan Harga Rp." + new Intl.NumberFormat().format(potongan);
}

function potongan_discount() {
    var qty = $("#qty").val().replace('.', '').replace(',', '');
    var harga = $("#harga").val().replace('.', '').replace(',', '');
    var jlh_disc = $("#sub_discount").val().replace('.', '').replace(',', '');
    var hasil_potongan = (qty * harga) * (jlh_disc / 100);
    var subtotal = (qty * harga) - hasil_potongan;
    $("#potongan").val(new Intl.NumberFormat().format(hasil_potongan));
    $("#subtotal").val(new Intl.NumberFormat().format(subtotal));
    document.getElementById("desc_1").innerHTML = "Discont " + jlh_disc + "%";
}

function Summary() {
    var table = document.getElementById("tbody-list-trans-prod");
    var sumVal = 0;
    var sumPot = 0;
    var qty = 0;
    for (var i = 0; i < table.rows.length; i++) {
        var qt = table.rows[i].cells[5].innerHTML;
        var su = table.rows[i].cells[6].innerHTML;
        var po = table.rows[i].cells[7].innerHTML
        sumVal = sumVal + parseFloat(su.replace('.', '').replace(',', ''));
        sumPot = sumPot + parseFloat(po.replace('.', '').replace(',', ''));
        qty = qty + parseFloat(qt.replace('.', '').replace(',', ''));
    }
    document.getElementById("subtotal_all").innerHTML = new Intl.NumberFormat().format(sumVal);
    document.getElementById("potongan_all").innerHTML = new Intl.NumberFormat().format(sumPot);
    document.getElementById("qty_all").innerHTML = new Intl.NumberFormat().format(qty);
}


function masukkan_list_belanja() {
    var table2 = document.getElementById("tbody-list-trans-prod");
    var kode = $("#kode").val();
    var cmb_prod = document.getElementById("cmb_prod");
    var cmb_prod_value = cmb_prod.options[cmb_prod.selectedIndex].value;
    var cmb_prod_text = cmb_prod.options[cmb_prod.selectedIndex].text;
    var dsc = document.getElementById("desc_1").innerHTML;
    var harga = $("#harga").val().replace('.', '').replace(',', '');
    var qty = $("#qty").val().replace('.', '').replace(',', '');
    var subtotal = $("#subtotal").val().replace('.', '').replace(',', '');
    var potongan = $("#potongan").val().replace('.', '').replace(',', '');
    var satuan = $("#satuan").val();

    for (var i = 0; i < table2.rows.length; i++) {
        if (table2.rows[i].cells[1].innerHTML == kode) {
            swal.fire({
                type: "error",
                title: "Mohon Maaf !",
                text: "Data Produk " + cmb_prod_text + " Sudah Ada List !",
            });
            return false;
        }
    }
    var x = table2.insertRow(0);
    var c1 = x.insertCell(0);
    var c2 = x.insertCell(1);
    var c3 = x.insertCell(2);
    var c4 = x.insertCell(3);
    var c5 = x.insertCell(4);
    var c6 = x.insertCell(5);
    var c7 = x.insertCell(6);
    var c8 = x.insertCell(7);
    var c9 = x.insertCell(8);
    c1.innerHTML = '<button type="button" class="btn btn-md btn-danger" onclick="delete_list(this)"><i class ="fa fa-trash"></i></button >';
    c2.innerHTML = kode;
    c3.innerHTML = cmb_prod_text;
    c4.innerHTML = satuan;
    c5.innerHTML = harga;
    c6.innerHTML = qty;
    c7.innerHTML = subtotal;
    c8.innerHTML = potongan;
    c9.innerHTML = dsc;
    awal();
    Summary();
}

function delete_list(btn) {
    var row = btn.parentNode.parentNode;
    row.parentNode.removeChild(row);
    Summary();
    if (document.getElementById("tbody-list-trans-prod").rows.length === 0) {
        document.getElementById("subtotal_all").innerHTML = 0;
        document.getElementById("potongan_all").innerHTML = 0;
        document.getElementById("qty_all").innerHTML = 0;
    } else { }
}



function detail_transaksi_product() {
    var no_transaksi = document.getElementById("no_transaksi").innerHTML;
    var table = document.getElementById("tbody-list-trans-prod");
    for (var i = 0; i < table.rows.length; i++) {
        var kode = table.rows[i].cells[1].innerHTML;
        var nama = table.rows[i].cells[2].innerHTML;
        var satuan = table.rows[i].cells[3].innerHTML;
        var harga = table.rows[i].cells[4].innerHTML.replace('.', '').replace(',', '');
        var qty = table.rows[i].cells[5].innerHTML.replace('.', '').replace(',', '');
        var su = table.rows[i].cells[6].innerHTML.replace('.', '').replace(',', '');
        var po = table.rows[i].cells[7].innerHTML.replace('.', '').replace(',', '');
        var desc = table.rows[i].cells[8].innerHTML;
        $.ajax({
            url: "/transaksi/product/pay_transaksi_detail",
            type: "POST",
            data: {
                no_transaksi: no_transaksi,
                kode: kode,
                nama: nama,
                satuan: satuan,
                harga: harga,
                qty: qty,
                subtotal: su,
                potongan: po,
                desc: desc,
            },
            dataType: "json",
        });
    }
}

function pay_cashProduct() {
    // Data Pasien
    var cmb_kategori_konsumen_cash = document.getElementById("cmb_konsumen");
    var cmb_kategori_konsumen_value_cash = cmb_kategori_konsumen_cash.options[cmb_kategori_konsumen_cash.selectedIndex].value;
    var cmb_kategori_konsumen_text_cash = cmb_kategori_konsumen_cash.options[cmb_kategori_konsumen_cash.selectedIndex].text;
    var nama_cash = $("#nama_konsumen").val();
    var hp_cash = $("#no_hp").val();
    var alamat_cash = $("#alamat").val();
    var nik_cash = $("#nik").val();
    var idpasien_cash = document.getElementById("id_pasien").innerHTML;
    // transaksi
    var no_transaksi_cash = document.getElementById("no_transaksi").innerHTML;
    var metode_bayar_cash = $("#cmb_metode_bayar").val();
    var qty_cash = document.getElementById("qty_all").innerHTML.replace('.', '').replace(',', '');
    var subtotal_cash = document.getElementById("subtotal_all").innerHTML.replace('.', '').replace(',', '');
    var potongan_cash = document.getElementById("potongan_all").innerHTML.replace('.', '').replace(',', '');
    var jumlah_dibayar_cash = $("#nominal_bayar_product").val().replace('.', '').replace(',', '');
    var kembalian_cash = document.getElementById("kembalian").innerHTML.replace('.', '').replace(',', '');
    // 
    let FormDataCash = new FormData();
    FormDataCash.append("no_transaksi", no_transaksi_cash);
    FormDataCash.append("metode_bayar", metode_bayar_cash);
    FormDataCash.append("qty", qty_cash);
    FormDataCash.append("subtotal", subtotal_cash);
    FormDataCash.append("potongan", potongan_cash);
    FormDataCash.append("deskripsi", "");
    FormDataCash.append("konsumen", cmb_kategori_konsumen_value_cash);
    FormDataCash.append("pasien_id", "");
    FormDataCash.append("nama", nama_cash);
    FormDataCash.append("hp", hp_cash);
    FormDataCash.append("alamat", alamat_cash);
    FormDataCash.append("nik", nik_cash);
    FormDataCash.append("img", "");
    FormDataCash.append("jumlah_dibayar", jumlah_dibayar_cash);
    FormDataCash.append("kembalian", kembalian_cash);
    FormDataCash.append("no_transaksi_debit", "");
    detail_transaksi_product()
    $.ajax({
        url: "/transaksi/product/pay_cash",
        type: "POST",
        enctype: 'multipart/form-data',
        processData: false,  // tell jQuery not to process the data
        contentType: false,
        data: FormDataCash,
        dataType: "json",
        success: function (data) {
            if (data.status == "success") {
                swal.fire({
                    type: "success",
                    title: "Good Luck !",
                    text: "Transaksi Anda Berhasil !",
                });
                document.location.reload();
            }
        }
    });
}
function payDebitProduct() {
    // Data Pasien
    var cmb_kategori_konsumen = document.getElementById("cmb_konsumen");
    var cmb_kategori_konsumen_value = cmb_kategori_konsumen.options[cmb_kategori_konsumen.selectedIndex].value;
    var cmb_kategori_konsumen_text = cmb_kategori_konsumen.options[cmb_kategori_konsumen.selectedIndex].text;
    var nama = $("#nama_konsumen").val();
    var hp = $("#no_hp").val();
    var alamat = $("#alamat").val();
    var nik = $("#nik").val();
    var idpasien = document.getElementById("id_pasien").innerHTML;
    // transaksi
    var no_transaksi = document.getElementById("no_transaksi").innerHTML;
    var metode_bayar = $("#cmb_metode_bayar").val();
    var qty = document.getElementById("qty_all").innerHTML.replace('.', '').replace(',', '');
    var subtotal = document.getElementById("subtotal_all").innerHTML.replace('.', '').replace(',', '');
    var potongan = document.getElementById("potongan_all").innerHTML.replace('.', '').replace(',', '');
    var jumlah_dibayar = $("#nominal_bayar_product").val().replace('.', '').replace(',', '');
    var kembalian = document.getElementById("kembalian").innerHTML.replace('.', '').replace(',', '');
    let img = document.getElementById("input-file-now img_bukti").files[0];
    var no_transaksi_debit = $("#no_transaksi_debit").val();
    let form_data = new FormData();
    form_data.append("no_transaksi", no_transaksi);
    form_data.append("metode_bayar", metode_bayar);
    form_data.append("qty", qty);
    form_data.append("subtotal", subtotal);
    form_data.append("potongan", potongan);
    form_data.append("deskripsi", "");
    form_data.append("konsumen", cmb_kategori_konsumen_value);
    form_data.append("pasien_id", idpasien);
    form_data.append("nama", nama);
    form_data.append("hp", hp);
    form_data.append("alamat", alamat);
    form_data.append("nik", nik);
    form_data.append("img", img);
    form_data.append("jumlah_dibayar", jumlah_dibayar);
    form_data.append("kembalian", kembalian);
    form_data.append("no_transaksi_debit", no_transaksi_debit);

    detail_transaksi_product()
    $.ajax({
        url: "/transaksi/product/pay_debit",
        type: "POST",
        data: form_data,
        enctype: 'multipart/form-data',
        processData: false,  // tell jQuery not to process the data
        contentType: false,
        dataType: "json",
        success: function (data) {
            if (data.status == "success") {
                swal.fire({
                    type: "success",
                    title: "Good Luck !",
                    text: "Transaksi Anda Berhasil !",
                });
                document.location.reload();
            }
        }
    });
}



function OnChngeKonsumen() {
    var cmb_konsumen = document.getElementById("cmb_konsumen");
    var cmb_konsumen_value = cmb_konsumen.options[cmb_konsumen.selectedIndex].value;
    var x = document.getElementById("pasien_x");
    if (cmb_konsumen_value == "Pasien") {
        x.style.display = "block";
        // $('#my-modal-pasien').modal('show');
        $('#table-pasien-admin-product').DataTable().destroy();
        $('#table-pasien-admin-product').DataTable({
            ajax: {
                url: "/transaksi/product/getdata_pasien",
                dataSrc: "",
            },
            columns: [
                { "data": "no" },
                { "data": "action" },
                { "data": "id_pasien" },
                { "data": "nik" },
                { "data": "nama" },
                { "data": "usia" },
                { "data": "alamat" },
                { "data": "jk" },
                { "data": "pekerjaan" },
                { "data": "hp" },
                { "data": "registri" },
                { "data": "created_at" }
            ],
        });
    } else {
        x.style.display = "none";
    }
}

function pilih_konsumen() {
    var table = document.getElementById("table-pasien-admin-product");
    var rows = table.getElementsByTagName("tr");
    for (i = 0; i < rows.length; i++) {
        var currentRow = table.rows[i];
        var createClickHandler = function (row) {
            return function () {
                var cell1 = row.getElementsByTagName("td")[2];
                var cell2 = row.getElementsByTagName("td")[3];
                var cell3 = row.getElementsByTagName("td")[4];
                var cell4 = row.getElementsByTagName("td")[5];
                var cell5 = row.getElementsByTagName("td")[6];
                var cell6 = row.getElementsByTagName("td")[7];
                var cell7 = row.getElementsByTagName("td")[8];
                var cell8 = row.getElementsByTagName("td")[9];
                var id_pasien = cell1.innerHTML;
                var nik = cell2.innerHTML;
                var nama = cell3.innerHTML;
                var usia = cell4.innerHTML;
                var alamat = cell5.innerHTML;
                var jenis_kelamin = cell6.innerHTML;
                var pekerjaan = cell7.innerHTML;
                var hp = cell8.innerHTML;

                $("#nama_konsumen").val(nama);
                document.getElementById("id_pasien").innerText = id_pasien;
                $("#no_hp").val(hp);
                $("#alamat").val(alamat);
                $("#nik").val(nik);
                var x = document.getElementById("pasien_x").style.display = 'none';
            };
        };
        currentRow.onclick = createClickHandler(currentRow);
    }
}

function OnChangeMetodeBayar() {
    var cmb = document.getElementById("cmb_metode_bayar");
    var cmb_value = cmb.options[cmb.selectedIndex].value;
    var x = document.getElementById("debit");
    if (cmb_value == "Debit ATM") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}

function clear_konsumen() {
    $("#cmb_konsumen").val("");
    $("#nama_konsumen").val("");
    document.getElementById("id_pasien").innerText = "";
    $("#no_hp").val("");
    $("#alamat").val("");
    $("#nik").val("");
}

function lakukan_pembayaran() {
    var subtotal = document.getElementById("subtotal_all").innerText.replace(",", "").replace(".", "");
    var nominal = $("#nominal_bayar_product").val().replace(",", "").replace(".", "");
    if (parseInt(nominal) < parseInt(subtotal)) {
        swal.fire({
            type: "error",
            title: "Nominal Anda Kurang !",
            text: "Erorr Process !",
        });
        $("#nominal_bayar").val(0);
    } else {
        var hasil = nominal - subtotal;
        document.getElementById("kembalian").innerHTML = new Intl.NumberFormat().format(hasil);
    }
}

$('#nominal_bayar_product').on('keyup', function (e) {
    if (e.keyCode === 13) {
        lakukan_pembayaran();
    }
});

function simpan_transaksi_product() {
    $('.button-prevent').attr('disabled', 'true');
    $('.spinner').show();
    $('.hide-text').hide();
    var cmb_metode_bayar = document.getElementById("cmb_metode_bayar");
    var cmb_metode_bayar_value = cmb_metode_bayar.options[cmb_metode_bayar.selectedIndex].value;
    if (cmb_metode_bayar_value == 'Cash') {
        pay_cashProduct()
    } else if (cmb_metode_bayar_value == 'Debit ATM') {
        payDebitProduct()
    } else {
        swal.fire({
            icon: "error",
            title: "Mohon Maaf !",
            text: "Jangan Lupa Memilih Metode Bayar Anda !",
        });
    }
}

function list_invoice_product(no_transaksi) {
    document.getElementById("no_invoice_list").innerHTML = no_transaksi;
    $.ajax({
        url: "/transaksi/product/list_transaksi",
        type: "POST",
        data: {
            no_transaksi: no_transaksi,
        },
        dataType: "json",
        success: function (data) {
            document.getElementById("kategori_konsumen").innerHTML = data.kategori_konsumen + " - " + data.id_pasien;
            document.getElementById("nik_konsumen").innerHTML = data.nik;
            document.getElementById("nama_konsumen_new").innerHTML = data.nama;
            document.getElementById("alamat_konsumen").innerHTML = data.alamat;
            document.getElementById("no_hp_konsumen").innerHTML = data.hp;
            document.getElementById("list_metode_bayar").innerText = data.metode_bayar
            document.getElementById("list_jumlah_dibayar").innerText = new Intl.NumberFormat().format(data.jumlah_dibayar).replace(',', '.')
            document.getElementById("list_kembalian").innerText = new Intl.NumberFormat().format(data.kembalian).replace(',', '.')
            document.getElementById("list_qty").innerText = new Intl.NumberFormat().format(data.qty).replace(',', '.')
            document.getElementById("list_subtotal").innerText = new Intl.NumberFormat().format(data.subtotal).replace(',', '.')

            // // treatment
            var tbody1 = document.getElementById('list_trans_prod_tbody');
            var tr1 = '';
            for (var i in data.product) {
                tr1 += `<tr>
                <td align="center">${data.product[i].kode}</td>
                <td>${data.product[i].nama}</td>
                <td>${data.product[i].satuan}</td>
                <td>${data.product[i].harga}</td>
                <td>${data.product[i].qty}</td>
                <td>${data.product[i].subtotal}</td>
                <td>${data.product[i].potongan}</td>
                <td>${data.product[i].deskripsi}</td>
            </tr>`;
            }
            tbody1.innerHTML = tr1;
        }
    });
    $("#my-modal-invoice").modal("show");
}

function delete_transaksi_product(no_transaksi) {
    Swal.fire({
        title: 'Yakin Apakan Anda ingin Menghapus Data ini ?',
        text: "Data dengan No.Transaksi " + no_transaksi + " Akan dihapus !",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus Data !',
        cancelButtonText: 'Tidak'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "/transaksi/product/delete",
                data: {
                    no_transaksi: no_transaksi,
                },
                type: "POST",
                dataType: "json",
                success: function (data) {
                    if (data.status == 'success') {
                        Swal.fire(
                            'Berhasil !',
                            'Data Berhasil Dihapus !',
                            'success'
                        )
                        document.location.reload();
                    }
                }
            });
        }
    });
}

function cetak_invoice_prodcut(no_transaksi) {
    Swal.fire({
        title: 'Yakin Apakan Anda ingin Mencetak Data Transaksi ' + no_transaksi + ' ini ?',
        text: "Data Transaksi Akan Dicetak !",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Cetak !',
        cancelButtonText: 'Tidak'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "/transaksi/product/invoice",
                type: "GET",
                data: {
                    no_transaksi: no_transaksi
                },
                // dataType: "json",
                success: function (data) {
                }
            });
        }
    });
}

