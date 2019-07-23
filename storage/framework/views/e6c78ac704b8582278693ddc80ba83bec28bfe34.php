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

                <div class="col-lg-9 col-md-8 col-12 mt-4 mt-md-0 font-body-bold">
                    <div class="py-2 pr-3 rounded-lg shadow-around">
                        <h4 class="page-title"><?php echo e(trans('site.reservations')); ?></h4>
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
                                    <?php echo e(trans('site.current_reservations')); ?>

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
                                    <?php echo e(trans('site.previous_reservations')); ?>

                                </a>
                            </li><!-- .nav-item -->

                        </ul><!-- .nav-tabs -->
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        

                        
                    </div>
                    <div class="tab-content">

                        <div class="tab-pane fade show active"
                             id="current"
                             role="tabpanel"
                             aria-describedby="current-tab">


                            <?php $__currentLoopData = $currentReservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <div class="p-3 rounded-lg shadow-around mt-4">

                                        <div class="media align-items-center flex-column flex-lg-row">
                                            <img class="ml-3 rounded-circle mb-lg-0 mb-3"
                                                 style="width:70px;height:70px"
                                                 src="<?php echo e(($reservation->user_image_url == null) ? url("/storage/app/public/users/avatar.png") : $reservation->user_image_url); ?>"
                                                 alt="Generic placeholder image">

                                            <div class="media-body">
                                                <h5 class="mt-0 text-lg-right text-center font-body-bold font-size-base">
                                                    <?php echo e($reservation->username); ?>

                                                </h5>
                                                <p class="text-gray font-body-md mb-0">
                                            <span class="d-block d-lg-inline">
                                                <?php echo e(trans('site.reservation_num')); ?> <span class="reservation-number"><?php echo e($reservation->reservation_code); ?></span>
                                            </span>
                                                    <span class="d-block d-lg-inline">
                                                <span class="d-none d-lg-inline">|</span>
                                                 <?php echo e(trans('site.person_num')); ?><span class="reservation-person"><?php echo e($reservation->seats_number); ?></span>
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


                                            <?php $__env->startComponent('User.pages.reservation.reservation-status'); ?>
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

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <?php echo e($currentReservations->links("Pagination.pagination")); ?>


                        </div><!-- .tab-pane -->

                        <div class="tab-pane fade"
                             id="prev"
                             role="tabpanel"
                             aria-labelledby="prev-tab">


                            <?php $__currentLoopData = $previousReservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <div class="p-3 rounded-lg shadow-around mt-4">

                                        <div class="media align-items-center flex-column flex-lg-row">
                                            <img class="ml-3 rounded-circle mb-lg-0 mb-3"
                                                 style="width:70px;height:70px"
                                                 src="<?php echo e(($reservation->user_image_url == null) ? url("/storage/app/public/users/avatar.png") : $reservation->user_image_url); ?>"
                                                 alt="Generic placeholder image">

                                            <div class="media-body">
                                                <h5 class="mt-0 text-lg-right text-center font-body-bold font-size-base">
                                                    <?php echo e($reservation->username); ?>

                                                </h5>
                                                <p class="text-gray font-body-md mb-0">
                                            <span class="d-block d-lg-inline">
                                                <?php echo e(trans('site.reservation_num')); ?><span class="reservation-number"><?php echo e($reservation->reservation_code); ?></span>
                                            </span>
                                                    <span class="d-block d-lg-inline">
                                                <span class="d-none d-lg-inline">|</span>
                                                <?php echo e(trans('site.person_num')); ?> <span class="reservation-person"><?php echo e($reservation->seats_number); ?></span>
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


                                            <?php $__env->startComponent('User.pages.reservation.reservation-status'); ?>
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

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <?php echo e($previousReservations->links("Pagination.pagination")); ?>

                        </div><!-- .tab-pane -->
                        
                             
                             
                             
                            
                        
                        
                             
                             
                             
                            
                        

                    </div><!-- .tab-content -->

                </div><!-- .col-* -->
            </div><!-- .row -->

        </div><!-- .container -->
    </main><!-- .page-content -->

<?php $__env->stopSection(); ?>




<?php echo $__env->make("User.layouts.master", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>