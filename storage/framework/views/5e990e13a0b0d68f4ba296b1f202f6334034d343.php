<?php $__env->startSection('title'); ?>
   - <?php echo e($title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
   <!-- Page-header start -->
   <div class="page-header card">
      <div class="card-block">
         <h5 class="m-b-10">المستخدمين</h5>
         <ul class="breadcrumb-title b-t-default p-t-10">
            <li class="breadcrumb-item">
               <a href="<?php echo e(url('/admin/dashboard')); ?>">الرئيسية</a>
            </li>
            <li class="breadcrumb-item"><a href="<?php echo e(url('/admin/admins')); ?>">المستخدمين</a>
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
            <h5>اضافة مستخدم جديدة </h5>
         </div>
         <div class="card-block">
            <form action="<?php echo e(url("/admin/admins/store")); ?>" method="POST" >
               <?php echo e(csrf_field()); ?>


               <?php if(Session::has('error')): ?>
                  <div class="alert alert-danger">
                     <?php echo e(Session::get("error")); ?>

                  </div>
               <?php endif; ?>
               <?php if(Session::has('success')): ?>
                  <div class="alert alert-success">
                     <?php echo e(Session::get("success")); ?>

                  </div>
               <?php endif; ?>

               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">الاسم</label>
                  <div class="col-sm-10">
                     <input type="text"
                            class="form-control"
                            name="name"
                            value="<?php echo e(old('name')); ?>"
                            placeholder="الاسم">
                     <?php if($errors->has('name')): ?>
                        <?php echo e($errors->first('name')); ?>

                     <?php endif; ?>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">رقم الجوال</label>
                  <div class="col-sm-10">
                     <input type="text"
                            class="form-control"
                            name="phone"
                            value="<?php echo e(old('phone')); ?>"
                            placeholder="رقم الجوال">
                     <?php if($errors->has('phone')): ?>
                        <?php echo e($errors->first('phone')); ?>

                     <?php endif; ?>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">البريد الالكترونى</label>
                  <div class="col-sm-10">
                     <input type="text"
                            class="form-control"
                            name="email"
                            value="<?php echo e(old('email')); ?>"
                            placeholder="البريد الالكترونى">
                     <?php if($errors->has('email')): ?>
                        <?php echo e($errors->first('email')); ?>

                     <?php endif; ?>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">الرقم السرى</label>
                  <div class="col-sm-10">
                     <input type="password"
                            class="form-control"
                            name="password"
                            placeholder="الرقم السرى">
                     <?php if($errors->has('password')): ?>
                        <?php echo e($errors->first('password')); ?>

                     <?php endif; ?>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">الصلاحيات</label>
                  <div class="col-sm-10">
                     <fieldset class="group">
                        <ul class="checkbox">
                           <li><input type="checkbox" name="all" id="all" /><label for="cb1">كل الصلاحيات</label></li><br /><hr />
                           <li><input type="checkbox" name="credit" /><label for="cb1">الرصيد</label></li>
                           <li><input type="checkbox" name="profile" /><label for="cb2">تعديل الملف الشخصى</label></li>
                           <li><input type="checkbox" name="settings" /><label for="cb3">الاعدادات</label></li>
                           <li><input type="checkbox" name="dashboard" /><label for="cb3">الاحصائيات</label></li>
                           <li><input type="checkbox" name="countries" /><label for="cb3">الدول</label></li>
                           <li><input type="checkbox" name="cities" /><label for="cb3">المدن</label></li>
                           <li><input type="checkbox" name="pages" /><label for="cb3">الصفحات</label></li>
                           <li><input type="checkbox" name="categories" /><label for="cb3">التصنيفات</label></li>
                           <li><input type="checkbox" name="ticket_types" /><label for="cb3">انواع التذاكر</label></li>
                           <li><input type="checkbox" name="order_status" /><label for="cb3">حالات الطلب</label></li>
                           <li><input type="checkbox" name="booking_status" /><label for="cb3">حالات الحجز</label></li>
                           <li><input type="checkbox" name="crowd" /><label for="cb3">حالات الازدحام</label></li>
                           <li><input type="checkbox" name="meals" /><label for="cb3">الوجبات</label></li>
                           <li><input type="checkbox" name="offers" /><label for="cb3">العروض</label></li>
                           <li><input type="checkbox" name="orders" /><label for="cb3">الطلبات</label></li>
                           <li><input type="checkbox" name="reservations" /><label for="cb3">الحجوزات</label></li>
                           <li><input type="checkbox" name="tickets" /><label for="cb3">التذاكر</label></li>
                           <li><input type="checkbox" name="notifications" /><label for="cb3">الاشعارات</label></li>
                           <li><input type="checkbox" name="comments" /><label for="cb3">التعليقات</label></li>
                           <li><input type="checkbox" name="providers" /><label for="cb3">المطاعم</label></li>
                           <li><input type="checkbox" name="users" /><label for="cb3">المستخدمين</label></li>
                           <li><input type="checkbox" name="withdraws" /><label for="cb3">طلبات سحب الرصيد</label></li>
                           <li><input type="checkbox" name="admins" /><label for="cb3">التحكم بأعضاء لوحة التحكم</label></li>
                        </ul>
                     </fieldset>
                  </div>
               </div>
               <button type="submit" class="btn btn-md btn-success"><i class="icofont icofont-check"></i>  اضافة </button>    <a href="<?php echo e(url("/admin/admins")); ?>" class="btn btn-md btn-danger"><i class="icofont icofont-close"></i>  رجوع </a>
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