<?php $__env->startSection('title'); ?>
    - <?php echo e($title); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('style'); ?>
  <style>
      
       .hidden-element2{
           
           display:none;
       }
       
  </style>
  
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- Page-header start -->
<div class="page-header card">
    <div class="card-block">
        <h5 class="m-b-10">تصنيفات المنتجات</h5>
        <ul class="breadcrumb-title b-t-default p-t-10">
            <li class="breadcrumb-item">
                <a href="<?php echo e(url("/admin/dashboard")); ?>">الرئيسية</a>
            </li>
            <li class="breadcrumb-item"><a href="<?php echo e(url("/admin/meals")); ?>">الوجبات</a>
            </li>
            <li class="breadcrumb-item"><a>تعديل</a>
            </li>
        </ul>
    </div>
</div>
<!-- Page-header end -->
<div class="page-body">
    <!-- Basic Form Inputs card start -->
    <div class="card">
        <div class="card-header">
            <h5>تعديل الوجبة </h5>
        </div>
        <div class="card-block">
            <form action="<?php echo e(url("/admin/meals/edit")); ?>" method="POST" enctype="multipart/form-data">
                <?php echo e(csrf_field()); ?>

                <input type="hidden" name="id" value="<?php echo e($meal->id); ?>" />
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">اسم الوجبة باللغة العربية</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="ar_name" value="<?php echo e(old("ar_name", $meal->ar_name)); ?>" placeholder="من فضلك ادخل الاسم باللغة العربية">
                        <?php if($errors->has("ar_name")): ?>
                            <?php echo e($errors->first("ar_name")); ?>

                        <?php endif; ?>
                    </div>

                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">اسم الوجبة باللغة الانجليزية</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="en_name" value="<?php echo e(old("en_name", $meal->en_name)); ?>" placeholder="من فضلك ادخل الاسم باللغة الانجليزية">
                        <?php if($errors->has("en_name")): ?>
                            <?php echo e($errors->first("en_name")); ?>

                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">السعرات الحرارية</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="calories" value="<?php echo e(old("calories", $meal->calories)); ?>" placeholder="السعرات الحرارية">
                        <?php if($errors->has("calories")): ?>
                            <?php echo e($errors->first("calories")); ?>

                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">تصنيف الوجبة</label>
                    <div class="col-sm-10">

                        <select class="form-control" name="cat">
                            <option value="">برجاء اختيار تصنيف الوجبة</option>
                            <?php $__currentLoopData = $cats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($cat->id); ?>" <?php if($cat->id == $meal->cat_id): ?> selected <?php endif; ?>><?php echo e($cat->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php if($errors->has("cat")): ?>
                            <?php echo e($errors->first("cat")); ?>

                        <?php endif; ?>
                    </div>
                    
                </div>
                
                   <div class="form-group row">
                                <label class="col-sm-2 col-form-label" for="available">متوفر جميع الاوقات</label>
                             <div class="col-sm-10">    
                                <select class="custom-select text-gray font-body-md border-gray"
                                        id="available" name="available" required>
                                    <option value="">يرجى تحديد الحالة</option>
                                    <option value="1" <?php if($meal->available == "1"): ?> selected <?php endif; ?>>نعم</option>
                                    <option value="0" <?php if($meal->available == "0"): ?> selected <?php endif; ?>>لا</option>
                                </select>
                             </div>
                             
                            </div><!-- .form-group available -->

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label" for="spicy">حار</label>
                                
                              <div class="col-sm-10">        
                                <select class="custom-select text-gray font-body-md border-gray"
                                        id="spicy" name="spicy" required>
                                    <option value="">يرجى تحديد القيمة</option>
                                    <option value="1" <?php if($meal->spicy == "1"): ?> selected <?php endif; ?>>نعم</option>
                                    <option value="0" <?php if($meal->spicy == "0"): ?> selected <?php endif; ?>>لا</option>
                                </select>
                                
                                 <?php if($errors->has("spicy")): ?>
                            <?php echo e($errors->first("spicy")); ?>

                        <?php endif; ?>
                             </div>    
                            </div><!-- .form-group spicy -->



                        <div class="form-group spicyDiv row  <?php if($meal->spicy == "0" ): ?> hidden-element2 <?php endif; ?>">       
                                 <label  class="col-sm-2 col-form-label" for="spicy-degree">درجة حرارة الصنف</label>
                                
                                <div class="col-sm-10">        
                                <input type="text"
                                       class="form-control border-gray font-body-md"
                                       name="spicy-degree"
                                       value="<?php echo e(old("spicy-degree", $meal->spicy_degree)); ?>"
                                       placeholder="برجاء ادخال قيمة من 1 الى 5"
                                       id="spicy-degree">
                                       
                                       
                       <?php if($errors->has("spicy_degree")): ?>
                            <?php echo e($errors->first("spicy_degree")); ?>

                        <?php endif; ?>
                             </div><!-- .form-group name -->
                        </div>    
                            
                            
                            

                            <div class="form-group row">
                                <label  class="col-sm-2 col-form-label" for="vegetable">مناسب للنباتيين</label>
                                 
                                  <div class="col-sm-10">        
                                <select class="custom-select text-gray font-body-md border-gray"
                                        id="vegetable" name="vegetable" required>
                                    <option value="">يرجى تحديد القيمة</option>
                                    <option value="1" <?php if($meal->vegetable == "1"): ?> selected <?php endif; ?>>نعم</option>
                                    <option value="0" <?php if($meal->vegetable == "0"): ?> selected <?php endif; ?>>لا</option>
                                </select>
                                
                                  <?php if($errors->has("vegetable")): ?>
                            <?php echo e($errors->first("vegetable")); ?>

                        <?php endif; ?>
                        
                                </div>
                            </div><!-- .form-group vegetable -->

                            <div class="form-group row">
                                
                                <label class="col-sm-2 col-form-label" for="gluten">خالي من الجلوتين </label>
                                <div class="col-sm-10">        
                                <select class="custom-select text-gray font-body-md border-gray"
                                        id="gluten" name="gluten" required>
                                    <option value="">يرجى تحديد القيمة</option>
                                    <option value="1" <?php if($meal->gluten == "1"): ?> selected <?php endif; ?>>نعم</option>
                                    <option value="0" <?php if($meal->gluten == "0"): ?> selected <?php endif; ?>>لا</option>
                                </select>
                                
                                  <?php if($errors->has("gluten")): ?>
                            <?php echo e($errors->first("gluten")); ?>

                        <?php endif; ?>
                        
                        
                                </div>
                            </div><!-- .form-group gluten -->

                            <div class="form-group row">
                                <label   class="col-sm-2 col-form-label" for="calorie">
                                    عدد السعرات الحرارية
                                    <span class="text-gray font-body-md">السعرات الكلية للطلب متوسط الحجم</span>
                                </label>
                                <div class="col-sm-10">        
                                <input type="text"
                                       class="form-control border-gray font-body-md"
                                       id="calorie"
                                       value="<?php echo e(old("calorie", $meal->calories)); ?>"
                                       name="calorie" required>
                                       
                                        
                                 <?php if($errors->has("calories")): ?>
                            <?php echo e($errors->first("calories")); ?>

                        <?php endif; ?>
                        
                                     </div>  
                                
                            </div><!-- .form-group calorie -->

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label" for="details"> الوصف باللغة العربية <span class="text-gray font-body-md">برجاء ادخال على الاقل خمس كلمات</span></label>
                                
                                <div class="col-sm-10">        
                                <textarea class="form-control ar-details font-body-md border-gray"
                                          id="details"
                                          name="ar_description"
                                          rows="6" ><?php echo e(old("ar_description", $meal->ar_description)); ?></textarea>
                                          
                                          
                                          <?php if($errors->has("ar_description")): ?>
                            <?php echo e($errors->first("ar_description")); ?>

                        <?php endif; ?>
                        
                        
                                    </div>      
                            </div><!-- .form-group details -->


                            <div class="form-group row">
                                <label  class="col-sm-2 col-form-label" for="details"> الوصف باللغة الانجليزية <span class="text-gray font-body-md">برجاء ادخال على الاقل خمس كلمات</span></label>
                                
                                <div class="col-sm-10">        
                                <textarea class="form-control en-details font-body-md border-gray"
                                          id="details"
                                          name="en_description"
                                          rows="6" required><?php echo e(old("en_description", $meal->en_description)); ?></textarea>
                                          
                                             <?php if($errors->has("en_description")): ?>
                            <?php echo e($errors->first("en_description")); ?>

                        <?php endif; ?>
                        
                                </div>          
                            </div><!-- .form-group details -->

                            <div class="row">
                                <div class="col-sm-6 col-12">
                                    <p>الأحجام</p>

                                    <?php $__currentLoopData = $sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="form-group">
                                            <input type="text"
                                                   id="size<?php echo e($key + 1); ?>"
                                                   name="size<?php echo e($key + 1); ?>"
                                                   value="<?php echo e(old("size". ($key + 1) ."", $s->size_name)); ?>"
                                                   class="form-control font-body-md border-gray" <?php if($key == 0): ?> required <?php endif; ?>>
                                                   
                                                   
                                                   
                                             <?php if($errors->has("size1")): ?>
                            <?php echo e($errors->first("size1")); ?>

                        <?php endif; ?>
                        
                                        </div><!-- .form-group -->

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(count($sizes) <= 5): ?>
                                        <?php for($i=0; $i <= (5- count($sizes)) - 1; $i++): ?>
                                            <div class="form-group">
                                                <input type="text"
                                                       id="size<?php echo e(count($sizes) + $i + 1); ?>"
                                                       name="size<?php echo e(count($sizes) + $i + 1); ?>"
                                                       value="<?php echo e(old("size". (count($sizes) + $i + 1) ."")); ?>"
                                                       class="form-control font-body-md border-gray">
                                                       
                                          
                                            </div><!-- .form-group -->
                                        <?php endfor; ?>
                                    <?php endif; ?>
                                </div><!-- .col -->
                                <div class="col-sm-6 col-12">

                                    <p>السعر</p>
                                    <?php $__currentLoopData = $sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                            <input type="text"
                                                   id="price<?php echo e($key + 1); ?>"
                                                   name="price<?php echo e($key + 1); ?>"
                                                   pattern="^[0-9]+$"
                                                   value="<?php echo e(old("price". ($key + 1) ."", $s->price)); ?>"
                                                   class="form-control border-0 font-body-md rounded-0"
                                                   aria-describedby="price-addon" <?php if($key == 0): ?> required <?php endif; ?>>
                                                   
                                                            
                                             <?php if($errors->has("price1")): ?>
                            <?php echo e($errors->first("price1")); ?>

                        <?php endif; ?>
                        
                                            <div class="input-group-prepend">
                                            <span id="price1-addon"
                                                  class="input-group-text bg-white border-0 font-body-md text-gray">ر.س
                                            </span>
                                            </div><!-- .input-group-prepend -->
                                        </div><!-- .input-group -->
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    <?php if(count($sizes) <= 5): ?>
                                        <?php for($i=0; $i<= (5- count($sizes)) -1 ; $i++): ?>

                                            <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                                <input type="text"
                                                       id="price<?php echo e(count($sizes) + $i +1); ?>"
                                                       name="price<?php echo e(count($sizes) + $i +1); ?>"
                                                       pattern="^[0-9]+$"
                                                       value="<?php echo e(old("price". (count($sizes) + $i + 1) ."")); ?>"
                                                       class="form-control border-0 font-body-md rounded-0"
                                                       aria-describedby="price-addon">
                                                <div class="input-group-prepend">
                                            <span id="price1-addon"
                                                  class="input-group-text bg-white border-0 font-body-md text-gray">ر.س
                                            </span>
                                                </div><!-- .input-group-prepend -->
                                            </div><!-- .input-group -->


                                        <?php endfor; ?>
                                    <?php endif; ?>


                                </div><!-- .col -->
                            </div>


                            <div class="row">
                                <div class="col-sm-6 col-12">
                                    <p>الاضافات</p>

                                    <?php $__currentLoopData = $adds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="form-group">
                                            <input type="text"
                                                   id="add<?php echo e($key + 1); ?>"
                                                   name="add<?php echo e($key + 1); ?>"
                                                   value="<?php echo e(old("add". ($key + 1) ."", $s->name)); ?>"
                                                   class="form-control font-body-md border-gray">
                                        </div><!-- .form-group -->

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(count($adds) <= 5): ?>
                                        <?php for($i=0; $i <= (5- count($adds)) - 1; $i++): ?>
                                            <div class="form-group">
                                                <input type="text"
                                                       id="add<?php echo e(count($adds) + $i + 1); ?>"
                                                       name="add<?php echo e(count($adds) + $i + 1); ?>"
                                                       value="<?php echo e(old("add". (count($adds) + $i + 1) ."")); ?>"
                                                       class="form-control font-body-md border-gray">
                                            </div><!-- .form-group -->
                                        <?php endfor; ?>
                                    <?php endif; ?>
                                </div><!-- .col -->
                                <div class="col-sm-6 col-12">

                                    <p>السعر المضاف</p>
                                    <?php $__currentLoopData = $adds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                            <input type="text"
                                                   id="add-price<?php echo e($key + 1); ?>"
                                                   name="add-price<?php echo e($key + 1); ?>"
                                                   pattern="^[0-9]+$"
                                                   value="<?php echo e(old("add-price". ($key + 1) ."", $s->price)); ?>"
                                                   class="form-control border-0 font-body-md rounded-0"
                                                   aria-describedby="price-addon">
                                            <div class="input-group-prepend">
                                            <span id="price1-addon"
                                                  class="input-group-text bg-white border-0 font-body-md text-gray">ر.س
                                            </span>
                                            </div><!-- .input-group-prepend -->
                                        </div><!-- .input-group -->
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    <?php if(count($adds) <= 5): ?>
                                        <?php for($i=0; $i<= (5- count($adds)) -1 ; $i++): ?>

                                            <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                                <input type="text"
                                                       id="add-price<?php echo e(count($adds) + $i +1); ?>"
                                                       name="add-price<?php echo e(count($adds) + $i +1); ?>"
                                                       pattern="^[0-9]+$"
                                                       value="<?php echo e(old("add-price". (count($adds) + $i + 1) ."")); ?>"
                                                       class="form-control border-0 font-body-md rounded-0"
                                                       aria-describedby="price-addon">
                                                <div class="input-group-prepend">
                                            <span id="price1-addon"
                                                  class="input-group-text bg-white border-0 font-body-md text-gray">ر.س
                                            </span>
                                                </div><!-- .input-group-prepend -->
                                            </div><!-- .input-group -->


                                        <?php endfor; ?>
                                    <?php endif; ?>


                                </div><!-- .col -->
                            </div>


                            <div class="row">
                                <div class="col-sm-6 col-12">
                                    <p>التفضيلات</p>

                                    <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="form-group">
                                            <input type="text"
                                                   id="option<?php echo e($key + 1); ?>"
                                                   name="option<?php echo e($key + 1); ?>"
                                                   value="<?php echo e(old("option". ($key + 1) ."", $s->name)); ?>"
                                                   class="form-control font-body-md border-gray">
                                        </div><!-- .form-group -->

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(count($options) <= 5): ?>
                                        <?php for($i=0; $i <= (5- count($options)) - 1; $i++): ?>
                                            <div class="form-group">
                                                <input type="text"
                                                       id="option<?php echo e(count($options) + $i + 1); ?>"
                                                       name="option<?php echo e(count($options) + $i + 1); ?>"
                                                       value="<?php echo e(old("option". (count($options) + $i + 1) ."")); ?>"
                                                       class="form-control font-body-md border-gray">
                                            </div><!-- .form-group -->
                                        <?php endfor; ?>
                                    <?php endif; ?>
                                </div><!-- .col -->
                                <div class="col-sm-6 col-12">

                                    <p>السعر المضاف</p>
                                    <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                            <input type="text"
                                                   id="option-price<?php echo e($key + 1); ?>"
                                                   name="option-price<?php echo e($key + 1); ?>"
                                                   pattern="^[0-9]+$"
                                                   value="<?php echo e(old("option-price". ($key + 1) ."", $s->price)); ?>"
                                                   class="form-control border-0 font-body-md rounded-0"
                                                   aria-describedby="price-addon">
                                            <div class="input-group-prepend">
                                            <span id="price1-addon"
                                                  class="input-group-text bg-white border-0 font-body-md text-gray">ر.س
                                            </span>
                                            </div><!-- .input-group-prepend -->
                                        </div><!-- .input-group -->
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    <?php if(count($options) <= 5): ?>
                                        <?php for($i=0; $i<= (5- count($options)) -1 ; $i++): ?>

                                            <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                                <input type="text"
                                                       id="option-price<?php echo e(count($options) + $i +1); ?>"
                                                       name="option-price<?php echo e(count($options) + $i +1); ?>"
                                                       pattern="^[0-9]+$"
                                                       value="<?php echo e(old("option-price". (count($options) + $i + 1) ."")); ?>"
                                                       class="form-control border-0 font-body-md rounded-0"
                                                       aria-describedby="price-addon">
                                                <div class="input-group-prepend">
                                            <span id="price1-addon"
                                                  class="input-group-text bg-white border-0 font-body-md text-gray">ر.س
                                            </span>
                                                </div><!-- .input-group-prepend -->
                                            </div><!-- .input-group -->


                                        <?php endfor; ?>
                                    <?php endif; ?>


                                </div><!-- .col -->
                            </div>


                            <div class="form-group row">
                                <label  class="col-sm-2 col-form-label" for="recommended">ينصح به من قبل المطعم </label>
                                
                                <div class="col-sm-10">
                                <select name="recommended" class="custom-select text-gray font-body-md border-gray" required>
                                    <option value="">برجاء اختيار الحالة</option>
                                    <option value="1" <?php if($meal->recommend == "1"): ?> selected <?php endif; ?>>نعم</option>
                                    <option value="0" <?php if($meal->recommend == "0"): ?> selected <?php endif; ?>>لا</option>
                                </select>
                                
                                                
                                             <?php if($errors->has("recommended")): ?>
                            <?php echo e($errors->first("recommended")); ?>

                        <?php endif; ?>
                                </div>
                            </div><!-- .form-group gluten -->

 
 
                        <input type="hidden" name="meal_id" value="<?php echo e($meal->id); ?>" />
  

                <button type="submit" class="btn btn-md btn-success"><i class="icofont icofont-check"></i>  تعديل </button>    <a href="<?php echo e(url("/admin/meals")); ?>" class="btn btn-md btn-danger"><i class="icofont icofont-close"></i>  رجوع </a>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

 <script>
     
     $(document).on('change','#spicy',function(){
    
         if($(this).val() == "0")
         {
             
               $('.spicyDiv').hide();
             
         }else{
             
             $('.spicyDiv').show();
         }
            
         
     });
 </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin_panel.blank', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>