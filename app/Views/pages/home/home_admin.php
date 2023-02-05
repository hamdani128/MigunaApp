<?= $this->Extend('layout/index'); ?>

<?= $this->Section('title'); ?>
<div class="row pb-2">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="float-right align-item-center mt-0">
                <div class="row">


                </div>
            </div>
            <h4 class="page-title mb-2"><i class="mdi mdi-monitor mr-2"></i>Dashboard</h4>
            <div class="">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Owner</a></li>
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
                <div class="card-body bg-dark" style="background-image: url(/assets/images/clean.jpg);">
                    <div class="row">
                        <div class="col-md-7 text-right">
                        </div>
                        <div class="col-md-4">
                            <label for="" class="text-black">Filter</label>
                            <select name="" id="" class="form-control">
                                <option value="">Pilih</option>
                                <option value="Hari ini">Hari ini</option>
                                <option value="Hari Semalam (Kemarin)">Hari Semalam (Kemarin)</option>
                                <option value="Bulan ini">Bulan ini</option>
                                <option value="Bulan Kemarin">Bulan Kemarin</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="float-right">
                        <i class="dripicons-user-group font-24 text-secondary"></i>
                    </div>
                    <span class="badge badge-danger">Pendaftaran Pasien Baru</span>
                    <h3 class="font-weight-bold">24 <small> /orang</small></h3>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <button class="btn btn-block btn-md btn-danger">
                            <i class="fas fa-eye"></i>
                            view
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="float-right">
                        <i class="dripicons-wallet  font-20 text-secondary"></i>
                    </div>
                    <span class="badge badge-info">Penjualan Produk</span>
                    <h3 class="font-weight-bold">10k</h3>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <button class="btn btn-block btn-md btn-info">
                            <i class="fas fa-eye"></i>
                            view
                        </button>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="float-right">
                        <i class="dripicons-wallet font-20 text-secondary"></i>
                    </div>
                    <span class="badge badge-success">Penjualan Treatment</span>
                    <h3 class="font-weight-bold">8400</h3>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <button class="btn btn-block btn-md btn-success">
                            <i class="fas fa-eye"></i>
                            view
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="float-right">
                        <i class="dripicons-user-group font-20 text-secondary"></i>
                    </div>
                    <span class="badge badge-warning">Jumlah Kunjungan</span>
                    <h3 class="font-weight-bold">2450<small>/ orang</small></h3>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <button class="btn btn-block btn-md btn-warning">
                            <i class="fas fa-eye"></i>
                            view
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">Revenue</h4>
                    <div class="apexchart-wrapper chart-demo">
                        <div id="e-dash1" class="chart-gutters"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end row-->
</div>
<?= $this->EndSection(); ?>