<?php $__env->startSection('title'); ?>
     <?php echo e($title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('class'); ?>
    <?php echo e($class); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <main class="page-content py-5">

        <header class="page-header mt-4 text-center">
            <h1 class="page-title h2 font-body-bold">متابعة ادخال البيانات</h1>
            <p class="description text-gray font-body-md mt-3">برجاء اختيار تصنيف المطعم</p>
        </header>

        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-sm-10 col-12 mx-auto font-body-bold mb-5 text-center">

                    <form id="register-food-form" action="<?php echo e(url("/restaurant/complete-profile/cat")); ?>" method="POST" class="mt-4 font-body-md " data-toggle="buttons">

                        <?php
                            $count = 1;
                            $addParent = true;
                        ?>

                        <input type="hidden" class="food-count" value="<?php echo e(count($cats)); ?>" />
                        <?php $__currentLoopData = $cats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <?php if($addParent): ?>
                                    <div class="row justify-content-center">
                                <?php endif; ?>

                                    <div class="form-group">
                                        <div class="form-check">
                                            <label class="btn btn-primary f-food">
                                                <input data-id = "<?php echo e($cat->id); ?>" class="form-check-input<?php echo e($key); ?>" type="checkbox" />
                                                <?php echo e($cat->name); ?>

                                            </label>
                                        </div>
                                    </div>

                                <?php if($count < 4): ?>
                                    <?php
                                        $count = $count + 1;
                                        $addParent = false;
                                    ?>

                                    <?php if(count($cats) == ($key +1)): ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php continue; ?>
                                <?php else: ?>
                                    <?php
                                        $count =  1;
                                        $addParent = true;
                                    ?>
                                <?php endif; ?>
                                    </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <div class="text-center mt-4 text-center">
                            <button type="submit" id="register-food-btn" class="btn btn-primary px-5 mx-auto text-center">متابعة</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </main><!-- .page-content -->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('Provider.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>