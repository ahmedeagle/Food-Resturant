
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
            <div class="card-block">
               <div class="table-responsive">
                  <div class="table-content">
                     <div class="project-table">
                        <table id="order-table" class="table table-striped table-bordered nowrap">
                           <thead>
                              <tr>
                                 <th>رقم الطلب</th>
                                 <th>صاحب الطلب</th>
                                 <th>رقم الهاتف</th>
                                 <th>الايميل</th>
                                 <th>اسم المطعم</th>
                                 <th>الاجمالي</th>
                                 <th>تاريخ  الطلب</th>
                                 <th>العمليات</th>
                              </tr>
                           </thead>
                           <tbody>
                            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <tr>
                                 <td>
                                   <?php echo e($order->id); ?>

                                 </td>
                                 <td>
                                    <h6><?php echo e($order->username); ?></h6>
                                 </td>
                                 <td>
                                    <h6><?php echo e($order->user_phone); ?></h6>
                                 </td>
                                 <td>
                                    <h6><?php echo e($order->user_email); ?></h6>
                                 </td>
                                 <td>
                                    <h6><?php echo e($order->provider_name); ?></h6>
                                 </td>
                                 <td><?php echo e($order->total_price); ?> ريال</td>
                                 <td><?php echo e($order->created_at); ?></td>
                                 <td class="action-icon">
                                    <a href="<?php echo e(url('admin/orders/view/'.$order->id)); ?>" class="btn btn-success ">عرض الفاتورة</a>  <a href="<?php echo e(url('admin/orders/details/'.$order->id)); ?>" class="btn btn-warning ">تفاصيل الطلب</a>
                                 </td>
                              </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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