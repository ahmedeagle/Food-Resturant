@section('main')
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">أختر التصنيف للوجبة  </label>
        <div class="col-sm-10">

            <select class="form-control"   id="categorie" name="category">
                <option value="">برجاء اختيار  التصنيف </option>
                 @if(isset($categories) && count($categories) > 0)
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                        >{{ $category->name }}
                        </option>
                    @endforeach
                @endif
            </select>
            @if($errors->has("category"))
                {{ $errors->first("category") }}
            @endif
        </div>
    </div>
@stop