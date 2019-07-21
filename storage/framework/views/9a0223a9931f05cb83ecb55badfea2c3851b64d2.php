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
                    <form action="<?php echo e(url('/user/change-user-password')); ?>" method="POST" class="login-form mt-5">
                        <?php echo e(csrf_field()); ?>


                        <div class="form-group">
                            <label for="new-password">  <?php echo e(trans('site.new_password')); ?></label>
                            <input type="password" class="form-control border-gray" name="password" id="password">
                            <?php if($errors->has("password")): ?>
                                <div class="alert alert-danger top-margin">
                                    <?php echo e($errors->first("password")); ?>

                                </div>
                            <?php endif; ?>
                        </div><!-- .form-group -->
                        <div class="form-group">
                            <label for="confirm-password">  <?php echo e(trans('site.confirm_password')); ?></label>
                            <input type="hidden" name="token" value="<?php echo e($token); ?>" />
                            <input type="password" class="form-control border-gray" id="password_confirmation" name="password_confirmation">
                        </div><!-- .form-group -->
                        <button type="submit" class="btn btn-primary px-5"><?php echo e(trans('site.change')); ?></button>
                    </form><!-- .login-form -->
                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->

<?php $__env->stopSection(); ?>
<?php echo $__env->make("Site.layouts.master", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>