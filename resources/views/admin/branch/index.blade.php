<?php
$head->appendScript('/admin/branch/branch.js');
$pageTitle = $pageSubTitle = trans('admin.branch.form.title');
$pageMenu = 'branch';
$isAdmin = Auth::guard('admin')->check();
?>
@extends('core.layout')
@section('navButtons')
    <a href="{{route('admin_branch_create')}}" class="btn btn-primary pull-right">{{trans('admin.base.label.add')}}</a>
@stop
@section('content')
<script type="text/javascript">
    $branch.isAdmin = <?php echo $isAdmin ? 'true' : 'false'; ?>;
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
            <th>{{trans('admin.base.label.address')}}</th>
            @if($isAdmin && Auth::guard('admin')->user()->isSuperAdmin())
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