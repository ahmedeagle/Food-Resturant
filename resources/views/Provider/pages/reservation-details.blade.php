
<img class="ml-3 rounded-circle mb-lg-0 mb-3"
     src="http://placehold.it/70x70"
     alt="Generic placeholder image">

<div class="media-body">

    <h5 class="mt-0 text-lg-right text-center font-body-bold font-size-base">
        {{ $reservationDetails->username }}
    </h5>

    <p class="text-gray font-body-md mb-0">
                            <span class="d-block">
                                {{trans('site.reservation_num')}}: <span class="reservation-number">{{ $reservationDetails->reservation_code }}</span>
                            </span>
        <span class="d-block">
                               {{trans('site.person_num')}}: <span class="reservation-person">{{ $reservationDetails->seats_number }}</span>
                            </span>
        <span class="d-block">
        <span class="reservation-date">
           {{trans('site.time_date')}}
            <time datetime="2018-10-25 17:30">
                {{ $reservationDetails->reservation_date }} - {{ $reservationDetails->time_extention }} {{ $reservationDetails->reservation_time }}
            </time>
        </span>
    </span>
    </p>
                            @if(!empty($reservationDetails -> special_reservation) && $reservationDetails -> special_reservation !=null )
                                <p>                                    
                                      {{trans('site.occasion_description')}} <br>

                                     
                                </p>

                                 <span class="text-gray font-body-md mb-0">  
                                      {{$reservationDetails -> occasion_description}}
                                  </span>
                            @endif

    <div class="reservation-confirm mt-1 text-center text-sm-right">
        <button class="btn btn-primary px-xl-5 px-md-3 px-sm-5 px-5 ml-0 mt-2 ml-sm-2"
                type="submit" >
           {{trans('site.cancel_reservation')}} <br>
        </button>
        <button class="btn btn-primary px-xl-5 px-md-3 px-sm-5 px-5 mt-2"
                type="submit">
            {{trans('site.confirm_reservation')}} <br>
        </button>
    </div>
</div><!-- .media-body -->
