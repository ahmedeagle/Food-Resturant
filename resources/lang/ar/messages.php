<?php

return [
    "required"                      => "جميع الحقول مطلوبة",
    "email"                         => "البريد الالكترونى غير صحيح",
    "email_unique"                  => "هذا البريد الالكترونى مستخدم من قبل",
    "age_numeric"                   => "العمر غير صحيح",
    "gender_in"                     => "الجنس غير صحيح",
    "country_id_exists"             => "الدولة غير صحيحة",
    "subCategory_id_exists"         => "التصنيف غير صحيح",
    "branch_id_exists"              => "رقم المطعم غير صحيح",
    "reservations_id_exists"        => "رقم الحجز غير صحيح",
    "provider_id_exists"            => "هذا المطعم غير موجود",
    "ticket.type.exists"            => "نوع التذكرة غير صحيح",
    "ticket.id.exists"              => "رقم التذكرة غير صحيح",
    "meal_id_exists"                => "رقم الوجبة غير صحيح",
    "meal_size_exists"              => "رقم حجم الوجبة غير صحيح",
    "meal_option_exists"            => "رقم التفضيلة الخاصة بالوجبة غير صحيح",
    "meal_add_exists"               => "رقم الاضافة الخاصة بالوجبة غير صحيح",
    
    "order.id.not.exists"           => "رقم الطلب غير صحيح",
    
    "password_not_correct"          => "الرقم السرى الذى ادخلتة غير صحيح"  ,
    
    "city_id_exists"                => "المدينة غير صحيحة",
    "meal_sub_id_numeric"           => "الرقم المرسل غير صحيح",
    "phone_numeric"                 => "رقم الهاتف غير صحيح",
    "phone_exists"                  => "رقم الهاتف غير موجود",
    "phone_unique"                  => "رقم الهاتف مستخدم من قبل",
    "pasword_min"                   => "الحد الادنى للرقم السرى ستة رموز",
    "confirm_pasword_same"          => "لم يتم تأكيد الرقم السرى",
    "success"                       => "تمت العملية بنجاح",
    "error"                         => "حدث خطأ برجاء المحاولة مرة اخرى",
    "invalid.credential"            => "كلمة المرور غير صحيحة",
    "invalid.email.phone"           => "من فضلك قم بادخال رقم هاتف او بريد الكترونى صحيح",
    "date_of_birth_format"          => "تاريخ الميلاد يجب ان يكون على الصورة Y-m-d",

    "no.record.found"               => "لا توجد سجلات لهذة البيانات المرسلة برجاء التأكد من البيانات والمحاولة مرة اخرى",
    
    "user.already.active"           => "تم تفعيل الحساب من قبل",
    "page.exists"                   => "هذة الصفحة غير موجودة",

    "register.check.phone"          => "تمت عملية تسجيل الحساب بنجاح وارسال كود التفعيل على رقم الهاتف الخاص بكم",
    "register.active.expire"        => "رقم التفعيل الذى قمت بإدخالة غير صالح الان برجاء طلب تفعيل الحساب مرة اخرى حتى يصلك رقم تفعيل جديد",
    "register.active.notMatch"      => "رقم التفعيل غير صحيح",

    "send.new.password"             => "تم ارسال الرقم السرى الجديد على رقم الهاتف",

    "phone.not.active"              => "برجاء تفعيل رقم الهاتف حتى تتمكن من اتمام هذة العملية",
    "send.activation.code"          => "تمت العملية بنجاح وارسال رقم التفعيل على رقم الهاتف الخاص بك",

    "favorite.provide.exists"       => "لقد قمت بتفضيل هذا المطعم من قبل",

    "rate.exists"                   => "لقد قمت بتقييم هذا المطعم من قبل",

    "error.in.rate"                 => "برجاء ادخال قيم صحيحة للتقييم",

    "type.in.0.1"                   => "يجب ان يكون النوع 0 او 1",

    "reservation.status.error"      => "خطأ فى نوع الحجز",
    "reservation.date.format.error" => "تاريخ الحجز يجب ان يكون على الصورة Y-m-d",
    "reservation.time.format.error" => "وقت الحجز يجب ان يكون على الصورة H:i:s",
    "reservation.seats.error"       => "خطأ فى عدد المقاعد",
    "reservation.special.error"     => "خطأ فى قيمة مناسبة خاصة",
    "branch.hasnot.booking"         => "هذا المطعم ليس لدية حجوزات",
    "branch.out.of.date"            => "وقت الحجز لا يتوافق مع اوقات العمل لهذا المطعم",
    "reservation_already_accepted"  => "لا يمكن الغاء حجز تمت الموافقة علية",
    

    "order.in_future.in"            => "يجب ان يكون قيمة هل الطلب مستقبلى 1 او 0",
    "order.is_delivery.in"          => "يجب ان تكون قيمة هل الطلب بة خدمة التوصيل على 1 او 0",
    "order.balance.not.enough"      => "رصيدك غير كافى لاتمام هذة العملية",
    "favorite.order.not.finished"   => "برجاء انتظار انتهاء الطلب حتى تتمكن من الاضافة فى المفضلة",

    "recommended_number"            => "تحديد الوجبات التى ينصح بها 2 فقط من كل تصنيف",

    "location-empty"                => "برجاء تحديد العنوان",
    "dateMustAfterorEqualTodat"     => "لابد ان يكون تاريخ الطلب اكبر من او يساوي تاريخ اليوم",
    "invalid_phone_format"          => "صغه الهاتف غير صحيحه ",
    "phonenotcorrect"                => "صيغه الهاتف غير صحيحه ",
    "user.blocked"                   => "عذرا تم إيقاف هذا الحساب ",
    "workinghoursfrombranch"                   => 'تم تحديد مواعيد العمل من قبل المطعم',
    "branchclosedtoday"                   =>  'المطعم مغلق اليوم',
    "exitbranchhours"                   => "عفوا توقيت الطلب خارج اوقات عمل المطعم",
    "user.blocked"                   => "عذرا تم إيقاف هذا الحساب ",
];
