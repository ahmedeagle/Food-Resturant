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
                <label class="col-sm-2 col-form-label"> الصلاحيات</label>
                   <div class="col-sm-10">
                                 <select class="city-ajax-request custom-select text-gray font-body-md border-gray form-control " id="city" name="role_id" required="">                                         
                                         <option value="" selected=""> اختر صلاحيه </option>
                                       <?php if(isset($roles) && $roles -> count() > 0): ?>
                                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                              <option value="<?php echo e($role -> id); ?>"> <?php echo e($role -> name); ?></option>                                          
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                       <?php endif; ?>       
                                  
                                </select>
                   </div>
               </div>
               <button type="submit" class="btn btn-md btn-success">
                <i class="icofont icofont-check"></i>  اضافة </button>    
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