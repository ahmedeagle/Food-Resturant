<?php $__env->startSection('title'); ?>
   - <?php echo e($title); ?> - <?php echo e($user -> name); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<!-- Page-header start -->
<div class="page-header card">
   <div class="card-block">
      <h5 class="m-b-10">العملاء</h5>
      <ul class="breadcrumb-title b-t-default p-t-10">
         <li class="breadcrumb-item">
            <a href="<?= url('admin_panel/dashboard')?>">الرئيسية</a>
         </li>
         <li class="breadcrumb-item"><a href="<?= url('admin_panel/customers/all')?>"> العملاء</a>
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
            <h5>        تعديل بيانات  العميل <?php echo e($user -> name); ?> </h5>
         </div>
         <div class="card-block">
                 <form action="<?php echo e(url('admin/customers/update').'/'.$user -> id); ?>" method="POST" enctype="multipart/form-data">
                     <div class="col-lg-9 col-md-8 col-12 mt-4 mt-md-0 ">
                    <div class="section-header d-flex p-3 rounded-lg bg-white shadow-around justify-content-between font-body-bold flex-lg-row flex-md-column flex-sm-row flex-column">

                        <h4 class="page-title mb-auto">الملف الشخصي</h4>

                    </div><!-- .section-header -->

                     

                            <?php echo e(csrf_field()); ?>

                          
                            <?php if(Session::has("success")): ?>

                                <div class="alert alert-success top-margin">
                                    <?php echo e(Session::get("success")); ?>

                                </div>

                            <?php endif; ?>

                            <?php if(Session::has("error")): ?>

                                <div class="alert alert-danger top-margin">
                                    <?php echo e(Session::get("error")); ?>

                                </div>

                            <?php endif; ?>

                         <br>

                            <div class="form-group">
                                <label for="user-name">الإسم الكامل</label>
                                <input type="text"
                                       class="form-control border-gray font-body-md text-gray"
                                       id="name"
                                       name="name"
                                       value="<?php echo e(old("name", $user ->name)); ?>"
                                       placeholder="محمد عبد الله"
                                       required
                                >

                                <?php if($errors->has("name")): ?>

                                    <div class="alert alert-danger top-margin">
                                        <?php echo e($errors->first("name")); ?>

                                    </div>

                                <?php endif; ?>

                            </div><!-- .form-group name -->

                            <div class="form-group">
                                <label for="country">الدولة</label>
                                <select class="country-ajax-request custom-select text-gray font-body-md border-gray"
                                        id="country" name="country" data-action="<?php echo e(url("/restaurant/cities")); ?>" required>
                                    <option value="">يرجى تحديد الدولة</option>

                                    <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($country->id); ?>" <?php if( old("country") ): ?>  <?php if(old("country") == $country->id): ?> selected <?php endif; ?> <?php else: ?> <?php if($country->id == $user ->country_id): ?> selected <?php endif; ?> <?php endif; ?>><?php echo e($country->ar_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                                <?php if($errors->has("country")): ?>

                                    <div class="alert alert-danger top-margin">
                                        <?php echo e($errors->first("country")); ?>

                                    </div>

                                <?php endif; ?>

                            </div><!-- .form-group country -->

                            <div class="form-group">
                                <label for="city">المدينة</label>
                                <select class="city-ajax-request custom-select text-gray font-body-md border-gray"
                                        id="city" name="city" required>


                                    <?php if(old("country") != null): ?>
                                        <?php if(old("country") != ""): ?>
                                            <option value="">برجاء اختيار المدينة</option>
                                            <?php $__currentLoopData = \App\Http\Controllers\User\HelperController::get_cities(old("country")); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($city->id); ?>" <?php if(old("city")): ?> <?php if(old("city") == $city->id): ?> selected <?php endif; ?> <?php else: ?> <?php if($city->id == $user ->city_id): ?> selected <?php endif; ?> <?php endif; ?>><?php echo e($city->ar_name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                            <option value="">برجاء تحديد الدولة اولا</option>
                                        <?php endif; ?>
                                    <?php elseif(old("country") != ""): ?>


                                    <?php else: ?>
                                        <option value="">برجاء اختيار المدينة</option>
                                        <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($city->id); ?>" <?php if(old("city")): ?> <?php if(old("city") == $city->id): ?> selected <?php endif; ?> <?php else: ?> <?php if($city->id == $user -> city_id): ?> selected <?php endif; ?> <?php endif; ?>><?php echo e($city->ar_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    <?php endif; ?>

                                </select>

                                <?php if($errors->has("city")): ?>

                                    <div class="alert alert-danger top-margin">
                                        <?php echo e($errors->first("city")); ?>

                                    </div>

                                <?php endif; ?>

                            </div><!-- .form-group city -->


                            <div class="form-group">
                                <label for="user-sax">الجنس</label>
                                <select class="custom-select text-gray font-body-md" name="gender" id="user-sax" required>
                                    <option value="">يرجى تحديد الجنس</option>
                                    <option value="1"  <?php if(old('gender')): ?> <?php if(old('gender') == '1'): ?> selected <?php endif; ?>  <?php else: ?> <?php if($user ->gender == 'male'): ?> selected <?php endif; ?> <?php endif; ?>>ذكر</option>
                                    <option value="2" <?php if(old('gender')): ?>  <?php if(old('gender') == '2'): ?> selected <?php endif; ?>  <?php else: ?> <?php if($user -> gender == 'female'): ?> selected <?php endif; ?> <?php endif; ?>>أنثى</option>
                                </select>

                                <?php if($errors->has("gender")): ?>
                                    <div class="alert alert-danger top-margin">
                                        <?php echo e($errors->first("gender")); ?>

                                    </div>
                                <?php endif; ?>

                            </div><!-- .form-group service provider -->

 

                            <div class="form-group">
                                <label for="phone-number">العمر</label>
                                <input type="date" class="form-control border-gray font-body-md" value="<?php echo e(old('date_of_birth', $user -> date_of_birth)); ?>" id="user-age" name="date_of_birth" required>
                                <?php if($errors->has("date_of_birth")): ?>
                                    <div class="alert alert-danger top-margin">
                                        <?php echo e($errors->first("date_of_birth")); ?>

                                    </div>
                                <?php endif; ?>
                            </div><!-- .form-group phone -->


                            <div class="form-group">
                                <label for="phone-number">رقم الجوال</label>
                                <input type="text"
                                       class="form-control border-gray font-body-md text-gray"
                                       value="<?php echo e(old("phone", $user ->phone)); ?>"
                                       id="phone-number"
                                       name="phone"
                                       placeholder="966-553-6556556+"
                                       required
                                >

                                <?php if($errors->has("phone")): ?>

                                    <div class="alert alert-danger top-margin">
                                        <?php echo e($errors->first("phone")); ?>

                                    </div>

                                <?php endif; ?>   

                            </div><!-- .form-group phone -->

                            <div class="form-group">
                                <label for="email">البريد الإلكتروني</label>
                                <input type="email"
                                       class="form-control border-gray font-body-md text-gray"
                                       value="<?php echo e(old("email", $user->email)); ?>"
                                       id="email"
                                       name="email"
                                       placeholder="your@mail.com"
                                       required
                                >

                                <?php if($errors->has("email")): ?>

                                    <div class="alert alert-danger top-margin">
                                        <?php echo e($errors->first("email")); ?>

                                    </div>

                                <?php endif; ?>

                            </div><!-- .form-group email -->


                            <button type="submit" class="btn btn-primary py-2 px-5 mt-2">تغيير</button>
                            
                       </div>        

                        </form>
                        
                        <br><br>
                 <form action="<?php echo e(url("/admin/customers/change-password".'/'.$user  -> id)); ?>" id="change-password-form" method="POST">
                            
                              <div class="col-lg-9 col-md-8 col-12 mt-4 mt-md-0 ">                            
                            <?php echo e(csrf_field()); ?>


                            <hr class="bg-gray my-4">


                            <?php if(Session::has("edit-password-success")): ?>

                                <div class="alert alert-success top-margin">
                                    <?php echo e(Session::get("edit-password-success")); ?>

                                </div>

                            <?php endif; ?>

                            <?php if(Session::has("edit-password-error")): ?>

                                <div class="alert alert-danger top-margin">
                                    <?php echo e(Session::get("edit-password-error")); ?>

                                </div>

                            <?php endif; ?>

                            <div class="form-group">
                                <label for="old_password">كلمة المرور القديمة</label>
                                <input type="password"
                                       class="form-control border-gray font-body-md"
                                       id="old-password"
                                       name="old_password"
                                       required
                                >
                                <?php if($errors->has("old_password")): ?>

                                    <div class="alert alert-danger top-margin">
                                        <?php echo e($errors->first("old_password")); ?>

                                    </div>

                                <?php endif; ?>
                            </div><!-- .form-group password -->

                            <div class="form-group">
                                <label for="new-password">كلمة المرور الجديدة</label>
                                <input type="password"
                                       class="form-control border-gray font-body-md"
                                       id="new-password"
                                       name="password"
                                       minlength="6"
                                       required
                                >
                                <?php if($errors->has("password")): ?>

                                    <div class="alert alert-danger top-margin">
                                        <?php echo e($errors->first("password")); ?>

                                    </div>

                                <?php endif; ?>
                            </div><!-- .form-group password -->

                            <div class="form-group">
                                <label for="confirm-password">تأكيد كلمة المرور</label>
                                <input type="password"
                                       class="form-control border-gray font-body-md"
                                       id="confirm-password"
                                       name="password_confirmation"
                                       required
                                >
                            </div><!-- .form-group password -->

                            <button type="submit" class="btn btn-primary py-2 px-5">تغيير</button>

                 
              </div>
            </form>
         </div>
</div>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('script'); ?>
   
   <script>
       
       
   
   
   
        // Request Function
    function request(url,type,data,beforeSend,success,error){
        $.ajax({
            url: url,
            type:type,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:data,
            processData: false,
            contentType: false,
            beforeSend: beforeSend,
            success: success,
            error:error
        });
    }
    
    
        /*
        *   Get the Cities List from the server
        * */
        
        
        

    $(".country-ajax-request").on('change', function(){
        
        var id = $(this).find(":selected").val();
        
         
       if( id == "") {
           $(".city-ajax-request").html("<option value=''>برجاء تحديد الدولة اولا</option>");
           $(".city-ajax-request").focus();
           return false;
       }

       var url = $(this).attr("data-action");

       var data = new FormData();
       data.append("country", id);

       request(url, "POST", data,function(){}, function(data){
           
           $(".city-ajax-request").html("<option value=''>يرجى تحديد المدينة</option>");
            $.each(data.cities, function(k,v){
               $(".city-ajax-request").append("<option value='"+ v.id +"'>"+ v.name +"</option>");
                $(".city-ajax-request").focus();
           })

       },function(error){

       });
    });
    
   </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin_panel.blank', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>