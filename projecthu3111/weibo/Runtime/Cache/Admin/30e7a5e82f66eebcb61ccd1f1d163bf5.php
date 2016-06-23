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
    <link href="/project/Public/Admin/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/project/Public/Admin/Uploadify/uploadify.css"/>
    <!-- MetisMenu CSS -->
    <link href="/project/Public/Admin/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="/project/Public/Admin/dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/project/Public/Admin/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="/project/Public/Admin/bower_components/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="/project/Public/Admin/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

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
        <h1 class="page-header">模板</h1>
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
                  <div class="col-md-offset-2 col-md-8">
                    <table id="dataTables-example" class="table table-striped table-bordered table-hover dataTable no-footer" role="grid" aria-describedby="dataTables-example_info">
                      <thead>
                        <tr role="row">
                          <th class="sorting col-md-2" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" style="width: 100px;" aria-label="Browser: activate to sort column ascending">模板名称</th>
                          <th class="sorting col-md-3" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" style="width:60px;" aria-label="Platform(s): activate to sort column ascending">模板图片</th>
                          <th class="sorting col-md-2" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" style="width:;" aria-label="CSS grade: activate to sort column ascending">操作</th>
                        </tr>
                      </thead>
                      <tbody>
                          <tr class="gradeA odd" role="row">
                            <td class="sorting_1 sid">default</td>
                            <td><img src="/project/Public/Uploads/Theme/default.jpg" alt="" width="150px"></td>
                            <td class="center">
                              <button class="btn btn-info">修改</button>
                            </td>
                          </tr>
                      </tbody>
                      <tbody>
                          <tr class="gradeA odd" role="row">
                            <td class="sorting_1 sid">style2</td>
                            <td><img src="/project/Public/Uploads/Theme/style2.jpg" alt="" width="150px"></td>
                            <td class="center">
                              <button class="btn btn-info">修改</button>
                            </td>
                          </tr>
                      </tbody>
                      <tbody>
                          <tr class="gradeA odd" role="row">
                            <td class="sorting_1 sid">style3</td>
                            <td><img src="/project/Public/Uploads/Theme/style3.jpg" alt="" width="150px"></td>
                            <td class="center">
                              <button class="btn btn-info">修改</button>
                            </td>
                          </tr>
                      </tbody>
                      <tbody>
                          <tr class="gradeA odd" role="row">
                            <td class="sorting_1 sid">style4</td>
                            <td><img src="/project/Public/Uploads/Theme/style4.jpg" alt="" width="150px"></td>
                            <td class="center">
                              <button class="btn btn-info">修改</button>
                            </td>
                          </tr>
                      </tbody>
                    </table>
                    
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
  <style type="text/css">
  .mask{
    margin:0;padding:0;border:none;width:100%;
    height:100%;background:#333;opacity:0.6;filter:alpha(opacity=60);z-index:9999;
    position:fixed;top:0;left:0;display:none;
  }
  #tan{
    position:absolute;left:500px;top:200px;
    background:white;width:400px;height:250px;border:3px solid orange;
    border-radius:7px;z-index:10000;display:none;
  }
  .upload-img{
    width:390px;
    height:30px;
    border-bottom: 1px solid #E1E1E1;
    background:#FAFAFA;
  }
  .upload-img p{
    width:100px;
    height:30px;
    line-height:30px;
    float: left;
    font-weight: bold;
    color:#888888;
    text-indent: 1em;
  }
  .upload-img span{
    display: block;
    width:32px;
    height:25px;
    line-height:15px;
    float: right;
    margin: 7px 5px;
    cursor: pointer;
  }
  .upload-btn{
    padding-top: 80px;
  }
  #SWFUpload_0,#picture-button{
    margin-left:140px;
  }
  </style>
  <div id="tan">
    <div class='upload-img'><p>本地上传</p><span class='close'>x</span></div>
    <div class='upload-btn'>
        <input type="file" name='picture' id='picture' sid=""/>
    </div>
  </div>
  <script type="text/javascript" src="/project/Public/Admin/js/jquery-1.8.3.min.js"></script>
  <script type="text/javascript" src='/project/Public/Admin/Uploadify/jquery.uploadify.min.js'></script>
  <script type="text/javascript">
    var PUBLIC = '/project/Public';
    $('button').click(function(){
      $("body").append("<div id='mask'></div>");
      $("#mask").addClass("mask").fadeIn("slow");
      $("#tan").fadeIn("slow");
      var sid = $(this).parents('tr').find('.sid').html();
      $('#picture').attr('sid',sid);
    });
    var uploadUrl = "<?php echo U('Admin/Theme/uploadPic');?>";
    // alert(sid);
    // var pid = $('#picture').attr('sid');
    var btn = $('#picture');
    $('#picture').uploadify({
      swf : PUBLIC + '/Admin/Uploadify/uploadify.swf', //引入Uploadify核心Flash文件
      uploader : uploadUrl, //PHP处理脚本地址
      width : 120,  //上传按钮宽度
      height : 30,  //上传按钮高度
      buttonImage : PUBLIC + '/Admin/Uploadify/browse-btn.png',  //上传按钮背景图地址
      fileTypeDesc : 'Image File',  //选择文件提示文字
      fileTypeExts : '*.jpeg; *.jpg; *.png; *.gif', //允许选择的文件类型
      formData : {'sid' : $('#picture').attr('sid')},
      onUploadStart: function (file) {
      btn.uploadify("settings","formData",{'sid': $('#picture').attr('sid')});
      },
      //上传成功后的回调函数
      onUploadSuccess : function (file, data, response) {
          location.reload();
          alert(data);
          $("#tan").fadeOut("fast");
          $("#mask").css({ display: 'none' });
       }
    });
    $('.close').click(function(){
      $("#tan").fadeOut("fast");
      $("#mask").css({ display: 'none' });
    });
  </script>

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="/project/Public/Admin/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="/project/Public/Admin/js/link.js"></script>
    

    <!-- Bootstrap Core JavaScript -->
    <script src="/project/Public/Admin/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="/project/Public/Admin/bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="/project/Public/Admin/bower_components/raphael/raphael-min.js"></script>
    <!-- // <script src="/project/Public/Admin/bower_components/morrisjs/morris.min.js"></script> -->
    <!-- // <script src="/project/Public/Admin/js/morris-data.js"></script> -->

    <!-- Custom Theme JavaScript -->
    <script src="/project/Public/Admin/dist/js/sb-admin-2.js"></script>

</body>

</html>