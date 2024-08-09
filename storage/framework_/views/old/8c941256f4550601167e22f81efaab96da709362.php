<?php $qr_side = "active"; $qr_home="active"?>



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

    <div class="clearfix"></div>

    <?php echo $__env->make('layouts.message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <div class="col-md-12 col-sm-12 col-xs-12">

        

        <div class="x_panel">
            <div class="x_title">
                <h2>
                    E-Binhi Payments (Manual Form)
                </h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content form-horizontal form-label-left">
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-2">
                                    <h2> <span class="badge badge-info" style="width:100%;">Billing Date</span> </h2>
                                    
                            </div>
                            <div class="col-md-3">
                                <input type="date" id="billing_date" name="billing_date" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                    <h1> <span class="badge badge-success" style="width:100%;">No.</span> </h1>
                                    
                            </div>
                            <div class="col-md-5">
                                 <h1> <span class="badge badge-success" style="width:100%;">Cooperative</span> </h1>
                            </div>
                            <div class="col-md-5">
                                <h1> <span class="badge badge-success" style="width:100%;">No of Bag(s)</span> </h1>
                            </div>
                            
                        </div>




                        <?php for($x = 1; $x<11; $x++): ?>

                        <div class="row">
                            <div class="col-md-2">
                                    <h2> <span class="badge badge-info" style="width:100%;">Payee <?php echo e($x); ?></span> </h2>
                                    
                            </div>
                            <div class="col-md-5">
                                    <select class="form-control form-select coop_class" id="coop_<?php echo e($x); ?>" name="coop_<?php echo e($x); ?>">
                                        <option value="0">Please select a coop</option>
                                        <?php foreach($coop as $coop_data): ?>
                                            <option value="<?php echo e($coop_data->id); ?>"><?php echo e($coop_data->coop_name); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                            </div>
                            <div class="col-md-5">
                                <input type="number" class="form-control" id="bags_<?php echo e($x); ?>" name="bags_<?php echo e($x); ?>" placeholder="No of Bags">
                            </div>
                        </div>

                        <?php endfor; ?>
                        


                        
                    </div>


                    <div class="col-md-4" style="vertical-align: bottom;">
                        <br> <br> <br>
                        
                        <button class="btn btn-success form-control" id="dbp_form"><i class="fa fa-database" ></i> DBP FORM</button>
                        <button class="btn btn-success form-control" id="oth_banks"><i class="fa fa-database"></i> OTHER BANKS FORM</button>
                        
                    </div>
                    
                </div><hr>
                
            </div>
        </div>

    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src=" <?php echo e(asset('public/js/daterangepicker.js')); ?> "></script>
    <script src=" <?php echo e(asset('public/js/jquery.inputmask.bundle.js')); ?> "></script>
    <script src=" <?php echo e(asset('public/js/select2.min.js')); ?> "></script>
    <script src=" <?php echo e(asset('public/js/parsely.js')); ?> "></script>
    <script src=" <?php echo e(asset('public/assets/iCheck/icheck.min.js')); ?> "></script>
    <script src=" <?php echo e(asset('public/js/daterangepicker.js')); ?> "></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(".form-select").select2();
        
        $("#oth_banks").on("click", function(){
            var data_arr = [];
            var URL_SITE = "<?php echo e(url('/')); ?>";
            var billing_date = $("#billing_date").val();
                if(billing_date == ""){
                    Swal.fire(
                    "No Inputed Date",
                    "Please Select Date",
                    "danger"
                );
                return;
                }


            $('.coop_class').each(function(index, element) {
            var id = $(this).attr('id');
            var no = id.replace("coop_","");
            var coop_name = $("#"+id).val();
            var bags = $("#bags_"+no).val();
            var concat_data = coop_name+";"+bags;

                if(coop_name == "0" || parseInt(bags)<= 0){
                  
                }else{
                    data_arr.push(concat_data);
                }
                

             });

             if(data_arr.length >0){
                window.open(URL_SITE+"/paymaya/manual_form/oth/"+data_arr+"/"+billing_date,"_blank");
             }else{
                Swal.fire(
                    "No Inputed Data",
                    "Please Select and Put No. of Bags",
                    "danger"
                );
             }

             
        });
     

        $("#dbp_form").on("click", function(){
            var data_arr = [];
            var URL_SITE = "<?php echo e(url('/')); ?>";
            var billing_date = $("#billing_date").val();
                if(billing_date == ""){
                    Swal.fire(
                    "No Inputed Date",
                    "Please Select Date",
                    "danger"
                );
                return;
                }


            $('.coop_class').each(function(index, element) {
            var id = $(this).attr('id');
            var no = id.replace("coop_","");
            var coop_name = $("#"+id).val();
            var bags = $("#bags_"+no).val();
            var concat_data = coop_name+";"+bags;

                if(coop_name == "0" || parseInt(bags)<= 0){
                  
                }else{
                    data_arr.push(concat_data);
                }
                

             });

             if(data_arr.length >0){
                window.open(URL_SITE+"/paymaya/manual_form/dbp/"+data_arr+"/"+billing_date,"_blank");
             }else{
                Swal.fire(
                    "No Inputed Data",
                    "Please Select and Put No. of Bags",
                    "danger"
                );
             }

             
        });


    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.index', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>