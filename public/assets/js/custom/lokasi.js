$(document).ready(function () {
    $('#table-cabang').DataTable();
});

// function getDataLokasi() {
//     var tbody = document.getElementById("cabang_body");
//     tbody.innerHTML = '<tr><td colspan="12"><h7> Mohon Tunggu Sebentar Data Lagi Dirender.. </h7></td></tr>';
//     $.ajax({
//         url: '/lokasi/getdata',
//         method: "POST",
//         dataType: "json",
//         success: function (data) {
//             if (data == null) {
//                 tbody.innerHTML = '<tr><td colspan="8"><h3>No Record Found.</h3></td></tr>';
//             } else {
//                 var tr = '';
//                 var no = 1;
//                 for (var i in data) {
//                     tr += `<tr>
//                                     <td align="center">${no++}</td>
//                                     <td>
//                                         <div class="btn-group mb-2 mb-md-0">
//                                             <button class="btn btn-md btn-warning">
//                                                 <i class="fa fa-edit"></i>
//                                             </button>
//                                             <button class="btn btn-md btn-danger">
//                                                 <i class="fa fa-trash"></i>
//                                             </button>
//                                         </div>
//                                     </td>
//                                     <td>${data[i].unit}</td>
//                                     <td>${data[i].alamat}</td>
//                                     <td>${data[i].kecamatan}</td>
//                                     <td>${data[i].kabupaten}</td>
//                                     <td>${data[i].provinsi}</td>
//                                     <td>${data[i].created_at}</td>
//                                 </tr>`;
//                 }
//                 tbody.innerHTML = tr;
//             }
//         }
//     });
// }

function simpan_lokasi() {
    var unit = $("#unit").val();
    var alamat = $("#alamat").val();
    var kecamatan = $("#kecamatan").val();
    var kabupaten = $("#kabupaten").val();
    var provinsi = $("#provinsi").val();

    if (unit == "" || alamat == "" || kecamatan == "" || kabupaten == "" || provinsi == "") {
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
            url: "/lokasi/insert",
            type: "POST",
            data: {
                unit: unit,
                alamat: alamat,
                kecamatan: kecamatan,
                kabupaten: kabupaten,
                provinsi: provinsi,
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

function edit_lokasi(id) {
    $.ajax({
        url: "/lokasi/edit_show",
        data: {
            id: id,
        },
        type: "POST",
        dataType: "json",
        success: function (data) {
            $("#my-modal-edit").modal('show');
            $("#id_update").val(id);
            $("#unit_update").val(data.unit);
            $("#alamat_update").val(data.alamat);
            $("#kecamatan_update").val(data.kecamatan);
            $("#kabupaten_update").val(data.kabupaten);
            $("#provinsi_update").val(data.provinsi);
        }
    });
}

function update_lokasi() {
    var id = $("#id_update").val();
    var unit = $("#unit_update").val();
    var alamat = $("#alamat_update").val();
    var kecamatan = $("#kecamatan_update").val();
    var kabupaten = $("#kabupaten_update").val();
    var provinsi = $("#provinsi_update").val();
    $.ajax({
        url: "/lokasi/update",
        type: "POST",
        data: {
            id: id,
            unit: unit,
            alamat: alamat,
            kecamatan: kecamatan,
            kabupaten: kabupaten,
            provinsi: provinsi,
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
    }
    );
}

function delete_lokasi(id, unit) {
    Swal.fire({
        title: 'Yakin Apakan Anda ingin Menghapus Data ini ?',
        text: "Data Cabang " + unit + " Akan dihapus !",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus Data !',
        cancelButtonText: 'Tidak'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "/lokasi/delete",
                data: {
                    id: id,
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
    })
}