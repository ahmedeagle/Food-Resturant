<header class="site-header shadow-bottom py-lg-0 py-3">
    <div class="container">
        <nav class="navbar navbar-expand-lg font-body-bold px-0">
            <a href="<?php echo e(url("/")); ?>" class="navbar-brand site-logo mr-0">
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
            <div class="collapse navbar-collapse justify-content-end" id="top-navigation">
                <ul class="nav navbar primary-menu flex-column flex-lg-row">
                    <li class="nav-item">
                        <a href="<?php echo e(url('/')); ?>" class="nav-link text-secondary px-xl-3 px-2"><?php echo e(trans('site.home')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo e(url('/#offers')); ?>" class="nav-link text-secondary px-xl-3 px-2"><?php echo e(trans('site.offers')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo e(url('/#categories')); ?>" class="nav-link text-secondary px-xl-3 px-2"><?php echo e(trans('site.cats')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo e(url('/#app')); ?>" class="nav-link text-secondary px-xl-3 px-2"><?php echo e(trans('site.apps')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo e(url('/#contact')); ?>" class="nav-link text-secondary px-xl-3 px-2">  <?php echo e(trans('site.contact_us')); ?></a>
                    </li>

                  <?php $__currentLoopData = LaravelLocalization::getSupportedLocales(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $localeCode => $properties): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <?php if(LaravelLocalization::getCurrentLocale()  != $localeCode ): ?>
                        <li class="nav-item"> 
                            <a rel="alternate" hreflang="<?php echo e($localeCode); ?>" href="<?php echo e(LaravelLocalization::getLocalizedURL($localeCode, null, [], true)); ?>">
                                <?php echo e($properties['native']); ?>

                            </a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </ul><!-- .primary-menu -->

                    

                <div class="client-area mt-lg-0 mt-md-2 mt-sm-0 d-flex justify-content-center">
                    <a href="<?php echo e(url('/register')); ?>"
                       class="btn btn-outline-primary px-3 px-sm-4 ml-2">
                        <?php echo e(trans('site.register')); ?>

                    </a>
                    <a href="<?php echo e(url('/login')); ?>"
                       class="btn btn-primary px-3 px-sm-4 mr-2">
                        <?php echo e(trans('site.login')); ?>

                    </a>
                </div><!-- .client-area -->
            </div>
        </nav>
    </div>
</header><!-- .site-header -->
 