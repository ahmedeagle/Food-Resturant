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

                <?php echo $__env->make("User.includes.menu", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                <div class="col-lg-9 col-md-8 col-12 mt-4 mt-md-0 font-body-bold">
                    <div class="py-2 pr-3 rounded-lg shadow-around bg-white">
                        <h4 class="page-title font-body-bold"><?php echo e(trans('site.reservations')); ?></h4>
                    </div>

                    <?php if(Session::has("warning")): ?>

                        <div class="alert alert-warning top-margin">
                            <?php echo e(Session::get("warning")); ?>

                        </div>

                    <?php endif; ?>

                    <?php if(Session::has("success")): ?>

                        <div class="alert alert-success top-margin">
                            <?php echo e(Session::get("success")); ?>

                        </div>

                    <?php endif; ?>
                    
                    
                                  <?php if(Session::has('closed')): ?>
                                  
                                    <div class="alert alert-danger top-margin">
                                           <?php echo e(Session::get('closed')); ?> 
                                    </div>
                                 <?php endif; ?>
                                 
                                   <?php if(Session::has('outWork')): ?>
                                  
                                    <div class="alert alert-danger top-margin">
                                           <?php echo e(Session::get('outWork')); ?> 
                                    </div>
                                 <?php endif; ?>
                                 
                                  
                                  
                                  
                    <div class="p-3 rounded-lg shadow-around mt-4 bg-white font-body-bold bg-white">

                        <form action="<?php echo e(url("/user/reservations/add-reservation")); ?>" method="POST">
                            <?php echo e(csrf_field()); ?>



                            <div class="form-group my-2">
                                <label for="people-count"><?php echo e(trans('site.date')); ?></label>
                                <input type="date" name="date" value="<?php echo e(old("date")); ?>" class="form-control border-gray">
                                <?php if($errors->has("date")): ?>

                                    <div class="alert alert-danger top-margin">
                                        <?php echo e($errors->first("date")); ?>

                                    </div>

                                <?php endif; ?>
                            </div>

                            <div class="form-group my-2">
                                <label for="people-count"> <?php echo e(trans('site.time')); ?> </label>
                                <input type="time" id="time" name="time" value="<?php echo e(old("time")); ?>" class="form-control border-gray">
                                <?php if($errors->has("time")): ?>

                                    <div class="alert alert-danger top-margin">
                                        <?php echo e($errors->first("time")); ?>

                                    </div>

                                <?php endif; ?>
                            </div>

                            <div class="form-group my-2">
                                <label for="people-count"> <?php echo e(trans('site.person_num')); ?></label>
                                <input type="text" name="seats_number" value="<?php echo e(old("seats_number")); ?>" class="form-control border-gray">
                                <?php if($errors->has("seats_number")): ?>

                                    <div class="alert alert-danger top-margin">
                                        <?php echo e($errors->first("seats_number")); ?>

                                    </div>

                                <?php endif; ?>
                            </div>

                            <div class="form-group my-2">
                                <label for="special-event"><?php echo e(trans('site.special_reservation')); ?></label>
                                <select class="custom-select text-gray font-body-md border-gray"
                                        id="special-event" name="special">
                                    <option value=""><?php echo e(trans('site.reservation_note')); ?></option>
                                    <option value="1" <?php if(old("special") == "1"): ?> selected <?php endif; ?>><?php echo e(trans('site.special')); ?></option>
                                    <option value="0" <?php if(old("special") == "0"): ?> selected <?php endif; ?>><?php echo e(trans('site.not_special')); ?></option>
                                </select>

                                <?php if($errors->has("special")): ?>

                                    <div class="alert alert-danger top-margin">
                                        <?php echo e($errors->first("special")); ?>

                                    </div>

                                <?php endif; ?>

                            </div>

                            <div class="event_desc_content form-group my-2 <?php if(old("special")): ?> <?php if(old("special") != "1"): ?> hidden-element <?php endif; ?> <?php else: ?> hidden-element <?php endif; ?>">
                                <label for="people-count"><?php echo e(trans('site.occasion_description')); ?></label>
                                <textarea class="form-control font-body-md"
                                          name="occasion_description"
                                          value="<?php echo e(old("occasion_description")); ?>"
                                          rows="6"></textarea>
                                <?php if($errors->has("occasion_description")): ?>

                                    <div class="alert alert-danger top-margin">
                                        <?php echo e($errors->first("occasion_description")); ?>

                                    </div>

                                <?php endif; ?>
                            </div>

                            <input type="hidden" name="status" value="<?php echo e($type); ?>" />
                            <input type="hidden" name="id" value="<?php echo e($id); ?>" />

                            <button type="submit" class="btn btn-primary py-2 px-5 mt-3"><?php echo e(trans('site.confirm')); ?></button>


                            

                        </form>

                    </div>



                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->
<?php $__env->stopSection(); ?>


<?php echo $__env->make("User.layouts.master", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>