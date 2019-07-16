<div class="row <?php echo e($en_name); ?>">
    <div class="col">
        <p><?php echo e($ar_name); ?></p>
        <div class="form-group row">
            <div class="col-lg-6 col-12">
                <div class="row">
                    <label for="<?php echo e($en_name); ?>-start-working-hours-select"
                           class="col-form-label col-auto">من:</label>
                    <div class="col pr-md-0">
                        <select class="working-hours custom-select text-gray font-body-md border-gray"
                                id="<?php echo e($en_name); ?>-start-working-hours-select" required>
                            <option value="">مغلق</option>
                            <?php $__env->startComponent("Provider.includes.working-hours-options"); ?>

                                <?php $__env->slot("time"); ?>
                                    <?php echo e(($start_time) ? $start_time : null); ?>

                                <?php $__env->endSlot(); ?>
                                
                            <?php echo $__env->renderComponent(); ?>
                            
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-12 mt-3 mt-lg-auto">
                <div class="row">
                    <label for="<?php echo e($en_name); ?>-end-working-hours-select"
                           class="col-form-label col-auto">إلى:</label>
                    <div class="col pr-md-0">
                        <select class="working-hours custom-select text-gray font-body-md border-gray"
                                id="<?php echo e($en_name); ?>-end-working-hours-select">
                            <option value="">مغلق</option>
                            <?php $__env->startComponent("Provider.includes.working-hours-options"); ?>

                                <?php $__env->slot("time"); ?>
                                    <?php echo e($end_time); ?>

                                <?php $__env->endSlot(); ?>
                            <?php echo $__env->renderComponent(); ?>
                            
                        </select>
                    </div>
                </div>
            </div>
        </div><!-- .form-group booking-status -->
    </div><!-- .col -->
</div><!-- .row saturday -->