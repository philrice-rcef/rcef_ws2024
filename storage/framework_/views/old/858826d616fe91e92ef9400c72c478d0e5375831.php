<?php $__env->startSection('content'); ?>
<style>
    .active_collapse{
        background-color: #337ab7 !important;
        color: white !important;
    }

    .panel > .panel-heading2 {
        background-color:  #337ab7;
        color: white;
        border-bottom: 0;
        padding: 10px 15px;
        border-top-left-radius: 3px;
        border-top-right-radius: 3px;
    }
    
</style>
<div class="container" style="padding: 3rem">
    <div class="row">
        <div class="col-md-12">


            <div class="page-title">
                <div class="title_left">
                    <h3>SRA Dashboard</h3>
                </div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-md-2">
                        <div class="panel panel-default text-center">
                            <div class="panel-heading2"><h4><b>no. of Benificiaries</b></h4></div>
                            <div class="panel-body"><h1><b><?php echo e($total_farmers); ?></b></h1></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-info">
                    <div class="panel-heading" role="tab" id="head_">
                        <div class="panel-title container-fluid">
                            <div class="row">
                                <div class="col-md-3">Sowing Month</div>
                                <div class="col-md-2">no. of Farmers</div>
                                <div class="col-md-2">Scheduled Farmers</div>
                                <div class="col-md-1 text-center"></div>
                                <div class="col-md-1 text-center"></div>
                                <!-- <div class="col-md-2">Distribution Date</div> -->
                                <div class="col-md-1 text-right">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php foreach($months as $d): ?>
                <div class="panel panel-default" id="month_panels">
                    <div class="panel-heading" role="tab" id="head_<?php echo e($d->season_month); ?>">
                        <div class="panel-title container-fluid">
                            <div class="row">
                                <div class="col-md-3"><?php echo e($d->season_month); ?></div>
                                <div class="col-md-2"><?php echo e($d->farmer_count); ?></div>
                                <div class="col-md-2"><?php echo e($d->farmer_scheduled); ?></div>
                                <div class="col-md-1 text-center"></div>
                                <div class="col-md-1 text-center"></div>
                                <div class="col-md-2"></div>
                                <div class="col-md-1 text-right">
                                    <a role="button" class="collapseBtn" data-toggle="collapse" data-parent="#accordion"
                                        href="#<?php echo e($d->season_month); ?>" aria-expanded="true" aria-controls="<?php echo e($d->season_month); ?>"
                                        data-month="<?php echo e($d->season_month); ?>">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="<?php echo e($d->season_month); ?>" class="panel-collapse collapse" role="tabpanel"
                        aria-labelledby="head_<?php echo e($d->season_month); ?>">
                        <div class="panel-body">
                            <div class="text-center">Loading <i class="fas fa-spinner"></i></div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
$(".collapseBtn").on("click", function() {
    var month = $(this).data('month');
    let id = "#"+month+" .panel-body";
    // console.log(id);
    let heading_id  = "#head_" + month;
    $(id).html('<div class="text-center">Loading <i class="fas fa-spinner"></i></div>');
    $.ajax({
        type: "POST",
        url: "<?php echo e(url('sra/paymaya/load/municipality')); ?>",
        data: {
            month: month,
            _token: "<?php echo e(csrf_token()); ?>"
        },
        success: function(response) {  
            $(".panel-collapse .panel-body").empty();
            if (!$(heading_id).hasClass("active_collapse")) {
                $('#month_panels>.panel-heading').removeClass("active_collapse");
                $(heading_id).addClass("active_collapse");
            }else{
                $('#month_panels>.panel-heading').removeClass("active_collapse");
            }
            $(id).append(response);
        }
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.index', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>