<?php $__env->startSection('title'); ?>
    <?php echo e($title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('class'); ?>
    <?php echo e($class); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <main class="page-content py-5">
        <div class="container">


            <div class="row">

                <?php if(auth('web')->user()): ?>
                    <?php echo $__env->make("User.includes.menu", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php endif; ?>
                <div class="<?php if(auth('web')->user()): ?> col-lg-9 col-md-8 col-12 <?php else: ?> col-lg-12 col-md-11 col-12 <?php endif; ?> mt-4 mt-md-0 font-body-bold">
                    <div class="py-2 pr-3 rounded-lg shadow-around bg-white">
                        <h4 class="page-title font-body-bold"><?php echo e($branch->name); ?></h4>
                    </div>

                    <?php if(Session::has('success')): ?>
                        <div class="alert alert-success top-margin">

                            <?php echo e(Session::get('success')); ?>


                        </div>
                    <?php endif; ?>

                    <?php if(Session::has('error')): ?>
                        <div class="alert alert-danger top-margin">

                            <?php echo e(Session::get('error')); ?>


                        </div>
                    <?php endif; ?>

                    <div class="d-flex px-3 rounded-lg shadow-around mt-4 justify-content-between flex-lg-row flex-md-column flex-sm-column flex-column bg-white">
                        <ul class="nav nav-tabs border-0 pr-lg-2 pr-0 text-center justify-content-center"
                            id="new-branch-tabs"
                            role="tablist">

                            <li class="nav-item">
                                <a class="nav-link pb-3 font-body-bold active"
                                   id="current-tab"
                                   data-toggle="tab"
                                   href="#current"
                                   role="tab"
                                   aria-controls="current"
                                   aria-selected="true">
                                    التفاصيل
                                </a>
                            </li><!-- .nav-item -->

                            <li class="nav-item">
                                <a class="nav-link pb-3 font-body-bold"
                                   id="features-tab"
                                   data-toggle="tab"
                                   href="#features"
                                   role="tab"
                                   aria-controls="features"
                                   aria-selected="false">
                                    الميزات
                                </a>
                            </li><!-- .nav-item -->

                            <li class="nav-item">
                                <a class="nav-link pb-3 font-body-bold"
                                   id="reservations-tab"
                                   data-toggle="tab"
                                   href="#reservations"
                                   role="tab"
                                   aria-controls="reservations"
                                   aria-selected="false">
                                    الحجز
                                </a>
                            </li><!-- .nav-item -->

                            <li class="nav-item">
                                <a class="nav-link pb-3 font-body-bold"
                                   id="menu-tab"
                                   data-toggle="tab"
                                   href="#menu"
                                   role="tab"
                                   aria-controls="menu"
                                   aria-selected="false">
                                    قائمة الطعام
                                </a>
                            </li><!-- .nav-item -->

                            <li class="nav-item">
                                <a class="nav-link pb-3 font-body-bold"
                                   id="comments-tab"
                                   data-toggle="tab"
                                   href="#comments"
                                   role="tab"
                                   aria-controls="comments"
                                   aria-selected="false">
                                    التعليقات
                                </a>
                            </li><!-- .nav-item -->

                        </ul><!-- .nav-tabs -->
                    </div>


                    <div class="tab-content">

                        <div class="tab-pane fade show active"
                             id="current"
                             role="tabpanel"
                             aria-describedby="current-tab">


                            <div class="mael-pic mt-4 rounded-lg shadow-around bg-white">

                                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">

                                    <ol class="carousel-indicators">
                                        <?php $__currentLoopData = $branch->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li data-target="#carouselExampleControls" data-slide-to="<?php echo e($key); ?>" class="<?php if($key == 0): ?> active <?php endif; ?>"></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ol>

                                    <div class="carousel-inner">

                                        <?php $__currentLoopData = $branch->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                            <div class="carousel-item <?php if($key == 0): ?> active <?php endif; ?>">
                                                <img style="width:825px;height:331px" class="d-block w-100" src="<?php echo e($img->image_url); ?>" alt="First slide" draggable="false">
                                            </div>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </div>

                                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>


                                <!-- <div class="d-flex justify-content-center flex-sm-row">
                                    <p class="page-content font-body-md text-gray py-2 py-3 px-3">
                                            هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق.
                                    </p>
                                    <span class="love mt-xs-5 ml-3 px-md-4 px-sm-4 d-sm-inline-block d-block mr-sm-3 mt-2 mb-auto mt-sm-auto rounded-lg shadow-around">
                                        <i class="fa fa-heart fa-lg text-white cursor"></i>
                                    </span>

                                </div> -->

                                <div class="d-flex justify-content-center flex-column flex-sm-row pb-3">
                                    <p class="page-content font-body-md text-gray py-3 px-3 mb-0">
                                        <?php echo e($branch->description); ?>

                                    </p>
                                    <?php if(auth('web')->user()): ?>

                                        <?php if($branch->is_favorite): ?>
                                            <a href="<?php echo e(url("/user/favorites/remove/" . $branch->id)); ?>">
                                                    <span title="<?php echo e(trans("user.remove-favorite")); ?>" style="background:#97246b" class="love rounded-lg shadow-around ml-3 px-md-4 px-sm-4 d-sm-inline-block d-block mt-2 mt-sm-auto mr-3">
                                                        <i class="fa fa-heart fa-lg text-white cursor text-center justify-content-center align-items-center"></i>
                                                    </span>
                                            </a>
                                        <?php else: ?>
                                            <a href="<?php echo e(url("/user/favorites/add/" . $branch->id)); ?>">
                                                    <span title="<?php echo e(trans("user.add-favorite")); ?>" class="love rounded-lg shadow-around ml-3 px-md-4 px-sm-4 d-sm-inline-block d-block mt-2 mt-sm-auto mr-3">
                                                        <i class="fa fa-heart fa-lg text-white cursor text-center justify-content-center align-items-center"></i>
                                                    </span>
                                            </a>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                </div>

                            </div>
                            <div class="p-3 rounded-lg shadow-around mt-3 bg-white">

                                <div class="row">
                                    <div class="res-column-one col-sm-4 col font-body-md ">
                                        <p>ساعات العمل</p>
                                        <p>متوسط الاسعار</p>
                                        <p>نوع الأكل</p>
                                        <p>العنوان</p>
                                        <p>خدمات</p>
                                    </div>
                                    <div class="res-column-two col-sm-8 col text-gray font-body-md">
                                        <p>الأحد :-<?php if($branch_working_hours->sunday_start_work != null): ?> من <?php echo e($branch_working_hours->sunday_start_work); ?> <?php echo e($branch_working_hours->sunday_start_work_extention); ?> حتى <?php echo e($branch_working_hours->sunday_end_work); ?> <?php echo e($branch_working_hours->sunday_end_work_extention); ?> <?php else: ?> لا يعمل <?php endif; ?>
                                            <a style="color:#97246b;text-decoration: underline;cursor: pointer"
                                                  data-toggle="modal"
                                                  title="مشاهدة جميع اوقات العمل"
                                                  data-target="#confirm-delete"
                                                  aria-hidden="true">
                                            <i class="fas fa-eye"></i>        
                                            </a>
                                        </p>
                                        <p><?php echo e($branch->menu_average_price); ?> ر.س</p>
                                        <p><?php echo e($branch->categories_string); ?></p>
                                        <p><?php echo e($branch->address); ?></p>
                                        <div>
                                            <?php if($branch->has_delivery || $branch->has_booking): ?>
                                                <?php if($branch->has_booking): ?>
                                                    <img src="<?php echo e(url('/assets/site/img/-e-reserved-icon.svg')); ?>"
                                                         class="img-fluid d-inline mx-auto my-2">
                                                <?php endif; ?>

                                                <?php if($branch->has_delivery): ?>
                                                    <img src="<?php echo e(url('/assets/site/img/-e-delivery-icon.svg')); ?>"
                                                         class="img-fluid d-inline mx-auto my-2 pr-2">
                                                <?php endif; ?>

                                            <?php else: ?>
                                                <p>لا توجد خدمات</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Start Working Hours Modal -->

                            <div class="modal fade"
                                 id="confirm-delete"
                                 tabindex="-1"
                                 role="dialog"
                                 aria-labelledby="exampleModalLabel"
                                 aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content py-3">
                                        <p class="modal-body h4 font-weight-bold text-center mb-auto">
                                            ساعات العمل
                                        </p>
                                        <div style="padding: 15px;" class="form-group">

                                        <p>الأحد :-<?php if($branch_working_hours->sunday_start_work != null): ?> من <?php echo e($branch_working_hours->sunday_start_work); ?> <?php echo e($branch_working_hours->sunday_start_work_extention); ?> حتى <?php echo e($branch_working_hours->sunday_end_work); ?> <?php echo e($branch_working_hours->sunday_end_work_extention); ?> <?php else: ?> لا يعمل <?php endif; ?></p>

                                        <p>الاثنين :-<?php if($branch_working_hours->monday_start_work != null): ?> من <?php echo e($branch_working_hours->monday_start_work); ?> <?php echo e($branch_working_hours->monday_start_work_extention); ?> حتى <?php echo e($branch_working_hours->monday_end_work); ?> <?php echo e($branch_working_hours->monday_end_work_extention); ?> <?php else: ?> لا يعمل <?php endif; ?></p>

                                        <p>الثلاثاء :-<?php if($branch_working_hours->tuesday_start_work != null): ?> من <?php echo e($branch_working_hours->tuesday_start_work); ?> <?php echo e($branch_working_hours->tuesday_start_work_extention); ?> حتى <?php echo e($branch_working_hours->tuesday_end_work); ?> <?php echo e($branch_working_hours->tuesday_end_work_extention); ?> <?php else: ?> لا يعمل <?php endif; ?></p>

                                        <p>الاربعاء :-<?php if($branch_working_hours->wednesday_start_work != null): ?> من <?php echo e($branch_working_hours->wednesday_start_work); ?> <?php echo e($branch_working_hours->wednesday_start_work_extention); ?> حتى <?php echo e($branch_working_hours->wednesday_end_work); ?> <?php echo e($branch_working_hours->wednesday_end_work_extention); ?> <?php else: ?> لا يعمل <?php endif; ?></p>

                                        <p>الخميس :-<?php if($branch_working_hours->thursday_start_work != null): ?> من <?php echo e($branch_working_hours->thursday_start_work); ?> <?php echo e($branch_working_hours->thursday_start_work_extention); ?> حتى <?php echo e($branch_working_hours->thursday_end_work); ?> <?php echo e($branch_working_hours->thursday_end_work_extention); ?> <?php else: ?> لا يعمل <?php endif; ?></p>
                                        <hr />
                                        <p>الجمعة :-<?php if($branch_working_hours->friday_start_work != null): ?> من <?php echo e($branch_working_hours->friday_start_work); ?> <?php echo e($branch_working_hours->friday_start_work_extention); ?> حتى <?php echo e($branch_working_hours->friday_end_work); ?> <?php echo e($branch_working_hours->friday_end_work_extention); ?> <?php else: ?> لا يعمل <?php endif; ?></p>
                                        <hr />
                                        <p>السبت :-<?php if($branch_working_hours->saturday_start_work != null): ?> من <?php echo e($branch_working_hours->saturday_start_work); ?> <?php echo e($branch_working_hours->saturday_start_work_extention); ?> حتى <?php echo e($branch_working_hours->saturday_end_work); ?> <?php echo e($branch_working_hours->saturday_end_work_extention); ?> <?php else: ?> لا يعمل <?php endif; ?></p>

                                        </div>
                                        <div class="modal-footer d-flex justify-content-center pt-0">
                                            <button type="button"
                                                    class="top-margin btn btn-primary px-4 px-sm-5 ml-3 font-weight-bold"
                                                    data-dismiss="modal">إلغاء</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- End Working Hours Modal -->
                            <div class="rounded-lg shadow-around mt-3">
                                <div class="embed-responsive embed-responsive-16by9 my-4 shadow-bottom">

                                    
                                    
                                    <input type="hidden" id="latitude" value="<?php echo e($branch->latitude); ?>" />
                                    <input type="hidden" id="longitude" value="<?php echo e($branch->longitude); ?>" />
                                    <input type="hidden" id="branch_name" value="<?php echo e($branch->name); ?>" />
                                    <div id="map" class="embed-responsive-item"></div>
                                </div>

                            </div>


                        </div><!-- .tab-pane -->

                        <div class="tab-pane fade"
                             id="features"
                             role="tabpanel"
                             aria-labelledby="features-tab">

                            <div class="row">


                                <?php if(count($branch->options) > 0): ?>
                                    <?php $__currentLoopData = $branch->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-12 col-lg-3 mt-4">
                                            <div class="rounded-lg shadow-around bg-white text-center py-3 font-body-md">
                                                <img src="<?php echo e($option->option_image_url); ?>"
                                                     class="img-fluid d-inline mx-auto">
                                                <p  class="pt-3 mb-1"><?php echo e($option->option_name); ?></p>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>

                                    <p class="mt-4">قائمة المميزات فارغة</p>

                                <?php endif; ?>
                            </div>

                        </div><!-- .tab-pane -->

                        <div class="tab-pane fade"
                             id="reservations"
                             role="tabpanel"
                             aria-labelledby="reservations-tab">

                            <div class="row">
                                <?php if($branch->has_booking): ?>

                                    <?php if($branch->booking_status == 0 || $branch->booking_status == 2): ?>
                                        <div class="col-12 col-lg-4 mt-4">
                                            <div class="rounded-lg shadow-around bg-white text-center  font-body-md">
                                                <a href="<?php echo e(url("/user/reservations/add-reservation/" . $branch->id ."/0")); ?>"
                                                   class="text-center no-decoration text-secondary p-4 d-block">
                                                    <img src="<?php echo e(url('/assets/site/img/reservations-menu/-e-persons-icon.svg')); ?>"
                                                         class="img-fluid d-block mx-auto"
                                                         alt="">
                                                    <h5 class="item-tile font-size-base font-body-bold mt-4">
                                                        أفراد
                                                    </h5>
                                                </a>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($branch->booking_status == 1 || $branch->booking_status == 2): ?>
                                        <div class="col-12 col-lg-4 mt-4">
                                            <div class="rounded-lg shadow-around bg-white text-center font-body-md">
                                                <a href="<?php echo e(url("/user/reservations/add-reservation/". $branch->id ."/1")); ?>"
                                                   class="text-center no-decoration text-secondary p-4 d-block">
                                                    <img src="<?php echo e(url('/assets/site/img/reservations-menu/-e-families-icon.svg')); ?>"
                                                         class="img-fluid d-block mx-auto"
                                                         alt="">
                                                    <h5 class="item-tile font-size-base font-body-bold mt-4">
                                                        عائلات
                                                    </h5>
                                                </a>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                <?php else: ?>

                                    <div class="col-12 col-lg-4 mt-4">خدمة استقبال الحجوزات غير متوفرة فى هذا المطعم</div>

                                <?php endif; ?>
                            </div>

                        </div><!-- .tab-pane -->



                        <div class="tab-pane fade"
                             id="menu"
                             role="tabpanel"
                             aria-describedby="menu-tab">

                            <?php if(count($mealCategories) > 0): ?>
                                <?php $__currentLoopData = $mealCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="py-2 pr-3 rounded-lg mt-3 shadow-around bg-white">
                                        <h4 class="page-title font-body-bold"><?php echo e($c->cat_name); ?></h4>
                                    </div>

                                    <div class="row">
                                        <?php $__currentLoopData = $c->meals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $meal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="col-12 col-lg-6 mt-3">
                                                <div class="rounded-lg shadow-around bg-white py-2 font-body-md">

                                                    <div class="media align-items-lg-start align-items-center flex-column flex-lg-row">
                                                        <img class="ml-2 mr-2 rounded mb-lg-0 mb-3"
                                                             src="<?php echo e($meal->image_url); ?>"
                                                             draggable="false"
                                                             style="width:105px;height:105px"
                                                             alt="Generic placeholder image">

                                                        <div class="media-body">

                                                            <h5 class="mt-lg-3 mt-md-0 mt-xs-0 text-lg-right text-center font-body-md font-size-base">
                                                                <a href="<?php echo e(url('/meal-page/' . $meal->meal_id)); ?>">
                                                                    إ<?php echo e($meal->meal_name); ?>

                                                                </a>
                                                            </h5>

                                                            <p class="text-primary font-body-md mb-0 mt-2 mt-sm-0 text-lg-right text-md-center text-sm-center text-center">

                                                            <span class="d-block">
                                                                <?php echo e($meal->price); ?> ر.س
                                                            </span>

                                                            </p>
                                                        </div><!-- .media-body -->

                                                    </div><!-- .media -->

                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div> <!-- .row -->
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <?php else: ?>
                                <p class="mt-4">قائمة الوجبات فارغة</p>
                            <?php endif; ?>
                        </div><!-- .tab-pane -->


                        <div class="tab-pane fade"
                             id="comments"
                             role="tabpanel"
                             aria-describedby="comments-tab">

                            <?php if(auth('web')->user()): ?>
                                <a href="new-branch.html"
                                   class="btn btn-primary no-decoration mt-3 px-5"
                                   data-toggle="modal"
                                   data-target="#add-comment"
                                   aria-hidden="true"
                                >
                                    إضافة تعليق
                                </a>


                                <div class="modal fade mt-5"
                                     id="add-comment"
                                     tabindex="-1"
                                     role="dialog"
                                     aria-labelledby="exampleModalLabel"
                                     aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content py-1 ">
                                            <div class="modal-body pb-0">
                                                <form>

                                                    <p class="mb-1">
                                                        ما هو تقييمك للخدمة؟
                                                    </p>

                                                    <div class="text-lg-right  pb-1 rating-stars">


                                                        <ul id='service-stars'>

                                                            <?php if(!$branch->is_user_rate_branch): ?>

                                                                <li class='star' title='1' data-value='1'>
                                                                    <img src="<?php echo e(url("/assets/site/img/-e-rating-icon-ncolor.svg")); ?>"
                                                                         class="img-fluid d-inline mx-auto">
                                                                </li>
                                                                <li class='star' title='2' data-value='2'>
                                                                    <img src="<?php echo e(url("/assets/site/img/-e-rating-icon-ncolor.svg")); ?>"
                                                                         class="img-fluid d-inline mx-auto">
                                                                </li>
                                                                <li class='star' title='3' data-value='3'>
                                                                    <img src="<?php echo e(url("/assets/site/img/-e-rating-icon-ncolor.svg")); ?>"
                                                                         class="img-fluid d-inline mx-auto">
                                                                </li>
                                                                <li class='star' title='4' data-value='4'>
                                                                    <img src="<?php echo e(url("/assets/site/img/-e-rating-icon-ncolor.svg")); ?>"
                                                                         class="img-fluid d-inline mx-auto">
                                                                </li>
                                                                <li class='star' title='5' data-value='5'>
                                                                    <img src="<?php echo e(url("/assets/site/img/-e-rating-icon-ncolor.svg")); ?>"
                                                                         class="img-fluid d-inline mx-auto">
                                                                </li>

                                                            <?php else: ?>



                                                                <?php
                                                                    $count = 0;
                                                                ?>

                                                                <?php for($i = 1; $i <= (int)$branch->user_service_rate; $i++): ?>
                                                                    <li class='star' title='<?php echo e($i); ?>' data-value='<?php echo e($i); ?>'>
                                                                        <img src="<?php echo e(url("/assets/site/img/-e-rating-icon.svg")); ?>"
                                                                             class="img-fluid d-inline mx-auto">
                                                                    </li>

                                                                    <?php
                                                                        $count++
                                                                    ?>
                                                                <?php endfor; ?>

                                                                <?php if($count < 5): ?>
                                                                    <?php for($i = $count+1; $i <= 5; $i++): ?>
                                                                        <li class='star' title="<?php echo e($i); ?>" data-value='<?php echo e($i); ?>'>
                                                                            <img src="<?php echo e(url("/assets/site/img/-e-rating-icon-ncolor.svg")); ?>"
                                                                                 class="img-fluid d-inline mx-auto">
                                                                        </li>
                                                                    <?php endfor; ?>
                                                                <?php endif; ?>


                                                            <?php endif; ?>
                                                        </ul>

                                                    </div>

                                                    <p class="mb-1">
                                                        ما هو تقييمك للنظافة؟
                                                    </p>

                                                    <div class="text-lg-right  pb-1 rating-stars">


                                                        <ul id='cleanliness-stars'>

                                                            <?php if(!$branch->is_user_rate_branch): ?>

                                                                <li class='star' title='1' data-value='1'>
                                                                    <img src="<?php echo e(url("/assets/site/img/-e-rating-icon-ncolor.svg")); ?>"
                                                                         class="img-fluid d-inline mx-auto">
                                                                </li>
                                                                <li class='star' title='2' data-value='2'>
                                                                    <img src="<?php echo e(url("/assets/site/img/-e-rating-icon-ncolor.svg")); ?>"
                                                                         class="img-fluid d-inline mx-auto">
                                                                </li>
                                                                <li class='star' title='3' data-value='3'>
                                                                    <img src="<?php echo e(url("/assets/site/img/-e-rating-icon-ncolor.svg")); ?>"
                                                                         class="img-fluid d-inline mx-auto">
                                                                </li>
                                                                <li class='star' title='4' data-value='4'>
                                                                    <img src="<?php echo e(url("/assets/site/img/-e-rating-icon-ncolor.svg")); ?>"
                                                                         class="img-fluid d-inline mx-auto">
                                                                </li>
                                                                <li class='star' title='5' data-value='5'>
                                                                    <img src="<?php echo e(url("/assets/site/img/-e-rating-icon-ncolor.svg")); ?>"
                                                                         class="img-fluid d-inline mx-auto">
                                                                </li>

                                                            <?php else: ?>



                                                                <?php
                                                                    $count = 0;
                                                                ?>

                                                                <?php for($i = 1; $i <= (int)$branch->user_cleanliness_rate; $i++): ?>
                                                                    <li class='star' title='<?php echo e($i); ?>' data-value='<?php echo e($i); ?>'>
                                                                        <img src="<?php echo e(url("/assets/site/img/-e-rating-icon.svg")); ?>"
                                                                             class="img-fluid d-inline mx-auto">
                                                                    </li>

                                                                    <?php
                                                                        $count++
                                                                    ?>
                                                                <?php endfor; ?>

                                                                <?php if($count < 5): ?>
                                                                    <?php for($i = $count+1; $i <= 5; $i++): ?>
                                                                        <li class='star' title="<?php echo e($i); ?>" data-value='<?php echo e($i); ?>'>
                                                                            <img src="<?php echo e(url("/assets/site/img/-e-rating-icon-ncolor.svg")); ?>"
                                                                                 class="img-fluid d-inline mx-auto">
                                                                        </li>
                                                                    <?php endfor; ?>
                                                                <?php endif; ?>


                                                            <?php endif; ?>
                                                        </ul>

                                                    </div>

                                                    <p class="mb-1">
                                                        ما هو تقييمك للجودة؟
                                                    </p>

                                                    <div class="text-lg-right  pb-1 rating-stars">


                                                        <ul id='quality-stars'>

                                                            <?php if(!$branch->is_user_rate_branch): ?>

                                                                <li class='star' title='1' data-value='1'>
                                                                    <img src="<?php echo e(url("/assets/site/img/-e-rating-icon-ncolor.svg")); ?>"
                                                                         class="img-fluid d-inline mx-auto">
                                                                </li>
                                                                <li class='star' title='2' data-value='2'>
                                                                    <img src="<?php echo e(url("/assets/site/img/-e-rating-icon-ncolor.svg")); ?>"
                                                                         class="img-fluid d-inline mx-auto">
                                                                </li>
                                                                <li class='star' title='3' data-value='3'>
                                                                    <img src="<?php echo e(url("/assets/site/img/-e-rating-icon-ncolor.svg")); ?>"
                                                                         class="img-fluid d-inline mx-auto">
                                                                </li>
                                                                <li class='star' title='4' data-value='4'>
                                                                    <img src="<?php echo e(url("/assets/site/img/-e-rating-icon-ncolor.svg")); ?>"
                                                                         class="img-fluid d-inline mx-auto">
                                                                </li>
                                                                <li class='star' title='5' data-value='5'>
                                                                    <img src="<?php echo e(url("/assets/site/img/-e-rating-icon-ncolor.svg")); ?>"
                                                                         class="img-fluid d-inline mx-auto">
                                                                </li>

                                                            <?php else: ?>



                                                                <?php
                                                                    $count = 0;
                                                                ?>

                                                                <?php for($i = 1; $i <= (int)$branch->user_quality_rate; $i++): ?>
                                                                    <li class='star' title='<?php echo e($i); ?>' data-value='<?php echo e($i); ?>'>
                                                                        <img src="<?php echo e(url("/assets/site/img/-e-rating-icon.svg")); ?>"
                                                                             class="img-fluid d-inline mx-auto">
                                                                    </li>

                                                                    <?php
                                                                        $count++
                                                                    ?>
                                                                <?php endfor; ?>

                                                                <?php if($count < 5): ?>
                                                                    <?php for($i = $count+1; $i <= 5; $i++): ?>
                                                                        <li class='star' title="<?php echo e($i); ?>" data-value='<?php echo e($i); ?>'>
                                                                            <img src="<?php echo e(url("/assets/site/img/-e-rating-icon-ncolor.svg")); ?>"
                                                                                 class="img-fluid d-inline mx-auto">
                                                                        </li>
                                                                    <?php endfor; ?>
                                                                <?php endif; ?>


                                                            <?php endif; ?>
                                                        </ul>

                                                    </div>
                                                    <div class="form-group">
                                                        <label for="message-text" class="col-form-label">أضف تعليقك</label>
                                                        <input type="hidden" id="branch_id" value="<?php echo e($branch->id); ?>" />
                                                        <input type="hidden" id="is_user_rate" value="<?php echo e($branch->is_user_rate_branch); ?>" />
                                                        <input type="hidden" id="is_user_can_rate" value="<?php echo e($branch->is_user_can_rate); ?>" />
                                                        <input type="hidden" id="user_comment_url" value="<?php echo e(url("/user/add-comment")); ?>" />
                                                        <textarea id="comment-text" required class="form-control" id="message-text" cols="8" rows="5"></textarea>
                                                    </div>
                                                </form>
                                            </div>

                                            <div class="modal-footer border-0  pt-0">
                                                <button type="submit" id="add-comment-btn" class="btn btn-primary btn btn-primary px-4 px-sm-5 font-weight-bold">إضافة</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="comment-cell hidden-element">

                                    <div class="rounded-lg shadow-around bg-white py-2 font-body-md my-3">
                                        <div class="media align-items-lg-start align-items-center flex-column flex-lg-row">
                                            <img class="rounded-circle mb-lg-0 mb-3 ml-3 mt-2 mr-3"
                                                 src="<?php echo e(\App\Http\Controllers\User\ProfileController::get_image()); ?>"
                                                 draggable="false"
                                                 style="width:90px;height:90px"
                                                 alt="Generic placeholder image">

                                            <div class="media-body">

                                                <h5 class="mt-lg-2 mt-md-0 mt-xs-0 text-lg-right text-center font-body-md font-size-base">
                                                    <?php echo e(auth('web')->user()->name); ?>

                                                </h5>

                                                <p class="text-gray font-body-md pl-3 pr-3 pr-lg-0 pb-3 mb-0 mt-2 mt-sm-0 text-lg-right text-md-center text-sm-center text-center font-size-base">

                                                            <span class="comment-cell-text d-block">
                                                                <!-- comment text -->
                                                            </span>
                                                </p>
                                            </div><!-- .media-body -->
                                        </div><!-- .media -->
                                    </div>

                                </div>
                            <?php endif; ?>
                            <?php if(count($comments) > 0): ?>
                                <div class="comment-container">
                                    <?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="rounded-lg shadow-around bg-white py-2 font-body-md my-3">
                                            <div class="media align-items-lg-start align-items-center flex-column flex-lg-row">
                                                <img class="rounded-circle mb-lg-0 mb-3 ml-3 mt-2 mr-3"
                                                     src="<?php echo e(($comment->user_image_url == null) ? url('/storage/app/public/users/avatar.png') : $comment->user_image_url); ?>"
                                                     draggable="false"
                                                     style="width:90px;height:90px"
                                                     alt="Generic placeholder image">

                                                <div class="media-body">

                                                    <h5 class="mt-lg-2 mt-md-0 mt-xs-0 text-lg-right text-center font-body-md font-size-base">
                                                        <?php echo e($comment->username); ?>

                                                    </h5>

                                                    <p class="text-gray font-body-md pl-3 pr-3 pr-lg-0 pb-3 mb-0 mt-2 mt-sm-0 text-lg-right text-md-center text-sm-center text-center font-size-base">

                                                            <span class="d-block">
                                                                <?php echo e($comment->comment); ?>

                                                            </span>
                                                    </p>
                                                </div><!-- .media-body -->
                                            </div><!-- .media -->
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php else: ?>
                                <p class='mt-4'>لا توجد تعليقات حتى الان</p>
                            <?php endif; ?>

                        </div><!-- .tab-pane -->

                    </div><!-- .tab-content -->

                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection("script"); ?>

   
    <script>
        
      

    var baseUrl = $('meta[name="base-url"]').attr('content');
    var rateStare = baseUrl + "/assets/site/img/-e-rating-icon.svg";
    var rateNoColor = baseUrl + "/assets/site/img/-e-rating-icon-ncolor.svg"

    var service = 0;
    var quality = 0;
    var cleanliness =0;
    /* 1. Visualizing things on Hover - See next part for action on click */

  

    /* 2. Action to perform on click */
    $('#cleanliness-stars li, #service-stars li, #quality-stars li').on('click', function(){

        var rate = $("#is_user_rate").val();
        var canRate = $("#is_user_can_rate").val();
        if(canRate == false) {
            return false;
        }

        var onStar = parseInt($(this).data('value'), 10); // The star currently selected
        var stars = $(this).parent().children('li.star');

        if($(this).parent().attr("id") == "cleanliness-stars"){
            cleanliness = onStar;
        }

        if($(this).parent().attr("id") == "service-stars"){
            service = onStar;
        }

        if($(this).parent().attr("id") == "quality-stars"){
            quality = onStar;
        }


        for (i = 0; i < stars.length; i++) {
            $(stars[i]).find(".img-fluid").attr("src", rateNoColor);//removeClass('selected');
        }

        for (i = 0; i < onStar; i++) {
            $(stars[i]).find(".img-fluid").attr("src", rateStare);//.addClass('selected');
        }

    });

    $("#add-comment-btn").on("click", function(){

        var comment = $("#comment-text").val();
        var branch_id = $("#branch_id").val();
        if(comment == ""){
            notif({
                msg: "برجاء كتابة نص التعليق",
                type: "warning"
            });
            return false;
        }

        var data = new FormData();

        data.append("cleanliness", cleanliness);
        data.append("service", service);
        data.append("quality", quality);
        data.append("id", branch_id);
        data.append("comment", comment);
        // send request
        var url = $("#user_comment_url").val();

        request(url, "POST", data, function(){}, function(data){

            $(".comment-cell").find(".comment-cell-text").html(comment);
            $(".comment-container").prepend($(".comment-cell").html());
            $("#comment-text").val("");
            $("#comment-text").blur();
            notif({
                msg: "تمت العملية بنجاح",
                type: "success"
            });

        },function (error) {

        })
    });

 
    var map, infoWindow , marker;
    var messagewindow;
    var markers = [];

 
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: parseFloat($("#latitude").val()), lng: parseFloat($("#longitude").val())},
            zoom: 10
        });

        infoWindow = new google.maps.InfoWindow;

        addMarker( "(" + parseFloat($('#latitude').val()) + "," + parseFloat($('#longitude').val()) +")");

        function addMarker(location) {
            // var marker = new google.maps.Marker({
            //     position: location,
            //     map: map
            // });

            var marker = new google.maps.Marker({
                position: new google.maps.LatLng( parseFloat($("#latitude").val()),parseFloat($("#longitude").val())),
                map: map,
                title: $("#branch_name").val()
            });

            var contentString = '<div id="content" style="width: 200px; height: 200px;"><h1>Overlay</h1></div>';
            var infowindow = new google.maps.InfoWindow({
                content: contentString
            });

            google.maps.event.addListener(marker, 'click', function() {
                infowindow.open(map,marker);
            });

            // To add the marker to the map, call setMap();
            marker.setMap(map);

        }




    }

    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
            'Error: The Geolocation service failed.' :
            'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(map);
    }

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
    
  
    
         
    </script>
    
       <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDKZAuxH9xTzD2DLY2nKSPKrgRi2_y0ejs&callback=initMap">
    </script>
    

<?php $__env->stopSection(); ?>
<?php echo $__env->make('Site.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>