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

                <div class="col-lg-9 col-md-8 col-12 mt-4 mt-md-0 ">

                    <div class="py-2 pr-3 rounded-lg shadow-around bg-white">
                        <h4 class="page-title font-body-bold"><?php echo e(trans('site.secondary_page')); ?></h4>
                    </div>

                <?php  
                     $title    =  LaravelLocalization::getCurrentLocale()."_title";
                     $content  =  LaravelLocalization::getCurrentLocale()."_content";

                ?>
                    <div class="p-3 rounded-lg shadow-around mt-4 mb-5 bg-white">
                        <h5 class="sub-title font-body-bold mb-3"><?php echo e($page-> $title); ?></h5>
                        <div class="page-content font-body-md text-gray">
                            <?php echo $page-> $content; ?>

                        </div>
                    </div>

                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->

<?php $__env->stopSection(); ?>




<?php echo $__env->make("User.layouts.master", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>