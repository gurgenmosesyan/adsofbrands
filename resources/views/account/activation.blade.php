<?php
use App\Models\Account\Account;

$title = trans('www.activation.title');
?>
@extends('layout')

@section('content')

<div id="account">
    <div class="page">
        <h1 class="tc fsb fs36">{{$title}}</h1>
        <p class="fs18 tc lh25">
            @if($wrong)
                {{trans('www.activation.wrong_hash')}}
            @else
                {!!trans('www.activation.success')!!}
            @endif
        </p>
    </div>
</div>

@stop