<?= $this->Extend('layout/index'); ?>
<?= $this->Section('title'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <!-- <div class="float-right align-item-center mt-2">
                <button class="btn btn-info px-4 align-self-center report-btn">Creat Report</button>
            </div> -->
            <h4 class="page-title mb-2"><i class="mdi mdi-monitor mr-2"></i>Informasi Pasien</h4>
            <div class="">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Master</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Pasien</a></li>
                    <li class="breadcrumb-item active">Info Pasien</li>
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
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-2">
                            <button class="btn btn-primary btn-md" data-toggle="modal" data-target="#my-modal">
                                <i class="fa fa-plus"></i>
                                Tambah
                            </button>
                        </div>
                        <div class="col-lg-5">

                        </div>
                        <div class="col-lg-5 text-right">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="date" name="" id="" class="form-control">
                                    <button class="btn btn-info btn-md">
                                        <i class="fa fa-filter"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table id="table-pasien-admin" class="table dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#No</th>
                                            <th>#Action</th>
                                            <th>ID Pasien</th>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>Usia</th>
                                            <th>Alamat</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Pekerjaan</th>
                                            <th>No.Handphone</th>
                                            <th>Tanggal Registrasi</th>
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


<!-- Modal Add -->
<div id="my-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white" id="my-modal-title">Tambah Data Pasien</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="" class="form-label">NIK Pasien</label>
                            <input type="text" class="form-control" name="nik" id="nik"
                                placeholder="Masukkan NIK Pasien">
                        </div>
                        <div class="form-group">
                            <label for="">Nama Lengkap</label>
                            <input type="text" name="nama" id="nama" placeholder="Nama Lengkap Anda"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Usia</label>
                            <input type="text" name="usia" id="usia" class="form-control" placeholder="Masukkan Usia">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Alamat</label>
                            <textarea class="form-control" name="alamat" id="alamat" cols="5" rows="5"
                                placeholder="Masukkan Alamat Lengkap"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Jenis Kelamin</label>
                            <select name="jk" id="jk" class="form-control">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Pria">Pria</option>
                                <option value="Wanita">Wanita</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Pekerjaan / Kegiatan</label>
                            <input type="text" name="pekerjaan" id="pekerjaan" class="form-control"
                                placeholder="Masukkan Kegiatan / Pekerjaan">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">No.Handphone</label>
                            <input type="text" name="hp" id="hp" class="form-control"
                                placeholder="Masukkan No HP ex:(0813-7507-8785)">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Tanggal Registrasi</label>
                            <input type="date" name="registri" id="registri" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="simpan_data_pasien_by_admin()"><i
                        class="fa fa-save"></i>
                    Simpan Data</button>
            </div>
        </div>
    </div>
</div>
<!-- End Add -->

<!-- Update Modal -->
<div id="my-modal-edit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-white" id="my-modal-title">Update Data Pasien</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="" class="form-label">ID Pasien</label>
                            <input type="text" name="id_pasien_update" id="id_pasien_update" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">NIK Pasien</label>
                            <input type="text" class="form-control" name="nik_update" id="nik_update"
                                placeholder="Masukkan NIK Pasien">
                        </div>
                        <div class="form-group">
                            <label for="">Nama Lengkap</label>
                            <input type="text" name="nama_update" id="nama_update" placeholder="Nama Lengkap Anda"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Usia</label>
                            <input type="text" name="usia_update" id="usia_update" class="form-control"
                                placeholder="Masukkan Usia">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Alamat</label>
                            <textarea class="form-control" name="alamat_update" id="alamat_update" cols="5" rows="5"
                                placeholder="Masukkan Alamat Lengkap"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Jenis Kelamin</label>
                            <select name="jk_update" id="jk_update" class="form-control">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Pria">Pria</option>
                                <option value="Wanita">Wanita</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Pekerjaan / Kegiatan</label>
                            <input type="text" name="pekerjaan_update" id="pekerjaan_update" class="form-control"
                                placeholder="Masukkan Kegiatan / Pekerjaan">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">No.Handphone</label>
                            <input type="text" name="hp_update" id="hp_update" class="form-control"
                                placeholder="Masukkan No HP ex:(0813-7507-8785)">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Tanggal Registrasi</label>
                            <input type="date" name="registri_update" id="registri_update" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-warning" onclick="update_data_pasien_by_admin()"><i
                        class="fa fa-edit"></i>
                    Update Data</button>
            </div>
        </div>
    </div>
</div>
<!-- End Update -->

<!-- Antrian Pasien -->
<div id="my-modal-antrian" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white" id="my-modal-title">Tambah Data Kunjungan</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="" class="form-label">No.Kunjungan</label>
                            <h5 id='no_kunjungan'><?= $no_antrian; ?></h5>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">ID Pasien</label>
                            <input type="text" name="id_pasien" id="id_pasien" class="form-control"
                                placeholder="ID Pasien">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Nama Pasien</label>
                            <input type="text" class="form-control" name="nama_pasien" id="nama_pasien"
                                placeholder="Nama Pasien">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Catatan Kunjungan</label>
                            <textarea class="form-control" name="catatan" id="catatan" cols="5" rows="5"
                                placeholder="Silahkan isi Tujuan atau Catatan Penting Saat Kunjungan Pasien">
                            </textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info" onclick="masukan_antrian_data_pasien_by_admin()"><i
                        class="fa fa-edit"></i>
                    Masukkan Antrian</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Riwayat Kunjungan -->
<div id="my-modal-riwayat" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white" id="my-titla-riwayat"></h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header bg-dark">
                                <span class="text-white">Riwayat Tanggal Kunjungan</span>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="table-responsive">
                                        <table id="table-transaksi-riwayat"
                                            class="table dt-responsive nowrap table-bordered"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>#No</th>
                                                    <th>#Action</th>
                                                    <th>Tanggal</th>
                                                    <th>ID Pasien</th>
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
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header bg-dark">
                                <span class="text-white">Informasi Treatment</span>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table id="table-list-treatment"
                                                class="table dt-responsive nowrap table-bordered table-striped"
                                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Kode</th>
                                                        <th>Treament</th>
                                                        <th>Harga</th>
                                                        <th>Qty</th>
                                                        <th>Subtotal</th>
                                                        <th>Potongan</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbody-list-treat-riw">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header bg-dark">
                                <span class="text-white">Informasi Product</span>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table dt-responsive nowrap table-bordered table-striped"
                                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Kode</th>
                                                        <th>Produk / Obat</th>
                                                        <th>Satuan</th>
                                                        <th>Harga</th>
                                                        <th>Qty</th>
                                                        <th>Subtotal</th>
                                                        <th>Potongan</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbody-list-prod-riw">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header bg-dark">
                                <span class="text-white">Informasi Catatan Diagnosa</span>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Catatan Anamnesa</label>
                                            <textarea name="riwayat_catatan" id="riwayat_catatan" cols="5" rows="5"
                                                class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Catatan Resep</label>
                                            <textarea rows="5" cols="5" class="form-control" id="riwayat_catatan_resep"
                                                name="riwayat_catatan_resep"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <img class="card-img-top img-fluid" id="img1"
                                                        src="<?= base_url() ?>/assets/images/small/img-1.jpg"
                                                        alt="Card image cap">
                                                    <div class="card-body">
                                                        <h4 class="card-title mt-0">Image Before</h4>
                                                    </div>
                                                    <!--end card -body-->
                                                </div>
                                                <!--end card-->
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <img class="card-img-top img-fluid" id="img2"
                                                        src="<?= base_url() ?>/assets/images/small/img-1.jpg"
                                                        alt="Card image cap">
                                                    <div class="card-body">
                                                        <h4 class="card-title mt-0">Image Diagnosa</h4>
                                                    </div>
                                                    <!--end card -body-->
                                                </div>
                                                <!--end card-->
                                            </div>
                                        </div>
                                        <div class="row pt-2">
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <img class="card-img-top img-fluid" id="img3"
                                                        src="<?= base_url() ?>/assets/images/small/img-1.jpg"
                                                        alt="Card image cap">
                                                    <div class="card-body">
                                                        <h4 class="card-title mt-0">Image Diagnosa</h4>
                                                    </div>
                                                    <!--end card -body-->
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <img class="card-img-top img-fluid" id="img4"
                                                        src="<?= base_url() ?>/assets/images/small/img-1.jpg"
                                                        alt="Card image cap">
                                                    <div class="card-body">
                                                        <h4 class="card-title mt-0">Image After</h4>
                                                    </div>
                                                    <!--end card -body-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                Footer
            </div>
        </div>
    </div>
</div>

<?= $this->EndSection(); ?>