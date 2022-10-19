$(document).ready(function () {
    // var no = 1;
    $('#table-pasien-admin').DataTable({
        "ajax": {
            "url": "/pasien/admin/getdata",
            "dataSrc": "",
        },
        "columns": [
            { "data": "no" },
            { "data": "action" },
            { "data": "id_pasien" },
            { "data": "nik" },
            { "data": "nama" },
            { "data": "usia" },
            { "data": "alamat" },
            { "data": "jk" },
            { "data": "pekerjaan" },
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
        }
        );
    }
}

function edit_admin_pasien(id_pasien) {
    alert(id_pasien);
}