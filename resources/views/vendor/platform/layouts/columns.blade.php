<div class="row">
    @foreach ($manyForms as $key => $column)
        <div class="col-lg">
            @foreach ($column as $item)
                {!! $item ?? '' !!}
            @endforeach
        </div>
    @endforeach
</div>
