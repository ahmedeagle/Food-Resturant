<?php $__env->startSection('title'); ?>
   - <?php echo e($title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="page-header card">
   <div class="card-block">
      <h5 class="m-b-10"><?php echo e($title); ?></h5>
      <ul class="breadcrumb-title b-t-default p-t-10">
         <li class="breadcrumb-item">
            <a href="<?php echo e(url('admin/dashboard')); ?>">الرئيسية</a>
         </li>
         <li class="breadcrumb-item"><a href="<?php echo e(url('admin/notifications/list/' . $type)); ?>">الاشعارات</a>
         </li>
         <li class="breadcrumb-item"><a>اضافة</a>
         </li>
      </ul>
   </div>
</div>
<!-- Page-header end -->
<div class="page-body">
      <!-- Basic Form Inputs card start -->
      <div class="card">
         <div class="card-header">
            <h5>اضافة اشعار جديد </h5>
         </div>
         <div class="card-block">
            <form id="notificatins-form" base_url = <?php echo e(url("/")); ?> action="<?php echo e(url('admin/notifications/store')); ?>" method="POST" enctype="multipart/form-data">
               <?php echo e(csrf_field()); ?>

               <input type="hidden" id="rec_type" name="type" value="<?php echo e($type); ?>" />
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">عنوان الاشعار</label>
                  <div class="col-sm-10">
                     <input type="text" class="title form-control" name="title" value="<?php echo e(old("title")); ?>" placeholder="من فضلك ادخل عنوان الاشعار">
                     <span style="display: none" class="title-error"></span>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">محتوى الاشعار</label>
                  <div class="col-sm-10">
                      <input type="text" class="content form-control" name="content"  value="<?php echo e(old('content')); ?>" placeholder="من فضلك ادخل محتوى الاشعار">
                      <span style="display: none" class="content-error"></span>
                  </div>
               </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">نوع الارسال</label>
                    <div class="col-sm-10">
                        <select id="select-notify-type" name="notify-type" class="form-control">
                            <option value="0">برجاء اختيار نوع الارسال</option>
                            <option value="1">ارسال الى الكل</option>
                            <option value="2">تحديد الارسال</option>
                        </select>
                        <span style="display: none;" class="type-error"></span>
                    </div>
                </div>
                <div style="display: none" id="choose-users-container" class="form-group row">
                    <label class="col-sm-2 col-form-label">مستقبلى الاشعار</label>
                    <div class="col-sm-10">
                        <button type="button" data-toggle="modal" data-target="#default-Modal" class="btn btn-default"><i class="fa fa-plus-circle"></i> اختيار من القائمة</button>
                    </div>
                </div>
                <div style="display: none;" id="users-list" class="form-group row">
                    <label class="col-sm-2 col-form-label">تفاصيل الارسال</label>
                    <div class="noti-numbers col-sm-10">
                        <!-- list of users will append here -->
                        <p>لم يتم اختيار مستقبلى الاشعار</p>
                        <span style="display: none;" class="number-error"></span>
                    </div>
                </div>
                <button class="send-notify-btn btn btn-md btn-success"><i class="icofont icofont-check"></i>  ارسال </button>    <a href="<?php echo e(url('admin/notifications/list/' . $type)); ?>" class="btn btn-md btn-danger"><i class="icofont icofont-close"></i>  رجوع </a>
            </form>
         </div>
      </div>
</div>


<div class="modal fade" id="default-Modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">اختيار مستقبلى الاشعار</h4>
            </div>
            <div class="modal-body">

                <input type="text" class="form-control" name="search" id="search" placeholder="بحث" />

                <div id="notification-container" style="overflow-y: auto;max-height: 371px;" class="user-box assign-user taskboard-right-users">
                    <?php $__currentLoopData = $receivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $receiver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div id = "refre<?php echo e($receiver->id); ?>" selectItem = "0" style="margin-bottom: 10px;" class="notification-cell list-cell media">
                            <input type="hidden" name="r_id[]" id="r_id" value="<?php echo e($receiver->id); ?>" />
                            <div class="media-left media-middle photo-table">
                                <a>
                                    <img class="media-object img-radius" src="<?php echo e(($receiver->user_image_url != "") ? $receiver->user_image_url : url("/storage/app/public/users/avatar.png")); ?>" alt="Generic placeholder image">
                                </a>
                            </div>
                            <div style="margin-right: 15px;" class="media-body">
                                <h6 id="notification_name"><?php echo e($receiver->name); ?></h6>
                                <?php if($type == "users"): ?>
                                    <p> عدد الطلبات : <?php echo e($receiver->number_of_orders); ?>

                                <?php else: ?>
                                    <p> عدد الفروع : <?php echo e($receiver->number_of_branches); ?>

                                <?php endif; ?>
                            </div>
                            <input name="check-user-btn" class="check-user-btn" style="margin-top: 20px;margin-left: 24px;" type="checkbox">
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

            </div>
            <div class="modal-footer">
                <button style="margin-left: 10px;" class="add-btn-list btn btn-success">اضافة الى القائمة</button>
                <button type="button" aria-label="Close" class="list-back btn btn-primary waves-effect waves-light ">رجوع</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="success-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">

                <div style="overflow-y: auto;max-height: 371px;" class="user-box assign-user taskboard-right-users">
                    تمت عملية الارسال بنجاح
                </div>

            </div>
            <div class="modal-footer">
                <button style="margin-left: 10px;" class="back-to-notification btn btn-success">عودة الى القائمة</button>
                <button type="button" aria-label="Close" class="clear-btn btn btn-primary waves-effect waves-light ">ارسال اشعار اخر</button>
            </div>
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin_panel.blank', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>