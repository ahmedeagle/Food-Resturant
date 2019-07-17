<?php $__env->startSection("title"); ?>
    <?php echo e($title); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection("class"); ?>
    <?php echo e($class); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection("content"); ?>

    <main class="page-content py-5">
        <div class="container">
            <div class="row">

                <?php echo $__env->make("User.includes.menu", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                <div class="col-lg-9 col-md-8 col-12 mt-4 mt-md-0 ">
                    <div class="section-header d-flex p-3 rounded-lg bg-white shadow-around justify-content-between font-body-bold flex-lg-row flex-md-column flex-sm-row flex-column">

                        <h4 class="page-title mb-auto">الملف الشخصي</h4>

                    </div><!-- .section-header -->

                    <div class="p-3 rounded-lg shadow-around mt-4 bg-white font-body-bold">
                        <form class="edit-form" action="<?php echo e(url("/user/profile")); ?>" method="POST" novalidate>

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

                            <div class="form-group">
                                <p>صورة المستخدم</p>
                                <div class="custom-file h-auto">
                                    <input type="file" class="edit-logo-file custom-file-input" id="restaurant-logo" hidden>
                                    <label class="border-0 mb-0 cursor" for="restaurant-logo">
                                        <img src="<?php echo e($img); ?>"
                                             class="d-inline-block rounded-circle"
                                             style="width:86px;height:86px"
                                             id="edit-logo-image"
                                             alt="Restaurant Logo">
                                        <span class="font-body-md mr-2 text-primary">
                                            تغيير الصورة
                                        </span>
                                    </label>
                                </div>
                            </div><!-- .form-group logo -->

                            <button type="button" data-action="<?php echo e(url("/user/profile/edit-image")); ?>" id="edit-logo-btn" class="hidden-element btn btn-primary py-2 px-5">تغيير</button>

                            <div class="form-group">
                                <label for="user-name">الإسم الكامل</label>
                                <input type="text"
                                       class="form-control border-gray font-body-md text-gray"
                                       id="user-name"
                                       name="user-name"
                                       value="<?php echo e(old("user-name", auth()->user()->name)); ?>"
                                       placeholder="محمد عبد الله"
                                       required
                                >

                                <?php if($errors->has("user-name")): ?>

                                    <div class="alert alert-danger top-margin">
                                        <?php echo e($errors->first("user-name")); ?>

                                    </div>

                                <?php endif; ?>

                            </div><!-- .form-group name -->

                            <div class="form-group">
                                <label for="country">الدولة</label>
                                <select class="country-ajax-request custom-select text-gray font-body-md border-gray"
                                        id="country" name="user-country" data-action="<?php echo e(url("/restaurant/cities")); ?>" required>
                                    <option value="">يرجى تحديد الدولة</option>

                                    <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($country->id); ?>" <?php if( old("user-country") ): ?>  <?php if(old("user-country") == $country->id): ?> selected <?php endif; ?> <?php else: ?> <?php if($country->id == auth()->user()->country_id): ?> selected <?php endif; ?> <?php endif; ?>><?php echo e($country->ar_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                                <?php if($errors->has("user-country")): ?>

                                    <div class="alert alert-danger top-margin">
                                        <?php echo e($errors->first("user-country")); ?>

                                    </div>

                                <?php endif; ?>

                            </div><!-- .form-group country -->

                            <div class="form-group">
                                <label for="city">المدينة</label>
                                <select class="city-ajax-request custom-select text-gray font-body-md border-gray"
                                        id="city" name="user-city" required>


                                    <?php if(old("user-country") != null): ?>
                                        <?php if(old("user-country") != ""): ?>
                                            <option value="">برجاء اختيار المدينة</option>
                                            <?php $__currentLoopData = \App\Http\Controllers\User\HelperController::get_cities(old("user-country")); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($city->id); ?>" <?php if(old("user-city")): ?> <?php if(old("user-city") == $city->id): ?> selected <?php endif; ?> <?php else: ?> <?php if($city->id == auth()->user()->city_id): ?> selected <?php endif; ?> <?php endif; ?>><?php echo e($city->ar_name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                            <option value="">برجاء تحديد الدولة اولا</option>
                                        <?php endif; ?>
                                    <?php elseif(old("user-country") != ""): ?>


                                    <?php else: ?>
                                        <option value="">برجاء اختيار المدينة</option>
                                        <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($city->id); ?>" <?php if(old("user-city")): ?> <?php if(old("user-city") == $city->id): ?> selected <?php endif; ?> <?php else: ?> <?php if($city->id == auth()->user()->city_id): ?> selected <?php endif; ?> <?php endif; ?>><?php echo e($city->ar_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    <?php endif; ?>

                                </select>

                                <?php if($errors->has("user-city")): ?>

                                    <div class="alert alert-danger top-margin">
                                        <?php echo e($errors->first("user-city")); ?>

                                    </div>

                                <?php endif; ?>

                            </div><!-- .form-group city -->


                            <div class="form-group">
                                <label for="user-sax">الجنس</label>
                                <select class="custom-select text-gray font-body-md" name="user-gender" id="user-sax" required>
                                    <option value="">يرجى تحديد الجنس</option>
                                    <option value="1"  <?php if(old('user-gender')): ?> <?php if(old('user-gender') == '1'): ?> selected <?php endif; ?>  <?php else: ?> <?php if(auth()->user()->gender == 'male'): ?> selected <?php endif; ?> <?php endif; ?>>ذكر</option>
                                    <option value="2" <?php if(old('user-gender')): ?>  <?php if(old('user-gender') == '2'): ?> selected <?php endif; ?>  <?php else: ?> <?php if(auth()->user()->gender == 'female'): ?> selected <?php endif; ?> <?php endif; ?>>أنثى</option>
                                </select>

                                <?php if($errors->has("user-gender")): ?>
                                    <div class="alert alert-danger top-margin">
                                        <?php echo e($errors->first("user-gender")); ?>

                                    </div>
                                <?php endif; ?>

                            </div><!-- .form-group service provider -->



                            <div class="form-group">
                                <label for="phone-number">العمر</label>
                                <input type="tel" class="form-control border-gray font-body-md" value="<?php echo e(old('user-age', auth()->user()->age)); ?>" id="user-age" name="user-age" required>
                                <?php if($errors->has("user-age")): ?>
                                    <div class="alert alert-danger top-margin">
                                        <?php echo e($errors->first("user-age")); ?>

                                    </div>
                                <?php endif; ?>
                            </div><!-- .form-group phone -->


                            <div class="form-group">
                                <label for="phone-number">رقم الجوال</label>
                                <input type="text"
                                       class="form-control border-gray font-body-md text-gray"
                                       value="<?php echo e(old("user-phone", auth()->user()->phone)); ?>"
                                       id="phone-number"
                                       name="user-phone"
                                       placeholder="966-553-6556556+"
                                       required
                                >

                                <?php if($errors->has("user-phone")): ?>

                                    <div class="alert alert-danger top-margin">
                                        <?php echo e($errors->first("user-phone")); ?>

                                    </div>

                                <?php endif; ?>

                            </div><!-- .form-group phone -->

                            <div class="form-group">
                                <label for="email">البريد الإلكتروني</label>
                                <input type="email"
                                       class="form-control border-gray font-body-md text-gray"
                                       value="<?php echo e(old("user-email", auth()->user()->email)); ?>"
                                       id="email"
                                       name="user-email"
                                       placeholder="your@mail.com"
                                       required
                                >

                                <?php if($errors->has("user-email")): ?>

                                    <div class="alert alert-danger top-margin">
                                        <?php echo e($errors->first("user-email")); ?>

                                    </div>

                                <?php endif; ?>

                            </div><!-- .form-group email -->


                            <button type="submit" class="btn btn-primary py-2 px-5 mt-2">تغيير</button>

                        </form>
                        <form action="<?php echo e(url("/user/change-password")); ?>" id="change-password-form" method="POST">
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
                                <label for="old-password">كلمة المرور القديمة</label>
                                <input type="password"
                                       class="form-control border-gray font-body-md"
                                       id="old-password"
                                       name="old-password"
                                       required
                                >
                                <?php if($errors->has("old-password")): ?>

                                    <div class="alert alert-danger top-margin">
                                        <?php echo e($errors->first("old-password")); ?>

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

                        </form><!-- .login-form -->

                    </div>



                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->

<?php $__env->stopSection(); ?>




<?php echo $__env->make("User.layouts.master", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>