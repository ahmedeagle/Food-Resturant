<?php $__env->startSection('title'); ?>
   - <?php echo e($title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection("content"); ?>
<div class="page-header card">
   <div class="card-block">
      <h5 class="m-b-10">الدول</h5>
      <ul class="breadcrumb-title b-t-default p-t-10">
         <li class="breadcrumb-item">
            <a href="<?php echo e(url("/admin/dashboard")); ?>">الرئيسية</a>
         </li>
         <li class="breadcrumb-item"><a href="<?php echo e(url("/admin/countries")); ?>">الدول</a>
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
            <h5>تعديل الدولة</h5>
         </div>
         <div class="card-block">
            <form action="<?php echo e(url("/admin/countries/update/" . $country->id)); ?>" method="POST" enctype="multipart/form-data">
               <?php echo e(csrf_field()); ?>

               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">اسم الدولة باللغة العربية</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="ar_name" value="<?php echo e(old('ar_name' , $country->ar_name)); ?>" placeholder="اسم الدولة باللغة العربية">
                     <?php if($errors->has('ar_name')): ?>
                        <?php echo e($errors->first('ar_name')); ?>

                     <?php endif; ?>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">اسم الدولة باللغة الانجليزية</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="en_name" value="<?php echo e(old("en_name" , $country->en_name)); ?>" placeholder="اسم الدولة باللغة الانجليزية">
                     <?php if($errors->has('en_name')): ?>
                        <?php echo e($errors->first('ar_name')); ?>

                     <?php endif; ?>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">رقم الدولة</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="code" value="<?php echo e(old("code", $country->country_code)); ?>" placeholder="رقم الدولة">
                     <?php if($errors->has('code')): ?>
                        <?php echo e($errors->first('code')); ?>

                     <?php endif; ?>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">الحالة</label>
                  <div class="col-sm-10">
                     <select style="height: 40px;" name="active" class="form-control">
                        <option value="">من فضلك قم باختيار الحالة</option>

                        <option value="1"  <?php if(old('active') || $errors->has('active')): ?> <?php if(old('active') == '1'): ?> selected <?php endif; ?> <?php else: ?> <?php if($country->active == '1'): ?> selected <?php endif; ?> <?php endif; ?>>مفعل</option>
                        <option value="0"  <?php if(old('active') || $errors->has('active')): ?> <?php if(old('active') == '0'): ?> selected <?php endif; ?> <?php else: ?> <?php if($country->active == '0'): ?> selected <?php endif; ?> <?php endif; ?>>غير مفعل</option>

                     </select>
                     <?php if($errors->has("active")): ?>
                        <?php echo e($errors->first("active")); ?>

                     <?php endif; ?>
                  </div>
               </div>
               <button type="submit" class="btn btn-md btn-success"><i class="icofont icofont-check"></i>  تعديل </button>    <a href="<?php echo e(url("admin/countries")); ?>" class="btn btn-md btn-danger"><i class="icofont icofont-close"></i>  رجوع </a>
            </form>
         </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin_panel.blank', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>