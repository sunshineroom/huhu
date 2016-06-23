<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends CommonController {
    public function index(){
        // var_dump($_GET['uid']);
        $info = M('userinfo');

        $uid = $_GET['uid'];

        //查找粉丝,关注列表
        //follow关注列表
        $followlist = M('follow')->field('wb_follow.follow')->join('wb_userinfo on wb_userinfo.uid = wb_follow.fans')->where('wb_follow.fans="'.$uid.'" and wb_follow.follow != "'.$uid.'"')->select();
        // $followlist = M('follow')->field('wb_follow.follow')->join('wb_userinfo on wb_userinfo.uid = wb_follow.fans')->where('wb_follow.fans='.$uid)->select();
        $followcount = M('follow')->field('wb_follow.follow')->join('wb_userinfo on wb_userinfo.uid = wb_follow.fans')->where('wb_follow.fans="'.$uid.'" and wb_follow.follow != "'.$uid.'"')->count();
        $this->assign('follownum',$followcount);
        // dump($followlist);
        //关注不为自己
        $follownum = array();
        foreach ($followlist as $key => $value) {
            $follownum[] = $value['follow'];
        }
        $mp['uid'] = array('in',$follownum);
        $followlist = $info->where($mp)->select();
        $this->assign('follow',$followlist);
        // dump($followlist);
        //fans关注列表
        $followlist = M('follow')->field('wb_follow.fans')->join('wb_userinfo on wb_userinfo.uid = wb_follow.follow')->where('wb_follow.follow="'.$uid.'" and wb_follow.fans != "'.$uid.'"')->select();
        // $followlist = M('follow')->field('wb_follow.fans')->join('wb_userinfo on wb_userinfo.uid = wb_follow.follow')->where('wb_follow.follow='.$uid)->select();
        $followcount = M('follow')->field('wb_follow.fans')->join('wb_userinfo on wb_userinfo.uid = wb_follow.follow')->where('wb_follow.follow="'.$uid.'" and wb_follow.fans != "'.$uid.'"')->count();
        $follownum = array();
        $this->assign('fansnum',$followcount);
        foreach ($followlist as $key => $value) {
            $follownum[] = $value['fans'];
        }
        $mp['uid'] = array('in',$follownum);
        $followlist = $info->where($mp)->select();
        // dump($followlist);
        $this->assign('fans',$followlist);

        //查找粉丝关注列表

        $info = $info->where('uid='.$uid)->select();
        $info = $info[0];
        //判断是不是vip  ???
        $this->assign('userinfo',$info);
        $this->assign('countfollow',$info['follow']);
        $this->assign('countfans',$info['fans']);
        $this->assign('style',$info['style']);
        $weibo = M('weibo');
        $count = $weibo->where('uid = "'.$uid.'"')->count();
        $num = 4;
        $Page = new \Think\Page($count,$num);
        $show = $Page->show();
        $limit = $Page->firstRow.','.$Page->listRows;
        $res = M('userinfo')->join('wb_weibo on wb_userinfo.uid = wb_weibo.uid')->join('wb_picture on wb_weibo.id = wb_picture.wid','left')->where('wb_weibo.uid = "'.$uid.'"')->order('wb_weibo.time desc')->limit($limit)->select();
        // var_dump($res);
        // die;
        $this->assign('page',$show);
        $this->assign('weibo',$res);
        $this->display();
    }
    //搜寻所有这个用户发布的微博
    public function getWeibo(){
        // 多表查询 获取关注用户发布微博的总数
        $uid = $_GET['id'];
        $weibo = M('weibo');
        $count = $weibo->where('uid='.$uid)->count();
        
        // 每次刷新的条数
        $num = 4;
        $Page = new \Think\Page($count,$num);

        // 获取limit参数
        $limit = $Page->firstRow.','.$Page->listRows;
        // echo '<hr>';
        // 获取数据
        $model = M('weibo');
        // $result = $model->join('right join wb_userinfo on wb_userinfo.uid="'.$uid.'" AND wb_userinfo.uid=wb_follow.fans AND wb_follow.follow=wb_weibo.uid AND wb_picture.wid= wb_weibo.id')->select();
        // $result = $model->join('wb_userinfo on wb_follow.follow = wb_userinfo.uid')->where('wb_follow.fans="'.$uid.'"')->join('wb_weibo on wb_follow.follow=wb_weibo.uid')->join('wb_picture on wb_weibo.id=wb_picture.wid','left')->limit($limit)->order('wb_weibo.time desc')->select();
        $result = $model->join('wb_userinfo on wb_weibo.uid = wb_userinfo.uid')->where('wb_weibo.uid="'.$uid.'"')->join('wb_picture on wb_weibo.id=wb_picture.wid','left')->limit($limit)->order('wb_weibo.time desc')->select();
        // 返回结果
        // echo 1;
        echo json_encode($result);
    }

    //我的所有私信遍历
    public function letter(){
        //查询我的信息
        $info = M('userinfo');

        //可能感兴趣的人 发布微博数最多的而且你没有关注他
        $userinfo = M('userinfo');
        $weibo = $userinfo->field('weibo')->select();
        $weinum = array();
        foreach($weibo as $k=>$v){
            $weinum[] = $v['weibo'];
        }
        rsort($weinum);
        //判断你没有关注他
        for($i=0;$i<count($weinum);$i++){
            $maxuid = $userinfo->field('uid')->where('weibo='.$weinum[$i])->select();
            $maxuid = $maxuid[0]['uid'];
            if($maxuid==session('uid')){
                continue;
            }
            $fanslist = M('follow')->field('fans')->where('follow='.$maxuid)->select();
            $fans = array();
            foreach($fanslist as $k=>$v){
                $fans[] = $v['fans'];
            }
            if(in_array(session('uid'),$fans)) continue;
            $maxweiuid = $userinfo->join('wb_follow')->where('(wb_userinfo.weibo='.$weinum[$i].') and (wb_follow.follow='.$maxuid.')')->select();
            if($maxweiuid!=null){
                $this->assign('hobbymen',$maxweiuid[0]);
                break;
            }
        }
        //共多少个共同好友
        //他的uid
        $tauid = $maxweiuid[0]['uid'];

        $commonnum = $userinfo->join('wb_follow')->where('(( wb_follow.follow='.$tauid.' ) and ( wb_follow.follow='.session("uid").' )) and ((wb_follow.fans='.$tauid.') and (wb_follow.fans='.session("uid").')) ')->count();
        $this->assign('commonnum',$commonnum);
        $this->assign('tauid',$tauid);
        //结束可能感兴趣的人和共同好友

        $userinfo = $info->where('uid='.session('uid'))->select();
        $name = $userinfo[0]['username'];
        $follow = $userinfo[0]['follow'];
        $fans = $userinfo[0]['fans'];
        $weibo = $userinfo[0]['weibo'];
        $face = $userinfo[0]['face80'];
        $style = $userinfo[0]['style'];
        if($face!=''){
            $this->assign('face',$face);
        }
        $this->assign('style',$style);
        $this->assign('username',$name);
        $this->assign('fans',$fans);
        $this->assign('weibo',$weibo);
        $this->assign('follow',$follow);
        //判断是否为会员和会员是否到期
        $vip = M('vip');
        $isvip = $vip->where('uid='.session('uid'))->select();
        if(!empty($isvip)){
            if($isvip[0]['buytime']+$isvip[0]['vtime']>time()){
                $this->assign('vtime',1);
            }
        }
        
        //查看私信
        //新消息情空
        session('newletter',0);
    	$letter = M('letter');
        //如果有GET 表示是查询我与当前人私信
    	//userinfo和Letter表联查
        //示例语句 查询我和from的对话信息
        // SELECT * FROM `wb_letter` INNER JOIN wb_userinfo on wb_letter.from=wb_userinfo.uid WHERE
        //  (( wb_letter.from=4 ) and ( wb_letter.uid=1 )) or ((wb_letter.from=1) and (wb_letter.uid=4)) 
        //  ORDER BY time desc ;
       
        if(!empty($_GET)){
            $from = $_GET['from'];
            session($from,0);
        	$letterinfo = $letter->join('wb_userinfo on wb_letter.from=wb_userinfo.uid')
            ->where('(( wb_letter.from='.$_GET["from"].' ) and ( wb_letter.uid='.session("uid").' )) or ((wb_letter.from='.session("uid").') and (wb_letter.uid='.$_GET["from"].')) ')
            ->select();
            $userinfo = M('userinfo');
            //正在与谁对话
            $username = $userinfo->where('uid='.$_GET['from'])->field('username')->select();
            //我自己名字
            $myname = $userinfo->where('uid='.session('uid'))->field('username')->select();
            $myname = $myname[0]['username'];
            $username = $username[0]['username'];
            $this->assign('chatusername',$username);
            $this->assign('myname',$myname);
        }else{
            //否则 查询我的所有私信
            $letterinfo = $letter->join('wb_userinfo on wb_letter.from=wb_userinfo.uid')->order('time desc')->where(array('wb_letter.uid='.session("uid")))->select();
        }
        $num = $letter->where('uid='.session('uid'))->count();
    	$this->assign('count',$num);
    	$this->assign('letter',$letterinfo);
    	$this->display();
    }
    //增加letter
    public function addletter(){
        $time = time();
        $uid = session('uid');
        $_POST['time'] = $time;
        $_POST['from'] = $uid;
        $letter = M('letter');
        $le = $letter->create();
        $le = $letter->add();
        if($le>0){
            echo 1;
        }else{
            echo 0;
        }
    }
    //增加letter 返回json格式用于动态创建我发给对方的对话框
    public function addaddletter(){
        $letter = M('letter');

        $time = time();
        $uid = session('uid');
        $_POST['time'] = $time;
        //letter的from为我
        $_POST['from'] = $uid;
        $le = $letter->create();
        $le = $letter->add();
        //查找新增的那条信息
        $newkuang = $letter->join('wb_userinfo on wb_letter.from=wb_userinfo.uid')->where(array('wb_letter.id='.$le))->select();
        if($le>0){
            $newkuang[0]['newtime'] = date('y-m-d H:i',$newkuang[0]['time']);
            echo json_encode($newkuang[0]);
        }else{
            echo 0;
        }
    }
    //得到收信人的uid
    Public function getuid(){
    	$userinfo = M('userinfo');
    	$uid = $userinfo->where('username="'.$_POST["username"].'"')->field('uid')->select();
    	$uid = $uid[0]['uid'];
        if (session('uid')==$uid) {
            echo 0;
        }else{
            echo $uid;
        }
    }
    //删除当前对话人所有私信
    Public function delallletter(){
        //找到那条微博
        $letter = M('letter');
        $res = $letter->where("`from`='".$_POST['from']."' AND `uid`='".session('uid')."'")->delete();
        if($res>0){
            echo 1;
        }
    }
    //删除单条私信
    Public function delletter(){
        //找到那条微博
        $letter = M('letter');
        $id = $letter->where("`from`='".$_POST['from']."'  AND `time`='".$_POST['time']."'")
        ->field('id')->select();
        $res = $letter->where('id='.$id[0]['id'])->delete();
        //返回那条私信的id
        if($res>0){
            echo 1;
        }
    }
    //实时私信提醒 私信数量
    // Public function newletter(){
    //     $letter = M('letter');
    //     $newtime = time()-10;
    //     $letternum = $letter->where("`uid`='".session('uid')."' AND `time`>'".$newtime."'")->count();
    //     if($letternum>0){
    //         session('newletter',session('newletter')+$letternum);
    //         echo session('newletter');
    //     }
    // }
    Public function newletter(){
        $letter = M('letter');
        $newtime = time()-10;
        $letternum = $letter->where("`uid`='".session('uid')."' AND `time`>'".$newtime."'")->count();
        $fromuser = $letter->field('from')->where("`uid`='".session('uid')."' AND `time`>'".$newtime."'")->select();
        foreach($fromuser as $k=>$v){
            session($v['from'],session($v['from'])+1);
        }
        if($letternum>0){
            session('newletter',session('newletter')+$letternum);
            // echo session('newletter');
        }
        echo json_encode(session());
    }

    //动态创建实时对方发来的信息
    Public function sechnewletter(){
        $letter = M('letter');
        $newtime = time()-10;
        // $letternum = $letter->join('wb_userinfo on wb_letter.from=wb_userinfo.uid')->where("`uid`='".session('uid')."' AND `from`='".$_POST['from']."' AND `time`>'".$newtime."'")->select();
        $letternum = $letter->join('wb_userinfo on wb_letter.from=wb_userinfo.uid')->
        where('(( wb_letter.from='.$_POST["from"].' ) and ( wb_letter.uid='.session("uid").' )  and (wb_letter.time>'.$newtime.')) ')
        ->select();
        // $letternum = $letter->where("`uid`='".session('uid')."' AND `from`='".$_POST['from']."' AND `time`>'".$newtime."'")->select();
        $count = $letter->where("`uid`='".session('uid')."' AND `from`='".$_POST['from']."' AND `time`>'".$newtime."'")->count();
        for($i=0;$i<$count;$i++){
            $letternum[$i]['newtime'] = date('y-m-d H:i',$letternum[$i]['time']);
        }

        if(($letternum)!=null){
            echo json_encode($letternum);
        }
    }
    //关注列表
    Public function followList(){
        $follow = M('follow');
        if(!empty($_GET['follow'])){
            $fans = $_GET['follow'];
            echo $fans;
        }else{
            $fans = session('uid');
        }
        $count = $follow->where('fans='.$fans)->count();
        //分页
         $num = 1;
         $Page = new \Think\Page($count,$num);
         $show  = $Page->show();
        // 获取limit参数
        $limit = $Page->firstRow.','.$Page->listRows;
        //搜索我关注的所有人
        $followList = $follow->where('wb_follow.fans='.session('uid'))->join('wb_userinfo on wb_userinfo.uid=wb_follow.follow')
        ->limit($limit)->select();
        //判断每个人的关系
        foreach($followList as $k=>$v){
            //我关注了她
            if($follow->where('follow='.$v['uid'].' && fans='.session('uid'))->select()){
                //她也关注了我
                if($follow->where('fans='.$v['uid'].' && follow='.session('uid'))->select()){
                    //互相关注 mutual
                    $followList[$k]['mutual'] = 1;
                }else{
                    //已关注 followed
                    $followList[$k]['followed'] = 1;
                }
            }
            //否则互不关注
        }
        $info = M('userinfo')->where('uid='.session('uid'))->find();
        $this->assign('style',$info['style']);
        $this->assign('type',1);
        $this->assign('count',$count);
        $this->assign('users',$followList);
        $this->assign('page',$show);
        $this->display('followList');
    }
    //粉丝列表
    Public function fansList(){
        //搜索所有关注我的人
        $follow = M('follow');
        if(!empty($_GET['fans'])){
            $foll = $_GET['fans'];
        }else{
            $foll = session('uid');
        }
        $count = $follow->where('foll='.$follow)->count();
        //分页
        $num = 1;
        $Page = new \Think\Page($count,$num);
        $show  = $Page->show();
        // 获取limit参数
        $limit = $Page->firstRow.','.$Page->listRows;

        // $followList = $follow->where('wb_follow.follow='.session('uid'))->join('wb_userinfo on wb_userinfo.uid=wb_follow.fans')
        // ->select();
        $followList = $follow->join('wb_userinfo on wb_userinfo.uid=wb_follow.fans')->where('wb_follow.follow='.session('uid'))
        ->limit($limit)->select();

        //判断每个人的关系
        foreach($followList as $k=>$v){
            //我关注了她
            if($follow->where('follow='.$v['uid'].' && fans='.session('uid'))->select()){
                //她也关注了我
                if($follow->where('fans='.$v['uid'].' && follow='.session('uid'))->select()){
                    //互相关注 mutual
                    $followList[$k]['mutual'] = 1;
                }else{
                    //已关注 followed
                    $followList[$k]['followed'] = 1;
                }
            }
            //否则互不关注
        }
        $info = M('userinfo')->where('uid='.session('uid'))->find();
        $this->assign('style',$info['style']);
        $this->assign('count',$count);
        $this->assign('users',$followList);
        $this->assign('page',$show);
        $this->display('followList');
    }
    //收藏微博列表
    Public function weiboList(){
        $uid = $_SESSION['uid'];
        $info = M('userinfo')->where('uid="'.$uid.'"')->select();
        $info = $info[0];
        $model = M('weibo');
        $count = M('keep')->where('uid = "'.$uid.'"')->count();
        $num = 2;
        $Page = new \Think\Page($count,$num);
        $show = $Page->show();
        $limit = $Page->firstRow.','.$Page->listRows;
        $res = $model->join('wb_picture on wb_weibo.id = wb_picture.wid','left')->join('wb_keep on wb_weibo.id = wb_keep.wid')->join('wb_userinfo on wb_weibo.uid = wb_userinfo.uid')->where('wb_keep.uid = "'.$uid.'"')->order('wb_keep.ktime desc')->limit($limit)->select();
        $this->assign('page',$show);
        $this->assign('weibo',$res);
        $this->assign('style',$info['style']);
        $this->display();
       
    }
    // 删除收藏的微博
    public function cancelKeep(){
        $wid = I('post.wid');
        echo $wid;
        $keep = M('keep');
        $res = $keep->where('wid = "'.$wid.'"')->delete();
        echo json_encode($res);
    }
    // 评论显示
    public function comment(){
        $uid = $_SESSION['uid'];
        $userinfo = M('userinfo');

         //可能感兴趣的人 发布微博数最多的而且你没有关注他
        $weibo = $userinfo->field('weibo')->select();
        $weinum = array();
        foreach($weibo as $k=>$v){
            $weinum[] = $v['weibo'];
        }
        rsort($weinum);
        //判断你没有关注他
        for($i=0;$i<count($weinum);$i++){
            $maxuid = $userinfo->field('uid')->where('weibo='.$weinum[$i])->select();
            $maxuid = $maxuid[0]['uid'];
            if($maxuid==session('uid')){
                continue;
            }
            $fanslist = M('follow')->field('fans')->where('follow='.$maxuid)->select();
            $fans = array();
            foreach($fanslist as $k=>$v){
                $fans[] = $v['fans'];
            }
            if(in_array(session('uid'),$fans)) continue;
            $maxweiuid = $userinfo->join('wb_follow')->where('(wb_userinfo.weibo='.$weinum[$i].') and (wb_follow.follow='.$maxuid.')')->select();
            if($maxweiuid!=null){
                $this->assign('hobbymen',$maxweiuid[0]);
                break;
            }
        }
        //共多少个共同好友
        //他的uid
        $tauid = $maxweiuid[0]['uid'];

        $commonnum = $userinfo->join('wb_follow')->where('(( wb_follow.follow='.$tauid.' ) and ( wb_follow.follow='.session("uid").' )) and ((wb_follow.fans='.$tauid.') and (wb_follow.fans='.session("uid").')) ')->count();
        $this->assign('commonnum',$commonnum);
        $this->assign('tauid',$tauid);
        //结束可能感兴趣的人和共同好友
        
        $info = $userinfo->where('uid="'.$uid.'"')->select();
        $info = $info[0];
        $count = M()->table('wb_weibo,wb_comment')->where('wb_weibo.uid = "'.$uid.'" AND wb_comment.wid = wb_weibo.id AND wb_comment.state = 0 AND wb_comment.uid !="'.$uid.'"')->count();
        $res = M()->table('wb_weibo,wb_userinfo,wb_comment')->where('wb_weibo.uid = "'.$uid.'" AND wb_comment.wid = wb_weibo.id AND wb_comment.state = 0 AND wb_userinfo.uid = wb_comment.uid AND wb_comment.uid !="'.$uid.'"')->order('wb_comment.time desc')->select();
        // echo $count;
        // die;
        $this->assign('count',$count);
        $this->assign('comment',$res);
        $this->assign('face',$info['face80']);
        $this->assign('username',$info['username']);
        $this->assign('follow',$info['follow']);
        $this->assign('fans',$info['fans']);
        $this->assign('weibo',$info['weibo']);
        $this->assign('style',$info['style']);
        $this->display();
    }

    // 单方面删除接收的评论
    public function delComment(){
        $cid = I('post.cid');
        $comment = M('comment');
        $data['state'] = 1;
        $res = $comment->where('id = "'.$cid.'"')->save($data);
        if($res){
            echo true;
        }else{
            echo false;
        }
    }

    // 回复评论
    public function reply(){
        $data['wid'] = I('post.wid');
        $data['uid'] = $_SESSION['uid'];
        $data['content'] = I('post.content');
        $data['time'] = time();
        $comment = M('comment');
        $res = $comment->add($data);
        if($res){
            //评论数加1
            $weibo = M('weibo');
            $comment = $weibo->where('id = "'.I('post.wid').'"')->getField('comment');
            $date['comment'] = $comment + 1;
            $row = $weibo->where('id = "'.I('post.wid').'"')->save($date);
            echo true;
        }else{
            echo false;
        }
    }
    //atme我的微博
    public function atme(){
        session('newatme',0);
        //所有atme的找到所有wid
        $atme = M('atme');

        $wid = $atme->field('wid')->where('uid='.session('uid'))->select();
        $widnum = $atme->field('wid')->where('uid='.session('uid'))->count();
        // 所有微博的id
        $wids = array();
        for ($i=0; $i <$widnum ; $i++) { 
            $wids[] = $wid[$i]['wid'];
        }
        $count = $atme->where('uid='.session('uid'))->count();
        $num = 4;
        $Page = new \Think\Page($count,$num);

        $show = $Page->show();
        $limit = $Page->firstRow.','.$Page->listRows;
        $map['wb_weibo.id']  = array('in',$wids);
        $weibolist = M('userinfo')->join('wb_weibo on wb_weibo.uid = wb_userinfo.uid')->join('wb_picture on wb_weibo.id = wb_picture.wid','left')->where($map)->limit($limit)->order('wb_weibo.time desc')->select();
        // dump($weibolist);
        $info = M('userinfo')->where('uid='.session('uid'))->find();
        $this->assign('style',$info['style']);
        $this->assign('page',$show);
        $this->assign('weibo',$weibolist);
        $this->display();
    }

}

?>