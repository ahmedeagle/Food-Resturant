<?php $__env->startSection('title'); ?>
   - <?php echo e($title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="page-header card">
   <div class="card-block">
      <h5 class="m-b-10">الصفحات الفرعيه</h5>
      <ul class="breadcrumb-title b-t-default p-t-10">
         <li class="breadcrumb-item">
            <a href="<?php echo e(url('admin/dashboard')); ?>">الرئيسية</a>
         </li>
         <li class="breadcrumb-item"><a href="<?php echo e(url('admin/pages')); ?>">الصفحات الفرعيه</a>
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
            <h5>اضافة صفحة فرعية جديدة </h5>
         </div>
         <div class="card-block">
            <form action="<?php echo e(url('admin/pages/store')); ?>" method="POST" enctype="multipart/form-data">
               <?php echo e(csrf_field()); ?>

               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">عنوان الصفحة باللغة العربية</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="ar_title" value="<?php echo e(old('ar_title')); ?>" placeholder="من فضلك ادخل عنوان الصفحه باللغة العربية">
                      <?php if($errors->has("ar_title")): ?>
                          <?php echo e($errors->first("ar_title")); ?>

                      <?php endif; ?>
                  </div>
               </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">عنوان الصفحة باللغة الانجليزية</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="en_title" value="<?php echo e(old('en_title')); ?>" placeholder="من فضلك ادخل عنوان الصفحه باللغة الانجليزية">
                        <?php if($errors->has("en_title")): ?>
                            <?php echo e($errors->first("en_title")); ?>

                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">حالة الصفحة</label>
                    <div class="col-sm-10">
                        <select style="height: 40px;" name="active" class="form-control">
                            <option value="">من فضلك قم باختيار حالة الصفحة</option>
                            <option value="1" <?php if(old('active') != ''): ?> <?php if(old('active') == 1): ?> selected <?php endif; ?> <?php endif; ?>>مفعل</option>
                            <option value="0" <?php if(old('active') != ''): ?> <?php if(old('active') == 0): ?> selected <?php endif; ?> <?php endif; ?>>غير مفعل</option>
                        </select>
                        <?php if($errors->has("active")): ?>
                            <?php echo e($errors->first("active")); ?>

                        <?php endif; ?>
                    </div>
                </div>
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">محتوى الصفحة باللغة العربية</label>
                  <div class="col-sm-10">
                     <textarea name="ar_content">
                        <?php echo e(old("ar_content")); ?>

                     </textarea>
                      <?php if($errors->has("ar_content")): ?>
                          <?php echo e($errors->first("ar_content")); ?>

                      <?php endif; ?>
                  </div>
               </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">محتوى الصفحة باللغة الانجليزية</label>
                    <div class="col-sm-10">
                     <textarea name="en_content">
                        <?php echo e(old("en_content")); ?>

                     </textarea>
                        <?php if($errors->has("en_content")): ?>
                            <?php echo e($errors->first("en_content")); ?>

                        <?php endif; ?>
                    </div>
                </div>

               <button type="submit" class="btn btn-md btn-success"><i class="icofont icofont-check"></i>  اضافة </button>    <a href="<?php echo e(url('admin/pages')); ?>" class="btn btn-md btn-danger"><i class="icofont icofont-close"></i>  رجوع </a>
            </form>
         </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin_panel.blank', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>