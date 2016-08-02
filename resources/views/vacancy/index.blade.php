<?php
$title = trans('www.vacancies.title');
$page = 'vacancies';
?>
@extends('layout')

@section('content')

<div class="page">
    <div id="page-title">
        <h1 class="title">{{$title}}</h1>
    </div>
</div>

<div class="page">

    <div id="vacancies" class="index">
        <table>
            <thead>
            <tr>
                <th>{{trans('www.vacancies.list.title')}}</th>
                <th>{{$vacancy->title}}</th>
            </tr>
            </thead>
            <tbody>
                @if(!empty($vacancy->term))
                    <tr>
                        <td>{{trans('www.vacancies.list.term')}}</td>
                        <td class="last">{{$vacancy->term}}</td>
                    </tr>
                @endif
                @if($vacancy->start_date != '0000-00-00')
                    <tr>
                        <td>{{trans('www.vacancies.list.start_date')}}</td>
                        <td class="last">{{strftime('%d %b %Y', strtotime($vacancy->start_date))}}</td>
                    </tr>
                @endif
                @if(!empty($vacancy->location))
                    <tr>
                        <td>{{trans('www.vacancies.list.location')}}</td>
                        <td class="last">{{$vacancy->location}}</td>
                    </tr>
                @endif
                @if(!empty($vacancy->description))
                    <tr>
                        <td>{{trans('www.vacancies.list.description')}}</td>
                        <td class="last">{{$vacancy->description}}</td>
                    </tr>
                @endif
                @if(!empty($vacancy->responsibilities))
                    <tr>
                        <td>{{trans('www.vacancies.list.responsibilities')}}</td>
                        <td class="last">{{$vacancy->responsibilities}}</td>
                    </tr>
                @endif
                @if(!empty($vacancy->qualifications))
                    <tr>
                        <td>{{trans('www.vacancies.list.qualifications')}}</td>
                        <td class="last">{{$vacancy->qualifications}}</td>
                    </tr>
                @endif
                @if(!empty($vacancy->procedures))
                    <tr>
                        <td>{{trans('www.vacancies.list.procedures')}}</td>
                        <td class="last">{{$vacancy->procedures}}</td>
                    </tr>
                @endif
                @if($vacancy->open_date != '0000-00-00')
                    <tr>
                        <td>{{trans('www.vacancies.list.open_date')}}</td>
                        <td class="last">{{strftime('%d %b %Y', strtotime($vacancy->open_date))}}</td>
                    </tr>
                @endif
                @if($vacancy->deadline != '0000-00-00')
                    <tr>
                        <td>{{trans('www.vacancies.list.deadline')}}</td>
                        <td class="last">{{strftime('%d %b %Y', strtotime($vacancy->deadline))}}</td>
                    </tr>
                @endif
                @if(!empty($vacancy->about))
                    <tr>
                        <td>{{trans('www.vacancies.list.about')}}</td>
                        <td class="last">{{$vacancy->about}}</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

</div>

@stop
