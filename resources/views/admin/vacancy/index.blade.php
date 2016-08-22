<?php
$head->appendScript('/admin/vacancy/vacancy.js');
$pageTitle = $pageSubTitle = trans('admin.vacancy.form.title');
$pageMenu = 'vacancy';
$isAdmin = Auth::guard('admin')->check();
?>
@extends('core.layout')
@section('navButtons')
    <a href="{{route('admin_vacancy_create')}}" class="btn btn-primary pull-right">{{trans('admin.base.label.add')}}</a>
@stop
@section('content')
<script type="text/javascript">
    $vacancy.isAdmin = <?php echo $isAdmin ? 'true' : 'false'; ?>;
</script>
<div class="box-body">
    <table id="data-table" class="table table-bordered table-striped table-hover">
        <thead>
        <tr>
            <th>{{trans('admin.base.label.id')}}</th>
            @if($isAdmin)
                <th>{{trans('admin.base.label.type')}}</th>
                <th>{{trans('admin.base.label.brand_agency')}}</th>
            @endif
            <th>{{trans('admin.base.label.title')}}</th>
            <th class="th-actions"></th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
@stop