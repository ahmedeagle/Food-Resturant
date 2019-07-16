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

                    <?php if(count($meals) > 0): ?>

                    <div class="rounded-lg shadow-around mt-4 overflow-hidden">

                        <div class="table-responsive bg-light">
                            <table class="table">
                                <thead class="font-body-bold">
                                <tr>
                                    <th scope="col">إسم الوجبه</th>
                                     <th scope="col">الفرع</th>
                                    <th scope="col">التصنيف</th>
                                    <th scope="col">التحكم</th>
                                </tr>
                                </thead>

                                <tbody class="font-body-md text-gray border-bottom bg-white">
                                    <?php $__currentLoopData = $meals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $meal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <th scope="row" class="font-body-md text-nowrap"><?php echo e($meal->meal_name); ?></th>
                                             <th scope="row" class="font-body-md text-nowrap"><?php echo e($meal->branch_name); ?></th>
                                            <td class="text-nowrap"><?php echo e($meal->cat_name); ?></td>
                                            <td class="text-nowrap">

                                                <?php if($meal->published == "1"): ?>
                                                    <a href="<?php echo e(url("/restaurant/food-menu/stop/". $meal->meal_id)); ?>">
                                                        <i class="fa fa-pause fa-fw text-primary cursor"
                                                           aria-hidden="true"></i>
                                                    </a>
                                                <?php else: ?>
                                                    <a href="<?php echo e(url("/restaurant/food-menu/activate/". $meal->meal_id)); ?>">
                                                        <i class="fa fa-play fa-fw text-primary cursor"
                                                           aria-hidden="true"></i>
                                                    </a>
                                                <?php endif; ?>

                                                <a href="<?php echo e(url("/restaurant/food-menu/edit/" . $meal->meal_id)); ?>">
                                                <i class="fa fa-pencil-alt fa-fw text-primary cursor"
                                                   aria-hidden="true"></i>
                                                </a>


                                                <i class="fa fa-trash-alt fa-fw text-primary cursor"
                                                   data-toggle="modal"
                                                   data-target="#confirm-delete"
                                                   id = "<?php echo e($meal->meal_id); ?>"
                                                   onclick="deletefn(this.id)"
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
                                                    id="yes"
                                                    class="btn btn-primary px-4 px-sm-5 font-weight-bold">نعم</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                    <?php else: ?>
                        <div class="mt-4">
                            <?php echo e(trans("provider.empty-meals")); ?>

                        </div>
                    <?php endif; ?>

                    <?php echo e($meals->links("Pagination.pagination")); ?>


                </div><!-- .col-* -->
            </div><!-- .row -->

        </div><!-- .container -->
    </main><!-- .page-content -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection("script"); ?>
    <script>

        function deletefn(val){
            var a = document.getElementById('yes');
            a.href = "<?php echo e(url('restaurant/food-menu/delete')); ?>" + "/" +val;

        }

    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("Provider.layouts.master", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>