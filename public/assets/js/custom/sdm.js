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
            { "data": "status" },
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

function delete_admin_sdm() {
    alert("miss you");
}