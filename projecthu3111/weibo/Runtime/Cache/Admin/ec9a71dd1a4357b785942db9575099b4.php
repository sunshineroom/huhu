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
        
<script type="text/javascript">
    
</script>
  <div id="page-wrapper">
    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header">vip列表 &nbsp;&nbsp;&nbsp;&nbsp;<i style="font-size:20px">共&nbsp;<i style="color:red;font-weight:700"><?php echo ($count); ?></i>&nbsp;个vip会员</i></h1>

      </div>
      <!-- /.col-lg-12 -->
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <!-- DataTables Advanced Tables -->
          </div>
          <!-- /.panel-heading -->
          <div class="panel-body">
            <div class="dataTable_wrapper">
              <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div class="row">

                  

                </div>
                <div class="row">
                  <div class="col-sm-12">
                  <!-- 用户列表遍历 -->
                    <table id="dataTables-example" class="table table-striped table-bordered table-hover dataTable no-footer" role="grid" aria-describedby="dataTables-example_info">
                      <thead>
                        <tr role="row">
                          <th class="sorting_asc" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 50px;" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">ID</th>
                          <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 80px;" aria-label="Browser: activate to sort column ascending">用户昵称</th>
                          <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 80px;" aria-label="Platform(s): activate to sort column ascending">头像</th>
                          <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 50px;" aria-label="Engine version: activate to sort column ascending">粉丝数量</th>
                          <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 50px;" aria-label="CSS grade: activate to sort column ascending">关注数量</th>
                          <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 50px;" aria-label="CSS grade: activate to sort column ascending">微博数量</th>
                          <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 50px;" aria-label="CSS grade: activate to sort column ascending">vip购买时间</th>
                          <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 90px;" aria-label="CSS grade: activate to sort column ascending">vip到期时间</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if(is_array($userlist)): foreach($userlist as $k=>$vo): ?><tr class="gradeA odd" role="row">
                            <td class="sorting_1 sid"><?php echo ($vo["id"]); ?></td>
                            <td id="<?php echo ($vo["id"]); ?>" class="gongsrc"><?php echo ($vo["username"]); ?></td>
                            <td id="<?php echo ($vo["id"]); ?>">
                                <img src="<?php if($vo["face50"]): ?>/Public/<?php echo ($vo["face50"]); else: ?>/Public/Home/Images/noface.gif<?php endif; ?>" width='50' height='50' alt="<?php echo ($vo["username"]); ?>" />
                            </td>
                            <td><?php echo ($vo["follow"]); ?></td>
                            <td><?php echo ($vo["fans"]); ?></td>
                            <td><?php echo ($vo["weibo"]); ?></td>
                            <td><?php echo date("Y-m-d H:i:s",$vo["vtime"]) ?></td>
                            <td>在<i style="color:red"><?php echo floor((($vo["vtime"]+$vo["buytime"]-time()))/24/3600) ?></i>天后到期</td>
                          </tr><?php endforeach; endif; ?>
                      </tbody>
                    </table>
                  
                  </div>
                </div>
                <div class="row">
                  <style type="text/css">
                      #pages a,#pages span{ background-color: #fff;
                              border: 1px solid #ddd;
                              color: #337ab7;
                              float: left;
                              line-height: 1.42857;
                              margin-left: -1px;
                              padding: 6px 12px;
                              position: relative;
                              text-decoration: none;}
                      #pages span {
                            background-color: #337ab7;
                            border-color: #337ab7;
                            color: #fff;
                            cursor: default;
                            z-index: 2;
                            }
                  </style>
                 
                  <div class="col-sm-6">
                    <div class="dataTables_paginate paging_simple_numbers" id="dataTables-example_paginate">
                       <div id="pages">
                          <?php echo ($pages); ?>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.table-responsive -->

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