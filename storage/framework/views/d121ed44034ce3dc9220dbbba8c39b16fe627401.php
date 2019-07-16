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
                        <h4 class="page-title font-body-bold">تذاكري السابقة</h4>
                    </div>

                    <?php if(Session::has('success')): ?>
                        <div class="alert alert-success top-margin">

                            <?php echo e(Session::get('success')); ?>


                        </div>
                    <?php endif; ?>

                    <?php if(count($tickets) > 0): ?>
                    <div class="rounded-lg shadow-around mt-3 overflow-hidden">

                        <div class="table-responsive bg-white">
                            
                            <table class="table table-striped">
                                <thead class="font-body-bold">
                                <tr>
                                    <th scope="col-7">العنوان</th>
                                    <th scope="col-4">التاريخ</th>
                                </tr>

                                </thead>


                                <tbody class="font-body-md text-gray border-bottom bg-white">

                                <?php $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <th scope="row" class="font-body-md text-nowrap "><a href="<?php echo e(url("/restaurant/contact-us/ticket/details/". $ticket->id)); ?>"><?php echo e($ticket->title); ?></a></th>
                                        <td class="text-nowrap"><?php echo e($ticket->created_at); ?></td>

                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                            
                        </div>

                    </div>
                    <?php else: ?>
                        <div class="mt-4">قائمة التذاكر فارغة</div>
                    <?php endif; ?>
                    <?php echo e($tickets->links('Pagination.pagination')); ?>


                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make("Provider.layouts.master", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>