<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title><?php echo (C("WEBNAME")); ?>-用户个人页</title>
	<link rel="stylesheet" href="/Public/Home/Theme/<?php echo ($style); ?>/Css/nav.css" />
	<link rel="stylesheet" href="/Public/Home/Theme/<?php echo ($style); ?>/Css/user.css" />
	<link rel="stylesheet" href="/Public/Home/Theme/<?php echo ($style); ?>/Css/bottom.css" />
    <link rel="stylesheet" href="/Public/Home/Theme/<?php echo ($style); ?>/Css/index.css" />
        <link rel="stylesheet" href="/Public/Home/Uploadify/uploadify.css"/>
	<script type="text/javascript" src='/Public/Home/Js/jquery-1.8.3.min.js'></script>
    <script type="text/javascript" src='/Public/Home/Uploadify/jquery.uploadify.min.js'></script>
	<script type='text/javascript' src='/Public/Home/Js/nav.js'></script>
	<script type='text/javascript' src='/Public/Home/Js/index.js'></script>
  <script type='text/javascript' src='/Public/Home/Js/user.js'></script>

    <script type='text/javascript'>
        //得到GET['id']
        var id="id";
        var local_url = document.location.href; 
          //获取要取得的get参数位置
          var get = local_url.indexOf(id +"=");
          if(get>0){
              //截取字符串获得id
            var get_par = local_url.slice(id.length + get + 1); 
          }else{
            get_par = '';
          }

        var PUBLIC = '/Public';
        var uploadUrl = '<?php echo U("Home/Common/uploadPic");?>';
        var getWeibo = '<?php echo U("Home/Index/getWeibo");?>';
        var getTurnWeibo = '<?php echo U("Home/Index/getTurnWeibo");?>'
        var clickZan = '<?php echo U("Home/Common/clickZan");?>';
        var keepUrl = '<?php echo U("Home/Common/keep");?>';
        var commentUrl = "<?php echo U('Home/common/comment');?>";
        var getComment = '<?php echo U("Home/Common/getComment");?>';
        var delWeibo = '<?php echo U("Home/Index/delWeibo");?>';
        var uid = '<?php echo ($_SESSION["uid"]); ?>';
        var newletter = '<?php echo U("User/newletter");?>'
    </script>
<!--==========顶部固定导行条==========-->
<script type='text/javascript'>
    var delFollow = "<?php echo U('Common:delFollow');?>";
    var editStyle = "<?php echo U('Common:editStyle');?>";
    var getMsgUrl = "<?php echo U('Common:getMsg');?>";

    //我的
    var groupadd = "<?php echo U('Home/Search/groupadd');?>";
    var follow = "<?php echo U('Home/Search/follow');?>";
    var followdel = "<?php echo U('Home/Search/followdel');?>";
    var newletter = "<?php echo U('Home/User/newletter');?>";

    //发送ajax来实时发现@我的
    var atmemeurl = '<?php echo U("Common/atmemeurl");?>';
    
</script>
<style type="text/css">
    .newmessagenum {
    background : #FA7D3C;
    width : 14px;
    height : 13px;
    color : white;
    position : absolute;
    left : 19px;
    top : 5px;
}
</style>
</head>
<body>
<!--==========顶部固定导行条==========-->
       <div id='top_wrap'>
           <div id="top">
               <div class='top_wrap'>
                   <div class="logo fleft"></div>
                   <ul class='top_left fleft'>
                        <li class='cur_bg'><a href='<?php echo U("Home/Index/index");?>'>首页</a></li>
                        <li><a href="<?php echo U('Home/User/letter');?>">私信</a></li>
                        <li><a href="<?php echo U('Home/User/comment');?>">评论</a></li>
                        <li><a href="<?php echo U('Home/User/atme');?>">@我</a></li>
                   </ul>
                   <div id="search" class='fleft'>
                       <form action='<?php echo U("Home/Search/sechUser");?>' method='get'>
                           <input type='text' name='keyword' id='sech_text' class='fleft' value='搜索微博、找人'/>
                           <input type='submit' value='' id='sech_sub' class='fleft'/>
                       </form>
                   </div>
                      <?php $user = M('userinfo');$user = $user->where('uid='.session("uid"))->select();?> 
                   <div class="user fleft">
                       <a href=""><?php echo $user[0]['username'] ?></a>
                   </div>
                   <ul class='top_right fleft'>
                       <li title='快速发微博' class='fast_send'><i class='icon icon-write'></i></li>
                       <li class='selector'><i class='icon icon-msg'></i>
                           <ul class='hidden'>
	                            <li><a href="<?php echo U('Home/User/comment');?>">查看评论</a></li>
	                            <li><a href="<?php echo U('Home/User/letter');?>" class="newletter">查看私信</a></li>
	                            <li><a href="<?php echo U('Home/User/keep');?>">查看收藏</a></li>
	                            <li><a href="<?php echo U('Home/User/atme');?>" class="newatme">查看@我</a></li>
                           </ul>
                       </li>
                       <li class='selector'><i class='icon icon-setup'></i>
                           <ul class='hidden'>
                               <li><a href="<?php echo U('Home/UserSetting/index');?>">帐号设置</a></li>
                               <li><a href="<?php echo U('Home/Common/huiyuancenter');?>">会员中心</a></li>
                               <li><a href="" class='set_model'>模版设置</a></li>
                               <li><a href="<?php echo U('Home/Index/loginOut');?>">退出登录</a></li>
                           </ul>
                       </li>
                   <!--信息推送-->
                       <li id='news' class='hidden'>
                           <i class='icon icon-news'></i>
                           <ul>
                               <li class='news_comment hidden'>
                                   <a href="<?php echo U('User/comment');?>"></a>
                               </li>
                               <li class='news_letter hidden'>
                                   <a href="<?php echo U('User/letter');?>"></a>
                               </li>
                               <li class='news_atme hidden'>
                                   <a href="<?php echo U('User/atme');?>"></a>
                               </li>
                           </ul>
                       </li>
                   <!--信息推送-->
                   </ul>
               </div>
           </div>
           <div id="right_ad" class="right_ad">
		
	<img id="bigImg" class="bigImg" src="/Public/Uploads/Advert/1.jpg" height="300px" width="120px" title="么么哒" style="position:fixed;top:30%;left:10px;" />
	<?php if(is_array($adverts)): foreach($adverts as $key=>$vo): ?><img src="/Public/Uploads/Advert/<?php echo ($vo["pic"]); ?>" class="smallImg" title="<?php echo ($vo['content']); ?>" style="display:none" /><?php endforeach; endif; ?>
	<span id="right_close" class="right_x" style="position:fixed;top:30%;left:50px;">关闭</span>
</div>
<script>
	
	var len = $(".smallImg").length;
	// alert(len);
	var index = 0;
	var time = setInterval(function(){
		var smallSrc = $(".smallImg").eq(index).attr("src");
		var smallTit = $(".smallImg").eq(index).attr("title");
		
		index++;
		if(index > len-1){
			index = 0;
		}
		$("#bigImg").attr("src",smallSrc);
		$("#bigImg").attr("title",smallTit);
	},1000);
	$("#right_close").click(function(){
		$("#right_ad").css("display","none");
		
	});
</script>

	<div id="left_ad" class="left_ad">
		<img id="bigImg1" class="bigImg1" src="/Public/Uploads/Advert/1.jpg" height="300px" width="120px" title="么么哒"  style="position:fixed;top:30%;right:10px;"/>

		<?php if(is_array($adverts)): foreach($adverts as $key=>$vo): ?><img src="/Public/Uploads/Advert/<?php echo ($vo["pic"]); ?>" class="smallImg1" title="<?php echo ($vo['content']); ?>" style="display:none"/><?php endforeach; endif; ?>
		<span id="left_close" class="left_x" style="position:fixed;top:30%;right:50px;">关闭<span>
	</div>
	<script>
		var leng = $(".smallImg1").length;
		var ind = 0;
		var time = setInterval(function(){
			var smallSrc = $(".smallImg1").eq(ind).attr("src");
			var smallTit = $(".smallImg1").eq(ind).attr("title");
			
			ind++;
			if(ind > leng-1){
				ind = 0;
			}
			$("#bigImg1").attr("src",smallSrc);
			$("#bigImg1").attr("title",smallTit);
		},1000);

		$("#left_close").click(function(){
			$("#left_ad").css("display","none");
		});
	</script>
       </div>
   <!--==========顶部固定导行条==========-->
   <!--==========加关注弹出框==========-->

   <?php  $group = M('group')->where(array('uid' => session('uid')))->select(); ?>
       <script type='text/javascript'>
           var addFollow = "";
       </script>
       <div id='follow'>
           <div class="follow_head">
               <span class='follow_text fleft'>关注好友</span>
           </div>
           <div class='sel-group'>
               <span>好友分组：</span>
               <select name="gid">
                   <option value="0">默认分组</option>
                   <?php if(is_array($group)): foreach($group as $key=>$v): ?><option value=<?php echo ($v["id"]); ?>><?php echo ($v["name"]); ?></option><?php endforeach; endif; ?>
               </select>
           </div>
           <div class='fl-btn-wrap'>
               <input type="hidden" name='follow'/>
               <span class='add-follow-sub'>关注</span>
               <span class='follow-cencle'>取消</span>
           </div>
       </div>
<!--==========加关注弹出框==========-->

<!--==========自定义模版==========-->
    <div id='model' class='hidden'>
        <div class="model_head">
            <span class="model_text">个性化设置</span>
            <span class="close fright"></span>
        </div>
        <ul>
            <li style='background:url(/Public/Uploads/Theme/default.jpg) no-repeat;' theme='default'></li>
            <li style='background:url(/Public/Uploads/Theme/style2.jpg) no-repeat;' theme='style2'></li>
            <li style='background:url(/Public/Uploads/Theme/style3.jpg) no-repeat;' theme='style3'></li>
            <li style='background:url(/Public/Uploads/Theme/style4.jpg) no-repeat;' theme='style4'></li>
        </ul>
        <div class='model_operat'>
            <span class='model_save'>保存</span>
            <span class='model_cancel'>取消</span>
        </div>
    </div>
<!--==========自定义模版==========-->
<!--==========顶部固定导行条==========-->
<!--==========内容主体==========-->
  <div style='height:40px;opcity:10'></div>
  <div id='userinfo'>
    <div class='info-list'>
      <div class='info-face'>
        <p> 
          <img src="<?php if($userinfo["face180"]): ?>/Public/<?php echo ($userinfo["face180"]); else: ?>/Public/Home/Images/noface.gif<?php endif; ?>" width='180' height='180' alt="<?php echo ($userinfo["username"]); ?>" />
        </p>
        <ul>
          <li>
            <a href="<?php echo U('User/followList/',array('follow'=>$userinfo["uid"]));?>">
              <strong><?php echo ($userinfo["follow"]); ?></strong><br/>关注
            </a>
          </li>
          <li>
            <a href="<?php echo U('User/fansList/',array('fans'=>$userinfo["uid"]));?>">
              <strong><?php echo ($userinfo["fans"]); ?></strong><br/>粉丝
            </a>
          </li>
          <li>
            <a href="<?php echo U('Home/User/index',array('uid'=>$userinfo["uid"]));?>">
              <strong><?php echo ($userinfo["weibo"]); ?></strong><br/>微博
            </a>
          </li>
        </ul>
      </div>
      <ul class='uinfo'>
        <li class='uname full'><?php echo ($userinfo["username"]); ?></li>
        <li class='uintro full'><?php echo ($userinfo["intro"]); ?></li>
        <li class='ulist full'>
          <ul>
            <li><i class='icon icon-<?php if($userinfo['sex'] == '男'): ?>boy<?php else: ?>girl<?php endif; ?>'></i></li>
            <li><?php echo ($userinfo["location"]); ?></li>
            <li class='nobr'><?php echo ($userinfo["constellation"]); ?></li>
          </ul>
        </li>
            <?php if(isset($_SESSION["uid"]) && $_SESSION["uid"] == $_GET["uid"]): ?><li class='uedit full'>
          <a href="<?php echo U('Home/UserSetting/index');?>">修改个人资料</a>
        </li><?php endif; ?>
      </ul>
    </div>
  </div>
    <div class="main">
    <!--=====左侧=====-->
        <div id="middle" class='fleft'>
        <!--微博发布框-->
        <?php if(isset($_SESSION["uid"]) && $_SESSION["uid"] == $_GET["uid"]): ?><div class='send_wrap'>
                <div class='send_title fleft'></div>
                <div class='send_prompt fright'>
                    <span>你还可以输入<span id='send_num'>140</span>个字</span>
                </div>
                <div class='send_write'>
                    <form action='<?php echo U("Common/send");?>' method='post' name='weibo'>
                        <textarea sign='weibo' name='content'></textarea>
                        <span class='ta_right'></span>
                        <div class='send_tool'>
                            <ul class='fleft'>
                                <li title='表情'>
                                  <i class='icon icon-phiz phiz' sign='weibo'></i>
                                </li>
                                <li title='图片'><i class='icon icon-picture'></i>
                                <!--图片上传框-->
                                    <div id="upload_img" class='hidden'>
                                        <div class='upload-title'><p>本地上传</p><span class='close'></span></div>
                                        <div class='upload-btn'>
                                            <input type="hidden" name='max' value=''/>
                                            <input type="hidden" name='medium' value=''/>
                                            <input type="hidden" name='mini' value=''/>
                                            <input type="file" name='picture' id='picture'/>
                                        </div>
                                    </div>
                                <!--图片上传框-->
                                    <div id='pic-show' class='hidden'>
                                        <img src="" alt=""/>
                                    </div>
                                </li>
                            </ul>
                            <input type='submit' value='' class='send_btn fright' title='发布微博按钮'/>
                        </div>
                    </form>
                </div>
            </div><?php endif; ?>
        <!--微博发布框-->
            <div class='view_line'>
                <strong>微博</strong>
            </div>
      <?php if(!$weibo): ?>没有发布的微博
      <?php else: ?>
      <?php if(is_array($weibo)): foreach($weibo as $key=>$v): if(!$v["isturn"]): ?><!--====================普通微博样式====================-->
            <div class="weibo">
                <!--头像-->
                <div class="face">
                    <a href="">
                        <img src="
                        <?php if($v["face50"]): ?>/Public/<?php echo ($v["face50"]); ?>
                        <?php else: ?>
                            /Public/Home/Images/noface.gif<?php endif; ?>" width='50' height='50'/>
                    </a>
                </div>
                <div class="wb_cons">
                    <dl>
                    <!--用户名-->
                        <dt class='author'>
                            <a href=""><?php echo ($v["username"]); ?></a>
                        </dt>
                        <dt class='screen'>
                            <a href="javascript:void(0);">
                                <i class='screen_box'>…</i> 
                            </a>
                           <ul class="screen_list hidden">
                              <?php if(isset($_SESSION["uid"]) && $_SESSION["uid"] == $_GET["uid"]): ?><li class="del">
                                    <a href="javascript:void(0);" wid="">删除</a>
                               </li>
                               <?php else: ?>
                               <li class="keep">
                                    <a href="javascript:void(0);" wid="">收藏</a>
                                    <div class='keep-up hidden'></div>
                               </li>
                               <li class="report">
                                    <a href="javascript:void(0);" wid="">举报</a>
                                </li><?php endif; ?>
                           </ul>              
                        </dt>
                    <!--发布内容-->
                        <dd class='content'>
                            <p><?php echo ($v['content']); ?></p>                           
                        </dd>
                    <!--微博图片-->
                    <?php if($v['max']): ?><dd>
                            <div class='wb_img'>
                            <!--小图-->
                                <img src="/Public/<?php echo ($v["mini"]); ?>" class='mini_img'/>
                                <div class="img_tool hidden">
                                    <ul>
                                        <li>
                                            <i class='icon icon-packup'></i>
                                            <span class='packup'>&nbsp;收起</span>
                                        </li>
                                        <li>|</li>
                                        <li>
                                            <i class='icon icon-bigpic'></i>
                                            <a href="/Public/<?php echo ($v["max"]); ?>" target='_blank'>&nbsp;查看大图</a>
                                        </li>
                                    </ul>
                                <!--中图-->
                                    <div class="img_info"><img src="/Public/<?php echo ($v["medium"]); ?>"/></div>
                                </div>
                            </div>
                        </dd><?php endif; ?>
                    </dl>
                <!--操作-->
                    <div class="wb_tool">
                    <!--发布时间-->
                        <span class="send_time">
                        <?php echo (date("Y-m-d H:i:s",$v["time"])); ?></span>
                    </div>
                    <div class="wb_tool">
                        <hr color="#eee">
                        <ul>
                            <li>
                                <span class='turn' id='<?php echo ($v["wid"]); ?>'>转发(<i><?php echo ($v["turn"]); ?></i>)</span>
                            </li>
                            <li><b>|</b></li>
                            <li>
                                <span class='zan' sign='no' id='<?php echo ($v["id"]); ?>'>赞(<i><?php echo ($v["zan"]); ?></i>)</span>
                            </li>
                            <li><b>|</b></li>   
                            <li>
                                <span class='comment' wid='<?php echo ($v["id"]); ?>'>评论(<i><?php echo ($v["comment"]); ?></i>)</span>
                            </li>
                        </ul>
                    </div>
                <!--=====回复框=====-->
                    <div class='comment_load hidden'>
                        <img src="/Public/Home/Images/loading.gif">评论加载中，请稍候...
                    </div>
                    <div class='comment_list hidden'>
                        <textarea name="" sign='comment<?php echo ($key); ?>'></textarea>
                        <ul>
                            <li class='phiz fleft' sign='comment<?php echo ($key); ?>'></li>
                            <li class='comment_turn fleft'>
                                <label>
                                    <input type="checkbox" name=''/>同时转发到我的微博
                                </label>
                            </li>
                            <li class='comment_btn fright' wid='<?php echo ($v["id"]); ?>' uid='<?php echo ($v["uid"]); ?>'>评论</li>
                        </ul>
                    </div>
                <!--=====回复框结束=====-->
                </div>
            </div>

              <!-- 原创微博展示模板结束 -->              
        <?php else: ?>      
<!--====================转发样式====================-->

            <div class="weibo">
            <!--头像-->
                <div class="face">
                    <a href="">
                        <img src="
                        <?php if($v["face50"]): ?>/Public/<?php echo ($v["face50"]); ?>
                        <?php else: ?>
                            /Public/Home/Images/noface.gif<?php endif; ?>" width='50' height='50'/>
                    </a>
                </div>
                <div class="wb_cons">
                    <dl>
                    <!--用户名-->
                        <dt class='author'>
                            <a href=""><?php echo ($v["username"]); ?></a>
                        </dt>
                        <dt class='screen'>
                            <a href="javascript:void(0);">
                                <i class='screen_box'>…</i> 
                            </a>
                           <ul class="screen_list hidden">
                              <?php if(isset($_SESSION["uid"]) && $_SESSION["uid"] == $_GET["uid"]): ?><li class="del">
                                    <a href="javascript:void(0);" wid="">删除</a>
                               </li>
                               <?php else: ?>
                               <li class="keep">
                                    <a href="javascript:void(0);" wid="">收藏</a>
                                    <div class='keep-up hidden'></div>
                               </li>
                               <li class="report">
                                    <a href="javascript:void(0);" wid="">举报</a>
                                </li><?php endif; ?>
                           </ul>              
                        </dt>
                    <!--发布内容-->
                        <dd class='content'>
                            <p><?php echo ($v["content"]); ?></p>
                        </dd>
                    <!--转发的微博内容-->
                    <?php  $wid = $v['isturn']; $weibo = M('weibo'); $res = $weibo->where('id ="'.$wid.'"')->find(); $info = M('userinfo'); $username = $info->where('uid = "'.$res['uid'].'"')->getField('username'); ?>

                    <?php if($res == null): ?><dd class="wb_turn">该微博已被删除</dd>
                    <?php else: ?>
                        <dd>
                            <div class="wb_turn">
                                <dl>
                                <!--原作者-->
                                    <dt class='turn_name'>
                                        <a href="">@<?php echo ($username); ?></a>
                                    </dt>
                                <!--原微博内容-->
                                    <dd class='turn_cons'>
                                        <p><?php echo ($username); echo ($res['content']); ?></p>
                                    </dd>
                                <!--原微博图片-->
                                <?php if($res["max"]): ?><dd>
                                        <div class="turn_img">
                                        <!--小图-->
                                            <img src="__PUBLIC/<?php echo ($res["mini"]); ?>" class='turn_mini_img'/>
                                            <div class="turn_img_tool hidden">
                                                <ul>
                                                    <li>
                                                        <i class='icon icon-packup'></i>
                                                        <span class='packup'>&nbsp;收起</span></li>
                                                    <li>|</li>
                                                    <li>
                                                        <i class='icon icon-bigpic'></i>
                                                        <a href="/Public/<?php echo ($res["max"]); ?>" target='_blank'>&nbsp;查看大图</a>
                                                    </li>
                                                </ul>
                                            <!--中图-->
                                                <div class="turn_img_info">
                                                    <img src="__PUBLIC/<?php echo ($res["medium"]); ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                    </dd><?php endif; ?>
                                </dl>
                                <!--转发微博操作-->
                                <div class="turn_tool">
                                    <span class='send_time'>
                                        <?php echo (date("Y-m-d H:i:s",$res["time"])); ?>
                                    </span>
                                    <ul>
                                        <li><a href="javascript:void(0)">转发(<i><?php echo ($res['turn']); ?></i>)</a></li>
                                        <li><b>|</b></li>
                                        <li> <a href="javascript:void(0)">赞(<i><?php echo ($res['zan']); ?></i>)</a></li>
                                        <li><b>|</b></li> 
                                        <li><a href="javascript:void(0)">评论(<i><?php echo ($res['comment']); ?></i>)</a></li>
                                    </ul>
                                </div>
                            </div>
                        </dd><?php endif; ?>
                    </dl>
                    <!--操作-->
                    <div class="wb_tool">
                    <!--发布时间-->
                       <span class="send_time"><?php echo (date("Y-m-d H:i:s",$v["time"])); ?></span>
                    </div>
                    <div class="wb_tool">
                       <hr color="#eee">
                       <ul>
                          <li>
                              <span class='turn' id='<?php echo ($v["id"]); ?>' tid='<?php echo ($v["isturn"]); ?>'>转发(<i><?php echo ($v["turn"]); ?></i>)</span>
                          </li>
                          <li><b>|</b></li>
                          <li>
                              <span class='zan' sign='no' id='<?php echo ($v["id"]); ?>'>赞(<i><?php echo ($v["zan"]); ?></i>)</span>
                          </li>
                          <li><b>|</b></li>   
                          <li>
                              <span class='comment' wid='<?php echo ($v["id"]); ?>'>评论(<i><?php echo ($v["comment"]); ?></i>)</span>
                          </li>
                       </ul>
                    </div>
                    <!--回复框-->
                    <div class='comment_load hidden'>
                        <img src="/Public/Home/Images/loading.gif">评论加载中，请稍候...
                    </div>
                    <div class='comment_list hidden'>
                        <textarea name=""></textarea>
                        <ul>
                            <li class='phiz fleft'></li>
                            <li class='comment_turn fleft'>
                                <label>
                                    <input type="checkbox" name=''/>同时转发到我的微博
                                </label>
                            </li>
                            <li class='comment_btn fright' wid='<?php echo ($v["id"]); ?>' uid='<?php echo ($v["uid"]); ?>'>评论</li>
                        </ul>
                    </div>
                    <!--回复框结束-->
                </div>
            </div>
<!--====================转发样式结束====================--><?php endif; endforeach; endif; endif; ?>
         <div id='page'><?php echo ($page); ?></div>
      </div>
        <!--==========右侧==========-->
        <div id='right'>
          <dl>
            <dt>我的关注(<?php echo ($follownum); ?>)<a href=""  style="">更多</a></dt>
                <?php if(is_array($follow)): foreach($follow as $key=>$v): ?><dd>
              <a href="<?php echo U('Home/User/index',array('uid'=>$v['uid']));?>">
                <img src="<?php if($v["face50"]): ?>/Public/<?php echo ($v["face50"]); else: ?>/Public/Home/Images/noface.gif<?php endif; ?>" alt="<?php echo ($v["username"]); ?>" width='50' height='50'/>
              </a>
              <p>
                <a href="<?php echo U('Home/User/index',array('uid'=>$v['uid']));?>"><?php echo ($v["username"]); ?></a>
              </p>
            </dd><?php endforeach; endif; ?>
          </dl>
          <dl>
            <dt>我的粉丝(<?php echo ($fansnum); ?>) <?php if(count($fans) > 8): ?><a href="<?php echo U('Home/User/index',array('uid'=>$v['uid']));?>">更多»</a><?php endif; ?></dt>
                <?php if(is_array($fans)): foreach($fans as $key=>$v): ?><dd>
              <a href="<?php echo U('Home/User/index',array('uid'=>$v['uid']));?>">
                <img src="<?php if($v["face50"]): ?>/Public/<?php echo ($v["face50"]); else: ?>/Public/Home/Images/noface.gif<?php endif; ?>" alt="<?php echo ($v["username"]); ?>" width='50' height='50'/>
              </a>
              <p>
                <a href="<?php echo U('Home/User/index',array('uid'=>$v['uid']));?>"><?php echo ($v["username"]); ?></a>
              </p>
            </dd><?php endforeach; endif; ?>
          </dl>
        </div>
    </div>
<!--==========内容主体结束==========-->
<!--==========底部==========-->
   <!--==========底部==========-->
    <div id="bottom">
    <?php $link = M('link'); $linklist = $link->where('`show`=1')->select(); ?>
        <div class='link'>
            <dl>
            <?php foreach ($linklist as $key => $va): ?>
                
                <dd><a href="<?php echo $va['src'] ?>"><?php echo $va['linkcontent'] ?></a></dd>
            <?php endforeach ?>
            </dl>
            
        </div>
        <div id="copy">
            <div>
                <p>
                    版权所有：<?php echo (C("COPY")); ?> 站长统计 All rights reserved, houdunwang.com services for Beijing 2008-2012 
                </p>
            </div>
        </div>
    </div>

<!--==========转发输入框==========-->
    <div id='turn' class='hidden'>
        <div class="turn_head">
            <span class='turn_text fleft'>转发微博</span>
            <span class="close fright"></span>
        </div>
        <div class="turn_main">
            <form action='<?php echo U("Index/turn");?>' method='post' name='turn'>
                <p></p>
                <div class='turn_prompt'>
                    你还可以输入<span id='turn_num'>140</span>个字</span>
                </div>
                <textarea name='content' sign='turn'></textarea>
                <ul>
                    <li class='phiz fleft' sign='turn'></li>
                    <li class='turn_comment fleft'>
                        <label>
                            <input type="checkbox" name='becomment'/>同时评论给<span class='turn-cname'></span>
                        </label>
                    </li>
                    <li class='turn_btn fright'>
                        <input type="hidden" name='id' value=''/>
                        <input type="hidden" name='tid' value=''/>
                        <input type="submit" value='转发' class='turn_btn'/>
                    </li>
                </ul>
            </form>
        </div>
    </div>
<!--==========转发输入框==========-->

<!--==========表情选择框==========-->
    <div id="phiz" class='hidden'>
        <div>
            <p>常用表情</p>
            <span class='close fright'></span>
        </div>
        <ul>
            <li><img src="/Public/Home/Images/phiz/hehe.gif" alt="呵呵" title="呵呵" /></li>
            <li><img src="/Public/Home/Images/phiz/xixi.gif" alt="嘻嘻" title="嘻嘻" /></li>
            <li><img src="/Public/Home/Images/phiz/haha.gif" alt="哈哈" title="哈哈" /></li>
            <li><img src="/Public/Home/Images/phiz/keai.gif" alt="可爱" title="可爱" /></li>
            <li><img src="/Public/Home/Images/phiz/kelian.gif" alt="可怜" title="可怜" /></li>
            <li><img src="/Public/Home/Images/phiz/wabisi.gif" alt="挖鼻屎" title="挖鼻屎" /></li>
            <li><img src="/Public/Home/Images/phiz/chijing.gif" alt="吃惊" title="吃惊" /></li>
            <li><img src="/Public/Home/Images/phiz/haixiu.gif" alt="害羞" title="害羞" /></li>
            <li><img src="/Public/Home/Images/phiz/jiyan.gif" alt="挤眼" title="挤眼" /></li>
            <li><img src="/Public/Home/Images/phiz/bizui.gif" alt="闭嘴" title="闭嘴" /></li>
            <li><img src="/Public/Home/Images/phiz/bishi.gif" alt="鄙视" title="鄙视" /></li>
            <li><img src="/Public/Home/Images/phiz/aini.gif" alt="爱你" title="爱你" /></li>
            <li><img src="/Public/Home/Images/phiz/lei.gif" alt="泪" title="泪" /></li>
            <li><img src="/Public/Home/Images/phiz/touxiao.gif" alt="偷笑" title="偷笑" /></li>
            <li><img src="/Public/Home/Images/phiz/qinqin.gif" alt="亲亲" title="亲亲" /></li>
            <li><img src="/Public/Home/Images/phiz/shengbin.gif" alt="生病" title="生病" /></li>
            <li><img src="/Public/Home/Images/phiz/taikaixin.gif" alt="太开心" title="太开心" /></li>
            <li><img src="/Public/Home/Images/phiz/ldln.gif" alt="懒得理你" title="懒得理你" /></li>
            <li><img src="/Public/Home/Images/phiz/youhenhen.gif" alt="右哼哼" title="右哼哼" /></li>
            <li><img src="/Public/Home/Images/phiz/zuohenhen.gif" alt="左哼哼" title="左哼哼" /></li>
            <li><img src="/Public/Home/Images/phiz/xiu.gif" alt="嘘" title="嘘" /></li>
            <li><img src="/Public/Home/Images/phiz/shuai.gif" alt="衰" title="衰" /></li>
            <li><img src="/Public/Home/Images/phiz/weiqu.gif" alt="委屈" title="委屈" /></li>
            <li><img src="/Public/Home/Images/phiz/tu.gif" alt="吐" title="吐" /></li>
            <li><img src="/Public/Home/Images/phiz/dahaqian.gif" alt="打哈欠" title="打哈欠" /></li>
            <li><img src="/Public/Home/Images/phiz/baobao.gif" alt="抱抱" title="抱抱" /></li>
            <li><img src="/Public/Home/Images/phiz/nu.gif" alt="怒" title="怒" /></li>
            <li><img src="/Public/Home/Images/phiz/yiwen.gif" alt="疑问" title="疑问" /></li>
            <li><img src="/Public/Home/Images/phiz/canzui.gif" alt="馋嘴" title="馋嘴" /></li>
            <li><img src="/Public/Home/Images/phiz/baibai.gif" alt="拜拜" title="拜拜" /></li>
            <li><img src="/Public/Home/Images/phiz/sikao.gif" alt="思考" title="思考" /></li>
            <li><img src="/Public/Home/Images/phiz/han.gif" alt="汗" title="汗" /></li>
            <li><img src="/Public/Home/Images/phiz/kun.gif" alt="困" title="困" /></li>
            <li><img src="/Public/Home/Images/phiz/shuijiao.gif" alt="睡觉" title="睡觉" /></li>
            <li><img src="/Public/Home/Images/phiz/qian.gif" alt="钱" title="钱" /></li>
            <li><img src="/Public/Home/Images/phiz/shiwang.gif" alt="失望" title="失望" /></li>
            <li><img src="/Public/Home/Images/phiz/ku.gif" alt="酷" title="酷" /></li>
            <li><img src="/Public/Home/Images/phiz/huaxin.gif" alt="花心" title="花心" /></li>
            <li><img src="/Public/Home/Images/phiz/heng.gif" alt="哼" title="哼" /></li>
            <li><img src="/Public/Home/Images/phiz/guzhang.gif" alt="鼓掌" title="鼓掌" /></li>
            <li><img src="/Public/Home/Images/phiz/yun.gif" alt="晕" title="晕" /></li>
            <li><img src="/Public/Home/Images/phiz/beishuang.gif" alt="悲伤" title="悲伤" /></li>
            <li><img src="/Public/Home/Images/phiz/zuakuang.gif" alt="抓狂" title="抓狂" /></li>
            <li><img src="/Public/Home/Images/phiz/heixian.gif" alt="黑线" title="黑线" /></li>
            <li><img src="/Public/Home/Images/phiz/yinxian.gif" alt="阴险" title="阴险" /></li>
            <li><img src="/Public/Home/Images/phiz/numa.gif" alt="怒骂" title="怒骂" /></li>
            <li><img src="/Public/Home/Images/phiz/xin.gif" alt="心" title="心" /></li>
            <li><img src="/Public/Home/Images/phiz/shuangxin.gif" alt="伤心" title="伤心" /></li>
        </ul>
    </div>
<!--==========表情==========-->
</body>
</html>