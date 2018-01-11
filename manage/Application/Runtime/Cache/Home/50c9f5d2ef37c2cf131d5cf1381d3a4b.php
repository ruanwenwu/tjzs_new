<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="ThemeBucket">
    <link rel="shortcut icon" href="#" type="image/png">

    <title>Login</title>

    <link href="./Public/css/style.css" rel="stylesheet">
    <link href="./Public/css/style-responsive.css" rel="stylesheet">
    <link rel="stylesheet" href="http://validform.rjboy.cn/wp-content/themes/validform/style.css" type="text/css" media="all" />
    <style>
		.Validform_checktip{}
	</style>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="./Public/js/html5shiv.js"></script>
    <script src="./Public/js/respond.min.js"></script>
    <![endif]-->
</head>

<body class="login-body">

<div class="container">

    <form class="form-signin registerform" action="/manage/index.php?m=home&c=ajax&a=login">
        <div class="form-signin-heading text-center">
            <h1 class="sign-title">天津掌视医疗后台登录</h1>
            <img src="./Public/images/login-logo.png" alt=""/>
        </div>
        <div class="login-wrap">
        	<div>
            <input type="text" name="username" class="form-control" autocomplete="off" empty=true datatype="s6-18" nullmsg="请输入用户名！" errormsg="用户名至少6个字符,最多18个字符！" placeholder="用户名" autofocus>
             <p class="help-block Validform_checktip"></p>
            </div>
            <div>
            <input type="password" name="password" empty=true autocomplete="off" class="form-control" datatype="*6-16" nullmsg="请输入密码！" errormsg="密码范围在6~16位之间！" placeholder="密码">
			 <p class="help-block Validform_checktip"></p>
			</div>
            <button class="btn btn-lg btn-login btn-block" type="submit">
                <i class="fa fa-check"></i>
            </button>
		
            <!--<div class="registration">
                Not a member yet?
                <a class="" href="registration.html">
                    Signup
                </a>
            </div>-->
            <!--<label class="checkbox">
                <input type="checkbox" value="remember-me"> 记住登录状态
                <span class="pull-right">
                    <a data-toggle="modal" href="#myModal"> 忘记密码？</a>

                </span>
            </label>-->

        </div>

        <!-- Modal -->
        <!-- <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Forgot Password ?</h4>
                    </div>
                    <div class="modal-body">
                        <p>Enter your e-mail address below to reset your password.</p>
                        <input type="text" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">

                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                        <button class="btn btn-primary" type="button">Submit</button>
                    </div>
                </div>
            </div>
        </div>-->
        <!-- modal -->

    </form>

</div>



<!-- Placed js at the end of the document so the pages load faster -->

<!-- Placed js at the end of the document so the pages load faster -->
<script src="./Public/js/jquery-1.10.2.min.js"></script>
<script src="./Public/js/bootstrap.min.js"></script>
<script src="./Public/js/modernizr.min.js"></script>
<script type="text/javascript" src="http://validform.rjboy.cn/Validform/v5.3.2/Validform_v5.3.2_min.js"></script>
<script src="./Public/js/tjzsyl/login.js"></script>
</body>
</html>