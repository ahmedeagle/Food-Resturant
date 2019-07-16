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

                <?php if(auth()->check()): ?>
                    <?php echo $__env->make("User.includes.menu", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php endif; ?>

                <div class="<?php if(auth()->check()): ?> col-lg-9 col-md-8 <?php else: ?> col-lg-12 col-md-11 <?php endif; ?> col-12 mt-4 mt-md-0 ">
                    <div class="section-header d-flex p-3 rounded-lg bg-white shadow-around justify-content-between font-body-bold flex-lg-row flex-md-column flex-sm-row flex-column">

                        <h4 class="page-title mb-auto"><?php echo e($cat_name); ?></h4>

                        
                        
                              
                              
                              
                            
                        
                            
                                
                                   
                                
                                   
                                
                                   
                                
                                   
                            
                        

                    </div><!-- .section-header -->


                    <div class="row">






                        <?php if(count($providers) > 0): ?>

                            <?php $__currentLoopData = $providers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $provider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <div class="col-12 col-lg-4 mt-4">

                                    <div style="height: 100%;" class="rounded-lg shadow-around bg-white text-center py-3">

                                        <img class="rounded-circle mb-lg-0 mb-3"
                                             src="<?php echo e($provider->image_url); ?>"
                                             style="width:90px;height:90px"
                                             alt="Generic placeholder image">


                                        <p class="my-1 font-body-bold"><a href="<?php echo e(url("/restaurant-page/" . $provider-> id)); ?>"><?php echo e($provider->name); ?></a></p>

                                        <div>

                                            <?php
                                                $count = 0;
                                            ?>
                                            <?php for($i = 1; $i <= (int)$provider->averageRate; $i++): ?>
                                                <img src="<?php echo e(url("/assets/site/img/-e-rating-icon.svg")); ?>"
                                                     class="img-fluid d-inline mx-auto">

                                                <?php
                                                    $count++
                                                ?>
                                            <?php endfor; ?>
                                            <?php if($count < 5): ?>
                                                <?php for($i = $count+1; $i <= 5; $i++): ?>
                                                    <img src="<?php echo e(url("/assets/site/img/-e-rating-icon-ncolor.svg")); ?>"
                                                         class="img-fluid d-inline mx-auto">
                                                <?php endfor; ?>
                                            <?php endif; ?>


                                        </div>
                                        <div>

                                            <?php if($provider->has_booking == "1"): ?>
                                                <img src="<?php echo e(url("/assets/site/img/-e-reserved-icon.svg")); ?>"
                                                     class="img-fluid d-inline mx-auto my-2">
                                            <?php endif; ?>

                                            <?php if($provider->has_delivery == "1"): ?>
                                                <img src="<?php echo e(url("/assets/site/img/-e-delivery-icon.svg")); ?>"
                                                     class="img-fluid d-inline mx-auto my-2 pr-2">
                                            <?php endif; ?>

                                        </div>
                                        <div>
                                            <img src="<?php echo e(url("/assets/site/img/-e-money-icon.svg")); ?>"
                                                 class="img-fluid d-inline mx-auto my-2 pr-2">
                                            <span class="font-body-md"><?php echo e($provider->mealAveragePrice); ?> ر.س</span>

                                            
                                            
                                            
                                        </div>

                                    </div>
                                </div>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <?php else: ?>

                            <p class="mt-4">قائمة المطاعم فارغة</p>

                        <?php endif; ?>


                    </div>




                    
                        
                            
                                
                                   
                            
                            
                                
                                   
                            
                            
                                
                                   
                            
                            
                            
                                
                                   
                            
                        
                    

                </div><!-- .col-* -->

            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('Site.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>