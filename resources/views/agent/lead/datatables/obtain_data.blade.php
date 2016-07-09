@if($type=='calendar')
    {{ date(trans('main.date_format'),strtotime($data->value)) }}
@elseif($type='undef')

@else

@endif