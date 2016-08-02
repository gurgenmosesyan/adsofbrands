<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{config('app.name')}}</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <?php
    $head->appendStyle('/assets/bootstrap/css/bootstrap.min.css');
    //$head->appendStyle('/assets/plugins/iCheck/square/blue.css');
    $head->appendStyle('https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css');
    //$head->appendStyle('https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css');
    $head->appendStyle('/assets/dist/css/main.css');

    $head->appendMainScript('/assets/plugins/jQuery/jQuery-2.1.4.min.js');
    $head->appendMainScript('/assets/bootstrap/js/bootstrap.min.js');
    //$head->appendMainScript('/assets/plugins/iCheck/icheck.min.js');
    $head->appendMainScript('/core/js/login.js');

    $head->renderStyles();
    $head->renderScripts();
    ?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo"><b>{{config('app.name')}}</b></div>
    <div class="login-box-body">
        <p class="login-box-msg">{{trans('admin.login.title')}}</p>
        <form id="login-form" action="{{route('core_admin_login_api')}}" method="post">
            <div class="form-group has-feedback">
                <input type="text" name="email" class="form-control" placeholder="Email">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                <div id="form-error-email" class="form-error"></div>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="password" class="form-control" placeholder="Password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                <div id="form-error-password" class="form-error"></div>
            </div>
            <div class="row">
                {{--<div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox"> Remember Me
                        </label>
                    </div>
                </div>--}}
                {{csrf_field()}}
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">{{trans('admin.login.submit_btn')}}</button>
                </div>
            </div>
        </form>

    </div>
</div>

</body>
</html>
