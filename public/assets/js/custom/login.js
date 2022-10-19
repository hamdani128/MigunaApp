function login_administrator() {
    var username = $("#username").val();
    var password = $("#password").val();

    if (username == '' || password == '') {
        swal.fire(
            {
                title: 'Opps!',
                text: 'Harap Wajib Mengisi Username dan Password Anda !',
                type: 'warning',
                confirmButtonClass: 'btn btn-danger',
            }
        )
    } else {
        $.ajax({
            url: "/auth/login_check",
            method: "POST",
            data: {
                username: username,
                password: password,
            },
            dataType: "json",
            success: function (data) {
                if (data.status == "success") {
                    Swal.fire({
                        title: "Weldone !",
                        text: " Anda Berhasil Login !",
                        type: "success",
                        confirmButtonClass: 'btn btn-success',
                    }).then((result) => {
                        if (result.value) {
                            document.location = "/";
                        }
                    });
                } else if (data.status == 'username not found') {
                    Swal.fire({
                        title: "Warning",
                        text: "Username Belom Terdaftar !",
                        type: "warning",
                        confirmButtonClass: 'btn btn-warning',
                    });
                } else if (data.status == 'Password Error') {
                    Swal.fire({
                        title: "error",
                        text: "Password Anda Salah !",
                        type: "error",
                        confirmButtonClass: 'btn btn-danger',
                    });
                }
            }
        }
        );
    }
}