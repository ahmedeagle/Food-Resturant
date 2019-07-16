<!-- Page-header start -->
<div class="page-header card">
   <div class="card-block">
      <h5 class="m-b-10">المستخدمين</h5>
      <ul class="breadcrumb-title b-t-default p-t-10">
         <li class="breadcrumb-item">
            <a href="<?=base_url('admin_panel/dashboard')?>">الرئيسية</a>
         </li>
         <li class="breadcrumb-item"><a href="<?=base_url('admin_panel/users')?>">سلايدر الصور</a>
         </li>
         <li class="breadcrumb-item"><a>اضافة</a>
         </li>
      </ul>
   </div>
</div>
<!-- Page-header end -->
<div class="page-body">
      <!-- Basic Form Inputs card start -->
      <div class="card">
         <div class="card-header">
            <h5>اضافة مستخدم جديد</h5>
         </div>
         <div class="card-block">
            <form action="" method="POST" enctype="multipart/form-data">
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">الاسم بالكامل</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="full_name" value="<?=set_value('full_name')?>" placeholder="من فضلك ادخل الاسم بالكامل">
                     <?php if(form_error('full_name'))echo form_error('full_name')?>
                  </div>
               </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">اسم المستخدم</label>
                  <div class="col-sm-10">
                     <input type="text" class="form-control" name="user_name" value="<?=set_value('user_name')?>" placeholder="من فضلك ادخل  سم المستخدم">
                     <?php if(form_error('user_name')) echo form_error('user_name') ?>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">البريد الالكتروني</label>
                  <div class="col-sm-10">
                     <input type="email" class="form-control" name="email" value="<?=set_value('email')?>" placeholder="من فضلك ادخل البريد الالكتروني">
                     <?php if(form_error('email')) echo form_error('email') ?>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">كلمة المرور</label>
                  <div class="col-sm-10">
                     <input type="password" class="form-control" name="password" value="<?=set_value('password')?>" placeholder="من فضلك ادخل كلمة المرور">
                     <?php if(form_error('password')) echo form_error('password') ?>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">تأكيد كلمة المرور</label>
                  <div class="col-sm-10">
                     <input type="password" class="form-control" name="confirm_password" value="<?=set_value('confirm_password')?>" placeholder="من فضلك ادخل تأكيد كلمة المرور">
                     <?php if(form_error('confirm_password')) echo form_error('confirm_password') ?>
                  </div>
               </div>
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">صورة الحساب</label>
                  <div class="col-sm-10">
                      <input type="file" name="img" value="<?=set_value('img')?>" class="form-control">
                      <?php if(form_error('img')) echo form_error('img') ?>
                  </div>
              </div>
               <button type="submit" class="btn btn-md btn-success"><i class="icofont icofont-check"></i>  اضافة </button>    <a href="<?=base_url('admin_panel/users')?>" class="btn btn-md btn-danger"><i class="icofont icofont-close"></i>  رجوع </a>
            </form>
         </div>
</div>
