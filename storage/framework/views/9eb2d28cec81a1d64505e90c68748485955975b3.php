<?php $__env->startSection('title'); ?>
   - <?php echo e($title); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header card">
   <div class="card-block">
      <h5 class="m-b-10">العملاء</h5>
      <ul class="breadcrumb-title b-t-default p-t-10">
         <li class="breadcrumb-item">
            <a href="<?php echo e(url('admin/dashboard')); ?>}">الرئيسية</a>
         </li>
         <li class="breadcrumb-item"><a href="<?php echo e(url('admin/customers/all')); ?>">العملاء</a>
         </li>
         <li class="breadcrumb-item"><a>عرض</a>
         </li>
      </ul>
   </div>
</div>
<!-- Page-header end -->
<div class="page-body invoice-list-page">
   <!--profile cover start-->
   <div class="row">
      <div class="col-lg-12">
         <div class="cover-profile">
            <div class="profile-bg-img">
               <img class="profile-bg-img img-fluid" src="<?php echo e(($customer->user_image_url) ? $customer->user_image_url : url("/storage/app/public/users/avatar.png")); ?>" alt="bg-img">
               <div class="card-block user-info">
                  <div class="col-md-12">
                     <div class="media-left">
                        <a href="#" class="profile-image">
                        <img style="height: 108px; width: 108px" class="user-img img-radius" src="<?php echo e(($customer->user_image_url) ? $customer->user_image_url : url("/storage/app/public/users/avatar.png")); ?>" alt="user-img">
                        </a>
                     </div>
                     <div class="media-body row">
                        <div class="col-lg-12">
                           <div class="user-title">
                              <h2><?php echo e($customer->name); ?></h2>
                              <span class="text-white">عميل</span>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!--profile cover end-->
   <div class="row">
      <div class="col-lg-12">
         <!-- tab header start -->
         <div class="tab-header card">
            <ul class="nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">
               <li class="nav-item">
                  <a class="nav-link active" data-toggle="tab" href="#personal" role="tab">المعلومات الشخصية</a>
                  <div class="slide"></div>
               </li>
               <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#binfo" role="tab">طلبات العميل</a>
                  <div class="slide"></div>
               </li>
               <!-- <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#contacts" role="tab">User's Contacts</a>
                  <div class="slide"></div>
               </li> -->
               <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#review" role="tab">التذاكر</a>
                  <div class="slide"></div>
               </li>
            </ul>
         </div>
         <!-- tab header end -->
         <!-- tab content start -->
         <div class="tab-content">
            <!-- tab panel personal start -->
            <div class="tab-pane active" id="personal" role="tabpanel">
               <!-- personal card start -->
               <div class="card">
                  <div class="card-block">
                     <div class="view-info">
                        <div class="row">
                           <div class="col-lg-12">
                              <div class="general-info">
                                 <div class="row">
                                    <div class="col-lg-12 col-xl-6">
                                       <div class="table-responsive">
                                          <table class="table m-0">
                                             <tbody>
                                                <tr>
                                                   <th scope="row">الاسم بالكامل</th>
                                                   <td><?php echo e($customer->name); ?></td>
                                                </tr>
                                                <tr>
                                                   <th scope="row">الدولة</th>
                                                   <td><?php echo e($customer->country_name); ?></td>
                                                </tr>
                                                <tr>
                                                   <th scope="row">المدينة</th>
                                                   <td><?php echo e($customer->city_name); ?></td>
                                                </tr>
                                                <tr>
                                                   <th scope="row">تفعيل رقم الهاتف</th>
                                                   <td>
                                                      <?php if($customer->phoneactivated == "1"): ?>
                                                         <label class="label label-success">حساب مفعل</label>
                                                      <?php else: ?>
                                                         <label class="label label-danger">حساب غير مفعل</label>
                                                      <?php endif; ?>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </div>
                                    </div>
                                    <!-- end of table col-lg-6 -->
                                    <div class="col-lg-12 col-xl-6">
                                       <div class="table-responsive">
                                          <table class="table">
                                             <tbody>
                                                <tr>
                                                   <th scope="row">رقم الجوال</th>
                                                   <td><?php echo e($customer->phone); ?></td>
                                                </tr>
                                                <tr>
                                                   <th scope="row">البريد الالكتروني</th>
                                                   <td><a><?php echo e($customer->email); ?></a></td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">النوع</th>
                                                    <td><a><?php echo e(($customer->gender == "male") ? 'ذكر' : 'انثى'); ?></a></td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">تاريخ الميلاد</th>
                                                    <td><a><?php echo e($customer->date_of_birth); ?></a></td>
                                                </tr>

                                                <tr>
                                                   <th scope="row">تاريخ التسجيل</th>
                                                   <td><?php echo e($customer->created_at); ?></td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </div>
                                    </div>
                                    <!-- end of table col-lg-6 -->
                                 </div>
                                 <!-- end of row -->
                              </div>
                              <!-- end of general info -->
                           </div>
                           <!-- end of col-lg-12 -->
                        </div>
                        <!-- end of row -->
                     </div>
                  </div>
                  <!-- end of card-block -->
               </div>
               <!-- personal card end-->
            </div>
            <!-- tab pane personal end -->
            <!-- tab pane info start -->
            <div class="tab-pane" id="binfo">
                <div class="row">
                   <!-- Invoice list card start -->
                  <?php $__currentLoopData = $main_orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                     <div class="col-sm-6">
                       <div class="card card-border-primary">
                           <div class="card-header">
                               <h5><?php echo e($customer->name); ?></h5>
                               <div class="dropdown-secondary dropdown f-left">
                               </div>
                           </div>
                           <div class="card-block">
                               <div class="row">
                                   <div class="col-sm-6">
                                       <ul class="list list-unstyled">
                                           <li>رقم الطلب #: &nbsp;<?php echo e($order->order_code); ?></li>
                                           <li>تاريخ الطلب : &nbsp;<?php echo e($order->created_at); ?></li>
                                       </ul>
                                   </div>
                                   <div class="col-sm-6">
                                       <ul class="list list-unstyled text-right">
                                           <li>الاجمالي : <?php echo e($order->total_price); ?></li>
                                            <li>حالة الطلب: <span class="text-semibold"><?php echo e($order->status); ?></span></li>
                                           <li>نوع الدفع: <span class="text-semibold"><?php echo e($order->payment_method); ?></span></li>
                                       </ul>
                                   </div>
                               </div>
                           </div>
                           <div class="card-footer">
                               <div class="">
                                   <a href="<?php echo e(url('admin/orders/details/'.$order->id)); ?>" class="btn btn-info btn-large b-none"><i class="icofont icofont-eye-alt m-0"></i>  التفاصيل</a>
                               </div>
                               <!-- end of pull-right class -->
                           </div>
                           <!-- end of card-footer -->
                       </div>
                     </div>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                   <!-- Invoice list card end -->
               </div>
            </div>
            <!-- tab pane info end -->
            <div class="tab-pane" id="review" role="tabpanel">
               <div class="card">
                  <div class="card-block">
                     <ul class="media-list">
                        <?php $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <li class="media">
                              <div class="media-left">
                                 <a href="#">
                                 <img class="media-object img-radius comment-img" src="<?php echo e(($customer->user_image_url) ? $customer->user_image_url : url("/storage/app/public/users/avatar.png")); ?>">
                                 </a>
                              </div>
                              <div class="media-body" style="padding-right: 20px;">
                                 <h6 class="media-heading"><?php echo e($ticket->username); ?><span class="f-12 text-muted m-l-5" style="padding-right: 5px;"><?php echo e($ticket->created_at); ?></span></h6>
                                 <p class="m-b-0"><?php echo e($ticket->title); ?></p>
                                 <hr>
                                 <!-- Nested media object -->
                                 <?php $__currentLoopData = $ticket->replies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reply): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="media mt-2">
                                       <a class="media-left">
                                       <?php if($reply->FromUser == 1): ?>
                                            <img class="media-object img-radius comment-img" src="<?php echo e(($customer->user_image_url) ? $customer->user_image_url : url("/storage/app/public/users/avatar.png")); ?>">
                                       <?php else: ?>
                                               <img class="media-object img-radius comment-img" src="<?php echo e(url("/storage/app/public/admins/arab.png")); ?>">
                                       <?php endif; ?>
                                       </a>
                                       <div class="media-body" style="padding-right: 20px;">
                                          <h6 class="media-heading"><?php echo e(($reply->FromUser == 1) ? $ticket->username : 'ادارة التطبيق'); ?><span style="padding-right: 5px;" class="f-12 text-muted m-l-5"><?php echo e($reply->created_at); ?></span></h6>
                                          <p class="m-b-0"><?php echo e($reply->reply); ?></p>
                                          <hr>
                                       </div>
                                    </div>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </div>
                           </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
         <!-- tab content end -->
      </div>
   </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin_panel.blank', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>