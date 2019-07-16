<?php $__env->startSection('title'); ?>
    - <?php echo e($title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<style>
    .offer_ar_more , .offer_en_more{
        color: #3886de;
        text-decoration: underline;
    }
</style>
<div class="page-header card">
   <div class="card-block">
      <h5 class="m-b-10"><?php echo e($title); ?></h5>
      <ul class="breadcrumb-title b-t-default p-t-10">
         <li class="breadcrumb-item" style="line-height: 2.5">
            <a href="<?php echo e(url('admin/dashboard')); ?>">الرئيسية</a>
         </li>
         <li class="breadcrumb-item"><a href="<?php echo e(url('admin/comments/list')); ?>" style="line-height: 2.5"><?php echo e($title); ?></a>
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
         <h5><?php echo e($title); ?></h5>
      </div>
      <div class="card-block">
         <div class="dt-responsive table-responsive">
            <table id="order-table" class="table table-striped table-bordered nowrap">
               <thead>
                  <tr>
                      <th>مسلسل</th>
                     <th>التعليق</th>
                     <th>المطعم</th>
                     <th>المستخدم</th>
                     <th>تاريخ التعليق</th>
                     <th>حالة التعليق</th>
                     <th>العمليات</th>
                  </tr>
               </thead>
               <tbody>
                  <?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($key + 1); ?></td>
                        <td><?php echo e($comment->comment); ?></td>
                        <td><?php echo e($comment->provider_name); ?></td>
                        <td><?php echo e($comment->user_name); ?></td>
                        <td><?php echo e($comment->created_at); ?></td>
                        <td><?php echo e(($comment->stopped == "1") ? 'غير مفعل' : 'مفعل'); ?></td>
                        <td>

                            <?php if($comment->stopped == "0"): ?>

                                <a href="<?php echo e(url("/admin/branches/comments/stop/" . $comment->id)); ?>" class="btn btn-danger">إيقاف</a>

                            <?php else: ?>

                                <a href="<?php echo e(url("/admin/branches/comments/play/" . $comment->id)); ?>" class="btn btn-success">
                                    تفعيل
                                </a>

                            <?php endif; ?>
                        </td>
                    </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </table>
         </div>
      </div>
   </div>
</div>



<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin_panel.blank', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>