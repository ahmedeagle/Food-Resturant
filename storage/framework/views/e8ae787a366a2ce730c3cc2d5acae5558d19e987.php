
<?php $__env->startSection('title'); ?>
   - <?php echo e($title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="page-header card">
   <div class="card-block">
      <h5 class="m-b-10"><?=$title?></h5>
      <ul class="breadcrumb-title b-t-default p-t-10">
         <li class="breadcrumb-item">
            <a href="<?php echo e(url('admin_panel/dashboard')); ?>">الرئيسية</a>
         </li>
         <li class="breadcrumb-item"><a href="<?php echo e(url('admin/tickets/' . $type)); ?>"><?=$title?></a>
         </li>
         <li class="breadcrumb-item"><a>عرض التذكرة</a>
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
   <div class="row">
      <div class="col-md-12">
         <div class="">
            <div class="row timeline-right p-t-35">
               <div class="col-12 col-sm-10 col-xl-11 p-l-5 p-b-35">
                  <div class="card">
                     <div class="card-block post-timelines">
                        <!-- <span class="dropdown-toggle addon-btn text-muted f-left service-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" role="tooltip"></span>
                        <div class="dropdown-menu dropdown-menu-left b-none services-list">
                           <a class="dropdown-item" href="#">حذف التذكرة</a>
                           <a class="dropdown-item" href="#">رجوع</a>
                        </div> -->
                        <div class="chat-header f-w-600"><?php echo e($username); ?></div>
                        <div class="social-time text-muted"><?php echo e($ticket->created_at); ?></div>
                     </div>
                     <div class="card-block">
                        <div class="timeline-details">
                           <div class="chat-header"><?php echo e($ticket->type_name); ?></div>
                           <p class="text-muted"><?php echo e($ticket->title); ?></p>
                        </div>
                     </div>
                     <div class="card-block b-b-theme b-t-theme social-msg">
                        <a> <i class="icofont icofont-comment text-muted"></i> <span class="b-r-muted">الردود <?php echo e(count($ticket_replys)); ?></span></a>
                     </div>
                     <div class="card-block user-box">
                        <div class="p-b-30"><span class="f-right">عرض جميع الردود</span></div>
                     <?php $__currentLoopData = $ticket_replys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reply): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="media m-b-20">
                           <div class="media-body b-b-muted social-client-description" style="padding-right: 20px;">
                              <div class="chat-header">
                                  <?php echo e(($reply->FromUser == "1") ? $username : 'ادارة الموقع'); ?>

                                  <span class="text-muted" style="padding-right: 5px;"><?php echo e($reply->created_at); ?></span>
                              </div>
                              <p class="text-muted"><?php echo e($reply->reply); ?></p>
                           </div>
                        </div>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <div class="media">
                           <div class="media-body" style="padding-right: 20px;">
                              <form action="<?php echo e(url("/admin/tickets/reply")); ?>" method="POST" >
                                  <?php echo e(csrf_field()); ?>

                                 <div class="">
                                    <input type="text" class="form-control" name="content" placeholder="اضافة رد"/>
                                     <input type="hidden" name="ticket_id" value="<?php echo e($ticket->id); ?>" />
                                    <div class="text-right m-t-20"> <button style="width: 63px" type="submit" class="btn btn-md btn-success">رد</button>  <a href="<?php echo e(url('admin/tickets/' . $type)); ?>" class="btn btn-md btn-danger">رجوع</a></div>
                                 </div>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin_panel.blank', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>