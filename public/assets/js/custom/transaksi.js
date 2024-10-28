$(document).ready(function () {
    $(".money").maskMoney({ thousands: '.', decimal: ',', affixesStay: false, precision: 0 });
});

$(document).ready(function () {
    $('#table-transaksi-kunjungan').DataTable({
        "ajax": {
            "url": "/transaksi/kunjungan/getdata",
            "dataSrc": "",
        },
        "columns": [
            { "data": "no" },
            { "data": "action" },
            { "data": "no_antrian" },
            { "data": "id_pasien" },
            { "data": "nama" },
            { "data": "catatan_kunjungan" },
            { "data": "status" },
            { "data": "tanggal" },
            { "data": "created_at" },
            { "data": "status_asli" }
        ],
    });

    $('#table-transaksi-treatment').DataTable();

    $('#table-list-treat').DataTable({
        "ajax": {
            "url": "/transaksi/treatment/getdata_filter",
            "dataSrc": "",
        },
        "columns": [
            { "data": "no" },
            { "data": "action" },
            { "data": "id_treat" },
            { "data": "nama" },
            { "data": "harga" },
        ],
    });
});

function getVisit() {
    $.ajax({
        url: "/transaksi/treatment/getdata_visit",
        type: "GET",
        dataType: "json",
        success: function (data) {
            document.getElementById("visit_jlh").innerHTML = data.jumlah;
        }
    });
}
// getVisit();
function getPotongan() {
    $.ajax({
        url: "/transaksi/treatment/getdata_potsub",
        type: "GET",
        dataType: "json",
        success: function (data) {
            document.getElementById("potongan_jlh").innerHTML = "Rp." + (new Intl.NumberFormat('id-ID').format(data.jumlah_potongan));
            document.getElementById("subtotal_jlh").innerHTML = "Rp." + (new Intl.NumberFormat('id-ID').format(data.jumlah_subtotal));
            document.getElementById("total_jlh").innerHTML = "Rp." + (new Intl.NumberFormat('id-ID').format(data.total));
        }
    });
}
// getPotongan()

function refresh_summary_tr_trans() {
    getVisit();
    getPotongan()
}

function OnChange_Filter() {
    var cmb_filter = document.getElementById("cmb_treat");
    var cmb_filter_text = cmb_filter.options[cmb_filter.selectedIndex].text;
    var cmb_filter_value = cmb_filter.options[cmb_filter.selectedIndex].value;
    getDataFilter(cmb_filter_value);
}

function getDataFilter(filter) {
    $('#table-list-treat').DataTable({
        "ajax": {
            "url": "/transaksi/treatment/getdata_filter",
            "dataSrc": [
                { "filter": filter },
            ],
        },
        "columns": [
            { "data": "no" },
            { "data": "action" },
            { "data": "no_antrian" },
            { "data": "id_pasien" },
            { "data": "nama" },
            { "data": "catatan_kunjungan" },
            { "data": "status" },
            { "data": "tanggal" },
            { "data": "created_at" },
            { "data": "status_asli" }
        ],
    });
}

function delete_transaksi_kunjungan() {
    var table = document.getElementById("table-transaksi-kunjungan");
    var rows = table.getElementsByTagName("tr");
    for (i = 0; i < rows.length; i++) {
        var currentRow = table.rows[i];
        var createClickHandler = function (row) {
            return function () {
                var cell1 = row.getElementsByTagName("td")[2];
                var cell2 = row.getElementsByTagName("td")[3];
                var cell3 = row.getElementsByTagName("td")[4];
                var cell9 = row.getElementsByTagName("td")[9];
                var no_antrian = cell1.innerHTML;
                var id_pasien = cell2.innerHTML;
                var nama_pasien = cell3.innerHTML;
                var status = cell9.innerHTML;
                if (status == 'antrian') {
                    Swal.fire({
                        title: 'Yakin Apakan Anda ingin Menghapus Data Antrian ini ?',
                        text: "Data Antrian " + no_antrian + " Akan dihapus !",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Hapus Data !',
                        cancelButtonText: 'Tidak'
                    }).then((result) => {
                        if (result.value) {
                            $.ajax({
                                url: "/kunjungan/delete",
                                data: {
                                    no_antrian: no_antrian,
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
                } else {
                    swal.fire({
                        title: 'Mohon Perhatian!',
                        text: 'No Antrian dengan ' + no_antrian + ' Sudah Dilakukan Diagnosa Seblumnya !',
                        type: 'warning',
                        confirmButtonClass: 'btn btn-danger',
                    })
                }
            };
        };
        currentRow.onclick = createClickHandler(currentRow);
    }
}


function diagnosa_pasien_dokter() {
    var table = document.getElementById("table-transaksi-kunjungan");
    var rows = table.getElementsByTagName("tr");
    for (i = 0; i < rows.length; i++) {
        var currentRow = table.rows[i];
        var createClickHandler = function (row) {
            return function () {
                var cell1 = row.getElementsByTagName("td")[2];
                var cell2 = row.getElementsByTagName("td")[3];
                var cell3 = row.getElementsByTagName("td")[4];
                var cell9 = row.getElementsByTagName("td")[9];
                var no_antrian = cell1.innerHTML;
                var id_pasien = cell2.innerHTML;
                var nama_pasien = cell3.innerHTML;
                var status = cell9.innerHTML;
                if (status == 'antrian') {
                    $("#my-modal-diagnosa").modal("show");
                    document.getElementById("title_diagnosa").innerHTML = "Diagnosa - " + no_antrian;
                    document.getElementById("no_antrian").innerHTML = no_antrian;
                    document.getElementById("id_pasien").innerHTML = id_pasien;
                    document.getElementById("nama_pasien").innerHTML = nama_pasien;
                } else {
                    swal.fire({
                        title: 'Mohon Perhatian!',
                        text: 'No Antrian dengan ' + no_antrian + ' Sudah Dilakukan Diagnosa Seblumnya !',
                        type: 'warning',
                        confirmButtonClass: 'btn btn-danger',
                    })
                }
            };
        };
        currentRow.onclick = createClickHandler(currentRow);
    }
}


function simpan_diagnosa() {
    $('.button-prevent').attr('disabled', 'true');
    $('.spinner').show();
    $('.hide-text').hide();
    var no_antrian = document.getElementById("no_antrian").innerHTML;
    var id_pasien = document.getElementById("id_pasien").innerHTML;
    var nama_pasien = document.getElementById("nama_pasien").innerHTML;
    var diagnosa = $("#diagnosa").val();
    var resep = $("#resep").val();
    var cmb_pic = document.getElementById("cmb_pic");
    var cmb_pic_value = cmb_pic.options[cmb_pic.selectedIndex].value;
    var cmb_pic_text = cmb_pic.options[cmb_pic.selectedIndex].text;

    var img1 = document.getElementById("input-file-now file1").value;
    var img2 = document.getElementById("input-file-now file2").value;
    var img3 = document.getElementById("input-file-now file3").value;
    var img4 = document.getElementById("input-file-now file4").value;
    if (diagnosa == '' || resep == '' || cmb_pic_value == '') {
        swal.fire({
            title: 'Opps!',
            text: 'Harap Wajib Filed - Field Teersedia !',
            type: 'warning',
            confirmButtonClass: 'btn btn-danger',
        })
    } else if (img1 == '' || img2 == '' || img3 == '' || img4 == '') {
        swal.fire({
            title: 'Opps!',
            text: 'Jangan Lupa Wajib Upload Dokumentasi Photo!',
            type: 'warning',
            confirmButtonClass: 'btn btn-danger',
        })
    } else {
        var formupload = document.getElementById("form_diagnosa");
        var formdata = new FormData(formupload);
        formdata.append("no_antrian", no_antrian);
        formdata.append("id_pasien", id_pasien);
        formdata.append("nama_pasien", nama_pasien);
        formdata.append("id_sdm", cmb_pic_value);
        formdata.append("sdm", cmb_pic_text);
        $.ajax({
            url: "/transaksi/kunjungan/add_diagnosa",
            type: "POST",
            denctype: "multipart/form-data",
            processData: false, // tell jQuery not to process the data
            contentType: false,
            data: formdata,
            dataType: "json",
            success: function (data) {
                if (data.status == "success") {
                    Swal.fire({
                        title: "Good Luck !",
                        text: " Data Berhasil Disimpan !",
                        type: "success",
                        confirmButtonClass: 'btn btn-success',
                    }).then((result) => {
                        if (result.value) {
                            document.location.reload();
                        }
                    });
                }
            }
        });
    }
}


// Transaksi Treatment
function call_add_transaksi_treat() {
    $("#my-modal-addtreat").modal("show");
}

function awal_treat1() {
    document.getElementById("cmb_treat").value = "";
    document.getElementById("kode_ref").value = "";
    document.getElementById("harga").value = "";
    document.getElementById("qty_treat").value = 0;
    document.getElementById("subtotal_treat").value = 0;
    document.getElementById("potongan_treat").value = 0;
    document.getElementById("jlh_pot_treat").value = 0;
    document.getElementById("jlh_disc_treat").value = 0;
    document.getElementById("desc_treat").value = "";
}

function awal_prod1() {
    document.getElementById("cmb_prod").value = "";
    document.getElementById("kode_ref_prod").value = "";
    document.getElementById("satuan_prod").value = "";
    document.getElementById("harga_prod").value = "";
    document.getElementById("qty_prod").value = "";
    document.getElementById("stok_prod").value = "";
    document.getElementById("after_stok_prod").value = "";
    document.getElementById("subs_prod").value = "";
    document.getElementById("pot_prod").value = "0";
    document.getElementById("nominal_pot_prod").value = "0";
    document.getElementById("nominal_disc_prod").value = "0";
}


function onChangeTreat() {
    var cmb_treat = document.getElementById("cmb_treat");
    var cmb_treat_value = cmb_treat.options[cmb_treat.selectedIndex].value;
    $.ajax({
        url: "/transaksi/treatment/value_treat",
        type: "POST",
        data: {
            id_treat: cmb_treat_value,
        },
        dataType: "json",
        success: function (data) {
            const harga = data.harga;
            $("#kode_ref").val(data.kode);
            $("#harga").val(new Intl.NumberFormat('id-ID').format(harga));
            $("#qty_treat").val(1);
            $("#subtotal_treat").val((new Intl.NumberFormat('id-ID').format(data.harga * 1)));
        }
    });
}

function onChangeMetodeBayar() {
    var cmb_metode = document.getElementById("cmb_metode_byr");
    var cmb_metode_value = cmb_metode.options[cmb_metode.selectedIndex].value;
    var x = document.getElementById("debit");
    if (cmb_metode_value == "Debit ATM") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}


function onChangeQtyTreatment() {
    var qty_treat = $("#qty_treat").val();
    var harga = $("#harga").val();
    const harga_rpl = harga.replace('.', '');
    const subs = qty_treat * harga_rpl;
    var subs2 = new Intl.NumberFormat().format(subs);
    document.getElementById("subtotal_treat").value = subs2;
}

function OnChangeJlhPotonganTreat() {
    var qty_treat = $("#qty_treat").val();
    var harga = $("#harga").val();
    var potongan = $("#jlh_pot_treat").val();
    const harga_rpl = harga.replace('.', '');
    const subs = qty_treat * harga_rpl;
    const hasil = subs - potongan;
    var subs2 = new Intl.NumberFormat().format(hasil);
    var subs3 = new Intl.NumberFormat().format(potongan);
    document.getElementById("subtotal_treat").value = subs2;
    document.getElementById("potongan_treat").value = subs3;
}

function OnChangeJlhDiscTreat() {
    const jlhdis = $("#jlh_disc_treat").val();
    const jlh_disc_treat = jlhdis / 100;

    var qty_treat = $("#qty_treat").val();
    var harga = $("#harga").val();
    var potongan = $("#jlh_pot_treat").val();
    const harga_rpl = harga.replace('.', '');
    const subs = qty_treat * harga_rpl;
    const pot = subs * jlh_disc_treat;
    const hasil = subs - pot;
    var subs2 = new Intl.NumberFormat().format(hasil);
    var subs3 = new Intl.NumberFormat().format(pot);
    document.getElementById("subtotal_treat").value = subs2;
    document.getElementById("potongan_treat").value = subs3;
}

function masukkan_list_treat() {
    var kode_ref = $("#kode_ref").val();
    var cmb_treat = document.getElementById("cmb_treat");
    var cmb_treat_value = cmb_treat.options[cmb_treat.selectedIndex].value;
    var cmb_treat_text = cmb_treat.options[cmb_treat.selectedIndex].text;
    var harga = $("#harga").val();
    var qty_treat = $("#qty_treat").val();
    var subtotal_treat = $("#subtotal_treat").val();
    var potongan = $("#potongan_treat").val();
    var description = $("#desc_treat").val();
    var table = document.getElementById("tbody-list-tretment");
    for (var i = 0; i < table.rows.length; i++) {
        if (table.rows[i].cells[1].innerHTML == kode_ref) {
            swal.fire({
                type: "error",
                title: "Mohon Maaf !",
                text: "Data Treatment " + cmb_treat_text + " Sudah Ada List !",
            });
            return false;
        }
    }
    var x = table.insertRow(0);
    var c1 = x.insertCell(0);
    var c2 = x.insertCell(1);
    var c3 = x.insertCell(2);
    var c4 = x.insertCell(3);
    var c5 = x.insertCell(4);
    var c6 = x.insertCell(5);
    var c7 = x.insertCell(6);
    var c8 = x.insertCell(7);
    c1.innerHTML = '<button type="button" class="btn btn-md btn-danger" onclick="delete_list_treat(this)"><i class ="fa fa-trash"></i></button >';
    c2.innerHTML = kode_ref;
    c3.innerHTML = cmb_treat_text;
    c4.innerHTML = harga;
    c5.innerHTML = qty_treat;
    c6.innerHTML = subtotal_treat;
    c7.innerHTML = potongan;
    c8.innerHTML = description;
    SummarryTreatment();
    summaryAllTotal();
    awal_treat1();
}

function SummarryTreatment() {
    var table = document.getElementById("tbody-list-tretment");
    var sumVal = 0;
    var sumPot = 0;
    for (var i = 0; i < table.rows.length; i++) {
        var su = table.rows[i].cells[5].innerHTML;
        var po = table.rows[i].cells[6].innerHTML
        sumVal = sumVal + su.replace(',', '').replace('.', '');
        sumPot = sumPot + po.replace(',', '').replace('.', '');
    }
    document.getElementById("total_treat").innerHTML = new Intl.NumberFormat().format(sumVal);
    document.getElementById("total_pot_treat").innerHTML = new Intl.NumberFormat().format(sumPot);
}

function delete_list_treat(btn) {
    var row = btn.parentNode.parentNode;
    row.parentNode.removeChild(row);
    SummarryTreatment();
    summaryAllTotal();
    if (document.getElementById("tbody-list-tretment").rows.length === 0) {
        document.getElementById("total_treat").innerHTML = 0;
        document.getElementById("total_pot_treat").innerHTML = 0;
    } else { }
}

// Product

function onChangeProduct() {
    var cmb_prod = document.getElementById("cmb_prod");
    var cmb_prod_value = cmb_prod.options[cmb_prod.selectedIndex].value;
    var cmb_prod_text = cmb_prod.options[cmb_prod.selectedIndex].text;
    $.ajax({
        url: "/transaksi/treatment/value_prod",
        type: "POST",
        data: {
            id_prod: cmb_prod_value,
        },
        dataType: "json",
        success: function (data) {
            const harga = data.harga;
            const subs = 1 * data.harga;
            $("#kode_ref_prod").val(data.kode);
            $("#satuan_prod").val(data.satuan);
            $("#qty_prod").val(1);
            $("#harga_prod").val(new Intl.NumberFormat('id-ID').format(harga));
            $("#stok_prod").val(data.qty);
            $("#subs_prod").val(new Intl.NumberFormat('id-ID').format(subs));
        }
    });
}

function onChangeQtyProduct() {
    var qty_prod = $("#qty_prod").val();
    var harga = $("#harga_prod").val();
    const harga_rpl = harga.replace('.', '').replace(',', '');
    const subs = qty_prod * harga_rpl;
    var subs2 = new Intl.NumberFormat().format(subs);
    const stok = $("#stok_prod").val();
    const after_stok = stok - qty_prod;
    document.getElementById("subs_prod").value = subs2;
    document.getElementById("after_stok_prod").value = after_stok;
}

function InputPotonganProd() {
    var qty_prod = $("#qty_prod").val();
    var harga = $("#harga_prod").val();
    const harga_rpl = harga.replace('.', '').replace(',', '');
    const pot = $("#nominal_pot_prod").val();
    const subs = (qty_prod * harga_rpl) - pot;
    var subs2 = new Intl.NumberFormat().format(subs);
    var pot2 = new Intl.NumberFormat().format(pot);
    document.getElementById("subs_prod").value = subs2;
    document.getElementById("pot_prod").value = pot2;
}

function InputDiscProd() {
    var qty_prod = $("#qty_prod").val();
    var harga = $("#harga_prod").val();
    const harga_rpl = harga.replace('.', '').replace(',', '');
    const jlh_disc = $("#nominal_disc_prod").val();
    const pot = (jlh_disc / 100) * (qty_prod * harga_rpl);
    const subs = (qty_prod * harga_rpl) - pot;
    var subs2 = new Intl.NumberFormat().format(subs);
    var pot2 = new Intl.NumberFormat().format(pot);
    document.getElementById("subs_prod").value = subs2;
    document.getElementById("pot_prod").value = pot2;
}

function masukkan_list_prod() {
    var kode_ref_prod = $("#kode_ref_prod").val();
    var cmb_prod = document.getElementById("cmb_prod");
    var cmb_prod_text = cmb_prod.options[cmb_prod.selectedIndex].text;
    var satuan = $("#satuan_prod").val();
    var harga = $("#harga_prod").val();
    var qty = $("#qty_prod").val();
    var subtotal = $("#subs_prod").val();
    var potongan = $("#pot_prod").val();

    var table2 = document.getElementById("tbody-list-product");
    for (var i = 0; i < table2.rows.length; i++) {
        if (table2.rows[i].cells[1].innerHTML == kode_ref_prod) {
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
    c1.innerHTML = '<button type="button" class="btn btn-md btn-danger" onclick="delete_list_prod(this)"><i class ="fa fa-trash"></i></button >';
    c2.innerHTML = kode_ref_prod;
    c3.innerHTML = cmb_prod_text;
    c4.innerHTML = satuan;
    c5.innerHTML = harga;
    c6.innerHTML = qty;
    c7.innerHTML = subtotal;
    c8.innerHTML = potongan;
    c9.innerHTML = "-";
    awal_prod1();
    SummarryProd();
    summaryAllTotal();
}

function SummarryProd() {
    var table = document.getElementById("tbody-list-product");
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
    document.getElementById("total_prod").innerHTML = new Intl.NumberFormat().format(sumVal);
    document.getElementById("total_pot_prod").innerHTML = new Intl.NumberFormat().format(sumPot);
    document.getElementById("qty_prod_sale").innerHTML = new Intl.NumberFormat().format(qty);
}

function delete_list_prod(btn) {
    var row = btn.parentNode.parentNode;
    row.parentNode.removeChild(row);
    SummarryProd();
    summaryAllTotal();
    if (document.getElementById("tbody-list-product").rows.length === 0) {
        document.getElementById("total_prod").innerHTML = 0;
        document.getElementById("total_pot_prod").innerHTML = 0;
    } else { }
}

function OnChangeNoAntrian() {
    var cmb_no_antrian = document.getElementById("cmb_antrian");
    var cmb_no_antrian_value = cmb_no_antrian.options[cmb_no_antrian.selectedIndex].value;
    if (cmb_no_antrian_value != "") {
        $.ajax({
            url: "/transaksi/treatment/get_no_antrian",
            type: "POST",
            data: {
                no_antrian: cmb_no_antrian_value,
            },
            dataType: "json",
            success: function (data) {
                if (data.id_pasien != "") {
                    document.getElementById("pasien_id").innerHTML = data.id_pasien;
                    document.getElementById("nama_pasien").innerHTML = data.nama;
                    $("#cat_anamnesa").val(data.catatan_anamnesa);
                    $("#cat_resep").val(data.catatan_obat);
                } else if (data == null || data.id_pasien == '') {
                    document.getElementById("pasien_id").innerHTML = "-";
                    document.getElementById("nama_pasien").innerHTML = "-";
                    $("#cat_anamnesa").val("");
                    $("#cat_resep").val("");
                }
            }
        });
    } else {
        document.getElementById("pasien_id").innerHTML = "-";
        document.getElementById("nama_pasien").innerHTML = "-";
        $("#cat_anamnesa").val("");
        $("#cat_resep").val("");
    }

}

function hanyaAngka(event) {
    var angka = (event.which) ? event.which : event.keyCode
    if (angka != 46 && angka > 31 && (angka < 48 || angka > 57))
        return false;
    return true;
}

$("#nominal_bayar").keyup(function () {
    if ($("#nominal_bayar").val().length == 4) {
        var my_val = $("#nominal_bayar").val();
        $("#nominal_bayar").val(Number(my_val).toLocaleString('en'));
    }
});

function summaryAllTotal() {
    var total1 = parseFloat(document.getElementById("total_treat").innerText.replace(',', '')) + parseInt(document.getElementById("total_prod").innerText.replace(',', ''));
    var potongan1 = parseFloat(document.getElementById("total_pot_treat").innerText.replace(',', '')) + parseInt(document.getElementById("total_pot_prod").innerText.replace(',', ''));
    var qty = parseFloat(document.getElementById("qty_prod_sale").innerText.replace(',', '').replace('.', ''));
    document.getElementById("total_bel").innerHTML = new Intl.NumberFormat().format(total1);
    document.getElementById("total_pot_bel").innerHTML = new Intl.NumberFormat().format(potongan1);
    document.getElementById("total_qty_bel").innerHTML = new Intl.NumberFormat().format(qty);
}


$("#nominal_bayar").keyup(function (event) {
    if (event.keyCode === 13) {
        var dibayar = $("#nominal_bayar").val();
        var jlhsub = document.getElementById("total_bel").innerText.replace(',', '');
        // alert(dibayar)
        if (dibayar.replace('.', '').replace(',', '.') > 0) {
            var hasil = parseInt(dibayar.replace('.', '').replace(',', '.')) - parseInt(jlhsub);
        } else {
            swal.fire({
                type: "error",
                title: "Mohon Maaf !",
                text: "Data Jumlah Nominal Anda Masih Belum Cukup !",
            });
        }
        document.getElementById("kembalian_harga").innerHTML = new Intl.NumberFormat().format(hasil);
    }
});

// Simpan Transaksi

function simpan_transaksi() {
    $('.button-prevent').attr('disabled', 'true');
    $('.spinner').show();
    $('.hide-text').hide();
    var transaksi_id = document.getElementById("id_transaksi").innerHTML;
    var cmb_no_antrian = document.getElementById("cmb_antrian");
    var cmb_no_antrian_value = cmb_no_antrian.options[cmb_no_antrian.selectedIndex].value;
    var id_pasien = document.getElementById("pasien_id").innerHTML;
    var qty = document.getElementById("total_qty_bel").innerHTML.replace(',', '').replace('.', '');
    var subtotal = document.getElementById("total_bel").innerHTML.replace(',', '').replace('.', '');
    var potongan = document.getElementById("total_pot_bel").innerHTML.replace(',', '').replace('.', '');
    var desc_pot = document.getElementById("catatan_tr").innerHTML.replace(',', '').replace('.', '');
    var cmb_metode = document.getElementById("cmb_metode_byr");
    var cmb_metode_value = cmb_metode.options[cmb_metode.selectedIndex].value;
    var jumlah_dibayar = $("#nominal_bayar").val().replace('.', '').replace('.', '');
    var kembalian = document.getElementById("kembalian_harga").innerHTML.replace('.', '').replace('.', '');
    if (jumlah_dibayar == '' || jumlah_dibayar == 0 || subtotal == 0) {
        {
            swal.fire({
                type: "warning",
                title: "Mohon Maaf !",
                text: "Transaksi Anda Belom Tersedia !",
            })
        }
    } else {
        if (cmb_metode_value == "Debit ATM") {
            detail_transaksi1()
            detail_transaksi2()
            pay_debit()
        } else {
            detail_transaksi1()
            detail_transaksi2()
            pay_cash()
        }
    }
}

function pay_cash() {
    var transaksi_id = document.getElementById("id_transaksi").innerHTML;
    var cmb_no_antrian = document.getElementById("cmb_antrian");
    var cmb_no_antrian_value = cmb_no_antrian.options[cmb_no_antrian.selectedIndex].value;
    var id_pasien = document.getElementById("pasien_id").innerHTML;
    var qty = document.getElementById("total_qty_bel").innerHTML.replace(',', '').replace('.', '');
    var subtotal = document.getElementById("total_bel").innerHTML.replace(',', '').replace('.', '');
    var potongan = document.getElementById("total_pot_bel").innerHTML.replace(',', '').replace('.', '');
    var desc_pot = document.getElementById("catatan_tr").innerHTML.replace(',', '').replace('.', '');
    var cmb_metode = document.getElementById("cmb_metode_byr");
    var cmb_metode_value = cmb_metode.options[cmb_metode.selectedIndex].value;
    var jumlah_dibayar = $("#nominal_bayar").val().replace('.', '').replace('.', '');
    var kembalian = document.getElementById("kembalian_harga").innerText.replace(',', '').replace('.', '');
    // alert(kembalian);
    $.ajax({
        url: "/transaksi/treatment/pay_transaksi",
        type: "POST",
        data: {
            transaksi_id: transaksi_id,
            no_antrian: cmb_no_antrian_value,
            pasien_id: id_pasien,
            qty: qty,
            subtotal: subtotal,
            potongan: potongan,
            desc_pot: desc_pot,
            metode_bayar: cmb_metode_value,
            jumlah_dibayar: jumlah_dibayar,
            kembalian: kembalian,
        },
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

function pay_debit() {
    var transaksi_id = document.getElementById("id_transaksi").innerHTML;
    var cmb_no_antrian = document.getElementById("cmb_antrian");
    var cmb_no_antrian_value = cmb_no_antrian.options[cmb_no_antrian.selectedIndex].value;
    var id_pasien = document.getElementById("pasien_id").innerHTML;
    var qty = document.getElementById("total_qty_bel").innerHTML.replace(',', '').replace('.', '');
    var subtotal = document.getElementById("total_bel").innerHTML.replace(',', '').replace('.', '');
    var potongan = document.getElementById("total_pot_bel").innerHTML.replace(',', '').replace('.', '');
    var desc_pot = $("#catatan_tr").val();
    var cmb_metode = document.getElementById("cmb_metode_byr");
    var cmb_metode_value = cmb_metode.options[cmb_metode.selectedIndex].value;
    var jumlah_dibayar = $("#nominal_bayar").val().replace('.', '').replace('.', '');
    var kembalian = document.getElementById("kembalian_harga").innerText.replace(',', '').replace('.', '');
    var no_transaksi_debit = $("#no_transaksi_debit").val();
    let img = document.getElementById("input-file-now img_bukti").files[0];


    let form_data = new FormData();
    form_data.append("img", img);
    form_data.append("id_transaksi", transaksi_id);
    form_data.append("no_antrian", cmb_no_antrian_value);
    form_data.append("pasien_id", id_pasien);
    form_data.append("qty", qty);
    form_data.append("subtotal", subtotal);
    form_data.append("potongan", potongan);
    form_data.append("deskripsi", desc_pot);
    form_data.append("metode_bayar", cmb_metode_value);
    form_data.append("jumlah_dibayar", jumlah_dibayar);
    form_data.append("kembalian", kembalian);
    form_data.append("no_debit", no_transaksi_debit);
    $.ajax({
        url: "/transaksi/treatment/pay_transaksi_debit",
        type: "POST",
        enctype: 'multipart/form-data',
        processData: false,  // tell jQuery not to process the data
        contentType: false,
        data: form_data,
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

function detail_transaksi1() {
    var transaksi_id = document.getElementById("id_transaksi").innerHTML;
    var id_pasien = document.getElementById("pasien_id").innerHTML;
    var cmb_no_antrian = document.getElementById("cmb_antrian");
    var cmb_no_antrian_value = cmb_no_antrian.options[cmb_no_antrian.selectedIndex].value;
    var table = document.getElementById("tbody-list-tretment");
    var sumVal = 0;
    var sumPot = 0;
    var hrg = 0;
    for (var i = 0; i < table.rows.length; i++) {
        var kode = table.rows[i].cells[1].innerHTML;
        var nama = table.rows[i].cells[2].innerHTML;
        var harga = table.rows[i].cells[3].innerHTML.replace('.', '').replace(',', '');
        var qty = table.rows[i].cells[4].innerHTML.replace('.', '').replace(',', '');
        var su = table.rows[i].cells[5].innerHTML.replace('.', '').replace(',', '');
        var po = table.rows[i].cells[6].innerHTML.replace('.', '').replace(',', '');
        $.ajax({
            url: "/transaksi/treatment/pay_transaksi_detail_treat",
            type: "POST",
            data: {
                transaksi_id: transaksi_id,
                no_antrian: cmb_no_antrian_value,
                pasien_id: id_pasien,
                kode: kode,
                treatment: nama,
                harga: harga,
                qty: qty,
                subtotal: su,
                potongan: po,
            },
            dataType: "json",
        });
    }
}

function detail_transaksi2() {
    var transaksi_id = document.getElementById("id_transaksi").innerHTML;
    var id_pasien = document.getElementById("pasien_id").innerHTML;
    var cmb_no_antrian = document.getElementById("cmb_antrian");
    var cmb_no_antrian_value = cmb_no_antrian.options[cmb_no_antrian.selectedIndex].value;
    var table = document.getElementById("tbody-list-product");
    for (var i = 0; i < table.rows.length; i++) {
        var kode = table.rows[i].cells[1].innerHTML;
        var nama = table.rows[i].cells[2].innerHTML;
        var satuan = table.rows[i].cells[3].innerHTML;
        var harga = table.rows[i].cells[4].innerHTML.replace('.', '').replace(',', '');
        var qty = table.rows[i].cells[5].innerHTML.replace('.', '').replace(',', '');
        var su = table.rows[i].cells[6].innerHTML.replace('.', '').replace(',', '');
        var po = table.rows[i].cells[7].innerHTML.replace('.', '').replace(',', '');
        $.ajax({
            url: "/transaksi/treatment/pay_transaksi_detail_prod",
            type: "POST",
            data: {
                transaksi_id: transaksi_id,
                no_antrian: cmb_no_antrian_value,
                pasien_id: id_pasien,
                kode: kode,
                nama: nama,
                satuan: satuan,
                harga: harga,
                qty: qty,
                subtotal: su,
                potongan: po,
            },
            dataType: "json",
        });
    }
}

function cetak_struk(no_transaksi) {
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
                url: "/transaksi/treatment/invoice",
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

function list_transaksi(transaksi_id, datenow) {
    $("#my-modal-list").modal("show");
    document.getElementById("title-transaksi").innerHTML = transaksi_id;
    document.getElementById("title-date").innerHTML = datenow;
    $.ajax({
        url: "/transaksi/treatment/list_transaksi",
        type: "POST",
        data: {
            transaksi_id: transaksi_id,
        },
        dataType: "json",
        success: function (data) {
            document.getElementById("list_id_pasien").innerHTML = data.transaksi_id;
            document.getElementById("list_nama_pasien").innerHTML = data.nama;
            document.getElementById("list_nik").innerHTML = data.nik;
            document.getElementById("list_antrian").innerHTML = data.no_antrian;
            document.getElementById("list_metode_bayar").innerHTML = data.metode_bayar;
            document.getElementById("list_jumlah_dibayar").innerHTML = "Rp." + new Intl.NumberFormat().format(data.jumlah_dibayar);
            document.getElementById("list_kembalian").innerHTML = "Rp." + new Intl.NumberFormat().format(data.kembalian);
            document.getElementById("list_qty").innerHTML = new Intl.NumberFormat().format(data.qty);
            document.getElementById("list_subtotal").innerHTML = "Rp." + new Intl.NumberFormat().format(data.subtotal);

            // treatment
            var tbody1 = document.getElementById('list-treat-tbody');
            var tr1 = '';
            for (var i in data.treatment) {
                tr1 += `<tr>
                <td align="center">${data.treatment[i].kode}</td>
                <td>${data.treatment[i].treatment}</td>
                <td>${data.treatment[i].harga}</td>
                <td>${data.treatment[i].qty}</td>
                <td>${data.treatment[i].subtotal}</td>
                <td>${data.treatment[i].potongan}</td>
                <td>${data.treatment[i].desc}</td>
            </tr>`;
            }
            tbody1.innerHTML = tr1;

            // Product
            var tbody2 = document.getElementById('list_prod_tbody');
            var tr2 = '';
            for (var i in data.product) {
                tr2 += `<tr>
                <td align="center">${data.product[i].kode}</td>
                <td>${data.product[i].nama}</td>
                <td>${data.product[i].harga}</td>
                <td>${data.product[i].qty}</td>
                <td>${data.product[i].subtotal}</td>
                <td>${data.product[i].potongan}</td>
                <td>${data.product[i].desc}</td>
            </tr>`;
            }
            tbody2.innerHTML = tr2;
        }
    });
}