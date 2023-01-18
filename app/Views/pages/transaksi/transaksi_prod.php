<?= $this->Extend('layout/index'); ?>

<?= $this->Section('title'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <!-- <div class="float-right align-item-center mt-2">
                <button class="btn btn-info px-4 align-self-center report-btn">Creat Report</button>
            </div> -->
            <h4 class="page-title mb-2"><i class="mdi mdi-monitor mr-2"></i>Transaksi Product</h4>
            <div class="">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Transaksi</a></li>
                    <li roclass="breadcrumb-item"><a href="javascript:void(0);">Product</a></li>
                    <li class="breadcrumb-item active">Info Transaksi Product</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<?= $this->EndSection(); ?>

<?= $this->Section('content'); ?>
<div class="container-fluid">
    <!-- begin card -->
    <div class="row justify-content-center">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="float-right">
                        <i class="dripicons-user-group font-24 text-secondary"></i>
                    </div>
                    <span class="badge badge-danger">Jumlah Transaksi</span>
                    <h3 class="font-weight-bold" id="jlh_transaksi">0</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="float-right">
                        <i class="dripicons-cart  font-20 text-secondary"></i>
                    </div>
                    <span class="badge badge-info">Total Belanja</span>
                    <h3 class="font-weight-bold" id="potongan_jlh">Rp.0</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="float-right">
                        <i class="dripicons-jewel font-20 text-secondary"></i>
                    </div>
                    <span class="badge badge-success">Total Potongan</span>
                    <h3 class="font-weight-bold">Rp.0</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="float-right">
                        <i class="dripicons-wallet font-20 text-secondary"></i>
                    </div>
                    <span class="badge badge-dark">Total Item Keluar</span>
                    <h3 class="font-weight-bold">0</h3>
                </div>
            </div>
        </div>
    </div>
    <!-- end Card -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row pb-2">
                        <div class="col-lg-12">
                            <button class="btn btn-info btn-md" onclick="call_add_transaksi_prod()">
                                <i class="fa fa-plus"></i>
                                Tambah Transaksi
                            </button>
                            <button class="btn btn-dark btn-md">
                                <i class="fa fa-print"></i>
                                Export Data Transaksi
                            </button>
                            <button class="btn btn-success btn-md" onclick="refresh_summary_tr_prod()">
                                <i class="fas fa-recycle"></i>
                                Refresh
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="table-transaksi-product" class="table dt-responsive nowrap  table-bordered"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#No</th>
                                            <th>#Action</th>
                                            <th>No.Transaksi</th>
                                            <th>Metode Bayar</th>
                                            <th>Date</th>
                                            <th>Subtotal</th>
                                            <th>Potongan</th>
                                            <th>Konsumen</th>
                                            <th>NIK</th>
                                            <th>No.Hp</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (count($transaksi) > 0) { ?>
                                        <?php $no = 1; ?>
                                        <?php foreach ($transaksi as $row) { ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td>
                                                <div class="button-group">
                                                    <button class="btn btn-md btn-danger"
                                                        onclick="delete_transaksi_product('<?= $row->no_transaksi; ?>')">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                    <button class="btn btn-md btn-info"
                                                        onclick="list_invoice_product('<?= $row->no_transaksi; ?>')">
                                                        <i class="fa fa-list"></i>
                                                    </button>
                                                    <button class="btn btn-md btn-success"
                                                        onclick="cetak_invoice_prodcut('<?= $row->no_transaksi; ?>')">
                                                        <i class="fa fa-print"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td><?= $row->no_transaksi; ?></td>
                                            <td><?= $row->metode_bayar; ?></td>
                                            <td><?= $row->date; ?></td>
                                            <td>
                                                <?= 'Rp.' . str_replace(',', '.', number_format($row->subtotal)); ?>
                                            </td>
                                            <td>
                                                <?= 'Rp.' . str_replace(',', '.', number_format($row->potongan)); ?>
                                            </td>
                                            <td>
                                                <?= $row->nama; ?>
                                            </td>
                                            <td>
                                                <?= $row->nik; ?>
                                            </td>
                                            <td>
                                                <?= $row->hp; ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
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
<!-- End Coneten -->


<!-- Modal Tambah Transaksi-->
<div id="my-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white" id="my-modal-title">No.Transaksi : <span
                        id="no_transaksi"><?= $kode_transaksi; ?></span></h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Kode dan Nama Items</label>
                                            <div class="input-group">
                                                <input type="text" name="kode" id="kode" class="form-control"
                                                    placeholder="Masukkan Kode">
                                                <select class="select2 form-control mb-0 custom-select" id="cmb_prod"
                                                    style="width: 40%; height:36px;" onchange="OnchangeProductByName()">
                                                    <option value="">Pilih Item Product :</option>
                                                    <?php foreach ($list_product as $row) { ?>
                                                    <option value="<?= $row->nama; ?>"><?= $row->nama; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <input type="text" class="form-control" name="satuan" id="satuan"
                                                    readonly>
                                                <button class="btn btn-md btn-dark">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-info btn-md btn-block"
                                                onclick="masukkan_list_belanja()">
                                                <i class="fa fa-plus"></i>
                                                Masukkan Kedalam List
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Harga dan Qty</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="harga" id="harga"
                                                    readonly>
                                                <input type="number" class="form-control" name="qty" id="qty"
                                                    onchange="OnChangeQty()" onkeyup="OnChangeQty()">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Subtotal Belanja</label>
                                            <input type="text" name="subtotal" id="subtotal" class="form-control"
                                                readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Subtotal Potongan</label>
                                            <input type="text" name="potongan" id="potongan" class="form-control"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Masukkan Potongan Nilai</label>
                                            <div class="input-group">
                                                <input type="text" name="sub_dipotong" id="sub_dipotong"
                                                    class="form-control" onkeyup="potongan_nilai()">
                                                <button class="btn btn-md btn-dark" onclick="potongan_nilai()">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Masukkan Nilai Discount(%)</label>
                                            <div class="input-group">
                                                <input type="text" name="sub_discount" id="sub_discount"
                                                    onkeyup="potongan_discount()" class="form-control">
                                                <button class="btn btn-md btn-dark" onclick="potongan_discount()">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display: block;">
                                            <label for="" id="desc_1"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-dark">
                                <div class="row">
                                    <div class="col-md-12">
                                        <span for="" class="text-white">List Item Belanja</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table id="table-list-treatment"
                                                        class="table dt-responsive nowrap table-bordered table-striped"
                                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th style="text-align: center;">No</th>
                                                                <th style="width: 10%;text-align: center;">#Action</th>
                                                                <th>Kode</th>
                                                                <th>Produk / Obat</th>
                                                                <th>Satuan</th>
                                                                <th>Harga</th>
                                                                <th>Qty</th>
                                                                <th>Subtotal</th>
                                                                <th>Potongan</th>
                                                                <th>Deskripsi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tbody-list-trans-prod">

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="card bg-primary">
                                            <div class="card-body">
                                                <div class="form-group text-right text-white">
                                                    <span>Subtotal Potongan.</span>
                                                    <h2><span id="potongan_all">0</span></h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card bg-info">
                                            <div class="card-body">
                                                <div class="form-group text-right text-white">
                                                    <span>Qty.</span>
                                                    <h2><span id="qty_all">0</span></h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card bg-success">
                                            <div class="card-body">
                                                <div class="form-group text-right text-white">
                                                    <span>Subtotal Belanja.</span>
                                                    <h2><span id="subtotal_all">0</span></h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                <div class="row">
                                    <div class="col-md-12">
                                        <span class="text-white">Pembayaran</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="">Kategori Konsumen</label>
                                            <select name="cmb_konsumen" id="cmb_konsumen" class="form-control"
                                                onchange="OnChngeKonsumen()">
                                                <option value="">Pilih Kategori</option>
                                                <option value="umum">Umum</option>
                                                <option value="Pasien">Pasien</option>
                                            </select>
                                            <label for="">ID Pasien : <span id="id_pasien"></span></label>
                                        </div>
                                        <div class="form-group" id="pasien_x" style="display: none;">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="card">
                                                        <div class="card-body bg-light">
                                                            <div class="table-responsive">
                                                                <table id="table-pasien-admin-product"
                                                                    class="table dt-responsive nowrap"
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
                                        <div class="form-group">
                                            <label for="">Nama Konsumen</label>
                                            <input type="text" name="nama_konsumen" id="nama_konsumen"
                                                class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-md btn-light" onclick="clear_konsumen()">
                                                <i class="fa fa-recycle"></i>
                                                Clear
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">No.HP</label>
                                            <input type="text" name="no_hp" id="no_hp" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Alamat</label>
                                            <input type="text" name="alamat" id="alamat" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="">NIK</label>
                                            <input type="text" name="nik" id="nik" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Metode Bayar</label>
                                            <select name="cmb_metode_bayar" id="cmb_metode_bayar" class="form-control"
                                                onchange="OnChangeMetodeBayar()">
                                                <option value="">Pilih Metode Bayar</option>
                                                <option value="Cash">Cash</option>
                                                <option value="Debit ATM">Debit ATM</option>
                                            </select>
                                            <div class="debit" id="debit" style="display: none;padding-top: 5pt;">
                                                <label for="">No.Transaksi Debit</label>
                                                <input type="text" class="form-control" name="no_transaksi_debit"
                                                    id="no_transaksi_debit"
                                                    placeholder="Masukkan No Transaksi Debit Anda">
                                                <label for="">Upload Bukti Transaksi</label>
                                                <input type="file" id="input-file-now img_bukti" name="img_bukti"
                                                    class="dropify" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Masukkan Pembayaran</label>
                                            <input type="text" name="nominal_bayar_product" id="nominal_bayar_product"
                                                style="font-size: 20pt;font-weight: bold;height: 50px;width: 100%;"
                                                class="form-control money">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Kembalian</label>
                                            <h4 id="kembalian">0</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-lg-12">
                        <button class="btn btn-info btn-md" onclick="simpan_transaksi_product()">
                            <i class="fa fa-save"></i>
                            <span class="hide-text">Simpan Transaksi</span>
                            <div class="spinner" style="display: none;"><i role="status"
                                    class="spinner-border spinner-border-sm spinner-border-custom-4 text-white"></i>
                                Loading..
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->


<!-- Modal List Riwayat -->
<div id="my-modal-invoice" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white" id="my-modal-title">No.Invoice : <span id="no_invoice_list"></span>
                </h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden\="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-3">
                        <h4>Informasi Konsumen</h4>
                        <div class="form-group">
                            <label for="">Kategori Konsumen</label>
                            <h5 id="kategori_konsumen">-</h5>
                        </div>
                        <div class="form-group">
                            <label for="">NIK</label>
                            <h5 id="nik_konsumen">-</h5>
                        </div>
                        <div class="form-group">
                            <label for="">Nama Konsumen</label>
                            <h5 id="nama_konsumen_new">-</h5>
                        </div>
                        <div class="form-group">
                            <label for="">Alamat</label>
                            <h5 id="alamat_konsumen">-</h5>
                        </div>
                        <div class="form-group">
                            <label for="">No.Handphone</label>
                            <h5 id="no_hp_konsumen">-</h5>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="" class="form-label">Metode Bayar</label>
                            <h5 id="list_metode_bayar">0</h5>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Jumlah Dibayar</label>
                            <h5 id="list_jumlah_dibayar">0</h5>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Kembalian</label>
                            <h5 id="list_kembalian">0</h5>
                        </div>
                    </div>
                    <div class="col-md-4 text-right">
                        <div class="form-grup">
                            <label for="" class="form-label">Jlh Qty.</label>
                            <h3 id="list_qty">0</h3>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Subtotal</label>
                            <h3 id="list_subtotal"></h3>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-dark">
                                <h6 class="text-white">Product / Obat</h6>
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
                                                        <th>Deskripsi</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="list_trans_prod_tbody">

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
            <div class="modal-footer">
                <button class="btn btn-dark btn-md">
                    <i class="mdi mdi-printer"></i>
                    Cetak Invoice
                </button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal List Riwayat -->
<?= $this->endSection(); ?>