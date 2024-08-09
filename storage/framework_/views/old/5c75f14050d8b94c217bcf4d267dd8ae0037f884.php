<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>

      <?php echo $__env->make('DeliveryDAshboard.includes.header_v2', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
   
      <?php if($region == "CENTRAL LUZON"): ?>
       <?php echo $__env->make('DeliveryDAshboard.includes.body_v2_r3', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      <?php else: ?>
        <?php echo $__env->make('DeliveryDAshboard.includes.body_v2', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      <?php endif; ?>
    
      <?php /* <div style="page-break-before: always;"></div>
      <?php echo $__env->make('DeliveryDAshboard.delivery_pdf_v2', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> */ ?>

      <div style="page-break-before: always;"></div>
      <?php echo $__env->make('DeliveryDAshboard.delivery_pdf_v3', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


    
      <div style="page-break-before: always;"></div>
       <?php echo $__env->make('DeliveryDAshboard.delivery_sar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

 
  </body>
</html>
