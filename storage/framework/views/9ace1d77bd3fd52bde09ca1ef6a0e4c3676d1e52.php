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

                <div class="col-lg-9 col-md-8 col-12 mt-4 mt-md-0 ">

                    <div class="py-2 pr-3 rounded-lg shadow-around bg-white">
                        <h4 class="page-title font-body-bold"><?php echo e($ticket->ticket_title); ?></h4>
                    </div>
                    <div class="chat-container">
                        <?php $__currentLoopData = $replies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reply): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <div class="rounded-lg shadow-around bg-white py-2 font-body-md my-3">

                                <div class="media align-items-lg-start align-items-center flex-column flex-lg-row">
                                    <img class="rounded-circle mb-lg-0 mb-3 ml-3 mt-2 mr-3"
                                         src="<?php echo e(($ticket->provider_image_url == null) ? url("/storage/app/public/users/avatar.png") : $ticket->provider_image_url); ?>"
                                         style="width:90px;height:90px"
                                         draggable="false"
                                         alt="Generic placeholder image">

                                    <div class="media-body">

                                        <h5 class="mt-lg-2 mt-md-0 mt-xs-0 text-lg-right text-center font-size-base">
                                            <?php if($reply->FromUser == "1"): ?> <?php echo e($ticket->provider_name); ?> <?php else: ?> <?php echo e(trans("site.support-name")); ?> <?php endif; ?>
                                        </h5>
                                        <p class="text-lg-right text-center pb-1 text-gray mb-0"><?php echo e($reply->created_date); ?></p>

                                        <p class="text-gray  pl-3 pr-3 pr-lg-0 pb-3 mb-0 mt-2 mt-sm-0 text-lg-right text-md-center text-sm-center text-center font-size-base">

                                            <span class="d-block">
                                                <?php echo e($reply->reply); ?>

                                            </span>
                                        </p>
                                    </div><!-- .media-body -->
                                </div><!-- .media -->
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <div class="reply-cell hidden-element">
                        <div class="rounded-lg shadow-around bg-white py-2 font-body-md my-3">

                            <div class="media align-items-lg-start align-items-center flex-column flex-lg-row">
                                <img class="rounded-circle mb-lg-0 mb-3 ml-3 mt-2 mr-3"
                                     src="<?php echo e(($ticket->provider_image_url == null) ? url("/storage/app/public/users/avatar.png") : $ticket->provider_image_url); ?>"
                                     style="width:90px;height:90px"
                                     draggable="false"
                                     alt="Generic placeholder image">

                                <div class="media-body">

                                    <h5 class="mt-lg-2 mt-md-0 mt-xs-0 text-lg-right text-center font-size-base">
                                        <?php echo e($ticket->provider_name); ?>

                                    </h5>
                                    <p class="time text-lg-right text-center pb-1 text-gray mb-0"></p>

                                    <p class="text-gray  pl-3 pr-3 pr-lg-0 pb-3 mb-0 mt-2 mt-sm-0 text-lg-right text-md-center text-sm-center text-center font-size-base">

                                        <span class="reply-text d-block">

                                        </span>
                                    </p>
                                </div><!-- .media-body -->
                            </div><!-- .media -->
                        </div>
                    </div>

                    <div class="p-3 rounded-lg shadow-around bg-white py-2 font-body-bold my-3">
                        <form id="add-reply-form" data-action="<?php echo e(url("/restaurant/contact-us/ticket/add-reply")); ?>" class="edit-form">
                            <div class="form-group">
                                <label for="provider-details"><?php echo e(trans('site.reply')); ?></label>
                                <input type="hidden" name="ticker_id" class="ticker_id" value="<?php echo e($ticket->ticket_id); ?>" />
                                <textarea class="form-control font-body-md"
                                          id="provider-details"
                                          rows="6"></textarea>
                                <p id= "reply-error" class="alert alert-danger top-margin hidden-element"></p>
                            </div><!-- .form-group details -->
                            <button type="submit" id="add-reply-btn" class="btn btn-primary py-2 px-5 mt-1 mb-1"><?php echo e(trans('site.send')); ?></button>
                        </form>
                    </div>


                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection("script"); ?>
    <script src="<?php echo e(url("/assets/site/js/tickets.js")); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("Provider.layouts.master", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>