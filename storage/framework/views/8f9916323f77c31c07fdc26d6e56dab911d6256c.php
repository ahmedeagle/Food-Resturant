<?php $__env->startSection('title'); ?>
    <?php echo e($title); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('class'); ?>
    <?php echo e($class); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection("content"); ?>
    <main class="page-content py-5 mb-4">
        <div class="container">
            <div class="row">

                <?php echo $__env->make("Provider.pages.menu", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                <div class="col-lg-9 col-md-8 col-12 mt-4 mt-md-0 font-body-bold">
                    <div class="py-2 pr-3 rounded-lg shadow-around">
                        <h4 class="page-title">ملف المطعم</h4>
                    </div>
                    <div class="p-3 rounded-lg shadow-around mt-4">

                        <?php if(Session::has("success")): ?>
                            <div class="alert alert-success">
                                <?php echo e(Session::get("success")); ?>

                            </div>
                        <?php endif; ?>


                     
                         <div class="form-group">
                            <p>شعار المطعم</p>
                            <div class="custom-file h-auto">
                                <input type="file" class="edit-logo-file custom-file-input" id="restaurant-logo" hidden>
                                <label class="border-0 mb-0 cursor" for="restaurant-logo">
                                    <img src="<?php echo e($provider->provider_image_url); ?>"
                                         class="d-inline-block rounded-circle"
                                         width="86"
                                         height="86"
                                         id="edit-logo-image"
                                         alt="Restaurant Logo">
                                    <span class="font-body-md mr-2 text-primary">
                                        تغيير شعار المطعم
                                    </span>
                                </label>
                            </div>
                        </div><!-- .form-group logo -->
                        <button type="button" data-action="<?php echo e(url("/restaurant/profile/edit-image")); ?>" id="edit-logo-btn" class="hidden-element btn btn-primary py-2 px-5">تغيير</button>

                       <form action="<?php echo e(url("/restaurant/profile")); ?>" method="POST" class="edit-form">
                            <?php echo e(csrf_field()); ?>

                            <div class="top-margin form-group">
                                <label for="restaurant-name">إسم المطعم باللغة العربية</label>
                                <input type="text"
                                       class="form-control border-gray font-body-md text-gray"
                                       id="restaurant-name"
                                       name="ar_name"
                                       value="<?php echo e(old("ar_name", $provider->ar_name)); ?>">

                                <?php if($errors->has("ar_name")): ?>
                                    <div class="top-margin alert alert-danger">
                                        <?php echo e($errors->first('ar_name')); ?>

                                    </div>
                                <?php endif; ?>
                            </div><!-- .form-group name -->

                            <div class="form-group">
                                <label for="restaurant-name">إسم المطعم باللغة الانجليزية</label>
                                <input type="text"
                                       class="form-control border-gray font-body-md text-gray"
                                       id="restaurant-name"
                                       name="en_name"
                                       value="<?php echo e(old("en_name", $provider->en_name)); ?>">

                                <?php if($errors->has("en_name")): ?>
                                    <div class="top-margin alert alert-danger">
                                        <?php echo e($errors->first('en_name')); ?>

                                    </div>
                                <?php endif; ?>
                            </div><!-- .form-group name -->
                            
                            
                               <div class="form-group">
                                    <label for="service-provider">نوع مقدم الخدمة</label>
                                    <select class="custom-select text-gray font-body-md" name="service-provider" id="service-provider">
                                        <option value="">يرجى تحديد نوع مقدم الخدمة</option>
                                        <?php $__currentLoopData = $cats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($cat->id); ?>" <?php if($cat->id == $provider -> category_id): ?> selected="" <?php endif; ?>><?php echo e($cat->ar_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    
                                       <?php if($errors->has("service-provider")): ?>
                                    <div class="top-margin alert alert-danger">
                                        <?php echo e($errors->first('service-provider')); ?>

                                    </div>
                                <?php endif; ?>
                                     
                                </div><!-- .form-group service provider -->

                                <div class="form-group">
                                    <p>الخدمات المطلوبة</p>
                                    <div class="row pr-4 text-gray font-body-md">

                                        <div class="custom-control custom-checkbox pl-0 col-md-6 col-12 mb-2">
                                            <input type="checkbox"
                                                   class="custom-control-input"
                                                   name="automatic-list"
                                                   id="automatic-list"
                                                   
                                                  
                                                   
                                                   >
                                            <label class="custom-control-label font-body-md"
                                                   for="automatic-list">قائمة الكترونية</label>
                                        </div><!-- .custom-control -->

                                        <div class="custom-control custom-checkbox pl-0 col-md-6 col-12">
                                            <input type="checkbox"
                                                   class="custom-control-input"
                                                   name="accept-online-payment"
                                                   id="accept-online-payment" <?php if($provider -> accept_online_payment == '1'): ?> checked="" <?php endif; ?> >
                                            <label class="custom-control-label font-body-md"
                                                   for="accept-online-payment">قبول الدفع الالكتروني</label>
                                        </div><!-- .custom-control -->
                                        
                                        <div class="custom-control custom-checkbox pl-0 col-md-6 col-12">
                                            <input type="checkbox"
                                                   class="custom-control-input"
                                                   name="accept-order"
                                                   id="accept-order" <?php if($provider -> order_status == '1'): ?> checked="" <?php endif; ?>>
                                            <label class="custom-control-label font-body-md"
                                                   for="accept-order">قبول الطلبات</label>
                                        </div><!-- .custom-control -->

                                    </div>
                                    
                                  
                                </div><!-- .form-group service -->

                            <div class="form-group">
                                <label for="country">الدولة</label>
                                <select class="country-ajax-request custom-select text-gray font-body-md border-gray"
                                        id="country" name="country">
                                    <option value="">يرجى تحديد الدولة</option>
                                    <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($c->id); ?>" <?php if($provider->country_id == $c->id): ?> selected <?php endif; ?>><?php echo e($c->ar_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                                <?php if($errors->has("country")): ?>
                                    <div class="top-margin alert alert-danger">
                                        <?php echo e($errors->first('country')); ?>

                                    </div>
                                <?php endif; ?>

                            </div>
                            


                            <!-- .form-group country -->

                            <div class="form-group">
                                <label for="city">المدينة</label>
                                <select class="city-ajax-request form-control custom-select text-gray font-body-md border-gray"
                                        id="city" name="city">
                                    <option>يرجى تحديد المدينة</option>
                                    <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($c->id); ?>" <?php if($provider->city_id == $c->id): ?> selected <?php endif; ?>><?php echo e($c->ar_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                                <?php if($errors->has("city")): ?>
                                    <div class="top-margin alert alert-danger">
                                        <?php echo e($errors->first('city')); ?>

                                    </div>
                                <?php endif; ?>
                            </div><!-- .form-group city -->
                            
                              <!-- .form-group recieve orders -->

                            <div class="form-group">
                                <label for="accept_order"> تفعيل استلام الطلبات </label>
                                <select class="form-control custom-select text-gray font-body-md border-gray"
                                        id="accept_order" name="accept_order">
                                    <option value="0">يرجى  اختيار حالة </option>
                                    
                                        <option value="1" <?php if($provider->order_status == 1): ?> selected <?php endif; ?>>مفعل</option>
                                        <option value="2" <?php if($provider->order_status ==0): ?> selected <?php endif; ?>>غير مفعل </option>
                                   
                                </select>

                                <?php if($errors->has("accept_order")): ?>
                                    <div class="top-margin alert alert-danger">
                                        <?php echo e($errors->first('accept_order')); ?>

                                    </div>
                                <?php endif; ?>
                            </div><!-- .form-group recieve orders -->



                            <div class="form-group">
                                <label for="phone-number">رقم التواصل</label>
                                <input type="text"
                                       class="form-control border-gray font-body-md text-gray"
                                       id="phone-number"
                                       name="phone-number"
                                       placeholder="966-553-6556556+"
                                       value="<?php echo e(old("phone", $provider->phone)); ?>">

                                <?php if($errors->has("phone-number")): ?>
                                    <div class="top-margin alert alert-danger">
                                        <?php echo e($errors->first('phone-number')); ?>

                                    </div>
                                <?php endif; ?>

                            </div><!-- .form-group phone -->

                            <div class="form-group">
                                <label for="email">البريد الإلكتروني</label>
                                <input type="email"
                                       class="form-control border-gray font-body-md text-gray"
                                       id="email"
                                       name="email"
                                       value="<?php echo e(old("email", $provider->email)); ?>">

                                <?php if($errors->has("email")): ?>
                                    <div class="top-margin alert alert-danger">
                                        <?php echo e($errors->first('email')); ?>

                                    </div>
                                <?php endif; ?>

                            </div><!-- .form-group email -->

                            <div class="form-group">
                                <label for="provider-details">نبذة عن الخدمة المقدمة باللغة العربية</label>
                                <textarea class="form-control font-body-md"
                                          id="provider-details"
                                          name="ar_description"
                                          rows="6"><?php echo e(old("ar_description", $provider->ar_description)); ?></textarea>

                                <?php if($errors->has("ar_description")): ?>
                                    <div class="top-margin alert alert-danger">
                                        <?php echo e($errors->first('ar_description')); ?>

                                    </div>
                                <?php endif; ?>

                            </div><!-- .form-group details -->
                            <div class="form-group">
                                <label for="provider-details">نبذة عن الخدمة المقدمة باللغة الانجليزية</label>
                                <textarea class="form-control font-body-md"
                                          id="provider-details"
                                          name="en_description"
                                          rows="6"><?php echo e(old("en_description", $provider->en_description)); ?></textarea>

                                <?php if($errors->has("en_description")): ?>
                                    <div class="top-margin alert alert-danger">
                                        <?php echo e($errors->first('en_description')); ?>

                                    </div>
                                <?php endif; ?>

                            </div><!-- .form-group details -->

                            <button type="submit" class="btn btn-primary py-2 px-5">تغيير</button>

                        </form>
                        <form id="editpasswordform" action="<?php echo e(url("/restaurant/profile/change-password")); ?>" method="POST">
                            <?php echo e(csrf_field()); ?>

                            <hr class="bg-gray my-4">
                            <?php if(Session::has("edit-password-error")): ?>
                                <div class="alert alert-danger">
                                    <?php echo e(Session::get("edit-password-error")); ?>

                                </div>
                            <?php endif; ?>

                            <?php if(Session::has("edit-password-success")): ?>
                                <div class="alert alert-success">
                                    <?php echo e(Session::get("edit-password-success")); ?>

                                </div>
                            <?php endif; ?>
                            <div class="form-group">
                                <label for="old-password">كلمة المرور القديمة</label>
                                <input type="password"
                                       class="form-control border-gray font-body-md"
                                       id="old-password"
                                       name="old-password">

                                <?php if($errors->has("old-password")): ?>
                                    <div class="top-margin alert alert-danger">
                                        <?php echo e($errors->first('old-password')); ?>

                                    </div>
                                <?php endif; ?>

                            </div><!-- .form-group password -->

                            <div class="form-group">
                                <label for="new-password">كلمة المرور الجديدة</label>
                                <input type="password"
                                       class="form-control border-gray font-body-md"
                                       id="new-password"
                                       name="password">

                                <?php if($errors->has("password")): ?>
                                    <div class="top-margin alert alert-danger">
                                        <?php echo e($errors->first('password')); ?>

                                    </div>
                                <?php endif; ?>

                            </div><!-- .form-group password -->

                            <div class="form-group">
                                <label for="confirm-password">تأكيد كلمة المرور</label>
                                <input type="password"
                                       class="form-control border-gray font-body-md"
                                       id="confirm-password"
                                       name="password_confirmation">

                            </div><!-- .form-group password -->

                            <button type="submit" class="btn btn-primary py-2 px-5">تغيير</button>

                        </form><!-- .login-form -->

                    </div>
                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->

<?php $__env->stopSection(); ?>
<?php echo $__env->make("Provider.layouts.master", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>