<section id="app" class="app-dl py-5">
    <header class="section-header text-center">
        <h2 class="section-title font-body-heavy mb-4"><?php echo e(trans('site.download_apps')); ?></h2>
        <p class="font-body-md text-gray"><?php echo e(trans('site.download_via_stores')); ?></p>
    </header><!-- .section-header -->
    <div class="section-content">

        <div class="container">
            <div class="app-store d-flex justify-content-center flex-column flex-sm-row ltr mt-5">
                <a href="<?php echo e($settings->ios_app_url); ?>" class="mr-sm-2 mr-0">
                    <img src="<?php echo e(url('/assets/site/img/app/app-store.png')); ?>"
                         class="img-fluid d-block mx-auto"
                         width="231"
                         height="70"
                         alt="App Store">
                </a>
                <a href="<?php echo e($settings->android_app_url); ?>" class="ml-sm-2 ml-0 mt-2 mt-sm-0">
                    <img src="<?php echo e(url('/assets/site/img/app/google-play.png')); ?>"
                         class="img-fluid d-block mx-auto"
                         width="231"
                         height="70"
                         alt="Google Play">
                </a>
            </div>
            <img src="<?php echo e(url('/assets/site/img/app/galaxy-note-8.png')); ?>"
                 class="img-fluid d-block mx-auto mt-5"
                 width="977"
                 height="245"
                 alt="Galaxy Note 8">
        </div><!-- .container -->

    </div><!-- .section-content -->
</section><!-- .app-dl -->