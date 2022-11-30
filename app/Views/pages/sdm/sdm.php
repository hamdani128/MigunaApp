<?= $this->Extend('layout/index'); ?>

<?= $this->Section('title'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <!-- <div class="float-right align-item-center mt-2">
                <button class="btn btn-info px-4 align-self-center report-btn">Creat Report</button>
            </div> -->
            <h4 class="page-title mb-2"><i class="mdi mdi-monitor mr-2"></i>Modul SDM</h4>
            <div class="">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">SDM</a></li>
                    <li roclass="breadcrumb-item"><a href="javascript:void(0);">SDM Master</a></li>
                    <li class="breadcrumb-item active">Info Info Data Karyawan</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<?= $this->EndSection(); ?>


<?= $this->Section('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <button class="btn btn-md btn-primary" onclick="call_modal_add()">
                                <i class="fa fa-plus"></i>
                                Tambah Data
                            </button>
                        </div>
                    </div>
                    <div class="row pt-2">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table id="table-sdm" class="table dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#No</th>
                                            <th>#Action</th>
                                            <th>Nama Karyawan</th>
                                            <th>Status</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Created At</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Content -->

<!-- Modal add -->
<div id="my-modal-sdm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="title_diagnosa">Tambah Data Karyawan</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="post" id="form_sdm">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Nama Karyawan</label>
                                <input type="text" name="nama" id="nama" class="form-control"
                                    placeholder="Silahkan Masukkan Nama Karyawan" required>
                            </div>
                            <div class="form-group">
                                <label for="form-label">Status Karyawan</label>
                                <select name="cmb_status" id="cmb_status" class="form-control">
                                    <option value="">Pilih :</option>
                                    <option value="Dokter">Dokter</option>
                                    <option value="pegawai1">Pegawai Treatment</option>
                                    <option value="pegawai2">Kasir / Admin</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="form-label">Jenis Kelamin</label>
                                <select name="cmb_jk" id="cmb_jk" class="form-control">
                                    <option value="">Pilih :</option>
                                    <option value="Laki - Laki"> Laki - Laki</option>
                                    <option value="Perempuan"> Perempuan </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info" onclick="simpan_data_sdm()">
                    <i class="fa fa-save"></i>
                    Simpan Data
                </button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Add -->


<!-- Modal Edit Show -->
<div id="my-modal-sdm-edit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-white" id="title_diagnosa">Update Karyawan</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="post" id="form_sdm_update">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="hidden" class="form-control" id="id_update">
                            </div>
                            <div class="form-group">
                                <label for="">Nama Karyawan</label>
                                <input type="text" name="nama_update" id="nama_update" class="form-control"
                                    placeholder="Silahkan Masukkan Nama Karyawan" required>
                            </div>
                            <div class="form-group">
                                <label for="form-label">Status Karyawan</label>
                                <select name="cmb_status_update" id="cmb_status_update" class="form-control">
                                    <option value="">Pilih :</option>
                                    <option value="Dokter">Dokter</option>
                                    <option value="pegawai1">Pegawai Treatment</option>
                                    <option value="pegawai2">Kasir / Admin</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="form-label">Jenis Kelamin</label>
                                <select name="cmb_jk_update" id="cmb_jk_update" class="form-control">
                                    <option value="">Pilih :</option>
                                    <option value="Laki - Laki"> Laki - Laki</option>
                                    <option value="Perempuan"> Perempuan </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-warning" onclick="update_data_sdm()">
                    <i class="fa fa-edit"></i>
                    Update Data
                </button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Edit -->

<?= $this->EndSection(); ?>