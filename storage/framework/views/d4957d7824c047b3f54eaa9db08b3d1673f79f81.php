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
         <li class="breadcrumb-item"><a href="<?php echo e(url('admin/notifications/list/' . $type)); ?>" style="line-height: 2.5"><?php echo e($title); ?></a>
         </li>
         <a style="float: left; color: white" href="<?php echo e(url('/admin/notifications/add/' . $type)); ?>" class="btn btn-grd-primary">ارسال اشعار جديد</a>
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
                     <th>عنوان الاشعار</th>
                     <th>محتوى الاشعار</th>
                     <th>تاريخ الانشاء</th>
                     <th>العمليات</th>
                  </tr>
               </thead>
               <tbody>
                  <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($key + 1); ?></td>
                        <td><?php echo e($n->title); ?></td>
                        <td><?php echo e($n->content); ?></td>
                        <td><?php echo e($n->created_at); ?></td>
                        <td>
                            <button value="<?php echo e($n->notification_id); ?>" type="button" class="btn btn-success waves-effect" data-toggle="modal" data-target="#default-Modal<?php echo e($n->notification_id); ?>">عرض مستقبلى الاشعار</button>
                            <button value="<?php echo e($n->notification_id); ?>" type="button" class="btn btn-danger waves-effect" data-toggle="modal" data-target="#default-Modal" onclick="deletefn(this.value)">حذف</button>
                        </td>
                    </tr>
                    <div class="modal fade" id="default-Modal<?php echo e($n->notification_id); ?>" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">عرض مستقبلى الاشعار</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input type="text" class="form-control search-notification" id="search-notification-2"  placeholder="بحث" />
                                    <div class="notification-container-2 user-box assign-user taskboard-right-users">
                                        <?php $__currentLoopData = $n->users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="media notification-cell-2">
                                                <div class="media-left media-middle photo-table">
                                                    <a>
                                                        <img class="media-object img-radius" src="<?php echo e(($user->user_image_url != "") ? $user->user_image_url : url("/storage/app/public/users/avatar.png")); ?>" alt="Generic placeholder image">
                                                    </a>
                                                </div>
                                                <div style="margin-right: 15px;" class="media-body">
                                                    <h6 id="notification_name"><?php echo e($user->user_name); ?></h6>
                                                    <p> عدد الطلبات : <?php echo e($user->number_of_orders); ?></p>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-primary waves-effect waves-light ">رجوع</button>
                                </div>
                            </div>
                        </div>
                    </div>
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
                <h4 class="modal-title">حذف الاشعار</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>هل تريد حذف هذا الاشعار؟</p>
            </div>
            <div class="modal-footer">
                <a id="yes" style="margin-left: 5px; color: white" class="btn btn-danger waves-effect ">حذف</a>
                <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-primary waves-effect waves-light ">رجوع</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
        function deletefn(val){
        var a = document.getElementById('yes');
        a.href = "<?php echo e(url('admin/notifications/delete')); ?>" + "/" + val ;

        }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin_panel.blank', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>