<?php $__env->startSection('title'); ?>
    <?php echo e($title); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('class'); ?>
    <?php echo e($class); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection("content"); ?>
<main class="page-content py-5 mt-4">

    <header class="page-header mt-5 text-center">
        <h1 class="page-title h2 font-body-bold"><?php echo e(trans('site.password_reset')); ?></h1>
    </header>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-sm-10 col-12 mx-auto font-body-bold mb-5 pb-5">
                <form action="<?php echo e(url("/restaurant/forget-password")); ?>" method="POST" class="login-form mt-5">
                    <?php echo e(csrf_field()); ?>

                    <?php if(Session::has("error")): ?>
                        <div class="alert alert-warning">
                            <?php echo e(Session::get("error")); ?>

                        </div>
                    <?php endif; ?>
                    
                    
                    <div class="row justify-content-center">
    
                               <div class="form-group">
                                                <div class="form-check">
                                                    <label class="btn btn-primary f-food ">
                                                        <input data-id="1" name="guard" value="1" class="form-check-input0" type="radio">
                                                         <?php echo e(trans('site.branch_account')); ?>

                                                    </label>
                                                </div>
                                           
                                </div>
                                  <div class="form-group">
                                                <div class="form-check">
                                                    <label class="btn btn-primary f-food ">
                                                        <input data-id="1"  name="guard" value="2" class="form-check-input0" type="radio" checked="">
                                                         <?php echo e(trans('site.main_account')); ?>

                                                    </label>
                                                </div>
                                 </div>
                            </div>  
                            
                            
                    <div class="form-group">
                        <label for="phone-number"><?php echo e(trans('site.enter_your_phone')); ?></label>
                        <input type="text" name="phone" class="form-control border-gray" id="phone-number">
                        <?php if($errors->has("phone")): ?>
                            <div class="alert alert-danger top-margin">
                                <?php echo e($errors->first("phone")); ?>

                            </div>
                        <?php endif; ?>
                    </div><!-- .form-group -->
                    <button type="submit" class="btn btn-primary px-5"><?php echo e(trans('site.send')); ?></button>
                </form><!-- .login-form -->
            </div><!-- .col-* -->
        </div><!-- .row -->
    </div><!-- .container -->
</main><!-- .page-content -->

<?php $__env->stopSection(); ?>
<?php echo $__env->make("Site.layouts.master", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>