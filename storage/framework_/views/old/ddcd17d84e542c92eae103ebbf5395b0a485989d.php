<?php $inspection_side = "active"; $inspection_form="active"?>



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
  </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php /* CSRF TOKEN */ ?>
    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">

    <div>

        <div class="row">
                <h1>Assign Inspector (Second Inspection for Buffer Inventory)</h1>
        </div>


        <form action="<?php echo e(route('rcef.inspector.buffer.save')); ?>" method="POST" id="registryForm" data-parsley-validate>
        <?php echo csrf_field(); ?>

        <div class="clearfix"></div>

            <?php echo $__env->make('layouts.message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <div class="col-md-6 col-sm-12 col-xs-12">
                <!-- delivery details -->
                <div class="x_panel">
                <div class="x_title">
                    <h2>1. Choose a Location</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content form-horizontal form-label-left">
                    <br/>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-3">Region:</label>
                            <div class="col-md-9 col-sm-9 col-xs-9">
                                <select name="drop_region" id="drop_region" class="form-control" data-parsley-min="1">
                                    <option value="0">Please select a Region</option>
                                    <?php foreach($buffer_data as $buffer): ?>
                                        <option value="<?php echo e($buffer->region); ?>"><?php echo e($buffer->region); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-3">Province:</label>
                            <div class="col-md-9 col-sm-9 col-xs-9">
                                <select name="drop_province" id="drop_province" class="form-control" data-parsley-min="1">
                                    <option value="0">Please select a Province</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-3">Municipality:</label>
                            <div class="col-md-9 col-sm-9 col-xs-9">
                                <select name="drop_municipality" id="drop_municipality" class="form-control" data-parsley-min="1">
                                    <option value="0">Please select a Municipality</option>
                                </select>
                            </div>
                        </div>

                       
                </div>
                </div><br>
                <!-- /delivery details -->

                <!-- seed grower details -->
                <div class="x_panel">
                <div class="x_title">
                    <h2 style="width: 100%;vertical-align">2. Confirmed Deliveries</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content form-horizontal form-label-left">
                    <br/>
                    <label class="control-label col-md-3 col-sm-3 col-xs-3">Cooperative:</label>

                    <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-9">
                            <select name="dropOffID" id="dropOffID" class="form-control" data-parsley-min="1">
                                <option value="0">Please select Cooperative</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-2"></label>
                        <div class="col-md-10 col-sm-10 col-xs-10" id="batch_list_container">

                        </div>
                    </div>

                  
                </div>
                </div>
                <!-- /seed grower details -->
            </div>


            <div class="col-md-6 col-sm-6 col-xs-6">
                <!-- farm performance -->
                <div class="x_panel">
                    <div class="x_title">
                    <h2>3. Delivery Inspector</h2>
                    <div class="clearfix"></div>
                    </div>
                    <div class="x_content form-horizontal form-label-left">
                    <br/>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-3">Personnel <span>*</span></label>
                            <div class="col-md-9 col-sm-9 col-xs-9">
                                <select name="inspectorID" id="inspectorID" class="form-control" data-parsley-min="1">
                                    <option value="0">Please select a delivery inspector</option>
                                    <?php foreach($inspector_details as $inspector_detail): ?>
                                        <?php if($inspector_detail->middleName = '' || $inspector_detail->extName = ''): ?>
                                            <option value="<?php echo e($inspector_detail->userId); ?>"><?php echo e($inspector_detail->firstName); ?> <?php echo e($inspector_detail->lastName); ?> - (<?php echo e($inspector_detail->username); ?>)</option>
                                        <?php else: ?>
                                            <option value="<?php echo e($inspector_detail->userId); ?>"><?php echo e($inspector_detail->firstName); ?> <?php echo e($inspector_detail->middleName); ?> <?php echo e($inspector_detail->lastName); ?> <?php echo e($inspector_detail->extName); ?> - (<?php echo e($inspector_detail->username); ?>)</option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="ln_solid"></div>

                       

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-3">Remarks:</label>
                            <div class="col-md-9 col-sm-9 col-xs-9">
                               <textarea name="pmo_remarks" class="form-control" id="pmo_remarks" rows="5" placeholder="Please enter your remarks..."></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-9 col-md-offset-3">
                                <input type="submit" id="submit_btn" class="btn btn-round btn-success" value="save & Validate">
                            </div>
                        </div>
                    </div>
                    </div><br>
                <!-- /farm performance -->
        </div>
        </form>



    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src=" <?php echo e(asset('public/js/jquery.inputmask.bundle.js')); ?> "></script>
    <script src=" <?php echo e(asset('public/js/select2.min.js')); ?> "></script>
    <script src=" <?php echo e(asset('public/js/parsely.js')); ?> "></script>
    <script src=" <?php echo e(asset('public/assets/iCheck/icheck.min.js')); ?> "></script>
    <script src=" <?php echo e(asset('public/js/daterangepicker.js')); ?> "></script>

    <script>
        $("#inspectorID").select2();
        $("#ticket_list").select2({
            tags: true
        });

        $("#drop_region").on("change", function(e){
            var region = $(this).val();
            $("#coop_region").val("loading please wait...");
            $("#drop_province").empty().append("<option value='0'>Loading provinces please wait...</option>");
            $("#drop_municipality").empty().append("<option value='0'>Please select a municipality</option>");
            $("#delivery_date").empty().val("Please Select Location");
            $("#date_of_inspection").empty().val("Please Select Location");
            $("#dropOffID").empty().append("<option value='0'>Please Select Location");
            $("#batch_list_container").empty();

            $.ajax({
                type: 'POST',
                url: "<?php echo e(route('api.provinces.buffer.dropoff')); ?>",
                data: {
                    _token: "<?php echo e(csrf_token()); ?>",
                    region: region
                },
                success: function(data){
                    $("#drop_province").empty().append("<option value='0'>Please select a Province</option>");
                    $("#drop_province").append(data);
                }
            });
        });

        $("#drop_province").on("change", function(e){
            var province = $(this).val();
            $("#drop_municipality").empty().append("<option value='0'>Loading municipalities please wait...</option>");
            $("#delivery_date").empty().val("Please Select Location");
            $("#date_of_inspection").empty().val("Please Select Location");
            $("#dropOffID").empty().append("<option value='0'>Please Select Location");
            $("#batch_list_container").empty();

            $.ajax({
                type: 'POST',
                url: "<?php echo e(route('api.municipalities.buffer.dropoff')); ?>",
                data: {
                    _token: "<?php echo e(csrf_token()); ?>",
                    province: province
                },
                success: function(data){
                    $("#drop_municipality").empty().append("<option value='0'>Please select a municipality</option>");
                    $("#drop_municipality").append(data);
                }
            });
        });


         $("#drop_municipality").on("change", function(e){
            var province = $("#drop_province").val();
            var municipality = $("#drop_municipality").val();
            var region = $("#drop_region").val();
            $("#delivery_date").empty().val("Please Select Location");
            $("#date_of_inspection").empty().val("Please Select Location");
            $("#dropOffID").empty().append("<option value='0'>Loading Coop please wait...</option>");
            $("#batch_list_container").empty();

            $.ajax({
                type: 'POST',
                url: "<?php echo e(route('api.dropoff.buffer.search')); ?>",
                data: {
                    _token: "<?php echo e(csrf_token()); ?>",
                    province: province,
                    municipality: municipality,
                    region: region
                },
                success: function(data){
                    $("#dropOffID").empty().append("<option value='0'>Please select a Cooperative</option>");
                    $("#dropOffID").append(data);
                }
            });
        });




        $("#dropOffID").on("change", function(e){
            var coop_accre = $(this).val();
            var region  = $("#drop_region").val();
            var province  = $("#drop_province").val();
            var municipality  = $("#drop_municipality").val();

            $("#delivery_date").val("loading ticket details please wait...");
            $("#date_of_inspection").val("loading please wait...");
            $("#delivery_date").empty().val("Please Select Location");
            $("#date_of_inspection").empty().val("Please Select Location");
             $("#batch_list_container").empty();

            $.ajax({
                type: 'POST',
                url: "<?php echo e(route('api.dropoff.buffer.details')); ?>",
                data: {
                    _token: "<?php echo e(csrf_token()); ?>",
                    region: region,
                    province: province,
                    municipality: municipality,
                    coop_accre: coop_accre
                },
                success: function(data){
                    $("#delivery_date").val(data["delivery_date"]);
                    $("#batch_list_container").empty().html(data["batch_string"]);
                    $("#date_of_inspection").val(data["delivery_date"]);
                }
            });
        });

        //check fields...
        $("#submit_btn").on("click", function(e){
            e.preventDefault();

            if($("#inspectorID").val() == "0"){
                alert("Please select a delivery inspector");
            }else{
                $("#registryForm").submit();
            }
        })
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.index', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>