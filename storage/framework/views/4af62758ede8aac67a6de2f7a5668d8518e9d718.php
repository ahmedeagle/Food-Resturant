<?php $__env->startSection('title'); ?>
    - <?php echo e($title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<style>
    .offer_ar_more , .offer_en_more{
        color: #3886de;
        text-decoration: underline;
    }
</style>
<div class="page-header card">
   <div class="card-block">
      <h5 class="m-b-10"><?php echo e($title); ?></h5>
      <ul class="breadcrumb-title b-t-default p-t-10">
         <li class="breadcrumb-item" style="line-height: 2.5">
            <a href="<?php echo e(url('admin/dashboard')); ?>">الرئيسية</a>
         </li>
         <li class="breadcrumb-item"><a href="<?php echo e(url('admin/offers/list/all')); ?>" style="line-height: 2.5"><?php echo e($title); ?></a>
         </li>
         <a style="float: left; color: white" href="<?php echo e(url('admin/offers/add')); ?>" class="btn btn-grd-primary">اضافة عرض جديد</a>
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
                      <th>صورة العرض</th>
                     <th>عنوان العرض باللغة العربية</th>
                     <th>عنوان العرض باللغة الانجليزية</th>
                     <th>اسم المطعم</th>
                     <th>ترتيب الظهور</th>
                     <th>حالة العرض</th>
                     <th>تاريخ الانشاء</th>
                     <th>العمليات</th>
                  </tr>
               </thead>
               <tbody>
                  <?php $__currentLoopData = $offers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $offer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><img style="width: 100px; height: 66px" src="<?php echo e(url('/storage/app/public/offers/'.$offer->image)); ?>"></td>
                        <td><input type="hidden" value="<?php echo e($offer->ar_title); ?>" /> <?php echo e(str_limit($offer->ar_title, $limit = 30, $end = "....")); ?><?php if(strlen($offer->ar_title) > 30): ?><a href="#" class="offer_ar_more">عرض المزيد</a> <?php endif; ?></td>
                        <td><input type="hidden" value="<?php echo e($offer->en_title); ?>" /><?php echo e(str_limit($offer->en_title, $limit = 30, $end = "....")); ?><?php if(strlen($offer->ar_title) > 30): ?><a href="#" class="offer_en_more">عرض المزيد</a><?php endif; ?></td>
                        <td><?php echo e($offer->ar_name); ?></td>
                        <td><?php echo e($offer->order_level); ?></td>
                        <td><?php echo e(($offer->approved == 1) ? 'مفعل' : 'غير مفعل'); ?></td>
                        <td><?php echo e($offer->created_at); ?></td>
                        <td>
                            <a href="<?php echo e(url('admin/offers/edit/'.$offer->id)); ?>" class="btn btn-warning ">تعديل</a>
                            <button value="<?php echo e($offer->id); ?>" type="button" class="btn btn-danger waves-effect" data-toggle="modal" data-target="#default-Modal" onclick="deletefn(this.value)">حذف</button>
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
                <h4 class="modal-title">حذف العرض</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>هل تريد حذف هذا العرض؟</p>
            </div>
            <div class="modal-footer">
                <a id="yes" style="margin-left: 5px; color: white" class="btn btn-danger waves-effect ">حذف</a>
                <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-primary waves-effect waves-light ">رجوع</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="content-Modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">تفاصيل العرض</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-content-data modal-body">
                <p></p>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-primary waves-effect waves-light ">رجوع</button>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
        function deletefn(val){
        var a = document.getElementById('yes');
        a.href = "<?php echo e(url('admin/offers/delete')); ?>" + "/" +val;

        }
        $(".offer_ar_more , .offer_en_more").on("click", function(e){
            e.preventDefault();
            $(".modal-content-data p").html($(this).parent().find("input").val());
            $("#content-Modal").modal();
        })
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin_panel.blank', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>