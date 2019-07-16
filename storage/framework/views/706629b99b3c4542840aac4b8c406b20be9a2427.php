<header class="site-header shadow-bottom py-lg-0 py-3 bg-white">
    <div class="container">
        <nav class="navbar navbar-expand-lg font-body-bold px-0">
            <a href="<?php echo e(url("/user/dashboard")); ?>" class="navbar-brand site-logo mr-0 col-3">
                <img src="<?php echo e(url("/assets/site/img/logo.png")); ?>"
                     width="115"
                     height="56"
                     alt="Site Logo">
            </a><!-- .site-logo -->
            <button class="navbar-toggler"
                    type="button"
                    data-toggle="collapse"
                    data-target="#top-navigation"
                    aria-controls="top-navigation"
                    aria-expanded="false"
                    aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse justify-content-end col-lg-9 col-md px-1" id="top-navigation">

                <form id="user-search-form" method = "POST" action="<?php echo e(url("/search")); ?>">
                    <?php echo e(csrf_field()); ?>

                </form>

                <div class="input-group input-group-sm mb-0 justify-content-end align-items-center flex-lg-row">
                    <input type="search" form="user-search-form" name="query" class="form-control border-gray font-body-md text-gray d-sm-inline-flex" placeholder="عن ما تبحث ..." aria-label="" aria-describedby="basic-addon1" required>
                    <div class="input-group-prepend d-inline d-sm-inline-flex">
                        <button form="user-search-form" class="btn btn-primary py-1 px-4" type="submit">بحث</button>
                    </div>
                </div>

                <div class="client-area mt-lg-0 mt-md-2 mt-sm-0 d-flex justify-content-center flex-column flex-lg-row align-items-center">

                    <a class="d-inline-flex m-2 mr-md-3 ml-sm-0">
                        <img src="<?php echo e(url("/assets/site/img/-e-wallet-icon.svg")); ?>" class="ml-2" width="25"
                        height="25">
                        <h2 class="font-size-base font-body-md ml-2 mb-1 wallet"><?php echo e(\App\Http\Controllers\User\BalanceController::get_balance()); ?> ر.س</h2>
                    </a>

                    <a class="text-gray m-2 mr-md-2" href="<?php echo e(url("/user/cart")); ?>">
                        <i class="fas fa-shopping-cart fa-lg"></i>
                    </a>

                    <a class="text-gray m-2 navigation mr-md-2" href="<?php echo e(url("/user/notifications")); ?>">
                        <?php if(\App\Http\Controllers\User\NotificationController::getUserNotification(true) > 0): ?>
                            <span class="badge badge-light bg-primary">

                                <?php echo e(\App\Http\Controllers\User\NotificationController::getUserNotification(true)); ?>


                            </span>
                        <?php endif; ?>
                        <i class="fas fa-bell fa-lg"></i>

                    </a>
                    <a href="<?php echo e(url("/user/profile")); ?>" class="mr-0 mr-md-2">
                        <img src="<?php echo e(\App\Http\Controllers\User\ProfileController::get_image()); ?>"
                            class="rounded-circle bg-medium"
                            width="65"
                            height="65"
                            alt="avatar">
                    </a>
                </div><!-- .client-area -->

            </div>
            
                
                    
                        
                    
                
            
        </nav>
    </div>
</header><!-- .site-header -->