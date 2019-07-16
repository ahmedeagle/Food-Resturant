<?php $__env->startSection('title'); ?>
    <?php echo e($title); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('class'); ?>
    <?php echo e($class); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection("content"); ?>
    <main class="main-content page-content py-5">
        <div class="container">

            <div class="row">

                <?php echo $__env->make("Provider.pages.menu", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                <div class="col-lg-9 col-md-8 col-12 mt-4 mt-md-0">

                    <div class="py-2 pr-3 rounded-lg shadow-around">
                        <h4 class="page-title font-body-bold">تعديل الفرع</h4>
                    </div>

                    <?php if(Session::has("warning")): ?>
                        <div class="alert alert-warning top-margin">
                            <?php echo e(Session::get("warning")); ?>

                        </div>
                    <?php endif; ?>

                    <?php if(Session::has("error")): ?>
                        <div class="alert alert-danger top-margin">
                            <?php echo e(Session::get("error")); ?>

                        </div>
                    <?php endif; ?>

                    <?php if(Session::has("success")): ?>
                        <div class="alert alert-success top-margin">
                            <?php echo e(Session::get("success")); ?>

                        </div>
                    <?php endif; ?>

                    <div class="rounded-lg shadow-around mt-4 overflow-hidden">

                        <ul class="nav nav-tabs pr-lg-3 pr-0 flex-lg-row flex-md-column flex-sm-row flex-column text-center"
                            id="new-branch-tabs"
                            role="tablist">
                            <li class="nav-item">
                                <a class="nav-link pb-3 font-body-bold active"
                                   id="info-tab"
                                   data-toggle="tab"
                                   href="#branch-info"
                                   role="tab"
                                   aria-controls="branch-info"
                                   aria-selected="true">
                                    معلومات الفرع
                                </a>
                            </li><!-- .nav-item -->

                            <li class="nav-item">
                                <a class="nav-link pb-3 font-body-bold"
                                   id="work-tab"
                                   data-toggle="tab"
                                   href="#work"
                                   role="tab"
                                   aria-controls="work"
                                   aria-selected="false">
                                    ساعات العمل
                                </a>
                            </li><!-- .nav-item -->

                            <li class="nav-item">
                                <a class="nav-link pb-3 font-body-bold"
                                   id="cats-tab"
                                   data-toggle="tab"
                                   href="#category"
                                   role="tab"
                                   aria-controls="category"
                                   aria-selected="false">
                                    الأصناف الموجودة
                                </a>
                            </li><!-- .nav-item -->

                        </ul><!-- .nav-tabs -->

                        <div class="tab-content" id="new-branch-tabs-content">

                            <div class="tab-pane fade show active"
                                 id="branch-info"
                                 role="tabpanel"
                                 aria-labelledby="info-tab">
                                <form data-action="<?php echo e(url('/restaurant/branches/edit')); ?>" id="edit-branch-from" class="new-branch-form multi-forms p-3 font-body-bold">

                                    <div class="form-group">
                                        <p>صور الفرع</p>
                                        <div class="custom-file h-auto">
                                            <input type="file" class="custom-file-input" id="restaurant-logo" hidden>
                                            <label class="border-0 mb-0 cursor" for="restaurant-logo">
                                        <span class="d-inline-block border-gray rounded p-4">
                                            <i class="fa fa-plus fa-fw fa-lg text-gray" aria-hidden="true"></i>
                                        </span>
                                            </label>
                                            <p id="branch-images-error" class="hidden-element alert alert-danger top-margin">برجاء اختيار صور الفرع</p>
                                        </div>
                                    </div><!-- .form-group logo -->

                                    <div class="top-margin add-meal-images row">
                                        <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div>
                                                <input class="image_id" type="hidden" value="<?php echo e($img->image_id); ?>" />
                                                <i class='delete-img fa fa-times' aria-hidden='true'></i>
                                                <img class='io' src='<?php echo e($img->branch_image_url); ?>' />
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="branch-name">إسم الفرع باللغة العربية</label>
                                        <input type="text"
                                               name="ar_name"
                                               value="<?php echo e($branch->ar_name); ?>"
                                               class="form-control border-gray font-body-md"
                                               id="branch-name" required>
                                    </div><!-- .form-group name -->


                                    <div class="form-group">
                                        <label for="branch-name">إسم الفرع باللغة الانجليزية</label>
                                        <input type="text"
                                               name="en_name"
                                               value="<?php echo e($branch->en_name); ?>"
                                               class="form-control border-gray font-body-md"
                                               id="branch-name" required>
                                    </div><!-- .form-group name -->

                                    <div class="form-group">
                                        <label for="service-provider">نوع الفرع</label>
                                        <select class="custom-select text-gray font-body-md" name="service-provider" id="service-provider" required>
                                            <option value="">يرجى تحديد نوع الفرع</option>
                                            <?php $__currentLoopData = $cats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($cat->id); ?>" <?php if($branch->category_id == $cat->id): ?> selected <?php endif; ?>><?php echo e($cat->ar_name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div><!-- .form-group service provider -->

                                    <div class="form-group">
                                        <p>الخدمات المتوفرة</p>
                                        <div class="row pr-4 text-gray font-body-md">

                                            <div class="custom-control custom-checkbox pl-0 col-md-4 col-12 mb-2">
                                                <input type="checkbox"
                                                       class="custom-control-input"
                                                       id="has-booking"
                                                       name="has-booking" <?php if($branch->has_booking == "1"): ?> checked <?php endif; ?>>
                                                <label class="custom-control-label font-body-md"
                                                       for="has-booking">قبول حجوزات</label>
                                            </div><!-- .custom-control -->

                                            <div class="custom-control custom-checkbox pl-0 col-md-4 col-12 mb-2">
                                                <input type="checkbox"
                                                       class="custom-control-input"
                                                       id="has-delivery"
                                                       name="has-delivery" <?php if($branch->has_delivery == "1"): ?> checked <?php endif; ?>>
                                                <label class="custom-control-label font-body-md"
                                                       for="has-delivery">توصيل الطلبات</label>
                                            </div><!-- .custom-control -->
                                            
                                            
                                             <div class="custom-control custom-checkbox pl-0 col-md-4 col-12 mb-2">
                                                <input type="checkbox"
                                                       class="custom-control-input"
                                                       id="has_payment"
                                                       name="has_payment" <?php if($branch->has_payment == "1"): ?> checked <?php endif; ?>>
                                                <label class="custom-control-label font-body-md"
                                                       for="has_payment">قبول الدفع الالكتروني</label>
                                            </div><!-- .custom-control -->


                                        </div>
                                    </div><!-- .form-group available service -->

                                    <div class="form-group">
                                        <label for="average-price">سعر التوصيل</label>
                                        <div class="input-group rounded border border-gray overflow-hidden">
                                            <input type="text"
                                                   id="delivery-price"
                                                   name="delivery-price"
                                                   value="<?php echo e($branch->delivery_price); ?>"
                                                   class="form-control border-0 font-body-md rounded-0"
                                                   aria-describedby="average-price-addon">



                                            <div class="input-group-prepend">
                                        <span id="average-price-addon"
                                              class="input-group-text bg-white border-0 font-body-md text-gray">ر.س
                                        </span>
                                            </div><!-- .input-group-prepend -->
                                        </div><!-- .input-group -->

                                        <p class="delivery-price-error top-margin alert alert-danger hidden-element"></p>
                                    </div><!-- .form-group average-price -->

                                    <div class="form-group">
                                        <label for="booking-features">خصائص الحجز</label>
                                        <select class="custom-select text-gray font-body-md border-gray"
                                                id="booking-features" name="booking-features" required>
                                            <option value="">يرجى تحديد خصائص الحجز</option>

                                            <option value="0" <?php if($branch->booking_status == "0"): ?> selected <?php endif; ?>>افراد</option>
                                            <option value="1" <?php if($branch->booking_status == "1"): ?> selected <?php endif; ?>>عائلات</option>
                                            <option value="2" <?php if($branch->booking_status == "2"): ?> selected <?php endif; ?>>افراد وعائلات</option>
                                        </select>
                                    </div><!-- .form-group booking-features -->

                                    <div class="form-group">
                                        <label for="congestion-status">حالة الإزدحام</label>
                                        <select class="custom-select text-gray font-body-md border-gray"
                                                id="congestion-status" name="congestion-status" required>
                                            <option value="">يرجى تحديد حالة الإزدحام</option>
                                            <?php $__currentLoopData = $congestion; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($c->id); ?>" <?php if($c->id == $branch->congestion_settings_id): ?> selected <?php endif; ?>><?php echo e($c->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div><!-- .form-group congestion-status -->

                                    <div class="form-group">
                                        <label for="average-price">متوسط الأسعار</label>
                                        <div class="input-group rounded border border-gray overflow-hidden">
                                            <input type="text"
                                                   id="average-price"
                                                   name="average-price"
                                                   value="<?php echo e($branch->average_price); ?>"
                                                   class="form-control border-0 font-body-md rounded-0"
                                                   aria-describedby="average-price-addon" required>



                                            <div class="input-group-prepend">
                                        <span id="average-price-addon"
                                              class="input-group-text bg-white border-0 font-body-md text-gray">ر.س
                                        </span>
                                            </div><!-- .input-group-prepend -->
                                        </div><!-- .input-group -->
                                        <p class="average-price-error top-margin alert alert-danger hidden-element"></p>
                                    </div><!-- .form-group average-price -->

                                    <div class="form-group">
                                        <p>خصائص الفرع</p>
                                        <div class="row pr-4 text-gray font-body-md">

                                            <input type="hidden" name="options_count" value="<?php echo e(count($options)); ?>" />
                                            <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="custom-control custom-checkbox pl-0 col-lg-4 col-12 mb-2">
                                                    <input type="checkbox"
                                                           class="options custom-control-input"
                                                           id="option_<?php echo e($option->id); ?>"
                                                           data="<?php echo e($option->id); ?>"
                                                           name="option_<?php echo e($option->id); ?>" <?php if($option->selected == "1"): ?> checked <?php endif; ?>>
                                                    <label class="custom-control-label font-body-md"
                                                           for="option_<?php echo e($option->id); ?>"><?php echo e($option->name); ?></label>
                                                </div><!-- .custom-control -->
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div><!-- .row -->
                                    </div><!-- .form-group branch-features -->


                                    <div class="form-group">
                                        <label for="address-text">
                                            عنوان الفرع بشكل نصي
                                        </label>
                                        <input type="text"
                                               class="form-control border-gray font-body-md"
                                               id="address-text"
                                               value="<?php echo e($branch->ar_address); ?>"
                                               name="address-text" required>
                                    </div><!-- .form-group address-text -->

                                    <div class="form-group">
                                        <label for="address-map"
                                               class="font-body-bold">عنوان الفرع على الخريطة</label>
                                        <div class="d-flex justify-content-center flex-column flex-sm-row">
                                            <input type="text"
                                                   class="form-control border-gray"
                                                   id="address-map" value="<?php echo e($branch->ar_address); ?>" disabled>

                                            <input type="hidden"
                                                   name="latLng"
                                                   value="(<?php echo e($branch->latitude); ?>,<?php echo e($branch->longitude); ?>)"
                                                   id="branch-latLng" />

                                            <input type="hidden"
                                                   name="lat"
                                                   value="<?php echo e($branch->latitude); ?>"
                                                   id="branch-lat" />
                                            <input type="hidden"
                                                   name="lng"
                                                   value="<?php echo e($branch->longitude); ?>"
                                                   id="branch-lng" />

                                            <button
                                                    type="button"
                                                    data-toggle="modal"
                                                    data-target="#confirm-location"
                                                    id="new-branch-map-btn"
                                                    class="btn btn-primary font-body-bold px-lg-5 px-md-4 px-sm-5 d-sm-inline-block d-block mr-sm-3 mt-2 mt-sm-auto">إذهب للخريطة</button>
                                        </div>
                                        <p class="branch-location-error alert alert-danger top-margin hidden-element"></p>
                                    </div><!-- .form-group address-map -->

                                    <div class="form-group">
                                        <label for="phone-number">
                                            رقم المسؤول
                                            <span class="text-gray font-body-md">
                                                 (يستخدم لتسجيل الدخول)
                                            </span>
                                        </label>
                                        <input type="text"
                                               class="form-control border-gray"
                                               id="phone-number" name="phone-number" value="<?php echo e($branch->phone); ?>" required>
                                        <p class="phone-number-error top-margin alert alert-danger hidden-element"></p>
                                    </div><!-- .form-group phone-number -->
                                    
                                    
                                      <div class="form-group">
                                        <label for="phone-number">
                                             كلمة المرور  
                                            <span class="text-gray font-body-md">
                                                 
                                            </span>
                                        </label>
                                        
                                        <input type="text"
                                               class="form-control border-gray"
                                               id="password" name="password" placeholder="ادخل كلمة المرور جديدة"  >
                                        <p class="password-error top-margin alert alert-danger hidden-element"></p>
                                    </div><!-- .form-group phone-number -->
                                    

                                    <input type="hidden" name="branch_id" value="<?php echo e($branch->id); ?>" />
                                    <button type="submit" class="btn btn-primary py-2 px-5"> تعديل </button>
                                </form><!-- .new-kind-form -->
                            </div><!-- .tab-pane -->

                            <div class="tab-pane fade p-3 font-body-bold"
                                 id="work"
                                 role="tabpanel"
                                 aria-labelledby="work-tab">
                                <p id="working-hours-error" class="alert alert-danger top-margin hidden-element">برجاء تحديد مواعيد العمل</p>
                                
                                
                                  <?php if(isset($branches) && $branches -> count() > 0 ): ?>
             
                 <div class="col-lg-6 col-12 mt-3 mt-lg-auto">
                    <div class="row">
                        <label for=""
                               class="col-form-label col-auto"> سحب التوقيتات من الفرع :</label>
                        <div class="col pr-md-0">
                            <select id="autoCompeletTimes" class="working-hours custom-select text-gray font-body-md border-gray">
                                <option value="">اختر فرع</option>
                                 
                                  <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                   <option value="<?php echo e($branch -> id); ?>"> <?php echo e($branch -> ar_name); ?> </option>
                                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>    
                                   
                             </select>
                        </div>
                    </div>
                </div>
             
            
        <br>
        
        أو
        
        
        <br>
        
        <?php endif; ?>
        
        
                                <form class="work-times">


                                    <?php $__currentLoopData = $week_days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <?php
                                            $start_time = $key . "_start_work";
                                            $end_time = $key . "_end_work";
                                        ?>
                                        <?php $__env->startComponent('User.includes.working-time'); ?>

                                            <?php $__env->slot('en_name'); ?>
                                                <?php echo e($key); ?>

                                            <?php $__env->endSlot(); ?>

                                            <?php $__env->slot('ar_name'); ?>
                                                <?php echo e($value); ?>

                                            <?php $__env->endSlot(); ?>

                                            <?php $__env->slot("start_time"); ?>
                                                <?php echo e($working_hours->$start_time); ?>

                                            <?php $__env->endSlot(); ?>
                                            <?php $__env->slot("end_time"); ?>
                                                <?php echo e($working_hours->$end_time); ?>

                                            <?php $__env->endSlot(); ?>
                                        <?php echo $__env->renderComponent(); ?>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    
                                        
                                            
                                            
                                                
                                                    
                                                        
                                                               
                                                        
                                                            
                                                                    
                                                                
                                                                
                                                            
                                                        
                                                    
                                                
                                                
                                                    
                                                        
                                                               
                                                        
                                                            
                                                                    
                                                                
                                                                
                                                            
                                                        
                                                    
                                                
                                            
                                        
                                    

                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    

                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    

                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    

                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    

                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    

                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    

                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    <button  type="submit" class="btn btn-primary py-2 px-5 submit_edit_form"> تعديل </button>
                                    
                                    

                                </form>

                            </div><!-- .tab-pane -->

                            <div class="tab-pane fade"
                                 id="category"
                                 role="tabpanel"
                                 aria-labelledby="cats-tab">
                                <div class="table-responsive bg-light">

                                    <table class="table">
                                        <thead class="font-body-bold">
                                        <tr>
                                            <th scope="col">إسم الصنف</th>
                                            <th scope="col">التصنيف</th>
                                            <th scope="col">التحكم</th>
                                        </tr>
                                        </thead>

                                        <tbody class="font-body-md text-gray border-bottom bg-white">

                                        <?php $__currentLoopData = $meals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $meal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <th scope="row" class="font-body-md text-nowrap"><?php echo e($meal->meal_name); ?></th>
                                                <td class="text-nowrap"><?php echo e($meal->cat_name); ?></td>
                                                <td class="text-nowrap">

                                                    <div class="custom-control custom-checkbox pl-0 col-md-4 col-12 mb-2">
                                                        <input type="checkbox"
                                                               class="branch-meal custom-control-input"
                                                               id="meal_<?php echo e($meal->meal_id); ?>"
                                                               data="<?php echo e($meal->meal_id); ?>"
                                                               name="meal_<?php echo e($meal->meal_id); ?>" <?php if($meal->selected == "1"): ?> checked <?php endif; ?>>
                                                        <label class="custom-control-label font-body-md"
                                                               for="meal_<?php echo e($meal->meal_id); ?>">إضافة الى الفرع</label>
                                                    </div><!-- .custom-control -->

                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>

                                </div>
                                
                                <button   type="submit" class="btn btn-primary py-2 px-5 submit_edit_form"> تعديل </button>
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                            </div><!-- .tab-pane -->

                        </div><!-- .tab-content -->


                    </div>

                </div><!-- .col-* -->
            </div><!-- .row -->

        </div><!-- .container -->

    </main><!-- .page-content -->

    <main id="map-content" class="hidden-element map-content page-content py-5">

        <header class="page-header mt-4 text-center">
            <h1 class="page-title h2 font-body-bold">تحديد الموقع</h1>
            <p class="description text-gray font-body-md mt-3">يرجى تحديد موقع الفرع عبر الخريطة</p>
            
        </header>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-sm-10 col-12 mx-auto font-body-bold mb-5 text-center">
                    <div class="embed-responsive embed-responsive-16by9 my-4 shadow-bottom">

                        <div id="map" class="embed-responsive-item"></div>

                    </div>

                    <Button type="button" id="confirm-branch-location" class="btn btn-primary px-5 no-decoration">تأكيد</Button>
                    <Button type="button" id="decline-branch-location" class="btn btn-default px-5 no-decoration">رجوع</Button>

                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

   

<!--    <script src="<?php echo e(asset("/assets/site/js/new-branch-location.js")); ?>"></script>   -->
    <script src="<?php echo e(asset("/assets/site/js/new-branch2.js")); ?>"></script>
    
     <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDKZAuxH9xTzD2DLY2nKSPKrgRi2_y0ejs&language=ar&callback=initMap">
    </script>
    
 
    
    <script>
    
    
    
	$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


   $(document).on('change','#autoCompeletTimes',function(){
       
       var branch_id = this.value;
        if(branch_id){
     
 
        $.ajax({
   	  	  
   	  	  url:  '/restaurant/branches/getTimeFromOtherBranch/'+branch_id,
   	  	  
   	  	  data:{

           'id'      : branch_id,
           'type'    : 'edit'
   	  	  } ,
           type: 'post',
   	  	  success:function(data){
                  
                $('.work-times').empty().append(data.content);
                
                if(data.content == null){
                    
                    
                     alert('الفرع غير موجود');
                }
                
 
   	  	  },
   	  	  error:function(reject){
   	  	      
   	  	      alert('فشل في جلب ساعات العمل الرجاء ادخال الاوقات يدويا ');
                
    	  	  }
         
        });

      
       
        }
   });
   
    $(document).on('click','.submit_edit_form',function(e){
        
        e.preventDefault();
        
          $('#edit-branch-from').submit(); 
    });
           
            
    var map, infoWindow , marker ,geocoder;
        
    var messagewindow;
    var markers = [];

    var prevlat;
    var prevLng

    var SelectedLatLng = "";
    var SelectedLocation = "";

    $("#new-branch-map-btn, #complete-order-location-btn").on("click", function () {
        $(".main-content").addClass("hidden-element");
        $(".map-content").removeClass("hidden-element");

        window.scrollTo(0,200);

        if($("#branch-latLng").val() !== ""){
            prevlat = $("#branch-lat").val();
            prevLng = $("#branch-lng").val();
        }else{
            prevlat = -34.397;
            prevLng = 150.6444;
        }

        initMap();

    });

    $("#decline-branch-location, #decline-user-location").on("click", function () {
        $(".main-content").removeClass("hidden-element");
        $(".map-content").addClass("hidden-element");

        if($(this).attr("id") == "decline-branch-location"){
            window.scrollTo(0,1600);
        }else{
            window.scrollTo(0,0);
        }


    });

    $("#confirm-branch-location, #confirm-user-location").on("click", function () {

        if(SelectedLatLng === ""){
            notif({
                msg: "برجاء تحديد الموقع",
                type: "warning"
            });
            return false;
        }

        $("#branch-latLng").val(SelectedLatLng);
        splitLatLng(String(SelectedLatLng));

        $("#address-map").val(SelectedLocation);

        $(".main-content").removeClass("hidden-element");
        $(".map-content").addClass("hidden-element");

        if($(this).attr("id") == "decline-branch-location"){
            window.scrollTo(0,1600);
        }else{
            window.scrollTo(0,0);
        }

    });
  

 

  function initMap() {
   

         var pos = {lat:   <?php echo e($branch->latitude); ?> ,  lng: <?php echo e($branch->longitude); ?> };  
         
         map = new google.maps.Map(document.getElementById('map'), {
             zoom: 15,
             center: pos
        });
        
          
          infoWindow = new google.maps.InfoWindow;
          geocoder = new google.maps.Geocoder();

   
              marker = new google.maps.Marker({
                position: pos,
                map: map,
                title: $("input[name='ar_name']").val()
                
            });
            
            
             infoWindow.setContent($("input[name='ar_name']").val());
             infoWindow.open(map, marker);
    
         
        // Try HTML5 geolocation.

        if($("#branch-latLng").val() === ""){
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    //infoWindow.setPosition(pos);
                   // infoWindow.setContent('Location found.');
                   // infoWindow.open(map);
                    map.setCenter(pos);
                    
                     var marker = new google.maps.Marker({
                            position: new google.maps.LatLng(pos),
                              
                            map: map,
                            title: 'موقعك الحالي'
                        });
                         
                        
                        
                        
                        
                }, function() {
                    handleLocationError(true, infoWindow, map.getCenter());
                });
            } else {
                // Browser doesn't support Geolocation
                handleLocationError(false, infoWindow, map.getCenter());
            }
        }

         var geocoder = new google.maps.Geocoder();
 

            google.maps.event.addListener(map, 'click', function(event) {
                SelectedLatLng = event.latLng;
                geocoder.geocode({
                    'latLng': event.latLng
                }, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            deleteMarkers();
                            addMarkerRunTime(event.latLng);
                            SelectedLocation = results[0].formatted_address;
                        }
                    }
                });
            });

      
 
        function addMarkerRunTime(location) {
            var marker = new google.maps.Marker({
                position: location,
                map: map
            });
            markers.push(marker);
        }

        function setMapOnAll(map) {
            for (var i = 0; i < markers.length; i++) {
                markers[i].setMap(map);
            }
        }

        function clearMarkers() {
            setMapOnAll(null);
        }

        function deleteMarkers() {
            clearMarkers();
            markers = [];
        }

    }

    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
            'Error: The Geolocation service failed.' :
            'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(map);
    }

    function splitLatLng(latLng){

        var newString = latLng.substring(0, latLng.length-1);
        var newString2 = newString.substring(1);
        var trainindIdArray = newString2.split(',');
        var lat = trainindIdArray[0];
        var Lng  = trainindIdArray[1];

        $("#branch-lat").val(lat);
        $("#branch-lng").val(Lng);
    }
         
    </script>
    
    <script>
        $(".next-working-hours").on("click", function(){
            $("#work-tab").addClass("active show");
            $(".working-hours-content").addClass("active show");
            
            $("#info-tab").removeClass("active show");
            $(".info-content").removeClass("active show");
            
            window.scrollTo(0, 0);
        });
        
        $(".prev-work").on("click", function(){
            $("#info-tab").addClass("active show");
            $(".info-content").addClass("active show");
            
            $("#work-tab").removeClass("active show");
            $(".working-hours-content").removeClass("active show");
            
            window.scrollTo(0, 0);
        });
        
        $(".next-cats").on("click", function(){
            $("#cats-tab").addClass("active show");
            $(".cat-content").addClass("active show");
            
            $("#work-tab").removeClass("active show");
            $(".working-hours-content").removeClass("active show");
            
            window.scrollTo(0, 0);
        });
        
        $(".prev-final-cat").on("click", function(){
            $("#cats-tab").removeClass("active show");
            $(".cat-content").removeClass("active show");
            
            $("#work-tab").addClass("active show");
            $(".working-hours-content").addClass("active show");
            
            window.scrollTo(0, 0);
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("Provider.layouts.master", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>