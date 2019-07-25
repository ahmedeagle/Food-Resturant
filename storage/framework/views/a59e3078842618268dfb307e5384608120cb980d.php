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
                        <h4 class="page-title font-body-bold"><?php echo e(trans('site.branches')); ?></h4>
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

                    <?php if(count($branches) > 0): ?>
                    <div class="rounded-lg shadow-around mt-4 overflow-hidden">

                        <div class="table-responsive bg-light">

                            <table class="table">
                                <thead class="font-body-bold">
                                <tr>
                                    <th scope="col"> <?php echo e(trans('site.branch_name')); ?></th>
                                    <th scope="col"> <?php echo e(trans('site.branch_address')); ?></th>
                                    <th scope="col"><?php echo e(trans('site.control')); ?></th>
                                </tr>
                                </thead>

                                <tbody class="font-body-md text-gray border-bottom bg-white">
                                <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <th scope="row"
                                            class="font-body-md text-nowrap"><?php echo e($branch->branch_name); ?></th>
                                        <td class="text-nowrap"><?php echo e($branch->branch_address); ?></td>
                                        <td class="text-nowrap">

                                            <?php if($branch->published == "1"): ?>
                                                <a href="<?php echo e(url("/restaurant/branches/stop-branch/". $branch->branch_id)); ?>">
                                                    <i class="fa fa-pause fa-fw text-primary cursor"
                                                       aria-hidden="true"></i>
                                                </a>
                                            <?php else: ?>
                                                <a href="<?php echo e(url("/restaurant/branches/activate-branch/". $branch->branch_id)); ?>">
                                                    <i class="fa fa-play fa-fw text-primary cursor"
                                                       aria-hidden="true"></i>
                                                </a>
                                            <?php endif; ?>

                                            <a href="<?php echo e(url("/restaurant/branches/edit/" . $branch->branch_id)); ?>">
                                                <i class="fa fa-pencil-alt fa-fw text-primary cursor"
                                                   aria-hidden="true"></i>
                                            </a>

                                            <button class="fa fa-trash-alt fa-fw text-primary cursor"
                                               data-toggle="modal"
                                               id = "<?php echo e($branch->branch_id); ?>"
                                               onclick="deletefn(this.id)"
                                               data-target="#confirm-delete"
                                               aria-hidden="true"></button>
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
                                           <?php echo e(trans('site.delete_branch_message')); ?>

                                        </p>
                                        <div class="modal-footer d-flex justify-content-center pt-0">
                                            <button type="button"
                                                    class="btn btn-primary px-4 px-sm-5 ml-3 font-weight-bold"
                                                    data-dismiss="modal"><?php echo e(trans('site.cancel')); ?></button>
                                            <a type="submit"
                                                    href=""
                                                    id="yes"
                                                    class="btn btn-primary px-4 px-sm-5 font-weight-bold"><?php echo e(trans('site.yes')); ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    <?php else: ?>
                        <div class="mt-4">
                            <?php echo e(trans("provider.empty_branches")); ?>

                        </div>
                    <?php endif; ?>
                    <a href="<?php echo e(url("/restaurant/branches/new-branch")); ?>" class="btn btn-primary no-decoration mt-4 px-4"><?php echo e(trans('site.add_new_branch')); ?></a>

                </div><!-- .col-* -->
            </div><!-- .row -->

        </div><!-- .container -->
    </main><!-- .page-content -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection("script"); ?>
    <script>

        function deletefn(val){
            var a = document.getElementById('yes');
            a.href = "<?php echo e(url('restaurant/branches/delete')); ?>" + "/" +val;

        }

    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("Provider.layouts.master", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>