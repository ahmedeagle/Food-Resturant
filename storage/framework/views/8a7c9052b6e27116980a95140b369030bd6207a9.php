<?php $__env->startSection('title'); ?>
    <?php echo e($title); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('class'); ?>
    <?php echo e($class); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection("content"); ?>
    <main class="page-content py-5">
        <div class="container">

            <div class="row">

                <?php echo $__env->make("Provider.pages.menu", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                <div class="col-lg-9 col-md-8 col-12 mt-4 mt-md-0 font-body-bold">
                    <div class="py-2 pr-3 rounded-lg shadow-around">
                        <h4 class="page-title">الحجوزات</h4>
                    </div>
                    <div class="d-flex px-3 rounded-lg shadow-around mt-4 justify-content-between flex-lg-row flex-md-column flex-sm-row flex-column">
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
                                    الحجوزات الحالية
                                </a>
                            </li><!-- .nav-item -->

                            <li class="nav-item">
                                <a class="nav-link pb-3 font-body-bold"
                                   id="prev-tab"
                                   data-toggle="tab"
                                   href="#prev"
                                   role="tab"
                                   aria-controls="prev"
                                   aria-selected="false">
                                    الحجوزات السابقة
                                </a>
                            </li><!-- .nav-item -->

                        </ul><!-- .nav-tabs -->
                        
                            
                                  
                                  
                                  
                                
                            
                            
                                
                                   
                                
                                   
                                
                                   
                            

                        
                    </div>
                    <div class="tab-content">

                        <div class="tab-pane fade show active"
                             id="current"
                             role="tabpanel"
                             aria-describedby="current-tab">


                                <?php $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($reservation->status_id == "1" || $reservation->status_id == "2"): ?>
                                        <div class="p-3 rounded-lg shadow-around mt-4">

                                            <div class="media align-items-center flex-column flex-lg-row">
                                                <img class="ml-3 rounded-circle mb-lg-0 mb-3"
                                                     src="<?php echo e(($reservation->user_image_url) ? $reservation->user_image_url : url("/storage/app/public/users/avatar.png")); ?>"
                                                     style="width:70px;height:70px"
                                                     alt="Generic placeholder image">

                                                <div class="media-body">
                                                    <h5 class="mt-0 text-lg-right text-center font-body-bold font-size-base">
                                                        <?php echo e($reservation->username); ?> - <?php echo e($reservation -> branch_name); ?>

                                                    </h5>
                                                    <p class="text-gray font-body-md mb-0">
                                            <span class="d-block d-lg-inline">
                                                رقم الحجز: <span class="reservation-number"><?php echo e($reservation->reservation_code); ?></span>
                                            </span>
                                                        <span class="d-block d-lg-inline">
                                                <span class="d-none d-lg-inline">|</span>
                                                عدد الأشخاص: <span class="reservation-person"><?php echo e($reservation->seats_number); ?></span>
                                            </span>
                                                        <span class="d-block d-lg-inline">
                                                <span class="d-none d-lg-inline">|</span>
                                                <span class="reservation-date">
                                                    <time datetime="2018-10-25 17:30">
                                                        <?php echo e($reservation->reservation_time); ?> <?php echo e($reservation->time_extention); ?> - <?php echo e($reservation->reservation_date); ?>

                                                    </time>
                                                </span>
                                            </span>
                                                    </p>
                                                </div><!-- .media-body -->


                                                <?php $__env->startComponent('Provider.includes.reservation-status'); ?>
                                                    <?php $__env->slot('id'); ?>
                                                        <?php echo e($reservation->reservation_id); ?>

                                                    <?php $__env->endSlot(); ?>

                                                    <?php $__env->slot('statusname'); ?>
                                                        <?php echo e($reservation->status_name); ?>

                                                    <?php $__env->endSlot(); ?>

                                                    <?php echo e($reservation->status_id); ?>

                                                <?php echo $__env->renderComponent(); ?>

                                            </div><!-- .media -->

                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                        </div><!-- .tab-pane -->

                        <div class="tab-pane fade"
                             id="prev"
                             role="tabpanel"
                             aria-labelledby="prev-tab">


                            <?php $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($reservation->status_id == "3" || $reservation->status_id == "4"): ?>
                                <div class="p-3 rounded-lg shadow-around mt-4">

                                    <div class="media align-items-center flex-column flex-lg-row">
                                        <img class="ml-3 rounded-circle mb-lg-0 mb-3"
                                             src="<?php echo e(($reservation->user_image_url) ? $reservation->user_image_url : url("/storage/app/public/users/avatar.png")); ?>"
                                             style="width:70px;height:70px"
                                             alt="Generic placeholder image">

                                        <div class="media-body">
                                            <h5 class="mt-0 text-lg-right text-center font-body-bold font-size-base">
                                                <?php echo e($reservation->username); ?>

                                            </h5>
                                            <p class="text-gray font-body-md mb-0">
                                            <span class="d-block d-lg-inline">
                                                رقم الحجز: <span class="reservation-number"><?php echo e($reservation->reservation_code); ?></span>
                                            </span>
                                                <span class="d-block d-lg-inline">
                                                <span class="d-none d-lg-inline">|</span>
                                                عدد الأشخاص: <span class="reservation-person"><?php echo e($reservation->seats_number); ?></span>
                                            </span>
                                                <span class="d-block d-lg-inline">
                                                <span class="d-none d-lg-inline">|</span>
                                                <span class="reservation-date">
                                                    <time datetime="2018-10-25 17:30">
                                                        <?php echo e($reservation->reservation_time); ?> <?php echo e($reservation->time_extention); ?> - <?php echo e($reservation->reservation_date); ?>

                                                    </time>
                                                </span>
                                            </span>
                                            </p>
                                        </div><!-- .media-body -->


                                        <?php $__env->startComponent('Provider.includes.reservation-status'); ?>
                                            <?php $__env->slot('id'); ?>
                                                <?php echo e($reservation->reservation_id); ?>

                                            <?php $__env->endSlot(); ?>

                                            <?php $__env->slot('statusname'); ?>
                                                <?php echo e($reservation->status_name); ?>

                                            <?php $__env->endSlot(); ?>

                                            <?php echo e($reservation->status_id); ?>

                                        <?php echo $__env->renderComponent(); ?>

                                    </div><!-- .media -->

                                </div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                        </div><!-- .tab-pane -->

                        <?php echo e($reservations->links("Pagination.pagination")); ?>


                    </div><!-- .tab-content -->
                </div><!-- .col-* -->
            </div><!-- .row -->

        </div><!-- .container -->
    </main><!-- .page-content -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make("Provider.layouts.master", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>