<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?= $title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A premium admin dashboard template by themesbrand" name="description" />
    <meta content="Mannatthemes" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= base_url() ?>/assets/images/miguna.jpg">
    <link href="<?= base_url() ?>/assets/plugins/jvectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet">

    <!-- DataTables -->
    <link href="<?= base_url() ?>/assets/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet"
        type="text/css" />
    <link href="<?= base_url() ?>/assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet"
        type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="<?= base_url() ?>/assets/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet"
        type="text/css" />

    <!-- Select 2 -->
    <link href="<?= base_url() ?>/assets/plugins/select2/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>/assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css"
        rel="stylesheet">
    <link href="<?= base_url() ?>/assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css"
        rel="stylesheet">
    <link href="<?= base_url() ?>/assets/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css"
        rel="stylesheet" />

    <!-- upload -->
    <link href="<?= base_url() ?>/assets/plugins/dropify/css/dropify.min.css" rel="stylesheet">

    <!-- Sweet Alert -->
    <link href="<?= base_url() ?>/assets/plugins/sweet-alert2/sweetalert2.min.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url() ?>/assets/plugins/sweet-alert2/sweetalert2.css" rel="stylesheet" type="text/css">

    <!-- App css -->
    <link href="<?= base_url() ?>/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>/assets/css/icons.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>/assets/css/metismenu.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>/assets/css/style.css" rel="stylesheet" type="text/css" />

    <!-- Slider -->
    <link href="<?= base_url() ?>/assets/plugins/slick/slick.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>/assets/plugins/slick/slick-theme.css" rel="stylesheet" type="text/css" />

    <style>
    .logo_name {
        font-size: 16px;
        padding-left: 5pt;
        font-family: Arial, Helvetica, sans-serif;
        color: black;
        font-weight: bold;
    }
    </style>
</head>

<body>

    <!-- Top Bar Start -->
    <?= $this->include('layout/topbar'); ?>
    <!-- Top Bar End -->
    <div class="page-wrapper-img">
        <div class="page-wrapper-img-inner">
            <div class="sidebar-user media">
                <img src="<?= base_url() ?>/assets/images/users/user-1.jpg" alt="user"
                    class="rounded-circle img-thumbnail mb-1">
                <span class="online-icon"><i class="mdi mdi-record text-success"></i></span>
                <div class="media-body">
                    <h5 class="text-light"><?= $userinfo->fullname; ?></h5>
                    <ul class="list-unstyled list-inline mb-0 mt-2">
                        <li class="list-inline-item">
                            <a href="javascript: void(0);" class=""><i class="mdi mdi-account text-light"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="javascript: void(0);" class=""><i class="mdi mdi-settings text-light"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="javascript: void(0);" class=""><i class="mdi mdi-power text-danger"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Page-Title -->
            <?= $this->renderSection('title'); ?>
            <!-- end page title end breadcrumb -->
        </div>
    </div>

    <div class="page-wrapper">
        <div class="page-wrapper-inner">

            <!-- Left Sidenav -->
            <?= $this->include('layout/sidebar'); ?>
            <!-- end left-sidenav-->

            <!-- Page Content-->
            <div class="page-content">
                <?= $this->renderSection('content'); ?>
                <!-- container -->

                <?= $this->include('layout/footer'); ?>
            </div>
            <!-- end page content -->
        </div>
    </div>
    <!-- end page-wrapper -->

    <!-- jQuery  -->
    <script src="<?= base_url() ?>/assets/js/jquery.min.js"></script>
    <script src="<?= base_url() ?>/assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>/assets/js/metisMenu.min.js"></script>
    <script src="<?= base_url() ?>/assets/js/waves.min.js"></script>
    <script src="<?= base_url() ?>/assets/js/jquery.slimscroll.min.js"></script>

    <script src="<?= base_url() ?>/assets/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

    <script src="<?= base_url() ?>/assets/plugins/moment/moment.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/apexcharts/apexcharts.min.js"></script>
    <script src="https://apexcharts.com/samples/assets/irregular-data-series.js"></script>
    <script src="https://apexcharts.com/samples/assets/series1000.js"></script>
    <script src="https://apexcharts.com/samples/assets/ohlc.js"></script>
    <script src="<?= base_url() ?>/assets/pages/jquery.dashboard.init.js"></script>
    <!-- upload -->
    <script src="<?= base_url() ?>/assets/plugins/dropify/js/dropify.min.js"></script>
    <script src="<?= base_url() ?>/assets/pages/jquery.form-upload.init.js"></script>
    <!-- Required datatable js -->
    <script src="<?= base_url() ?>/assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Buttons examples -->
    <script src="<?= base_url() ?>/assets/plugins/datatables/dataTables.buttons.min.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/datatables/buttons.bootstrap4.min.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/datatables/jszip.min.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/datatables/pdfmake.min.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/datatables/vfs_fonts.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/datatables/buttons.html5.min.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/datatables/buttons.print.min.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/datatables/buttons.colVis.min.js"></script>
    <!-- Responsive examples -->
    <script src="<?= base_url() ?>/assets/plugins/datatables/dataTables.responsive.min.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/datatables/responsive.bootstrap4.min.js"></script>
    <script src="<?= base_url() ?>/assets/pages/jquery.datatable.init.js"></script>
    <!-- Sweet-Alert  -->
    <script src="<?= base_url() ?>/assets/plugins/sweet-alert2/sweetalert2.min.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/sweet-alert2/sweetalert2.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/sweet-alert2/sweetalert2.all.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/sweet-alert2/sweetalert2.all.min.js"></script>
    <!-- select multiple -->
    <script src="<?= base_url() ?>/assets/plugins/moment/moment.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/select2/select2.min.js"></script>
    <script src="<?= base_url() ?>/assets/pages/jquery.forms-advanced.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js"></script>
    <!-- money -->
    <script src="<?= base_url() ?>/assets/js/jquery.maskMoney.min.js"></script>
    <!-- App js -->
    <script src="<?= base_url() ?>/assets/js/app.js"></script>
    <!-- slider -->
    <script src="<?= base_url() ?>/assets/plugins/slick/slick.min.js"></script>
    <script src="<?= base_url() ?>/assets/pages/jquery.slick.init.js"></script>

    <!-- Custom -->
    <script src="<?= base_url() ?>/assets/js/custom/profile.js"></script>
    <script src="<?= base_url() ?>/assets/js/custom/lokasi.js"></script>
    <script src="<?= base_url() ?>/assets/js/custom/infousers.js"></script>
    <script src="<?= base_url() ?>/assets/js/custom/pasien.js"></script>
    <script src="<?= base_url() ?>/assets/js/custom/kunjungan.js"></script>
    <script src="<?= base_url() ?>/assets/js/custom/product.js"></script>
    <script src="<?= base_url() ?>/assets/js/custom/treatment.js"></script>
    <script src="<?= base_url() ?>/assets/js/custom/transaksi.js"></script>
    <script src="<?= base_url() ?>/assets/js/custom/sdm.js"></script>
    <script src="<?= base_url() ?>/assets/js/custom/transaksi2.js"></script>
</body>

</html>