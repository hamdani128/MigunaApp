$(document).ready(function () {
    $('#table-product').DataTable({
        "ajax": {
            "url": "/product/getdata",
            "dataSrc": "",
        },
        "columns": [
            { "data": "no" },
            { "data": "action" },
            { "data": "kode" },
            { "data": "nama" },
            { "data": "satuan" },
            { "data": "harga" },
            { "data": "qty" },
            { "data": "subtotal" },
            { "data": "supplier" },
            { "data": "kategori" }
        ],
    });

    $('#table-supplier').DataTable({
        "ajax": {
            "url": "/product/supplier/getdata",
            "dataSrc": "",
        },
        "columns": [
            { "data": "no" },
            { "data": "action" },
            { "data": "supplier" },
            { "data": "alamat" },
            { "data": "hp" },
            { "data": "created_at" }
        ],

    });
});

function penjumlahan() {
    var a = $("#harga").val();
    var b = $("#qty").val();
    c = a * b;
    $("#subtotal").val(c);
}

function penjumlahan2() {
    var a = $("#harga_update").val();
    var b = $("#qty_update").val();
    c = a * b;
    $("#subtotal_update").val(c);
}

function simpan_data_supplier() {
    var nama_supplier = $("#nama_supplier").val();
    var alamat_supplier = $("#alamat_supplier").val();
    var no_telepon = $("#no_telepon").val();
    var email_supplier = $("#email_supplier").val();
    if (nama_supplier == '' || alamat_supplier == '' || no_telepon == '' || email_supplier == '') {
        swal.fire({
            title: 'Opps!',
            text: 'Harap Wajib Filed - Field Teersedia !',
            type: 'warning',
            confirmButtonClass: 'btn btn-danger',
        })
    } else {
        $.ajax({
            url: "/product/supplier/insert",
            type: "POST",
            data: {
                nama_supplier: nama_supplier,
                alamat_supplier: alamat_supplier,
                no_telepon: no_telepon,
                email_supplier: email_supplier,
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

function edit_admin_supplier() {
    var table = document.getElementById("table-supplier");
    var rows = table.getElementsByTagName("tr");
    for (i = 0; i < rows.length; i++) {
        var currentRow = table.rows[i];
        var createClickHandler = function (row) {
            return function () {
                var cell = row.getElementsByTagName("td")[2];
                var supplier = cell.innerHTML;
                $.ajax({
                    url: "/product/supplier/edit_show",
                    data: {
                        supplier: supplier,
                    },
                    type: "POST",
                    dataType: "json",
                    success: function (data) {
                        $("#my-modal-supplier-edit").modal('show');
                        $("#id_update").val(data.id);
                        $("#nama_supplier_update").val(data.supplier);
                        $("#alamat_supplier_update").val(data.alamat);
                        $("#no_telepon_update").val(data.hp);
                        $("#email_supplier_update").val(data.email);
                    }
                });
            };
        };
        currentRow.onclick = createClickHandler(currentRow);
    }
}

function update_data_supplier() {
    var id = $("#id_update").val();
    var nama_supplier = $("#nama_supplier_update").val();
    var alamat_supplier = $("#alamat_supplier_update").val();
    var no_telepon = $("#no_telepon_update").val();
    var email_supplier = $("#email_supplier_update").val();
    if (nama_supplier == '' || alamat_supplier == '' || no_telepon == '' || email_supplier == '') {
        swal.fire({
            title: 'Opps!',
            text: 'Harap Wajib Filed - Field Teersedia !',
            type: 'warning',
            confirmButtonClass: 'btn btn-danger',
        })
    } else {
        $.ajax({
            url: "/product/supplier/update_data_supplier",
            type: "POST",
            data: {
                id: id,
                nama_supplier: nama_supplier,
                alamat_supplier: alamat_supplier,
                no_telepon: no_telepon,
                email_supplier: email_supplier,
            },
            dataType: "json",
            success: function (data) {
                if (data.status == "success") {
                    Swal.fire({
                        title: "Good Luck !",
                        text: " Data Berhasil Di ubah !",
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

function delete_admin_supplier() {
    var table = document.getElementById("table-supplier");
    var rows = table.getElementsByTagName("tr");
    for (i = 0; i < rows.length; i++) {
        var currentRow = table.rows[i];
        var createClickHandler = function (row) {
            return function () {
                var cell = row.getElementsByTagName("td")[2];
                var supplier = cell.innerHTML;
                Swal.fire({
                    title: 'Yakin Apakan Anda ingin Menghapus Data ini ?',
                    text: "Data Supplier " + supplier + " Akan dihapus !",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus Data !',
                    cancelButtonText: 'Tidak'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "/product/supplier/delete",
                            data: {
                                supplier: supplier,
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

function simpan_data_product_byadmin() {
    var kode_product = document.getElementById("kode").innerHTML;
    var nama_product = $("#nama").val();
    var harga_product = $("#harga").val();
    var satuan_product = $("#satuan").val();
    var qty_product = $("#qty").val();
    var subtotal_product = $("#subtotal").val();
    var cmb_supplier = document.getElementById("supplier").value;
    if (kode_product == '' || nama_product == '' || harga_product == '' || satuan_product == '' || qty_product == '' || subtotal_product == '') {
        swal.fire({
            title: 'Opps!',
            text: 'Harap Wajib Filed - Field Teersedia !',
            type: 'warning',
            confirmButtonClass: 'btn btn-danger',
        })
    } else {
        $.ajax({
            url: "/product/insert",
            type: "POST",
            data: {
                kode: kode_product,
                nama: nama_product,
                satuan: nama_product,
                harga: harga_product,
                qty: qty_product,
                subtotal: subtotal_product,
                supplier_value: cmb_supplier,
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


function edit_admin_product() {
    var table = document.getElementById("table-product");
    var rows = table.getElementsByTagName("tr");
    for (i = 0; i < rows.length; i++) {
        var currentRow = table.rows[i];
        var createClickHandler = function (row) {
            return function () {
                var cell = row.getElementsByTagName("td")[2];
                var kode = cell.innerHTML;
                $.ajax({
                    url: "/product/edit_show",
                    data: {
                        kode: kode,
                    },
                    type: "POST",
                    dataType: "json",
                    success: function (data) {
                        $("#my-modal-product-edit").modal('show');
                        $("#id_update").val(data.id);
                        document.getElementById('kode_update').innerHTML = data.kode;
                        $("#nama_update").val(data.nama);
                        $("#satuan_update").val(data.satuan);
                        $("#harga_update").val(data.harga);
                        $("#qty_update").val(data.qty);
                        $("#subtotal_update").val(data.subtotal);
                        document.getElementById('supplier_update').value = data.id_supplier;
                    }
                });
            };
        };
        currentRow.onclick = createClickHandler(currentRow);
    }
}


function update_data_product_byadmin() {
    var id = $("#id_update").val();
    var kode_product = document.getElementById("kode_update").innerHTML;
    var nama_product = $("#nama_update").val();
    var harga_product = $("#harga_update").val();
    var satuan_product = $("#satuan_update").val();
    var qty_product = $("#qty_update").val();
    var subtotal_product = $("#subtotal_update").val();
    var cmb_supplier = document.getElementById("supplier_update").value;
    if (kode_product == '' || nama_product == '' || harga_product == '' || satuan_product == '' || qty_product == '' || subtotal_product == '') {
        swal.fire({
            title: 'Opps!',
            text: 'Harap Wajib Filed - Field Teersedia !',
            type: 'warning',
            confirmButtonClass: 'btn btn-danger',
        })
    } else {
        $.ajax({
            url: "/product/update",
            type: "POST",
            data: {
                id: id,
                kode: kode_product,
                nama: nama_product,
                satuan: nama_product,
                harga: harga_product,
                qty: qty_product,
                subtotal: subtotal_product,
                supplier_value: cmb_supplier,
            },
            dataType: "json",
            success: function (data) {
                if (data.status == "success") {
                    Swal.fire({
                        title: "Good Luck !",
                        text: " Data Berhasil Di ubah !",
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

function delete_admin_product() {
    var table = document.getElementById("table-product");
    var rows = table.getElementsByTagName("tr");
    for (i = 0; i < rows.length; i++) {
        var currentRow = table.rows[i];
        var createClickHandler = function (row) {
            return function () {
                var cell = row.getElementsByTagName("td")[2];
                var kode = cell.innerHTML;
                Swal.fire({
                    title: 'Yakin Apakan Anda ingin Menghapus Data ini ?',
                    text: "Data Product dengan Kode " + kode + " Akan dihapus !",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus Data !',
                    cancelButtonText: 'Tidak'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "/product/delete",
                            data: {
                                kode: kode,
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

function download_format_product() {
    document.location.href = '/product/download';
}

function import_data_product() {
    $("#my-modal-import-product").modal('show');
}

function simpan_data_import_product() {
    $('.button-prevent').attr('disabled', 'true');
    $('.spinner').show();
    $('.hide-text').hide();
    let formData = new FormData(document.getElementById('import_data_product'));
    $.ajax({
        url: "/product/import_data_product",
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

function download_format_supplier() {
    document.location.href = '/supplier/download';
}

function import_data_supplier() {
    $("#my-modal-import-supplier").modal('show');
}

function simpan_data_import_supplier() {
    $('.button-prevent').attr('disabled', 'true');
    $('.spinner').show();
    $('.hide-text').hide();
    let formData = new FormData(document.getElementById('import_data_supplier'));
    $.ajax({
        url: "/supplier/import_data_supplier",
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