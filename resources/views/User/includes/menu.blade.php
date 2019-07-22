<div class="col-lg-3 col-md-4 col-12">
    <div class="rounded-bottom-lg rounded-top-lg shadow-around-lg overflow-hidden bg-white">
        <h4 class="welcome mb-0 bg-primary text-light p-3 font-body-bold">
           {{trans('site.hello_mjrb')}}
        </h4>
        <ul class="nav flex-column font-body-md pr-0 py-3">
            <li class="nav-item">
                <a class="nav-link {{ ( Request::segment(2) == 'dashboard' ) ? 'text-secondary' : 'text-gray'}}" href="{{ url('/user/dashboard') }}">
                    <img src="{{ url('/assets/site/img/icons/home.svg') }}"
                         class="ml-1"
                         width="24"
                         height="24"
                         alt="Home icon">
                    {{trans('site.home')}}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ ( Request::segment(2) == 'profile' ) ? 'text-secondary' : 'text-gray'}}" href="{{ url('/user/profile') }}">
                    <img src="{{ url('/assets/site/img/icons/user-profile.svg') }}"
                         class="ml-1"

                         alt="File icon">
                    {{trans('site.profile')}}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ ( Request::segment(2) == 'reservations' ) ? 'text-secondary' : 'text-gray'}}" href="{{ url('/user/reservations') }}">
                    <img src="{{ url('/assets/site/img/icons/reservations.svg') }}"
                         class="ml-1"
                         width="24"
                         height="22"
                         alt="Reservations icon">
                     {{trans('site.reservations')}}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ ( Request::segment(2) == 'orders' ) ? 'text-secondary' : 'text-gray'}}" href="{{ url('/user/orders') }}">
                    <img src="{{ url('/assets/site/img/icons/orders.svg') }}"
                         class="ml-1"
                         width="24"
                         height="22"
                         alt="Orders icon">
                    {{trans('site.orders')}}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ ( Request::segment(2) == 'favorites' ) ? 'text-secondary' : 'text-gray'}}" href="{{ url('/user/favorites') }}">
                    <img src="{{ url('/assets/site/img/icons/favourite.svg') }}"
                         class="ml-1"
                         alt="Menu icon">
                    ا {{trans('site.favourite')}}
                </a>
            </li>
            @foreach(  \App\Http\Controllers\Provider\GeneralController::get_pages_list() as $page)

            <li class="nav-item">
                <a class="nav-link {{ ( Request::segment(2) == 'page' && Request::segment(3) == $page->id ) ? 'text-secondary' : 'text-gray'}}" href="{{ url('/user/page/' . $page->id) }}">
                    <img src="{{ url('/assets/site/img/icons/sub-page.svg') }}"
                         class="ml-1"
                         width="24"
                         height="22"
                         alt="Sub Page icon">
                    {{ $page->title }}
                </a>
            </li>

            @endforeach
            <li class="nav-item">
                <a class="nav-link {{ ( Request::segment(2) == 'tickets' ) ? 'text-secondary' : 'text-gray'}}" href="{{ url('/user/tickets') }}">
                    <img src="{{ url('/assets/site/img/icons/contact.svg') }}"
                         class="ml-1"
                         width="24"
                         height="22"
                         alt="Contact icon">
                 {{trans('site.contact_us')}}
                </a>
            </li>


            <ul>
  
</ul>


            <li class="nav-item">
                <a class="nav-link text-gray" href="{{ url('/user/logout') }}">
                    <img src="{{ url('/assets/site/img/icons/log-out.svg'}}"
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