<?php $__env->startSection('title'); ?>
    <?php echo e($title); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('class'); ?>
    <?php echo e($class); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection("content"); ?>
    <main class="page-content py-5 mb-4">
        <div class="container">
            <div class="row">

                <?php echo $__env->make("Provider.pages.menu", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                <div class="col-lg-9 col-md-8 col-12 mt-4 mt-md-0 font-body-bold">
                    <div class="py-2 pr-3 rounded-lg shadow-around">
                        <h4 class="page-title">تغيير تصنيفات المطعم</h4>
                    </div>
                    <div class="p-3 rounded-lg shadow-around mt-4">

                        <?php if(Session::has("success")): ?>
                            <div class="alert alert-success">
                                <?php echo e(Session::get("success")); ?>

                            </div>
                        <?php endif; ?>

                            <form id="register-food-form" action="<?php echo e(url("/restaurant/profile/change-resturant-categories")); ?>" method="POST" class="mt-4 font-body-md " data-toggle="buttons">
                                
                                <?php echo e(csrf_field()); ?>


                                <?php
                                    $count = 1;
                                    $addParent = true;
                                ?>

                                <input type="hidden" class="food-count" value="<?php echo e(count($cats)); ?>" />
                                <?php $__currentLoopData = $cats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <?php if($addParent): ?>
                                        <div class="row justify-content-center">
                                            <?php endif; ?>

                                            <div class="form-group">
                                                <div class="form-check">
                                                    <label class="btn btn-primary f-food <?php if($cat->selected == "1"): ?> active <?php endif; ?>">
                                                        <input
                                                                data-id = "<?php echo e($cat->id); ?>"
                                                                class="form-check-input<?php echo e($key); ?>"
                                                                type="checkbox"
                                                                name="cats[]"
                                                                value="<?php echo e($cat->id); ?>"
                                                                <?php if($cat->selected == "1"): ?> checked <?php endif; ?>
                                                        />
                                                        <?php echo e($cat->name); ?>

                                                    </label>
                                                </div>
                                            </div>

                                            <?php if($count < 4): ?>
                                                <?php
                                                    $count = $count + 1;
                                                    $addParent = false;
                                                ?>

                                                <?php if(count($cats) == ($key +1)): ?>
                                        </div>
                            <?php endif; ?>
                            <?php continue; ?>
                            <?php else: ?>
                                <?php
                                    $count =  1;
                                    $addParent = true;
                                ?>
                            <?php endif; ?>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <div class="text-center mt-4 text-center">
                        <button type="submit" id="cat_change"  class="btn btn-primary px-5 mx-auto text-center">تغيير</button>
                    </div>
                    </form>

                    </div>
                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->

<?php $__env->stopSection(); ?>



<?php $__env->startSection('main-script'); ?>

 <script>
     
      $('#cat_change').on('click',function(){
          
            $('#register-food-form').submit();
            
          
      }); 
      
      
 </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make("Provider.layouts.master", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>