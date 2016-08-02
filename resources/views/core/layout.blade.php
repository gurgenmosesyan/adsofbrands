<?php
$appName = config('app.name');
$jsTrans->addTrans([
    'admin.delete.modal.text',
    'admin.base.label.delete',
    'admin.base.label.close',
    'admin.base.label.loading',
    'admin.base.label.saved',
    'admin.base.label.invalid_data'
]);
?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{isset($pageTitle) ? $appName.' - '.$pageTitle : $appName}}</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Ionicons -->
    {{--<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">--}}
    <!-- Date Picker -->
    {{--<link rel="stylesheet" href="/assets/plugins/datepicker/datepicker3.css">
    <link rel="stylesheet" href="/assets/plugins/timepicker/bootstrap-timepicker.min.css">--}}

    <?php
    $head->appendMainStyle('https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css');
    $head->appendMainStyle('/assets/bootstrap/css/bootstrap.min.css');
    $head->appendMainStyle('/assets/plugins/datatables/dataTables.bootstrap.css');
    $head->appendMainStyle('/assets/dist/css/main.css');
    $head->appendMainStyle('/assets/dist/css/skins/skin-blue.min.css');
    $head->appendMainStyle('/assets/plugins/iCheck/minimal/blue.css');

    $head->appendMainScript('/assets/plugins/jQuery/jQuery-2.1.4.min.js');
    $head->appendMainScript('https://code.jquery.com/ui/1.11.4/jquery-ui.min.js');
    $head->appendMainScript('/assets/bootstrap/js/bootstrap.min.js');
    $head->appendMainScript('/assets/plugins/datatables/jquery.dataTables.min.js');
    $head->appendMainScript('/assets/plugins/datatables/dataTables.bootstrap.min.js');
    $head->appendMainScript('/assets/plugins/iCheck/icheck.min.js');
    $head->appendMainScript('/assets/dist/js/app.js');
    $head->appendMainScript('/core/js/main.js');

    $head->renderStyles();
    $head->renderScripts();

    $admin = Auth::guard('admin')->user();
    ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<script type="text/javascript">
    var $locSettings = {"trans":<?php echo json_encode($jsTrans->getTrans())?>};
    $main.path = '{{url('')}}';
    $main.token = '{{csrf_token()}}';
</script>
<div class="wrapper">

    <header class="main-header">
        <a href="{{url('/')}}" class="logo">
            <span class="logo-mini">{{config('app.short_name')}}</span>
            <span class="logo-lg">{{$appName}}</span>
        </a>
        <nav class="navbar navbar-static-top" role="navigation">
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="hidden-xs">{{$admin->email}}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{route('core_admin_edit', $admin->id)}}" class="btn btn-default btn-flat">{{trans('admin.profile.title')}}</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{route('core_admin_logout')}}" class="btn btn-default btn-flat">{{trans('admin.logout.title')}}</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <aside class="main-sidebar">
        <section class="sidebar">
            @include('core.menu')
        </section>
    </aside>

    <div class="content-wrapper">
        <section class="content-header">
            <h1>{{$pageTitle}}</h1>
            {{--<ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Dashboard</li>
            </ol>--}}
        </section>

        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border nav-tabs-custom">
                            <h3 class="box-title">{{$pageSubTitle}}</h3>
                            @yield('navButtons')
                        </div>
                        @yield('content')
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="control-sidebar-bg"></div>
</div>
<div id="win-status"></div>
</body>
</html>
