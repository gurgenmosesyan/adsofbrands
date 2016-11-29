<?php
$head->appendScript('/admin/award/award.js');
$pageTitle = $pageSubTitle = trans('admin.award.form.title');
$pageMenu = 'award';
$isAdmin = Auth::guard('admin')->check();
?>
@extends('core.layout')
@section('navButtons')
    <a href="{{route('admin_award_create')}}" class="btn btn-primary pull-right">{{trans('admin.base.label.add')}}</a>
@stop
@section('content')
<script type="text/javascript">
    $award.isAdmin = <?php echo $isAdmin ? 'true' : 'false'; ?>;
</script>
<div class="box-body">
    <table id="data-table" class="table table-bordered table-striped table-hover">
        <thead>
        <tr>
            <th>{{trans('admin.base.label.id')}}</th>
            @if($isAdmin)
                <th>{{trans('admin.base.label.type')}}</th>
                <th>{{trans('admin.base.label.brand_agency_creative')}}</th>
            @endif
            <th>{{trans('admin.base.label.year')}}</th>
            <th>{{trans('admin.base.label.title')}}</th>
            @if(Auth::guard('admin')->check() && Auth::guard('admin')->user()->isSuperAdmin())
                <th>{{trans('admin.base.label.created_by')}}</th>
                <th>{{trans('admin.base.label.updated_by')}}</th>
            @endif
            <th class="th-actions"></th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
@stop