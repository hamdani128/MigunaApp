<?= $this->Extend('layout/index'); ?>
<?= $this->Section('title'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title mb-2"><i class="mdi mdi-monitor mr-2"></i>Informasi Treatment</h4>
            <div class="">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Master</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Treatment</a></li>
                    <li class="breadcrumb-item active">Info Treatment</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<?= $this->EndSection(); ?>

<?= $this->Section('content'); ?>
<div class="container-fluid">
    <!-- row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <button class="btn btn-md btn-info" data-toggle="modal" data-target="#my-modal">
                                <i class="fa fa-plus"></i>
                                Tambah
                            </button>
                        </div>
                    </div>
                    <div class="row pt-5">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table id="table-treatment" class="table dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#No</th>
                                            <th>#Action</th>
                                            <th>ID Treatment</th>
                                            <th>Nama</th>
                                            <th>Harga</th>
                                            <th>Kategori</th>
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
<!-- End Contetn -->

<!-- Add Modal -->
<div id="my-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white" id="my-modal-title">Tambah Data Product</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="" class="form-label">ID Treatment</label>
                            <h5 id="id_treat"><?= $kodetreatment; ?></h5>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Nama Treatment</label>
                            <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama Treatment">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Harga</label>
                            <input type="number" name="harga" id="harga" value="0" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="" id="form-label">Kategori</label>
                            <input type="text" name="kategori" id="kategori" class="form-control"
                                placeholder="Kategori Treatment">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info" onclick="simpan_data_treatment()"><i class="fa fa-save"></i>
                    Simpan Data</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->

<!-- Edit Modal Product -->
<div id="my-modal-edit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-white" id="my-modal-title">Update Data Product</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="" class="form-label">ID Treatment</label>
                            <h5 id="id_treat_update">-</h5>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Nama Treatment</label>
                            <input type="text" name="nama_update" id="nama_update" class="form-control"
                                placeholder="Nama Treatment">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Harga</label>
                            <input type="number" name="harga_update" id="harga_update" value="0" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="" id="form-label">Kategori</label>
                            <input type="text" name="kategori_update" id="kategori_update" class="form-control"
                                placeholder="Kategori Treatment">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-warning" onclick="update_data_treatment_byadmin()"><i
                        class="fa fa-edit"></i>
                    Update Data</button>
            </div>
        </div>
    </div>
</div>
<!-- End Edit Modal -->



<?= $this->EndSection(); ?>