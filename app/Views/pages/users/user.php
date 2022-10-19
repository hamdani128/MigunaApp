<?= $this->Extend('layout/index'); ?>
<?= $this->Section('title'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <!-- <div class="float-right align-item-center mt-2">
                <button class="btn btn-info px-4 align-self-center report-btn">Creat Report</button>
            </div> -->
            <h4 class="page-title mb-2"><i class="mdi mdi-monitor mr-2"></i>Info Users</h4>
            <div class="">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Settings</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Users</a></li>
                    <li class="breadcrumb-item active">Info Users</li>
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
                            <button class="btn btn-md btn-primary" data-toggle="modal" data-target="#my-modal">
                                <i class="fa fa-plus"></i>
                                Tambah User
                            </button>
                        </div>
                    </div>
                    <div class="row pt-5">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table id="table-info-user" class="table dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#No</th>
                                            <th>#Action</th>
                                            <th>Fullname</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Level</th>
                                            <th>Cabang</th>
                                            <th>Created At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(count($datauser) > 0){ $no=1; ?>
                                        <?php foreach($datauser as $row) : ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td>
                                                <div class="button-group">
                                                    <button class="btn btn-md btn-info"
                                                        onclick="edit_user('<?= $row->id; ?>')">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-md btn-danger"
                                                        onclick="delete_user('<?= $row->id; ?>', '<?= $row->fullname; ?>')">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                    <button class="btn btn-md btn-warning"
                                                        onclick="show_password('<?= $row->id; ?>')">
                                                        <i class="fas fa-eye "></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td><?= $row->fullname; ?></td>
                                            <td><?= $row->username; ?></td>
                                            <td><?= $row->email; ?></td>
                                            <td><?= $row->level; ?></td>
                                            <td><?= $row->unit; ?></td>
                                            <td><?= $row->created_at; ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <?php }else{ ?>
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
<!-- End Content -->


<!-- Modal Add -->
<div id="my-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white" id="my-modal-title">Tambah Akun User</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="">Fullname</label>
                            <input type="text" name="fullname" id="fullname" class="form-control"
                                placeholder="Silahkan Isi Fullname">
                        </div>
                        <div class="form-group">
                            <label for="">Username</label>
                            <input type="text" name="username" id="username" class="form-control"
                                placeholder="Silahkan isi Username">
                        </div>
                        <div class="form-group">
                            <label for="">E-Mail</label>
                            <input type="email" name="email" id="email" class="form-control"
                                placeholder="Isi E-Mail Lengkap">
                        </div>
                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="password" name="password" id="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Confirm Password</label>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Unit Cabang</label>
                            <select name="unit_cabang" id="unit_cabang" class="form-control">
                                <option value="">Silahkan Pilih Cabang</option>
                                <?php foreach ($cabang as $row) : ?>
                                <option value="<?= $row->id; ?>"><?= $row->unit; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="simpan_akun_user()"><i class="fa fa-save"></i>
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
                <h5 class="modal-title text-white" id="my-modal-title">Update Akun User</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <input type="hidden" name="id_update" id="id_update">
                        </div>
                        <div class="form-group">
                            <label for="">Fullname</label>
                            <input type="text" name="fullname_update" id="fullname_update" class="form-control"
                                placeholder="Silahkan Isi Fullname">
                        </div>
                        <div class="form-group">
                            <label for="">Username</label>
                            <input type="text" name="username_update" id="username_update" class="form-control"
                                placeholder="Silahkan isi Username">
                        </div>
                        <div class="form-group">
                            <label for="">E-Mail</label>
                            <input type="email" name="email_update" id="email_update" class="form-control"
                                placeholder="Isi E-Mail Lengkap">
                        </div>
                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="password" name="password_update" id="password_update" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Confirm Password</label>
                            <input type="password" name="confirm_password_update" id="confirm_password_update"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Unit Cabang</label>
                            <select name="unit_cabang_update" id="unit_cabang_update" class="form-control">
                                <option value="">Silahkan Pilih Cabang</option>
                                <?php foreach ($cabang as $row) : ?>
                                <option value="<?= $row->id; ?>"><?= $row->unit; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-warning" onclick="update_akun_user()"><i class="fa fa-edit"></i>
                    Simpan Data</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->

<!-- modal show Password -->
<div id="my-modal-password" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white" id="my-modal-title">Info Password Akun User</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>#No</th>
                                        <th>Username</th>
                                        <th>Password</th>
                                        <th>Hash</th>
                                        <th>Updated At</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-info-password">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?= $this->EndSection(); ?>