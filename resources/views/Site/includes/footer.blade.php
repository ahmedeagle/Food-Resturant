<footer class="site-footer">

    <div class="footer-info py-5 bg-dark">
        <div class="container">
            <div class="row">
                <div class="col-xl-7 col-lg-6 col-md-5 col-12 text-md-right text-center mb-3 mb-md-0">
                    <a href="{{ url("/") }}">
                        <img src="{{ url("assets/site/img/footer-logo.png") }}"
                             width="115"
                             height="56"
                             alt="Site Logo">
                    </a>
                </div>

                <div class="col-xl-5 col-lg-6 col-md-7 col-sm-12">
                    <ul class="navbar-nav pr-0 flex-column flex-md-row justify-content-md-between font-body-bold">
                        <li class="nav-item text-center">
                            <a href="@if(auth('provider')->check()) {{ url("/restaurant/page/2") }} @elseif(auth()->check()) {{ url("/user/page/2") }} @else {{ url("/page/2") }} @endif" class="nav-link text-white">
                                {{trans('site.privacy')}}
                            </a>
                        </li>
                        <li class="nav-item text-center">
                            <a href="@if(auth('provider')->check()) {{ url("/restaurant/page/1") }} @elseif(auth()->check()) {{ url("/user/page/1") }} @else {{ url("/page/1") }} @endif" class="nav-link text-white">
                                 {{trans('site.usage')}}
                            </a>
                        </li>
                        <li class="nav-item text-center">
                            <a href="@if(auth('provider')->check()) {{ url("/restaurant/contact-us/open-new-ticket") }} @elseif(auth()->check()) {{ url("/user/tickets") }} @else {{ url("/#contact") }} @endif" class="nav-link text-white ml-md-0 pl-md-0">
                                {{trans('site.contact_us')}}
                            </a>
                        </li>
                    </ul>
                </div>
            </div><!-- .row -->
        </div><!-- .container -->
    </div><!-- .footer-info -->

    <div class="footer-copyright py-3 bg-body text-white">
        <div class="container">
            <div class="d-flex flex-sm-row flex-column justify-content-sm-between justify-content-center">

                <p class="copyright d-sm-block d-flex justify-content-center">{{trans('site.copyright')}} 2018 ©</p>

                <p class="copyright d-sm-block d-flex justify-content-center"> {{trans('site.developedBy')}} WISYST</p>

            </div><!-- .d-flex -->
        </div><!-- .container -->
    </div><!-- .copyright -->

</footer><!-- .site-footer -->