<?php $__env->startSection('title'); ?>
   - <?php echo e($title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="page-header card">
   <div class="card-block">
      <h5 class="m-b-10">الدول</h5>
      <ul class="breadcrumb-title b-t-default p-t-10">
         <li class="breadcrumb-item">
            <a href="<?php echo e(url('admin/dashboard')); ?>">الرئيسية</a>
         </li>
         <li class="breadcrumb-item"><a href="<?php echo e(url('admin/cities')); ?>">المدن</a>
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
            <h5>تعديل المدينة</h5>
         </div>
         <div class="card-block">
            <form action="<?php echo e(url("admin/cities/update/" . $city->id)); ?>" method="POST" enctype="multipart/form-data">
               <?php echo e(csrf_field()); ?>

               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">اسم المدينة باللغة العربية</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="ar_name" value="<?php echo e(old("ar_name" , $city->ar_name)); ?>" placeholder="من فضلك ادخل اسم المدينة باللغة العربية">
                     <?php if($errors->has("ar_name")): ?>
                        <?php echo e($errors->first("ar_name")); ?>

                     <?php endif; ?>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">اسم المدينة باللغة الانجليزية</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="en_name" value="<?php echo e(old("en_name" , $city->en_name)); ?>" placeholder="من فضلك ادخل اسم المدينة باللغة الانجليزية1">
                     <?php if($errors->has("en_name")): ?>
                        <?php echo e($errors->first("en_name")); ?>

                     <?php endif; ?>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">الدوله</label>
                  <div class="col-sm-10">
                      <select style="height: 40px;" name="country_id" class="form-control">
                        <option value="">من فضلك قم باختيار الدولة</option>
                        <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <option value="<?php echo e($country->id); ?>"  <?php if(old('country_id') || $errors->has('country_id')): ?> <?php if(old('country_id') == $country->id): ?> selected <?php endif; ?> <?php else: ?> <?php if($country->id == $city->country_id): ?> selected <?php endif; ?> <?php endif; ?>><?php echo e($country->ar_name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </select>
                      <?php if($errors->has("country_id")): ?>
                          <?php echo e($errors->first("country_id")); ?>

                      <?php endif; ?>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">الحالة</label>
                  <div class="col-sm-10">
                      <select style="height: 40px;" name="active" class="form-control">
                        <option value="">من فضلك قم باختيار الحالة</option>

                        <option value="1"  <?php if(old('active') || $errors->has('active')): ?> <?php if(old('active') == '1'): ?> selected <?php endif; ?> <?php else: ?> <?php if($city->active == '1'): ?> selected <?php endif; ?> <?php endif; ?>>مفعل</option>
                        <option value="0"  <?php if(old('active') || $errors->has('active')): ?> <?php if(old('active') == '0'): ?> selected <?php endif; ?> <?php else: ?> <?php if($city->active == '0'): ?> selected <?php endif; ?> <?php endif; ?>>غير مفعل</option>

                      </select>
                      <?php if($errors->has("active")): ?>
                          <?php echo e($errors->first("active")); ?>

                      <?php endif; ?>
                  </div>
               </div>
               <button type="submit" class="btn btn-md btn-success"><i class="icofont icofont-check"></i>  تعديل </button>
                <a href="<?php echo e(url("/admin/cities")); ?>" class="btn btn-md btn-danger">
                    <i class="icofont icofont-close"></i>  رجوع </a>
            </form>
         </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin_panel.blank', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>