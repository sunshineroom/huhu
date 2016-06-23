<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <title><?php echo (C("WEBNAME")); ?>-首页</title>
    <link rel="stylesheet" href="/Public/Home/Theme/default/Css/nav.css" />
    <link rel="stylesheet" href="/Public/Home/Theme/default/Css/index.css" />
    <link rel="stylesheet" href="/Public/Home/Theme/default/Css/bottom.css" />
    <link rel="stylesheet" href="/Public/Home/Uploadify/uploadify.css"/>
    <script type="text/javascript" src='/Public/Home/Js/jquery-1.8.3.min.js'></script>
    <script type="text/javascript" src='/Public/Home/Js/nav.js'></script>
    <script type="text/javascript" src='/Public/Home/Uploadify/jquery.uploadify.min.js'></script>
    <script type="text/javascript" src='/Public/Home/Js/index.js'></script>
    <script type='text/javascript'>
        var PUBLIC = '/Public';
        var uploadUrl = '<?php echo U("Home/Common/uploadPic");?>';
        var uid = '<?php echo ($_SESSION["uid"]); ?>';
        var getWeibo = '<?php echo U("Home/Index/getWeibo");?>';
        var getTurnWeibo = '<?php echo U("Home/Index/getTurnWeibo");?>'
        var clickZan = '<?php echo U("Home/Common/clickZan");?>';
        var commentUrl = "<?php echo U('Home/common/comment');?>";
        var getComment = '<?php echo U("Home/Common/getComment");?>';
        var keepUrl = '<?php echo U("Home/Common/keep");?>';
        var delWeibo = '<?php echo U("Home/Index/delWeibo");?>';
        //我的
        var newletter = '<?php echo U("User/newletter");?>';
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
        //发送ajax来实时发现@我的
        var atmemeurl = '<?php echo U("Common/atmemeurl");?>';
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
            <li style='background:url(/Public/Home/Images/default.jpg) no-repeat;' theme='default'></li>
            <li style='background:url(/Public/Home/Images/style2.jpg) no-repeat;' theme='style2'></li>
            <li style='background:url(/Public/Home/Images/style3.jpg) no-repeat;' theme='style3'></li>
            <li style='background:url(/Public/Home/Images/style4.jpg) no-repeat;' theme='style4'></li>
        </ul>
        <div class='model_operat'>
            <span class='model_save'>保存</span>
            <span class='model_cancel'>取消</span>
        </div>
    </div>
<!--==========自定义模版==========-->
<!--==========内容主体==========-->
<div style='height:60px;opcity:10'></div>
    <?php $user = M('userinfo');$user = $user->where('uid='.session("uid"))->select();?> 
    <div id="huiyuan">
        <div id="huimain">
            <div id="welcome">欢迎来到小小微博vip中心</div>
            <dl class="user_face huiyuanface">
                <dt>
                    <a href="<?php echo U('/' . $uid);?>">
                        <img src="<?php if($face): ?>/Public/<?php echo ($face); else: ?>/Public/Home/Images/noface.gif<?php endif; ?>" width='180' height='180' alt="<?php echo ($username); ?>" />
                    </a>
                    <a href="<?php echo U('/' . $uid);?>" class="centertou"><?php echo ($info["username"]); ?></a>
                    <?php if($vtime == 1): ?><a href="<?php echo U('/' . $uid);?>" class="huiyuantoux centertouxiang">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a><?php endif; ?>
                </dt>
                <dd class="fleft">
                </dd>
            </dl>
        <?php if($vtime == 1): ?><ul>
                <div class="daoqi">您的vip将在<i style="color:red;font-size:25px"><?php echo ($day); ?></i>天后到期</div>
            </ul>
            <ul>
                <a href="<?php echo U('Home/Common/huiyuan');?>"><button class="fleft payow">继续续加</button></a>
            </ul>
        <?php else: ?>
            <ul>
                <div class="daoqi">您还不是vip会员</div>
            </ul>
            <ul>
                <a href="<?php echo U('Home/Common/huiyuan');?>"><button class="fleft payow">立即开通</button></a>
            </ul><?php endif; ?>   
        </div>
        <div id="wenxin">
            <ul>
                <li class="action">温馨提示：</li>
                <li class="notice">1、若您的微博会员有效期已达上限，则不能续费。</li>
                <li class="notice">2、若您为手机包月用户，则本次支付的会员时长将在退订手机包月后延续。</li>
                <li class="notice">4、支付宝自动续费金额为扣款当日的会员原价9折。</li>
            </ul>
        </div>
    </div>
<!--==========内容主体结束==========-->
<script>
   


</script>
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