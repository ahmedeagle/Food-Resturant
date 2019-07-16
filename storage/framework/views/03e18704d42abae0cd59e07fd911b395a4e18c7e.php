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

                <div class="col-lg-9 col-md-8 col-12 mt-4 mt-md-0">

                    <div class="py-2 pr-3 rounded-lg shadow-around bg-white">
                        <h4 class="page-title font-body-bold">الرصيد</h4>
                    </div>

                    <?php if(Session::has("success")): ?>
                        <div class="alert alert-success top-margin">
                            <?php echo e(Session::get("success")); ?>

                        </div>
                    <?php endif; ?>

                    <?php if(Session::has("error")): ?>
                        <div class="alert alert-danger top-margin">
                            <?php echo e(Session::get("error")); ?>

                        </div>
                    <?php endif; ?>

                    <div class="py-2 rounded-lg shadow-around mt-4 bg-white">
                        <div class="row">

                            <div class="col-lg-8 col-12 text-center font-body-bold py-2">
                                <h2 class="balance"><?php echo e($balance); ?><span>ر.س</span></h2>
                                <h4 class="mt-3">الرصيد المتوفر</h4>
                            </div>

                            <div class="col-lg-4 col-12 text-left">
                                <div class="d-flex justify-content-center my-4">
                                    <a href="<?php echo e(url("/restaurant/balance/withdraw")); ?>" class="btn btn-primary px-4">سحب الرصيد</a>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="rounded-lg shadow-around mt-4 overflow-hidden bg-white" >

                        <div class="table-responsive bg-light ">

                            <table class="table">
                                <thead class="font-body-bold">
                                <tr>
                                    <th scope="col">نوع العملية</th>
                                    <th scope="col">رقم العملية</th>
                                    <th scope="col">القيمة</th>
                                    <th scope="col">التاريخ</th>
                                </tr>
                                </thead>

                                <tbody class="font-body-md text-gray border-bottom bg-white">
                                <?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <th scope="row" class="font-body-md text-nowrap"><?php echo e(($log->balance_action == "order") ? trans("provider.order_meal") : trans("provider.withdraw_request")); ?></th>
                                        <td class="text-nowrap"><?php echo e($log->code); ?></td>
                                        <td class="text-nowrap"><?php echo e($log->value); ?><?php echo e(($log->value_type == "increase") ? "+" : "-"); ?> ر.س</td>
                                        <td class="text-nowrap"><?php echo e($log->created_at); ?></td>

                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>

                        </div>
                    </div>


                    <?php echo e($logs->links("Pagination.pagination")); ?>


                </div><!-- .col-* -->
            </div><!-- .row -->

        </div><!-- .container -->
    </main><!-- .page-content -->

<?php $__env->stopSection(); ?>
<?php echo $__env->make("Provider.layouts.master", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>