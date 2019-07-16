<?php $__env->startSection('title'); ?>
- <?php echo e($title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="page-body">

    <?php if(auth('admin')->user()->permissions->dashboard == "1"): ?>
    <div class="row">

        <div class="col-md-6 col-xl-3">
            <a href="<?php echo e(url("/admin/customers/all")); ?>">
            <div class="card bg-c-pink order-card">
                <div class="card-block">
                    <h6 class="m-b-20">مستخدمي التطبيق</h6>
                    <h2 class="text-right"><i class="ti-user f-left"></i><span><?php echo e($users); ?></span></h2>
                    <br>
                    <p><span></span></p>
                </div>
            </div>
            </a>
        </div>


        <div class="col-md-6 col-xl-3">
            <a href="<?php echo e(url("/admin/providers/all")); ?>">
                <div class="card bg-c-green order-card">
                    <div class="card-block">
                        <h6 class="m-b-20">المطاعم</h6>
                        <h2 class="text-right"><i class="ti-home f-left"></i><span><?php echo e($providers); ?></span></h2>
                        <br>
                        <p><span></span></p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-xl-3">
            <a href="<?php echo e(url("/admin/offers/list/all")); ?>">
                <div class="card bg-c-yellow order-card">
                    <div class="card-block">
                        <h6 class="m-b-20">العروض</h6>
                        <h2 class="text-right"><i class="ti-agenda f-left"></i><span><?php echo e($offers); ?></span></h2>
                        <br>
                        <p><span></span></p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-xl-3">
            <a href="<?php echo e(url("/admin/orders")); ?>">
                <div class="card bg-c-blue order-card">
                    <div class="card-block">
                        <h6 class="m-b-20">الطلبات</h6>
                        <h2 class="text-right"><i class="ti-printer f-left"></i><span><?php echo e($orders); ?></span></h2>
                        <br>
                        <p><span></span></p>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <?php else: ?>
        <div class="row">
            <div class="col-md-12 col-xl-12">
              <p>أهلا وسهلا بك فى لوحة التحكم</p>
            </div>
        </div>
    <?php endif; ?>
</div> 
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin_panel.blank', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>