<?= $this->Extend('layout/index'); ?>

<?= $this->Section('title'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <!-- <div class="float-right align-item-center mt-2">
                <button class="btn btn-info px-4 align-self-center report-btn">Creat Report</button>
            </div> -->
            <h4 class="page-title mb-2"><i class="mdi mdi-monitor mr-2"></i>Transaksi Kunjungan</h4>
            <div class="">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Transaksi</a></li>
                    <li roclass="breadcrumb-item"><a href="javascript:void(0);">Kunjungan</a></li>
                    <li class="breadcrumb-item active">Info Transaksi Kunjungan</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<?= $this->EndSection(); ?>


<?= $this->Section('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4">
            <div class="card bg-light">
                <div class="card-body">
                    <div class="row">
                        <div class="col-8 align-self-center">
                            <div class="">
                                <h4 class="mt-0 header-title">Kunjungan</h4>
                                <h2 class="mt-0 font-weight-bold text-dark"><?= $total_kunjungan; ?></h2>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-4 align-self-center">
                            <div class="icon-info text-right">
                                <i class="dripicons-calendar bg-soft-success"></i>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card bg-light">
                <div class="card-body">
                    <div class="row">
                        <div class="col-8 align-self-center">
                            <div class="">
                                <h4 class="mt-0 header-title">Antrian</h4>
                                <h2 class="mt-0 font-weight-bold text-dark"><?= $total_diagnosa; ?></h2>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-4 align-self-center">
                            <div class="icon-info text-right">
                                <i class="dripicons-archive bg-soft-warning"></i>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card bg-light">
                <div class="card-body">
                    <div class="row">
                        <div class="col-8 align-self-center">
                            <div class="">
                                <h4 class="mt-0 header-title">Selesai Treatment / Transaksi</h4>
                                <h2 class="mt-0 font-weight-bold text-dark"><?= $total_transaksi; ?></h2>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-4 align-self-center">
                            <div class="icon-info text-right">
                                <i class="dripicons-basket bg-soft-primary"></i>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div>
            </div>
        </div>
    </div>
    <div class="row pt-2">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table id="table-transaksi-kunjungan" class="table dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>#No</th>
                                            <th>#Action</th>
                                            <th>No.Antrian</th>
                                            <th>ID Pasien</th>
                                            <th>Nama</th>
                                            <th>Catatan Riwayat</th>
                                            <th>Status Tahapan</th>
                                            <th>Tanggal</th>
                                            <th>Created At</th>
                                            <th hidden>status asli</th>
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

<!-- Modal Diagnosa -->
<div id="my-modal-diagnosa" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title_diagnosa"></h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="post" id="form_diagnosa">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="" class="form-label">No.Antrian</label>
                                <h5 id="no_antrian"></h5>
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label">ID.Pasien</label>
                                <h5 id="id_pasien"></h5>
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label">Nama Pasien</label>
                                <h5 id="nama_pasien"></h5>
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label">Diagnosa</label>
                                <textarea name="diagnosa" id="dianosa" rows="5" cols="5" class="form-control"
                                    placeholder="Catatan Diagnosa Berupa Tindakan Penanganan"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label">Resep / Obat</label>
                                <textarea name="resep" id="resep" rows="5" cols="5" class="form-control"
                                    placeholder="Catatan Diagnosa Berupa Tindakan Penanganan"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label">PIC Pelayanan</label>
                                <select name="cmb_pic" id="cmb_pic" class="form-control">
                                    <option value="">Pilih PIC</option>
                                    <?php foreach($sdm as $row) : ?>
                                    <option value="<?php echo $row->id?>"><?= $row->nama; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">Image Before </label>
                                        <input type="file" name="file1" id="input-file-now file1" class="dropify" />
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Image Diagnosa 1</label>
                                        <input type="file" name="file2" id="input-file-now file2" class="dropify" />
                                    </div>
                                </div>
                                <div class="row pt-2">
                                    <div class="col-md-6">
                                        <label for="">Image Diagnosa 2</label>
                                        <input type="file" name="file3" id="input-file-now file3" class="dropify" />
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Image After</label>
                                        <input type="file" name="file4" id="input-file-now file4" class="dropify" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info" onclick="simpan_diagnosa()">
                    <i class="fa fa-save"></i>
                    Simpan Data
                </button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Diagnosa -->

<?= $this->EndSection(); ?>