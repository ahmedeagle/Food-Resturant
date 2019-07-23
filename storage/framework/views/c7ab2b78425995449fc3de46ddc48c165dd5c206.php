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
                        <h4 class="page-title font-body-bold"><?php echo e(trans('site.notifications')); ?></h4>
                    </div>

                    <?php if(count($notification) > 0): ?>
                    <?php $__currentLoopData = $notification; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="pr-3 rounded-lg shadow-around bg-white py-2 font-body-md my-3 mt-4">

                            <div class="media align-items-lg-start align-items-center flex-column flex-lg-row">

                                <div class="media-body">

                                    <h5 class="mt-lg-2 mt-md-0 mt-xs-0 pt-2 pt-lg-0 text-lg-right text-center font-size-base">
                                        <?php echo e($n->notification_title); ?>

                                    </h5>
                                    <p class="text-lg-right text-center pb-1 text-gray mb-0"><?php echo e($n->create_date); ?></p>

                                    <p class="text-gray  pl-3 pr-3 pr-lg-0 pb-3 mb-0 mt-2 mt-sm-0 text-lg-right text-md-center text-sm-center text-center font-size-base">
                                        <span class="d-block"><?php echo e($n->notification_content); ?></span>
                                    </p>
                                </div><!-- .media-body -->
                            </div><!-- .media -->
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <p class="mt-4"><?php echo e(trans('site.no_notifications')); ?></p>
                    <?php endif; ?>



                    <?php echo e($notification->links("Pagination.pagination")); ?>



                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->

<?php $__env->stopSection(); ?>




<?php echo $__env->make("User.layouts.master", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>