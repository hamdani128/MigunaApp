<?= $this->Extend('layout/index'); ?>

<?= $this->Section('title'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <!-- <div class="float-right align-item-center mt-2">
                <button class="btn btn-info px-4 align-self-center report-btn">Creat Report</button>
            </div> -->
            <h4 class="page-title mb-2"><i class="mdi mdi-monitor mr-2"></i>Dashboard</h4>
            <div class="">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Frogetor</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">Dashboard 1</li>
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
            <div class="card"
                style="background-image: url('/assets/images/clean.jpg');background-repeat: no-repeat;background-size: cover;">
                <div class="card-body">
                    <div class="row text-right">
                        <div class="col-lg-12 text-white text-center">
                            <img src="<?= base_url() ?>/upload/<?= $profile->file; ?>" style="width: 30%;height: 50%;"
                                alt="">
                            <h4 class="text-dark"><?= $profile->nama; ?></h4>
                            <h4 class="text-dark">Alamat : <?= $profile->alamat; ?></h4>
                            <h5 class="text-dark">No.Telepon : <?= $profile->no_hp; ?> </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end row-->
    <!-- row -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="ribbon-1">
                        <div class="robbon-box">
                            <div class="ribbon ribbon-mark bg-danger">List Ulang Tahun Pasien</div>
                            <div class="mb-0"></div>
                            <div class="table-responsive mt-4">
                                <table class="table table-hover mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="border-top-0">NIK</th>
                                            <th class="border-top-0">Nama</th>
                                            <th class="border-top-0">Jenis Kelamin</th>
                                            <th class="border-top-0">Tanggal Lahir</th>
                                            <th class="border-top-0">Alamat</th>
                                            <th class="border-top-0">Status</th>
                                        </tr>
                                        <!--end tr-->
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <span>1207020812950002</span>
                                            </td>
                                            <td>
                                                Riski Hamdani
                                            </td>
                                            <td>Laki - Laki</td>
                                            <td>08-12-1995</td>
                                            <td>Medan</td>
                                            <td>
                                                <span class="badge badge-boxed  badge-soft-success">Today</span>
                                            </td>
                                        </tr>
                                        <!--end tr-->
                                    </tbody>
                                </table>
                                <!--end table-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end card-->
        </div>
        <!--end col-->
    </div>
    <!-- end row -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="ribbon-1">
                        <div class="robbon-box">
                            <div class="ribbon ribbon-mark bg-dark">Info Riwayat</div>
                            <div class="mb-0"></div>
                            <div class="table-responsive mt-4">
                                <table class="table table-hover mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="border-top-0">NIK</th>
                                            <th class="border-top-0">Nama</th>
                                            <th class="border-top-0">Jenis Kelamin</th>
                                            <th class="border-top-0">Tanggal Lahir</th>
                                            <th class="border-top-0">Alamat</th>
                                            <th class="border-top-0">Status</th>
                                        </tr>
                                        <!--end tr-->
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <span>1207020812950002</span>
                                            </td>
                                            <td>
                                                Riski Hamdani
                                            </td>
                                            <td>Laki - Laki</td>
                                            <td>08-12-1995</td>
                                            <td>Medan</td>
                                            <td>
                                                <span class="badge badge-boxed  badge-soft-success">Today</span>
                                            </td>
                                        </tr>
                                        <!--end tr-->
                                    </tbody>
                                </table>
                                <!--end table-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end card-->
        </div>
        <!--end col-->
    </div>
</div>
<?= $this->EndSection(); ?>