<div class="row {{ $en_name }}">
    <div class="col">
        <p>{{ $ar_name }}</p>
        <div class="form-group row">
            <div class="col-lg-6 col-12">
                <div class="row">
                    <label for="{{ $en_name }}-start-working-hours-select"
                           class="col-form-label col-auto">من:</label>
                    <div class="col pr-md-0">
                        <select class="working-hours custom-select text-gray font-body-md border-gray"
                                id="{{ $en_name }}-start-working-hours-select" required>
                            <option value="">مغلق</option>
                            @component("Provider.includes.working-hours-options")

                                @slot("time")
                                    {{ ($start_time) ? $start_time : null }}
                                @endslot
                                
                            @endcomponent
                            {{--@include("Provider.includes.working-hours-options")--}}
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-12 mt-3 mt-lg-auto">
                <div class="row">
                    <label for="{{ $en_name }}-end-working-hours-select"
                           class="col-form-label col-auto">إلى:</label>
                    <div class="col pr-md-0">
                        <select class="working-hours custom-select text-gray font-body-md border-gray"
                                id="{{ $en_name }}-end-working-hours-select">
                            <option value="">مغلق</option>
                            @component("Provider.includes.working-hours-options")

                                @slot("time")
                                    {{ $end_time }}
                                @endslot
                            @endcomponent
                            {{--@include("Provider.includes.working-hours-options")--}}
                        </select>
                    </div>
                </div>
            </div>
        </div><!-- .form-group booking-status -->
    </div><!-- .col -->
</div><!-- .row saturday -->