<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>微博后台管理首页</title>

    <!-- Bootstrap Core CSS -->
    <link href="/Public/Admin/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/Public/Admin/Uploadify/uploadify.css"/>
    <!-- MetisMenu CSS -->
    <link href="/Public/Admin/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="/Public/Admin/dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/Public/Admin/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="/Public/Admin/bower_components/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="/Public/Admin/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <a class="navbar-brand" href="<?php echo U('Admin/Index/index');?>"><i class="fa  fa-home"></i>微博后台管理首页</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i>当前管理员:<?php echo ($username); ?></a>
                        </li>
                        <li><a href="<?php echo U('Admin/User/settingself');?>"><i class="fa fa-gear fa-fw"></i>修改资料</a>
                        <li><a href="<?php echo U('Admin/Index/loginOut');?>"><i class="fa fa-sign-out fa-fw"></i> 用户退出</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <li class="dropdown"></li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="<?php echo U('Admin/Index/index');?>"><i class="fa fa-home fa-fw"></i> 首页</a>
                        </li>
                        
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> 后台用户管理<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo U('Admin/User/index');?>">后台管理员列表</a>
                                </li>
                                <?php  $AUTH = new \Think\Auth(); if($AUTH->check('AdminUser', session('uid'))){ ?> 
                                <li>
                                    <a href="<?php echo U('Admin/User/add');?>">后台管理员添加</a>
                                </li>
                                <?php } ?>


                            </ul>
                            <!-- /.nav-second-level -->
                        </li>

                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> 前台用户管理<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo U('Admin/Homeuser/index');?>">微博用户</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                         <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i>微博管理<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo U('Admin/WeiboAction/index');?>">微博列表</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                      <!--    <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i>转发微博管理<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo U('Admin/WeiboTurn/index');?>">转发微博列表</a>
                                </li>
                            </ul>
                        </li> -->

    
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i>评论管理<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo U('Admin/Comment/index');?>">评论列表</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i>举报管理<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo U('Admin/Report/index');?>">举报列表</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>

                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i>模板管理<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo U('Admin/Theme/index');?>">模板列表</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>

                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i>广告管理<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo U('Admin/Advert/index');?>">广告列表</a>
                                    <a href="<?php echo U('Admin/Advert/add');?>">添加广告</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i>[友情链接]管理<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo U('Admin/Link/index');?>">友情链接列表</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i>[公告栏]管理<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo U('Admin/Lin/index');?>">公告栏列表</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i>[vip]管理<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo U('Admin/Vip/index');?>">vip列表</a>
                                </li>
                            </ul>
                        </li>
                        <!-- <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i>统计管理<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo U('Admin/Goods/index');?>">网站统计列表</a>
                                </li>
                            </ul>
                        </li> -->
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
        
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">广告添加</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
   <div class="row">
                   <div class="col-lg-12">
                       <div class="panel panel-default">
                           <div class="panel-heading">
                               请输入表单内的内容~
                           </div>
                           <div class="panel-body">
                               <div class="row">
                                   <div class="col-lg-6">
                                       <form role="form" action="<?php echo U('Admin/Advert/insert');?>" method="post" enctype="multipart/form-data">
                                           
                                           <div class="form-group">
                                               <label>广告名称</label>
                                               <input name="name" placeholder="请输入广告名" class="form-control">
                                           </div>
                                           <div class="form-group">
                                               <input type="file"  class="col-xs-10 col-sm-5" name='pic' /><span>(请上传宽300,长150左右的广告图片)</span>
                                           </div>
                                           <div class="form-group">
                                              <label>广告简介:</label><br>
                                              <textarea style="width:100%;height:100px;" name="content" placeholder="请输入广告的简介"></textarea>
                                           </div>
                                           <button class="btn btn-warning" type="reset">重置</button>
                                           <button class="btn btn-info" type="submit">提交</button>
                                       </form>
                                   </div>
                             <!--   http://localhost/Class/s43/project/index.php/Admin/User/add.html
                               http://localhost/Class/s43/project/index.php/Admin/User/add.shtml
                               lamp43/Admin/User/add
                               lamp43/Admin/User/add.html -->
                               </div>
                               <!-- /.row (nested) -->
                           </div>
                           <!-- /.panel-body -->
                       </div>
                       <!-- /.panel -->
                   </div>
                   <!-- /.col-lg-12 -->
               </div>
</div>

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="/Public/Admin/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="/Public/Admin/js/link.js"></script>
    

    <!-- Bootstrap Core JavaScript -->
    <script src="/Public/Admin/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="/Public/Admin/bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="/Public/Admin/bower_components/raphael/raphael-min.js"></script>
    <!-- // <script src="/Public/Admin/bower_components/morrisjs/morris.min.js"></script> -->
    <!-- // <script src="/Public/Admin/js/morris-data.js"></script> -->

    <!-- Custom Theme JavaScript -->
    <script src="/Public/Admin/dist/js/sb-admin-2.js"></script>

</body>

</html>