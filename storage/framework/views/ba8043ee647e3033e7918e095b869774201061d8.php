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
                        <h4 class="page-title font-body-bold">   <?php echo e(trans('site.tickets_new')); ?> </h4>
                    </div>

                    <form action="<?php echo e(url("/restaurant/contact-us/open-new-ticket")); ?>" method="POST">
                        <?php echo e(csrf_field()); ?>

                    <div class="p-3 rounded-lg shadow-around font-body-bold mt-4 bg-white">

                            <div class="form-group my-2">
                                <label for="messaging-type">   <?php echo e(trans('site.conversation_type')); ?> </label>
                                <select class="custom-select text-gray font-body-md border-gray"
                                        id="messaging-type"
                                        name="type">
                                    <option selected value="<?php echo e(trans('site.choose_conversation_type')); ?>"><?php echo e(trans('site.choose_conversation_type')); ?></option>

                                    <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($type->id); ?>"><?php echo e($type->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </select>
                                <?php if($errors->has('type')): ?>
                                    <p class="alert alert-danger top-margin">
                                        <?php echo e($errors->first('type')); ?>

                                    </p>
                                <?php endif; ?>
                            </div>


                            <div class="form-group my-2">
                                <label for="address"><?php echo e(trans('site.subject')); ?></label>
                                <input type="text"
                                       class="form-control border-gray font-body-md text-gray"
                                       id="address"
                                       name="title"
                                       value="<?php echo e(old("title")); ?>"
                                       placeholder=""
                                >
                                <?php if($errors->has('title')): ?>
                                    <p class="alert alert-danger top-margin">
                                        <?php echo e($errors->first('title')); ?>

                                    </p>
                                <?php endif; ?>
                            </div>

                            <div class="form-group mb-1">
                                <label for="subject"><?php echo e(trans('site.content')); ?></label>
                                <textarea class="form-control font-body-md"
                                          id="subject"
                                          name="subject"
                                          rows="6"><?php echo e(old("subject")); ?></textarea>
                                <?php if($errors->has('subject')): ?>
                                    <p class="alert alert-danger top-margin">
                                        <?php echo e($errors->first('subject')); ?>

                                    </p>
                                <?php endif; ?>
                            </div>



                    </div>


                    <button type="submit" class="btn btn-primary py-2 px-5 mt-3"> <?php echo e(trans('site.send')); ?> </button>
                    </form>

                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make("Provider.layouts.master", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>