<?php $__env->startSection('title'); ?>
    - <?php echo e($title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="page-header card">
        <div class="card-block">
            <h5 class="m-b-10"><?=$title?></h5>
            <ul class="breadcrumb-title b-t-default p-t-10">
                <li class="breadcrumb-item" style="line-height: 2.5">
                    <a href="<?php echo e(url('admin/dashboard')); ?>">الرئيسية</a>
                </li>
                <li class="breadcrumb-item" style="line-height: 2.5">
                    <a href="<?php echo e(url('admin/providers/all')); ?>">المطاعم</a>
                </li>
                <li class="breadcrumb-item"><a style="line-height: 2.5"><?=$title?></a>
                </li>
            </ul>
        </div>
    </div>
    <!-- Page-header end -->
    <div class="page-body">
        <!-- Basic Form Inputs card start -->
        <div class="card">
            <div class="card-header">
                <h5>تعديل الاشتراكات الشهرية</h5>
            </div>
            <div class="card-block">
                <form action="<?php echo e(url('admin/providers/change-subscription')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo e(csrf_field()); ?>


                    <input type="hidden" name="id" value="<?php echo e($provider->id); ?>" />
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">الاشتراك</label>
                        <div class="col-sm-10">
                            <select style="height: 40px;" name="sub" class="form-control">
                                <option value="">من فضلك قم باختيار الاشتراك</option>
                                <option value="1" <?php if(old('sub') != ''): ?> <?php if(old('sub') == 1): ?> selected <?php endif; ?> <?php else: ?> <?php if($provider->has_subscriptions == 1 ): ?> selected <?php endif; ?> <?php endif; ?>>يوجد اشتراك</option>
                                <option value="0" <?php if(old('sub') != ''): ?> <?php if(old('sub') == 0): ?> selected <?php endif; ?> <?php else: ?> <?php if($provider->has_subscriptions == 0 ): ?> selected <?php endif; ?> <?php endif; ?>>لا يوجد اشتراك</option>
                            </select>
                            <?php if($errors->has("sub")): ?>
                                <?php echo e($errors->first("sub")); ?>

                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">مدة الاشتراك</label>
                        <div class="col-sm-10">
                            <select style="height: 40px;" name="period" class="form-control">
                                <option value="">من فضلك قم باختيار الاشتراك</option>
                                <option value="1" <?php if(old('period') != ''): ?> <?php if(old('period') == 1): ?> selected <?php endif; ?> <?php else: ?> <?php if($provider->subscriptions_period == 1): ?> selected <?php endif; ?> <?php endif; ?>>شهرى</option>
                                <option value="2" <?php if(old('period') != ''): ?> <?php if(old('period') == 2): ?> selected <?php endif; ?> <?php else: ?> <?php if($provider->subscriptions_period == 2): ?> selected <?php endif; ?> <?php endif; ?>>سنوى</option>
                            </select>
                            <?php if($errors->has("period")): ?>
                                <?php echo e($errors->first("period")); ?>

                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">قيمة الاشتراك</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="amount" value="<?php echo e(old("amount", $provider->subscriptions_amount)); ?>" placeholder="قيمة الاشتراك">
                            <?php if($errors->has("amount")): ?>
                                <?php echo e($errors->first("amount")); ?>

                            <?php endif; ?>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-md btn-success"><i class="icofont icofont-check"></i>تعديل</button>    <a href="<?php echo e(url('admin/providers/all')); ?>" class="btn btn-md btn-danger"><i class="icofont icofont-close"></i>  رجوع </a>
                </form>
            </div>
        </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin_panel.blank', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>