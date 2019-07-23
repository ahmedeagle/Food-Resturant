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
                        <h4 class="page-title font-body-bold"><?php echo e(trans('site.offers')); ?></h4>
                    </div>


                                     <div class="section-content mt-4 ">

                        <div id="offers-slider"
                             class="carousel offers-slider slide"
                             data-ride="carousel">

                            <div class="carousel-inner">

                    <?php $__currentLoopData = $offers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $offer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        
                        <?php if($key % 2 == 0): ?>
                            <div class="carousel-item <?php if($key == 0): ?> active <?php endif; ?>">
                                <div class="row">
                        <?php endif; ?>
                        
                        
                                <div class="col-md-6 col-12">
                                    <figure class="item-content shadow-sm">
                                        <img class="d-block img-fluid mx-auto rounded-top-lg"
                                             src="<?php echo e($offer->image_url); ?>"
                                             style="width:397px;height:193px"
                                             alt="First slide">
                                        <figcaption class="font-body-md p-3">
                                            <h4 class="item-title">
                                                <a href="<?php echo e(url('/restaurant-page/'. $offer-> branch_id)); ?>" class="text-secondary no-decoration" title="<?php echo e($offer-> title); ?>">
                                                    <?php echo e(str_limit($offer-> title, $limit = 35, $end = "..")); ?>

                                                </a>
                                            </h4>
                                            <p class="h5 address text-gray">
                                                <i class="fa fa-map-marker-alt text-primary ml-2"
                                                   aria-expanded="false"></i>
                                                <?php echo e($offer->address); ?>

                                            </p>
                                        </figcaption>
                                    </figure>
                                </div>
                        
                        <?php if($key % 2 != 0): ?>
                            </div>
                                </div>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </div><!-- .carousel-inner -->
                            <?php if(count($offers) > 0): ?>
                                <ol class="carousel-indicators position-relative mt-4 pr-0">
                                    <?php $__currentLoopData = $offers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $offer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($key % 2 == 0): ?>
                                            <li data-target="#offers-slider"
                                                data-slide-to="<?php echo e(($key == 0) ? $key : ($key - ($key - 1) )); ?>"
                                                class="<?php if($key == 0): ?> active <?php endif; ?> rounded-circle"></li>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ol>
                            <?php else: ?>
                                <div class="position-relative mt-4 pr-0">
                                    <p><?php echo e(trans('site.empty_offer_list')); ?></p>
                                <div>
                            <?php endif; ?>
                            
                        </div><!-- .offers-slider -->


                    </div><!-- .section-content -->

                    <div class="py-2 pr-3 rounded-lg shadow-around bg-white">
                        <h4 class="page-title font-body-bold"><?php echo e(trans('site.details')); ?></h4>
                    </div>


                    <div class=" categories section-content mt-1">

                        <div class="row">


                            <?php $__currentLoopData = $cats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <div class="col-lg-4 col-md-6 col-12 mt-4">
                                    <div class="cat-item position-relative rounded-lg overflow-hidden">
                                        <div class="overlay position-absolute w-100 h-100"></div>

                                            <figure class="cat-figure mb-0">
                                                <a href="<?php echo e(url('/cat-restaurants/'. $cat->id)); ?>">
                                                <img src="<?php echo e($cat->image_url); ?>"
                                                     class="img-fluid d-block mx-auto w-100"
                                                     style="width:255px;height:358px"
                                                     alt="Category image"></a>
                                                <figcaption class="cat-figcaption position-absolute px-3">
                                                    <h3 class="cat-title font-body-md position-relative">
                                                        <a href="<?php echo e(url('/cat-restaurants/'. $cat->id)); ?>" class="text-white no-decoration">

                                                <?php $name = LaravelLocalization::getCurrentLocale()."_name" ?>
                                                            
                                                            <?php echo e($cat-> $name); ?>

                                                        </a>
                                                    </h3>
                                                </figcaption>
                                            </figure>

                                    </div>
                                </div>



                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                        </div>


                    </div><!-- .section-content -->


                    <?php echo e($cats->links("Pagination.pagination")); ?>


                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->
<?php $__env->stopSection(); ?>




<?php echo $__env->make("User.layouts.master", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>