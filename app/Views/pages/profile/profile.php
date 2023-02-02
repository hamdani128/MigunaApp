<?= $this->Extend('layout/index'); ?>
<?= $this->Section('title'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title mb-2"><i class="mdi mdi-monitor mr-2"></i>Info Profile</h4>
            <div class="">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Settings</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Profile</a></li>
                    <li class="breadcrumb-item active">Info Profile</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>


<?= $this->Section('content'); ?>
<!-- Content -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body border-bottom">
                <div class="fro_profile">
                    <div class="row">
                        <div class="col-lg-4 text-center mb-3 mb-lg-0">
                            <div class="card">
                                <div class="card-body">
                                    <img src="#" alt="" id="img-profile" style="width: 100%;height: 80%;">
                                    <h5 class="fro_user-name" id="nama-klinik">-</h5>

                                </div>
                                <div class="card-footer bg-light">
                                    <button class="btn btn-md btn-info btn-block" type="button"
                                        onclick="Change_photo()">
                                        <span class="fro-profile_main-pic-change">
                                            <i class="fas fa-camera"></i>
                                        </span>
                                    </button>
                                </div>
                            </div>

                        </div>
                        <!--end col-->

                        <div class="col-lg-8 mb-3 mb-lg-0">
                            <div class="header-title">Informasi Profile</div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group" id="form_nama">
                                        <label for="">Nama Klinik</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-home"></i></span>
                                            </div>
                                            <input type="text" id="nama" name="nama" class="form-control"
                                                placeholder="Nama Klinik">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="">
                                            Alamat Terkini
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i
                                                        class="fas fa-map-marker-alt"></i></span>
                                            </div>
                                            <input type="text" id="alamat" name="alamat" class="form-control"
                                                placeholder="Alamat">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="">No.Handphone / No.Telepon</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            </div>
                                            <input type="text" id="no_hp" name="no_hp" class="form-control"
                                                placeholder="No.Handphone / No.Telepon">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="button-group">
                                            <button class="btn btn-md btn-warning" id="update">
                                                Update
                                            </button>
                                            <button class="btn btn-md btn-danger" id="delete">
                                                Delete
                                            </button>
                                            <button class="btn btn-md btn-primary" id="new" onclick="New_Profile()">
                                                Save
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!--end row-->
                </div>
                <!--end f_profile-->
            </div>
            <!--end card-body-->

        </div>
    </div>
</div>
<!-- End Content -->


<!-- modal -->
<div id="my-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <div class="row">
                    <div class="col-md-12">
                        <span class="text-white">Upload Photo</span>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="" method="post" id="form_change_photo">
                            <div class="form-group">
                                <input type="file" id="input-file-now photo" name="photo" class="dropify" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-info btn-md" onclick="Upload_Photo()">
                            <i class="fa fa-save"></i>
                            Upload
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->EndSection(); ?>