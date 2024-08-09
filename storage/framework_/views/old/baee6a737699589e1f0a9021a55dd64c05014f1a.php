<?php $__env->startSection('styles'); ?>
  <link rel="stylesheet" href="<?php echo e(asset('public/css/select2.min.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('public/assets/iCheck/skins/flat/green.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('public/css/daterangepicker.css')); ?>">
  <style>
    ul.parsley-errors-list {
        list-style: none;
        color: red;
        padding-left: 0;
        display: none !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 26px;
        position: absolute;
        top: 5px;
        right: 1px;
        width: 20px;
    }
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #a7acb5;
        color: black;
    }
    .x_content {
        padding: 0 5px 6px;
        float: left;
        clear: both;
        margin-top: 0; 
    }
    input[type=number]::-webkit-inner-spin-button {
        opacity: 1
    }
  </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <div class="clearfix"></div>

    <?php echo $__env->make('layouts.message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <div class="col-md-12 col-sm-12 col-xs-12">

        <div class="x_panel">
            <div class="x_title">
                <h2>
                    EDIT RLA (SEED TAGS, VOLUME, SEED COOPERATIVE)
                </h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content form-horizontal form-label-left">
                <table class="table table-bordered table-striped" id="seed_tbl">
                    <thead>
                        <th>Seed Coop</th>
                        <th>Seed Grower</th>
                        <th>Laboratory #</th>
                        <th>Lot #</th>
                        <th>Certification Date</th>
                        <th>Seed Variety</th>
                        <th>Volume</th>
                        <th>Action</th>
                    </thead>
                </table>
            </div>
        </div><br>        

    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src=" <?php echo e(asset('public/js/jquery.inputmask.bundle.js')); ?> "></script>
    <script src=" <?php echo e(asset('public/js/select2.min.js')); ?> "></script>
    <script src=" <?php echo e(asset('public/js/parsely.js')); ?> "></script>
    <script src=" <?php echo e(asset('public/assets/iCheck/icheck.min.js')); ?> "></script>
    <script src=" <?php echo e(asset('public/js/daterangepicker.js')); ?> "></script>

    <script>
        $('#seed_tbl').DataTable().clear();
        $("#seed_tbl").DataTable({
            "bDestroy": true,
            "autoWidth": false,
            "searchHighlight": true,
            "processing": true,
            "serverSide": true,
            "orderMulti": true,
            "order": [],
            "ajax": {
                "url": "<?php echo e(route('coop.rla.edit_tbl')); ?>",
                "dataType": "json",
                "type": "POST",
                "data":{
                    "_token": "<?php echo e(csrf_token()); ?>",
                }
            },
            "columns":[
                {"data": "cooperative_name", searchable: false},
                {"data": "sg_name"},
                {"data": "labNo"},
                {"data": "lotNo"},
                {"data": "certificationDate"},
                {"data": "seedVariety"},
                {"data": "noOfBags"},
                {"data": "action", searchable: false}
            ]
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.index', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>