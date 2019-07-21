<main class="page-content py-5">
    <div class="container">

        <div class="row">

            <?php echo $__env->make("Provider.pages.menu", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <div class="col-lg-9 col-md-8 col-12 mt-4 mt-md-0 font-body-bold">

                <div class="orders-section">

                    <div class="section-header d-flex p-3 rounded-lg shadow-around justify-content-between flex-lg-row flex-md-column flex-sm-row flex-column">

                        <h4 class="page-title mb-auto">الطلبات</h4>

                        
                            
                                  
                                  
                                  
                                
                            
                            
                                
                                   
                                
                                   
                                
                                   
                            

                        

                    </div><!-- .section-header -->

                    <div class="section-content">

                        <?php if(count($orders) > 0): ?>
                        <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <div class="p-3 rounded-lg shadow-around mt-4">

                                <div class="media align-items-center flex-column flex-lg-row">
                                    <img class="ml-3 rounded-circle mb-lg-0 mb-3"
                                         src="<?php echo e(($order->user_image_url) ? $order->user_image_url : url("/storage/app/public/users/avatar.png")); ?>"
                                         style="width:70px;height:70px"
                                         alt="Generic placeholder image">
                                    
                                    <div class="media-body">
                                        <h5 class="mt-0 text-lg-right text-center font-body-bold font-size-base">
                                            <?php echo e($order->username); ?>  - <?php echo e($order -> branch_name); ?>

                                        </h5>
                                        <p class="text-gray font-body-md mb-0">
                                            <span class="d-block d-lg-inline">
                                                رقم الطلب: <span class="order-number"><?php echo e($order->order_code); ?></span>
                                            </span>

                                            <span class="d-block d-lg-inline">
                                                <span class="d-none d-lg-inline">|</span>
                                                <span class="order-date">
                                                    <time><?php echo e($order->order_time); ?></time>
                                                    <?php echo e($order->time_extention); ?>

                                                </span>
                                            </span>

                                            <span class="d-block d-lg-inline">
                                                <span class="d-none d-lg-inline">-</span>
                                                <span class="order-price"><?php echo e($order->total_price); ?></span>ر.س
                                            </span>
                                        </p>
                                    </div><!-- .media-body -->
                                    <?php $__env->startComponent('Provider.includes.order-status'); ?>
                                        <?php $__env->slot('id'); ?>
                                            <?php echo e($order->order_id); ?>

                                        <?php $__env->endSlot(); ?>

                                        <?php $__env->slot('statusname'); ?>
                                            <?php echo e($order->status_name); ?>

                                        <?php $__env->endSlot(); ?>

                                        <?php echo e($order->status_id); ?>

                                    <?php echo $__env->renderComponent(); ?>
                                </div><!-- .media -->

                            </div>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <?php else: ?>
                            <div class="mt-4">
                                <?php echo e(trans("provider.empty-orders")); ?>

                            </div>
                        <?php endif; ?>


                        
                        <?php if(count($orders) > 0): ?>
                            <div class="mb-4 mt-5 text-center">
                                <a href="<?php echo e(url("/restaurant/orders/list/1")); ?>"
                                class="more-link font-body-bold btn px-5 btn-primary">المزيد</a>
                            </div>
                        <?php endif; ?>
                    </div><!-- .section-content -->

                </div><!-- .orders-section -->

                <div class="reservation-section mt-5">

                    <div class="section-header d-flex p-3 rounded-lg shadow-around justify-content-between flex-lg-row flex-md-column flex-sm-row flex-column">

                        <h4 class="page-title mb-auto">الحجوزات</h4>

                        
                            
                                  
                                  
                                  
                                
                            
                            
                                
                                   
                                
                                   
                                
                                   
                            

                        

                    </div><!-- .section-header -->

                    <div class="section-content">
                        <?php if(count($reservations) > 0): ?>
                        <?php $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <div class="p-3 rounded-lg shadow-around mt-4">

                                <div class="media align-items-center flex-column flex-lg-row">
                                    <img class="ml-3 rounded-circle mb-lg-0 mb-3"
                                         style="width:70px;height:70px"
                                         src="<?php echo e(($reservation->user_image_url) ? $reservation->user_image_url : url("/storage/app/public/users/avatar.png")); ?>"
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

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <div class="mt-4">
                                <?php echo e(trans("provider.empty-reservations")); ?>

                            </div>
                        <?php endif; ?>


                        
                        <?php if(count($reservations) > 0): ?>
                            <div class="mb-4 mt-5 text-center">
                                <a href="<?php echo e(url("/restaurant/reservations/list/1")); ?>"
                                class="more-link font-body-bold btn px-5 btn-primary">المزيد</a>
                            </div>
                        <?php endif; ?>
                    </div><!-- .section-content -->

                </div><!-- .reservation-section -->

            </div><!-- .col-* -->
        </div><!-- .row -->

    </div><!-- .container -->
</main><!-- .page-content -->