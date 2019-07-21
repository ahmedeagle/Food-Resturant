<?php $__env->startSection('title'); ?>
    <?php echo e($title); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('class'); ?>
    <?php echo e($class); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <main class="page-content py-5">

        <header class="page-header mt-4 text-center">
            <h1 class="page-title h2 font-body-bold">  <?php echo e(trans('site.login')); ?></h1>
        </header>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-sm-10 col-12 mx-auto font-body-bold mb-5">

                    <div class="d-flex px-3 rounded-lg shadow-around mt-4 justify-content-between flex-md-column flex-sm-column flex-column bg-white">
                        <ul class="nav nav-tabs border-0 px-lg-2 pr-0 text-center justify-content-around"
                            id="new-branch-tabs"
                            role="tablist">

                            <li class="nav-item">
                                <a class="nav-link pb-3 h3 mb-0 pt-3 font-body-bold <?php if(!$errors->has('provider-phone-number')  && !Session::has('provider-login-error') && !Session::has('provider-login-success')): ?> active <?php endif; ?>"
                                   id="user-tab"
                                   data-toggle="tab"
                                   href="#user"
                                   role="tab"
                                   aria-controls="user"
                                   aria-selected="true">
                                     <?php echo e(trans('site.as_user')); ?>

                                </a>
                            </li><!-- .nav-item -->

                            <li class="nav-item">
                                <a class="nav-link pb-3 h3 mb-0 pt-3 font-body-bold <?php if($errors->has('provider-phone-number') || $errors->has('provider-password') || Session::has('provider-login-error') || Session::has('provider-login-success')): ?> active <?php endif; ?>"
                                   id="restaurant-tab"
                                   data-toggle="tab"
                                   href="#restaurant"
                                   role="tab"
                                   aria-controls="restaurant"
                                   aria-selected="false">
                                    <?php echo e(trans('site.as_provider')); ?>

                                </a>
                            </li><!-- .nav-item -->
                        </ul><!-- .nav-tabs -->
                    </div>


                    <div class="tab-content">
                        <div class="tab-pane fade <?php if(!$errors->has('provider-phone-number') && !$errors->has('provider-password') && !Session::has('provider-login-error') && !Session::has('provider-login-success')): ?> active show <?php endif; ?>"
                             id="user"
                             role="tabpanel"
                             aria-describedby="user-tab">

                            <form action="<?php echo e(url('/user/login')); ?>" method="POST" class="login-form mt-5">
                                <?php echo e(csrf_field()); ?>


                                <?php if(Session::has("user-error")): ?>
                                    <div class="alert alert-warning top-margin">
                                        <?php echo e(Session::get("user-error")); ?>

                                    </div>
                                <?php endif; ?>

                                <?php if(Session::has("user-login-success")): ?>
                                    <div class="alert alert-success top-margin">
                                        <?php echo e(Session::get("user-login-success")); ?>

                                    </div>
                                <?php endif; ?>



                                <div class="form-group">
                                    <label for="phone-number"><?php echo e(trans('site.emailorphone')); ?></label>
                                    <input type="text" class="form-control border-gray font-body-md" id="phone-number" value="<?php echo e(old('user-data')); ?>" name="user-data" placeholder="usermail@gmail.com">
                                    <?php if($errors->has("user-data")): ?>
                                        <div class="alert alert-danger top-margin">
                                            <?php echo e($errors->first("user-data")); ?>

                                        </div>
                                    <?php endif; ?>

                                </div><!-- .form-group -->
                                <div class="form-group">
                                    <label for="password"><?php echo e(trans('site.password')); ?></label>
                                    <input type="password" class="form-control border-gray" id="password" name="user-password" placeholder="********">

                                    <?php if($errors->has("user-password")): ?>
                                        <div class="alert alert-danger top-margin">
                                            <?php echo e($errors->first("user-password")); ?>

                                        </div>
                                    <?php endif; ?>

                                </div><!-- .form-group -->
                                <button type="submit" class="btn btn-primary btn-block py-2 px-4"> <?php echo e(trans('site.login')); ?></button>
                                <p class="text-center text-gray my-3 font-body-md"><?php echo e(trans('site.login_via')); ?></p>
                                <div class="container">

                                    <div class="row">

                                        <div class="form-group col-md-6 col-12">

                                            <a href="<?php echo e(url('/login/facebook')); ?>" type="submit" class="btn col btn-primary py-2 px-4 facebook">

                                            <i class="fab fa-facebook-f ml-1"></i>
                                                     
                                                     <?php echo e(trans('site.facebook')); ?>


                                            </a>

                                        </div>

                                        <div class="form-group col-md-6 col-12">

                                            <a href="<?php echo e(url('/login/twitter')); ?>" type="submit" class="btn col btn-primary py-2 px-4 twitter">

                                            <i class="fab fa-twitter ml-1"></i>
                                            <?php echo e(trans('site.twitter')); ?>

                                            </a>

                                        </div>

                                    </div>


                                </div>
                            </form><!-- .login-form -->
                            <div class="lost-data">
                                <a href="<?php echo e(url('/user/forget-password')); ?>"
                                   class="no-decoration mt-3 d-inline-block text-primary">
                                    <?php echo e(trans('site.forget_password')); ?>

                                </a>
                                <p><?php echo e(trans('site.not_have_account')); ?>

                                    <a href="<?php echo e(url('/register')); ?>" class="no-decoration text-primary d-inline-block mt-2">
                                        <?php echo e(trans('site.new_account')); ?>

                                    </a>
                                </p>
                            </div>
                        </div>

                        <div class="tab-pane fade <?php if($errors->has('provider-phone-number') || $errors->has('provider-password') || Session::has('provider-login-error') || Session::has('provider-login-success')): ?> active show <?php endif; ?>"
                             id="restaurant"
                             role="tabpanel"
                             aria-labelledby="restaurant-tab">

                            <form action="<?php echo e(url('/restaurant/login')); ?>" method="POST" class="login-form mt-5">
                                <?php echo e(csrf_field()); ?>


                                <?php if(Session::has("provider-login-error")): ?>

                                    <div class="alert alert-info">
                                        <?php echo e(Session::get("provider-login-error")); ?>

                                    </div>

                                <?php endif; ?>

                                <?php if(Session::has("provider-login-success")): ?>

                                    <div class="alert alert-success">
                                        <?php echo e(Session::get("provider-login-success")); ?>

                                    </div>

                                <?php endif; ?>
                                
                            <div class="row justify-content-center">
    
                               <div class="form-group">
                                                <div class="form-check">
                                                    <label class="btn btn-primary f-food ">
                                                        <input data-id="1" name="guard" value="1" class="form-check-input0" type="radio">
                                                         <?php echo e(trans('site.branch_account')); ?>

                                                    </label>
                                                </div>
                                           
                                </div>
                                  <div class="form-group">
                                                <div class="form-check">
                                                    <label class="btn btn-primary f-food ">
                                                        <input data-id="1"  name="guard" value="2" class="form-check-input0" type="radio" checked="">
                                                         <?php echo e(trans('site.main_account')); ?>

                                                    </label>
                                                </div>
                                 </div>
                            </div>                
                                                

                                <div class="form-group">
                                    <label for="phone-number"> <?php echo e(trans('site.phone')); ?> </label>
                                    <input type="text" name="provider-phone-number" value="<?php echo e(old('provider-phone-number')); ?>" class="form-control border-gray" id="phone-number">

                                    <?php if($errors->has("provider-phone-number")): ?>
                                        <div class="top-margin alert alert-danger">
                                            <?php echo e($errors->first('provider-phone-number')); ?>

                                        </div>
                                    <?php endif; ?>
                                </div><!-- .form-group -->
                                <div class="form-group">
                                    <label for="password"><?php echo e(trans('site.password')); ?> </label>
                                    <input type="password" name="provider-password" class="form-control border-gray" id="password">

                                    <?php if($errors->has("provider-password")): ?>
                                        <div class="top-margin alert alert-danger">
                                            <?php echo e($errors->first('provider-password')); ?>

                                        </div>
                                    <?php endif; ?>

                                </div><!-- .form-group -->
                                <button type="submit" class="btn btn-primary py-2 px-4"> <?php echo e(trans('site.login')); ?> </button>
                            </form><!-- .login-form -->
                            <div class="lost-data">
                                <a href="<?php echo e(url('/restaurant/forget-password')); ?>"
                                   class="no-decoration mt-3 d-inline-block">
                                     <?php echo e(trans('site.forget_password')); ?>

                                </a>
                                <p><?php echo e(trans('site.not_have_account')); ?>

                                    <a href="<?php echo e(url('/register')); ?>" class="no-decoration text-primary d-inline-block mt-2">
                                        <?php echo e(trans('site.new_account')); ?>

                                    </a>
                                </p>
                            </div>



                        </div>
                    </div>

                </div><!-- .col-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </main><!-- .page-content -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('Site.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>