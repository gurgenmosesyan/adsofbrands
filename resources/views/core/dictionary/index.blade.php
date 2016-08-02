<?php
$head->appendScript('/core/js/dictionary.js');
$pageTitle = $pageSubTitle = trans('admin.dictionary.form.title');
$pageMenu = 'dictionary';
?>
@extends('core.layout')
@section('navButtons')
    <a href="#" id="add-dictionary" class="btn btn-primary pull-right">{{trans('admin.base.label.add')}}</a>
@stop
@section('content')
<script type="text/javascript">
    $dictionary.listColumns = [{data: 'key', orderable: false}];
    $dictionary.appId = '{{$appId}}';
    @foreach($languages as $language)
        $dictionary.listColumns.push({data: '{{$language->code}}', orderable: false});
    @endforeach
</script>
<div class="box-body">
    <table id="data-table" class="table table-bordered table-striped table-hover">
        <thead>
        <tr>
            <th>{{trans('admin.base.label.key')}}</th>
            @foreach($languages as $language)
                <th>{{$language->name}}</th>
            @endforeach
            <th class="th-actions"></th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>

    <div class="dataTables_length">
        <select id="app-select" class="form-control">
            <option value="1"{{$appId == '1' ? ' selected="selected"' : ''}}>{{trans('admin.dictionary.type.admin')}}</option>
            <option value="2"{{$appId == '2' ? ' selected="selected"' : ''}}>{{trans('admin.dictionary.type.www')}}</option>
        </select>
    </div>

</div>

<div id="dictionary-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="dictionary-form" action="{{route('core_dictionary_update')}}" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{trans('admin.dictionary.modal.title')}}</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{trans('admin.base.label.key')}}</label>
                        <input type="text" name="key" class="key form-control">
                        <div id="form-error-key" class="form-error"></div>
                        <input type="hidden" name="origin_key" class="key">
                        <input type="hidden" id="appId" name="app" value="{{$appId}}">
                    </div>
                    @foreach($languages as $lng)
                        <div class="form-group">
                            <label>{{$lng->name}}</label>
                            <input type="text" name="ml[{{$lng->code}}]" class="form-control {{$lng->code}}">
                            <div id="form-error-ml_{{$lng->code}}" class="form-error"></div>
                        </div>
                    @endforeach
                    {{csrf_field()}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('admin.base.label.close')}}</button>
                    <button type="submit" class="btn btn-primary">{{trans('admin.base.label.save')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop