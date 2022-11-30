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