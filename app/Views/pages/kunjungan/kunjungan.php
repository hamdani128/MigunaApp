<?= $this->Extend('layout/index'); ?>

<?= $this->Section('title'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <!-- <div class="float-right align-item-center mt-2">
                <button class="btn btn-info px-4 align-self-center report-btn">Creat Report</button>
            </div> -->
            <h4 class="page-title mb-2"><i class="mdi mdi-monitor mr-2"></i>Informasi Kunjungan</h4>
            <div class="">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Master</a></li>
                    <li roclass="breadcrumb-item"><a href="javascript:void(0);">Kunjungan</a></li>
                    <li class="breadcrumb-item active">Info Kunjungan</li>
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
                            <h5>Filter Tanggal</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="" class="form-label">Mulai</label>
                                <input type="date" name="mulai" id="mulai" class="form-control"
                                    placeholder="silahkan Input Tanggal">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="" class="form-label">Sampai Dengan</label>
                                <div class="input-group">
                                    <input type="date" name="sampai" id="sampai" class="form-control"
                                        placeholder="Silahkan input tanggal">
                                    <button class="btn btn-md btn-primary"><i class="fa fa-filter"></i> Pilih</button>
                                </div>
                            </div>
                        </div>
                    </div>
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
                            <table id="table-antrian" class="table dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>#No</th>
                                        <th>#Action</th>
                                        <th>No. Antrian</th>
                                        <th>ID Pasien</th>
                                        <th>Nama</th>
                                        <th>Catatan Riwayat</th>
                                        <th>Status Tahapan</th>
                                        <th>Tanggal</th>
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
<?= $this->EndSection(); ?>