
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
         <li class="breadcrumb-item"><a href="<?php echo e(url('admin/offers/list/all')); ?>">العروض</a>
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
            <h5>اضافة عرض جديد </h5>
         </div>
         <div class="card-block">
            <form action="<?php echo e(url('admin/offers/store')); ?>" method="POST" enctype="multipart/form-data">
               <?php echo e(csrf_field()); ?>

               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">عنوان العرض بالعربية</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="ar_title" value="<?php echo e(old("ar_title")); ?>" placeholder="من فضلك ادخل عنوان العرض بالعربية">
                     <?php if($errors->has("ar_title")): ?>
                        <?php echo e($errors->first("ar_title")); ?>

                     <?php endif; ?>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">عنوان العرض بالانجليزية</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="en_title" value="<?php echo e(old("en_title")); ?>" placeholder="من فضلك ادخل عنوان العرض بالانجليزية">
                     <?php if($errors->has("en_title")): ?>
                        <?php echo e($errors->first("en_title")); ?>

                     <?php endif; ?>
                  </div>
               </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">حالة العرض</label>
                    <div class="col-sm-10">
                        <select style="height: 40px;" name="approved" class="form-control">
                            <option value="">من فضلك قم باختيار حالة العرض</option>
                            <option value="1" <?php if(old('approved') != ''): ?> <?php if(old('approved') == 1): ?> selected <?php endif; ?> <?php endif; ?>>مفعل</option>
                            <option value="0" <?php if(old('approved') != ''): ?> <?php if(old('approved') == 0): ?> selected <?php endif; ?> <?php endif; ?>>غير مفعل</option>
                        </select>
                        <?php if($errors->has("approved")): ?>
                            <?php echo e($errors->first("approved")); ?>

                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">المطعم</label>
                    <div class="col-sm-10">
                        <select style="height: 40px;" name="provider_id" class="form-control">
                            <option value="">من فضلك قم باختيار المطعم</option>
                            <?php $__currentLoopData = $providers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($p->id); ?>" <?php if(old('provider_id') == $p->id): ?> selected <?php endif; ?>><?php echo e($p->ar_name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php if($errors->has("provider_id")): ?>
                            <?php echo e($errors->first("provider_id")); ?>

                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">ترتيب الظهور</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="order_level" value="<?php echo e(old("order_title")); ?>" placeholder="ترتيب الظهور فى الموقع بإدخال 0 سيكون اقل ترتيب">
                        <?php if($errors->has("order_level")): ?>
                            <?php echo e($errors->first("order_level")); ?>

                        <?php endif; ?>
                    </div>
                </div>
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">صورة العرض</label>
                  <div class="col-sm-10">
                      <input type="file" name="image" value="<?php echo e(old("image")); ?>" class="form-control">
                     <?php if($errors->has("image")): ?>
                        <?php echo e($errors->first("image")); ?>

                     <?php endif; ?>
                  </div>
              </div>
               <button type="submit" class="btn btn-md btn-success"><i class="icofont icofont-check"></i>  اضافة </button>    <a href="<?php echo e(url('admin/offers/list/all')); ?>" class="btn btn-md btn-danger"><i class="icofont icofont-close"></i>  رجوع </a>
            </form>
         </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin_panel.blank', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>