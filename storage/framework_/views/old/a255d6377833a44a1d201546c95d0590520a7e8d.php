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
            
            <div class="clearfix"></div>
            <div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">
                <div class="panel panel-info">
                    <div class="panel-heading" role="tab" id="head_">
                        <div class="panel-title container-fluid">
                            <div class="row">
                                <div class="col-md-5">Province <i class="fa fa-arrow-right" aria-hidden="true"></i> Municipality</div>
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
                <?php foreach($data as $d): ?>
                <div class="panel panel-default" id="muni_panels">
                    <div class="panel-heading" role="tab" id="head_<?php echo e($d->muni_code); ?>">
                        <div class="panel-title container-fluid">
                            <div class="row">
                                <div class="col-md-5"><?php echo e($d->province_name); ?> <i class="fa fa-arrow-right" aria-hidden="true"></i> <b><?php echo e($d->municipality_name); ?></b></div>
                                <div class="col-md-2"><?php echo e($d->farmer_count); ?></div>
                                <div class="col-md-2"><?php echo e($d->farmer_scheduled); ?></div>
                                <div class="col-md-1 text-center"></div>
                                <div class="col-md-1 text-center"></div>
                                <div class="col-md-1 text-right">
                                    <a role="button" class="collapseBtnMuni" data-toggle="collapse" data-parent="#accordion2"
                                        href="#<?php echo e($d->muni_code); ?>" aria-expanded="true" aria-controls="<?php echo e($d->muni_code); ?>"
                                        data-muni="<?php echo e($d->muni_code); ?>">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="<?php echo e($d->muni_code); ?>" class="panel-collapse collapse municontainer" role="tabpanel"
                        aria-labelledby="head_<?php echo e($d->muni_code); ?>">
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

<script>
$(".collapseBtnMuni").on("click", function() {
    var muni = $(this).data('muni');
    let id = "#"+muni+" .panel-body";
    let heading_id  = "#head_" + muni;
    $(id).html('<div class="text-center">Loading <i class="fas fa-spinner"></i></div>');
    $.ajax({
        type: "POST",
        url: "<?php echo e(url('sra/paymaya/load/barangay')); ?>",
        data: {
            muni: muni,
            month: "<?php echo e($month); ?>",
            _token: "<?php echo e(csrf_token()); ?>"
        },
        success: function(response) {  
            $(".panel-collapse.municontainer .panel-body").empty();
            if (!$(heading_id).hasClass("active_collapse")) {
                $('#muni_panels>.panel-heading').removeClass("active_collapse");
                $(heading_id).addClass("active_collapse");
            }else{
                $('#muni_panels>.panel-heading').removeClass("active_collapse");
            }
            $(id).append(response);
        }
    });
});
</script>
