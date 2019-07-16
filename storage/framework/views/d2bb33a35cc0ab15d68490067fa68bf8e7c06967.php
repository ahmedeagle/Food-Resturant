<?php $__env->startSection("title"); ?>
    <?php echo e($title); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection("class"); ?>
    <?php echo e($class); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection("content"); ?>

    <main class="page-content py-5">
        <div class="container">
            <div class="row">

                <?php echo $__env->make("User.includes.menu", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                <div class="col-lg-9 col-md-8 col-12 mt-4 mt-md-0 font-body-bold">
                    <div class="py-2 pr-3 rounded-lg shadow-around bg-white">
                        <h4 class="page-title font-body-bold">الطلب</h4>
                    </div>

                    <div class="py-4 rounded-lg shadow-around my-4 bg-white">

                        <div class="text-center ">
                            <img src="<?php echo e(url("/assets/site/img/-e-successful-icon.jpg")); ?>"
                                 class="img-fluid d-inline mx-auto my-2">
                            <p class="font-body-md">
                                تم إرسال طلبك بنجاح
                            </p>
                        </div>

                    </div>

                    <a href="<?php echo e(url("/user/dashboard")); ?>" class="btn btn-primary px-5">العودة</a>


                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->

<?php $__env->stopSection(); ?>





<?php echo $__env->make("User.layouts.master", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>