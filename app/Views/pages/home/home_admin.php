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
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body mb-0">
                    <div class="row">
                        <div class="col-8 align-self-center">
                            <div class="">
                                <h4 class="mt-0 header-title">Total Sales</h4>
                                <h2 class="mt-0 font-weight-bold text-dark">40k</h2>
                                <p class="mb-0 text-muted"><span class="text-success"><i
                                            class="mdi mdi-arrow-up"></i>14.5%</span> Up From Last Week
                                </p>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-4 align-self-center">
                            <div class="icon-info text-right">
                                <i class="dripicons-cart bg-soft-warning"></i>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div>
                <!--end card-body-->
                <div class="card-body overflow-hidden p-0">
                    <div class="d-flex mb-0 h-100 dash-info-box">
                        <div class="w-100">
                            <div class="apexchart-wrapper">
                                <div id="dash_spark_1" class="chart-gutters"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end card-body-->
            </div>
            <!--end card-->
        </div>
        <!--end col-->

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body mb-0">
                    <div class="row">
                        <div class="col-8 align-self-center">
                            <div class="">
                                <h4 class="mt-0 header-title">Total Revenue</h4>
                                <h2 class="mt-0 font-weight-bold text-dark">$9090</h2>
                                <p class="mb-0 text-muted"><span class="text-success"><i
                                            class="mdi mdi-arrow-up"></i>14.5%</span> Up from yesterday
                                </p>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-4 align-self-center">
                            <div class="icon-info text-right">
                                <i class="dripicons-wallet bg-soft-success"></i>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div>
                <!--end card-body-->
                <div class="card-body overflow-hidden p-0">
                    <div class="d-flex mb-0 h-100 dash-info-box">
                        <div class="w-100">
                            <div class="apexchart-wrapper">
                                <div id="apex_column1" class="chart-gutters"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end card-body-->
            </div>
            <!--end card-->
        </div>
        <!--end col-->
        <div class="col-lg-4">
            <div class="card carousel-bg-img">
                <div class="card-body dash-info-carousel mb-0">
                    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="row">
                                    <div class="col-12 align-self-center">
                                        <div class="text-center">
                                            <h4 class="mt-0 header-title text-left">Average Product
                                                Price</h4>
                                            <div class="icon-info my-3">
                                                <i class="dripicons-jewel bg-soft-pink"></i>
                                            </div>
                                            <h2 class="mt-0 font-weight-bold text-dark">$1280.00</h2>
                                            <p class="mb-1 text-muted"><span class="text-success"><i
                                                        class="mdi mdi-arrow-up"></i>35.5%</span> Last
                                                100 Subscriptions</p>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </div>
                            <!--end carousel-item-->
                            <div class="carousel-item">
                                <div class="row">
                                    <div class="col-12 align-self-center">
                                        <div class="text-center">
                                            <h4 class="mt-0 header-title text-left">New Orders</h4>
                                            <div class="icon-info my-3">
                                                <i class="dripicons-basket bg-soft-info"></i>
                                            </div>
                                            <h2 class="mt-0 font-weight-bold text-dark">1824</h2>
                                            <p class="mb-1 text-muted"><span class="text-danger"><i
                                                        class="mdi mdi-arrow-down"></i>1.5%</span> Down
                                                From Last week</p>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </div>
                            <!--end carousel-item-->

                            <div class="carousel-item">
                                <div class="row">
                                    <div class="col-12 align-self-center">
                                        <div class="text-center">
                                            <h4 class="mt-0 header-title text-left">Order Returns</h4>
                                            <div class="icon-info my-3">
                                                <i class="dripicons-swap bg-soft-primary"></i>
                                            </div>
                                            <h2 class="mt-0 font-weight-bold text-dark">11.1%</h2>
                                            <p class="mb-1 text-muted"><span class="text-success"><i
                                                        class="mdi mdi-arrow-up"></i>11.1%</span> Up
                                                from Last Month</p>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </div>
                            <!--end carousel-item-->
                            <div class="carousel-item">
                                <div class="row">
                                    <div class="col-12 align-self-center">
                                        <div class="text-center">
                                            <h4 class="mt-0 header-title text-left">Total Brands</h4>
                                            <div class="icon-info my-3">
                                                <i class="dripicons-store bg-soft-warning"></i>
                                            </div>
                                            <h2 class="mt-0 font-weight-bold text-dark">92</h2>
                                            <p class="mb-1 text-muted">All International Brands</p>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </div>
                            <!--end carousel-item-->
                            <div class="carousel-item">
                                <div class="row">
                                    <div class="col-12 align-self-center">
                                        <div class="text-center">
                                            <h4 class="mt-0 header-title text-left">Total Visits</h4>
                                            <div class="icon-info my-3">
                                                <i class="dripicons-user-group bg-soft-success"></i>
                                            </div>
                                            <h2 class="mt-0 font-weight-bold text-dark">35k</h2>
                                            <p class="mb-1 text-muted"><span class="text-success"><i
                                                        class="mdi mdi-arrow-up"></i>11.1%</span> Up
                                                from yesterday</p>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </div>
                            <!--end carousel-item-->
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button"
                            data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleControls" role="button"
                            data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
                <!--end card-body-->
            </div>
            <!--end card-->
        </div>
        <!--end col-->
    </div>
    <!--end row-->
</div>
<?= $this->EndSection(); ?>