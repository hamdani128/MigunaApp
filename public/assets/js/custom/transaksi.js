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
            { "data": "created_at" }
        ],
    });
});

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
                var no_antrian = cell1.innerHTML;
                var id_pasien = cell2.innerHTML;
                var nama_pasien = cell3.innerHTML;
                $("#my-modal-diagnosa").modal("show");
                document.getElementById("title_diagnosa").innerHTML = "Diagnosa - " + no_antrian;
                document.getElementById("no_antrian").innerHTML = no_antrian;
                document.getElementById("id_pasien").innerHTML = id_pasien;
                document.getElementById("nama_pasien").innerHTML = nama_pasien;

            };
        };
        currentRow.onclick = createClickHandler(currentRow);
    }
}

function simpan_diagnosa() {
    var no_antrian = document.getElementById("no_antrian").innerHTML;
    var id_pasien = document.getElementById("id_pasien").innerHTML;
    var nama_pasien = document.getElementById("nama_pasien").innerHTML;
    var diagnosa = $("#diagnosa").val();
    var resep = $("#resep").val();
    var img1 = document.getElementById("input-file-now file1").value;
    var img2 = document.getElementById("input-file-now file2").value;
    var img3 = document.getElementById("input-file-now file3").value;
    var img4 = document.getElementById("input-file-now file4").value;
    if (diagnosa == '' || resep == '') {
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


