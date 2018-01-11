<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="keywords" content="admin, dashboard, bootstrap, template, flat, modern, theme, responsive, fluid, retina, backend, html5, css, css3">
  <meta name="description" content="">
  <meta name="author" content="ThemeBucket">
  <link rel="shortcut icon" href="#" type="image/png">

  <title>AdminX</title>

  <!--icheck-->
  <link href="./Public/js/iCheck/skins/minimal/minimal.css" rel="stylesheet">
  <link href="./Public/js/iCheck/skins/square/square.css" rel="stylesheet">
  <link href="./Public/js/iCheck/skins/square/red.css" rel="stylesheet">
  <link href="./Public/js/iCheck/skins/square/blue.css" rel="stylesheet">

  <!--dashboard calendar-->
  <link href="./Public/css/clndr.css" rel="stylesheet">

  <!--Morris Chart CSS -->
  <link rel="stylesheet" href="./Public/js/morris-chart/morris.css">

  <!--common-->
  <link href="./Public/css/style.css" rel="stylesheet">
  <link href="./Public/css/style-responsive.css" rel="stylesheet">
  
 <link rel="stylesheet" href="http://validform.rjboy.cn/wp-content/themes/validform/style.css" type="text/css" media="all" />
 
 


  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="./Public/js/html5shiv.js"></script>
  <script src="./Public/js/respond.min.js"></script>
  <![endif]-->
</head>

<body class="sticky-header">

<section>
    <!-- left side start-->
    <div class="left-side sticky-left-side">

        <!--logo and iconic logo start-->
        <div class="logo">
            <a href="index.html"><img src="./Public/images/logo.png" alt=""></a>
        </div>

        <div class="logo-icon text-center">
            <a href="index.html"><img src="./Public/images/logo_icon.png" alt=""></a>
        </div>
        <!--logo and iconic logo end-->

        <div class="left-side-inner">

            <!-- visible to small devices only -->
            <div class="visible-xs hidden-sm hidden-md hidden-lg">
                <div class="media logged-user">
                    <img alt="" src="./Public/images/photos/user-avatar.png" class="media-object">
                    <div class="media-body">
                        <h4><a href="#">John Doe</a></h4>
                        <span>"Hello There..."</span>
                    </div>
                </div>

                <h5 class="left-nav-title">Account Information</h5>
                <ul class="nav nav-pills nav-stacked custom-nav">
                  <li><a href="#"><i class="fa fa-user"></i> <span>Profile</span></a></li>
                  <li><a href="#"><i class="fa fa-cog"></i> <span>Settings</span></a></li>
                  <li><a href="#"><i class="fa fa-sign-out"></i> <span>Sign Out</span></a></li>
                </ul>
            </div>

            <!--sidebar nav start-->
            <ul class="nav nav-pills nav-stacked custom-nav">
                <!--<li class="active"><a href="/manage/index.php?m=home&c=index&a=index"><i class="fa fa-home"></i> <span>首页</span></a></li>-->
                <li class="menu-list <?php if($ctl == 'hospitalmanage'): ?>nav-active<?php endif; ?>"><a href=""><i class="fa fa-laptop"></i> <span>医院信息</span></a>
                    <ul class="sub-menu-list">
                        <li <if condition="$act eq 'hospitalinfo'"class="active"</if>><a href="/manage/index.php?c=index&a=index">信息预览</a></li>
                        <!--<li><a href="boxed_view.html"> Boxed Page</a></li>
                        <li><a href="leftmenu_collapsed_view.html"> Sidebar Collapsed</a></li>
                        <li><a href="horizontal_menu.html"> Horizontal Menu</a></li>-->
                    </ul>
                </li>
                <li class="menu-list"><a href=""><i class="fa fa-book"></i> <span>医生信息</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="general.html">医生列表</a></li>
                        <!--<li><a href="buttons.html"> Buttons</a></li>
                        <li><a href="tabs-accordions.html"> Tabs & Accordions</a></li>
                        <li><a href="typography.html"> Typography</a></li>
                        <li><a href="slider.html"> Slider</a></li>
                        <li><a href="panels.html"> Panels</a></li>-->
                    </ul>
                </li>
                 <li class="menu-list"><a href=""><i class="fa fa-book"></i> <span>日志信息</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="/manage/index.php?m=home&c=Log&a=errinfo">挂号日志</a></li>
                        <!--<li><a href="buttons.html"> Buttons</a></li>
                        <li><a href="tabs-accordions.html"> Tabs & Accordions</a></li>
                        <li><a href="typography.html"> Typography</a></li>
                        <li><a href="slider.html"> Slider</a></li>
                        <li><a href="panels.html"> Panels</a></li>-->
                    </ul>
                </li>
                <!--<li class="menu-list"><a href=""><i class="fa fa-cogs"></i> <span>Components</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="grids.html"> Grids</a></li>
                        <li><a href="gallery.html"> Media Gallery</a></li>
                        <li><a href="calendar.html"> Calendar</a></li>
                        <li><a href="tree_view.html"> Tree View</a></li>
                        <li><a href="nestable.html"> Nestable</a></li>

                    </ul>
                </li>

                <li><a href="fontawesome.html"><i class="fa fa-bullhorn"></i> <span>Fontawesome</span></a></li>

                <li class="menu-list"><a href=""><i class="fa fa-envelope"></i> <span>Mail</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="mail.html"> Inbox</a></li>
                        <li><a href="mail_compose.html"> Compose Mail</a></li>
                        <li><a href="mail_view.html"> View Mail</a></li>
                    </ul>
                </li>

                <li class="menu-list"><a href=""><i class="fa fa-tasks"></i> <span>Forms</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="form_layouts.html"> Form Layouts</a></li>
                        <li><a href="form_advanced_components.html"> Advanced Components</a></li>
                        <li><a href="form_wizard.html"> Form Wizards</a></li>
                        <li><a href="form_validation.html"> Form Validation</a></li>
                        <li><a href="editors.html"> Editors</a></li>
                        <li><a href="inline_editors.html"> Inline Editors</a></li>
                        <li><a href="pickers.html"> Pickers</a></li>
                        <li><a href="dropzone.html"> Dropzone</a></li>
                        <li><a href="http://www.weidea.net"> More</a></li>
                    </ul>
                </li>
                <li class="menu-list"><a href=""><i class="fa fa-bar-chart-o"></i> <span>Charts</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="flot_chart.html"> Flot Charts</a></li>
                        <li><a href="morris.html"> Morris Charts</a></li>
                        <li><a href="chartjs.html"> Chartjs</a></li>
                        <li><a href="c3chart.html"> C3 Charts</a></li>
                    </ul>
                </li>
                <li class="menu-list"><a href="#"><i class="fa fa-th-list"></i> <span>Data Tables</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="basic_table.html"> Basic Table</a></li>
                        <li><a href="dynamic_table.html"> Advanced Table</a></li>
                        <li><a href="responsive_table.html"> Responsive Table</a></li>
                        <li><a href="editable_table.html"> Edit Table</a></li>
                    </ul>
                </li>

                <li class="menu-list"><a href="#"><i class="fa fa-map-marker"></i> <span>Maps</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="google_map.html"> Google Map</a></li>
                        <li><a href="vector_map.html"> Vector Map</a></li>
                    </ul>
                </li>
                <li class="menu-list"><a href=""><i class="fa fa-file-text"></i> <span>Extra Pages</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="profile.html"> Profile</a></li>
                        <li><a href="invoice.html"> Invoice</a></li>
                        <li><a href="pricing_table.html"> Pricing Table</a></li>
                        <li><a href="timeline.html"> Timeline</a></li>
                        <li><a href="blog_list.html"> Blog List</a></li>
                        <li><a href="blog_details.html"> Blog Details</a></li>
                        <li><a href="directory.html"> Directory </a></li>
                        <li><a href="chat.html"> Chat </a></li>
                        <li><a href="404.html"> 404 Error</a></li>
                        <li><a href="500.html"> 500 Error</a></li>
                        <li><a href="registration.html"> Registration Page</a></li>
                        <li><a href="lock_screen.html"> Lockscreen </a></li>
                    </ul>
                </li>
                <li><a href="login.html"><i class="fa fa-sign-in"></i> <span>Login Page</span></a></li>-->

            </ul>
            <!--sidebar nav end-->

        </div>
    </div>
    <!-- left side end-->
    
    <!-- main content start-->
    <div class="main-content" >

        <!-- header section start-->
        <div class="header-section">

            <!--toggle button start-->
            <a class="toggle-btn"><i class="fa fa-bars"></i></a>
            <!--toggle button end-->

            <!--search start-->
            <form class="searchform" action="index.html" method="post">
                <input type="text" class="form-control" name="keyword" placeholder="Search here..." />
            </form>
            <!--search end-->

            <!--notification menu start -->
            <div class="menu-right">
                <ul class="notification-menu">
                   <!--<li>
                        <a href="#" class="btn btn-default dropdown-toggle info-number" data-toggle="dropdown">
                            <i class="fa fa-tasks"></i>
                            <span class="badge">8</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-head pull-right">
                            <h5 class="title">You have 8 pending task</h5>
                            <ul class="dropdown-list user-list">
                                <li class="new">
                                    <a href="#">
                                        <div class="task-info">
                                            <div>Database update</div>
                                        </div>
                                        <div class="progress progress-striped">
                                            <div style="width: 40%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-warning">
                                                <span class="">40%</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="new">
                                    <a href="#">
                                        <div class="task-info">
                                            <div>Dashboard done</div>
                                        </div>
                                        <div class="progress progress-striped">
                                            <div style="width: 90%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="90" role="progressbar" class="progress-bar progress-bar-success">
                                                <span class="">90%</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="task-info">
                                            <div>Web Development</div>
                                        </div>
                                        <div class="progress progress-striped">
                                            <div style="width: 66%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="66" role="progressbar" class="progress-bar progress-bar-info">
                                                <span class="">66% </span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="task-info">
                                            <div>Mobile App</div>
                                        </div>
                                        <div class="progress progress-striped">
                                            <div style="width: 33%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="33" role="progressbar" class="progress-bar progress-bar-danger">
                                                <span class="">33% </span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="task-info">
                                            <div>Issues fixed</div>
                                        </div>
                                        <div class="progress progress-striped">
                                            <div style="width: 80%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="80" role="progressbar" class="progress-bar">
                                                <span class="">80% </span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="new"><a href="">See All Pending Task</a></li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a href="#" class="btn btn-default dropdown-toggle info-number" data-toggle="dropdown">
                            <i class="fa fa-envelope-o"></i>
                            <span class="badge">5</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-head pull-right">
                            <h5 class="title">You have 5 Mails </h5>
                            <ul class="dropdown-list normal-list">
                                <li class="new">
                                    <a href="">
                                        <span class="thumb"><img src="./Public/images/photos/user1.png" alt="" /></span>
                                        <span class="desc">
                                          <span class="name">John Doe <span class="badge badge-success">new</span></span>
                                          <span class="msg">Lorem ipsum dolor sit amet...</span>
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="">
                                        <span class="thumb"><img src="./Public/images/photos/user2.png" alt="" /></span>
                                        <span class="desc">
                                          <span class="name">Jonathan Smith</span>
                                          <span class="msg">Lorem ipsum dolor sit amet...</span>
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="">
                                        <span class="thumb"><img src="./Public/images/photos/user3.png" alt="" /></span>
                                        <span class="desc">
                                          <span class="name">Jane Doe</span>
                                          <span class="msg">Lorem ipsum dolor sit amet...</span>
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="">
                                        <span class="thumb"><img src="./Public/images/photos/user4.png" alt="" /></span>
                                        <span class="desc">
                                          <span class="name">Mark Henry</span>
                                          <span class="msg">Lorem ipsum dolor sit amet...</span>
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="">
                                        <span class="thumb"><img src="./Public/images/photos/user5.png" alt="" /></span>
                                        <span class="desc">
                                          <span class="name">Jim Doe</span>
                                          <span class="msg">Lorem ipsum dolor sit amet...</span>
                                        </span>
                                    </a>
                                </li>
                                <li class="new"><a href="">Read All Mails</a></li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a href="#" class="btn btn-default dropdown-toggle info-number" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            <span class="badge">4</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-head pull-right">
                            <h5 class="title">Notifications</h5>
                            <ul class="dropdown-list normal-list">
                                <li class="new">
                                    <a href="">
                                        <span class="label label-danger"><i class="fa fa-bolt"></i></span>
                                        <span class="name">Server #1 overloaded.  </span>
                                        <em class="small">34 mins</em>
                                    </a>
                                </li>
                                <li class="new">
                                    <a href="">
                                        <span class="label label-danger"><i class="fa fa-bolt"></i></span>
                                        <span class="name">Server #3 overloaded.  </span>
                                        <em class="small">1 hrs</em>
                                    </a>
                                </li>
                                <li class="new">
                                    <a href="">
                                        <span class="label label-danger"><i class="fa fa-bolt"></i></span>
                                        <span class="name">Server #5 overloaded.  </span>
                                        <em class="small">4 hrs</em>
                                    </a>
                                </li>
                                <li class="new">
                                    <a href="">
                                        <span class="label label-danger"><i class="fa fa-bolt"></i></span>
                                        <span class="name">Server #31 overloaded.  </span>
                                        <em class="small">4 hrs</em>
                                    </a>
                                </li>
                                <li class="new"><a href="">See All Notifications</a></li>
                            </ul>
                        </div>
                    </li>-->
                    <li>
                        <a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            <img src="./Public/images/photos/user-avatar.png" alt="" />
                            <?php echo ($userInfo['name']); ?>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-usermenu pull-right">
                            <li><a href="/manage/index.php?c=index&a=index"><i class="fa fa-user"></i>  我的信息</a></li>
                            <!--<li><a href="#"><i class="fa fa-cog"></i>  Settings</a></li>-->
                            <li><a href="/manage/index.php?c=login&a=logout"><i class="fa fa-sign-out"></i>退出登录</a></li>
                        </ul>
                    </li>

                </ul>
            </div>
            <!--notification menu end -->

        </div>
        <!-- header section end-->

        <!-- page heading start-->
        <div class="page-heading">
            <h3>
                <?php echo ($Dashboard['parent']['name']); ?>
            </h3>
            <ul class="breadcrumb">
                <li>
                    <a href="#"><?php echo ($Dashboard['parent']['name']); ?></a>
                </li>
                <li class="active"><?php echo ($Dashboard['child']['name']); ?></li>
            </ul>
            <!--<div class="state-info">
                <section class="panel">
                    <div class="panel-body">
                        <div class="summary">
                            <span>yearly expense</span>
                            <h3 class="red-txt">$ 45,600</h3>
                        </div>
                        <div id="income" class="chart-bar"></div>
                    </div>
                </section>
                <section class="panel">
                    <div class="panel-body">
                        <div class="summary">
                            <span>yearly  income</span>
                            <h3 class="green-txt">$ 45,600</h3>
                        </div>
                        <div id="expense" class="chart-bar"></div>
                    </div>
                </section>
            </div>-->
        </div>
        <!-- page heading end-->

        <!--body wrapper start-->
        <div class="wrapper">
        
<div class="row">
        <div class="col-lg-12">
        <section class="panel">

            <div class="panel-body">
                <form id="xxx" class="form-horizontal adminex-form registerform" method="post" action="/manage/index.php?c=index&a=updateHospital">
                 	<div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">ID</label>
                        <div class="col-sm-10">
                            <input class="form-control" value="<?php echo ($hospitalInfo['id']); ?>" id="disabledInput" nullmsg="请输入id！" datatype="n1-8" errormsg="id为1-8个数字" type="text" name="id" placeholder="13" readonly>
                            <p class="help-block Validform_checktip"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">名称</label>
                        <div class="col-sm-10">
                            <input type="text" name="name" value="<?php echo ($hospitalInfo['name']); ?>" nullmsg="请输入医院名称！" datatype="s4-18" errormsg="至少4个字符,最多18个字符！"  class="form-control">
                            <p class="help-block Validform_checktip"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">地址</label>
                        <div class="col-sm-10">
                            <input type="text" nullmsg="请输入地址！" value="<?php echo ($hospitalInfo['address']); ?>" datatype="s6-100" errormsg="地址至少个字符,最多100个字符！" name="address" class="form-control">
                            <p class="help-block Validform_checktip"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">电话</label>
                        <div class="col-sm-10">
                            <input type="text" nullmsg="请输入电话！" value="<?php echo ($hospitalInfo['tel']); ?>" datatype="*" errormsg="输入正确的电话" name="tel" class="form-control">
                            <p class="help-block Validform_checktip"></p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">网址</label>
                        <div class="col-sm-10">
                            <input type="text" value="<?php echo ($hospitalInfo['website']); ?>"  name="website" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">乘车路线</label>
                        <div class="col-sm-10">
                            <input type="text" name="traffic" value="<?php echo ($hospitalInfo['traffic']); ?>" class="form-control">
                            <p class="help-block Validform_checktip"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">简介</label>
                        <div class="col-sm-10">
                            <textarea name="desc" nullmsg="请输入简介！" datatype="*" errormsg="简介至少6个字符,最多500个字符！" class="form-control"><?php echo ($hospitalInfo['desc']); ?></textarea>
                            <p class="help-block Validform_checktip"></p>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="exampleInputFile1" class="col-lg-2 col-sm-2 control-label">图标</label>
                        <div class="col-lg-10">
                        <input type="file" t="icon" name="icon" id="exampleInputFile1">
                        <input id="icond" type="hidden" value="<?php echo ($hospitalInfo['icon']); ?>" nullmsg="请上传医院icon！" datatype="*" errormsg="icon不能为空" name="icon" />
                        <p class="help-block Validform_checktip">将展示在列表以及其他页面</p>
                        <div id="icon-preview"><img src="/Uploads/<?php echo ($hospitalInfo['icon']); ?>" /></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile2" class="col-lg-2 col-sm-2 control-label">海报</label>
                        <div class="col-lg-10">
                        <input type="file" t="poster"  name="poster" id="exampleInputFile2">
                        <input id="posterd" nullmsg="请上传医院海报！" value="<?php echo ($hospitalInfo['icon']); ?>" errormsg="海报不能为空" datatype="*" type="hidden" name="poster" />
                        <p class="help-block Validform_checktip">将展示在医院介绍页面</p>
                          <div id="poster-preview"><img src="/Uploads/<?php echo ($hospitalInfo['poster']); ?>" /></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                        	
                       
                            <button type="submit" class="btn btn-primary">修改</button>
                        </div>
                    </div>
      		
                </form>
            </div>
        </section>
     </div>
 </div>

        </div>
        <!--body wrapper end-->

        <!--footer section start-->
        <footer>
            2014 &copy; AdminEx by ThemeBucket
        </footer>
        <!--footer section end-->


    </div>
    <!-- main content end-->
</section>

<!-- Placed js at the end of the document so the pages load faster -->
<script src="./Public/js/jquery-1.10.2.min.js"></script>
<script src="./Public/js/jquery-ui-1.9.2.custom.min.js"></script>
<script src="./Public/js/jquery-migrate-1.2.1.min.js"></script>
<script src="./Public/js/bootstrap.min.js"></script>
<script src="./Public/js/modernizr.min.js"></script>
<script src="./Public/js/jquery.nicescroll.js"></script>

<!--easy pie chart-->
<script src="./Public/js/easypiechart/jquery.easypiechart.js"></script>
<script src="./Public/js/easypiechart/easypiechart-init.js"></script>

<!--Sparkline Chart-->
<script src="./Public/js/sparkline/jquery.sparkline.js"></script>
<script src="./Public/js/sparkline/sparkline-init.js"></script>

<!--icheck -->
<script src="./Public/js/iCheck/jquery.icheck.js"></script>
<script src="./Public/js/icheck-init.js"></script>

<!-- jQuery Flot Chart-->
<script src="./Public/js/flot-chart/jquery.flot.js"></script>
<script src="./Public/js/flot-chart/jquery.flot.tooltip.js"></script>
<script src="./Public/js/flot-chart/jquery.flot.resize.js"></script>



<!--Calendar-->
<script src="./Public/js/calendar/clndr.js"></script>
<script src="./Public/js/calendar/evnt.calendar.init.js"></script>
<script src="./Public/js/calendar/moment-2.2.1.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.5.2/underscore-min.js"></script>

<!--common scripts for all pages-->
<script src="./Public/js/scripts.js"></script>

<!--Dashboard Charts-->
<script src="./Public/js/dashboard-chart-init.js"></script>

<script type="text/javascript" src="http://validform.rjboy.cn/Validform/v5.3.2/Validform_v5.3.2_min.js"></script>
<script src="./Public/js/tjzsyl/index.js?<?php echo ($random); ?>"></script>

<!--Morris Chart-->
<script src="./Public/js/morris-chart/morris.js"></script>
<script src="./Public/js/morris-chart/raphael-min.js"></script>

</body>
</html>