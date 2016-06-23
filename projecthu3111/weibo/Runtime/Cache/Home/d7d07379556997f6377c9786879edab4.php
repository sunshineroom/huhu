<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title>微博找人</title>
	<link rel="stylesheet" href="/Public/Home/Theme/<?php echo ($style); ?>/Css/nav.css" />
	<link rel="stylesheet" href="/Public/Home/Theme/<?php echo ($style); ?>/Css/sech_user.css" />
	<link rel="stylesheet" href="/Public/Home/Theme/<?php echo ($style); ?>/Css/bottom.css" />
	<script type="text/javascript" src='/Public/Home/Js/jquery-1.8.3.min.js'></script>
    <script type="text/javascript" src='/Public/Home/Js/nav.js'></script>
    <script type="text/javascript" src='/Public/Home/Js/sechuser.js'></script>
<!-- nav -->
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
<!--==========内容主体==========-->
	<div style='height:60px;opcity:10'></div>
    <div class="main">
    <!--=====左侧=====-->
        <!--=====左侧=====-->
    <div id="left" class='fleft'>
        <ul class='left_nav'>
            <li><a href="<?php echo U('Index/index');?>"><i class='icon icon-home'></i>&nbsp;&nbsp;首页</a></li>
            <li><a href="<?php echo U('User/atme');?>"><i class='icon icon-at'></i>&nbsp;&nbsp;提到我的</a></li>
            <li><a href="<?php echo U('User/comment');?>"><i class='icon icon-comment'></i>&nbsp;&nbsp;评论</a></li>
            <li><a href="<?php echo U('User/letter');?>"><i class='icon icon-letter'></i>&nbsp;&nbsp;私信</a></li>
            <li><a href="<?php echo U('User/keep');?>"><i class='icon icon-keep'></i>&nbsp;&nbsp;收藏</a></li>
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
        var addGroup = "";
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
        <div id='right'>
    		<p id='sech-logo'></p>
    		<div id='sech'>
    			<div>
	    			<form action="<?php echo U("Home/Search/sechUser");?>" method='get' name='search'>
	    				<input type="text" name='keyword' id='sech-cons' value='<?php if($keyword): echo ($keyword); else: ?>搜索微博、找人<?php endif; ?>'/>
	    				<input type="submit" value='搜&nbsp;索' id='sech-sub'/>
	    			</form>
    			</div>
    			<ul>
                    <li><span class='cur sech-type' url="<?php echo U('sechUser');?>">找人</span></li>
    				<li><span class='sech-type' url="<?php echo U('sechWeibo');?>">微博</span></li>
    			</ul>
    		</div>
    		<?php if(isset($result)): ?><div id='content'>
    			<?php if($result): ?><div class='view_line'>
	                <strong>用户</strong>
	            </div>
	            <ul>
	            	<?php if(is_array($result)): foreach($result as $key=>$v): ?><li class="jiafensi">
						<dl class='list-left'>
							<dt>
								<img src="
								<?php if($v["face80"]): ?>/Public/<?php echo ($v["face80"]); ?>
								<?php else: ?>
									/Public/Home/Images/noface.gif<?php endif; ?>" width='80' height='80'/>
							</dt>
							<dd>
								<a href="<?php echo U('Home/User/index',array('uid'=>$v['uid']));?>"><?php echo (str_replace($keyword, '<font style="color:red">' . $keyword . '</font>', $v["username"])); ?></a>
							</dd>
							<dd>
								<i class='icon icon-boy'></i>&nbsp;
								<span>
									
								</span>
							</dd>
							<dd>
								<span>关注 <a href="<?php echo U('Home/User/followList',array('follow'=>$v['uid']));?>"><?php echo ($v["follow"]); ?></a></span>
                                <span class='bd-l'>粉丝 <a href="<?php echo U('Home/User/fansList',array('fans'=>$v['uid']));?>"><?php echo ($v["fans"]); ?></a></span>
                                <span class='bd-l'>微博 <a href="<?php echo U('Home/User/index',array('uid'=>$v['uid']));?>"><?php echo ($v["weibo"]); ?></a></span>
							</dd>
						</dl>
	    				<dl class='list-right'>
	    					<?php if($v["mutual"]): ?><dt>互相关注</dt>
	    						<dd class='del-follow' uid='<?php echo ($v["uid"]); ?>' type='1'>移除</dd>
    						<?php elseif($v["followed"]): ?>
                            	<dt>√&nbsp;已关注</dt>
                            	<dd class='del-follow' uid='<?php echo ($v["uid"]); ?>' type='1'>移除</dd>
                        	<?php else: ?>
	    						<dt class='add-fl' uid='<?php echo ($v["uid"]); ?>'>+&nbsp;关注</dt><?php endif; ?>
	    				</dl>
	    			</li><?php endforeach; endif; ?>
    			</ul>
    			<div style="text-align:center;padding:20px;"><?php echo ($page); ?></div>
    			<?php else: ?>
    				<p style='text-indent:7em;'>未找到与<strong style='color:red'><?php echo ($keyword); ?></strong>相关的用户</p><?php endif; ?>
	        </div><?php endif; ?>
        </div>
    </div>
            <div id="pageStylegg">
                <?php echo ($page); ?>
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