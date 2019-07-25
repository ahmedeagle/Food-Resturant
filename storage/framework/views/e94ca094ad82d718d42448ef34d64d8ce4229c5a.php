<section id="offers" class="offers py-5">
    <header class="section-header">
        <h2 class="section-title text-center font-body-heavy"><?php echo e(trans('site.offers')); ?></h2>
    </header><!-- .section-header -->
    <div class="section-content mt-5">

        <div class="container">

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
                                             style="width:570px;height:277px"
                                             alt="First slide">
                                        <figcaption class="font-body-md p-3">
                                            <h4 class="item-title">
                                                <a href="<?php echo e(url("/restaurant-page/". $offer->branch_id)); ?>" class="text-secondary no-decoration" title="<?php echo e($offer->title); ?>">
                                                    <?php echo e(str_limit($offer->title, $limit = 35, $end = "..")); ?>

                                                </a>
                                            </h4>
                                            <p class="h5 address text-gray">
                                                <i class="fa fa-map-marker-alt text-primary ml-2"
                                                   aria-expanded="false"></i>
                                                <?php echo e($offer-> address); ?>

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

        </div><!-- .container -->

    </div><!-- .section-content -->
</section><!-- .offers -->