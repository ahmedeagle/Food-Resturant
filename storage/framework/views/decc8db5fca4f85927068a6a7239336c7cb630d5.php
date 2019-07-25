<?php $__env->startSection('title'); ?>
    <?php echo e($title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('class'); ?>
    <?php echo e($class); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('Site.includes.search', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('Site.includes.offer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('Site.includes.cat', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('Site.includes.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('Site.includes.contact', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('Site.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>