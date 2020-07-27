<!DOCTYPE html>
<html lang="en">
<head>
    <title> مجرب @yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="" />

    <meta name="base-url" content="{{ url("/") }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">
        
    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('/assets/admin_panel/images/favicon.ico')}}" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin_panel/bower_components/bootstrap/css/bootstrap.min.css')}}">
     <!-- sweet alert framework -->
     <link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/bower_components/sweetalert/css/sweetalert.css')}}">
    <!-- themify-icons line icon -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/icon/themify-icons/themify-icons.css')}}">
    <!-- simple line icon -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel//icon/simple-line-icons/css/simple-line-icons.css')}}">
    <!-- ico font -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/icon/icofont/css/icofont.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/icon/font-awesome/css/font-awesome.min.css')}}">
    <!-- animation nifty modal window effects css -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/css/component.css')}}">
    <!-- Data Table Css -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/pages/data-table/css/buttons.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}">
    <!-- Syntax highlighter Prism css -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/pages/prism/prism.css')}}">
    <!-- notify js Fremwork -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/bower_components/pnotify/css/pnotify.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/bower_components/pnotify/css/pnotify.brighttheme.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/bower_components/pnotify/css/pnotify.buttons.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/bower_components/pnotify/css/pnotify.history.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/bower_components/pnotify/css/pnotify.mobile.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/pages/pnotify/notify.css')}}">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/css/jquery.mCustomScrollbar.css')}}">
    <link rel="stylesheet" media="screen" href="https://fontlibrary.org/face/droid-arabic-kufi" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/icon/typicons-icons/css/typicons.min.css')}}">
    <!-- ion icon css -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/icon/ion-icon/css/ionicons.min.css')}}">
    <!-- Material Icon -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/icon/material-design/css/material-design-iconic-font.min.css')}}">
    <!-- jquery file upload Frame work -->
    <link href="{{asset('assets/admin_panel/pages/jquery.filer/css/jquery.filer.css')}}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('assets/admin_panel/pages/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css')}}" type="text/css" rel="stylesheet" />
    <!-- star theme css -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/bower_components/jquery-bar-rating/css/bars-1to10.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/bower_components/jquery-bar-rating/css/bars-horizontal.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/bower_components/jquery-bar-rating/css/bars-movie.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/bower_components/jquery-bar-rating/css/bars-pill.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/bower_components/jquery-bar-rating/css/bars-reversed.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/bower_components/jquery-bar-rating/css/bars-square.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/bower_components/jquery-bar-rating/css/css-stars.css')}}">
    <!-- slick css -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/bower_components/slick-carousel/css/slick.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/bower_components/slick-carousel/css/slick-theme.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/css/logic.css')}}">

    <link rel="stylesheet" href="{{ asset('assets/site/css/notifIt.min.css') }}">

<style>
    
    
                .modall {
                display:    none;
                position:   fixed;
                z-index:    1000;
                top:        0;
                left:       0;
                height:     100%;
                width:      100%;
                background: rgba( 255, 255, 255, .8 ) 
                            url('https://i.stack.imgur.com/FhHRx.gif')
                            50% 50% 
                            no-repeat;
            }
            
            /* When the body has the loading class, we turn
               the scrollbar off with overflow:hidden */
            body.loading .modall {
                overflow: hidden;   
            }
            
            /* Anytime the body has the loading class, our
               modal element will be visible */
            body.loading .modall {
                display: block;
            }



</style>
    @yield('style')

</head>
<!-- Menu rtl layout -->

<body style="font-family: DroidArabicKufiRegular">
    <!-- Pre-loader start -->
    <div class="theme-loader">
        <div class="loader-track">
            <div class="loader-bar"></div>
        </div>
    </div>
    <!-- Pre-loader end -->
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">
            <nav class="navbar header-navbar pcoded-header">
                <div class="navbar-wrapper">
                    <div class="navbar-logo">
                        <a class="mobile-menu" id="mobile-collapse" href="#!">
                            <i class="ti-menu"></i>
                        </a>
                        <div class="mobile-search">
                            <div class="header-search">
                                <div class="main-search morphsearch-search">
                                    <div class="input-group">
                                        <span class="input-group-addon search-close"><i class="ti-close"></i></span>
                                        <input type="text" class="form-control" placeholder="Enter Keyword">
                                        <span class="input-group-addon search-btn"><i class="ti-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="index.html">
                            <!-- <img class="img-fluid" src="assets/admin_panel/images/logo.png" alt="Theme-Logo" /> -->
                        </a>
                        <a class="mobile-options">
                            <i class="ti-more"></i>
                        </a>
                    </div>

                    <div class="navbar-container container-fluid">
                        <ul class="nav-left">
                            <li>
                                <div class="sidebar_toggle"><a href="javascript:void(0)"><i class="ti-menu"></i></a></div>
                            </li>
                        </ul>
                        <ul class="nav-right">
                             @can('credit')
                            <li>
                                <a> الرصيد: {{ (new \App\Http\Controllers\Admin\Settings())->get_app_balance() }} ريال </a>
                            </li>
                            @endcan
                            <li class="user-profile header-notification">
                                <a>
                                    <img src="{{ url("/storage/app/public/admins/arab.png") }}" class="img-radius" alt="User-Profile-Image">
                                    <span>{{ Auth::guard("admin")->user()->name }}</span>
                                    <i class="ti-angle-down"></i>
                                </a>
                                <ul class="show-notification profile-notification">
                                    
                                    @can('settings')
                                    <li>
                                        <a href="{{ url("admin/settings") }}">
                                            <i class="ti-settings"></i>اعدادات عامة
                                        </a>
                                    </li>
                                    @endcan
                                    
                                    @can('profile')
                                    <li>
                                        <a href="{{ url("/admin/admins/edit/" . Auth::guard("admin")->user()->id) }}">s
                                            <i class="ti-user"></i> حسابي
                                        </a>
                                    </li>
                                    @endcan
                                    <li>
                                        <a href="{{ url("/admin/logout") }}">
                                        <i class="ti-layout-sidebar-left"></i> تسجيل الخروج
                                    </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    <nav class="pcoded-navbar">
                        <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
                        <div class="pcoded-inner-navbar main-menu">
                            <div class="pcoded-navigation-label"></div>
                            <ul class="pcoded-item pcoded-left-item">

                             
                             @can('dashboard')
                                <li class="{{ ( Request::segment(2) == 'dashboard' ) ? 'active' : ''}}">
                                    <a href="{{ url('/admin/dashboard') }}">
                                        <span class="pcoded-micon"><i class="fa fa-area-chart"></i><b></b></span>
                                        <span class="pcoded-mtext">الاحصائيات</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                              @endcan  

                                
                                @can('countries')
                                <li class="{{ ( Request::segment(2) == 'countries' ) ? 'active' : ''}}">
                                    <a href="{{ url('/admin/countries') }}">
                                        <span class="pcoded-micon"><i class="fa fa-globe"></i><b></b></span>
                                        <span class="pcoded-mtext">الدول</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                                @endcan
                                
                                @can('cities')
                                <li class="{{ ( Request::segment(2) == 'cities' ) ? 'active' : ''}}">
                                    <a href="{{ url("/admin/cities") }}">
                                        <span class="pcoded-micon"><i class="fa fa-map-signs"></i><b></b></span>
                                        <span class="pcoded-mtext">المدن</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                                @endcan
                                
                                @can('pages')
                                <li class="{{ ( Request::segment(2) == 'pages' ) ? 'active' : ''}}">
                                    <a href="{{ url('/admin/pages') }}">
                                        <span class="pcoded-micon"><i class="icofont icofont-page"></i><b></b></span>
                                        <span class="pcoded-mtext">الصفحات الفرعية</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>

                                @endif

                                     <li class="{{ ( Request::segment(2) == 'advantages' ) ? 'active' : ''}}">
                                         <a href="{{ url('/admin/advantages') }}">
                                             <span class="pcoded-micon"><i class="icofont icofont-page"></i><b></b></span>
                                             <span class="pcoded-mtext">مميزات المطاعم</span>
                                             <span class="pcoded-mcaret"></span>
                                         </a>
                                     </li>


                                @can('categories')
                                <li class="pcoded-hasmenu {{ (Request::segment(2) == 'mainCategories' || Request::segment(2) == 'subCategories' || Request::segment(2) == 'mealCategories' || Request::segment(2) == 'foodCategories') ? ' pcoded-trigger active' : '' }}">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="fa fa-google-wallet"></i><b></b></span>
                                        <span class="pcoded-mtext">التصنيفات</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="{{ ( Request::segment(2) == 'mainCategories' ) ? 'active' : '' }}">
                                            <a href="{{ url("/admin/mainCategories") }}">
                                                <span class="pcoded-micon"><i class="ti-direction-alt"></i></span>
                                                <span class="pcoded-mtext">التصنيفات الاساسية</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>
                                        <li class="{{ ( Request::segment(2) == 'subCategories' ) ? 'active' : '' }}">
                                            <a href="{{ url("/admin/subCategories") }}">
                                                <span class="pcoded-micon"><i class="ti-direction-alt"></i></span>
                                                <span class="pcoded-mtext">التصنيفات الفرعية</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>
                                        <li class="{{ ( Request::segment(2) == 'mealCategories' ) ? 'active' : '' }}">
                                            <a href="{{ url("/admin/mealCategories") }}">
                                                <span class="pcoded-micon"><i class="ti-direction-alt"></i></span>
                                                <span class="pcoded-mtext">تصنيفات قائمة الطعام</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>
                                        <li class="{{ ( Request::segment(2) == 'foodCategories' ) ? 'active' : '' }}">
                                            <a href="{{ url("/admin/foodCategories") }}">
                                                <span class="pcoded-micon"><i class="ti-direction-alt"></i></span>
                                                <span class="pcoded-mtext">تصنيفات نوع الاكل</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                @endcan
                                @can('ticket_types')

                                <li class="{{ ( Request::segment(2) == 'ticketTypes' ) ? 'active' : ''}}">
                                    <a href="{{ url("/admin/ticketTypes") }}">
                                        <span class="pcoded-micon"><i class="fa fa-ticket"></i><b></b></span>
                                        <span class="pcoded-mtext">انواع التذاكر</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                                @endcan
                                @can('order_status')
                                <li class="{{ ( Request::segment(2) == 'orderstatus' ) ? 'active' : ''}}">
                                    <a href="{{ url("/admin/orderstatus") }}">
                                        <span class="pcoded-micon"><i class="fa fa-reorder"></i><b></b></span>
                                        <span class="pcoded-mtext">حالات الطلب</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                                @endif
                                @can('booking_status')
                                <li class="{{ ( Request::segment(2) == 'bookingstatus' ) ? 'active' : ''}}">
                                    <a href="{{ url("/admin/bookingstatus") }}">
                                        <span class="pcoded-micon"><i class="fa fa-tag"></i><b></b></span>
                                        <span class="pcoded-mtext">حالات الحجز</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>

                                @endcan
                                @can('crowd')

                                <li class="{{ ( Request::segment(2) == 'crowd' ) ? 'active' : ''}}">
                                    <a href="{{ url("/admin/crowd") }}">
                                        <span class="pcoded-micon"><i class="fa fa-unlock"></i><b></b></span>
                                        <span class="pcoded-mtext">حالات الازدحام</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                                @endcan

                                @can('meals')
                                <li class="{{ ( Request::segment(2) == 'meals' ) ? 'active' : ''}}">
                                    <a href="{{ url("/admin/meals") }}">
                                        <span class="pcoded-micon"><i class="fa fa-spoon"></i><b></b></span>
                                        <span class="pcoded-mtext">الوجبات</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>

                                @endcan
                                @can('offers')


                                <li class="pcoded-hasmenu {{ (Request::segment(2) == 'offers') ? ' pcoded-trigger active' : '' }}">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="fa fa-cubes"></i><b></b></span>
                                        <span class="pcoded-mtext">العروض</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="{{ ( Request::segment(4) == 'active' && Request::segment(2) == "offers" ) ? 'active' : '' }}">
                                            <a href="{{ url("/admin/offers/list/active") }}">
                                                <span class="pcoded-micon"><i class="ti-direction-alt"></i></span>
                                                <span class="pcoded-mtext">مفعل</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>
                                        <li class="{{ ( Request::segment(4) == 'notactive' && Request::segment(2) == "offers" ) ? 'active' : '' }}">
                                            <a href="{{ url("/admin/offers/list/notactive") }}">
                                                <span class="pcoded-micon"><i class="ti-direction-alt"></i></span>
                                                <span class="pcoded-mtext">غير مفعل</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>
                                        <li class="{{ ( Request::segment(4) == 'all' && Request::segment(2) == "offers" ) ? 'active' : '' }}">
                                            <a href="{{ url("/admin/offers/list/all") }}">
                                                <span class="pcoded-micon"><i class="ti-direction-alt"></i></span>
                                                <span class="pcoded-mtext">الكل</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                @endcan
                                @can('orders')

                                <li class="{{ ( Request::segment(2) == 'orders' ) ? 'active' : ''}}">
                                    <a href="{{ url("/admin/orders") }}">
                                        <span class="pcoded-micon"><i class="fa fa-shopping-cart"></i><b></b></span>
                                        <span class="pcoded-mtext">الطلبات</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>

                                @endcan
                                @can('reservations')

                                <li class="{{ ( Request::segment(2) == 'reservations' ) ? 'active' : ''}}">
                                    <a href="{{ url("admin/reservations") }}">
                                        <span class="pcoded-micon"><i class="fa fa-wheelchair-alt"></i><b></b></span>
                                        <span class="pcoded-mtext">الحجوزات</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>

                                @endcan
                                @can('tickets')

                                <li class="pcoded-hasmenu {{ (Request::segment(2) == 'tickets') ? ' pcoded-trigger active' : '' }}">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="fa fa-envelope-square"></i><b></b></span>
                                        <span class="pcoded-mtext">التذاكر</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="{{ (Request::segment(2) == 'tickets' && Request::segment(3) == '0') ? 'active' : '' }}">
                                            <a href="{{ url("admin/tickets/0") }}">
                                                <span class="pcoded-micon"><i class="ti-direction-alt"></i></span>
                                                <span class="pcoded-mtext">التجار</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>
                                        <li class="{{ (Request::segment(2) == 'tickets' && Request::segment(3) == '1') ? 'active' : '' }}">
                                            <a href="{{ url("admin/tickets/1") }}">
                                                <span class="pcoded-micon"><i class="ti-direction-alt"></i></span>
                                                <span class="pcoded-mtext">العملاء</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>

                                    </ul>
                                </li>

                                @endcan
                                @can('notifications')

                                <li class="pcoded-hasmenu {{ (Request::segment(2) == 'notifications') ? ' pcoded-trigger active' : '' }}">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="fa fa-bell-slash"></i><b></b></span>
                                        <span class="pcoded-mtext">الاشعارات</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="{{ (Request::segment(2) == 'notifications' && Request::segment(4) == 'users') ? 'active' : '' }}">
                                            <a href="{{ url("admin/notifications/list/users") }}">
                                                <span class="pcoded-micon"><i class="ti-direction-alt"></i></span>
                                                <span class="pcoded-mtext">اشعارات المستخدمين</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>
                                        <li class="{{ (Request::segment(2) == 'notifications' && Request::segment(4) == 'providers') ? 'active' : '' }}">
                                            <a href="{{ url("admin/notifications/list/providers") }}">
                                                <span class="pcoded-micon"><i class="ti-direction-alt"></i></span>
                                                <span class="pcoded-mtext">اشعارات المطاعم</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>

                                    </ul>
                                </li>

                                @endcan
                                @can('comments')

                                <li class="{{ ( Request::segment(2) == 'comments' ) ? 'active' : ''}}">
                                    <a href="{{ url("admin/comments/list") }}">
                                        <span class="pcoded-micon"><i class="fa fa-comments"></i><b></b></span>
                                        <span class="pcoded-mtext">التعليقات</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>

                                @endcan

                                
                                @can('roles')
                                  <li class="{{ ( Request::segment(2) == 'roles' ) ? 'active' : ''}}">
                                    <a href="{{ route('admin.roles.index')}}">
                                        <span class="pcoded-micon"><i class="fa fa-user-secret"></i><b></b></span>
                                        <span class="pcoded-mtext">الصلاحيات </span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                                @endcan
 

                                 @if(Gate::check('providers') || Gate::check('users'))
                                <li class="pcoded-hasmenu {{ (Request::segment(2) == 'customers' || Request::segment(2) == 'providers') ? ' pcoded-trigger active' : '' }}">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="fa fa-users"></i><b></b></span>
                                        <span class="pcoded-mtext">أعضاء التطبيق</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                       @can('users')
                                       <li class="pcoded-hasmenu {{ (Request::segment(2) == 'customers') ? ' pcoded-trigger' : '' }}">
                                            <a href="javascript:void(0)">
                                                <span class="pcoded-micon"><i class="ti-direction-alt"></i></span>
                                                <span class="pcoded-mtext">العملاء</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                            <ul class="pcoded-submenu">
                                                <li class="{{ (Request::segment(2) == 'customers' && Request::segment(3) == 'all') ? ' active' : '' }}">
                                                    <a href="{{ url("/admin/customers/all") }}">
                                                        <span class="pcoded-micon"><i class="ti-direction-alt"></i></span>
                                                        <span class="pcoded-mtext">الكل</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                                <li class="{{ (Request::segment(2) == 'customers' && Request::segment(3) == 'activated') ? ' active' : '' }}">
                                                    <a href="{{ url("/admin/customers/activated") }}">
                                                        <span class="pcoded-micon"><i class="ti-direction-alt"></i></span>
                                                        <span class="pcoded-mtext">المفعلين</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                                <li class="{{ (Request::segment(2) == 'customers' && Request::segment(3) == 'deactivated') ? ' active' : '' }}">
                                                    <a href="{{ url("/admin/customers/deactivated") }}">
                                                        <span class="pcoded-micon"><i class="ti-direction-alt"></i></span>
                                                        <span class="pcoded-mtext">الغير مفعلين</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        @endcan
                                        @can('providers')
                                        <li class="pcoded-hasmenu {{ (Request::segment(2) == 'providers') ? ' pcoded-trigger' : '' }}">
                                            <a href="javascript:void(0)">
                                                <span class="pcoded-micon"><i class="ti-direction-alt"></i></span>
                                                <span class="pcoded-mtext">المطاعم</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                            <ul class="pcoded-submenu">
                                                <li class="{{ (Request::segment(2) == 'providers' && Request::segment(3) == 'all') ? ' active' : '' }}">
                                                    <a href="{{ url("/admin/providers/all") }}">
                                                        <span class="pcoded-micon"><i class="ti-direction-alt"></i></span>
                                                        <span class="pcoded-mtext">الكل</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                                <li class="{{ (Request::segment(2) == 'providers' && Request::segment(3) == 'activated') ? ' active' : '' }}">
                                                    <a href="{{ url("/admin/providers/activated") }}">
                                                        <span class="pcoded-micon"><i class="ti-direction-alt"></i></span>
                                                        <span class="pcoded-mtext">المفعلين</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                                <li class="{{ (Request::segment(2) == 'providers' && Request::segment(3) == 'deactivated') ? ' active' : '' }}">
                                                    <a href="{{ url("/admin/providers/deactivated") }}">
                                                        <span class="pcoded-micon"><i class="ti-direction-alt"></i></span>
                                                        <span class="pcoded-mtext">الغير مفعلين</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        @endcan

                                    </ul>
                                </li>
                                @endif

                               @can('withdraws')
                                <li class="{{ ( Request::segment(2) == 'withdraws' ) ? 'active' : ''}}">
                                        <a href="{{ url("admin/withdraws") }}">
                                        <span class="pcoded-micon"><i class="fa fa-money"></i><b></b></span>
                                        <span class="pcoded-mtext">طلبات سحب الرصيد</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                                @endcan


                                 @can('withdraws')

                                     <li class="pcoded-hasmenu {{ (Request::segment(2) == 'balances') ? ' pcoded-trigger active' : '' }}">
                                         <a href="javascript:void(0)">
                                             <span class="pcoded-micon"><i class="fa fa-money"></i><b></b></span>
                                             <span class="pcoded-mtext"> الارصدة </span>
                                             <span class="pcoded-mcaret"></span>
                                         </a>
                                         <ul class="pcoded-submenu">
                                             <li class="{{ (Request::segment(2) == 'balances' && Request::segment(4) == 'user') ? 'active' : '' }}">
                                                 <a href="{{ url("admin/balances/list/user") }}">
                                                     <span class="pcoded-micon"><i class="ti-direction-alt"></i></span>
                                                     <span class="pcoded-mtext"> ارصده المستخدمين</span>
                                                     <span class="pcoded-mcaret"></span>
                                                 </a>
                                             </li>
                                             <li class="{{ (Request::segment(2) == 'balances' && Request::segment(4) == 'provider') ? 'active' : '' }}">
                                                 <a href="{{ url("admin/balances/list/provider") }}">
                                                     <span class="pcoded-micon"><i class="ti-direction-alt"></i></span>
                                                     <span class="pcoded-mtext">ارصدة المطاعم</span>
                                                     <span class="pcoded-mcaret"></span>
                                                 </a>
                                             </li>

                                         </ul>
                                     </li>

                                 @endcan

                            </ul>

                             @if(Gate::check('settings') || Gate::check('users'))
                               <div class="pcoded-navigation-label">الاعدادات</div>
                              @endif
                            <ul class="pcoded-item pcoded-left-item">
                                @can('settings')
                                <li class="{{ ( Request::segment(2) == 'settings' ) ? 'active' : ''}}">
                                    <a href="{{ url("/admin/settings") }}">
                                        <span class="pcoded-micon"><i class="fa fa-cogs"></i><b></b></span>
                                        <span class="pcoded-mtext">اعدادات عامة</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                                @endcan
                                @can('admins')
                                <li class="{{ ( Request::segment(2) == 'admins' ) ? 'active' : ''}}">
                                    <a href="{{ url("/admin/admins") }}">
                                        <span class="pcoded-micon"><i class="fa fa-user-secret"></i><b></b></span>
                                        <span class="pcoded-mtext">المستخدمين</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                                @endcan



                            </ul>

                            

                        </div>
                    </nav>
                    <div class="pcoded-content">
                        <div class="pcoded-inner-content">
                            <!-- Main-body start -->
                            <div class="main-body">
                                <div class="page-wrapper">
                                    <!-- Page body start -->
                                            @yield('content')
                                    <!-- Page body end -->
                                </div>
                            </div>
                            <!-- Main-body end -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modall"><!-- Place at bottom of page --></div>

    <!-- Warning Section Ends -->
    <!-- Required Jquery -->
    <script  src="{{asset('assets/admin_panel/bower_components/jquery/js/jquery.min.js') }}"></script>
    <script  src="{{asset('assets/admin_panel/bower_components/jquery-ui/js/jquery-ui.min.js')}}"></script>
    <script  src="{{asset('assets/admin_panel/bower_components/popper.js/js/popper.min.js')}}"></script>
    <script  src="{{asset('assets/admin_panel/bower_components/bootstrap/js/bootstrap.min.js')}}"></script>
    
    
    <script>
        
          $body = $("body");

        $(document).on({
              ajaxSart: function() { $body.addClass("loading");    },
              ajaxStop: function() { $body.removeClass("loading"); }    
        });


    </script>
    
      @yield('script')
      
    <!-- jquery slimscroll js -->
    <script  src="{{asset('assets/admin_panel/bower_components/jquery-slimscroll/js/jquery.slimscroll.js')}}"></script>
    <!-- modernizr js -->
  
    <script  src="{{asset('assets/admin_panel/bower_components/modernizr/js/modernizr.js')}}"></script>
    <script  src="{{asset('assets/admin_panel/bower_components/modernizr/js/css-scrollbars.js')}}"></script>
    <!-- Syntax highlighter prism js -->
    <script  src="{{asset('assets/admin_panel/pages/prism/custom-prism.js')}}"></script>
    <!-- Custom js -->
    <script src="{{asset('assets/admin_panel/js/pcoded.min.js')}}"></script>
    <script src="{{asset('assets/admin_panel/js/vertical/menu/menu-rtl.js')}}"></script>
    <script src="{{asset('assets/admin_panel/js/jquery.mCustomScrollbar.concat.min.js')}}"></script>
    <script  src="{{asset('assets/admin_panel/js/script.js')}}"></script>
     <!-- data-table js -->
    <script src="{{asset('assets/admin_panel/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/admin_panel/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('assets/admin_panel/pages/data-table/js/jszip.min.js')}}"></script>
    <script src="{{asset('assets/admin_panel/pages/data-table/js/pdfmake.min.js')}}"></script>
    <script src="{{asset('assets/admin_panel/pages/data-table/js/vfs_fonts.js')}}"></script>
    <script src="{{asset('assets/admin_panel/bower_components/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('assets/admin_panel/bower_components/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('assets/admin_panel/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/admin_panel/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('assets/admin_panel/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>
    <!-- Custom js -->
    <script src="{{asset('assets/admin_panel/pages/data-table/js/data-table-custom.js')}}"></script>
    <!-- sweet alert js -->
    <script  src="{{asset('assets/admin_panel/bower_components/sweetalert/js/sweetalert.min.js')}}"></script>
    <script  src="{{asset('assets/admin_panel/js/modal.js')}}"></script>
    <!-- sweet alert modal.js intialize js -->
    <!-- modalEffects js nifty modal window effects -->
    <script src="{{asset('assets/admin_panel/js/classie.js')}}"></script>
    <script  src="{{asset('assets/admin_panel/js/modalEffects.js')}}"></script>
    <!-- Bootstrap date-time-picker js -->
    <script  src="{{asset('assets/admin_panel/pages/advance-elements/moment-with-locales.min.js')}}"></script>
    <script  src="{{asset('assets/admin_panel/bower_components/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script  src="{{asset('assets/admin_panel/pages/advance-elements/bootstrap-datetimepicker.min.js')}}"></script>
    <!-- Date-range picker js -->
    <script  src="{{asset('assets/admin_panel/bower_components/bootstrap-daterangepicker/js/daterangepicker.js')}}"></script>
    <!-- Date-dropper js -->
    <script  src="{{asset('assets/admin_panel/bower_components/datedropper/js/datedropper.min.js')}}"></script>
    <!-- ck editor -->
    <script src="{{asset('assets/admin_panel/pages/ckeditor/ckeditor.js')}}"></script>
    <!-- echart js -->
    <script src="{{asset('assets/admin_panel/pages/user-profile.js')}}"></script>
    <!-- pnotify js -->
    <script  src="{{asset('assets/admin_panel/bower_components/pnotify/js/pnotify.js')}}"></script>
    <script  src="{{asset('assets/admin_panel/bower_components/pnotify/js/pnotify.desktop.js')}}"></script>
    <script  src="{{asset('assets/admin_panel/bower_components/pnotify/js/pnotify.buttons.js')}}"></script>
    <script  src="{{asset('assets/admin_panel/bower_components/pnotify/js/pnotify.confirm.js')}}"></script>
    <script  src="{{asset('assets/admin_panel/bower_components/pnotify/js/pnotify.callbacks.js')}}"></script>
    <script  src="{{asset('assets/admin_panel/bower_components/pnotify/js/pnotify.animate.js')}}"></script>
    <script  src="{{asset('assets/admin_panel/bower_components/pnotify/js/pnotify.history.js')}}"></script>
    <script  src="{{asset('assets/admin_panel/bower_components/pnotify/js/pnotify.mobile.js')}}"></script>
    <script  src="{{asset('assets/admin_panel/bower_components/pnotify/js/pnotify.nonblock.js')}}"></script>
    <script  src="{{asset('assets/admin_panel/pages/pnotify/notify.js')}}"></script>
    <script src="{{asset('assets/admin_panel/pages/wysiwyg-editor/js/tinymce.min.js')}}"></script>
    <script src="{{asset('assets/admin_panel/pages/wysiwyg-editor/wysiwyg-editor.js')}}"></script>
    <!-- jquery file upload js -->
    <script src="{{asset('assets/admin_panel/pages/jquery.filer/js/jquery.filer.min.js')}}"></script>
    <script src="{{asset('assets/admin_panel/pages/filer/custom-filer.js')}}" ></script>
    <script src="{{asset('assets/admin_panel/pages/filer/jquery.fileuploads.init.js')}}" ></script>
    <!-- Model animation js -->
    <script src="{{asset('assets/admin_panel/js/classie.js')}}"></script>
    <script src="{{asset('assets/admin_panel/js/modalEffects.js')}}"></script>
    <!-- product list js -->
    <script  src="{{asset('assets/admin_panel/pages/product-list/product-list.js')}}"></script>
     <!-- barrating js -->
    <script  src="{{asset('assets/admin_panel/bower_components/jquery-bar-rating/js/jquery.barrating.min.js')}}"></script>
    <script  src="{{asset('assets/admin_panel/pages/rating/rating.js')}}"></script>
    <!-- slick js -->
    <script  src="{{asset('assets/admin_panel/bower_components/slick-carousel/js/slick.min.js')}}"></script>
    <!-- product detail js -->
    <script  src="{{asset('assets/admin_panel/pages/product-detail/product-detail.js')}}"></script>
    <!-- task board js -->
    <script  src="{{asset('assets/admin_panel/pages/task-board/task-board.js')}}"></script>
    <script  src="{{asset('assets/admin_panel/js/logic.js')}}"></script>
    <script src="{{ asset("/assets/site/js/notifIt.min.js") }}"></script>

    <!--<script src="https://www.gstatic.com/firebasejs/5.8.5/firebase.js"></script>-->
    <!--<script>-->
     <!--    var config = {-->
    <!--        apiKey: "AIzaSyAjZMZO0NND0J5jwZUR9Y6RcgOIBH-3hlM",-->
    <!--        authDomain: "mjrb-22164.firebaseapp.com",-->
    <!--        databaseURL: "https://mjrb-22164.firebaseio.com",-->
    <!--        projectId: "mjrb-22164",-->
    <!--        storageBucket: "mjrb-22164.appspot.com",-->
    <!--        messagingSenderId: "43874408605"-->
    <!--    };-->
    <!--    firebase.initializeApp(config);-->
    <!--</script>-->
    <!--<script src="{{ asset("/assets/push_notification/js/push.js") }}"></script>-->


</body>

</html>
