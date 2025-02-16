$(document).ready(function () {
    // var no = 1;
    $('#table-sdm').DataTable({
        "ajax": {
            "url": "/sdm/getdata",
            "dataSrc": "",
        },
        "columns": [
            { "data": "no" },
            { "data": "action" },
            { "data": "nama" },
            { "data": "jabatan" },
            { "data": "jk" },
            { "data": "created_at" }
        ],
    });
});

function call_modal_add() {
    $("#my-modal-sdm").modal("show");
}

function simpan_data_sdm() {
    var nama = $("#nama").val();
    var cmb_status = $("#cmb_status").val();
    var cmb_jk = $("#cmb_jk").val();
    var cmb_status1 = document.getElementById("cmb_status");
    var cmb_status_text = cmb_status1.options[cmb_status1.selectedIndex].text;
    if (nama == '' || cmb_status == '' || cmb_jk == '') {
        swal.fire({
            title: 'Opps!',
            text: 'Harap Wajib Filed - Field Teersedia !',
            type: 'warning',
            confirmButtonClass: 'btn btn-danger',
        })
    } else {
        $.ajax({
            url: "/sdm/insert",
            type: "POST",
            data: {
                nama: nama,
                cmb_status: cmb_status,
                cmb_status_text: cmb_status_text,
                jk: cmb_jk,
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

function edit_admin_sdm() {
    var table = document.getElementById("table-sdm");
    var rows = table.getElementsByTagName("tr");
    for (i = 0; i < rows.length; i++) {
        var currentRow = table.rows[i];
        var createClickHandler = function (row) {
            return function () {
                var cell = row.getElementsByTagName("td")[2];
                var nama = cell.innerHTML;
                $.ajax({
                    url: "/sdm/edit_show",
                    data: {
                        nama: nama,
                    },
                    type: "POST",
                    dataType: "json",
                    success: function (data) {
                        $("#my-modal-sdm-edit").modal('show');
                        $("#id_update").val(data.id);
                        $("#nama_update").val(data.nama);
                        $("#cmb_status_update").val(data.status);
                        $("#cmb_jk_update").val(data.jk);
                    }
                });
            };
        };
        currentRow.onclick = createClickHandler(currentRow);
    }
}

function update_data_sdm() {
    var id = $("#id_update").val();
    var nama = $("#nama_update").val();
    var cmb_status_update = document.getElementById("cmb_status_update");
    var cmb_status_update_value = cmb_status_update.options[cmb_status_update.selectedIndex].value;
    var cmb_status_update_text = cmb_status_update.options[cmb_status_update.selectedIndex].text;
    var cmb_jk_update = $("#cmb_jk_update").val();
    $.ajax({
        url: "/sdm/update",
        data: {
            id: id,
            nama: nama,
            status: cmb_status_update_value,
            jabatan: cmb_status_update_text,
            jk: cmb_jk_update,
        },
        type: "POST",
        dataType: "json",
        success: function (data) {
            if (data.status == "success") {
                Swal.fire({
                    title: "Good Luck !",
                    text: " Data Berhasil Di Ubah !",
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

function delete_admin_sdm() {
    var table = document.getElementById("table-sdm");
    var rows = table.getElementsByTagName("tr");
    for (i = 0; i < rows.length; i++) {
        var currentRow = table.rows[i];
        var createClickHandler = function (row) {
            return function () {
                var cell = row.getElementsByTagName("td")[2];
                var nama = cell.innerHTML;
                Swal.fire({
                    title: 'Yakin Apakan Anda ingin Menghapus Data ini ?',
                    text: "Data Pasien " + nama + " Akan dihapus !",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus Data !',
                    cancelButtonText: 'Tidak'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "/sdm/delete",
                            data: {
                                nama: nama,
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

