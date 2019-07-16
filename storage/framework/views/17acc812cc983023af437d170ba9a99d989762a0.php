<?php $__env->startSection('title'); ?>
    - <?php echo e($title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="page-header card">
   <div class="card-block">
      <h5 class="m-b-10">الاعدادات</h5>
      <ul class="breadcrumb-title b-t-default p-t-10">
         <li class="breadcrumb-item">
            <a href="<?php echo e(url('admin/dashboard')); ?>">الرئيسية</a>
         </li>
         <li class="breadcrumb-item"><a href="<?php echo e(url('admin/settings')); ?>">الاعدادات</a>
         </li>
      </ul>
   </div>
</div>
<!-- Page-header end -->
<div class="page-body">
    <?php if(Session::has('error')): ?>
        <div class="alert alert-danger"> <?php echo e(Session::get('error')); ?></div>
    <?php endif; ?>
    <?php if(Session::has('success')): ?>
        <div class="alert alert-success"> <?php echo e(Session::get('success')); ?></div>
    <?php endif; ?>
      <div class="card">
         <div class="card-header">
            <h5>الاعدادات</h5>
         </div>
         <div class="card-block">
            <form action="<?php echo e(url("admin/settings/store")); ?>" method="POST">
                <?php echo e(csrf_field()); ?>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">اسم التطبيق بالعربية</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="app_ar_name" value="<?php echo e(old("app_ar_name" , $settings->app_ar_name)); ?>" placeholder="من فضلك ادخل اسم التطبيق بالعربية">
                      <?php if($errors->has("app_ar_name")): ?>
                          <?php echo e($errors->first("app_ar_name")); ?>

                      <?php endif; ?>
                  </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">اسم التطبيق بالانجليزية</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="app_en_name" value="<?php echo e(old("app_en_name" , $settings->app_en_name)); ?>" placeholder="من فضلك ادخل اسم التطبيق بالانجليزية">
                        <?php if($errors->has("app_en_name")): ?>
                            <?php echo e($errors->first("app_en_name")); ?>

                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">رقم الجوال</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="phone" value="<?php echo e(old('phone' , $settings->phone)); ?>" placeholder="من فضلك ادخل رقم الجوال">
                      <?php if($errors->has("phone")): ?>
                          <?php echo e($errors->first("phone")); ?>

                      <?php endif; ?>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">البريد الالكتروني</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="email" value="<?php echo e(old("email" , $settings->email)); ?>" placeholder="من فضلك ادخل البريد الالكتروني">
                      <?php if($errors->has("email")): ?>
                          <?php echo e($errors->first("email")); ?>

                      <?php endif; ?>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">نسبة الضريبة</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="tax" value="<?php echo e(old('tax' , $settings->order_tax)); ?>" placeholder="من فضلك ادخل الضريبة ">
                      <?php if($errors->has("tax")): ?>
                          <?php echo e($errors->first("tax")); ?>

                      <?php endif; ?>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">العنوان باللغة العربية</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="ar_address" value="<?php echo e(old("ar_address" , $settings->ar_address)); ?>" placeholder="من فضلك ادخل العنوان بالعربية">
                      <?php if($errors->has("ar_address")): ?>
                          <?php echo e($errors->first("ar_address")); ?>

                      <?php endif; ?>
                  </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">العنوان باللغة الانجليزية</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="en_address" value="<?php echo e(old("en_address" , $settings->en_address)); ?>" placeholder="من فضلك ادخل العنوان بالانجليزية">
                        <?php if($errors->has("en_address")): ?>
                            <?php echo e($errors->first("en_address")); ?>

                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">رابط تطبيق الاندرويد</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="android" value="<?php echo e(old("android" , $settings->android_app_url)); ?>" placeholder="من فضلك ادخل العنوان">
                        <?php if($errors->has("android")): ?>
                            <?php echo e($errors->first("android")); ?>

                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">رابط تطبيق الايفون</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="ios" value="<?php echo e(old("ios" , $settings->ios_app_url)); ?>" placeholder="من فضلك ادخل العنوان">
                        <?php if($errors->has("ios")): ?>
                            <?php echo e($errors->first("ios")); ?>

                        <?php endif; ?>
                    </div>
                </div>
               <button type="submit" class="btn btn-md btn-success"><i class="icofont icofont-check"></i>  تعديل </button>      <a href="<?php echo e(url('admin/dashboard')); ?>" class="btn btn-md btn-danger"><i class="icofont icofont-close"></i>  رجوع </a>
            </form>
         </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin_panel.blank', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>