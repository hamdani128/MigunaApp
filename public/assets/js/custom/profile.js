function CheckProfile() {
    var form_nama_klinik = document.getElementById("form_nama");
    var button_update_form = document.getElementById("update");
    var button_simpan_form = document.getElementById("new");
    var button_delete_form = document.getElementById("delete");
    $.ajax({
        url: "/profile/check",
        type: "GET",
        dataType: "json",
        success: function (data) {
            if (data.nama == '') {
                button_update_form.style.display = 'none';
                button_delete_form.style.display = 'none';
                document.getElementById("alamat").readOnly = false;
                document.getElementById("no_hp").readOnly = false;
                document.getElementById("img-profile").src = "assets/images/users/user-4.jpg";
            } else {
                form_nama_klinik.style.display = 'none';
                button_simpan_form.style.display = 'none';
                document.getElementById("nama-klinik").innerHTML = data.nama;
                $("#alamat").val(data.alamat);
                $("#no_hp").val(data.no_hp);
                document.getElementById("alamat").readOnly = false;
                document.getElementById("no_hp").readOnly = false;
                document.getElementById("img-profile").src = "upload/" + data.file;
            }
        }
    });
}
CheckProfile();

function New_Profile() {
    var nama = $("#nama").val();
    var alamat = $("#alamat").val();
    var no_hp = $("#no_hp").val();
    $.ajax({
        url: "/profile/insert_profile",
        type: "POST",
        data: {
            nama: nama,
            alamat: alamat,
            no_hp: no_hp,
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

function Change_photo() {
    $.ajax({
        url: "/profile/check",
        type: "GET",
        dataType: "json",
        success: function (data) {
            if (data.nama == '') {
                Swal.fire({
                    title: "Attention !",
                    text: " Data Profile Wajib Terisi dulu, Baru Bisa Upload Photo !",
                    type: "warning",
                    confirmButtonClass: 'btn btn-success',
                })
            } else {
                $("#my-modal").modal("show");
            }
        }
    });
}

function Upload_Photo() {
    let img = document.getElementById("input-file-now photo").files[0];
    let form_data = new FormData();
    form_data.append("img", img);
    $.ajax({
        url: "/profile/change_photo",
        type: "POST",
        data: form_data,
        enctype: 'multipart/form-data',
        processData: false,  // tell jQuery not to process the data
        contentType: false,
        dataType: "json",
        success: function (data) {
            if (data.status == "success") {
                swal.fire({
                    type: "success",
                    title: "Good Luck !",
                    text: "Upload Photo Berhasil !",
                });
                document.location.reload();
            }
        }
    });
}