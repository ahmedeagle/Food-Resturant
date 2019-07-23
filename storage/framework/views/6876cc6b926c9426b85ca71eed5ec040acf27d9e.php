<div class="col-lg-3 col-md-4 col-12">
    <div class="rounded-bottom-lg rounded-top-lg shadow-around-lg overflow-hidden bg-white">
        <h4 class="welcome mb-0 bg-primary text-light p-3 font-body-bold">
           <?php echo e(trans('site.hello_mjrb')); ?>

        </h4>
        <ul class="nav flex-column font-body-md pr-0 py-3">
            <li class="nav-item">
                <a class="nav-link <?php echo e(( Request::segment(2) == 'dashboard' ) ? 'text-secondary' : 'text-gray'); ?>" href="<?php echo e(url('/user/dashboard')); ?>">
                    <img src="<?php echo e(url('/assets/site/img/icons/home.svg')); ?>"
                         class="ml-1"
                         width="24"
                         height="24"
                         alt="Home icon">
                    <?php echo e(trans('site.home')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(( Request::segment(2) == 'profile' ) ? 'text-secondary' : 'text-gray'); ?>" href="<?php echo e(url('/user/profile')); ?>">
                    <img src="<?php echo e(url('/assets/site/img/icons/user-profile.svg')); ?>"
                         class="ml-1"

                         alt="File icon">
                    <?php echo e(trans('site.profile')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(( Request::segment(2) == 'reservations' ) ? 'text-secondary' : 'text-gray'); ?>" href="<?php echo e(url('/user/reservations')); ?>">
                    <img src="<?php echo e(url('/assets/site/img/icons/reservations.svg')); ?>"
                         class="ml-1"
                         width="24"
                         height="22"
                         alt="Reservations icon">
                     <?php echo e(trans('site.reservations')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(( Request::segment(2) == 'orders' ) ? 'text-secondary' : 'text-gray'); ?>" href="<?php echo e(url('/user/orders')); ?>">
                    <img src="<?php echo e(url('/assets/site/img/icons/orders.svg')); ?>"
                         class="ml-1"
                         width="24"
                         height="22"
                         alt="Orders icon">
                    <?php echo e(trans('site.orders')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(( Request::segment(2) == 'favorites' ) ? 'text-secondary' : 'text-gray'); ?>" href="<?php echo e(url('/user/favorites')); ?>">
                    <img src="<?php echo e(url('/assets/site/img/icons/favourite.svg')); ?>"
                         class="ml-1"
                         alt="Menu icon">
                   <?php echo e(trans('site.favourite')); ?>

                </a>
            </li>
            <?php $__currentLoopData = \App\Http\Controllers\Provider\GeneralController::get_pages_list(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <li class="nav-item">
                <a class="nav-link <?php echo e(( Request::segment(2) == 'page' && Request::segment(3) == $page->id ) ? 'text-secondary' : 'text-gray'); ?>" href="<?php echo e(url('/user/page/' . $page->id)); ?>">
                    <img src="<?php echo e(url('/assets/site/img/icons/sub-page.svg')); ?>"
                         class="ml-1"
                         width="24"
                         height="22"
                         alt="Sub Page icon">
                    <?php echo e($page->title); ?>

                </a>
            </li>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <li class="nav-item">
                <a class="nav-link <?php echo e(( Request::segment(2) == 'tickets' ) ? 'text-secondary' : 'text-gray'); ?>" href="<?php echo e(url('/user/tickets')); ?>">
                    <img src="<?php echo e(url('/assets/site/img/icons/contact.svg')); ?>"
                         class="ml-1"
                         width="24"
                         height="22"
                         alt="Contact icon">
                 <?php echo e(trans('site.contact_us')); ?>

                </a>
            </li>


            <ul>
  
</ul>


              <?php $__currentLoopData = LaravelLocalization::getSupportedLocales(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $localeCode => $properties): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <?php if(LaravelLocalization::getCurrentLocale()  != $localeCode ): ?>
                        <li class="nav-item"> 
                            <a   class="nav-link text-gray" rel="alternate" hreflang="<?php echo e($localeCode); ?>" href="<?php echo e(LaravelLocalization::getLocalizedURL($localeCode, null, [], true)); ?>">
                                <i class="fa fa-gloable"></i>
                                <?php echo e($properties['native']); ?>

                            </a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


            <li class="nav-item">
                <a class="nav-link text-gray" href="<?php echo e(url('/user/logout')); ?>">
                    <img src="<?php echo e(url('/assets/site/img/icons/log-out.svg')); ?>"
                         class="ml-1"
                         width="24"
                         height="22"
                         alt="Logout icon">
                    <?php echo e(trans('site.logout')); ?>

                </a>
            </li>



        </ul>
    </div>
</div><!-- .col-* -->