<?= $this->Extend('layout/index'); ?>
<?= $this->Section('title'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title mb-2"><i class="mdi mdi-monitor mr-2"></i>Informasi Cabang</h4>
            <div class="">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Settings</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Cabang</a></li>
                    <li class="breadcrumb-item active">Info Cabang</li>
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
                            <button class="btn btn-primary btn-md" data-toggle="modal" data-target="#my-modal">
                                <i class="fa fa-plus"></i>
                                Tambah Cabang
                            </button>
                        </div>
                    </div>
                    <div class="row pt-2">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table id="table-cabang" class="table dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#No</th>
                                            <th>#Action</th>
                                            <th>Nama Unit</th>
                                            <th>Alamat Detail</th>
                                            <th>Kecamatan</th>
                                            <th>Kabupatan/Kota</th>
                                            <th>Provinsi</th>
                                            <th>Created At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(count($lokasi) > 0) { $no=1;?>
                                        <?php foreach($lokasi as $row) : ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td>
                                                <div class="button-group">
                                                    <button class="btn btn-md btn-warning"
                                                        onclick="edit_lokasi('<?= $row->id; ?>')">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-md btn-danger"
                                                        onclick="delete_lokasi('<?= $row->id; ?>', '<?= $row->unit; ?>')">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td><?= $row->unit; ?></td>
                                            <td><?= $row->alamat; ?></td>
                                            <td><?= $row->kecamatan; ?></td>
                                            <td><?= $row->kabupaten; ?></td>
                                            <td><?= $row->provinsi; ?></td>
                                            <td><?= $row->created_at; ?></td>
                                        </tr>
                                        <?php endforeach ?>
                                        <?php }else{ ?>
                                        <tr class="text-center">
                                            <td colspan="8">
                                                <h5>Data Anda Kosong</h5>
                                            </td>
                                        </tr>
                                        <?php } ?>
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
<!-- end -->

<!-- Modal Tambah -->
<div id="my-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">Tambah Data Cabang</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-light">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="" class="form-label">Nama Cabang</label>
                            <input type="text" name="unit" id="unit" class="form-control"
                                placeholder="Silahkan isi Nama Cabang">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Alamat Detail Cabang</label>
                            <textarea name="alamat" id="alamat" cols="5" rows="5" class="form-control"
                                placeholder="Silahkan isi Alamat Detail"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Kecamatan</label>
                            <input type="text" name="kecamatan" id="kecamatan" class="form-control"
                                placeholder="Silahkan isi Kecamatan">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Kabupaten / Kotamadya</label>
                            <input type="text" name="kabupaten" id="kabupaten" class="form-control"
                                placeholder="Silahkan isi Kabputen / Kotamadya">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Provinsi</label>
                            <input type="text" name="provinsi" id="provinsi" class="form-control"
                                placeholder="Silahkan isi Provinsi">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="simpan_lokasi()"><i class="fa fa-save"></i>
                    Simpan Data</button>
            </div>
        </div>
    </div>
</div>
<!-- end modal -->


<!-- Update modal -->
<div id="my-modal-edit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-white" id="my-modal-title">Update Data</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-light">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <input type="hidden" name="id_update" id="id_update">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Nama Cabang</label>
                            <input type="text" name="unit_update" id="unit_update" class="form-control"
                                placeholder="Silahkan isi Nama Cabang">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Alamat Detail Cabang</label>
                            <textarea name="alamat_update" id="alamat_update" cols="5" rows="5" class="form-control"
                                placeholder="Silahkan isi Alamat Detail"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Kecamatan</label>
                            <input type="text" name="kecamatan_update" id="kecamatan_update" class="form-control"
                                placeholder="Silahkan isi Kecamatan">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Kabupaten / Kotamadya</label>
                            <input type="text" name="kabupaten_update" id="kabupaten_update" class="form-control"
                                placeholder="Silahkan isi Kabputen / Kotamadya">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Provinsi</label>
                            <input type="text" name="provinsi_update" id="provinsi_update" class="form-control"
                                placeholder="Silahkan isi Provinsi">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-warning" onclick="update_lokasi()"><i class="fa fa-edit"></i>
                    Update Data</button>
            </div>
        </div>
    </div>
</div>
<!-- end Modal -->
<?= $this->EndSection(); ?>