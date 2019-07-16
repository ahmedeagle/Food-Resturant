<?php $__env->startSection('title'); ?>
   - <?php echo e($title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php $__env->startSection('content'); ?><div class="page-header card">
   <div class="card-block">
      <h5 class="m-b-10"><?php echo e($title); ?></h5>
      <ul class="breadcrumb-title b-t-default p-t-10">
         <li class="breadcrumb-item">
            <a href="<?php echo e(url('admin/dashboard')); ?>">الرئيسية</a>
         </li>
         <li class="breadcrumb-item"><a href="<?php echo e(url('admin_panel/orders')); ?>">الطلبات</a>
         </li>
         <li class="breadcrumb-item"><a><?php echo e($title); ?></a>
         </li>
      </ul>
   </div>
</div>
<!-- Page-header end -->
<div class="page-body">
   <!-- Container-fluid starts -->
   <div class="container">
      <!-- Main content starts -->

      <div>
         <!-- Invoice card start -->
         <div class="card">
            <div class="card-block" style="height: 200px;">
               <div class="row invoive-info">
                  <div class="col-md-4 col-xs-12 invoice-client-info">
                      <h6>معلومات المطعم  :</h6>


                      <table class="table table-responsive invoice-table invoice-order table-borderless">
                          <tbody>
                          <tr>
                              <th>اسم المطعم :</th>
                              <td><?php echo e($order->provider_name); ?></td>
                          </tr>
                          <tr>
                              <th>نوع التوصيل :</th>
                              <td>
                                  <?php echo e(($order->is_delivery == "1") ? 'توصيل من المطعم' : 'استلام من المطعم'); ?>

                              </td>
                          </tr>
                          <tr>
                              <th>رقم الجوال :</th>
                              <td>
                                  <?php echo e($order->branch_phone); ?>

                              </td>
                          </tr>
                          <tr>
                              <th>البريد الالكترونى : </th>
                              <td>
                                  <?php echo e($order->branch_email); ?>

                              </td>
                          </tr>
                          </tbody>
                      </table>

                  </div>
                  <div class="col-md-4 col-sm-6">
                     <h6>بيانات الطلب :</h6>
                     <table class="table table-responsive invoice-table invoice-order table-borderless">
                        <tbody>
                           <tr>
                              <th>التاريخ :</th>
                              <td><?php echo e($order->created_at); ?></td>
                           </tr>
                           <tr>
                              <th>حالة الدفع :</th>
                              <td>
                                 <?php echo e($order->payment_name); ?>

                              </td>
                           </tr>
                           <tr>
                              <th>رقم الطلب :</th>
                              <td>
                                 <?php echo e($order->order_id); ?>

                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
                  <div class="col-md-4 col-sm-6">
                     <h6 class="m-b-20">معلومات الرصيد</h6>
                     <h6 class="text-uppercase text-primary">الاجمالي :
                        <span><?php echo e($order->total_price); ?> ريال</span>
                     </h6>
                  </div>
               </div>
            </div>
         </div>
         <!-- Invoice card end -->
          <div class="row">
              <div class="col-sm-12">
                  <div class="table-responsive">
                      <table class="table  invoice-detail-table">
                          <thead>
                          <tr class="thead-default">
                              <th style="text-align: right">اسم الوجبة</th>
                              <th style="text-align: right">سعر الوجبة</th>
                              <th style="text-align: right">العدد</th>
                              <th style="text-align: right">الحجم</th>
                              <th style="text-align: right">
                                التفاصيل
                              </th>

                          </tr>
                          </thead>
                          <tbody>
                          <?php $__currentLoopData = $meals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $meal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <tr>
                              <td style="text-align: right">
                                  <h6><?php echo e($meal->ar_name); ?></h6>
                              </td>
                              <td style="text-align: right"><?php echo e($meal->meal_price); ?></td>
                              <td style="text-align: right"><?php echo e($meal->quantity); ?></td>
                              <td style="text-align: right"><?php echo e($meal->size_name); ?></td>
                              <td style="text-align: right">
                                  <button type="button" class="btn btn-primary waves-effect" data-toggle="modal" data-target="#adds-Modal<?php echo e($meal->id); ?>">الاضافات</button>
                                  <button type="button" class="btn btn-success waves-effect" data-toggle="modal" data-target="#options-Modal<?php echo e($meal->id); ?>">التفضيلات</button>
                              </td>

                          </tr>
                          <div class="modal fade" id="options-Modal<?php echo e($meal->id); ?>" tabindex="-1" role="dialog">
                              <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <h4 class="modal-title">تفضيلات الوجبة</h4>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                          </button>
                                      </div>
                                      <div class="modal-body">
                                                <ul>

                                              <?php $__currentLoopData = $meal->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                  <li>
                                                      الاسم: <?php echo e($option->name); ?>- السعر المضاف:   <?php echo e($option->added_price); ?> ريال
                                                  </li>
                                                    <hr />
                                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                      </div>
                                      <div class="modal-footer">
                                          <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-primary waves-effect waves-light ">رجوع</button>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="modal fade" id="adds-Modal<?php echo e($meal->id); ?>" tabindex="-1" role="dialog">
                              <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <h4 class="modal-title">اضافات الوجبة</h4>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                          </button>
                                      </div>
                                      <div class="modal-body">
                                          <ul>

                                              <?php $__currentLoopData = $meal->adds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $add): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                  <li>
                                                      الاسم: <?php echo e($add->name); ?> - السعر المضاف: <?php echo e($add->added_price); ?> ريال
                                                  </li>
                                                  <hr />
                                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                          </ul>
                                      </div>
                                      <div class="modal-footer">
                                          <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-primary waves-effect waves-light ">رجوع</button>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
          <div class="row">
              <div class="col-sm-12">
                  <table class="table table-responsive invoice-table invoice-total">
                      <tbody>
                      <tr>
                          <th>الاجمالي قبل الضريبة وسعر التوصيل : </th>
                          <td> <?php echo e($order->total_price - ( $order->order_tax + $order->delivery_price)); ?> ريال </td>
                      </tr>
                      <tr>
                          <th>الضريبة :</th>
                          <td> <?php echo e($order->order_tax); ?>  % </td>
                      </tr>
                      <tr>
                          <th>سعر التوصيل :</th>
                          <td> <?php echo e($order->delivery_price); ?> ريال </td>
                      </tr>
                      <tr class="text-info">
                          <td>
                              <hr/>
                              <h5 class="text-success">الاجمالي :</h5>
                          </td>
                          <td>
                              <hr/>
                              <h5 class="text-success"><?php echo e($order->total_price); ?> ريال</h5>
                          </td>
                      </tr>
                      </tbody>
                  </table>
              </div>
          </div>
      </div>

   </div>
   <!-- Container ends -->
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin_panel.blank', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>