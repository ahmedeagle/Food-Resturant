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

                    <?php if(Session::has("success")): ?>

                        <div class="alert alert-success top-margin">
                            <?php echo e(Session::get("success")); ?>

                        </div>

                    <?php endif; ?>
                    <div class="py-2 pr-3 rounded-lg shadow-around bg-white">
                        <h4 class="page-title font-body-bold"><?php echo e(trans('site.cart')); ?></h4>
                    </div>




                    <?php if(count($cart) > 0): ?>
                    <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <div class="py-3 py-lg-2 rounded-lg shadow-around my-4 bg-white">

                        <div class="media align-items-lg-start align-items-center flex-column flex-lg-row">
                            <img class="ml-2 mr-2 rounded mb-lg-0 mb-3"
                                 src="<?php echo e($item['meal_image_url']); ?>"
                                 draggable="false"
                                 style="width: 132px;height: 132px;"
                                 alt="Generic placeholder image">

                            <div class="media-body">

                                <h5 class="mt-lg-1 mt-md-0 mt-xs-0 text-lg-right text-center font-body-bold font-size-base">
                                    <a href="user-mealpage.html">
                                        <?php echo e($item['meal_name']); ?>

                                    </a>
                                </h5>

                                <div class="mb-0 mt-1 mt-sm-0 ">
                                    <p class="d-flex flex-row text-gray font-body-md mb-0 justify-content-center justify-content-lg-start">
                                        <span class="price"><?php echo e($item['price']); ?></span>
                                        &times;
                                        <span class="count"><?php echo e($item['qty']); ?></span>
                                        &nbsp;
                                        <span class="currency"><?php echo e(trans('site.riyal')); ?></span>
                                    </p>
                                </div>


                                <p class="mt-lg-1 mt-md-0 mt-xs-0 mb-lg-0 text-lg-right text-center font-body-md font-size-base">
                                    <?php echo e(trans('site.options')); ?>::
                                    <span class="text-gray"><?php echo e($item['addsNameString']); ?> ( <?php echo e(trans('site.added_price')); ?> : <?php echo e($item['addsAddedPrice']); ?> <?php echo e(trans('site.riyal')); ?>)</span>
                                </p>

                                <p class="mt-lg-1 mt-md-0 mt-xs-0 mb-lg-0 text-lg-right text-center font-body-md font-size-base">
                                     <?php echo e(trans('site.adds')); ?>::
                                    <span class="text-gray"><?php echo e($item['optionsNameString']); ?>   (   <?php echo e(trans('site.added_price')); ?> : <?php echo e($item['optionsAddedPrice']); ?> <?php echo e(trans('site.riyal')); ?>)</span>
                                </p>

                            </div><!-- .media-body -->

                            <a href="<?php echo e(url('/user/cart/remove-cart-meal/' . $key)); ?>" class="cancel-btn py-1 px-4 mt-lg-4 no-bg border border-primary d-lg-inline d-block rounded text-primary font-body-md ml-lg-3"><?php echo e(trans('site.cancel')); ?></a>


                        </div><!-- .media -->

                    </div>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <a href="<?php echo e(url('/user/cart/complete-order')); ?>" class="btn btn-primary px-5"><?php echo e(trans('site.next')); ?></a>
                    <?php else: ?>

                        <div class="mt-4"><?php echo e(trans('site.cart_list_empty')); ?></div>

                    <?php endif; ?>



                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->

<?php $__env->stopSection(); ?>




<?php echo $__env->make("User.layouts.master", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>