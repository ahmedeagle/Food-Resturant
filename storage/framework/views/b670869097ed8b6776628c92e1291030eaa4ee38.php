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
                        <h4 class="page-title">الطلبات</h4>
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

                    <div class="py-3 rounded-lg shadow-around my-4">

                        <div class="row align-items-center flex-column flex-lg-row px-3 px-lg-0">
                            <div class="col-lg-2 col-12">
                                <img class="rounded-circle mb-lg-0 mb-3 d-block mx-auto img-fluid"
                                     src="<?php echo e(($orderDetails->user_image_url) ? $orderDetails->user_image_url : url("/storage/app/public/users/avatar.png")); ?>"
                                     style="width:90px;height:90px"
                                     alt="Generic placeholder image">
                            </div>

                            <div class="col-xl-7 col-lg-6 col-12 pr-lg-0">
                                <h5 class="mt-0 text-lg-right text-center font-body-bold font-size-base">
                                    <?php echo e($orderDetails->username); ?>

                                </h5>

                                <p class="text-gray font-body-md mb-0">
                                    <span class="d-block">
                                        رقم الطلب: <span class="orders-number"><?php echo e($orderDetails->order_code); ?></span>
                                    </span>
                                    <span class="d-block">
                                        <span class="orders-date">
                                            الوقت والتاريخ:
                                            <time datetime="2018-10-25 17:30">
                                                <?php echo e($orderDetails->order_date); ?> - <?php echo e($orderDetails->time_extention); ?> <?php echo e($orderDetails->order_time); ?>

                                            </time>
                                        </span>
                                    </span>
                                    <span class="d-block">
                                        طريقة الدفع:  <span class="orders-payment"><?php echo e($orderDetails->payment_name); ?></span>
                                    </span>
                                    <span class="d-block">
                                        العنوان:
                                        <span class="orders-address">
                                          <?php echo e($orderDetails -> address); ?>

                                        </span>
                                    </span>
                                </p>

                            </div><!-- .media-body -->
                            <div class="col-xl-3 col-lg-4 col-auto mt-3 mt-lg-0 font-body-md text-lg-center">
                                <span class="py-2 bg-success text-white d-lg-inline d-block px-3 rounded-curved">
                                    <?php echo e($orderDetails->status_name); ?>

                                </span>
                            </div>
                        </div>

                        <div class="col-12">
                            <hr class="border-light border">
                        </div>

                        <div class="row px-3 px-lg-0">
                            <div class="col-lg-8 col-12 pr-lg-0 mx-auto">
                                <h6 class="font-size-base text-lg-right text-center">
                                    التفاصيل
                                </h6>


                                <?php
                                    $sum = 0;
                                ?>
                                <?php $__currentLoopData = $meals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $meal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <div class="item d-flex justify-content-between font-body-md text-gray">
                                        <div class="item-details">
                                            <p class="item-head mb-auto"><?php echo e($meal->meal_name); ?></p>
                                            <div class="item-body d-flex flex-row">
                                                <span class="price"><?php echo e($meal->meal_price); ?></span>
                                                &times;
                                                <span class="count"><?php echo e($meal->meal_qty); ?></span>
                                                &nbsp;
                                                <span class="currency">ر.س</span>
                                            </div>

                                            <!-- start meal options -->
                                            <?php
                                                $options_sum = 0;
                                            ?>
                                            <?php if(count($meal->options) > 0): ?>
                                                <p class="item-head mb-auto">التفضيلات</p>
                                                <?php $__currentLoopData = $meal->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                    <div class="item-body d-flex flex-row">
                                                        <span class="price"><?php echo e($option->option_name); ?></span>
                                                        : السعر المضاف
                                                        <span class="count"> <?php echo e($option->added_price); ?> </span>
                                                        &nbsp;
                                                        <span class="currency"> ر.س </span>
                                                    </div>
                                                    <?php
                                                        $options_sum  = $options_sum + $option->added_price;
                                                    ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            <?php endif; ?>
                                            <!-- end meal options -->

                                            <!-- start meal adds -->
                                            <?php
                                                $adds_sum = 0;
                                            ?>
                                            <?php if(count($meal->adds) > 0): ?>
                                                <p class="item-head mb-auto">الإضافات</p>
                                                <?php $__currentLoopData = $meal->adds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $add): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                    <div class="item-body d-flex flex-row">
                                                        <span class="price"><?php echo e($add->add_name); ?></span>
                                                        : السعر المضاف
                                                        <span class="count"> <?php echo e($add->added_price); ?> </span>
                                                        &nbsp;
                                                        <span class="currency"> ر.س </span>
                                                    </div>
                                                <?php
                                                    $adds_sum  = $adds_sum + $add->added_price;
                                                ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            <?php endif; ?>
                                            <!-- end meal adds -->
                                        </div>
                                        <div class="result text-primary">
                                            <span class="total"><?php echo e(( ( (int)$meal->meal_price + $options_sum + $adds_sum ) * ( (int)$meal->meal_qty ) )); ?></span>
                                            <span class="currency">ر.س</span>
                                        </div>
                                    </div><!-- .item -->
                                    <hr class="border-light border">
                                    <?php
                                        $sum = $sum + ( ( (int)$meal->meal_price + $options_sum + $adds_sum ) * ( (int)$meal->meal_qty ) );
                                    ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                <div class="invoice d-flex justify-content-between mt-3">
                                    <h6 class="font-size-base">المجموع</h6>
                                    <div class="result text-primary font-body-md">
                                        <span class="total"><?php echo e($sum); ?></span>
                                        <span class="currency">ر.س</span>
                                    </div>
                                </div>
                                
                                  <?php
                                             $taxData = DB::table("app_settings")
                                            ->first();
                                
                                         $orderTax = $taxData->order_tax;
                                        
                                    ?>   
                                  
        
                                <div class="invoice d-flex justify-content-between mt-3">
                                    <h6 class="font-size-base">الضريبة </h6>
                                    <div class="result text-primary font-body-md">
                                        <span class="total"><?php echo e(($sum * $orderTax ) / 100); ?></span>
                                        <span class="currency">ر.س</span>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-12">
                            <hr class="border-light border">
                        </div>

                        <div class="row px-3 px-lg-0">
                            <div class="col-lg-8 col-12 pr-lg-0 mx-auto">
                                <div class="order-confirm text-center text-sm-right">
                                    <a href="<?php echo e(url("/restaurant/orders/finish-order/" . $orderDetails->order_id)); ?>" class="btn btn-primary px-xl-5 px-md-3 px-sm-5 px-5 mt-2"
                                    >
                                        إكمال الطلب
                                    </a>

                                </div>
                            </div>
                        </div>


                    </div>

                    <a href="<?php echo e(url("/restaurant/orders/list/1")); ?>" class="btn btn-primary px-5">العودة</a>

                </div><!-- .col-* -->
            </div><!-- .row -->

        </div><!-- .container -->
    </main><!-- .page-content -->

<?php $__env->stopSection(); ?>
<?php echo $__env->make("Provider.layouts.master", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>