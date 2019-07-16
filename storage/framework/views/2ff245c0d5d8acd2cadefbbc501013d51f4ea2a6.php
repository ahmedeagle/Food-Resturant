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
                <li class="breadcrumb-item"><a href="<?php echo e(url('booking')); ?>" style="line-height: 2.5"><?=$title?></a>
                </li>
                
            </ul>
        </div>
    </div>




    <div class="page-body">
        <div class="row">
            <div class="col-sm-12">
                <!-- Product list card start -->
                <?php if(Session::has('error')): ?>
                    <div class="alert alert-danger"> <?php echo e(Session::get('error')); ?></div>
                <?php endif; ?>
                <?php if(Session::has('success')): ?>
                    <div class="alert alert-success"> <?php echo e(Session::get('success')); ?></div>
                <?php endif; ?>
                <div class="card">
                    <div class="card-header">
                        <h5><?php echo e($title); ?></h5>
                    </div>
                    <div class="card-block">
                        <div class="table-responsive">
                            <div class="table-content">
                                <div class="project-table">


                                    <table id="order-table" class="table table-striped table-bordered nowrap">
                                        <thead>
                                        <tr>
                                            <th>مسلسل</th>
                                            <th>اسم المطعم</th>
                                            <th>اسم المستخدم</th>
                                            <th>رقم الهاتف</th>
                                            <th>الايميل</th>
                                            <th>تاريخ الحجز</th>
                                            <th>عدد المقاعد</th>
                                            <th>مناسبة خاصة</th>
                                            <th>نوع الحجز</th>
                                            <th>حالة الحجز</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($key + 1); ?></td>
                                                <td><?php echo e($r->provider_name); ?></td>
                                                <td><?php echo e($r->user_name); ?></td>
                                                <td><?php echo e($r->user_phone); ?></td>
                                                <td><?php echo e($r->user_email); ?></td>
                                                <td><?php echo e($r->time); ?> - <?php echo e($r->date); ?></td>
                                                <td><?php echo e($r->seats_number); ?></td>
                                                <td><?php echo e(($r->special_reservation == "1") ? 'نعم': 'لا'); ?></td>
                                                <td><?php echo e(($r->booking_status == "0") ? 'أفراد': 'عائلات'); ?></td>
                                                <td><?php echo e($r->status); ?></td>

                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Product list card end -->
            </div>
        </div>
    </div>


    <div class="modal fade" id="default-Modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">حذف الحالة</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>هل تريد حذف هذا الحالة؟</p>
                </div>
                <div class="modal-footer">
                    <a id="yes" style="margin-left: 5px; color: white" class="btn btn-danger waves-effect ">حذف</a>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-primary waves-effect waves-light ">رجوع</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function deletefn(val){
            var a = document.getElementById('yes');
            a.href = "<?php echo e(url('admin/orderstatus/delete/')); ?>"+ "/" +val;

        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin_panel.blank', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>