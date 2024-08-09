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
                    Please fill-up all the required fields on the from.
                </h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content form-horizontal form-label-left">
                <form enctype="multipart/form-data" method="post" action="<?php echo e(route('coop.rla.bpi_save_request')); ?>">
                <?php echo e(csrf_field()); ?>

                    <div class="form-horizontal form-label-left">
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-2">Seed Cooperative:</label>
                            <div class="col-md-10 col-sm-10 col-xs-10">
                                <select name="coop" id="coop" class="form-control" required>
                                    <option value="0">Please select a seed cooperative</option>
                                    <?php foreach($coop_list as $row): ?>
                                        <option value="<?php echo e($row->accreditation_no); ?>"><?php echo e($row->coopName); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-2">Seed Grower:</label>
                            <div class="col-md-10 col-sm-10 col-xs-10" required>
                                <select name="sg_name" id="sg_name" class="form-control" required></select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-2">Certification Date:</label>
                            <div class="col-md-10 col-sm-10 col-xs-10">
                                <input type="date" name="certification_date" id="certification_date" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-2">Lab Number:</label>
                            <div class="col-md-10 col-sm-10 col-xs-10">
                                <input type="text" class="form-control" name="lab_number" id="lab_number" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-2">Lot Number:</label>
                            <div class="col-md-10 col-sm-10 col-xs-10">
                                <input type="text" class="form-control" name="lot_number" id="lot_number" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-2">Seed Variety:</label>
                            <div class="col-md-10 col-sm-10 col-xs-10">
                                <select name="variety" id="variety" class="form-control" required>
                                    <option value="0">Please select a seed variety</option>
                                    <?php foreach($variety_list as $row): ?>
                                        <option value="<?php echo e($row->variety); ?>"><?php echo e($row->variety); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-2"># of Bags:</label>
                            <div class="col-md-10 col-sm-10 col-xs-10">
                                <input type="number" class="form-control" name="bags" id="bags" min="1" max="240" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-2"></label>
                            <div class="col-md-10 col-sm-10 col-xs-10">
                                <input class="btn btn-success pull-right" type="submit" value="Send Request for RLA Upload">
                            </div>
                        </div>
                    </div>
                </form>
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
        $("#variety").select2();
        $("#sg_name").select2({
			"tags": true	
		});
        $("#coop").select2();

        $("#coop").on("change", function(e){
            var coop = $(this).val();
            
            $("#sg_name").empty().append("<option value='0'>loading seed grower list...</option>");
            $.ajax({
                type: 'POST',
                url: "<?php echo e(route('coop.rla.manual_sgList')); ?>",
                data: {
                    _token: "<?php echo e(csrf_token()); ?>",
                    coop: coop,
                },
                success: function (data) {
                    $("#sg_name").empty().append(data);
                }
            });
        });

        
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.index', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>