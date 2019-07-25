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

                <div class="col-lg-9 col-md-8 col-12 mt-4 mt-md-0 font-body-bold">


                   <?php if(Session::has("error_no_file")): ?>
                        <div class="alert alert-danger top-margin">
                            <?php echo e(Session::get("error_no_file")); ?>

                        </div>
                    <?php endif; ?>


                    <div class="py-2 pr-3 rounded-lg shadow-around">
                        <h4 class="page-title"> <?php echo e(trans('site.new_meal')); ?></h4>
                    </div>
                    <div class="p-3 rounded-lg shadow-around mt-4">

                        <form data-action="<?php echo e(url("/restaurant/food-menu/add-new-meal")); ?>" id="add-meal-from" class="new-kind-form multi-forms">
                            <?php echo e(csrf_field()); ?>

                            <div class="form-group">
                                 
                             <a  href="<?php echo e(url("/restaurant/download-rules")); ?>">     
                                <label class="border-0 mb-0 cursor" >
                                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQl_iQ9tX59-heOF1cAF4BB5ndB8TUxJT_jtD6JUkdoV2WjEfRv" class="d-inline-block rounded-circle" width="86" height="86" >
                                    <span class="font-body-md mr-2 text-primary">
                                    
                                      <?php echo e(trans('site.download_guide')); ?>

                                        
                                      </span>
                                      
                                </label>
                                
                                </a>
                                
                            </div>
                            
                            <hr>
                            
                            <div class="form-group">
                                <p> <?php echo e(trans('site.meal_photo')); ?> <span class="text-gray font-body-md"><?php echo e(trans('site.photo_note')); ?></span></p>
                                <div class="custom-file h-auto">
                                    <input type="file" name="file" class="add-meal-image custom-file-input" id="restaurant-logo" hidden>
                                    <label class="border-0 mb-0 cursor" for="restaurant-logo">
                                        <span class="d-inline-block border-gray rounded p-4">
                                            <i class="fa fa-plus fa-fw fa-lg text-gray" aria-hidden="true"></i>
                                        </span>
                                    </label>
                                    <p id="meal-images-error" class="hidden-element alert alert-danger top-margin"><?php echo e(trans('site.choose_meal_photo')); ?></p>
                                </div>
                            </div><!-- .form-group logo -->

                            <div class="top-margin add-meal-images row">

                            </div>

                            <div class="form-group">
                                <label for="kind-name"><?php echo e(trans('site.ar_name')); ?></label>
                                <input type="text"
                                       class="form-control border-gray font-body-md"
                                       name="ar_name"
                                       id="kind-name" required>
                            </div><!-- .form-group name -->

                            <div class="form-group">
                                <label for="kind-name"><?php echo e(trans('site.en_name')); ?></label>
                                <input type="text"
                                       class="form-control border-gray font-body-md"
                                       name="en_name"
                                       id="kind-name" required>
                            </div><!-- .form-group name -->

                            <div class="form-group">
                                <label for="categorie"><?php echo e(trans('site.meal_categories')); ?></label>
                                <select class="custom-select text-gray font-body-md border-gray"
                                        id="categorie" name="category" required>
                                    <option value=""><?php echo e(trans('site.choose_category')); ?></option>
                                    <?php $__currentLoopData = $cats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <option value="<?php echo e($cat->id); ?>"><?php echo e($cat->name); ?></option>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div><!-- .form-group available -->


                            <div class="form-group">
                                <label for="categorie"><?php echo e(trans('site.branches_have_meal')); ?></label>
                                <select class="custom-select text-gray font-body-md border-gray"
                                        id="branch" name="branch" required>
                                    <option value=""><?php echo e(trans('site.choose_branches')); ?></option>
                                    <option value="0"><?php echo e(trans('site.in_all_branches')); ?></option>
                                    <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <option value="<?php echo e($branch->id); ?>"><?php echo e($branch->name); ?></option>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div><!-- .form-group available -->

                            <div class="form-group">
                                <label for="input-tags">
                                    <?php echo e(trans('site.ingredients')); ?>

                                    <span class="text-gray font-body-md">
                                        (<?php echo e(trans('site.ingredients_note')); ?>)
                                    </span>
                                </label>
                                <input type="text"
                                       name="component"
                                       id="input-tags" required>
                            </div><!-- .form-group tags -->

                            <div class="form-group">
                                <label for="available"><?php echo e(trans('site.available_all_time')); ?></label>
                                <select class="custom-select text-gray font-body-md border-gray"
                                        id="available" name="available" required>
                                    <option value=""> <?php echo e(trans('site.choose_status')); ?></option>
                                    <option value="1"><?php echo e(trans('site.yes')); ?></option>
                                    <option value="0"><?php echo e(trans('site.no')); ?></option>
                                </select>
                            </div><!-- .form-group available -->

                            <div class="form-group">
                                <label for="spicy"> <?php echo e(trans('site.spicy')); ?> </label>
                                <select class="custom-select text-gray font-body-md border-gray"
                                        id="spicy" name="spicy" required>
                                    <option value=""><?php echo e(trans('site.choose_status')); ?></option>
                                    <option value="1"><?php echo e(trans('site.yes')); ?></option>
                                    <option value="0"><?php echo e(trans('site.no')); ?></option>
                                </select>
                            </div><!-- .form-group spicy -->

                            <div class="spicy-degree-container form-group hidden-element">
                                <label for="spicy-degree"><?php echo e(trans('site.spicy_degree')); ?></label>
                                <input type="text"
                                       class="form-control border-gray font-body-md"
                                       name="spicy-degree"
                                       placeholder="<?php echo e(trans('site.value_from1_to5')); ?>"
                                       id="spicy-degree">
                            </div><!-- .form-group name -->

                            <div class="form-group">
                                <label for="vegetable"> <?php echo e(trans('site.suitable_for_vegetarians')); ?> </label>
                                <select class="custom-select text-gray font-body-md border-gray"
                                        id="vegetable" name="vegetable" required>
                                    <option value=""><?php echo e(trans('site.choose_status')); ?></option>
                                    <option value="1"><?php echo e(trans('site.yes')); ?></option>
                                    <option value="0"><?php echo e(trans('site.no')); ?></option>
                                </select>
                            </div><!-- .form-group vegetable -->

                            <div class="form-group">
                                <label for="gluten"><?php echo e(trans('site.gluten_free')); ?></label>
                                <select class="custom-select text-gray font-body-md border-gray"
                                        id="gluten" name="gluten" required>
                                    <option value=""><?php echo e(trans('site.choose_status')); ?></option>
                                    <option value="1"><?php echo e(trans('site.yes')); ?></option>
                                    <option value="0"><?php echo e(trans('site.no')); ?></option>
                                </select>
                            </div><!-- .form-group gluten -->

                            <div class="form-group">
                                <label for="calorie">
                                    <?php echo e(trans('site.number_of_calories')); ?>

                                    <span class="text-gray font-body-md"><?php echo e(trans('site.meduim_colaries')); ?></span>
                                </label>
                                <input type="text"
                                       class="form-control border-gray font-body-md"
                                       id="calorie"
                                       name="calorie" required>
                                <div id="meal-calorie-error" class="top-margin hidden-element alert alert-danger"></div>
                            </div><!-- .form-group calorie -->

                            <div class="form-group">
                                <label for="details"> <?php echo e(trans('site.description_ar')); ?><span class="text-gray font-body-md"><?php echo e(trans('site.min_5_words')); ?></span></label>
                                <textarea class="ar-details form-control font-body-md border-gray"
                                          id="details"
                                          name="ar_description"
                                          rows="6" required></textarea>
                                          
                                          <p id="ar-details-error" class="hidden-element alert alert-danger top-margin"> <?php echo e(trans('site.min_5_words')); ?> </p>

                            </div><!-- .form-group details -->


                            <div class="form-group">
                                <label for="details"><?php echo e(trans('site.description_en')); ?><span class="text-gray font-body-md"><?php echo e(trans('site.min_5_words')); ?></span></label>
                                <textarea class="en-details form-control font-body-md border-gray"
                                          id="details"
                                          name="en_description"
                                          rows="6" required></textarea>
                                          
                                           <p id="ثى-details-error" class="hidden-element alert alert-danger top-margin"> <?php echo e(trans('site.min_5_words')); ?></p>
                            </div><!-- .form-group details -->

                            <div class="row">
                                <div class="col-sm-6 col-12">
                                    <p><?php echo e(trans('site.sizes')); ?></p>
                                    <div class="form-group">
                                        <input type="text"
                                               id="size1"
                                               name="size1"
                                               class="form-control font-body-md border-gray" required>
                                    </div><!-- .form-group -->
                                    <div class="form-group">
                                        <input type="text"
                                               id="size2"
                                               name="size2"
                                               class="form-control font-body-md border-gray">
                                    </div><!-- .form-group -->
                                    <div class="form-group">
                                        <input type="text"
                                               id="size3"
                                               name="size3"
                                               class="form-control font-body-md border-gray">
                                    </div><!-- .form-group -->
                                    <div class="form-group">
                                        <input type="text"
                                               id="size4"
                                               name="size4"
                                               class="form-control font-body-md border-gray">
                                    </div><!-- .form-group -->
                                    <div class="form-group">
                                        <input type="text"
                                               id="size5"
                                               name="size5"
                                               class="form-control font-body-md border-gray">
                                    </div><!-- .form-group -->
                                </div><!-- .col -->
                                <div class="col-sm-6 col-12">

                                    <p><?php echo e(trans('site.price')); ?></p>

                                    <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                        <input type="text"
                                               id="price1"
                                               name="price1"
                                               pattern="^[0-9]+$"
                                               class="form-control border-0 font-body-md rounded-0"
                                               aria-describedby="price-addon" required>
                                        <div class="input-group-prepend">
                                        <span id="price1-addon"
                                              class="input-group-text bg-white border-0 font-body-md text-gray"><?php echo e(trans('site.riyal')); ?>

                                        </span>
                                        </div><!-- .input-group-prepend -->
                                    </div><!-- .input-group -->

                                    <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                        <input type="text"
                                               id="price2"
                                               name="price2"
                                               pattern="^[0-9]+$"
                                               class="form-control border-0 font-body-md rounded-0"
                                               aria-describedby="price-addon">
                                        <div class="input-group-prepend">
                                        <span id="price2-addon"
                                              class="input-group-text bg-white border-0 font-body-md text-gray"> <?php echo e(trans('site.riyal')); ?>

                                        </span>
                                        </div><!-- .input-group-prepend -->
                                    </div><!-- .input-group -->

                                    <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                        <input type="text"
                                               id="price3"
                                               name="price3"
                                               pattern="^[0-9]+$"
                                               class="form-control border-0 font-body-md rounded-0"
                                               aria-describedby="price-addon">
                                        <div class="input-group-prepend">
                                        <span id="price3-addon"
                                              class="input-group-text bg-white border-0 font-body-md text-gray"> <?php echo e(trans('site.riyal')); ?>

                                        </span>
                                        </div><!-- .input-group-prepend -->

                                    </div><!-- .input-group -->

                                    <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                        <input type="text"
                                               id="price4"
                                               name="price4"
                                               pattern="^[0-9]+$"
                                               class="form-control border-0 font-body-md rounded-0"
                                               aria-describedby="price-addon">
                                        <div class="input-group-prepend">
                                        <span id="price4-addon"
                                              class="input-group-text bg-white border-0 font-body-md text-gray"> <?php echo e(trans('site.riyal')); ?>

                                        </span>
                                        </div><!-- .input-group-prepend -->
                                    </div><!-- .input-group -->

                                    <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                        <input type="text"
                                               id="price5"
                                               pattern="^[0-9]+$"
                                               name="proice5"
                                               class="form-control border-0 font-body-md rounded-0"
                                               aria-describedby="price-addon">
                                        <div class="input-group-prepend">
                                        <span id="price5-addon"
                                              class="input-group-text bg-white border-0 font-body-md text-gray"> <?php echo e(trans('site.riyal')); ?>

                                        </span>
                                        </div><!-- .input-group-prepend -->
                                    </div><!-- .input-group -->

                                </div><!-- .col -->
                            </div>


                            <div class="row">
                                <div class="col-sm-6 col-12">
                                    <p> <?php echo e(trans('site.options')); ?> </p>
                                    <div class="form-group">
                                        <input type="text"
                                               id="add1"
                                               name="add1"
                                               class="form-control font-body-md border-gray">
                                    </div><!-- .form-group -->
                                    <div class="form-group">
                                        <input type="text"
                                               id="add2"
                                               name="add2"
                                               class="form-control font-body-md border-gray">
                                    </div><!-- .form-group -->
                                    <div class="form-group">
                                        <input type="text"
                                               id="add3"
                                               name="add3"
                                               class="form-control font-body-md border-gray">
                                    </div><!-- .form-group -->
                                    <div class="form-group">
                                        <input type="text"
                                               id="add4"
                                               name="add4"
                                               class="form-control font-body-md border-gray">
                                    </div><!-- .form-group -->
                                    <div class="form-group">
                                        <input type="text"
                                               id="add5"
                                               name="add5"
                                               class="form-control font-body-md border-gray">
                                    </div><!-- .form-group -->
                                </div><!-- .col -->
                                <div class="col-sm-6 col-12">

                                   <p><?php echo e(trans('site.added_price')); ?></p>

                                    <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                        <input type="text"
                                               id="add-price1"
                                               name="add-price1"
                                               pattern="^[0-9]+$"
                                               class="form-control border-0 font-body-md rounded-0"
                                               aria-describedby="price-addon">
                                        <div class="input-group-prepend">
                                        <span id="price1-addon"
                                              class="input-group-text bg-white border-0 font-body-md text-gray"> <p><?php echo e(trans('site.riyal')); ?></p>
                                        </span>
                                        </div><!-- .input-group-prepend -->
                                    </div><!-- .input-group -->

                                    <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                        <input type="text"
                                               id="add-pric2"
                                               name="add-price2"
                                               pattern="^[0-9]+$"
                                               class="form-control border-0 font-body-md rounded-0"
                                               aria-describedby="price-addon">
                                        <div class="input-group-prepend">
                                        <span id="price2-addon"
                                              class="input-group-text bg-white border-0 font-body-md text-gray"> <?php echo e(trans('site.riyal')); ?>

                                        </span>
                                        </div><!-- .input-group-prepend -->
                                    </div><!-- .input-group -->

                                    <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                        <input type="text"
                                               id="add-price3"
                                               name="add-price3"
                                               pattern="^[0-9]+$"
                                               class="form-control border-0 font-body-md rounded-0"
                                               aria-describedby="price-addon">
                                        <div class="input-group-prepend">
                                        <span id="price3-addon"
                                              class="input-group-text bg-white border-0 font-body-md text-gray"> <?php echo e(trans('site.riyal')); ?>

                                        </span>
                                        </div><!-- .input-group-prepend -->

                                    </div><!-- .input-group -->

                                    <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                        <input type="text"
                                               id="add-price4"
                                               name="add-price4"
                                               pattern="^[0-9]+$"
                                               class="form-control border-0 font-body-md rounded-0"
                                               aria-describedby="price-addon">
                                        <div class="input-group-prepend">
                                        <span id="price4-addon"
                                              class="input-group-text bg-white border-0 font-body-md text-gray"> <?php echo e(trans('site.riyal')); ?>

                                        </span>
                                        </div><!-- .input-group-prepend -->
                                    </div><!-- .input-group -->

                                    <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                        <input type="text"
                                               id="add-price5"
                                               pattern="^[0-9]+$"
                                               name="add-price5"
                                               class="form-control border-0 font-body-md rounded-0"
                                               aria-describedby="price-addon">
                                        <div class="input-group-prepend">
                                        <span id="price5-addon"
                                              class="input-group-text bg-white border-0 font-body-md text-gray"> <?php echo e(trans('site.riyal')); ?>

                                        </span>
                                        </div><!-- .input-group-prepend -->
                                    </div><!-- .input-group -->

                                </div><!-- .col -->
                            </div>


                            <div class="row">
                                <div class="col-sm-6 col-12">
                                    <p> <?php echo e(trans('site.adds')); ?></p>
                                    <div class="form-group">
                                        <input type="text"
                                               id="option1"
                                               name="option1"
                                               class="form-control font-body-md border-gray">
                                    </div><!-- .form-group -->
                                    <div class="form-group">
                                        <input type="text"
                                               id="option2"
                                               name="option2"
                                               class="form-control font-body-md border-gray">
                                    </div><!-- .form-group -->
                                    <div class="form-group">
                                        <input type="text"
                                               id="option3"
                                               name="option3"
                                               class="form-control font-body-md border-gray">
                                    </div><!-- .form-group -->
                                    <div class="form-group">
                                        <input type="text"
                                               id="option4"
                                               name="option4"
                                               class="form-control font-body-md border-gray">
                                    </div><!-- .form-group -->
                                    <div class="form-group">
                                        <input type="text"
                                               id="option5"
                                               name="option5"
                                               class="form-control font-body-md border-gray">
                                    </div><!-- .form-group -->
                                </div><!-- .col -->
                                <div class="col-sm-6 col-12">

                                   <p><?php echo e(trans('site.added_price')); ?></p>

                                    <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                        <input type="text"
                                               id="option-price1"
                                               name="option-price1"
                                               pattern="^[0-9]+$"
                                               class="form-control border-0 font-body-md rounded-0"
                                               aria-describedby="price-addon">
                                        <div class="input-group-prepend">
                                        <span id="price1-addon"
                                              class="input-group-text bg-white border-0 font-body-md text-gray"> <?php echo e(trans('site.riyal')); ?>

                                        </span>
                                        </div><!-- .input-group-prepend -->
                                    </div><!-- .input-group -->

                                    <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                        <input type="text"
                                               id="option-pric2"
                                               name="option-price2"
                                               pattern="^[0-9]+$"
                                               class="form-control border-0 font-body-md rounded-0"
                                               aria-describedby="price-addon">
                                        <div class="input-group-prepend">
                                        <span id="price2-addon"
                                              class="input-group-text bg-white border-0 font-body-md text-gray"> <?php echo e(trans('site.riyal')); ?>

                                        </span>
                                        </div><!-- .input-group-prepend -->
                                    </div><!-- .input-group -->

                                    <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                        <input type="text"
                                               id="option-price3"
                                               name="option-price3"
                                               pattern="^[0-9]+$"
                                               class="form-control border-0 font-body-md rounded-0"
                                               aria-describedby="price-addon">
                                        <div class="input-group-prepend">
                                        <span id="price3-addon"
                                              class="input-group-text bg-white border-0 font-body-md text-gray"> <?php echo e(trans('site.riyal')); ?>

                                        </span>
                                        </div><!-- .input-group-prepend -->

                                    </div><!-- .input-group -->

                                    <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                        <input type="text"
                                               id="option-price4"
                                               name="option-price4"
                                               pattern="^[0-9]+$"
                                               class="form-control border-0 font-body-md rounded-0"
                                               aria-describedby="price-addon">
                                        <div class="input-group-prepend">
                                        <span id="price4-addon"
                                              class="input-group-text bg-white border-0 font-body-md text-gray"> <?php echo e(trans('site.riyal')); ?>

                                        </span>
                                        </div><!-- .input-group-prepend -->
                                    </div><!-- .input-group -->

                                    <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                        <input type="text"
                                               id="option-price5"
                                               pattern="^[0-9]+$"
                                               name="option-price5"
                                               class="form-control border-0 font-body-md rounded-0"
                                               aria-describedby="price-addon">
                                        <div class="input-group-prepend">
                                        <span id="price5-addon"
                                              class="input-group-text bg-white border-0 font-body-md text-gray"> <?php echo e(trans('site.riyal')); ?>

                                        </span>
                                        </div><!-- .input-group-prepend -->
                                    </div><!-- .input-group -->

                                </div><!-- .col -->
                            </div>


                            <div class="form-group">
                                <label for="recommended"> <?php echo e(trans('site.recommanded_restaurant')); ?><span class="text-gray font-body-md"><?php echo e(trans('site.choose_only_3from_eachCAt')); ?></span> </label>
                                <select name="recommended" class="custom-select text-gray font-body-md border-gray" required>
                                    <option value=""><?php echo e(trans('site.choose_status')); ?></option>
                                    <option value="1"><?php echo e(trans('site.yes')); ?></option>
                                    <option value="0"><?php echo e(trans('site.no')); ?></option>
                                </select>
                            </div><!-- .form-group gluten -->

                            <button type="submit" class="add-meal-btn btn btn-primary py-2 px-5"> <?php echo e(trans('site.save')); ?> </button>
                        </form><!-- .new-kind-form -->
                    </div>
                </div><!-- .col-* -->
            </div><!-- .row -->

        </div><!-- .container -->
    </main><!-- .page-content -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection("script"); ?>
    <script src="<?php echo e(asset("/assets/site/js/add-meal.js")); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("Provider.layouts.master", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>