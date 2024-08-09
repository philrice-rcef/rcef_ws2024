<?php if($errors->any()): ?>
    <div class="alert alert-danger alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4>Errors:</h4>
        <ul>
            <?php foreach($errors->all() as $error): ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<?php if(Session::has('error_rsbsa')): ?>
    <div class="alert alert-danger alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <strong><i class="fa fa-times-circle"></i> Error!</strong> <?php echo e(Session::get('error_rsbsa')); ?>

    </div>
<?php endif; ?>

<?php if(Session::has('error_msg')): ?>
    <div class="alert alert-danger alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <strong><i class="fa fa-times-circle"></i> Error!</strong> <?php echo e(Session::get('error_msg')); ?>

    </div>
<?php endif; ?>

<?php if(Session::has('success')): ?>
    <div class="alert alert-success alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <strong><i class="fa fa-check-circle"></i> Success!</strong> <?php echo e(Session::get('success')); ?>

    </div>
<?php endif; ?>