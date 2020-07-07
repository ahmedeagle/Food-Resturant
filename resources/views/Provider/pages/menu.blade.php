<div class="col-lg-3 col-md-4 col-12">
    <div class="rounded-bottom-lg rounded-top-lg shadow-around-lg overflow-hidden">
        <h4 class="welcome mb-0 bg-primary text-light p-3 font-body-bold">
            {{trans('site.hello_mjrb')}}
        </h4>
        <ul class="nav flex-column font-body-md pr-0 py-3">
            @if(auth("provider")->check())
                <li class="nav-item">
                    <a class="nav-link {{ ( Request::segment(2) == 'dashboard' ) ? 'text-secondary' : 'text-gray'}}"
                       href="{{ url("/restaurant/dashboard") }}">
                        <img src="{{ url('/assets/site/img/icons/home.svg') }}"
                             class="ml-1"
                             width="24"
                             height="24"
                             alt="Home icon">
                        {{trans('site.home')}}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ ( Request::segment(2) == 'profile' ) ? 'text-secondary' : 'text-gray'}}"
                       href="{{ url("/restaurant/profile") }}">
                        <img src="{{ url("/assets/site/img/icons/file.svg") }}"
                             class="ml-1"
                             width="24"
                             height="18"
                             alt="File icon">
                        {{trans('site.profile')}}
                    </a>
                </li>
                {{--<li class="nav-item">--}}
                {{--<a class="nav-link {{ ( Request::segment(2) == 'food-menu' ) ? 'text-secondary' : 'text-gray'}}" href="{{ url("/restaurant/food-menu") }}">--}}
                {{--<img src="{{ url("assets/site/img/icons/menu.svg") }}"--}}
                {{--class="ml-1"--}}
                {{--width="24"--}}
                {{--height="24"--}}
                {{--alt="Menu icon">--}}
                {{--قائمة الطعام--}}
                {{--</a>--}}

                {{--</li>--}}



                <li class="nav-item">
                    <div class="accordion" id="dropdown">
                        <a class="nav-link dropdown-toggle {{ ( Request::segment(2) == 'food-menu' && Request::segment(3) == '' ) ? 'text-secondary' : 'text-gray'}}"
                           href="{{ url("/restaurant/food-menu") }}" role="button">
                            <img src="{{ url("assets/site/img/icons/menu.svg") }}"
                                 class="ml-1"
                                 width="24"
                                 height="24"
                                 alt="Menu icon">
                            {{trans('site.food_list')}}
                        </a>

                        <div class="collapse pr-3 {{ ( Request::segment(2) == 'food-menu') ? 'show' : ''}}"
                             id="dropdown-menu"
                             aria-labelledby="dropdownMenuLink"
                             data-parent="#dropdown">
                            <a class="dropdown-item bg-white {{ ( Request::segment(2) == 'food-menu' && Request::segment(3) == 'list') ? 'text-secondary' : 'text-gray'}}"
                               href="{{ url("/restaurant/food-menu/list") }}"> {{trans('site.all_meals')}}  </a>
                            <a class="dropdown-item bg-white {{ ( Request::segment(2) == 'food-menu' && Request::segment(3) == 'add-new-meal') ? 'text-secondary' : 'text-gray'}}"
                               href="{{ url("/restaurant/food-menu/add-new-meal") }}">  {{trans('site.new_meal')}}</a>
                            <a class="dropdown-item bg-white {{ ( Request::segment(2) == 'food-menu' && Request::segment(3) == 'categories') ? 'text-secondary' : 'text-gray'}}"
                               href="{{ url("/restaurant/food-menu/categories") }}">{{trans('site.categories')}}</a>
                        </div>
                    </div>
                </li>


                <li class="nav-item">
                    <a class="nav-link {{ ( Request::segment(2) == 'branches' ) ? 'text-secondary' : 'text-gray'}}"
                       href="{{ url("/restaurant/profile/change-meal-type") }}">
                        <img src="{{ url("/assets/site/img/icons/branch.svg") }}"
                             class="ml-1"
                             width="24"
                             height="21"
                             alt="Branch icon">
                        {{trans('site.food_type')}}
                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link {{ ( Request::segment(2) == 'branches' ) ? 'text-secondary' : 'text-gray'}}"
                       href="{{ url("/restaurant/profile/change-resturant-categories") }}">
                        <img src="{{ url("/assets/site/img/icons/branch.svg") }}"
                             class="ml-1"
                             width="24"
                             height="21"
                             alt="Branch icon">
                        {{trans('site.resturant_categories')}}
                    </a>
                </li>



                <li class="nav-item">
                    <a class="nav-link {{ ( Request::segment(2) == 'branches' ) ? 'text-secondary' : 'text-gray'}}"
                       href="{{ url("/restaurant/profile/change-map-address") }}">
                        <img src="{{ url("/assets/site/img/icons/branch.svg") }}"
                             class="ml-1"
                             width="24"
                             height="21"
                             alt="Branch icon">

                        {{trans('site.location_on_map')}}
                    </a>
                </li>






                <li class="nav-item">
                    <a class="nav-link {{ ( Request::segment(2) == 'branches' ) ? 'text-secondary' : 'text-gray'}}"
                       href="{{ url("/restaurant/branches/list") }}">
                        <img src="{{ url("/assets/site/img/icons/branch.svg") }}"
                             class="ml-1"
                             width="24"
                             height="21"
                             alt="Branch icon">
                        {{trans('site.branches')}}
                    </a>
                </li>
            @endif

            <li class="nav-item">
                <a class="nav-link {{ ( Request::segment(2) == 'reservations' ) ? 'text-secondary' : 'text-gray'}}"
                   href="{{ url("/restaurant/reservations/list/1") }}">
                    <img src="{{ url("/assets/site/img/icons/reservations.svg") }}"
                         class="ml-1"
                         width="24"
                         height="22"
                         alt="Reservations icon">
                    {{trans('site.reservations')}}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ ( Request::segment(2) == 'orders' ) ? 'text-secondary' : 'text-gray'}}"
                   href="{{ url("/restaurant/orders/list/1") }}">
                    <img src="{{ url("/assets/site/img/icons/orders.svg") }}"
                         class="ml-1"
                         width="24"
                         height="22"
                         alt="Orders icon">
                    {{trans('site.orders')}}
                </a>
            </li>


            @if (auth('branch')->check())
                <li class="nav-item">
                    <a class="nav-link {{ ( Request::segment(2) == 'congestion' ) ? 'text-secondary' : 'text-gray'}}"
                       href="{{ url("/restaurant/congestion") }}">
                        <img src="{{ url("/assets/site/img/icons/sub-page.svg") }}"
                             class="ml-1"
                             width="24"
                             height="22"
                             alt="congestion icon">
                        {{trans('site.congestion')}}
                    </a>
                </li>

            @endif


            @foreach(  \App\Http\Controllers\Provider\GeneralController::get_pages_list() as $page)
                <li class="nav-item">
                    <a class="nav-link {{ ( Request::segment(2) == 'page' && Request::segment(3) == $page->id) ? 'text-secondary' : 'text-gray'}}"
                       href="{{ url("/restaurant/page/" . $page->id) }}">
                        <img src="{{ url("/assets/site/img/icons/sub-page.svg") }}"
                             class="ml-1"
                             width="24"
                             height="22"
                             alt="Sub Page icon">
                        {{ $page->title}}
                    </a>
                </li>
            @endforeach
            @if(auth("provider")->check())
                <li class="nav-item">
                    <a class="nav-link {{ ( Request::segment(2) == 'contact-us' ) ? 'text-secondary' : 'text-gray'}}"
                       href="{{ url("/restaurant/contact-us") }}">
                        <img src="{{ url("/assets/site/img/icons/contact.svg") }}"
                             class="ml-1"
                             width="24"
                             height="22"
                             alt="Contact icon">
                        {{trans('site.contact_us')}}
                    </a>
                </li>
            @endif


            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)

                @if(LaravelLocalization::getCurrentLocale()  != $localeCode )
                    <li class="nav-item">
                        <a class="nav-link text-gray" rel="alternate" hreflang="{{ $localeCode }}"
                           href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                            <i class="fa fa-gloable"></i>
                            {{ $properties['native'] }}
                        </a>
                    </li>
                @endif
            @endforeach

            <li class="nav-item">
                <a class="nav-link text-gray" href="{{ url("/restaurant/logout") }}">
                    <img src="{{ url("/assets/site/img/icons/log-out.svg") }}"
                         class="ml-1"
                         width="24"
                         height="22"
                         alt="Logout icon">
                    {{trans('site.logout')}}
                </a>
            </li>
        </ul>
    </div>
</div><!-- .col-* -->