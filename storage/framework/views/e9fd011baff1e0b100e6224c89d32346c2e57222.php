<?php $__env->startSection("title"); ?>
    <?php echo e($title); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection("class"); ?>
    <?php echo e($class); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection("content"); ?>

    <main class="page-content py-5 mt-4">

        <header class="page-header mt-5 text-center">
            <h1 class="page-title h2 font-body-bold">تأكيد رقم الهاتف</h1>
        </header>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-sm-10 col-12 mx-auto font-body-bold mb-5 pb-5">
                    <form action="<?php echo e(url("/restaurant/activate-phone")); ?>" method="POST" class="login-form mt-5">
                        <?php echo e(csrf_field()); ?>

                        <div class="form-group">
                            <label for="phone-number">قم بإدخال رقم التأكيد الذي وصلك على رقم الهاتف</label>
                            <input type="text" name="code" class="form-control border-gray" id="phone-number">

                            <?php if(Session::has("error")): ?>
                                <div class="alert alert-danger top-margin">
                                    <?php echo e(Session::get("error")); ?>

                                </div>
                            <?php endif; ?>

                            <?php if(Session::has("success")): ?>
                                <div class="alert alert-success top-margin">
                                    <?php echo e(Session::get("success")); ?>

                                </div>
                            <?php endif; ?>

                            <?php if($errors->has("code")): ?>

                                <div class="alert alert-danger top-margin">
                                    <?php echo e($errors->first("code")); ?>

                                </div>

                            <?php endif; ?>

                        </div><!-- .form-group -->
                        <button type="submit" class="btn btn-primary px-5">تفعيل</button>
                        <br />
                        <a href="<?php echo e(url("/restaurant/resend-activation-code")); ?>" class="top-margin btn btn-info px-5">إعادة ارسال رقم التأكيد</a>
                    </form><!-- .login-form -->
                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->

<?php $__env->stopSection(); ?>




<?php echo $__env->make("Provider.layouts.master", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>