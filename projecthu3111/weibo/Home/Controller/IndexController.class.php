<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends CommonController {
    public function index(){
        //广告
        // 广告
        $advert = M('advert');
        $adverts = $advert->select();
        $this->assign('adverts',$adverts);

        $uid = $_SESSION['uid'];
        $userinfo = M('userinfo');
        $info = $userinfo->where('uid="'.$uid.'"')->select();
        $info = $info[0];
        
        //判断是否为会员和会员是否到期
        $vip = M('vip');
        $isvip = $vip->where('uid='.session('uid'))->select();

        if(!empty($isvip)){
            if($isvip[0]['buytime']+$isvip[0]['vtime']>time()){
                $this->assign('vtime',1);
            }
        }
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
        // dump($commonnum);
    	$this->assign('tauid',$tauid);
    	//结束可能感兴趣的人和共同好友
        $this->assign('face',$info['face80']);
        $this->assign('username',$info['username']);
        $this->assign('follow',$info['follow']);
        $this->assign('fans',$info['fans']);
        $this->assign('weibo',$info['weibo']);
        $this->assign('style',$info['style']);
        // $this->assign('wb',$res);
    	$this->display();
    }

    public function getWeibo(){
        // 多表查询 获取关注用户发布微博的总数
        $uid = $_SESSION['uid'];
        $model = M();
        $count = $model->table('wb_userinfo info,wb_follow follow,wb_weibo weibo')->where('info.uid="'.$uid.'" AND '.'info.uid=follow.fans AND follow.follow=weibo.uid')->count();
        // echo $model->_sql();
        // echo $count;
        // 创建分页
        // 每次刷新的条数
        $num = 10;
        $Page = new \Think\Page($count,$num);

        // 获取limit参数
        $limit = $Page->firstRow.','.$Page->listRows;
        // echo '<hr>';
        // 获取数据
        $model = M('follow');
        // $result = $model->join('right join wb_userinfo on wb_userinfo.uid="'.$uid.'" AND wb_userinfo.uid=wb_follow.fans AND wb_follow.follow=wb_weibo.uid AND wb_picture.wid= wb_weibo.id')->select();
        $result = $model->join('wb_userinfo on wb_follow.follow = wb_userinfo.uid')->where('wb_follow.fans="'.$uid.'"')->join('wb_weibo on wb_follow.follow=wb_weibo.uid')->join('wb_picture on wb_weibo.id=wb_picture.wid','left')->limit($limit)->order('wb_weibo.time desc')->select();
        // echo $model->_sql();
        // 返回结果
        // var_dump($result);
        echo json_encode($result);
    }

    public function getTurnWeibo(){
        $id = I('post.wid');
        $model = M('weibo');
        $res = $model->join('wb_userinfo on wb_weibo.uid = wb_userinfo.uid')->where('wb_weibo.id = "'.$id.'"')->join('wb_picture on wb_weibo.id = wb_picture.wid','left')->find();
        echo json_encode($res);
    }

    public function delWeibo(){
        $uid = $_SESSION['uid'];
        $wid = I('post.wid');
        $pic = M('picture');
        $res = $pic->where('wid = "'.$wid.'"')->find();
        // var_dump($res);
        // die;
        if($res['max'] == null){
            $weibo = M('weibo');
            $res = $weibo->where('id = "'.$wid.'"')->delete();
            if($res){
                //uid的发表微博数加+1
                $weibo_num = M('userinfo')->where('uid = "'.$uid.'"')->getField('weibo');
                $date_weibo['weibo']= $weibo_num - 1;
                $rows = M('userinfo')->where('uid = "'.$uid.'"')->save($date_weibo);
                echo '1';
            }else{
                echo '0';
            }
        }else{
            unlink('./Public/'.$res['max']);
            unlink('./Public/'.$res['medium']);
            unlink('./Public/'.$res['mini']);
            $weibo = M('weibo');
            $row = $weibo->where('id = "'.$wid.'"')->delete();
            $row = $pic->where('wid = "'.$wid.'"')->delete();
            if($res){
                //uid的发表微博数加+1
                $weibo_num = M('userinfo')->where('uid = "'.$uid.'"')->getField('weibo');
                $date_weibo['weibo']= $weibo_num - 1;
                $rows = M('userinfo')->where('uid = "'.$uid.'"')->save($date_weibo);
                echo '1';
            }else{
                echo '0';
            }
        }
    }

    public function turn(){
        $tid = I('post.tid');
        if($tid == 0){
            $data['isturn'] = I('post.id');
        }else{
            $data['isturn'] = $tid;
        }
        $data['content'] = I('post.content');
        $data['time'] = time();
        $data['uid'] = $_SESSION['uid'];
        $weibo = M('weibo');
        $res = $weibo->add($data);
        if($res){
            if($tid != 0){
               $turn = $weibo->where('id = "'.$tid.'"')->getField('turn');
               $date['turn'] = $turn + 1;
               $weibo->where('id = "'.$tid.'"')->save($date);
               if(isset($_POST['becomment'])){
                   $comment_num = $weibo->where('id = "'.$tid.'"')->getField('comment');
                   $date_comment['comment'] = $comment_num + 1;
                   $weibo->where('id = "'.$tid.'"')->save($date_comment);
                   $comment['content'] = I('post.content');
                   $comment['uid'] = $_SESSION['uid'];
                   $comment['wid'] = $tid;
                   $comment['time'] = $data['time'];
                   $row = M('comment')->add($comment);
                }
            }
            $turn = $weibo->where('id = "'.I('post.id').'"')->getField('turn');
            $date['turn'] = $turn + 1;
            $weibo->where('id = "'.I('post.id').'"')->save($date);
            if(isset($_POST['becomment'])){
                $comment_num = $weibo->where('id = "'.I('post.id').'"')->getField('comment');
                $date_comment['comment'] = $comment_num + 1;
                $weibo->where('id = "'.I('post.id').'"')->save($date_comment);
                $comment['content'] = I('post.content');
                $comment['uid'] = $_SESSION['uid'];
                $comment['wid'] = I('post.id');
                $comment['time'] = $data['time'];
                $row = M('comment')->add($comment);
             }
            $this->success('','',0);
        }else{
            $this->error('转发失败','',3);
        }
    }
    public function reportWeibo(){
        $wid = I('post.wid');
        $weibo = M('weibo');
        $report_num = $weibo->where('id = "'.$wid.'"')->getField('report');
        $data['report'] = $report_num + 1;
        $res = $weibo->where('id = "'.$wid.'"')->save($data);
        if($res){
            echo json_decode('1'); 
        }else{
            echo json_decode('0');
        }
    }
    public function editStyle(){
        $uid = $_SESSION['uid'];
        $data['style'] = I('post.style');
        $res = M('userinfo')->where('uid ="'.$uid.'"')->save($data);
        if($res){
            echo true;
        }else{
            echo false;
        }
    }
    public function loginOut(){
    	$uid = $_SESSION['uid'];
        $user = M('user');
        $data['status'] = 1;
        $res = $user->where('id ="'.$uid.'"')->save($data);
        session(null);
        if(empty($_SESSION)){
            $this->success("退出成功",U('Home/Login/index'),3);
        }
    }
    


}
?>