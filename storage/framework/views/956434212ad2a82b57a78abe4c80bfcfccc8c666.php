<?php $__env->startSection("main-title"); ?>
    <?php echo $__env->yieldContent('title'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("main-class"); ?>
    <?php echo $__env->yieldContent('class'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("main-content"); ?>

    <?php echo $__env->make("Site.includes.warning", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make("Provider.includes.header", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <?php echo $__env->yieldContent("content"); ?>

    <?php echo $__env->make("Site.includes.footer", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("main-script"); ?>
    <?php echo $__env->yieldContent("script"); ?>
<?php $__env->stopSection(); ?>



<?php echo $__env->make("Site.layouts.pure-master", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>