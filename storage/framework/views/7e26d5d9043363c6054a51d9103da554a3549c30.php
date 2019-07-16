<?php $__env->startSection('title'); ?>
    - <?php echo e($title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="page-header card">
        <div class="card-block">
            <h5 class="m-b-10"><?php echo e($title); ?></h5>
            <ul class="breadcrumb-title b-t-default p-t-10">
                <li class="breadcrumb-item">
                    <a href="<?php echo e(url('admin/dashboard')); ?>">الرئيسية</a>
                </li>
                <li class="breadcrumb-item"><a href="<?php echo e(url('admin/crowd')); ?>">حالات الازدحام</a>
                </li>
                <li class="breadcrumb-item"><a>اضافة</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- Page-header end -->
    <div class="page-body">
        <!-- Basic Form Inputs card start -->
        <div class="card">
            <div class="card-header">
                <h5>اضافة حالة جديده </h5>
            </div>
            <div class="card-block">
                <form action="<?php echo e(url('admin/crowd/store')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo e(csrf_field()); ?>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">اسم الحالة بالعربية</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="ar_name" value="<?php echo e(old("ar_name")); ?>" placeholder="من فضلك ادخل اسم الحالة بالعربية">
                            <?php if($errors->has("ar_name")): ?>
                                <?php echo e($errors->first("ar_name")); ?>

                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">اسم الحالة بالانجليزية</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="en_name" value="<?php echo e(old("en_name")); ?>" placeholder="من فضلك ادخل اسم الحالة بالانجليزية">
                            <?php if($errors->has("en_name")): ?>
                                <?php echo e($errors->first("en_name")); ?>

                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">صورة الحالة</label>
                        <div class="col-sm-10">
                            <input type="file" name="image" value="<?php echo e(old("image")); ?>" class="form-control">
                            <?php if($errors->has("image")): ?>
                                <?php echo e($errors->first("image")); ?>

                            <?php endif; ?>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-md btn-success"><i class="icofont icofont-check"></i>  اضافة </button>    <a href="<?php echo e(url('admin/crowd')); ?>" class="btn btn-md btn-danger"><i class="icofont icofont-close"></i>  رجوع </a>
                </form>
            </div>
        </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin_panel.blank', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>