$(document).ready(function () {
    $('#table-info-user').DataTable();
});

function simpan_akun_user() {
    var fullname = $('#fullname').val();
    var username = $('#username').val();
    var email = $('#email').val();
    var password = $('#password').val();
    var confirm_password = $('#confirm_password').val();
    var cmb_unit = document.getElementById("unit_cabang").value;

    if (fullname == '' || username == '' || email == '' || password == '' || confirm_password == '' || cmb_unit == '') {
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
            url: "/infousers/insert",
            type: "POST",
            data: {
                fullname: fullname,
                username: username,
                email: email,
                password: password,
                confirm_password: confirm_password,
                unit_id: cmb_unit,
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

function edit_user(id) {
    $.ajax({
        url: "/infousers/show_edit",
        type: "POST",
        data: {
            id: id,
        },
        dataType: "json",
        success: function (data) {
            $("#my-modal-edit").modal('show');
            $("#id_update").val(id);
            $("#fullname_update").val(data.fullname);
            $("#username_update").val(data.username);
            $("#email_update").val(data.email);
            $("#password_update").val(data.password);
            $("#confirm_password_update").val(data.password);
            $("#unit_cabang_update").val(data.unit_id);
        }
    });
}

function update_akun_user() {
    var id = $("#id_update").val();
    var fullname = $('#fullname_update').val();
    var username = $('#username_update').val();
    var email = $('#email_update').val();
    var password = $('#password_update').val();
    var confirm_password = $('#confirm_password_update').val();
    var cmb_unit = document.getElementById("unit_cabang_update").value;

    if (fullname == '' || username == '' || email == '' || password == '' || confirm_password == '' || cmb_unit == '') {
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
            url: "/infousers/update",
            type: "POST",
            data: {
                id: id,
                fullname: fullname,
                username: username,
                email: email,
                password: password,
                confirm_password: confirm_password,
                unit_id: cmb_unit,
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
}

function delete_user(id, fullname) {
    Swal.fire({
        title: 'Yakin Apakan Anda ingin Menghapus Data ini ?',
        text: "Data Akun " + fullname + " Akan dihapus !",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus Data !',
        cancelButtonText: 'Tidak'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "/infousers/delete",
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

function show_password(id) {
    var tbody = document.getElementById("tbody-info-password");
    $.ajax({
        url: "/infousers/show_password",
        type: "POST",
        data: {
            id: id,
        },
        dataType: "json",
        success: function (data) {
            $("#my-modal-password").modal('show');
            if (data == null) {
                tbody.innerHTML = '<tr><td colspan="5"><h3>No Record Found.</h3></td></tr>';
            } else {
                var tr = '';
                var no = 1;
                for (var i in data) {
                    tr += `<tr>
                                <td align="center">${no++}</td>
                                <td>${data[i].username}</td>
                                <td>${data[i].password}</td>
                                <td>${data[i].hash}</td>
                                <td>${data[i].created_at}</td>
                            </tr>`;
                }
                tbody.innerHTML = tr;
            }
        }
    });
}