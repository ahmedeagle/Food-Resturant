<?php $__env->startSection('main'); ?>

            <?php if($week_days): ?>
                <?php $__currentLoopData = $week_days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $start_time = $key . "_start_work";
                        $end_time = $key . "_end_work";
                    ?>
                    <?php $__env->startComponent('User.includes.working-time'); ?>
                
                        <?php $__env->slot('en_name'); ?>
                            <?php echo e($key); ?>

                        <?php $__env->endSlot(); ?>
                
                        <?php $__env->slot('ar_name'); ?>
                            <?php echo e($value); ?>

                        <?php $__env->endSlot(); ?>
                
                        <?php $__env->slot("start_time"); ?>
                            <?php echo e($working_hours->$start_time); ?>

                        <?php $__env->endSlot(); ?>
                        <?php $__env->slot("end_time"); ?>
                            <?php echo e($working_hours->$end_time); ?>

                        <?php $__env->endSlot(); ?>
                    <?php echo $__env->renderComponent(); ?>
                
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>    
            
            
            <?php if($type == 'create'): ?>
            
            <button type="button" class="prev-work btn btn-primary py-2 px-5">السابق</button>
            <button type="button" class="next-cats btn btn-default py-2 px-5">التالى</button>
            <?php elseif($type == 'edit'): ?>
              <button type="submit" class="btn btn-primary py-2 px-5 submit_edit_form"> تعديل </button>
            <?php else: ?>
            
            <?php endif; ?>
<?php $__env->stopSection(); ?>