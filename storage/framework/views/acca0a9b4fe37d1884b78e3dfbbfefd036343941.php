<?php $__env->startSection('title'); ?>
    - <?php echo e($title); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header card">
   <div class="card-block">
      <h5 class="m-b-10"><?=$title?></h5>
      <ul class="breadcrumb-title b-t-default p-t-10">
         <li class="breadcrumb-item" style="line-height: 2.5">
            <a href="<?php echo e(url('admin/dashboard')); ?>">الرئيسية</a>
         </li>
         <li class="breadcrumb-item"><a style="line-height: 2.5"><?=$title?></a>
         </li>
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
   <div class="card">
      <div class="card-header">
         <h5><?=$title?></h5>
      </div>
      <div class="card-block">
         <div class="dt-responsive table-responsive">
            <table id="order-table" class="table table-striped table-bordered nowrap">
               <thead>
                  <tr>
                     <th>مسلسل</th>
                     <th>الاسم بالكامل</th>
                     <th>رقم الهاتف</th>
                     <th>البريد الالكترونى</th>
                     <th>الرصيد</th>
                     <th>نسبة التطبيق</th>
                     <th>التصنيف</th>
                     <th>تاريخ التسجيل</th>
                     <th>الاشتراك</th>
                     <th>مدة الاشتراك</th>
                     <th>قيمة الاشتراك</th>
                     <th>حالة المطعم</th>
                     <th>العمليات</th>
                  </tr>
               </thead>
               <tbody>
                  <?php $__currentLoopData = $providers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $merchant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($key + 1); ?></td>
                        <td><?php echo e($merchant->ar_name); ?></td>
                        <td><?php echo e($merchant->phone); ?></td>
                        <td><?php echo e($merchant->email); ?></td>
                        <td><?php echo e((new \App\Http\Controllers\Admin\Providers())->get_balance($merchant->id)); ?> ريال </td>
                        <td><?php echo e($app_percentage); ?> % </td>
                        <td><?php echo e($merchant->cat); ?></td>
                        <td><?php echo e($merchant->created_at); ?></td>
                        <td><?php echo e(($merchant->has_subscriptions == "1" ) ? 'يوجد' : 'لايوجد'); ?></td>
                        <td><?php if($merchant->subscriptions_period == "0"): ?> لايوجد <?php elseif($merchant->subscriptions_period == "1"): ?> شهرى <?php else: ?> سنوى <?php endif; ?></td>
                        <td><?php echo e($merchant->subscriptions_amount); ?></td>
                        <td><?php echo e(($merchant->accountactivated == "1") ? 'مفعل' : 'غير مفعل'); ?></td>
                        <td>
                            <?php if($merchant->accountactivated == 0): ?>
                                <a href="<?php echo e(url('admin/providers/approved/'.$merchant->id)); ?>" class="btn btn-success">تفعيل</a>
                            <?php else: ?>
                                <a href="<?php echo e(url('admin/providers/deactivate/'.$merchant->id)); ?>" class="btn btn-danger">الغاء التفعيل</a>
                            <?php endif; ?>
                            <a href="<?php echo e(url('admin/providers/view/'.$merchant->id)); ?>" class="btn btn-primary">عرض التفاصيل</a>
                            <a href="<?php echo e(url('admin/providers/change-subscription/'.$merchant->id)); ?>" class="btn btn-warning">تعديل الاشتراك</a>
                            <a href="<?php echo e(url('admin/providers/edit/'.$merchant->id)); ?>" class="btn btn-warning">تعديل  البيانات</a>
                            
                        </td>
                    </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </table>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="default-Modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">تأكيد الحذف</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>هل انت متاكد من انك تريد حذف هذا التاجر ؟</p>
            </div>
            <div class="modal-footer">
                <a id="yes" style="margin-left: 5px; color: white" class="btn btn-danger waves-effect ">حذف</a>
                <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-primary waves-effect waves-light ">رجوع</button>
            </div>
        </div>
    </div>
</div>
<script>
        function deletefn(val){
        var a = document.getElementById('yes');
        a.href = "<?php echo e(url('admin/merchants/delete')); ?>" + "/" +val;

        }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin_panel.blank', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>