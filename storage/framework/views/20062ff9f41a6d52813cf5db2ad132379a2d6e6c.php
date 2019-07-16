<?php $__env->startSection('title'); ?>
    - <?php echo e($title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="page-header card">
        <div class="card-block">
            <h5 class="m-b-10">حالات الازدحام</h5>
            <ul class="breadcrumb-title b-t-default p-t-10">
                <li class="breadcrumb-item">
                    <a href="<?php echo e(('admin/dashboard')); ?>">الرئيسية</a>
                </li>
                <li class="breadcrumb-item"><a href="<?php echo e(url('admin/crowd')); ?>">حالات الازدحام</a>
                </li>
                <li class="breadcrumb-item"><a>تعديل</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- Page-header end -->
    <div class="page-body">
        <!-- Basic Form Inputs card start -->
        <div class="card">
            <div class="card-header">
                <h5>تعديل التصنيف</h5>
            </div>
            <div class="card-block">
                <form action="<?php echo e(url("admin/crowd/update/" . $crowd->id)); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo e(csrf_field()); ?>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">اسم الحالة باللغة العربية</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="ar_name" value="<?php echo e(old("ar_name" , $crowd->ar_name)); ?>" placeholder="اسم الحالة باللغة العربية">
                            <?php if($errors->has("ar_name")): ?>
                                <?php echo e($errors->first("ar_name")); ?>

                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">اسم الحالة باللغة الانجليزية</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="en_name" value="<?php echo e(old("en_name" , $crowd->en_name)); ?>" placeholder="من فضلك ادخل اسم الحالة باللغة الانجليزية">
                            <?php if($errors->has("en_name")): ?>
                                <?php echo e($errors->first("en_name")); ?>

                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">صورة الحالة</label>
                        <div class="col-sm-10">
                            <img style="width: 282px;height: 200px;" src="<?php echo e(url("/storage/app/public/settings/" . $crowd->filename)); ?>" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">تعديل الصورة</label>
                        <div class="col-sm-10">
                            <input type="file" name="image" value="<?php echo e(old("image" , $crowd->filename)); ?>" class="form-control">
                            <?php if($errors->has("image")): ?>
                                <?php echo e($errors->first("image")); ?>

                            <?php endif; ?>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-md btn-success"><i class="icofont icofont-check"></i>  تعديل </button>    <a href="<?php echo e(url('admin/crowd')); ?>" class="btn btn-md btn-danger"><i class="icofont icofont-close"></i>  رجوع </a>
                </form>
            </div>
        </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin_panel.blank', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>