<?php $__env->startSection('title'); ?>
    - <?php echo e($title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="page-header card">
   <div class="card-block">
      <h5 class="m-b-10"><?php echo e($title); ?></h5>
      <ul class="breadcrumb-title b-t-default p-t-10">
         <li class="breadcrumb-item" style="line-height: 2.5">
            <a href="<?php echo e(url('admin/dashboard')); ?>">الرئيسية</a>
         </li>
         <li class="breadcrumb-item"><a href="<?php echo e(url('admin/subCategories')); ?>" style="line-height: 2.5"><?php echo e($title); ?></a>
         </li>
         <a style="float: left; color: white" href="<?php echo e(url('admin/subCategories/add')); ?>" class="btn btn-grd-primary">اضافة تصنيف فرعى جديد</a>
      </ul>
   </div>
</div>
<div class="page-body">
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
         <div class="dt-responsive table-responsive">
            <table id="order-table" class="table table-striped table-bordered nowrap">
               <thead>
                  <tr>
                     <th>مسلسل</th>  
                     <th>اسم التصنيف باللغة العربية</th>
                     <th>اسم التصنيف باللغة الانجليزية</th>
                     <th>صورة التصنيف</th>
                     <th>الترتيب</th>
                     <th>تاريخ الانشاء</th>
                     <th>العمليات</th>
                  </tr>
               </thead>
               <tbody>
                  <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($key +1); ?></td>
                        <td><?php echo e($category->ar_name); ?></td>
                        <td><?php echo e($category->en_name); ?></td>
                        <td><img style="width: 100px; height: 66px" src="<?php echo e(url('/storage/app/public/subcategories/'.$category->image)); ?>"></td>
                        <td><?php echo e($category->order_level); ?></td>
                        <td><?php echo e($category->created_at); ?></td>
                        <td>
                            <a href="<?php echo e(url('admin/subCategories/edit/'.$category->id)); ?>" class="btn btn-warning ">تعديل</a>
                            
                        </td>
                    </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </table>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="default-Modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">حذف التصنيف</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>هل تريد حذف هذا التصنيف؟</p>
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
        a.href = "<?php echo e(url('admin/subCategories/delete')); ?>" + "/" +val;

        }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin_panel.blank', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>