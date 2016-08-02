<?php
$title = trans('www.vacancies.title');
$page = 'vacancies';

$jsTrans->addTrans([
    'www.vacancies.list.title',
    'www.vacancies.list.function',
    'www.vacancies.list.published_on',
    'www.vacancies.list.read_more'
]);
?>
@extends('layout')

@section('content')

<div class="page">
    <div id="page-title">
        <h1 class="title">{{$title}}</h1>
    </div>
</div>

<div class="page">

    @if($vacancies->isEmpty())
        <p class="empty-result">{{trans('www.vacancies.empty_text')}}</p>
    @else
        <div id="vacancies" class="list">
            <table>
                <thead>
                <tr>
                    <th>{{trans('www.vacancies.list.title')}}</th>
                    <th>{{trans('www.vacancies.list.function')}}</th>
                    <th class="last">{{trans('www.vacancies.list.published_on')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($vacancies as $vacancy)
                    <tr>
                        <td class="v-title">{{$vacancy->title}}</td>
                        <td class="v-function">{{$vacancy->function}}</td>
                        <td class="published last">
                            <div class="date fl">{{date('d.m.Y', strtotime($vacancy->published_at))}}</div>
                            <div class="more fr">
                                <a href="{{url_with_lng('/vacancies/'.$vacancy->id, false)}}" class="db">{{trans('www.vacancies.list.read_more')}}</a>
                            </div>
                            <div class="cb"></div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif

</div>

@stop
