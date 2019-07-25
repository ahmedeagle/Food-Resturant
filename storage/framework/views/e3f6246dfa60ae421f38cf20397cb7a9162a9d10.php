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
                    <h4 class="page-title"> <?php echo e(trans('site.reservations')); ?></h4>
                </div>


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

                <div class="p-3 rounded-lg shadow-around my-4">

                    <div class="media align-items-center flex-column flex-lg-row">
                        <img class="ml-3 rounded-circle mb-lg-0 mb-3"
                             src="<?php echo e(($reservationDetails->user_image_url == null) ? url("/storage/app/public/users/avatar.png") : $reservationDetails->user_image_url); ?>"
                             style="width:90px;height:90px"
                             alt="Generic placeholder image">

                        <div class="media-body">

                            <h5 class="mt-0 text-lg-right text-center font-body-bold font-size-base">
                                <?php echo e($reservationDetails->username); ?>

                            </h5>

                            <p class="text-gray font-body-md mb-0">
                                    <span class="d-block">
                                            <?php echo e(trans('site.reservation_num')); ?>: <span class="reservation-number"><?php echo e($reservationDetails->reservation_code); ?></span>
                                    </span>
                                <span class="d-block">
                                        <?php echo e(trans('site.person_num')); ?>: <span class="reservation-person"><?php echo e($reservationDetails->seats_number); ?></span>
                                    </span>
                                <span class="d-block">
                                        <span class="reservation-date">
                                           <?php echo e(trans('site.time_date')); ?>

                                            <time datetime="2018-10-25 17:30">
                                             <?php echo e($reservationDetails->reservation_time); ?> <?php echo e($reservationDetails->time_extention); ?> - <?php echo e($reservationDetails->reservation_date); ?>

                                            </time>
                                        </span>
                                    </span>
                            </p>

                           
                            <?php if(!empty($reservationDetails -> special_reservation) && $reservationDetails -> special_reservation !=null ): ?>
                                <p>                                    
                                        <?php echo e(trans('site.occasion_description')); ?> <br>

                                     
                                </p>

                                 <span class="text-gray font-body-md mb-0">  
                                      <?php echo e($reservationDetails -> occasion_description); ?>

                                  </span>
                            <?php endif; ?>

                        </div><!-- .media-body -->
                        <span class="py-2 bg-danger text-white mt-3 mt-lg-0 text-white font-body-md px-3 rounded-curved">
                                <?php echo e($reservationDetails->status_name); ?>

                            </span>
                    </div><!-- .media -->

                </div>

                <a href="<?php echo e(url("/restaurant/reservations/list/1")); ?>" class="btn btn-primary px-5"> <?php echo e(trans('site.back')); ?> <br></a>

            </div><!-- .col-* -->
        </div><!-- .row -->

    </div><!-- .container -->
</main><!-- .page-content -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make("Provider.layouts.master", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>