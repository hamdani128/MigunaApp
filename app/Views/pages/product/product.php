<?= $this->Extend('layout/index'); ?>
<?= $this->Section('title'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title mb-2"><i class="mdi mdi-monitor mr-2"></i>Informasi Product</h4>
            <div class="">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Master</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Product</a></li>
                    <li class="breadcrumb-item active">Info Product</li>
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
            <div class="card bg-light">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Nav tabs -->
                            <ul class="nav nav-pills nav-justified" role="tablist">
                                <li class="nav-item waves-effect waves-light">
                                    <a class="nav-link active" data-toggle="tab" href="#home-1" role="tab">
                                        <i class="mdi mdi-archive"></i>
                                        Info Product
                                    </a>
                                </li>
                                <li class="nav-item waves-effect waves-light">
                                    <a class="nav-link" data-toggle="tab" href="#profile-1" role="tab">
                                        <i class="mdi mdi-calendar-multiple"></i>
                                        Info Supplier
                                    </a>
                                </li>
                                <!-- <li class="nav-item waves-effect waves-light">
                                    <a class="nav-link" data-toggle="tab" href="#settings-1" role="tab">Settings</a>
                                </li> -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- row -->
    <div class="row pt-2">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active p-3" id="home-1" role="tabpanel">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <button class="btn btn-md btn-info" data-toggle="modal"
                                                data-target="#my-modal-product">
                                                <i class="fa fa-plus"></i>
                                                Tambah Product
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row pt-5">
                                        <div class="col-lg-12">
                                            <div class="table-responsive">
                                                <table id="table-product" class="table dt-responsive nowrap"
                                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>#No</th>
                                                            <th>#Action</th>
                                                            <th>Kode Product</th>
                                                            <th>Nama Product</th>
                                                            <th>Satuan</th>
                                                            <th>Harga</th>
                                                            <th>Qty</th>
                                                            <th>Subtotal</th>
                                                            <th>Suupplier</th>
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
                                <div class="tab-pane p-3" id="profile-1" role="tabpanel">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <button class="btn btn-md btn-info" data-toggle="modal"
                                                data-target="#my-modal-supplier">
                                                <i class="fa fa-plus"></i>
                                                Tambah Supplier
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row pt-5">
                                        <div class="col-lg-12">
                                            <div class="table-responsive">
                                                <table id="table-supplier" class="table dt-responsive nowrap"
                                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>#No</th>
                                                            <th>#Action</th>
                                                            <th>Supplier</th>
                                                            <th>Alamat</th>
                                                            <th>No.Telepon</th>
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
                                <!-- <div class="tab-pane p-3" id="settings-1" role="tabpanel">
                                    <p class="text-muted mb-0">
                                        Trust fund seitan letterpress, keytar raw denim keffiyeh etsy
                                        art party before they sold out master cleanse gluten-free squid
                                        scenester freegan cosby sweater. Fanny pack portland seitan DIY,
                                        art party locavore wolf cliche high life echo park Austin. Cred
                                        vinyl keffiyeh DIY salvia PBR, banh mi before they sold out
                                        farm-to-table VHS viral locavore cosby sweater. Lomo wolf viral,
                                        mustache readymade thundercats keffiyeh craft beer marfa
                                        ethical. Wolf salvia freegan, sartorial keffiyeh echo park
                                        vegan.
                                    </p>
                                </div> -->
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
<div id="my-modal-product" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
    aria-hidden="true">
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
                            <label for="" class="form-label">Kode Produk</label>
                            <h5 id="kode"><?= $kodeproduct; ?></h5>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Nama Produk</label>
                            <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama Produk">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Satuan</label>
                            <input type="text" name="satuan" id="satuan" class="form-control"
                                placeholder="Satuan Produk">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Harga</label>
                            <input type="number" name="harga" id="harga" class="form-control" onkeyup="penjumlahan()">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Qty</label>
                            <input type="number" name="qty" id="qty" class="form-control" onkeyup="penjumlahan()">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Subtotal</label>
                            <input type="number" id="subtotal" name="subtotal" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Supplier</label>
                            <select name="supplier" id="supplier" class="form-control">
                                <option value="">Pilih Supplier</option>
                                <?php if(count($supplier) > 0): ?>
                                <?php foreach($supplier as $row)  : ?>
                                <option value="<?= $row->id; ?>"><?= $row->supplier; ?></option>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="simpan_data_product_byadmin()"><i
                        class="fa fa-save"></i>
                    Simpan Data</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->

<!-- Edit Modal Product -->
<div id="my-modal-product-edit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
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
                            <input type="hidden" name="id_update" id="id_update" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Kode Produk</label>
                            <h5 id="kode_update">-</h5>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Nama Produk</label>
                            <input type="text" name="nama_update" id="nama_update" class="form-control"
                                placeholder="Nama Produk">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Satuan</label>
                            <input type="text" name="satuan_update" id="satuan_update" class="form-control"
                                placeholder="Satuan Produk">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Harga</label>
                            <input type="number" name="harga_update" id="harga_update" class="form-control"
                                onkeyup="penjumlahan2()">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Qty</label>
                            <input type="number" name="qty_update" id="qty_update" class="form-control"
                                onkeyup="penjumlahan2()">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Subtotal</label>
                            <input type="number" id="subtotal_update" name="subtotal_update" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Supplier</label>
                            <select name="supplier_update" id="supplier_update" class="form-control">
                                <option value="">Pilih Supplier</option>
                                <?php if(count($supplier) > 0): ?>
                                <?php foreach($supplier as $row)  : ?>
                                <option value="<?= $row->id; ?>"><?= $row->supplier; ?></option>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-warning" onclick="update_data_product_byadmin()"><i
                        class="fa fa-edit"></i>
                    Update Data</button>
            </div>
        </div>
    </div>
</div>
<!-- End Edit Modal -->


<!-- Add Modal Supplier -->
<div id="my-modal-supplier" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white" id="my-modal-title">Tambah Data Supplier</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="" class="form-label">Nama Supplier</label>
                            <input type="text" name="nama_supplier" id="nama_supplier" class="form-control"
                                placeholder="Nama Supplier">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Alamat Supplier</label>
                            <textarea name="alamat_supplier" id="alamat_supplier" cols="5" rows="5" class="form-control"
                                placeholder="Alamat Lengkap Supplier"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">No.Telepon</label>
                            <input type="text" name="no_telepon" id="no_telepon" class="form-control"
                                placeholder="No.Telepon">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">E-Mail</label>
                            <input type="email" name="email_supplier" id="email_supplier" class="form-control"
                                placeholder="Email Supplier">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="simpan_data_supplier()"><i
                        class="fa fa-save"></i>
                    Simpan Data</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->

<!-- Update Modal Supplier -->
<div id="my-modal-supplier-edit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-white" id="my-modal-title">Update Data Supplier</h5>
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
                            <label for="" class="form-label">Nama Supplier</label>
                            <input type="text" name="nama_supplier_update" id="nama_supplier_update"
                                class="form-control" placeholder="Nama Supplier">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Alamat Supplier</label>
                            <textarea name="alamat_supplier_update" id="alamat_supplier_update" cols="5" rows="5"
                                class="form-control" placeholder="Alamat Lengkap Supplier"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">No.Telepon</label>
                            <input type="text" name="no_telepon_update" id="no_telepon_update" class="form-control"
                                placeholder="No.Telepon">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">E-Mail</label>
                            <input type="email" name="email_supplier_update" id="email_supplier_update"
                                class="form-control" placeholder="Email Supplier">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-warning" onclick="update_data_supplier()"><i
                        class="fa fa-edit"></i>
                    Update Data</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Update -->


<?= $this->EndSection(); ?>