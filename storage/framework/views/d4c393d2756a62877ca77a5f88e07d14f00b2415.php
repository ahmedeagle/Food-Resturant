<section id="categories" class="categories bg-light py-5">
    <header class="section-header">
        <h2 class="section-title text-center font-body-heavy"><?php echo e(trans('site.cats')); ?></h2>
    </header><!-- .section-header -->
    <div class="section-content mt-5">


<?php  $name = LaravelLocalization::getCurrentLocale()."_name"?>
        <div class="container">
            <div class="row">
                <?php $__currentLoopData = $cats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(url('/restaurant-page/'. $cat->id)); ?>">
                    <div class="col-md-3 col-sm-6 col-12 <?php if($key != 0): ?> <?php if($key == 1): ?> mt-4 mt-sm-0 <?php elseif($key == 2): ?> mt-4 mt-md-0 <?php elseif($key == 3): ?> mt-4 mt-md-0 <?php else: ?> mt-4 <?php endif; ?> <?php endif; ?>">
                        <div class="cat-item position-relative rounded-lg overflow-hidden">
                            <div class="overlay position-absolute w-100 h-100"></div>
                            <a href="<?php echo e(url('/cat-restaurants/'. $cat->id)); ?>">
                                <figure class="cat-figure mb-0">

                                    <img src="<?php echo e($cat->image_url); ?>"
                                             class="img-fluid d-block mx-auto w-100"
                                             style="width:270px;height:380px"
                                             alt="Category image">
                                    <figcaption class="cat-figcaption position-absolute px-3">
                                        <h3 class="cat-title font-body-md position-relative">
                                            <a href="<?php echo e(url("/cat-restaurants/". $cat->id)); ?>" class="text-white no-decoration">
                                                <?php echo e($cat->$name); ?>

                                            </a>
                                        </h3>
                                    </figcaption>
                                </figure>
                            </a>
                        </div>
                    </div>
                </a>
                
                
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php if(count($cats) > 0): ?>
            <div class="mb-4 mt-5 text-center">
                <a href="<?php echo e(url('/categories')); ?>"
                   class="more-link font-body-bold btn px-5 btn-primary"><?php echo e(trans('site.more')); ?></a>
            </div>
            <?php endif; ?>
        </div><!-- .container -->

    </div><!-- .section-content -->
</section><!-- .categories -->