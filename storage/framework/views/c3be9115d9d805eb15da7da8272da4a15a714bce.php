<?php $__env->startSection('title'); ?>
   - <?php echo e($title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="page-header card">
   <div class="card-block">
      <h5 class="m-b-10"><?php echo e($title); ?></h5>
      <ul class="breadcrumb-title b-t-default p-t-10">
         <li class="breadcrumb-item" style="line-height: 2.5">
            <a href="<?php echo e(url('admin/dashboard')); ?>">الرئيسية</a>
         </li>
         <li class="breadcrumb-item"><a href="<?php echo e(url('admin/orders')); ?>" style="line-height: 2.5"><?php echo e($title); ?></a>


         </li>

         <a style="float: left; color: white" href="<?php echo e(route('admin.roles.add')); ?>" class="btn btn-grd-primary">اضافة  صلاحيه جديده </a>


      </ul>
   </div>
</div>
<div class="page-body">

   <?php if(Session::has('error')): ?>
        <div class="alert alert-danger"> <?php echo e(Session::get('error')); ?></div>
    <?php endif; ?>
    <?php if(Session::has('success')): ?>
        <div class="alert alert-success"> <?php echo e(Session::get('success')); ?></div>
    <?php endif; ?>
   <div class="row">
      <div class="col-sm-12">
         <!-- Product list card start -->
         <div class="card">
            <div class="card-header">
               <h5><?php echo e($title); ?></h5>
            </div>
            <div class="card-block">
               <div class="table-responsive">
                  <div class="table-content">
                     <div class="project-table">
                        <table id="order-table" class="table table-striped table-bordered nowrap">
                           <thead>
                              <tr>
                                 <th>المسلسل</th>
                                 <th>الاسم </th>
                                 <th>عدد القدرات </th>
                                  <th>تم الانشاء</th>
                                    <th>اخر تعديل</th>
                                  <th>العمليات</th>
                              </tr>
                           </thead>
                           <tbody>
                           <?php if(isset($roles) && $roles -> count() > 0): ?>	
                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <tr>
                                 <td>
                                   <?php echo e($role->id); ?>

                                 </td>
                                 <td>
                                    <h6><?php echo e($role->name); ?></h6>
                                 </td>
                                 <td>
                                    <h6><?php echo e($role->user_phone); ?></h6>
                                 </td>
                                  <td>
                                   <?php echo e($role-> created_at); ?>

                                 </td>
                                   <td>
                                   <?php echo e($role-> updated_at); ?>

                                 </td>

                                 <td class="action-icon">
                                    <a href="<?php echo e(route('admin.roles.edit',$role->id)); ?>" class="btn btn-success ">تعديل  </a>  

                                    <a href="<?php echo e(route('admin.roles.delete',$role->id)); ?>" class="btn btn-danger ">حذف  </a>
                                 </td>

                              </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           <?php endif; ?> 
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- Product list card end -->
      </div>
   </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin_panel.blank', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>