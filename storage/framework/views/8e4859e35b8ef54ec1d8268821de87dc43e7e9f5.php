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
                        <h4 class="page-title font-body-bold"><?php echo e(trans('site.favourite')); ?></h4>
                    </div>

                    <?php if(Session::has('success')): ?>
                        <div class="alert alert-success top-margin">

                            <?php echo e(Session::get('success')); ?>


                        </div>
                    <?php endif; ?>

                    <div class="row">


                        <?php if(count($branches) > 0): ?>

                            <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $favorite): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <div class="col-12 col-lg-4 mt-4">

                                    <div class="fav-box rounded-lg shadow-around bg-white text-center py-3">
                                        <a href="<?php echo e(url("/user/favorites/remove/" . $favorite->branch_id)); ?>" class="delete-x">&times;</a>

                                        <img class="rounded-circle mb-lg-0 mb-3"
                                             src="<?php echo e($favorite->image_url); ?>"
                                             style="width:90px;height:90px"
                                             alt="Generic placeholder image">


                                        <p class="my-1 font-body-bold"><a href="<?php echo e(url("/restaurant-page/" . $favorite->branch_id)); ?>"><?php echo e($favorite->name); ?></a></p>

                                        <div>

                                            <?php
                                                $count = 0;
                                            ?>
                                            <?php for($i = 1; $i <= (int)$favorite->averageRate; $i++): ?>
                                                <img src="<?php echo e(url('/assets/site/img/-e-rating-icon.svg')); ?>"
                                                     class="img-fluid d-inline mx-auto">

                                                <?php
                                                    $count++
                                                ?>
                                            <?php endfor; ?>
                                            <?php if($count < 5): ?>
                                                <?php for($i = $count+1; $i <= 5; $i++): ?>
                                                    <img src="<?php echo e(url('/assets/site/img/-e-rating-icon-ncolor.svg')); ?>"
                                                         class="img-fluid d-inline mx-auto">
                                                <?php endfor; ?>
                                            <?php endif; ?>


                                        </div>
                                        <div>

                                            <?php if($favorite->has_booking == "1"): ?>
                                                <img src="<?php echo e(url('/assets/site/img/-e-reserved-icon.svg')); ?>"
                                                     class="img-fluid d-inline mx-auto my-2">
                                            <?php endif; ?>

                                            <?php if($favorite->has_delivery == "1"): ?>
                                                <img src="<?php echo e(url('/assets/site/img/-e-delivery-icon.svg')); ?>"
                                                     class="img-fluid d-inline mx-auto my-2 pr-2">
                                            <?php endif; ?>

                                        </div>
                                        <div>
                                            <img src="<?php echo e(url('/assets/site/img/-e-money-icon.svg')); ?>"
                                                 class="img-fluid d-inline mx-auto my-2 pr-2">
                                            <span class="font-body-md"><?php echo e($favorite->mealAveragePrice); ?> <?php echo e(trans('site.riyal')); ?></span>

                                            
                                                 
                                            
                                        </div>

                                    </div>
                                </div>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <?php else: ?>

                            <p class="mt-4"><?php echo e(trans('site.favourite_list_empty')); ?></p>

                        <?php endif; ?>

                    </div> <!-- .row -->

                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->

<?php $__env->stopSection(); ?>




<?php echo $__env->make("User.layouts.master", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>