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

                <?php echo $__env->make("Provider.pages.menu", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                <div class="col-lg-9 col-md-8 col-12 mt-4 mt-md-0 ">

                    <div class="py-2 pr-3 rounded-lg shadow-around bg-white">
                        <h4 class="page-title font-body-bold">تعديل التصنيف</h4>
                    </div>






                    <div class="p-3 rounded-lg shadow-around mt-4">

                        <form action="<?php echo e(url("/restaurant/food-menu/cat/edit")); ?>" method="POST" class="new-kind-form multi-forms">
                            <?php echo e(csrf_field()); ?>


                            <div class="form-group">
                                <label for="kind-name">الإسم باللغة العربية</label>
                                <input type="text"
                                       class="form-control border-gray font-body-md"
                                       name="ar_name" value="<?php echo e(old("ar_name", $cat->ar_name)); ?>">

                                <?php if($errors->has("ar_name")): ?>
                                    <div class="top-margin alert alert-danger">
                                        <?php echo e($errors->first("ar_name")); ?>

                                    </div>
                                <?php endif; ?>
                            </div><!-- .form-group name -->

                            <div class="form-group">
                                <label for="kind-name">الإسم باللغة الانجليزية</label>
                                <input type="text"
                                       class="form-control border-gray font-body-md"
                                       name="en_name" value="<?php echo e(old("en_name", $cat->en_name)); ?>">

                                <?php if($errors->has("en_name")): ?>
                                    <div class="top-margin alert alert-danger">
                                        <?php echo e($errors->first("en_name")); ?>

                                    </div>
                                <?php endif; ?>

                            </div><!-- .form-group name -->

                            <input type="hidden" name="id" value="<?php echo e($cat->id); ?>" />
                            <button type="submit" class="add-meal-btn btn btn-primary py-2 px-5">إضافة</button>
                        </form><!-- .new-kind-form -->
                    </div>
                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make("Provider.layouts.master", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>