<?php $__env->startSection('title'); ?>
    <?php echo e($title); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('class'); ?>
    <?php echo e($class); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <main class="page-content py-5">
        <div class="container">
            <div class="row">


                <div class="col-lg-12 col-md-12 col-12 mt-4 mt-md-0 ">

                    <?php if(count($providers) > 0): ?>
                    <div class="section-header d-flex p-3 rounded-lg bg-white shadow-around justify-content-between font-body-bold flex-lg-row flex-md-column flex-sm-row flex-column">

                        <h4 class="page-title mb-auto"><?php echo e(trans('site.show_results')); ?>  <?php echo e($query); ?></h4>

                        <!--<div class="orders-sort dropdown font-body-md text-gray align-self-center">
                        <span class="dropdown-toggle cursor"
                              data-toggle="dropdown"
                              aria-expanded="false"
                              aria-haspopup="true">
                            فرز حسب:
                        </span>
                            <div class="dropdown-menu text-right">
                                <a href="#"
                                   class="dropdown-item bg-white text-gray">الأقرب</a>
                                <a href="#"
                                   class="dropdown-item bg-white text-gray">التاريخ</a>
                                <a href="#"
                                   class="dropdown-item bg-white text-gray">رقم الحجز</a>
                                <a href="#"
                                   class="dropdown-item bg-white text-gray">عدد الأشخاص</a>
                            </div>
                        </div>-->

                    </div><!-- .section-header -->
                    <?php endif; ?>

                    <div class="row">

                        <?php if(count($providers) > 0): ?>

                            <?php $__currentLoopData = $providers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $provider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <div class="col-12 col-lg-4 mt-4">
                                    <div class="rounded-lg shadow-around bg-white text-center py-3">
                                        <img class="rounded-circle mb-lg-0 mb-3"
                                        src="<?php echo e($provider->image_url); ?>"
                                        alt="<?php echo e($provider->name); ?>"
                                        style="width:90px;height:90px">
                                        <p class="my-1 font-body-bold"><a href="<?php echo e(url("/restaurant-page/" . $provider->id)); ?>"><?php echo e($provider->name); ?></a></p>
                                        <div>
                                            <?php
                                                $count = 0;
                                            ?>
                                            <?php for($i = 1; $i <= (int)$provider->averageRate; $i++): ?>
                                                <img src="<?php echo e(url("/assets/site/img/-e-rating-icon.svg")); ?>"
                                                class="img-fluid d-inline mx-auto">

                                                <?php
                                                    $count++
                                                ?>
                                            <?php endfor; ?>
                                            <?php if($count < 5): ?>
                                                <?php for($i = $count+1; $i <= 5; $i++): ?>
                                                  <img src="<?php echo e(url("/assets/site/img/-e-rating-icon-ncolor.svg")); ?>"
                                                                class="img-fluid d-inline mx-auto">
                                                <?php endfor; ?>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <?php if($provider->has_booking == "1"): ?>
                                                <img src="<?php echo e(url("/assets/site/img/-e-reserved-icon.svg")); ?>"
                                                class="img-fluid d-inline mx-auto my-2">
                                            <?php endif; ?>

                                            <?php if($provider->has_delivery == "1"): ?>
                                                <img src="<?php echo e(url("/assets/site/img/-e-delivery-icon.svg")); ?>"
                                                class="img-fluid d-inline mx-auto my-2 pr-2">
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <img src="<?php echo e(url("/assets/site/img/-e-money-icon.svg")); ?>"
                                            class="img-fluid d-inline mx-auto my-2 pr-2">
                                            <span class="font-body-md"><?php echo e($provider->mealAveragePrice); ?> <?php echo e(trans('site.riyal')); ?></span>
                                            <!--
                                            <img src="assets/img/-e-mark-icon.svg"
                                            class="img-fluid d-inline mx-auto my-2 pr-2">
                                            <span class="font-body-md">10 كم</span> -->
                                        </div>

                                    </div>
                                </div>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                        <?php else: ?>
                             <div class="col-12 col-lg-4 mt-4">
                                    <div class="rounded-lg shadow-around bg-white text-center py-3">
                            <p><?php echo e(trans('site.empty-search-results')); ?></p>
                        </div>
                    </div>


                        <?php endif; ?>
                    </div>


                    <?php echo e($providers->links('Pagination.pagination')); ?>



                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->

<?php $__env->stopSection(); ?>
<?php if(count($providers) == 0): ?>
    <?php $__env->startSection('style'); ?>
    
    .site-footer{
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
    }
    
    <?php $__env->stopSection(); ?>
<?php endif; ?>
<?php echo $__env->make('Site.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>