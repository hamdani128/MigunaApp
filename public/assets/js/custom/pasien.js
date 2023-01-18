$(document).ready(function () {
    // var no = 1;
    $('#table-pasien-admin').DataTable({
        ajax: {
            url: "/pasien/admin/getdata",
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
});

function simpan_data_pasien_by_admin() {
    var nik = $("#nik").val();
    var nama = $("#nama").val();
    var usia = $("#usia").val();
    var alamat = $("#alamat").val();
    var cmb_jk = document.getElementById("jk").value;
    var pekerjaan = $("#pekerjaan").val();
    var hp = $("#hp").val();
    var registri = $("#registri").val();

    if (nik == '' || nama == '' || usia == '' || alamat == '' || cmb_jk == '' || pekerjaan == '' || hp == '' || registri == '') {
        swal.fire(
            {
                title: 'Opps!',
                text: 'Harap Wajib Filed - Field Teersedia !',
                type: 'warning',
                confirmButtonClass: 'btn btn-danger',
            }
        )
    } else {
        $.ajax({
            url: "/pasien/admin/insert",
            type: "POST",
            data: {
                nik: nik,
                nama: nama,
                usia: usia,
                alamat: alamat,
                jk: cmb_jk,
                pekerjaan: pekerjaan,
                hp: hp,
                registri: registri,
            },
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


function edit_admin_pasien() {
    var table = document.getElementById("table-pasien-admin");
    var rows = table.getElementsByTagName("tr");
    for (i = 0; i < rows.length; i++) {
        var currentRow = table.rows[i];
        var createClickHandler = function (row) {
            return function () {
                var cell = row.getElementsByTagName("td")[2];
                var id_pasien = cell.innerHTML;
                $.ajax({
                    url: "/pasien/admin/edit_show",
                    data: {
                        id_pasien: id_pasien,
                    },
                    type: "POST",
                    dataType: "json",
                    success: function (data) {
                        $("#my-modal-edit").modal('show');
                        $("#id_pasien_update").val(id_pasien);
                        $("#nik_update").val(data.nik);
                        $("#nama_update").val(data.nama);
                        $("#usia_update").val(data.usia);
                        $("#alamat_update").val(data.alamat);
                        $("#jk_update").val(data.jk);
                        $("#pekerjaan_update").val(data.pekerjaan);
                        $("#hp_update").val(data.hp);
                        $("#registri_update").val(data.registri);
                    }
                });
            };
        };
        currentRow.onclick = createClickHandler(currentRow);
    }
}

function update_data_pasien_by_admin() {
    var id_pasien = $("#id_pasien_update").val();
    var nik = $("#nik_update").val();
    var nama = $("#nama_update").val();
    var usia = $("#usia_update").val();
    var alamat = $("#alamat_update").val();
    var cmb_jk = document.getElementById("jk_update").value;
    var pekerjaan = $("#pekerjaan_update").val();
    var hp = $("#hp_update").val();
    var registri = $("#registri_update").val();
    $.ajax({
        url: "/pasien/admin/update",
        type: "POST",
        data: {
            id_pasien: id_pasien,
            nik: nik,
            nama: nama,
            usia: usia,
            alamat: alamat,
            jk: cmb_jk,
            pekerjaan: pekerjaan,
            hp: hp,
            registri: registri,
        },
        dataType: "json",
        success: function (data) {
            if (data.status == "success") {
                Swal.fire({
                    title: "Good Luck !",
                    text: " Data Berhasil Dirubah !",
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

function delete_admin_pasien() {
    var table = document.getElementById("table-pasien-admin");
    var rows = table.getElementsByTagName("tr");
    for (i = 0; i < rows.length; i++) {
        var currentRow = table.rows[i];
        var createClickHandler = function (row) {
            return function () {
                var cell = row.getElementsByTagName("td")[2];
                var id_pasien = cell.innerHTML;
                Swal.fire({
                    title: 'Yakin Apakan Anda ingin Menghapus Data ini ?',
                    text: "Data Pasien " + id_pasien + " Akan dihapus !",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus Data !',
                    cancelButtonText: 'Tidak'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "/pasien/admin/delete",
                            data: {
                                id_pasien: id_pasien,
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
            };
        };
        currentRow.onclick = createClickHandler(currentRow);
    }
}

function antrian_pasien_admin() {
    var table = document.getElementById("table-pasien-admin");
    var rows = table.getElementsByTagName("tr");
    for (i = 0; i < rows.length; i++) {
        var currentRow = table.rows[i];
        var createClickHandler = function (row) {
            return function () {
                var cell1 = row.getElementsByTagName("td")[2];
                var cell2 = row.getElementsByTagName("td")[4];
                var id_pasien = cell1.innerHTML;
                var Nama_Pasien = cell2.innerHTML;
                $("#my-modal-antrian").modal('show');
                $("#id_pasien").val(id_pasien);
                $("#nama_pasien").val(Nama_Pasien);
            };
        };
        currentRow.onclick = createClickHandler(currentRow);
    }
}


function masukan_antrian_data_pasien_by_admin() {
    var no_kunjungan = document.getElementById('no_kunjungan').innerHTML;
    var id_pasien = $("#id_pasien").val();
    var nama_pasien = $("#nama_pasien").val();
    var catatan = $("#catatan").val();
    if (id_pasien == '' || nama_pasien == '' || catatan == '') {
        swal.fire(
            {
                title: 'Opps!',
                text: 'Harap Wajib Filed - Field Tersedia !',
                type: 'warning',
                confirmButtonClass: 'btn btn-danger',
            }
        )
    } else {
        $.ajax({
            url: "/pasien/admin/antrian_kunjungan",
            data: {
                id_pasien: id_pasien,
                no_kunjungan: no_kunjungan,
                nama_pasien: nama_pasien,
                catatan: catatan,
            },
            type: "POST",
            dataType: "json",
            success: function (data) {
                if (data.status == 'success') {
                    Swal.fire(
                        'Berhasil !',
                        'Data Berhasil Dimasukkan Ke Antrian !',
                        'success'
                    )
                    document.location.reload();
                } else if (data.status == 'anyway') {
                    swal.fire(
                        {
                            title: 'Opps!',
                            text: 'Harap Pasien ini Sudah Terdaftar Kedalam Antrian !',
                            type: 'warning',
                            confirmButtonClass: 'btn btn-success',
                        }
                    )
                }
            }
        });
    }
}


function riwayat_transaksi_kunjungan_pasien() {
    var table = document.getElementById("table-pasien-admin");
    var rows = table.getElementsByTagName("tr");
    for (i = 0; i < rows.length; i++) {
        var currentRow = table.rows[i];
        var createClickHandler = function (row) {
            return function () {
                var cell1 = row.getElementsByTagName("td")[2];
                var cell2 = row.getElementsByTagName("td")[4];
                var id_pasien = cell1.innerHTML;
                var nama = cell2.innerHTML;
                document.getElementById("my-titla-riwayat").innerHTML = "No.ID Pasein : " + id_pasien + " | " + nama;
                document.getElementById("img1").src = "/assets/images/small/img-1.jpg";
                document.getElementById("img2").src = "/assets/images/small/img-1.jpg";
                document.getElementById("img3").src = "/assets/images/small/img-1.jpg";
                document.getElementById("img4").src = "/assets/images/small/img-1.jpg";
                $("#riwayat_catatan").val("");
                $("#riwayat_catatan_resep").val("");
                var tbody1 = document.getElementById('tbody-list-treat-riw');
                var tr1 = "";
                tbody1.innerHTML = tr1;
                var tbody2 = document.getElementById('tbody-list-prod-riw');
                var tr2 = '';
                tbody2.innerHTML = tr2;
                $("#my-modal-riwayat").modal("show");

                $('#table-transaksi-riwayat').DataTable().destroy();
                $('#table-transaksi-riwayat').DataTable({
                    "ajax": {
                        "url": "/transaksi/kunjungan/riwayat_tanggal/" + id_pasien,
                        "dataSrc": "",
                    },
                    "columns": [
                        { "data": "no" },
                        { "data": "action" },
                        { "data": "tanggal" },
                        { "data": "id_pasien" },
                    ],
                });

            };
        };
        currentRow.onclick = createClickHandler(currentRow);
    }
}