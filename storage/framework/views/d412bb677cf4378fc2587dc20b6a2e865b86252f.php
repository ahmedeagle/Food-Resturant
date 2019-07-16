<?php $__env->startSection('title'); ?>
    <?php echo e($title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('class'); ?>
    <?php echo e($class); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <main class="page-content py-5">

        <header class="page-header mt-2 text-center">
            <h1 class="page-title h2 font-body-bold">التصنيفات</h1>
        </header>

        <div class=" categories section-content mt-5">
            <div class="container">
                <div class="row">

                    <?php $__currentLoopData = $cats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(url("/cat-restaurants/". $cat->cat_id)); ?>">
                            <div class="col-md-3 col-sm-6 col-12 <?php if($key != 0): ?> <?php if($key == 1): ?> mt-4 mt-sm-0 <?php elseif($key == 2): ?> mt-4 mt-md-0 <?php elseif($key == 3): ?> mt-4 mt-md-0 <?php else: ?> mt-4 <?php endif; ?> <?php endif; ?>">
                                <div class="cat-item position-relative rounded-lg overflow-hidden">
                                    <div class="overlay position-absolute w-100 h-100"></div>
                                    <a href="<?php echo e(url("/cat-restaurants/". $cat->cat_id)); ?>">
                                        <figure class="cat-figure mb-0">
                                            <img src="<?php echo e($cat->image_url); ?>"
                                                 class="img-fluid d-block mx-auto w-100"
                                                 style="width:270px;height:380px"
                                                 alt="Category image">
                                            <figcaption class="cat-figcaption position-absolute px-3">
                                                <h3 class="cat-title font-body-md position-relative">
                                                    <a href="<?php echo e(url("/cat-restaurants/". $cat->cat_id)); ?>" class="text-white no-decoration">
                                                        <?php echo e($cat->ar_name); ?>

                                                    </a>
                                                </h3>
                                            </figcaption>
                                        </figure>
                                    </a>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </div><!-- .row -->
            </div><!-- .container -->
        </div>

        <?php echo e($cats->links("Pagination.pagination")); ?>


    </main><!-- .page-content -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('Site.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>