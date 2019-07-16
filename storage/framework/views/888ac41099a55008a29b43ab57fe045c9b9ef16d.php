<!DOCTYPE html>
<html>
<head>
   <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo e(asset("/assets/admin_panel/login/login.css")); ?>">
<link rel="stylesheet" media="screen" href="https://fontlibrary.org/face/droid-arabic-kufi" type="text/css"/>
<title>تسجيل الدخول</title>
</head>
<body style="font-family: DroidArabicKufiRegular">
<div class="container">
   <div class="row">
      
<!-- Mixins-->
<!-- Pen Title-->
<div class="pen-title">
   <h1>تسجيل الدخول</h1>
</div>
<div class="container">
  <div class="card"></div>
  <div class="card">
    <h1 class="title">دخول</h1>
    <form action="<?php echo e(url("/admin/login")); ?>" method="POST" role="form">
      <?php echo e(csrf_field()); ?>

      <?php if(Session::has('error')): ?>
        <div class="alert alert-danger"> <?php echo e(Session::get('error')); ?></div>
      <?php endif; ?>
      <?php if(Session::has('success')): ?>
        <div class="alert alert-success"> <?php echo e(Session::get('success')); ?></div>
      <?php endif; ?>
      <div class="input-container">
        <input type="text" id="Username" value="<?php echo e(old("email")); ?>" name="email">
        <label for="Username">البريد الالكترونى</label>
        <div class="bar"></div>
        <?php if($errors->has('email')): ?>
          <?php echo e($errors->first('email')); ?>

        <?php endif; ?>
      </div>
      <div class="input-container">
        <input type="password" id="Password" name="password" >

        <label for="Password">كلمة المرور</label>
        <div class="bar"></div>
        <?php if($errors->has('password')): ?>
          <?php echo e($errors->first('password')); ?>

        <?php endif; ?>
      </div>
      <div class="button-container">
        <button type="submit"><span>دخول</span></button>
      </div>
      <div class="footer"><a href="#" style="color: #4099ff">نسيت كلمة المرور؟</a></div>
    </form>
  </div>
   </div>
</div>
</body>
</html>