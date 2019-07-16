<header class="site-header shadow-bottom py-lg-0 py-3">
    <div class="container">
        <nav class="navbar font-body-bold px-0 flex-sm-row justify-content-sm-between flex-column justify-content-center">
            <a href="<?php echo e(url("/restaurant/dashboard")); ?>" class="navbar-brand site-logo mr-0">
                <img src="<?php echo e(url('assets/site/img/logo.png')); ?>"
                     width="115"
                     height="56"
                     alt="Site Logo">
            </a><!-- .site-logo -->
            <?php if(auth("provider")->check()): ?>
                <div class="d-flex flex-wrap align-items-center">
                    <a href="<?php echo e(url("/restaurant/balance")); ?>" class="d-flex flex-wrap ml-3 justify-content-sm-center mt-sm-0 mt-3">
                        <img src="<?php echo e(url("/assets/site/img/-e-wallet-icon.svg")); ?>" class="ml-2" width="25"
                             height="25">
                        <h2 class="font-size-base font-body-md ml-2 mb-1"><?php echo e(\App\Http\Controllers\Provider\HelperController::get_provider_balance(auth("provider")->id())); ?> ر.س</h2>
                    </a>
                    <a href="<?php echo e(url("/restaurant/profile")); ?>" class="restaurant-logo no-decoration text-secondary d-flex flex-wrap align-items-center mt-3 mt-sm-auto">
                        <h2 class="restaurant-title font-size-base ml-2 mb-1"><?php echo e(auth("provider")->user()->ar_name); ?></h2>
                        <img src="<?php echo e(url("/storage/app/public/providers/" . \App\Http\Controllers\Provider\HelperController::get_provider_image_path2(auth("provider")->id(),'providers'))); ?>"
                             class="rounded-circle bg-medium"
                             style="width:60px;height:60px"
                             alt="Restaurant Logo">
                    </a>
                </div>
            <?php else: ?>

                <a class="restaurant-logo no-decoration text-secondary d-flex flex-wrap align-items-center mt-3 mt-sm-auto">
                    <h2 class="restaurant-title font-size-base ml-2 mb-1"><?php echo e(auth("branch")->user()->ar_name); ?></h2>
                    <img src="<?php echo e(url("/storage/app/public/branches/" . \App\Http\Controllers\Provider\HelperController::get_provider_image_path2(auth("branch")->id(),'branches'))); ?>"
                    
                         class="rounded-circle bg-medium"
                         style="width:60px;height:60px"
                         alt="Restaurant Logo">
                </a>

            <?php endif; ?>
        </nav>
    </div>
</header><!-- .site-header -->


<?php if(auth('provider') -> check()): ?>
  <?php if(auth('provider') -> user() -> accountactivated == 0): ?>
<br><br>
<div class="container">
    <div class="alert alert-info">
                                      الاشتراك بانتظار موافقة الادارة
    </div>
</div>

 <?php endif; ?>
<?php endif; ?> 
