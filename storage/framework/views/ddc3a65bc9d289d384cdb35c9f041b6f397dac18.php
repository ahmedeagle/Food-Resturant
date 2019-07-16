<?php $__env->startSection('title'); ?>
   - <?php echo e($title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection("content"); ?>
   <div class="page-header card">
      <div class="card-block">
         <h5 class="m-b-10">المستخدمين</h5>
         <ul class="breadcrumb-title b-t-default p-t-10">
            <li class="breadcrumb-item">
               <a href="<?php echo e(url("/admin/dashboard")); ?>">الرئيسية</a>
            </li>
            <li class="breadcrumb-item"><a href="<?php echo e(url("/admin/admins")); ?>">المستخدمين</a>
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
            <h5>تعديل المدير</h5>
         </div>
         <div class="card-block">
            <form action="<?php echo e(url("/admin/admins/update/" . $admin->id)); ?>" method="POST" enctype="multipart/form-data">
               <?php echo e(csrf_field()); ?>

               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">الاسم</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="name" value="<?php echo e(old('name' , $admin->name)); ?>"
                            placeholder="الاسم">
                     <?php if($errors->has('name')): ?>
                        <?php echo e($errors->first('name')); ?>

                     <?php endif; ?>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">رقم الجوال</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="phone" value="<?php echo e(old("phone" , $admin->phone)); ?>"
                            placeholder="رقم الجوال">
                     <?php if($errors->has('phone')): ?>
                        <?php echo e($errors->first('phone')); ?>

                     <?php endif; ?>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">البريد الالكترونى</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="email" value="<?php echo e(old("email", $admin->email)); ?>"
                            placeholder="البريد الالكترونى">
                     <?php if($errors->has('email')): ?>
                        <?php echo e($errors->first('email')); ?>

                     <?php endif; ?>
                  </div>
               </div>
               
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">كلمة المرور  </label>
                  <div class="col-sm-10">
                     <input type="password" class="form-control" name="password"
                            placeholder="كلمه المرور  ">
                     <?php if($errors->has('password')): ?>
                        <?php echo e($errors->first('password')); ?>

                     <?php endif; ?>
                  </div>
               </div>
               
               
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">تاكيد كلمه المرور  </label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="password_confirmation"
                            placeholder="تاكيد كلمه المرور ">
                     <?php if($errors->has('password_confirmation')): ?>
                        <?php echo e($errors->first('password_confirmation')); ?>

                     <?php endif; ?>
                  </div>
               </div>
               


                  <div class="form-group row">
                     <label class="col-sm-2 col-form-label">الصلاحيات</label>
                     <div class="col-sm-10">
                        <?php if($admin->id != 1): ?>
                        <fieldset class="group">
                           <ul class="checkbox">
                              <li><input type="checkbox" name="all" id="all" /><label for="cb1">كل الصلاحيات</label></li><br /><hr />
                              <li><input type="checkbox" name="credit" <?php if($permissions->credit == "1"): ?> checked <?php endif; ?> /><label for="cb1">الرصيد</label></li>
                              <li><input type="checkbox" name="profile" <?php if($permissions->profile == "1"): ?> checked <?php endif; ?> /><label for="cb2">تعديل الملف الشخصى</label></li>
                              <li><input type="checkbox" name="settings" <?php if($permissions->settings == "1"): ?> checked <?php endif; ?> /><label for="cb3">الاعدادات</label></li>
                              <li><input type="checkbox" name="dashboard" <?php if($permissions->dashboard == "1"): ?> checked <?php endif; ?> /><label for="cb3">الاحصائيات</label></li>
                              <li><input type="checkbox" name="countries" <?php if($permissions->countries == "1"): ?> checked <?php endif; ?> /><label for="cb3">الدول</label></li>
                              <li><input type="checkbox" name="cities" <?php if($permissions->cities == "1"): ?> checked <?php endif; ?> /><label for="cb3">المدن</label></li>
                              <li><input type="checkbox" name="pages" <?php if($permissions->pages == "1"): ?> checked <?php endif; ?> /><label for="cb3">الصفحات</label></li>
                              <li><input type="checkbox" name="categories" <?php if($permissions->categories == "1"): ?> checked <?php endif; ?> /><label for="cb3">التصنيفات</label></li>
                              <li><input type="checkbox" name="ticket_types" <?php if($permissions->ticket_types == "1"): ?> checked <?php endif; ?> /><label for="cb3">انواع التذاكر</label></li>
                              <li><input type="checkbox" name="order_status" <?php if($permissions->order_status == "1"): ?> checked <?php endif; ?> /><label for="cb3">حالات الطلب</label></li>
                              <li><input type="checkbox" name="booking_status" <?php if($permissions->booking_status == "1"): ?> checked <?php endif; ?> /><label for="cb3">حالات الحجز</label></li>
                              <li><input type="checkbox" name="crowd" <?php if($permissions->crowd == "1"): ?> checked <?php endif; ?> /><label for="cb3">حالات الازدحام</label></li>
                              <li><input type="checkbox" name="meals" <?php if($permissions->meals == "1"): ?> checked <?php endif; ?> /><label for="cb3">الوجبات</label></li>
                              <li><input type="checkbox" name="offers" <?php if($permissions->offers == "1"): ?> checked <?php endif; ?> /><label for="cb3">العروض</label></li>
                              <li><input type="checkbox" name="orders" <?php if($permissions->orders == "1"): ?> checked <?php endif; ?> /><label for="cb3">الطلبات</label></li>
                              <li><input type="checkbox" name="reservations" <?php if($permissions->reservations == "1"): ?> checked <?php endif; ?> /><label for="cb3">الحجوزات</label></li>
                              <li><input type="checkbox" name="tickets" <?php if($permissions->tickets == "1"): ?> checked <?php endif; ?> /><label for="cb3">التذاكر</label></li>
                              <li><input type="checkbox" name="notifications" <?php if($permissions->notifications == "1"): ?> checked <?php endif; ?> /><label for="cb3">الاشعارات</label></li>
                              <li><input type="checkbox" name="comments" <?php if($permissions->comments == "1"): ?> checked <?php endif; ?> /><label for="cb3">التعليقات</label></li>
                              <li><input type="checkbox" name="providers" <?php if($permissions->providers == "1"): ?> checked <?php endif; ?> /><label for="cb3">المطاعم</label></li>
                              <li><input type="checkbox" name="users" <?php if($permissions->users == "1"): ?> checked <?php endif; ?> /><label for="cb3">المستخدمين</label></li>
                              <li><input type="checkbox" name="withdraws" <?php if($permissions->withdraws == "1"): ?> checked <?php endif; ?> /><label for="cb3">طلبات سحب الرصيد</label></li>
                              <li><input type="checkbox" name="admins" <?php if($permissions->admins == "1"): ?> checked <?php endif; ?> /><label for="cb3">التحكم بأعضاء لوحة التحكم</label></li>
                           </ul>
                        </fieldset>
                        <?php else: ?>
                           <p>كل الصلاحيات</p>
                        <?php endif; ?>
                     </div>
                  </div>
               <button type="submit" class="btn btn-md btn-success"><i class="icofont icofont-check"></i>  تعديل </button>    <a href="<?php echo e(url("admin/admins")); ?>" class="btn btn-md btn-danger"><i class="icofont icofont-close"></i>  رجوع </a>
            </form>
         </div>
      </div>
   </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('style'); ?>
   <style>
      fieldset.group  {
         margin: 0;
         margin-bottom: 1.25em;
         padding: .125em;
      }

      fieldset.group legend {
         margin: 0;
         padding: 0;
         font-weight: bold;
         margin-left: 20px;
         font-size: 100%;
         color: black;
      }


      ul.checkbox  {
         padding: 0;
         margin-right: 20px;
         list-style: none;
      }

      ul.checkbox li input {
         margin-right: .25em;
      }

      ul.checkbox li {
         float: right;
         min-width: 200px;
      }

      ul.checkbox li label {
         margin-right: 10px;
      }

   </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
   <script>
       var all = 0;
       $("#all").on("click", function () {
           if(all == 0){
               $( 'input[type="checkbox"]').prop("checked", true);
               all = 1;
           }else{
               $( 'input[type="checkbox"]' ).prop("checked", false);
               all = 0;
           }

       });
   </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin_panel.blank', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>