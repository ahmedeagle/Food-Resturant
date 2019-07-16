@section('main')

            @if($week_days)
                @foreach($week_days as $key => $value)
                    @php
                        $start_time = $key . "_start_work";
                        $end_time = $key . "_end_work";
                    @endphp
                    @component('User.includes.working-time')
                
                        @slot('en_name')
                            {{ $key }}
                        @endslot
                
                        @slot('ar_name')
                            {{ $value }}
                        @endslot
                
                        @slot("start_time")
                            {{ $working_hours->$start_time }}
                        @endslot
                        @slot("end_time")
                            {{ $working_hours->$end_time }}
                        @endslot
                    @endcomponent
                
                @endforeach
            @endif    
            
            
            @if($type == 'create')
            
            <button type="button" class="prev-work btn btn-primary py-2 px-5">السابق</button>
            <button type="button" class="next-cats btn btn-default py-2 px-5">التالى</button>
            @elseif($type == 'edit')
              <button type="submit" class="btn btn-primary py-2 px-5 submit_edit_form"> تعديل </button>
            @else
            
            @endif
@stop