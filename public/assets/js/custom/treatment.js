$(document).ready(function () {
    $('#table-treatment').DataTable({
        "ajax": {
            "url": "/treatment/admin/getdata",
            "dataSrc": "",
        },
        "columns": [
            { "data": "no" },
            { "data": "action" },
            { "data": "id_treat" },
            { "data": "nama" },
            { "data": "harga" },
            { "data": "kategori" },
            { "data": "created_at" }
        ],
    });
});


function simpan_data_treatment() {
    var id_treat = document.getElementById('id_treat').innerHTML;
    var nama = $("#nama").val();
    var harga = $("#harga").val();
    var kategori = $("#kategori").val();
    if (id_treat == "" || harga == "" || kategori == "") {
        swal.fire(
            {
                title: 'Opps!',
                text: 'Harap Wajib Filed - Field Teersedia !',
                type: 'warning',
                confirmButtonClass: 'btn btn-danger',
            })
    } else {
        $.ajax({
            url: "/treatment/admin/insert",
            type: "POST",
            data: {
                id_treat: id_treat,
                nama: nama,
                harga: harga,
                kategori: kategori,
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

function edit_admin_treatment() {
    var table = document.getElementById("table-treatment");
    var rows = table.getElementsByTagName("tr");
    for (i = 0; i < rows.length; i++) {
        var currentRow = table.rows[i];
        var createClickHandler = function (row) {
            return function () {
                var cell = row.getElementsByTagName("td")[2];
                var id_treat = cell.innerHTML;
                $.ajax({
                    url: "/treatment/admin/edit_show",
                    data: {
                        id_treat: id_treat,
                    },
                    type: "POST",
                    dataType: "json",
                    success: function (data) {
                        $("#my-modal-edit").modal('show');
                        document.getElementById('id_treat_update').innerHTML = data.id_treat;
                        $("#nama_update").val(data.nama);
                        $("#harga_update").val(data.harga);
                        $("#kategori_update").val(data.kategori);
                    }
                });
            };
        };
        currentRow.onclick = createClickHandler(currentRow);
    }
}

function update_data_treatment_byadmin() {
    var id_treat = document.getElementById('id_treat_update').innerHTML;
    var nama = $("#nama_update").val();
    var harga = $("#harga_update").val();
    var kategori = $("#kategori_update").val();
    $.ajax({
        url: "/treatment/admin/update",
        type: "POST",
        data: {
            id_treat: id_treat,
            nama: nama,
            harga: harga,
            kategori: kategori,
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


function delete_admin_treatment() {
    var table = document.getElementById("table-treatment");
    var rows = table.getElementsByTagName("tr");
    for (i = 0; i < rows.length; i++) {
        var currentRow = table.rows[i];
        var createClickHandler = function (row) {
            return function () {
                var cell = row.getElementsByTagName("td")[2];
                var id_treat = cell.innerHTML;
                Swal.fire({
                    title: 'Yakin Apakan Anda ingin Menghapus Data ini ?',
                    text: "Data ID Teatment " + id_treat + " Akan dihapus !",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus Data !',
                    cancelButtonText: 'Tidak'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "/treatment/admin/delete",
                            data: {
                                id_treat: id_treat,
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

function download_format_treatment() {
    document.location.href = '/treatment/download_format';
}

function import_data_treatment() {
    $("#my-modal-treatment").modal('show');
}

function simpan_data_import_treatmet() {
    $('.button-prevent').attr('disabled', 'true');
    $('.spinner').show();
    $('.hide-text').hide();
    let formData = new FormData(document.getElementById('import_data_treatment'));
    $.ajax({
        url: "/treatment/import_data",
        type: "POST",
        contentType: false,
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        data: formData,
        dataType: "json",
        success: function (data) {
            if (data.status == "success") {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Data Berhasil Diimport !',
                });
                document.location.reload();
            }
        },
    });
}