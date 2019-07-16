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

                    <div class="py-2 pr-3 rounded-lg shadow-around">
                        <h4 class="page-title font-body-bold">كل الوجبات</h4>
                    </div>

                    <?php if(Session::has("warning")): ?>
                        <div class="alert alert-warning top-margin">
                            <?php echo e(Session::get("warning")); ?>

                        </div>
                    <?php endif; ?>

                    <?php if(Session::has("error")): ?>
                        <div class="alert alert-danger top-margin">
                            <?php echo e(Session::get("error")); ?>

                        </div>
                    <?php endif; ?>

                    <?php if(Session::has("success")): ?>
                        <div class="alert alert-success top-margin">
                            <?php echo e(Session::get("success")); ?>

                        </div>
                    <?php endif; ?>

                    <?php if(count($cats) > 0): ?>
                    <div class="rounded-lg shadow-around mt-4 overflow-hidden">

                        <div class="table-responsive bg-light">

                            <table class="table">
                                <thead class="font-body-bold">
                                <tr>
                                    <th scope="col">إسم التصنيف</th>
                                    <th scope="col">عدد الوجبات</th>
                                    <th scope="col">التحكم</th>
                                </tr>
                                </thead>

                                <tbody class="font-body-md text-gray border-bottom bg-white">
                                <?php $__currentLoopData = $cats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <th scope="row"
                                            class="font-body-md text-nowrap"><?php echo e($cat->name); ?></th>
                                        <td class="text-nowrap"><?php echo e($cat->count); ?></td>
                                        <td class="text-nowrap">

                                            <?php if($cat->published == "1"): ?>
                                                <a href="<?php echo e(url("/restaurant/food-menu/cat/stop/" . $cat->cat_id)); ?>">
                                                    <i class="fa fa-pause fa-fw text-primary cursor"
                                                       aria-hidden="true"></i>
                                                </a>
                                            <?php else: ?>
                                                <a href="<?php echo e(url("/restaurant/food-menu/cat/activate/" . $cat->cat_id)); ?>">
                                                    <i class="fa fa-play fa-fw text-primary cursor"
                                                       aria-hidden="true"></i>
                                                </a>
                                            <?php endif; ?>

                                            <a href="<?php echo e(url("/restaurant/food-menu/cat/edit/" . $cat->cat_id)); ?>">

                                                <i class="fa fa-pencil-alt fa-fw text-primary cursor"
                                                   aria-hidden="true"></i>

                                            </a>

                                            <i class="fa fa-trash-alt fa-fw text-primary cursor"
                                               data-toggle="modal"
                                               id = "<?php echo e($cat->cat_id); ?>"
                                               onclick="deletefn(this.id)"
                                               data-target="#confirm-delete"
                                               aria-hidden="true"></i>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>

                            <div class="modal fade"
                                 id="confirm-delete"
                                 tabindex="-1"
                                 role="dialog"
                                 aria-labelledby="exampleModalLabel"
                                 aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content py-3">
                                        <p class="modal-body h4 font-weight-bold text-center mb-auto">
                                            هل تريد تأكيد عملية الحذف
                                        </p>
                                        <div class="modal-footer d-flex justify-content-center pt-0">
                                            <button type="button"
                                                    class="btn btn-primary px-4 px-sm-5 ml-3 font-weight-bold"
                                                    data-dismiss="modal">إلغاء</button>
                                            <a type="submit"
                                                    class="btn btn-primary px-4 px-sm-5 font-weight-bold"
                                                    id="yes">نعم</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    <?php else: ?>

                    <div class="mt-4">
                        <?php echo e(trans("provider.empty_meal_cats")); ?>

                    </div>

                    <?php endif; ?>
                    <div class="rounded-lg shadow-around mt-4">
                        <form action="<?php echo e(url("/restaurant/food-menu/new-cat")); ?>" id="add-meal-cat-form" method="POST" class="new-cat-form p-3">
                            <?php echo e(csrf_field()); ?>


                            <div class="form-group">
                                <label for="new-cat" class="font-body-bold">إضافة تصنيف جديد</label>
                                <div class="d-flex justify-content-center flex-column flex-sm-row">
                                    <input type="text" name="ar_name" value="<?php echo e(old("ar_name")); ?>" class="form-control" id="new-cat">
                                    <button class="btn btn-primary font-body-bold px-lg-5 px-md-4 px-sm-5 d-sm-inline-block d-block mr-sm-3 mt-2 mt-sm-auto"
                                            type="submit">إضافة</button>

                                </div>
                                <?php if($errors->has("ar_name")): ?>
                                    <div class="alert top-margin">
                                        <?php echo e($errors->first("ar_name")); ?>

                                    </div>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>

                </div><!-- .col-* -->
            </div><!-- .row -->

        </div><!-- .container -->
    </main><!-- .page-content -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection("script"); ?>
    <script>

        function deletefn(val){
            var a = document.getElementById('yes');
            a.href = "<?php echo e(url('restaurant/food-menu/cat/delete')); ?>" + "/" +val;

        }

    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("Provider.layouts.master", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>