<?php $__env->startSection('title'); ?>
    <?php echo e($title); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('class'); ?>
    <?php echo e($class); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection("content"); ?>
<main class="main-content page-content py-5">
    <div class="container">

        <div class="row">

            <?php echo $__env->make("Provider.pages.menu", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <div class="col-lg-9 col-md-8 col-12 mt-4 mt-md-0">

                <div class="py-2 pr-3 rounded-lg shadow-around">
                    <h4 class="page-title font-body-bold"><?php echo e(trans('site.add_branch')); ?> </h4>
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

                <div class="rounded-lg shadow-around mt-4 overflow-hidden">

                    <ul class="nav nav-tabs pr-lg-3 pr-0 flex-lg-row flex-md-column flex-sm-row flex-column text-center"
                        id="new-branch-tabs"
                        role="tablist">
                        <li class="nav-item">
                            <a class="nav-link pb-3 font-body-bold active"
                               id="info-tab"
                               data-toggle="tab"
                               href="#branch-info"
                               role="tab"
                               aria-controls="branch-info"
                               aria-selected="true">
                               <?php echo e(trans('site.branch_info')); ?>

                            </a>
                        </li><!-- .nav-item -->

                        <li class="nav-item">
                            <a class="nav-link pb-3 font-body-bold"
                               id="work-tab"
                               data-toggle="tab"
                               href="#work"
                               role="tab"
                               aria-controls="work"
                               aria-selected="false">
                               <?php echo e(trans('site.work_hours')); ?>

                            </a>
                        </li><!-- .nav-item -->

                        <li class="nav-item">
                            <a class="nav-link pb-3 font-body-bold"
                               id="cats-tab"
                               data-toggle="tab"
                               href="#category"
                               role="tab"
                               aria-controls="category"
                               aria-selected="false">
                               <?php echo e(trans('site.existing_cats')); ?>

                            </a>
                        </li><!-- .nav-item -->

                    </ul><!-- .nav-tabs -->

                    <div class="tab-content" id="new-branch-tabs-content">

                        <div class="tab-pane info-content fade show active"
                             id="branch-info"
                             role="tabpanel"
                             aria-labelledby="info-tab">
                            <form data-action="<?php echo e(url('/restaurant/branches/new-branch')); ?>" id="new-banch-form" class="new-branch-form multi-forms p-3 font-body-bold">

                                <div class="form-group">
                                    <p><?php echo e(trans('site.branch_photos')); ?></p>
                                    <div class="custom-file h-auto">
                                        <input type="file" class="custom-file-input" id="restaurant-logo" hidden>
                                        <label class="border-0 mb-0 cursor" for="restaurant-logo">
                                        <span class="d-inline-block border-gray rounded p-4">
                                            <i class="fa fa-plus fa-fw fa-lg text-gray" aria-hidden="true"></i>
                                        </span>
                                        </label>
                                        <p id="branch-images-error" class="hidden-element alert alert-danger top-margin"><?php echo e(trans('site.choose_branch_photos')); ?></p>
                                    </div>
                                </div><!-- .form-group logo -->

                                <div class="top-margin add-meal-images row">

                                </div>

                                <div class="form-group">
                                    <label for="branch-name"><?php echo e(trans('site.branch_name_ar')); ?></label>
                                    <input type="text"
                                           name="ar_name"
                                           class="form-control border-gray font-body-md"
                                           id="branch-name" required>
                                </div><!-- .form-group name -->


                                <div class="form-group">
                                    <label for="branch-name"><?php echo e(trans('site.branch_name_en')); ?></label>
                                    <input type="text"
                                           name="en_name"
                                           class="form-control border-gray font-body-md"
                                           id="branch-name" required>
                                </div><!-- .form-group name -->

                                <div class="form-group">
                                    <label for="service-provider"><?php echo e(trans('site.branch_type')); ?></label>
                                    <select class="custom-select text-gray font-body-md" name="service-provider" id="service-provider" required>
                                        <option value=""><?php echo e(trans('site.choose_branch_type')); ?></option>

                                        <?php  $name = LaravelLocalization::getCurrentLocale()."_name"?>


                                        <?php $__currentLoopData = $cats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($cat->id); ?>"><?php echo e($cat-> $name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div><!-- .form-group service provider -->

                                <div class="form-group">
                                    <p><?php echo e(trans('site.services_available')); ?></p>
                                    <div class="row pr-4 text-gray font-body-md">

                                        <div class="custom-control custom-checkbox pl-0 col-md-4 col-12 mb-2">
                                            <input type="checkbox"
                                                   class="custom-control-input"
                                                   id="has-booking"
                                                   name="has-booking">
                                            <label class="custom-control-label font-body-md"
                                                  for="has-booking"><?php echo e(trans('site.accept_resservations')); ?></label>
                                        </div><!-- .custom-control -->

                                        <div class="custom-control custom-checkbox pl-0 col-md-4 col-12 mb-2">
                                            <input type="checkbox"
                                                   class="custom-control-input"
                                                   id="has-delivery" name="has-delivery">
                                            <label class="custom-control-label font-body-md"
                                                   for="has-delivery"><?php echo e(trans('site.delivery_orders')); ?></label>
                                        </div><!-- .custom-control -->
                                        
                                        
                                        <div class="custom-control custom-checkbox pl-0 col-md-4 col-12 mb-2">
                                            <input type="checkbox"
                                                   class="custom-control-input"
                                                   id="has_payment" name="has_payment">
                                            <label class="custom-control-label font-body-md"
                                                   for="has_payment"><?php echo e(trans('site.elect_payment')); ?></label>
                                        </div><!-- .custom-control -->


                                    </div>
                                </div><!-- .form-group available service -->

                                <div class="form-group">
                                    <label for="average-price"><?php echo e(trans('site.delivery_price')); ?></label>
                                    <div class="input-group rounded border border-gray overflow-hidden">
                                        <input type="text"
                                               id="delivery-price"
                                               name="delivery-price"
                                               class="form-control border-0 font-body-md rounded-0"
                                               aria-describedby="average-price-addon">



                                        <div class="input-group-prepend">
                                        <span id="average-price-addon"
                                              class="input-group-text bg-white border-0 font-body-md text-gray"><?php echo e(trans('site.riyal')); ?>

                                        </span>
                                        </div><!-- .input-group-prepend -->
                                    </div><!-- .input-group -->

                                    <p class="delivery-price-error top-margin alert alert-danger hidden-element"></p>
                                </div><!-- .form-group average-price -->

                                <div class="form-group">
                                    <label for="booking-features"><?php echo e(trans('site.booking_features')); ?></label>
                                    <select class="custom-select text-gray font-body-md border-gray"
                                            id="booking-features" name="booking-features" required>
                                        <option value=""><?php echo e(trans('site.choose_booking_features')); ?></option>

                                        <option value="0"><?php echo e(trans('site.persons')); ?></option>
                                        <option value="1"><?php echo e(trans('site.famlies')); ?></option>
                                        <option value="2"><?php echo e(trans('site.person_family')); ?></option>
                                    </select>
                                </div><!-- .form-group booking-features -->

                                <div class="form-group">
                                    <label for="congestion-status"><?php echo e(trans('site.congestion_status')); ?></label>
                                    <select class="custom-select text-gray font-body-md border-gray"
                                            id="congestion-status" name="congestion-status" required>
                                         <option value=""><?php echo e(trans('site.choose_congestion_status')); ?> </option>
                                        <?php $__currentLoopData = $congestion; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($c->id); ?>"><?php echo e($c->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div><!-- .form-group congestion-status -->

                                <div class="form-group">
                                     <label for="average-price"><?php echo e(trans('site.average_price')); ?></label>
                                    <div class="input-group rounded border border-gray overflow-hidden">
                                        <input type="text"
                                               id="average-price"
                                               name="average-price"
                                               class="form-control border-0 font-body-md rounded-0"
                                               aria-describedby="average-price-addon" required>



                                        <div class="input-group-prepend">
                                        <span id="average-price-addon"
                                              class="input-group-text bg-white border-0 font-body-md text-gray"> <?php echo e(trans('site.riyal')); ?>

                                        </span>
                                        </div><!-- .input-group-prepend -->
                                    </div><!-- .input-group -->
                                    <p class="average-price-error top-margin alert alert-danger hidden-element"></p>
                                </div><!-- .form-group average-price -->

                                <div class="form-group">
                                    <p> <?php echo e(trans('site.branch_properties')); ?></p>
                                    <div class="row pr-4 text-gray font-body-md">

                                        <input type="hidden" name="options_count" value="<?php echo e(count($options)); ?>" />
                                        <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="custom-control custom-checkbox pl-0 col-lg-4 col-12 mb-2">
                                                <input type="checkbox"
                                                       class="options custom-control-input"
                                                       id="option_<?php echo e($option->id); ?>"
                                                       data="<?php echo e($option->id); ?>"
                                                       name="option_<?php echo e($option->id); ?>">
                                                <label class="custom-control-label font-body-md"
                                                       for="option_<?php echo e($option->id); ?>"><?php echo e($option->name); ?></label>
                                            </div><!-- .custom-control -->
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div><!-- .row -->
                                </div><!-- .form-group branch-features -->


                                <div class="form-group">
                                    <label for="address-text">
                                         <?php echo e(trans('site.branch_address_text')); ?>

                                    </label>
                                    <input type="text"
                                           class="form-control border-gray font-body-md"
                                           id="address-text"
                                           name="address-text" placeholder="الحى - الشارع - المبنى" required>
                                </div><!-- .form-group address-text -->

                                <div class="form-group">
                                    <label for="address-map"
                                           class="font-body-bold"><?php echo e(trans('site.branch_on_map')); ?></label>
 

                                    <div class="d-flex justify-content-center flex-column flex-sm-row">
                                        <input type="text"
                                               class="form-control border-gray"
                                               id="address-map" disabled>

                                        <input type="hidden"
                                               name="latLng"
                                               id="branch-latLng" />

                                        <input type="hidden"
                                               name="lat"
                                               id="branch-lat" />
                                        <input type="hidden"
                                               name="lng"
                                               id="branch-lng" />

                                        <button
                                            type="button"
                                            data-toggle="modal"
                                            data-target="#confirm-location"
                                            id="new-branch-map-btn"
                                            class="btn btn-primary font-body-bold px-lg-5 px-md-4 px-sm-5 d-sm-inline-block d-block mr-sm-3 mt-2 mt-sm-auto"> <?php echo e(trans('site.go_to_map')); ?></button>
                                    </div>
                                    <p class="branch-location-error alert alert-danger top-margin hidden-element"></p>
                                </div><!-- .form-group address-map -->

                                <div class="form-group">
                                    <label for="phone-number">
                                       <?php echo e(trans('site.branch_phone')); ?>

                                        <span class="text-gray font-body-md">
                                                 (<?php echo e(trans('site.used_for_login')); ?>)
                                            </span>
                                    </label>
                                    <input type="text"
                                           class="form-control border-gray"
                                           id="phone-number" name="phone-number" placeholder="05XXXXXXXX" required>
                                    <p class="phone-number-error top-margin alert alert-danger hidden-element"></p>
                                </div><!-- .form-group phone-number -->

                                <div class="form-group">
                                    <label for="password"><?php echo e(trans('site.password')); ?></label>
                                    <input type="password"
                                           class="form-control border-gray"
                                           id="password" name="password" required>
                                </div><!-- .form-group password -->
                                <p class="password-error  alert alert-danger top-margin hidden-element"></p>

                                <button type="submit" id="branch_submit_from_btn" class="btn btn-primary py-2 px-5"> <?php echo e(trans('site.next')); ?></button>
                         
                            </form><!-- .new-kind-form -->
                        </div><!-- .tab-pane -->

                        <div class="tab-pane working-hours-content fade p-3 font-body-bold"
                             id="work"
                             role="tabpanel"
                             aria-labelledby="work-tab">
                            <p id="working-hours-error" class="alert alert-danger top-margin hidden-element"> <?php echo e(trans('site.choose_work_hours')); ?> </p>
                            
                            
                             
            <?php if(isset($branches) && $branches -> count() > 0 ): ?>
             
                 <div class="col-lg-6 col-12 mt-3 mt-lg-auto">
                    <div class="row">
                        <label for=""
                               class="col-form-label col-auto"> <?php echo e(trans('site.get_times_from')); ?>:</label>
                        <div class="col pr-md-0">
                            <select id="autoCompeletTimes" class="working-hours custom-select text-gray font-body-md border-gray">
                                <option value="">   <?php echo e(trans('site.choose_branch')); ?> </option>

                                 <?php $br_name = LaravelLocalization::getCurrentLocale()."_name"?>
                                 
                                  <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                   <option value="<?php echo e($branch -> id); ?>"> <?php echo e($branch -> $br_name); ?> </option>
                                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>    
                                   
                             </select>
                        </div>
                    </div>
                </div>
            
            
            
        <br>
        
       <?php echo e(trans('site.or_manually')); ?>

        
        
        <br>
        
        <?php endif; ?>
            
            
                                            
                            <form class="work-times">
                                
                                


                                
                                    
                                        
                                        
                                            
                                                
                                                    
                                                           
                                                    
                                                        
                                                                
                                                            
                                                            
                                                        
                                                    
                                                
                                            
                                            
                                                
                                                    
                                                           
                                                    
                                                        
                                                                
                                                            
                                                            
                                                        
                                                    
                                                
                                            
                                        
                                    
                                

                                <?php $__currentLoopData = $week_days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <?php
                                        $start_time = null;
                                        $end_time = null;
                                    ?>
                                    <?php $__env->startComponent('User.includes.working-time'); ?>

                                        <?php $__env->slot('en_name'); ?>
                                            <?php echo e($key); ?>

                                        <?php $__env->endSlot(); ?>

                                        <?php $__env->slot('ar_name'); ?>
                                            <?php echo e($value); ?>

                                        <?php $__env->endSlot(); ?>
                                        <?php $__env->slot("start_time"); ?>
                                            <?php echo e($start_time); ?>

                                        <?php $__env->endSlot(); ?>
                                        <?php $__env->slot("end_time"); ?>
                                            <?php echo e($end_time); ?>

                                        <?php $__env->endSlot(); ?>
                                    <?php echo $__env->renderComponent(); ?>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                
                                    
                                        
                                        
                                            
                                                
                                                    
                                                           
                                                    
                                                        
                                                                
                                                            
                                                            
                                                        
                                                    
                                                
                                            
                                            
                                                
                                                    
                                                           
                                                    
                                                        
                                                                
                                                            
                                                            
                                                        
                                                    
                                                
                                            
                                        
                                    
                                

                                
                                    
                                        
                                        
                                            
                                                
                                                    
                                                           
                                                    
                                                        
                                                                
                                                            
                                                            
                                                        
                                                    
                                                
                                            
                                            
                                                
                                                    
                                                           
                                                    
                                                        
                                                                
                                                            
                                                            
                                                        
                                                    
                                                
                                            
                                        
                                    
                                

                                
                                    
                                        
                                        
                                            
                                                
                                                    
                                                           
                                                    
                                                        
                                                                
                                                            
                                                            
                                                        
                                                    
                                                
                                            
                                            
                                                
                                                    
                                                           
                                                    
                                                        
                                                                
                                                            
                                                            
                                                        
                                                    
                                                
                                            
                                        
                                    
                                

                                
                                    
                                        
                                        
                                            
                                                
                                                    
                                                           
                                                    
                                                        
                                                                
                                                            
                                                            
                                                        
                                                    
                                                
                                            
                                            
                                                
                                                    
                                                           
                                                    
                                                        
                                                                
                                                            
                                                            
                                                        
                                                    
                                                
                                            
                                        
                                    
                                

                                
                                    
                                        
                                        
                                            
                                                
                                                    
                                                           
                                                    
                                                        
                                                                
                                                            
                                                            
                                                        
                                                    
                                                
                                            
                                            
                                                
                                                    
                                                           
                                                    
                                                        
                                                                
                                                            
                                                            
                                                        
                                                    
                                                
                                            
                                        
                                    
                                

                                
                                    
                                        
                                        
                                            
                                                
                                                    
                                                           
                                                    
                                                        
                                                                
                                                            
                                                            
                                                        
                                                    
                                                
                                            
                                            
                                                
                                                    
                                                           
                                                    
                                                        
                                                                
                                                            
                                                            
                                                        
                                                    
                                                
                                            
                                        
                                    
                                

                                
                                    
                                        
                                        
                                            
                                                
                                                    
                                                           
                                                    
                                                        
                                                                
                                                            
                                                            
                                                        
                                                    
                                                
                                            
                                            
                                                
                                                    
                                                           
                                                    
                                                        
                                                                
                                                            
                                                            
                                                        
                                                    
                                                
                                            
                                        
                                    
                                

                                <button type="button" class="prev-work btn btn-primary py-2 px-5"> <?php echo e(trans('site.previous')); ?></button>
                                <button type="button" class="next-cats btn btn-default py-2 px-5"> <?php echo e(trans('site.next')); ?></button>
                            </form>

                        </div><!-- .tab-pane -->

                        <div class="tab-pane cat-content fade"
                             id="category"
                             role="tabpanel"
                             aria-labelledby="cats-tab">
                            <form>
                            <div class="table-responsive bg-light">

                                <table class="table">
                                    <thead class="font-body-bold">
                                    <tr>
                                        <th scope="col"> <?php echo e(trans('site.meal_name')); ?></th>
                                        <th scope="col"><?php echo e(trans('site.category')); ?></th>
                                        <th scope="col"><?php echo e(trans('site.control')); ?></th>
                                    </tr>
                                    </thead>

                                    <tbody class="font-body-md text-gray border-bottom bg-white">

                                    <?php $__currentLoopData = $meals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $meal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <th scope="row" class="font-body-md text-nowrap"><?php echo e($meal->meal_name); ?></th>
                                            <td class="text-nowrap"><?php echo e($meal->cat_name); ?></td>
                                            <td class="text-nowrap">

                                                <div class="custom-control custom-checkbox pl-0 col-md-4 col-12 mb-2">
                                                    <input type="checkbox"
                                                           class="branch-meal custom-control-input"
                                                           id="meal_<?php echo e($meal->meal_id); ?>"
                                                           data="<?php echo e($meal->meal_id); ?>"
                                                           name="meal_<?php echo e($meal->meal_id); ?>">
                                                    <label class="custom-control-label font-body-md"
                                                           for="meal_<?php echo e($meal->meal_id); ?>">   <?php echo e(trans('site.add_to_the_branch')); ?>  </label>
                                                </div><!-- .custom-control -->

                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>

                            </div>
                            
                                 
                                
                                    
                                        
                                           
                                    
                                    
                                        
                                           
                                    
                                    
                                        
                                           
                                    
                                    
                                    
                                        
                                           
                                    
                                
                            
                            
                            <button type="button" class="top-margin prev-final-cat btn btn-primary py-2 px-5"><?php echo e(trans('site.previous')); ?></button>
                            
                            <button type="button" id="save_branch" class="top-margin btn btn-primary py-2 px-5"><?php echo e(trans('site.save')); ?></button>
                             
                            </form>
                        </div><!-- .tab-pane -->

                    </div><!-- .tab-content -->


                </div>

            </div><!-- .col-* -->
        </div><!-- .row -->

    </div><!-- .container -->

</main><!-- .page-content -->

<main id="map-content" class="hidden-element map-content page-content py-5">

    <header class="page-header mt-4 text-center">
        <h1 class="page-title h2 font-body-bold"><?php echo e(trans('site.dete_locations')); ?></h1>
        <p class="description text-gray font-body-md mt-3"><?php echo e(trans('site.branch_on_map')); ?></p>
        
    </header>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-sm-10 col-12 mx-auto font-body-bold mb-5 text-center">
                <div class="embed-responsive embed-responsive-16by9 my-4 shadow-bottom">

                    <div id="map" class="embed-responsive-item"></div>

                </div>

                <Button type="button" id="confirm-branch-location"  class="btn btn-primary px-5 no-decoration"> <?php echo e(trans('site.current_location')); ?></Button>
                <Button type="button" id="decline-branch-location" class="btn btn-default px-5 no-decoration"><?php echo e(trans('site.back')); ?> </Button>

            </div><!-- .col-* -->
        </div><!-- .row -->
    </div><!-- .container -->
</main><!-- .page-content -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

   

<!--    <script src="<?php echo e(asset("/assets/site/js/new-branch-location.js")); ?>"></script>   -->
    <script src="<?php echo e(asset("/assets/site/js/new-branch2.js")); ?>"></script>
    
   
        


    
    <script>


	$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


   $(document).on('change','#autoCompeletTimes',function(){
       
       var branch_id = this.value;
        if(branch_id){
     
 
        $.ajax({
   	  	  
   	  	  url:  '/restaurant/branches/getTimeFromOtherBranch/'+branch_id,
   	  	  
   	  	  data:{

           'id'      : branch_id,
           'type'    : 'create'
   	  	  } ,
           type: 'post',
   	  	  success:function(data){
                  
                $('.work-times').empty().append(data.content);
                
                if(data.content == null){
                    
                    
                     alert('الفرع غير موجود');
                }
                
 
   	  	  },
   	  	  error:function(reject){
   	  	      
   	  	      alert('فشل في جلب ساعات العمل الرجاء ادخال الاوقات يدويا ');
                
    	  	  }
         
        });

      
       
        }
   });
   
   
    $(document).on('click','#save_branch',function(){
        
            
              $('#branch_submit_from_btn').trigger('click'); 
    });
    
    
      $("#map" ).click(function() {
       $("#confirm-branch-location" ).text( "متابعه" );
    });
         
         
       $(document).ready(function(){

                   var map, infoWindow , marker ,geocoder;
                    
                var messagewindow;
                var markers = [];

                var prevlat;
                var prevLng

                var SelectedLatLng = "";
                var SelectedLocation = "";
                 prevlat = -34.397;
                 prevLng = 150.6444;


                    if($("#branch-latLng").val() != ""){
                        prevlat = parseFloat($("#branch-lat").val());
                        prevLng = parseFloat($("#branch-lng").val());
                    }else{
                        prevlat = -34.397;
                        prevLng = 150.6444;
                    }



       });
            
  




    $("#new-branch-map-btn, #complete-order-location-btn").on("click", function () {
        $(".main-content").addClass("hidden-element");
        $(".map-content").removeClass("hidden-element");

        window.scrollTo(0,200);


       

    });

    $("#decline-branch-location, #decline-user-location").on("click", function () {
        $(".main-content").removeClass("hidden-element");
        $(".map-content").addClass("hidden-element");

        if($(this).attr("id") == "decline-branch-location"){
            window.scrollTo(0,1600);
        }else{
            window.scrollTo(0,0);
        }


    });

    $("#confirm-branch-location, #confirm-user-location").on("click", function () {

        if(SelectedLatLng == ""){
            notif({
                msg: "برجاء تحديد الموقع",
                type: "warning"
            });
            return false;
        }

        

        $(".main-content").removeClass("hidden-element");
        $(".map-content").addClass("hidden-element");

        if($(this).attr("id") == "decline-branch-location"){
            window.scrollTo(0,1600);
        }else{
            window.scrollTo(0,0);
        }

    });
  

  function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: parseFloat(prevlat), lng: parseFloat(prevLng)},
            zoom: 6
        });
        

        console.log('dfdf'+prevlat);
          infoWindow = new google.maps.InfoWindow;
          geocoder = new google.maps.Geocoder();

        // Try HTML5 geolocation.

        if($("#branch-latLng").val() === ""){
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    //infoWindow.setPosition(pos);
                   // infoWindow.setContent('Location found.');
                   // infoWindow.open(map);
                    map.setCenter(pos);
                    
                     var marker = new google.maps.Marker({
                            position: new google.maps.LatLng(pos),
                              
                            map: map,
                            title: 'موقعك الحالي'
                        });
                         
                         
                         markers.push(marker);
                         
                         
                      marker.addListener('click', function() {
                           
                                 
                                geocodeLatLng(geocoder, map, infoWindow,marker);
                                
                                
                        });
        
  
                        // to get current position address on load 
                        google.maps.event.trigger(marker, 'click');
                        
                        
                        
                        
                }, function() {
                    handleLocationError(true, infoWindow, map.getCenter());
                });
            } else {
                // Browser doesn't support Geolocation
                handleLocationError(false, infoWindow, map.getCenter());
            }
        }

        //addMarker(parseInt($(".shipping-latLng").val()));
        var geocoder = new google.maps.Geocoder();

        if($("#branch-latLng").val() !== ""){
            addMarker( "(" + parseInt($('#branch-lat').val()) + "," + parseInt($('#branch-lng').val()) +")");
        }else{

            google.maps.event.addListener(map, 'click', function(event) {
                SelectedLatLng = event.latLng;
                geocoder.geocode({
                    'latLng': event.latLng
                }, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        
                          if (results[0]) {
                            deleteMarkers();
                            addMarkerRunTime(event.latLng);
                            SelectedLocation = results[0].formatted_address;
                            
                            console.log( results[0].formatted_address);
                            splitLatLng(String(event.latLng));
                             $("#address-map").val(results[0].formatted_address); 
                           
                        }
                        
                    }
                });
            });

        }


     //used only to get current position address name 

        function geocodeLatLng(geocoder, map, infowindow,markerCurrent) {
          
           
         var latlng = {lat: markerCurrent.position.lat(), lng: markerCurrent.position.lng()};
         
             
             $('#branch-latLng').val("("+markerCurrent.position.lat() +","+markerCurrent.position.lng()+")");
             $('#branch-lat').val(markerCurrent.position.lat());
             $('#branch-lng').val(markerCurrent.position.lng());
            
            
            geocoder.geocode({'location': latlng}, function(results, status) {
              if (status === 'OK') {
                if (results[0]) {
                  map.setZoom(8);
                  var marker = new google.maps.Marker({
                    position: latlng,
                    map: map
                  });
                  
                   markers.push(marker);
                   
                  infowindow.setContent(results[0].formatted_address);
                   SelectedLocation = results[0].formatted_address;
                  
                  $("#address-map").val(results[0].formatted_address); 
                  
                  infowindow.open(map, marker);
                } else {
                  window.alert('No results found');
                }
              } else {
                window.alert('Geocoder failed due to: ' + status);
              }
            });
        
        
        SelectedLatLng =(markerCurrent.position.lat(),markerCurrent.position.lng());
       
      }
      
      
        
       function DeleteMarkers() {
        //Loop through all the markers and remove
        for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(null);
        }
        markers = [];
    };
    
    

        function addMarker(location) {
            // var marker = new google.maps.Marker({
            //     position: location,
            //     map: map
            // });

            var marker = new google.maps.Marker({
                position: new google.maps.LatLng( parseInt($("#latitude").val()),parseInt($("#longitude").val())),
                map: map,
                title: $("#branch_name").val()
            });

            var contentString = '<div id="content" style="width: 200px; height: 200px;"><h1>Overlay</h1></div>';
            var infowindow = new google.maps.InfoWindow({
                content: contentString
            });

            google.maps.event.addListener(map, 'click', function(event) {
                SelectedLatLng = event.latLng;
                geocoder.geocode({
                    'latLng': event.latLng
                }, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            deleteMarkers();
                            addMarkerRunTime(event.latLng);
                            SelectedLocation = results[0].formatted_address;
                            
                             splitLatLng(String(event.latLng));
                            $("#branch-latlng").val(SelectedLatLng);
                            $("#address-map").val(SelectedLocation);
                            
                        }
                    }
                    
                    
                    
                });
            });

            // To add the marker to the map, call setMap();
            marker.setMap(map);

        }



        function addMarkerRunTime(location) {
            var marker = new google.maps.Marker({
                position: location,
                map: map
            });
            markers.push(marker);
        }

        function setMapOnAll(map) {
            for (var i = 0; i < markers.length; i++) {
                markers[i].setMap(map);
            }
        }

        function clearMarkers() {
            setMapOnAll(null);
        }

         function deleteMarkers() {
            clearMarkers();
            markers = [];
        }

    }

    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
            'Error: The Geolocation service failed.' :
            'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(map);
    }

    function splitLatLng(latLng){

        var newString = latLng.substring(0, latLng.length-1);
        var newString2 = newString.substring(1);
        var trainindIdArray = newString2.split(',');
        var lat = trainindIdArray[0];
        var Lng  = trainindIdArray[1];

        $("#branch-lat").val(lat);
        $("#branch-lng").val(Lng);
    }
         
    </script>
    



    <script>
        $(".next-working-hours").on("click", function(){
            $("#work-tab").addClass("active show");
            $(".working-hours-content").addClass("active show");
            
            $("#info-tab").removeClass("active show");
            $(".info-content").removeClass("active show");
            
            window.scrollTo(0, 0);
        });
        
        $(".prev-work").on("click", function(){
            $("#info-tab").addClass("active show");
            $(".info-content").addClass("active show");
            
            $("#work-tab").removeClass("active show");
            $(".working-hours-content").removeClass("active show");
            
            window.scrollTo(0, 0);
        });
        
        $(".next-cats").on("click", function(){
            $("#cats-tab").addClass("active show");
            $(".cat-content").addClass("active show");
            
            $("#work-tab").removeClass("active show");
            $(".working-hours-content").removeClass("active show");
            
            window.scrollTo(0, 0);
        });
        
        $(".prev-final-cat").on("click", function(){
            $("#cats-tab").removeClass("active show");
            $(".cat-content").removeClass("active show");
            
            $("#work-tab").addClass("active show");
            $(".working-hours-content").addClass("active show");
            
            window.scrollTo(0, 0);
        });
    </script>


  <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDKZAuxH9xTzD2DLY2nKSPKrgRi2_y0ejs&language=ar&callback=initMap">
    </script>
    
<?php $__env->stopSection(); ?>
<?php echo $__env->make("Provider.layouts.master", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>