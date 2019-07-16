<!DOCTYPE html>
<html>
<head>
   <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="{{ asset("/assets/admin_panel/login/login.css") }}">
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
    <form action="{{ url("/admin/login") }}" method="POST" role="form">
      {{ csrf_field() }}
      @if(Session::has('error'))
        <div class="alert alert-danger"> {{ Session::get('error') }}</div>
      @endif
      @if(Session::has('success'))
        <div class="alert alert-success"> {{ Session::get('success') }}</div>
      @endif
      <div class="input-container">
        <input type="text" id="Username" value="{{ old("email") }}" name="email">
        <label for="Username">البريد الالكترونى</label>
        <div class="bar"></div>
        @if($errors->has('email'))
          {{ $errors->first('email') }}
        @endif
      </div>
      <div class="input-container">
        <input type="password" id="Password" name="password" >

        <label for="Password">كلمة المرور</label>
        <div class="bar"></div>
        @if($errors->has('password'))
          {{ $errors->first('password') }}
        @endif
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