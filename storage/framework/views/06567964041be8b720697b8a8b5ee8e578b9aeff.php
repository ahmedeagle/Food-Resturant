<?php $__env->startSection('title'); ?>
    - <?php echo e($title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="page-header card">
   <div class="card-block">
      <h5 class="m-b-10">العروض</h5>
      <ul class="breadcrumb-title b-t-default p-t-10">
         <li class="breadcrumb-item">
            <a href="<?php echo e(('admin/dashboard')); ?>">الرئيسية</a>
         </li>
         <li class="breadcrumb-item"><a href="<?php echo e(route('admin.roles.index')); ?>">الصلاحيات </a>
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
            <h5>تعديل  صلاحية </h5>
         </div>
         <div class="card-block">
            <form action="<?php echo e(route('admin.roles.save')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo e(csrf_field()); ?>

              <div class="form-group row">
                  <label class="col-sm-2 col-form-label">اسم الصلاحية </label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="name" value="<?php echo e(old('name')); ?>" placeholder="ادخل عنوان الصلاحية ">
                      <?php if($errors->has("name")): ?>
                          <?php echo e($errors->first("name")); ?>

                      <?php endif; ?>
                  </div>
               </div>
                
 
 
                  <div class="row">
                        <div class="form-group col-sm-12">
                            <label>القدرات*</label>
                             
                        </div>
                    </div>
                    <div class="row">
                        <?php $__currentLoopData = config('global.permissions'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="form-group col-sm-4">
                                <label class="checkbox-inline">
                                    <input type="checkbox" class="chk-box" name="permissions[]" value="<?php echo e($name); ?>">  <?php echo e($value); ?>

                                </label>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

              
               <button type="submit" class="btn btn-md btn-success"><i class="icofont icofont-check"></i>  تعديل </button>     
            </form>
         </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin_panel.blank', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>