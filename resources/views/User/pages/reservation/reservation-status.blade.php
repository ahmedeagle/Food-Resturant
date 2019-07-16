
@if($slot == "1")

    <a href="{{ url("/user/reservations/reservation-details/" . $id) }}"
       class="btn btn-pending mt-3 mt-lg-0 text-white font-body-md px-3 rounded-curved">
        {{ $statusname }}
    </a>

@elseif($slot == "2")

    <a href="{{ url("/user/reservations/reservation-details/" . $id) }}"
       class="btn btn-success mt-3 mt-lg-0 text-white font-body-md px-3 rounded-curved">
        {{ $statusname }}
    </a>

@elseif($slot == "3")

    <a href="{{ url("/user/reservations/reservation-details/" . $id) }}"
       class="btn btn-danger mt-3 mt-lg-0 text-white font-body-md px-3 rounded-curved">
        {{ $statusname }}
    </a>

@elseif($slot == "4")

    <a href="{{ url("/user/reservations/reservation-details/" . $id) }}"
       class="btn btn-warning mt-3 mt-lg-0 text-white font-body-md px-3 rounded-curved">
        {{ $statusname }}
    </a>

@endif




