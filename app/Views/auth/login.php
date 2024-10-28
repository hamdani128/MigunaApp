<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Login Administrator</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A premium admin dashboard template by mannatthemes" name="description" />
    <meta content="Mannatthemes" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= base_url() ?>/assets/images/icon.png">
    <!-- Sweet Alert -->
    <link href="<?= base_url() ?>/assets/plugins/sweet-alert2/sweetalert2.min.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url() ?>/assets/plugins/sweet-alert2/sweetalert2.css" rel="stylesheet" type="text/css">
    <!-- App css -->
    <link href="<?= base_url() ?>/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>/assets/css/icons.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>/assets/css/metismenu.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>/assets/css/style.css" rel="stylesheet" type="text/css" />

</head>

<body class="account-body">

    <!-- Log In page -->
    <div class="row vh-100">
        <div class="col-lg-3  pr-0">
            <div class="card mb-0 shadow-none">
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-12">
                            <a href="#" class="logo"><img src="<?= base_url() ?>/assets/images/Logo-Primary.png"
                                    height="55" alt="logo" class="my-0"></a>
                            <p class="text-muted mb-0">Sign in to continue to Gluehealth Care.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="px-3">
                                <div class="media">
                                    <div class="media-body ml-3 align-self-center">
                                        <!-- <h4 class="mt-0 mb-1">Login on Miguna App</h4> -->
                                    </div>
                                </div>

                                <!-- Alert -->
                                <?php if (!empty(session()->getFlashdata('fail'))) : ?>
                                <div class="alert alert-danger" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <i class="dripicons-wrong mr-2"></i> <strong>Notifikasi</strong><br>
                                    <?= session()->getFlashdata('fail'); ?>
                                </div>
                                <?php endif ?>

                                <?php if (!empty(session()->getFlashdata('logout'))) : ?>
                                <div class="alert alert-success" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <i class="dripicons-checkmark mr-2"></i> <strong>Notifikasi</strong><br>
                                    <?= session()->getFlashdata('logout'); ?>
                                </div>
                                <?php endif ?>

                                <?php if (!empty(session()->getFlashdata('warning'))) : ?>
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true"><i class="mdi mdi-close"></i></span>
                                    </button>
                                    <strong>Warning!</strong> <?= session()->getFlashdata('warning') ?>.
                                </div>
                                <?php endif ?>
                                <!-- End Alert -->


                                <form class="form-horizontal my-4" action="#">

                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"><i
                                                        class="mdi mdi-account-outline font-16"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="username" id="username"
                                                placeholder="Enter username">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="userpassword">Password</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon2"><i
                                                        class="mdi mdi-key font-16"></i></span>
                                            </div>
                                            <input type="password" class="form-control" name="password" id="password"
                                                placeholder="Enter password">
                                        </div>
                                    </div>

                                    <div class="form-group row mt-4">
                                        <!-- <div class="col-sm-6">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customControlInline">
                                        <label class="custom-control-label" for="customControlInline">Remember
                                            me</label>
                                    </div>
                                </div> -->
                                        <div class="col-sm-12 text-right">
                                            <a href="#" class="text-muted font-13" onclick="lupa_password_show()">
                                                <i class="mdi mdi-lock"></i>
                                                Lupa Password ?
                                            </a>
                                        </div>
                                    </div>

                                    <div class="form-group mb-0 row">
                                        <div class="col-12 mt-2">
                                            <button class="btn btn-primary btn-block waves-effect waves-light"
                                                type="button" onclick="login_administrator()">
                                                Masuk
                                                <i class="fas fa-sign-in-alt ml-1"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg-9 p-0 d-flex justify-content-center">
            <div class="accountbg d-flex align-items-center">
                <div class="account-title text-white text-center">
                    <img src="<?= base_url() ?>/assets/images/Logo-Secondary.png" alt=""
                        style="width: 50%;height: 50%;">

                    <h3 class="">Mari Bergabung Dan Rasakan Pelayanan Kami </h3>
                    <!-- <p class="font-14 mt-3">Tidak Punya Akun ? <a href="" class="text-primary">Sign up</a></p> -->

                </div>
            </div>
        </div>
    </div>
    <!-- End Log In page -->

    <!-- Show Modal Forgot password -->
    <div id="my-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h5 class="modal-title text-white" id="my-modal-title">Lupa Password</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>In develop</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-dark" onclick="simpan_data_pasien_by_admin()">
                        <i class="fa fa-save"></i>
                        Update Password
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery  -->
    <script src="<?= base_url() ?>/assets/js/jquery.min.js"></script>
    <script src="<?= base_url() ?>/assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>/assets/js/metisMenu.min.js"></script>
    <script src="<?= base_url() ?>/assets/js/waves.min.js"></script>
    <script src="<?= base_url() ?>/assets/js/jquery.slimscroll.min.js"></script>

    <!-- Sweet-Alert  -->
    <script src="<?= base_url() ?>/assets/plugins/sweet-alert2/sweetalert2.min.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/sweet-alert2/sweetalert2.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/sweet-alert2/sweetalert2.all.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/sweet-alert2/sweetalert2.all.min.js"></script>
    <!-- App js -->
    <script src="<?= base_url() ?>/assets/js/app.js"></script>
    <!-- Custom -->
    <script src="<?= base_url() ?>/assets/js/custom/login.js"></script>

</body>

</html>