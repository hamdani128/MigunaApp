<?= $this->Extend('layout/index'); ?>
<?= $this->Section('title'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title mb-2"><i class="mdi mdi-monitor mr-2"></i>Info Setting</h4>
            <div class="">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Settings</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Settings</a></li>
                    <li class="breadcrumb-item active">Info All Settings</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>


<?= $this->Section('content'); ?>
<!-- Content -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">

                            <div class="card-body">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">List Info Printer</label>
                                        <select name="" id="" class="form-control">
                                            <option value="">Printer</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end card-body-->
        </div>
    </div>
</div>
<!-- End Content -->


<?= $this->EndSection(); ?>