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
        <h1 class="page-header">广告</h1>
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

                  <form action="<?php echo U('Admin/Homeuser/index');?>" method="get">
                    
                  <div class="col-sm-2">
                    <div class="dataTables_length" id="dataTables-example_length">
                      <label>显示 
                        <select name="num" aria-controls="dataTables-example" class="form-control input-sm">
                          <option <?php echo $_GET['num'] == 5 ? 'selected' : '' ?> value="5">5</option>
                          <option <?php echo $_GET['num'] == 10 ? 'selected' : '' ?> value="10">10</option>
                          <option <?php echo $_GET['num'] == 20 ? 'selected' : '' ?> value="20">20</option>
                        </select>
                        条
                      </label>
                    </div>
                  </div>
                     <button type="submit" class="btn btn-info">跳转</button>
                  </form>

                </div>
                <div class="row">
                  <div class="col-sm-12">
                  <!-- 用户列表遍历 -->
                    <table id="dataTables-example" class="table table-striped table-bordered table-hover dataTable no-footer" role="grid" aria-describedby="dataTables-example_info">
                      <thead>
                        <tr role="row">
                          <th class="sorting_asc" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 100px;" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">ID</th>
                          <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 100px;" aria-label="Browser: activate to sort column ascending">广告名称</th>
                          <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" style="width:60px;" aria-label="Platform(s): activate to sort column ascending">广告图片</th>
                          <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 30%;" aria-label="Engine version: activate to sort column ascending">广告简介</th>
                          <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" style="width:130px;" aria-label="Platform(s): activate to sort column ascending">是否展示</th>
                          <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" style="width:;" aria-label="CSS grade: activate to sort column ascending">操作</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if(is_array($adverts)): foreach($adverts as $k=>$vo): ?><tr class="gradeA odd" role="row">
                            <td class="sorting_1 sid"><?php echo ($vo["id"]); ?></td>
                            <td><?php echo ($vo["name"]); ?></td>
                            <td><img src="/Public/Uploads/Advert/<?php echo ($vo["pic"]); ?>" alt="" width="100px" height="150px"></td>
                            <td><?php echo ($vo["content"]); ?></td>
                            <td>
                              <?php if($vo["status"] == 1 ): ?>前台展示&nbsp;&nbsp;&nbsp; <button type="button" id="<?php echo ($vo["id"]); ?>" class="btn btn-info btn-circle isshow"><i class="fa fa-check"></i></button>
                              <?php else: ?> 前台展示&nbsp;&nbsp;&nbsp; <button type="button" id="<?php echo ($vo["id"]); ?>" class="btn btn-danger btn-circle isshow"><i class="fa fa-times"></i></button><?php endif; ?>
                            </td>
                            <td class="center">
                              <a href="<?php echo U('Admin/Advert/save',array('id'=>$vo['id']));?>" class="btn btn-info" type="button">修改</a>
                               <button class="btn btn-danger btn-del " type="button" >删除广告</button>
                            </td>
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
  <script type="text/javascript" src="/Public/Admin/js/jquery-1.8.3.min.js"></script>
  <script type="text/javascript">
    //绑定单击事件
    $('.btn-del').click(function(){
      // alert('222');

      //获取id
      var id = $(this).parents('tr').find('.sid').html();
      var url = "<?php echo U('Admin/Advert/ajaxdel');?>";
      // alert(url);
      var btn = $(this);
      //ajax
      $.get(url,{id:id},function(data){
        // console.log(data);
        if(data == 1){
          alert('删除成功');
         btn.parents('tr').remove();
        }else{
          alert('删除失败');
        }
      })

    })

  //前台显示
  // alert($);
  $('.isshow').on('click',function(){
    var link = $(this);
    var showurl = "<?php echo U('Admin/Advert/showurl');?>";
    var id = $(this).attr('id');
    $.post(showurl,{id:id},function(data){
      if(data==1){
        //把他变成不显示
        var showlink = link.attr('class','btn btn-danger btn-circle isshow').find('i').attr('class','fa fa-times');
      }else{
        //把他变成显示
        var showlink = link.attr('class','btn btn-info btn-circle isshow').find('i').attr('class','fa fa-check');
      }
    })
  })
  </script>

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