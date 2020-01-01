@section('main')
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">أختر الفرع </label>
        <div class="col-sm-10">

            <select class="form-control" id="branches" name="branch">
                <option value="">برجاء اختيار الفرع</option>
                <option value="0">يوجد بجميع الفروع </option>
                @if(isset($branches) && count($branches) > 0)
                    @foreach($branches as $branches)
                        <option value="{{ $branches->id }}"
                        >{{ $branches->name }}
                        </option>
                    @endforeach
                @endif
            </select>
            @if($errors->has("branch"))
                {{ $errors->first("branch") }}
            @endif
        </div>
    </div>
@stop