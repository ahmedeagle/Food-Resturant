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
                    <div class="py-2 pr-3 rounded-lg shadow-around">
                        <h4 class="page-title"><?php echo e(trans('site.edit_meal')); ?></h4>
                    </div>
                    <div class="p-3 rounded-lg shadow-around mt-4">

                        <form data-action="<?php echo e(url("/restaurant/food-menu/edit")); ?>" id="edit-meal-from" class="new-kind-form multi-forms">

                            <div class="form-group">
                                <p><?php echo e(trans('site.meal_photo')); ?><span class="text-gray font-body-md"><?php echo e(trans('site.photo_note')); ?></span></p>
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

                                <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div>
                                        <input class="image_id" type="hidden" value="<?php echo e($img->image_id); ?>" />
                                        <i class='delete-img fa fa-times' aria-hidden='true'></i>
                                        <img class='io' src='<?php echo e($img->meal_image_url); ?>' />
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>

                            <div class="form-group">
                                <label for="kind-name"><?php echo e(trans('site.ar_name')); ?></label>
                                <input type="text"
                                       class="form-control border-gray font-body-md"
                                       name="ar_name"
                                       value="<?php echo e(old("ar_name", $meal->ar_name)); ?>"
                                       id="kind-name" required>
                            </div><!-- .form-group name -->

                            <div class="form-group">
                                <label for="kind-name"><?php echo e(trans('site.en_name')); ?></label>
                                <input type="text"
                                       class="form-control border-gray font-body-md"
                                       name="en_name"
                                       value="<?php echo e(old("en_name", $meal->en_name)); ?>"
                                       id="kind-name" required>
                            </div><!-- .form-group name -->

                            <div class="form-group">
                                <label for="categorie"><?php echo e(trans('site.meal_categories')); ?></label>
                                <select class="custom-select text-gray font-body-md border-gray"
                                        id="categorie" name="category" required>
                                    <option value=""><?php echo e(trans('site.choose_category')); ?></option>
                                    <?php $__currentLoopData = $cats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <option value="<?php echo e($cat->id); ?>" <?php if($meal->mealCategory_id == $cat->id): ?> selected <?php endif; ?>><?php echo e($cat->name); ?></option>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div><!-- .form-group available -->


                            <div class="form-group">
                                <label for="categorie"><?php echo e(trans('site.branches_have_meal')); ?></label>
                                <select class="custom-select text-gray font-body-md border-gray"
                                        id="branch" name="branch" required>
                                    <option value=""><?php echo e(trans('site.choose_branches')); ?></option>

                                    <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <option value="<?php echo e($branch->id); ?>" <?php if($meal->branch_id == $branch->id): ?> selected <?php endif; ?>><?php echo e($branch->name); ?></option>

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
                                       value="<?php echo e($component); ?>"
                                       id="input-tags" required>
                            </div><!-- .form-group tags -->

                            <div class="form-group">
                                <label for="available"><?php echo e(trans('site.available_all_time')); ?></label>
                                <select class="custom-select text-gray font-body-md border-gray"
                                        id="available" name="available" required>
                                    <option value=""><?php echo e(trans('site.choose_status')); ?></option>
                                    <option value="1" <?php if($meal->available == "1"): ?> selected <?php endif; ?>> <?php echo e(trans('site.yes')); ?></option>
                                    <option value="0" <?php if($meal->available == "0"): ?> selected <?php endif; ?>><?php echo e(trans('site.no')); ?></option>
                                </select>
                            </div><!-- .form-group available -->

                            <div class="form-group">
                                <label for="spicy"><?php echo e(trans('site.spicy')); ?></label>
                                <select class="custom-select text-gray font-body-md border-gray"
                                        id="spicy" name="spicy" required>
                                    <option value=""><?php echo e(trans('site.choose_status')); ?></option>
                                    <option value="1" <?php if($meal->spicy == "1"): ?> selected <?php endif; ?>><?php echo e(trans('site.yes')); ?></option>
                                    <option value="0" <?php if($meal->spicy == "0"): ?> selected <?php endif; ?>><?php echo e(trans('site.no')); ?></option>
                                </select>
                            </div><!-- .form-group spicy -->

                            <div class="spicy-degree-container form-group <?php if($meal->spicy == "0"): ?> hidden-element <?php endif; ?>">
                                <label for="spicy-degree"><?php echo e(trans('site.spicy_degree')); ?></label>
                                <input type="text"
                                       class="form-control border-gray font-body-md"
                                       name="spicy-degree"
                                       value="<?php echo e(old("spicy-degree", $meal->spicy_degree)); ?>"
                                       placeholder="<?php echo e(trans('site.value_from1_to5')); ?>"
                                       id="spicy-degree">
                            </div><!-- .form-group name -->

                            <div class="form-group">
                                <label for="vegetable"><?php echo e(trans('site.suitable_for_vegetarians')); ?></label>
                                <select class="custom-select text-gray font-body-md border-gray"
                                        id="vegetable" name="vegetable" required>
                                    <option value=""><?php echo e(trans('site.choose_status')); ?></option>
                                    <option value="1" <?php if($meal->vegetable == "1"): ?> selected <?php endif; ?>><?php echo e(trans('site.yes')); ?></option>
                                    <option value="0" <?php if($meal->vegetable == "0"): ?> selected <?php endif; ?>><?php echo e(trans('site.no')); ?></option>
                                </select>
                            </div><!-- .form-group vegetable -->

                            <div class="form-group">
                                <label for="gluten"><?php echo e(trans('site.gluten_free')); ?></label>
                                <select class="custom-select text-gray font-body-md border-gray"
                                        id="gluten" name="gluten" required>
                                    <option value=""><?php echo e(trans('site.choose_status')); ?></option>
                                    <option value="1" <?php if($meal->gluten == "1"): ?> selected <?php endif; ?>><?php echo e(trans('site.yes')); ?></option>
                                    <option value="0" <?php if($meal->gluten == "0"): ?> selected <?php endif; ?>><?php echo e(trans('site.no')); ?></option>
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
                                       value="<?php echo e(old("calorie", $meal->calories)); ?>"
                                       name="calorie" required>
                                <div id="meal-calorie-error" class="top-margin hidden-element alert alert-danger"></div>
                            </div><!-- .form-group calorie -->

                            <div class="form-group">
                                <label for="details"><?php echo e(trans('site.description_ar')); ?><span class="text-gray font-body-md"><?php echo e(trans('site.min_5_words')); ?></span></label>
                                <textarea class="form-control ar-details font-body-md border-gray"
                                          id="details"
                                          name="ar_description"
                                          rows="6" required><?php echo e(old("ar_description", $meal->ar_description)); ?></textarea>
                            </div><!-- .form-group details -->


                            <div class="form-group">
                                <label for="details"><?php echo e(trans('site.description_en')); ?><span class="text-gray font-body-md"><?php echo e(trans('site.min_5_words')); ?></span></label>
                                <textarea class="form-control en-details font-body-md border-gray"
                                          id="details"
                                          name="en_description"
                                          rows="6" required><?php echo e(old("en_description", $meal->en_description)); ?></textarea>
                            </div><!-- .form-group details -->

                            <div class="row">
                                <div class="col-sm-6 col-12">
                                    <p><?php echo e(trans('site.sizes')); ?></p>

                                    <?php $__currentLoopData = $sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="form-group">
                                            <input type="text"
                                                   id="size<?php echo e($key + 1); ?>"
                                                   name="size<?php echo e($key + 1); ?>"
                                                   value="<?php echo e(old("size". ($key + 1) ."", $s->size_name)); ?>"
                                                   class="form-control font-body-md border-gray" <?php if($key == 0): ?> required <?php endif; ?>>
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

                                    <p><?php echo e(trans('site.price')); ?></p>
                                    <?php $__currentLoopData = $sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="input-group mb-3 rounded border border-gray overflow-hidden">
                                            <input type="text"
                                                   id="price<?php echo e($key + 1); ?>"
                                                   name="price<?php echo e($key + 1); ?>"
                                                   pattern="^[0-9]+$"
                                                   value="<?php echo e(old("price". ($key + 1) ."", $s->price)); ?>"
                                                   class="form-control border-0 font-body-md rounded-0"
                                                   aria-describedby="price-addon" <?php if($key == 0): ?> required <?php endif; ?>>
                                            <div class="input-group-prepend">
                                            <span id="price1-addon"
                                                  class="input-group-text bg-white border-0 font-body-md text-gray"> <?php echo e(trans('site.riyal')); ?>

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
                                                  class="input-group-text bg-white border-0 font-body-md text-gray"> <?php echo e(trans('site.riyal')); ?>

                                            </span>
                                                </div><!-- .input-group-prepend -->
                                            </div><!-- .input-group -->


                                        <?php endfor; ?>
                                    <?php endif; ?>


                                </div><!-- .col -->
                            </div>


                            <div class="row">
                                <div class="col-sm-6 col-12">
                                    <p> <?php echo e(trans('site.options')); ?> </p>

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

                                    <p><?php echo e(trans('site.added_price')); ?></p>
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
                                                  class="input-group-text bg-white border-0 font-body-md text-gray"><?php echo e(trans('site.riyal')); ?>

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
                                                  class="input-group-text bg-white border-0 font-body-md text-gray"> <?php echo e(trans('site.riyal')); ?>

                                            </span>
                                                </div><!-- .input-group-prepend -->
                                            </div><!-- .input-group -->


                                        <?php endfor; ?>
                                    <?php endif; ?>


                                </div><!-- .col -->
                            </div>


                            <div class="row">
                                <div class="col-sm-6 col-12">
                                    <p> <?php echo e(trans('site.adds')); ?></p>

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

                                    <p><?php echo e(trans('site.added_price')); ?></p>
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
                                                  class="input-group-text bg-white border-0 font-body-md text-gray"> <?php echo e(trans('site.riyal')); ?>

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
                                                  class="input-group-text bg-white border-0 font-body-md text-gray"> <?php echo e(trans('site.riyal')); ?>

                                            </span>
                                                </div><!-- .input-group-prepend -->
                                            </div><!-- .input-group -->


                                        <?php endfor; ?>
                                    <?php endif; ?>


                                </div><!-- .col -->
                            </div>


                            <div class="form-group">
                                <label for="recommended"><?php echo e(trans('site.recommanded_restaurant')); ?></label>
                                <select name="recommended" class="custom-select text-gray font-body-md border-gray" required>
                                    <option value=""><?php echo e(trans('site.choose_status')); ?></option>
                                    <option value="1" <?php if($meal->recommend == "1"): ?> selected <?php endif; ?>><?php echo e(trans('site.yes')); ?></option>
                                    <option value="0" <?php if($meal->recommend == "0"): ?> selected <?php endif; ?>><?php echo e(trans('site.no')); ?>option>
                                </select>
                            </div><!-- .form-group gluten -->

                            <input type="hidden" name="meal_id" value="<?php echo e($meal->id); ?>" />
                            <button type="submit" class="add-meal-btn btn btn-primary py-2 px-5"><?php echo e(trans('site.edit')); ?></button>
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