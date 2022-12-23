<?= $this->Extend('layout/index'); ?>

<?= $this->Section('title'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <!-- <div class="float-right align-item-center mt-2">
                <button class="btn btn-info px-4 align-self-center report-btn">Creat Report</button>
            </div> -->
            <h4 class="page-title mb-2"><i class="mdi mdi-monitor mr-2"></i>Transaksi Tretment</h4>
            <div class="">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Transaksi</a></li>
                    <li roclass="breadcrumb-item"><a href="javascript:void(0);">Treatment</a></li>
                    <li class="breadcrumb-item active">Info Transaksi Treatment</li>
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
                    <span class="badge badge-danger">Visits</span>
                    <h3 class="font-weight-bold" id="visit_jlh">0</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="float-right">
                        <i class="dripicons-cart  font-20 text-secondary"></i>
                    </div>
                    <span class="badge badge-info">Potongan</span>
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
                    <span class="badge badge-success">Subtotal</span>
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
                    <span class="badge badge-dark">Total All</span>
                    <h3 class="font-weight-bold">Rp.0</h3>
                </div>
            </div>
        </div>
    </div>
    <!-- end Card -->

    <!-- list Transaksi -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <button class="btn btn-info btn-md" onclick="call_add_transaksi_treat()">
                                <i class="fa fa-plus"></i>
                                Tambah Transaksi
                            </button>
                            <button class="btn btn-dark btn-md">
                                <i class="fa fa-print"></i>
                                Export Data Transaksi
                            </button>
                            <button class="btn btn-success btn-md" onclick="refresh_summary_tr_trans()">
                                <i class="fas fa-recycle"></i>
                                Refresh
                            </button>
                        </div>
                    </div>

                    <div class="row pt-3">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table id="table-transaksi-treatment" class="table dt-responsive nowrap  table-bordered"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#No</th>
                                            <th>#Action</th>
                                            <th>No.Transaksi</th>
                                            <th>No.Antrian</th>
                                            <th>ID Pasien</th>
                                            <th>Nama Pasien</th>
                                            <th>Subtotal</th>
                                            <th>Qty (item)</th>
                                            <th>Potongan</th>
                                            <th>Metode Bayar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (count($transaksi_treat) > 0) {  ?>
                                        <?php $no = 1 ?>
                                        <?php foreach ($transaksi_treat as $row) { ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td>
                                                <div class="button-group">
                                                    <button class="btn btn-md btn-dark"
                                                        onclick="cetak_struk('<?= $row->transaksi_id; ?>')">
                                                        <i class="fa fa-print"></i>
                                                    </button>
                                                    <button class="btn btn-md btn-danger">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                    <button class="btn btn-md btn-warning"
                                                        onclick="list_transaksi('<?= $row->transaksi_id; ?>', '<?= date('Y-m-d') ?>')">
                                                        <i class="fa fa-list"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td><?= $row->transaksi_id; ?></td>
                                            <td><?= $row->no_antrian; ?></td>
                                            <td><?= $row->pasien_id; ?></td>
                                            <td><?= $row->nama; ?></td>
                                            <td><?= number_format($row->subtotal); ?></td>
                                            <td><?= $row->qty; ?></td>
                                            <td><?= $row->potongan; ?></td>
                                            <td><?= $row->metode_bayar; ?></td>
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
<!-- End contetn -->


<!-- Modal Tambah Transaksi -->
<div id="my-modal-addtreat" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white" id="my-modal-title">New Transaksi</h5>
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
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">ID.Transaksi</label>
                                            <h5 id="id_transaksi"><?= $id_transaksi; ?></h5>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="form-label">No.Antrian</label>
                                            <select name="cmb_antrian" id="cmb_antrian" class="form-control"
                                                onchange="OnChangeNoAntrian()">
                                                <option value="">Pilih</option>
                                                <?php foreach ($list_antrian as $row) { ?>
                                                <option value="<?= $row->no_antrian; ?>"><?= $row->no_antrian; ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">ID.Pasien </label>
                                                    <h6 id="pasien_id">-</h6>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="">Nama Pasien </label>
                                                    <h6 id="nama_pasien">-</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="">Catatan Anamnesa ( Treatment )</label>
                                                    <textarea name="cat_anamnesa" id="cat_anamnesa" cols="2" rows="2"
                                                        class="form-control"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Catatan Obat ( Resep )</label>
                                                    <textarea name="cat_resep" id="cat_resep" cols="2" rows="2"
                                                        class="form-control"></textarea>
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
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="" class="form-label">Metode Bayar</label>
                                            <select name="cmb_metode_byr" id="cmb_metode_byr" class="form-control"
                                                onchange="onChangeMetodeBayar()">
                                                <option value="">Pilih Metode</option>
                                                <option value="Cash">Cash</option>
                                                <option value="Debit ATM">Debit ATM</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="form-label">Catatan Tambahan</label>
                                            <textarea name="catatan_tr" id="catatan_tr" cols="5" rows="3"
                                                class="form-control"></textarea>
                                        </div>
                                        <div id="debit" style="display: none;">
                                            <div class="form-group">
                                                <label for="" class="form-label">Masukkan No.Transaksi Debit</label>
                                                <input type="text" class="form-control" name="no_transaksi_debit"
                                                    id="no_transaksi_debit"
                                                    placeholder="Masukkan No Transaksi Debit Anda">
                                            </div>
                                            <div class="form-grop">
                                                <label for="">Upload Buktu Transaksi</label>
                                                <input type="file" id="input-file-now img_bukti" name="img_bukti"
                                                    class="dropify" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="" class="form-label">Masukkan Nominal Transaksi</label>
                                            <input type="text" name="nominal_bayar" id="nominal_bayar"
                                                onkeypress="return hanyaAngka(event)"
                                                style="font-size: 18pt;font-weight: bold;" class="form-control money">
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="form-label">Kembalian .</label>
                                            <h3>Rp.<span id="kembalian_harga">0</span></h3>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="card bg-dark">
                                            <div class="card-body">
                                                <div class="form-group text-right text-white">
                                                    <span>Total Belanja.</span>
                                                    <h2>Rp.<span id="total_bel"></span></h2>
                                                </div>
                                                <div class="form-group text-right text-white">
                                                    <span>Total Potongan.</span>
                                                    <h2>Rp.<span id="total_pot_bel"></span></h2>
                                                </div>
                                                <div class="form-group text-right text-white">
                                                    <span>Total Item.</span>
                                                    <h3><span id="total_qty_bel"></span></h3>
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
                            <div class="card-title bg-dark">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h5 class="text-white pl-2">List Treatment</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-7">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="" class="form-label">
                                                                Masukan Nama Treatment
                                                            </label>
                                                            <select class="select2 form-control mb-0 custom-select"
                                                                id="cmb_treat" style="width: 100%; height:36px;"
                                                                onchange="onChangeTreat()">
                                                                <option value="">Pilih :</option>
                                                                <?php foreach ($list_treat as $row) { ?>
                                                                <optgroup label="<?= $row->kategori; ?>">
                                                                    <option value="<?= $row->id; ?>"><?= $row->nama; ?>
                                                                    </option>
                                                                </optgroup>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="" class="form-label">Kode Ref.</label>
                                                            <input type="text" class="form-control" name="kode_ref"
                                                                id="kode_ref" placeholder="">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="" class="form-label">Harga</label>
                                                            <input type="number" class="form-control" name="harga"
                                                                id="harga" placeholder="" readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="" class="form-label">Qty</label>
                                                            <input type="number" name="qty_treat" id="qty_treat"
                                                                class="form-control" onchange="onChangeQtyTreatment()">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="" class="form-label">Subtotal</label>
                                                            <input type="text" name="subtotal_treat" id="subtotal_treat"
                                                                class="form-control" value="0" readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="" class="form-label">Jlh.Potongan</label>
                                                            <input type="text" name="potongan_treat" id="potongan_treat"
                                                                class="form-control" value="0">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="" class="form-label">Masukkan Jumlah
                                                                Potongan</label>
                                                            <input type="text" name="jlh_pot_treat" id="jlh_pot_treat"
                                                                class="form-control" value="0"
                                                                onkeyup="OnChangeJlhPotonganTreat()">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="" class="form-label">Masukkan Jumlah Diskon
                                                                (%)</label>
                                                            <input type="text" name="jlh_disc_treat" id="jlh_disc_treat"
                                                                class="form-control" value="0"
                                                                onkeyup="OnChangeJlhDiscTreat()">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="" class="form-label">Descripsi</label>
                                                            <textarea name="desc_treat" id="desc_treat" cols="1"
                                                                rows="1" class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <button class="btn btn-md btn-block btn-info"
                                                            onclick="masukkan_list_treat()"><i class="fa fa-plus"></i>
                                                            Masukkan List
                                                        </button>
                                                        <button class="btn btn-md btn-block btn-dark"
                                                            onclick="awal_treat1()"><i class="fas fa-redo"></i>
                                                            Clear
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="card bg-success">
                                            <div class="card-body">
                                                <div class="form-group text-right text-white">
                                                    <span>Total Belanja.</span>
                                                    <h2>Rp.<span id="total_treat">0</span></h2>
                                                </div>
                                                <div class="form-group text-right text-white">
                                                    <span>Total Potongan.</span>
                                                    <h2>Rp.<span id="total_pot_treat">0</span></h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row pt-1">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table id="table-list-treatment"
                                                        class="table dt-responsive nowrap table-bordered table-striped"
                                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 10%;text-align: center;">#Action</th>
                                                                <th>Kode</th>
                                                                <th>Treament</th>
                                                                <th>Harga</th>
                                                                <th>Qty</th>
                                                                <th>Subtotal</th>
                                                                <th>Potongan</th>
                                                                <th>Description</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tbody-list-tretment">

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
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-title bg-dark">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h5 class="text-white pl-2">List Produk / Obat</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-7">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="">Nama Produk / Obat</label>
                                                            <select class="select2 form-control mb-0 custom-select"
                                                                id="cmb_prod" style="width: 100%; height:36px;"
                                                                onchange="onChangeProduct()">
                                                                <option value="">Pilih :</option>
                                                                <?php foreach ($list_product as $row) { ?>
                                                                <option value="<?= $row->id; ?>"><?= $row->nama; ?>
                                                                </option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Kode Ref.</label>
                                                            <input type="text" name="kode_ref_prod" id="kode_ref_prod"
                                                                class="form-control">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Satuan</label>
                                                            <input type="text" name="satuan_prod" id="satuan_prod"
                                                                class="form-control">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Harga</label>
                                                            <div class="input-group">
                                                                <input type="text" name="harga_prod" id="harga_prod"
                                                                    class="form-control" value="0" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="">Qty | Qty Sebelum | Qty Sesudah</label>
                                                            <div class="input-group">
                                                                <input type="number" name="qty_prod" id="qty_prod"
                                                                    class="form-control" value="0"
                                                                    onchange="onChangeQtyProduct()">
                                                                <input type="text" name="stok_prod" id="stok_prod"
                                                                    class="form-control" value="0" readonly>
                                                                <input type="text" name="after_stok_prod"
                                                                    id="after_stok_prod" class="form-control" value="0"
                                                                    readonly>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Subtotal</label>
                                                            <input type="text" name="subs_prod" id="subs_prod"
                                                                class="form-control" readonly value="0">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Jumlah Potongan</label>
                                                            <input type="text" name="pot_prod" id="pot_prod"
                                                                class="form-control" readonly value="0">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Masukkan => Potongan | Discount (%)
                                                            </label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control"
                                                                    name="nominal_pot_prod" id="nominal_pot_prod"
                                                                    onkeyup="InputPotonganProd()">
                                                                <input type="number" class="form-control"
                                                                    name="nominal_disc_prod" id="nominal_disc_prod"
                                                                    onkeyup="InputDiscProd()">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <button class="btn btn-md btn-block btn-info"
                                                            onclick="masukkan_list_prod()"><i class="fa fa-plus"></i>
                                                            Masukkan List
                                                        </button>
                                                        <button class="btn btn-md btn-block btn-dark"
                                                            onclick="awal_prod1()"><i class="fas fa-redo"></i>
                                                            Clear
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="card bg-warning">
                                            <div class="card-body">
                                                <div class="form-group text-right text-white">
                                                    <span>Total Belanja.</span>
                                                    <h2>Rp.<span id="total_prod">0</span></h2>
                                                </div>
                                                <div class="form-group text-right text-white">
                                                    <span>Total Potongan.</span>
                                                    <h2>Rp.<span id="total_pot_prod">0</span></h2>
                                                </div>
                                                <div class="form-group text-right text-white">
                                                    <span>Total Qty.</span>
                                                    <h2><span id="qty_prod_sale">0</span></h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row pt-1">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table id="table-list-treatment"
                                                        class="table dt-responsive nowrap table-bordered table-striped"
                                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                        <thead>
                                                            <tr>
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
                                                        <tbody id="tbody-list-product">

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
                </div>
            </div>
            <div class="modal-footer">
                <div class="row text-right">
                    <div class="col-lg-12">
                        <button class="btn btn-xl btn-success" onclick="simpan_transaksi()">
                            <i class="fa fa-save"></i>
                            Simpan
                        </button>
                        <button class="btn btn-xl btn-dark">
                            <i class="fa fa-print"></i>
                            Riwayat
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Transaksi -->





<!-- Modal List Transaksi -->
<div id="my-modal-list" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white">
                    <span id="title-transaksi">-</span>
                    <span id="title-date">-</span>
                </h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-3">
                        <h4>Informasi Pasien</h4>
                        <div class="form-group">
                            <label for="">ID Pasien</label>
                            <h5 id="list_id_pasien">-</h5>
                        </div>
                        <div class="form-group">
                            <label for="">Nama Pasien</label>
                            <h5 id="list_nama_pasien">-</h5>
                        </div>
                        <div class="form-group">
                            <label for="">NIK</label>
                            <h5 id="list_nik">-</h5>
                        </div>
                        <div class="form-group">
                            <label for="">No.Antrian</label>
                            <h5 id="list_antrian"></h5>
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
                                <h6 class="text-white">Treatment</h6>
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
                                                        <th>Description</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="list-treat-tbody">

                                                </tbody>
                                            </table>
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
                                                <tbody id="list_prod_tbody">

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
                <div class="row text-right">
                    <div class="col-lg-12">
                        <button class="btn btn-dark btn-md">
                            <i class="mdi mdi-printer"></i>
                            Cetak Invoice
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Modal List Transaksi -->


<?= $this->EndSection(); ?>