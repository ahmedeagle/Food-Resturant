<?php $__env->startSection('title'); ?>
    <?php echo e($title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('class'); ?>
    <?php echo e($class); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

        <main class="page-content py-5 mb-4 ">
        <div class="container">
            <div class="row">
                
                <?php if(auth('web')->user()): ?>
                    <?php echo $__env->make("User.includes.menu", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php endif; ?>
                <div class="<?php if(auth('web')->user()): ?> col-lg-9 col-md-8 col-12 <?php else: ?> col-lg-12 col-md-11 col-12 <?php endif; ?> mt-4 mt-md-0 ">
                    <div class="py-2 pr-3 rounded-lg shadow-around bg-white">
                        <h4 class="page-title font-body-bold"><?php echo e($meal->ar_name); ?></h4>
                    </div>

                    <div class="mael-pic mt-4 rounded-lg shadow-around bg-white">
                        
                        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">

                        
                            <ol class="carousel-indicators">
                                <?php $__currentLoopData = $meal->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li data-target="#carouselExampleControls" data-slide-to="<?php echo e($key); ?>" class="<?php if($key == 0): ?> active <?php endif; ?>"></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ol>

                            <div class="carousel-inner">
                                
                                <?php $__currentLoopData = $meal->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    
                                    <div class="carousel-item <?php if($key == 0): ?> active <?php endif; ?>">
                                        <img style="width:825px;height:331px" class="d-block w-100" src="<?php echo e($img->meal_image_url); ?>" alt="First slide" draggable="false">
                                    </div>
                                    
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               
                            </div>
                            
                            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>


                        <!-- <div class="d-flex justify-content-center flex-sm-row">
                            <p class="page-content font-body-md text-gray py-2 py-3 px-3">
                                    هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق.
                            </p>
                            <span class="love mt-xs-5 ml-3 px-md-4 px-sm-4 d-sm-inline-block d-block mr-sm-3 mt-2 mb-auto mt-sm-auto rounded-lg shadow-around">
                                <i class="fa fa-heart fa-lg text-white cursor"></i>
                            </span>

                        </div> -->

                        <div class="d-flex justify-content-center flex-column flex-sm-row pb-3">
                            <p class="page-content font-body-md text-gray py-3 px-3 mb-0">
                                <?php echo e($meal->ar_description); ?>      
                            </p>
                        </div>
                    
                    </div>
                    
                    
                     <div class="p-3 rounded-lg shadow-around mt-4 bg-white">

                        <div class="table-responsive">
                        <table class="table mb-0 tebel-meal">
                            <thead>
                                
                                
                              <tr class="">
                                <th scope="col" class="border-top-0 font-body-md"><?php echo e(trans('site.spicy_deg')); ?> </th>
                                <th scope="col" class="border-top-0 font-body-md"></th>
                                <th scope="col" class="border-top-0   font-body-md"> <?php echo e(trans('site.property')); ?></th>
                 
                              </tr>

                              
                              
                            </thead>


                            <tbody>
                              <tr>
                                <th scope="row" class="font-body-md">
                                    
                                    
                                      <?php if($meal->spicy     == "1"): ?>
                                      <span class=""><img src="<?php echo e(url('/')); ?>/storage/app/public/icons/thermometer-icon.png"/></span>
                                      <span class=""><img src="<?php echo e(url('/')); ?>/storage/app/public/icons/nothermometer-icon.png"/></span>
                                      <span class=""><img src="<?php echo e(url('/')); ?>/storage/app/public/icons/nothermometer-icon.png"/></span>
                                      <span class=""><img src="<?php echo e(url('/')); ?>/storage/app/public/icons/nothermometer-icon.png"/></span>
                                      <span class=""><img src="<?php echo e(url('/')); ?>/storage/app/public/icons/nothermometer-icon.png"/></span>
                                        
                                      <?php elseif($meal->spicy == "2"): ?>
                                      
                                       <span class=""><img src="<?php echo e(url('/')); ?>/storage/app/public/icons/thermometer-icon.png"/></span>
                                       <span class=""><img src="<?php echo e(url('/')); ?>/storage/app/public/icons/thermometer-icon.png"/></span>
                                      <span class=""><img src="<?php echo e(url('/')); ?>/storage/app/public/icons/nothermometer-icon.png"/></span>
                                      <span class=""><img src="<?php echo e(url('/')); ?>/storage/app/public/icons/nothermometer-icon.png"/></span>
                                      <span class=""><img src="<?php echo e(url('/')); ?>/storage/app/public/icons/nothermometer-icon.png"/></span>
                                      
                                      <?php elseif($meal->spicy == "3"): ?>
                                      
                                       <span class=""><img src="<?php echo e(url('/')); ?>/storage/app/public/icons/thermometer-icon.png"/></span>
                                       <span class=""><img src="<?php echo e(url('/')); ?>/storage/app/public/icons/thermometer-icon.png"/></span>
                                        <span class=""><img src="<?php echo e(url('/')); ?>/storage/app/public/icons/thermometer-icon.png"/></span>
                                       <span class=""><img src="<?php echo e(url('/')); ?>/storage/app/public/icons/nothermometer-icon.png"/></span>
                                       <span class=""><img src="<?php echo e(url('/')); ?>/storage/app/public/icons/nothermometer-icon.png"/></span>
                                      
                                      <?php elseif($meal->spicy == "4"): ?>
                                        <span class=""><img src="<?php echo e(url('/')); ?>/storage/app/public/icons/thermometer-icon.png"/></span>
                                        <span class=""><img src="<?php echo e(url('/')); ?>/storage/app/public/icons/thermometer-icon.png"/></span>
                                        <span class=""><img src="<?php echo e(url('/')); ?>/storage/app/public/icons/thermometer-icon.png"/></span>
                                        <span class=""><img src="<?php echo e(url('/')); ?>/storage/app/public/icons/thermometer-icon.png"/></span>
                                        <span class=""><img src="<?php echo e(url('/')); ?>/storage/app/public/icons/nothermometer-icon.png"/></span>
                                      <?php elseif($meal->spicy == "5"): ?>
                                       <span class=""><img src="<?php echo e(url('/')); ?>/storage/app/public/icons/thermometer-icon.png"/></span>
                                        <span class=""><img src="<?php echo e(url('/')); ?>/storage/app/public/icons/thermometer-icon.png"/></span>
                                        <span class=""><img src="<?php echo e(url('/')); ?>/storage/app/public/icons/thermometer-icon.png"/></span>
                                        <span class=""><img src="<?php echo e(url('/')); ?>/storage/app/public/icons/thermometer-icon.png"/></span>
                                        <span class=""><img src="<?php echo e(url('/')); ?>/storage/app/public/icons/thermometer-icon.png"/></span>
                                      <?php else: ?>
                                      
                                        <span class=""><img src="<?php echo e(url('/')); ?>/storage/app/public/icons/nothermometer-icon.png"/></span>
                                        <span class=""><img src="<?php echo e(url('/')); ?>/storage/app/public/icons/nothermometer-icon.png"/></span>
                                        <span class=""><img src="<?php echo e(url('/')); ?>/storage/app/public/icons/nothermometer-icon.png"/></span>
                                        <span class=""><img src="<?php echo e(url('/')); ?>/storage/app/public/icons/nothermometer-icon.png"/></span>
                                        <span class=""><img src="<?php echo e(url('/')); ?>/storage/app/public/icons/nothermometer-icon.png"/></span>
                                        
                                      <?php endif; ?>

                                  
 
                                       
                                </th>
                                 <td class="text-primary font-body-md small-price">
                                     </td>
                                 <td class="text-primary font-body-md small-price">
                                     
                                <?php if($meal->vegetable == "1"): ?>
                                   <span class="" title="<?php echo e(trans('site.vegetarian')); ?>"><img src="<?php echo e(url('/')); ?>/storage/app/public/icons/vegetarian-meals-icon.png"/></span>
                                <?php endif; ?>
                                
                                <?php if($meal->calories): ?>
                                   <span class="" title="<?php echo e($meal->calories); ?> <?php echo e(trans('site.Calories')); ?>"><img src="<?php echo e(url('/')); ?>/storage/app/public/icons/no-gluten-icon.png"/></span>
                                <?php endif; ?>   
                                </td>
                                
                                
                                
                               
                              </tr>
                             
                              
                            </tbody>
                          </table>
                        </div>
                    </div>
                    

                    <div class="p-3 rounded-lg shadow-around mt-4 bg-white">

                        <div class="table-responsive">
                        <table class="table mb-0 tebel-meal">
                            <thead>
                              <tr class="">
                                <th scope="col" class="border-top-0 font-body-md"><?php echo e(trans('site.Calories')); ?></th>
                                <th scope="col" class="border-top-0 text-primary font-body-md"><?php echo e($meal->calories); ?>   <?php echo e(trans('site.Calory')); ?></th>
                                <th scope="col" class="border-top-0 text-gray font-body-md"><?php echo e(trans('site.avg_colaries')); ?></th>
                
                              </tr>

                              <tr>
                                  <th scope="col" class="border-top-0 font-body-md"><?php echo e(trans('site.recommanded_restaurant')); ?></th>
                                  <th scope="col" class="border-top-0 text-primary font-body-md"><?php echo e(( $meal->recommend == "1") ? trans('site.yes')  :  trans('site.no')); ?></th>
                                  <th></th>
                              </tr>

                            

                                <?php if(count($meal->sizes) == 0): ?>
                                    <tr>
                                        <th scope="col" class="border-top-0 font-body-md"><?php echo e(trans('site.price')); ?></th>
                                        <th scope="col" class="border-top-0 text-primary font-body-md"><?php echo e($meal->price); ?></th>
                                        <th></th>
                                    </tr>
                                <?php endif; ?>
                              
                            </thead>


                            <tbody>
                              <tr>
                                <th scope="row" class="font-body-md"><?php echo e(trans('site.size')); ?></th>
                                <?php if(count($meal->sizes) > 0): ?>
                                <td>
                                    <div class="mr-4">
                                        <?php $__currentLoopData = $meal->sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="custom-control custom-radio">
                                                <input
                                                        type="radio"
                                                        id="size_customRadio<?php echo e($key + 1); ?>"
                                                        value="<?php echo e($size->id); ?>"
                                                        name="size_customRadio"
                                                        class="size_select custom-control-input"
                                                        
                                                >
                                                <label class="custom-control-label text-gray mb-2" for="size_customRadio<?php echo e($key + 1); ?>"><?php echo e($size->ar_name); ?></label>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>

                                </td>
                                <td class="text-primary font-body-md small-price">
                                    <?php $__currentLoopData = $meal->sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="mb-2">
                                            <?php echo e($size->price); ?> <?php echo e(trans('site.riyal')); ?>

                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                                <?php else: ?>
            
                                    <td><?php echo e(trans('site.no_sizes_meal')); ?></td>         
                                    <td></td>
            
                                <?php endif; ?>
                              </tr>
                              <tr>
                                <th scope="row" class="font-body-md"><?php echo e(trans('site.options')); ?></th>
                                <?php if(count($meal->adds) > 0): ?>
                                <td>
                                    <div class="mr-4">
                                        <?php $__currentLoopData = $meal->adds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $add): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        
                                            <div class="custom-control custom-checkbox">
                                                <input
                                                        type="checkbox"
                                                        class="adds_select custom-control-input"
                                                        value="<?php echo e($add->id); ?>"
                                                        id="add_customCheck<?php echo e($key + 1); ?>"
                                                        
                                                >
                                                <label class="custom-control-label text-gray mb-2" for="add_customCheck<?php echo e($key + 1); ?>"><?php echo e($add->ar_name); ?></label>
                                            </div>
                                        
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </td>
                                <td class="text-primary font-body-md ">
                                    
                                    <?php $__currentLoopData = $meal->adds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $add): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="mb-2">
                                            <?php echo e($add->added_price); ?>  <?php echo e(trans('site.riyal')); ?>

                                        </div> 
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                                <?php else: ?>
                                    <td><?php echo e(trans('site.no_options_meal')); ?></td>
                                    <td></td>
                                <?php endif; ?>
                                
                              </tr>
                              
                              <tr>
                              <th scope="row" class="font-body-md"><?php echo e(trans('site.adds')); ?></th>
                                <?php if(count($meal->options) > 0): ?>
                                <td>
                                    <div class="mr-4">
                                        <?php $__currentLoopData = $meal->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        
                                            <div class="custom-control custom-checkbox">
                                                <input
                                                        type="checkbox"
                                                        class="options_select custom-control-input"
                                                        value="<?php echo e($option->id); ?>"
                                                        id="option_customCheck<?php echo e($key + 1); ?>"
                                                        
                                                >
                                                <label class="custom-control-label text-gray mb-2" for="option_customCheck<?php echo e($key + 1); ?>"><?php echo e($option->ar_name); ?></label>
                                            </div>
                                        
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </td>
                                <td class="text-primary font-body-md ">
                                    
                                    <?php $__currentLoopData = $meal->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $options): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="mb-2">
                                            <?php echo e($options->added_price); ?> <?php echo e(trans('site.riyal')); ?>

                                        </div> 
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                                <?php else: ?>
                                    <td><?php echo e(trans('site.no_adds_meal')); ?></td>
                                    <td></td>
                                <?php endif; ?>
                                
                              </tr>
                              
                            </tbody>
                          </table>
                        </div>
                    </div>

                    <div class="modal fade"
                         id="confirm-clear-cart"
                         tabindex="-1"
                         role="dialog"
                         aria-labelledby="exampleModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content py-3">
                                <p class="modal-body h4 font-weight-bold text-center mb-auto">
                                    <?php echo e(trans('site.cart_note')); ?>

                                </p>
                                <div class="modal-footer d-flex justify-content-center pt-0">
                                    <button type="button"
                                            class="btn btn-primary px-4 px-sm-5 ml-3 font-weight-bold"
                                            data-dismiss="modal"><?php echo e(trans('site.cancel')); ?></button>
                                    <a type="submit"
                                       onclick="decreaseValue()"
                                       class="btn btn-primary px-4 px-sm-5 font-weight-bold"><?php echo e(trans('site.delete_cart_content')); ?></a>

                                    <a type="submit"
                                       onclick="<?php echo e(url('/user/cart')); ?>"
                                       class="btn btn-default px-4 px-sm-5 font-weight-bold"><?php echo e(trans('site.view_cart')); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if(auth('web')->user() && $meal->accept_order == "1"): ?>
                    <div class="p-3 rounded-lg shadow-around mt-4 d-flex bg-white justify-content-center flex-column flex-sm-row">
                        <label class="col-lg-6 co-md-4 col-xl-7 font-body-md"><?php echo e(trans('site.amount')); ?></label>
                        <span class="count-buttom d-inline-flex px-0">
                            <button onclick="decreaseValue()"  class="col min d-flex flex-column align-items-start"> - </button>
                            <span id="number" class="col counter d-flex flex-column align-items-center">
                                0
                                
                            </span>
                            <button onclick="increaseValue()" class="col max d-flex flex-column align-items-end"> + </button>
                        </span>
                        <input type="hidden" value="<?php echo e($meal->id); ?>" id="meal_id" />
                        <input type="hidden" value="<?php echo e($clearing_cart_content_warning); ?>" id="clear_cart_alert" />
                        <input type="hidden" value="<?php if(count($meal->sizes) > 0): ?> 1 <?php else: ?> 0 <?php endif; ?>" id="meal_has_sizes" />
                        <input type="hidden" value="<?php echo e(url('/user/cart/check-cart-content')); ?>" id="check_cart_content_url" />
                        <input type="hidden" value="<?php echo e(url('/user/cart/add')); ?>" id="add_cart_meal" />
                        <!-- <button type="submit" class="btn btn-primary font-body-bold px-lg-3 px-md-4 px-sm-5 d-sm-inline-block d-block mr-sm-3 mt-2 mt-sm-auto">
                                شراء (15 ر.س)
                        </button> -->

                        
                        <!--For test-->
                        <a href="<?php echo e(url('/user/cart')); ?>" class="btn btn-primary font-body-bold px-lg-3 px-md-4 px-sm-5 d-sm-inline-block d-block mr-sm-3 mt-2 mt-sm-auto">
                             <?php echo e(trans('site.buy')); ?>

                            (<span class="total_price_span">
                                
                                0
                            </span>
                              (<?php echo e(trans('site.riyal')); ?>)
                        </a><!--For test-->
                    </div>
                    <?php if($clearing_cart_content_warning == 1): ?>

                        <div class="alert alert-warning">
                            
                            <?php echo e(trans('site.cart_not2')); ?>

                            <a style="color: blue;text-decoration: underline" href="<?php echo e(url('/user/cart')); ?>"><?php echo e(trans('site.view_cart')); ?></a>
                        </div>

                    <?php endif; ?>
                    <?php endif; ?>

                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('Site.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>