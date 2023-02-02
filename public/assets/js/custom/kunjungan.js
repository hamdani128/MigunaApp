$(document).ready(function () {
    // var no = 1;
    $('#table-antrian').DataTable({
        "ajax": {
            "url": "/kunjungan/admin_getdata",
            "dataSrc": "",
        },
        "columns": [
            { "data": "no" },
            { "data": "action" },
            { "data": "status" },
            { "data": "tanggal" },
            { "data": "no_antrian" },
            { "data": "id_pasien" },
            { "data": "nama" },
            { "data": "catatan_kunjungan" },
            { "data": "created_at" },
        ],
    });
});

function delete_admin_kunjungan() {
    var table = document.getElementById("table-antrian");
    var rows = table.getElementsByTagName("tr");
    for (i = 0; i < rows.length; i++) {
        var currentRow = table.rows[i];
        var createClickHandler = function (row) {
            return function () {
                var cell1 = row.getElementsByTagName("td")[2];
                // var cell2 = row.getElementsByTagName("td")[7];
                var no_antrian = cell1.innerHTML;
                // var date_text = cell2.innerHTML;
                Swal.fire({
                    title: 'Yakin Apakan Anda ingin Menghapus Data ini ?',
                    text: "Data Kunjungan Pasien " + no_antrian + " Akan dihapus !",
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
                                // tanggal: date_text,
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


function riwayat_transaksi_kunjungan() {
    var table = document.getElementById("table-transaksi-kunjungan");
    var rows = table.getElementsByTagName("tr");
    for (i = 0; i < rows.length; i++) {
        var currentRow = table.rows[i];
        var createClickHandler = function (row) {
            return function () {
                var cell1 = row.getElementsByTagName("td")[3];
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


function check_riwayat_tanggal() {
    var table = document.getElementById("table-transaksi-riwayat");
    var rows = table.getElementsByTagName("tr");
    for (i = 0; i < rows.length; i++) {
        var currentRow = table.rows[i];
        var createClickHandler = function (row) {
            return function () {
                var cell1 = row.getElementsByTagName("td")[2];
                var cell2 = row.getElementsByTagName("td")[3];
                var tanggal = cell1.innerHTML;
                var id_pasien = cell2.innerHTML;
                $.ajax({
                    url: "/transaksi/kunjungan/list_detail_riwayat",
                    type: "POST",
                    data: {
                        tanggal: tanggal,
                        id_pasien: id_pasien,
                    },
                    dataType: "json",
                    success: function (data) {
                        document.getElementById("img1").src = "/upload/" + data.img1;
                        document.getElementById("img2").src = "/upload/" + data.img2;
                        document.getElementById("img3").src = "/upload/" + data.img3;
                        document.getElementById("img4").src = "/upload/" + data.img4;
                        $("#riwayat_catatan").val(data.catatan_anamnesa);
                        $("#riwayat_catatan_resep").val(data.catatan_obat);
                        var tbody1 = document.getElementById('tbody-list-treat-riw');
                        var tr1 = '';
                        for (var i in data.treatment_detail) {
                            tr1 += `<tr>
                            <td align="center">${data.treatment_detail[i].kode}</td>
                            <td>${data.treatment_detail[i].treatment}</td>
                            <td>${data.treatment_detail[i].harga}</td>
                            <td>${data.treatment_detail[i].qty}</td>
                            <td>${data.treatment_detail[i].subtotal}</td>
                            <td>${data.treatment_detail[i].potongan}</td>
                        </tr>`;
                        }
                        tbody1.innerHTML = tr1;

                        var tbody2 = document.getElementById('tbody-list-prod-riw');
                        var tr2 = '';
                        for (var i in data.product_detail) {
                            tr2 += `<tr>
                        <td align="center">${data.product_detail[i].kode}</td>
                        <td>${data.product_detail[i].nama}</td>
                        <td>${data.product_detail[i].satuan}</td>
                        <td>${data.product_detail[i].harga}</td>
                        <td>${data.product_detail[i].qty}</td>
                        <td>${data.product_detail[i].subtotal}</td>
                        <td>${data.product_detail[i].potongan}</td>
                        </tr>`;
                        }
                        tbody2.innerHTML = tr2;
                    }
                });
            };
        };
        currentRow.onclick = createClickHandler(currentRow);
    }
}

function Filter_riwayat_kunjungan() {
    var mulai = $('#mulai').val();
    var sampai = $('#sampai').val();
    if (mulai == '' || sampai == '') {
        Swal.fire({
            title: "Error !",
            text: " Harap Memilih Tanggal Yang Tersedia !",
            type: "error",
        });
    } else {
        var table = $('#table-antrian').DataTable();
        table.clear().draw();
        table = $('#table-antrian').DataTable({
            ajax: {
                url: "/kunjungan/filter_getdata/" + mulai + "/" + sampai,
                dataSrc: "",
            },
            columns: [
                { "data": "no" },
                { "data": "keterangan" },
                { "data": "tanggal" },
                { "data": "hari" },
                { "data": "nik" },
                { "data": "nama" },
                { "data": "instansi" },
                { "data": "jam_masuk" },
                { "data": "jam_pulang" },
                { "data": "jlh_telat" },
                { "data": "lokasi_masuk" },
                { "data": "lokasi_pulang" }
            ],
        });
    }
}


