<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/css/select2.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('public/css/daterangepicker.css')); ?>">

    <style>
        .btn-success[disabled]{
            background: #26B99A;
            border: 1px solid #169F85;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php /* CSRF TOKEN */ ?>
<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">

        <div class="col-md-12">

            <?php foreach($arrayData as $data): ?>
           
            <div class="col-md-4">
				<div class="x_panel">
					<div class="x_title">
						<h2>Station name: <?php echo e($data['StationName']); ?></h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content form-horizontal form-label-left">
						<div class="row tile_count" style="margin: 0">
							<div class="col-md-7 col-sm-12 col-xs-12 tile_stats_count" style="padding-bottom: 0;padding-left: 0;">
								<div class="count" <?php if($data['Status'] =="ONLINE"): ?>
                                style="color: green"
                                <?php else: ?>
                                style="color: red"
                                <?php endif; ?>><i class="fa fa-users"></i> <?php echo e($data['Status']); ?></div>
							</div>

                            <div class="col-md-5 col-sm-12 col-xs-12" style="padding-bottom: 0;padding-left: 0;">
                                <div class="row ml-3">
                                    <div class="col-md-12 col-sm-4 col-xs-4">
                                        <div class="sub-count" id="">
                                         <i class="fa fa-cubes"> <a href="//<?php echo e($data['ServerAddress']); ?>" target="_blank">Site</a>  </i> </div>
                                    </div>

                                    <div class="col-md-12 col-sm-4 col-xs-4">
                                        <div class="sub-count" id="">
                                          <i class="fa fa-cube">  Code: <?php echo e($data['code']); ?> </i></div>
                                    </div>
                                    <div class="col-md-12 col-sm-4 col-xs-4">
                                        <div class="sub-count" id="">
                                            <i class="fa fa-brands fa-github"><a href="#" class="gitAction" data-link="<?php echo e($data['ServerAddress']."/rcef_station/git-pull"); ?>"> Git pull</a> </i> </div>
                                    </div>
                                    <?php if($data['StationName'] == "CES"): ?>
                                    <div class="col-md-12 col-sm-4 col-xs-4">
                                        <div class="sub-count" id="">
                                            <i class="fa fa-brands fa-github"><a href="#" data-link="<?php echo e($data['ServerAddress']."/rcef_station/git-push"); ?>" class="gitAction"> Git push</a> </i> </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
						</div>
					</div>
				</div>
		    </div>
       
            <?php endforeach; ?>
			
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src=" <?php echo e(asset('public/js/jquery.inputmask.bundle.js')); ?> "></script>
<script src=" <?php echo e(asset('public/js/select2.min.js')); ?> "></script>
<script src=" <?php echo e(asset('public/js/parsely.js')); ?> "></script>
<script src=" <?php echo e(asset('public/js/daterangepicker.js')); ?> "></script>

<script>
   
    $('.gitAction').click(function(){
        var link = $(this).attr("data-link");        
        $.ajax({
            type: 'GET',
            url: "//"+link,
            data: {
                _token: "<?php echo e(csrf_token()); ?>",
            },
            success: function(data){		  
                alert(data);
            }
        });


    });


    
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.index', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>