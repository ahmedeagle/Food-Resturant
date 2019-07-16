
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
         <li class="breadcrumb-item"><a href="<?php echo e(url('admin/meals')); ?>" style="line-height: 2.5"><?php echo e($title); ?></a>
         </li>
      </ul>
   </div>
</div>
<div class="page-body">
   <div class="row">
      <div class="col-sm-12">
         <!-- Product list card start -->
         <div class="card">
            <div class="card-header">
               <h5><?php echo e($title); ?></h5>
            </div>
             <?php if(Session::has("success")): ?>
                 <div class="alert alert-success">
                     <?php echo e(Session::get("success")); ?>

                 </div>
             <?php endif; ?>
            <div class="card-block">
               <div class="table-responsive">
                  <div class="table-content">
                     <div class="project-table">

                         <table id="order-table" class="table table-striped table-bordered nowrap">
                             <thead>
                             <tr>
                                 <th>صورة الوجبة</th>
                                 <th>اسم الوجبة بالعربية</th>
                                 <th>اسم الوجبة بالانجليزية</th>
                                 <th>السعر</th>
                                 <th>السعرات الحرارية</th>
                                 <th>اسم المطعم</th>
                                 <th>مفعل</th>
                                 <th>العمليات</th>
                             </tr>
                             </thead>
                             <tbody>
                             <?php $__currentLoopData = $meals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $meal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <tr>
                                     <td class="pro-list-img">
                                         <img style="height: 64px; width: 64px;" src="<?php echo e(url("storage/app/public/meals/". $meal->image_url)); ?>" class="img-fluid" alt="tbl">
                                     </td>
                                     <td class="pro-name">
                                         <?php echo e($meal->ar_name); ?>

                                     </td>
                                     <td class="pro-name">
                                         <?php echo e($meal->en_name); ?>

                                     </td>
                                     <td><?php echo e($meal->price); ?> ريال</td>
                                     <td><?php echo e($meal->calories); ?></td>
                                     <td><?php echo e($meal->provider_name); ?></td>
                                     <td><?php echo e(($meal->published == 1) ? 'مفعل' : 'غير مفعل'); ?></td>
                                     <td class="action-icon">
                                         <a style="color:#fff !important;" href="<?php echo e(url("admin/meals/view/" . $meal->id)); ?>" class="btn btn-primary m-r-15 text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="عرض">عرض التفاصيل<i class="icofont icofont-eye-alt"></i></a>
                                         <a style="color:#fff !important;" href="<?php echo e(url("admin/meals/edit/" . $meal->id)); ?>" class="btn btn-success m-r-15 text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="عرض">تعديل</a>
                                         <?php if($meal->published == "1"): ?>
                                            <a style="color:#fff !important;" href="<?php echo e(url("admin/meals/stop/" . $meal->id)); ?>" class="btn btn-danger m-r-15 text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="عرض">ايقاف الوجبة</a>
                                         <?php else: ?>
                                             <a style="color:#fff !important;" href="<?php echo e(url("admin/meals/publish/" . $meal->id)); ?>" class="btn btn-warning m-r-15 text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="عرض">الغاء الايقاف</a>
                                         <?php endif; ?>
                                     </td>
                                 </tr>
                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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