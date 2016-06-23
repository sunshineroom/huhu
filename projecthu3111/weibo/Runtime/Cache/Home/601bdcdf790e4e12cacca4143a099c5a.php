<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title><?php echo (C("WEBNAME")); ?>-我的私信</title>
	<link rel="stylesheet" href="/Public/Home/Theme/<?php echo ($style); ?>/Css/nav.css" />
	<link rel="stylesheet" href="/Public/Home/Theme/<?php echo ($style); ?>/Css/letter.css" />
	<link rel="stylesheet" href="/Public/Home/Theme/<?php echo ($style); ?>/Css/bottom.css" />
	<script type="text/javascript" src='/Public/Home/Js/jquery-1.8.3.min.js'></script>
    <script type="text/javascript" src='/Public/Home/Js/nav.js'></script>
    <script type='text/javascript' src='/Public/Home/Js/letter.js'></script>
    <script type='text/javascript'>
       
        var newletter = '<?php echo U("User/newletter");?>';
        var sechnewletter = '<?php echo U("User/sechnewletter");?>';
        //双击刷新
        var dblurl = "<?php echo U('Home/User/letter');?>";
        //增加聊天对话a链接
        var singlewei  ="<?php echo U('Home/User/index');?>";
    </script>
    
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
<div style='height:60px;opcity:10'></div>
</div>
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
       
    <!--=====中部=====-->
    <!-- 如果没有$_GET 就走这个区间 -->
    <?php if(empty($_GET)): ?> 
        <div id="middle" class='fleft'>
			<p class='title'>我的私信（共<?php echo ($count); ?>条）<span class='send'>发送私信</span></p>
        <?php if(is_array($letter)): foreach($letter as $key=>$v): if(in_array($v['username'],$oldname)) continue; ?>
 			<dl>
				<dt>
					<a href="<?php echo U('Home/User/index',array('uid'=>$v[uid]));?>"><img src="<?php if($v["face50"]): ?>/Public/<?php echo ($v["face50"]); else: ?>/Public/Home/Images/noface.gif<?php endif; ?>" width='50' height='50'/></a>
				</dt>
				<dd>
					<a href="<?php echo U('Home/User/index',array('uid'=>$v[uid]));?>"><?php echo ($v["username"]); ?>:</a>
                    <?php $oldname[]=$v['username'] ?> 
					<span><?php echo ($v["content"]); ?></span>
                    <i style="" class="fright number<?php echo ($v["uid"]); ?>"></i>
                </dd>
				<dd class='tright'>
                    <span class="send_time" time="<?php echo ($v["time"]); ?>"><?php echo date("y-m-d H:i",$v['time'])?></span>
					<span class='del-allletter' lid='<?php echo ($v["from"]); ?>'>删除</span> &nbsp;|&nbsp;
					<span class='l-reply' from="<?php echo ($v["from"]); ?>">回复</span>
				</dd>
			</dl><?php endforeach; endif; ?>
        
        </div>
    <?php else: ?>
        <!-- 对话窗 -->
        <div id="sendto" class="fleft">

            <p class="chating">正在与&nbsp;&nbsp;<i><?php echo ($chatusername); ?></i>&nbsp;&nbsp;对话中</p>
            <div id="lattermain">
                <?php if(is_array($letter)): foreach($letter as $key=>$v): ?><dl>
                    <!-- 排整对话框 -->
                  <?php if($v['username']==$chatusername): ?>
                        <!-- 给js抓取from -->
                        <div class="fromfrom" from="<?php echo ($v["from"]); ?>"></div>
                        <div class="yourmessage">
                            <dt class="fleft">
                                <a href="<?php echo U('Home/User/index',array('uid'=>$v[uid]));?>"><img src="<?php if($v["face50"]): ?>/Public<?php echo ($v["face50"]); else: ?>/Public/Home/Images/noface.gif<?php endif; ?>" width='50' height='50'/></a>
                            </dt>
                            <dd class="lettermsg">
                                <span class="fleft" style="padding-left:20px"><?php echo ($v["content"]); ?></span>
                            </dd>
                            <dd class='tright'>
                                <span class="send_time fleft" time="<?php echo ($v["time"]); ?>" style="padding-left:20px"><?php echo date("y-m-d H:i",$v['time'])?></span>
                                <span class='del-letter fleft' lid='<?php echo ($v["from"]); ?>' style="padding-left:20px;">删除</span>
                            </dd>
                        </div>
                    <?php else: ?>
                        <div class="mymessage">
                            <dt class="fright">
                                <a href="<?php echo U('Home/User/index',array('uid'=>$v[uid]));?>"><img src="<?php if($v["face50"]): ?>/Public/<?php echo ($v["face50"]); else: ?>/Public/Home/Images/noface.gif<?php endif; ?>" width='50' height='50'/></a>
                            </dt>
                            <dd class="lettermsg fright">
                                <span class="fright" style="padding-right:20px"><?php echo ($v["content"]); ?></span>
                            </dd>
                            <dd class="tright fright">
                                <span class="send_time fright" time="<?php echo ($v["time"]); ?>" style="padding-right:20px"><?php echo date("y-m-d H:i",$v['time'])?></span>
                                <span class='del-letter fright' lid="<?php echo ($v["from"]); ?>" style="padding-right:20px">删除</span> 
                            </dd>
                        </div>
                    <?php endif; ?>
                </dl><?php endforeach; endif; ?> 
                
            </div>
            <div id='privatemsg'>
                <div class='send-cons'>
                    <textarea></textarea>
                </div>
                <div class='lt-btn-wrap'>
                    <input  value='发送' class='send-lt-hu'/>
                </div>
            </div>
        
        </div>
            <!-- 发送框 -->
    <?php endif; ?>
        <!-- 结束对话框 -->
<!--==========右侧==========-->
        <div id="right">
    <div class="edit_tpl"><a href="" class='set_model'></a></div> 
<userinfo id='$_SESSION["uid"]'>
    <dl class="user_face">
        <dt>
            <a href="<?php echo U('Home/User/index',array('uid'=>session('uid')));?>">
                <img src="<?php if($face): ?>/Public/<?php echo ($face); else: ?>/Public/Home/Images/noface.gif<?php endif; ?>" width='80' height='80' alt="<?php echo ($username); ?>" />
            </a>
        </dt>
        <dd>
            <a href="<?php echo U('Home/User/index',array('uid'=>session('uid')));?>"><?php echo ($username); ?></a>
            <?php if($vtime == 1): ?><a href="<?php echo U('Home/Common/huiyuancenter');?>" class="huiyuantoux"></a><?php endif; ?>
        </dd>
    </dl>
    <ul class='num_list'>
        <li><a href="<?php echo U('Home/User/followList',array('follow'=>session('uid')));?>"><strong><?php echo ($follow); ?></strong><span>关注</span></a></li>
        <li><a href="<?php echo U('Home/User/fansList',array('fans'=>session('uid')));?>"><strong><?php echo ($fans); ?></strong><span>粉丝</span></a></li>
        <li class='noborder'>
            <a href="<?php echo U('Home/User/index',array('uid'=>session('uid')));?>"><strong><?php echo ($weibo); ?></strong><span>微博</span></a>
        </li>
    </ul>
</userinfo>
    <div class="maybe">
        <fieldset>
            
            <legend>可能感兴趣的人</legend>
            <ul>
                <maybe uid=<?php echo ($hobbymen['uid']); ?>>
                    <li>
                        <dl>
                            <dt>
                                <a href="<?php echo U('Home/User/index',array('uid'=>$hobbymen['uid']));?>">
                                    <img src="<?php if($hobbymen["face50"]): ?>/Public/<?php echo ($hobbymen["face50"]); else: ?>/Public/Home/Images/noface.gif<?php endif; ?>" width='30' height='30'/>
                                </a>
                            </dt>
                            <dd><a href="<?php echo U('Home/User/index',array('uid'=>$hobbymen['uid']));?>"><?php echo ($hobbymen['username']); ?></a></dd>
                            <dd>共<?php echo ($commonnum); ?>个共同好友</dd>
                        </dl>
                        <span class='heed_btn add-fl yiguanzhu' uid='<?php echo ($tauid); ?>'><strong>+&nbsp;</strong><i>关注</i></span>
                    </li>
                </maybe>
            </ul>
        </fieldset>
    </div>
    <div class="post">
        <div class='post_line'>
            <span>公告栏</span>
        </div>
        <?php $link = M('gonggao'); $gonglist = $link->where('`gongshow`=1')->limit(4)->select(); ?>
        <ul>
            <?php foreach ($gonglist as $key => $value): ?>
                <li><a href="<?php echo $value['gongsrc'] ?>"><?php echo $value['gongcontent'] ?></a></li>
            <?php endforeach ?>
        </ul>
    </div>
</div>
    </div>
<!--==========内容主体结束==========-->

<!--私信弹出框-->
<div id='letter'>
   
        <div class="letter_head">
            <span class='letter_text fleft'>发送私信</span>
        </div>
        <div class='send-user'>
            用户昵称：<input type="text" name='infousername' />
        </div>
        <div class='send-cons'>
            内容：<textarea name="content"></textarea>
        </div>
        <div class='lt-btn-wrap'>
            <input  value='发送' class='send-lt-sub'/>
            <span class='letter-cencle'>取消</span>
        </div>
    
</div>
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
<!-- 动态创建对话框 -->
<?php if(!empty($_GET['from'])): ?>
<script type="text/javascript">
    var newtop = $('#lattermain').find('dt:last').offset().top;
    // alert(newtop);
    $('#lattermain').scrollTop(newtop);
    var scrolltop = $('#lattermain').scrollTop();
    var from = $('.fromfrom').attr('from');
        var fromletter = setInterval(function(){
             $.post(sechnewletter,{from:from},function(data){
                if(data!=null){
                   for (var i = 0; i <  data.length; i++) {
                        var newmykuang =  $('<dl><dt class="fleft">\n\
                             <a href="'+singlewei+'?uid='+data[i]["uid"]+'"><img src="/Public/Images/Home/noface.gif</if>" width="50" height="50"/></a>\n\
                             </dt>\n\
                             <dd class="lettermsg fleft">\n\
                                 <span class="fleft" style="padding-left:20px">'+data[i]["content"]+'</span>\n\
                             </dd>\n\
                             <dd class="tright fleft">\n\
                                 <span class="send_time fleft" time="'+data[i]["time"]+'" style="padding-right:20px"><?php echo date("y-m-d H:i",'+data[i]["time"]+')?></span>\n\
                                 <span class="del-letter fleft" lid="<?php echo ($v["from"]); ?>" style="padding-right:20px">删除</span> \n\
                             </dd></dl>');
                        newmykuang.find('.send_time').attr('time',data[i]['time']).html(data[i]["newtime"]);
                        newmykuang.find('.del-letter').attr('lid',data[i]['from']); 
                        if(data[i]['face50']!=''){
                            newmykuang.find('img').attr('src','/Public'+data[i]['face50']);
                        }
                        $('#lattermain').append(newmykuang);  
                        // var lattermain = $('#lattermain').find('dt:last').offset().top;
                        var latteheight = $('#lattermain').find('dt:last').height();
                        // alert(lattermain+latteheight);
                        $('#lattermain').scrollTop(scrolltop+latteheight+1000);
                   };
                }
             },'json');
          },10000);
</script>
<?php endif; ?>