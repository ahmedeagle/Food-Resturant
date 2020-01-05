<?php

return [
    "required"                      => "all fields required",
    "email"                         => "the Email is invalid",
    "email_unique"                  => "This Email is Already been Taken",
    "age_numeric"                   => "Please Enter a Valid Age",
    "gender_in"                     => "Please Enter a Valid Gender",
    "country_id_exists"             => "invalid Country",
    "subCategory_id_exists"         => "invalid Category",
    "branch_id_exists"              => "invalid branch id",
    "reservations_id_exists"        => "invalid Reservation id",
    "provider_id_exists"            => "invalid Provider Id",
    "ticket.type.exists"            => "invalid Ticket type",
    "ticket.id.exists"              => "invalid Ticket id",
    "meal_id_exists"                => "invalid Meal id",
    "meal_size_exists"              => "invalid Meal size id",
    "meal_option_exists"            => "invalid Meal option id",
    "meal_add_exists"               => "invalid Meal add id",
    
    "order.id.not.exists"           => "This Order id Not Exists",
    
    "password_not_correct"          => "The Password is Incorrect",
    
    "city_id_exists"                => "invalid City",
    "meal_sub_id_numeric"           => "please Enter a valid id",
    "phone_numeric"                 => "invalid Phone Number",
    "phone_unique"                  => "This Phone Number is Already Been Taken",
    "phone_exists"                  => "This Phone Number Not Found",
    "pasword_min"                   => "The Minimum Length For Password Six Characters",
    "confirm_pasword_same"          => "Please Confirm The Password",
    "success"                       => "Process Done Successfully",
    "error"                         => "Error, Please Try Again",
    "invalid.credential"            => "invalid credential",
    "no.record.found"               => "No records Found For This credential, Please check Your credential and Try Again",
    "invalid.email.phone"           => "Enter a Valid Email Or Phone Number",
    "date_of_birth_format"          => "Birth Date Format Must be Y-m-d",

    "user.already.active"           => "Your Account is Already Active",
    "page.exists"                   => "This Page Not Found",

    "register.check.phone"          => "Account Created Successfully,Activation Code Has Been Send To Your Phone",
    "active.expire"                 => "This Activation Code is Expired,Please Resend new Activation Request To Generate Valid new Code",
    "register.active.notMatch"      => "Wrong Activation Code",

    "send.new.password"             => "new Password Has Been Send To Your Phone Number",

    "phone.not.active"              => "Please Activate Your Phone To Complete This Process",
    "send.activation.code"          => "Process Done Successfully,And The Activation Code Has Been Send To Your Phone Number",

    "favorite.provide.exists"       => "this provider is already in your favorites",

    "rate.exists"                   => "You Already Rate This Restaurant Before",

    "error.in.rate"                 => "Please, Add a Valid Rate Value",

    "type.in.0.1"                   => "The Type Should Be in 1 or 2",

    "reservation.status.error"      => "Reservation status should be 1 or 2",
    "reservation.date.format.error" => "Reservation date format must be Y-m-d",
    "reservation.time.format.error" => "Reservation date format must be H:i:s",
    "reservation.seats.error"       => "Error in seats number",
    "reservation.special.error"     => "Reservation Special Should be 1 or 2",
    "branch.hasnot.booking"         => "The Reservation in this Restaurant Not Active",
    "branch.out.of.date"            => "Your Reservation Time is Out Of Range in this Restaurant",
    "reservation_already_accepted"  => "You Can Not Cancel Accepted Reservation",
    
    "order.in_future.in"            => "is the order will be in the future value should be 1 Or 0",
    "order.is_delivery.in"          => "is Delivery Value Should Be 1 or 0",
    "order.balance.not.enough"      => "Your Balanace is Not Enough to make This Process",
    "favorite.order.not.finished"   => "Please Wait Until Finish Order To Add In You Favorit List",

    "recommended_number"            => "The Recommended meals should be 2 at least in each Category",

    "location-empty"                => "Please, Select The Location",
     "dateMustAfterorEqualTodat"     => "Order Date Must Be Greater or Equal to Today",
     "invalid_phone_format"          => "phone number not correct",
     "phonenotcorrect"                => "phone number must begin ",
     "user.blocked"                    => "this account is blocked",
];