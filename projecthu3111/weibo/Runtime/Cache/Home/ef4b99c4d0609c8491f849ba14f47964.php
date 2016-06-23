<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <title><?php echo (C("WEBNAME")); ?>-修改个人资料</title>
    <link rel="stylesheet" href="/project/Public/Home/Theme/<?php echo ($style); ?>/Css/nav.css" />
    <link rel="stylesheet" href="/project/Public/Home/Theme/<?php echo ($style); ?>/Css/edit.css" />
    <link rel="stylesheet" href="/project/Public/Home/Uploadify/uploadify.css"/>
    <script type="text/javascript" src='/project/Public/Home/Js/jquery-1.8.3.min.js'></script>
    <script type="text/javascript" src='/project/Public/Home/Js/nav.js'></script>
    <script type='text/javascript' src='/project/Public/Home/Js/city.js'></script>
    <script type='text/javascript' src='/project/Public/Home/Js/edit.js'></script>
    <script type="text/javascript" src='/project/Public/Home/Uploadify/jquery.uploadify.min.js'></script>
    <script type='text/javascript'>
        var address = "<?php echo ($userinfo["location"]); ?>";
        var constellation = "<?php echo ($userinfo["constellation"]); ?>";
        var PUBLIC = '/project/Public';
        var uploadUrl = '<?php echo U("Home/Common/uploadFace");?>';
        // var sid = '<?php echo session_id();?>';
        var uid = '<?php echo ($_SESSION["uid"]); ?>';
        var AJAX = '<?php echo U("Home/UserSetting/ajax");?>';
        var AJAXPWD = '<?php echo U("Home/UserSetting/ajaxpwd");?>'; 
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
		
	<img id="bigImg" class="bigImg" src="/project/Public/Uploads/Advert/1.jpg" height="300px" width="120px" title="么么哒" style="position:fixed;top:30%;left:10px;" />
	<?php if(is_array($adverts)): foreach($adverts as $key=>$vo): ?><img src="/project/Public/Uploads/Advert/<?php echo ($vo["pic"]); ?>" class="smallImg" title="<?php echo ($vo['content']); ?>" style="display:none" /><?php endforeach; endif; ?>
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
		<img id="bigImg1" class="bigImg1" src="/project/Public/Uploads/Advert/1.jpg" height="300px" width="120px" title="么么哒"  style="position:fixed;top:30%;right:10px;"/>

		<?php if(is_array($adverts)): foreach($adverts as $key=>$vo): ?><img src="/project/Public/Uploads/Advert/<?php echo ($vo["pic"]); ?>" class="smallImg1" title="<?php echo ($vo['content']); ?>" style="display:none"/><?php endforeach; endif; ?>
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
            <li style='background:url(/project/Public/Uploads/Theme/default.jpg) no-repeat;' theme='default'></li>
            <li style='background:url(/project/Public/Uploads/Theme/style2.jpg) no-repeat;' theme='style2'></li>
            <li style='background:url(/project/Public/Uploads/Theme/style3.jpg) no-repeat;' theme='style3'></li>
            <li style='background:url(/project/Public/Uploads/Theme/style4.jpg) no-repeat;' theme='style4'></li>
        </ul>
        <div class='model_operat'>
            <span class='model_save'>保存</span>
            <span class='model_cancel'>取消</span>
        </div>
    </div>
<!--==========自定义模版==========-->
<!--==========内容主体==========-->
    <div style='height:60px;opcity:10'></div>
    <div class="main">
    <!--=====左侧=====-->
        <!--=====左侧=====-->
    <div id="left" class='fleft'>
        <ul class='left_nav'>
            <li><a href="<?php echo U('Index/index');?>"><i class='icon icon-home'></i>&nbsp;&nbsp;首页</a></li>
            <li><a href="<?php echo U('User/atme');?>"><i class='icon icon-at'></i>&nbsp;&nbsp;提到我的</a></li>
            <li><a href="<?php echo U('Home/User/comment');?>"><i class='icon icon-comment'></i>&nbsp;&nbsp;评论</a></li>
            <li><a href="<?php echo U('User/letter');?>"><i class='icon icon-letter'></i>&nbsp;&nbsp;私信</a></li>
            <li><a href="<?php echo U('Home/User/weiboList');?>"><i class='icon icon-keep'></i>&nbsp;&nbsp;收藏</a></li>
        </ul>
        <div class="group">
            <fieldset><legend>分组</legend></fieldset>
            <ul class="addgrouplist">
                <?php $group = M("group")->where(array('uid' => session('uid')))->limit(5)->select(); ?>
                <li><a href="<?php echo U('Search/sechUser');?>"><i class='icon icon-group'></i>&nbsp;&nbsp;全部</a></li>
                <?php if(is_array($group)): foreach($group as $key=>$v): ?><li>
                        <a href="<?php echo U('Search/sechGroup', array('gid' => $v['id']));?>"><i class='icon icon-group'></i>&nbsp;&nbsp;<?php echo ($v["name"]); ?></a>
                    </li><?php endforeach; endif; ?>
            </ul>
            <span id='create_group'>创建新分组</span>
        </div>
    </div>
    
    <!--==========创建分组==========-->
    <script type='text/javascript'>
        var addGroup = "<?php echo U('Common:addGroup');?>";
    </script>
    <div id='add-group'>
        <div class="group_head">
            <span class='group_text fleft'>创建好友分组</span>
        </div>
        <div class='group-name'>
            <span>分组名称：</span>
            <input type="text" name='name' id='gp-name'>
        </div>
        <div class='gp-btn-wrap'>
            <span class='add-group-sub'>添加</span>
            <span class='group-cencle'>取消</span>
        </div>
    </div>
    <!--==========创建分组==========-->
    <!--=====右侧=====-->
        <div id='right'>
            <ul id='sel-edit'>
                <li class='edit-cur'>基本信息</li>
                <li>修改头像</li>
                <li>修改密码</li>
            </ul>
            <div class='form'>
                <form action="<?php echo U('Home/UserSetting/edit');?>" method='post'>
                    <p>
                        <label for=""><span class='red'>*</span><?php echo ($userinfo["username"]); ?>昵称：</label>
                        <input type="text" name='nickname' value="<?php echo ($userinfo["username"]); ?>" class='input' /><span></span>
                    </p>
                    <p>
                        <label for="">真实名称：</label>
                        <input type="text" name='truename' value='<?php echo ($userinfo["truename"]); ?>' class='input'/>
                    </p>
                    <p>
                        <label for=""><span class='red'>*</span>性别：</label>
                        <input type="radio" name='sex' value='1' <?php if($userinfo["sex"] == "男"): ?>checked='checked'<?php endif; ?>/>&nbsp;男&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" name='sex' value='2' <?php if($userinfo["sex"] == "女"): ?>checked='checked'<?php endif; ?>/>&nbsp;女
                    </p>
                    <p>
                        <label for=""><span class='red'>*</span>所在地：</label>
                        <select name="province" id="">
                            <option value="">请选择</option>
                        </select>&nbsp;&nbsp;&nbsp;&nbsp;
                        <select name="city">
                            <option value="">请选择</option>
                        </select>
                    </p>
                    <p>
                        <label for="">星座：</label>
                        <select name="night" id="">
                            <option value="">请选择</option>
                            <option value="白羊座">白羊座</option>
                            <option value="金牛座">金牛座</option>
                            <option value="双子座">双子座</option>
                            <option value="巨蟹座">巨蟹座</option>
                            <option value="狮子座">狮子座</option>
                            <option value="处女座">处女座</option>
                            <option value="天秤座">天秤座</option>
                            <option value="天蝎座">天蝎座</option>
                            <option value="射手座">射手座</option>
                            <option value="魔羯座">魔羯座</option>
                            <option value="水瓶座">水瓶座</option>
                            <option value="双鱼座">双鱼座</option>
                        </select>
                    </p>
                    <p>
                        <label for="" class='intro'>一句话介绍自己：</label>
                        <textarea name="intro"><?php echo ($userinfo["intro"]); ?></textarea>
                    </p>
                    <p>
                        <input type="submit" value='保存修改' class='edit-sub'/>
                    </p>
                </form>
            </div>
            <div class='form hidden'>
                <form action="<?php echo U('Home/UserSetting/face');?>" method='post'>
                    <div class='edit-face'>
                        <img src="
                        <?php if($userinfo["face180"]): ?>/project/Public<?php echo ($userinfo["face180"]); ?>
                        <?php else: ?>
                            /project/Public/Home/Images/noface.gif<?php endif; ?>" width='180' height='180' id='face-img'/>
                        <p>
                            <input type="file" name='face' id='face'/>
                        </p>
                        <p>
                            <input type="hidden" name='face180' value=''/>
                            <input type="hidden" name='face80' value=''/>
                            <input type="hidden" name='face50' value=''/>
                            <input type="submit" value='保存修改' class='edit-sub'/>
                        </p>
                    </div>
                </form>
            </div>
            <div class='form hidden'>
                <form action="<?php echo U('Home/UserSetting/editPwd');?>" method='post' name='editPwd'>
                    <p class='account'>登录邮箱：<span><?php echo ($account); ?></span></p>
                    <p>
                        <label for=""><span class='red'>*</span>旧密码：</label>
                        <input type="password" name='old' class='input'/><span></span>
                    </p>
                    <p>
                        <label for=""><span class='red'>*</span>新密码：</label>
                        <input type="password" name='new' class='input' id='new'/>
                    </p>
                    <p>
                        <label for=""><span class='red'>*</span>确认密码：</label>
                        <input type="password" name='newed' class='input'/><span></span>
                    </p>
                    <p>
                        <input type="submit" value='确认修改' class='edit-sub'/>
                    </p>
                </form>
            </div>
        </div>
    </div>
<!--==========内容主体结束==========-->
<!--==========底部==========-->
    <div id="bottom">
        <div id="copy">
            <div>
                <p>
                    版权所有：后盾网 京ICP备10027771号-1 站长统计 All rights reserved, houdunwang.com services for Beijing 2008-2012 
                </p>
            </div>
        </div>
    </div>
</body>
</html>