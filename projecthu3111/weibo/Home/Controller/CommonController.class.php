<?php
namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller {


    //功能类似构造方法,率先执行的方法
    public function _initialize(){
        //用户的登录检测
        $id = session('uid');
        //检测
        if (empty($id)) {
            //没有登录
            $this->error('你还没有登录',U('Home/Login/index'),3);
        }
    }

    public function uploadPic(){
        $upload = $this->_upload('Pic',array('jpg','gif','png','jpeg'),10485760,array('800','380','120'));
        echo json_encode($upload);
    }

    public function uploadFace(){
        $upload = $this->_upload('Face',array('jpg','gif','png','jpeg'),10485760,array('180','80','50'));
        echo json_encode($upload);
    }

    public function uploadMV(){

    }
//发布原创微博
    public function send(){
        // var_dump($_POST);
        // die;
        $uid = $_SESSION['uid'];
        $time = time();
        $content = I('post.content'); 
        $weibo = M('weibo');
        $data['content'] = $content;
        $data['uid'] = $uid;
        $data['time'] = $time;
        //搜索所有用户名username
        $info = M('userinfo');
        $usernames = $info->field('username')->select();
        $count = $info->count();
        //得到所有用户名
        $users = array();
        for($i=0;$i<$count;$i++){
            $users[] = $usernames[$i]['username'];
            $uids[] = $usernames[$i]['uids'];
        }
        //得到所有@的人
        $atList = array();
        $patter = '/@\S+\s{1}/';
        // 所有at用户的uid
        $uid = array();
        if(preg_match_all($patter,$content,$matchs,PREG_SET_ORDER)){
            foreach($matchs as $k=>$list){
                $username = rtrim($list[0]);
                $username = ltrim($username,'@');
                if(in_array($username,$users)){
                    // 得到username的uid
                    $rs = $info->field('uid')->where('username="'.$username.'"')->select();
                    $uid[] = ($rs[0]['uid']);
                }
            }
        }
        //自增微博id
        $res = $weibo->add($data); 
        //插入atme数据库
        $atme = M('atme');
        for ($i=0; $i <count($uid) ; $i++) { 
            $dataList = array('uid'=>$uid[$i],'wid'=>$res);
            $atme->add($dataList);
        }
        if($_POST['max'] == null){
            if($res){
                //uid的发表微博数加+1
                $weibo_num = M('userinfo')->where('uid = "'.$uid.'"')->getField('weibo');
                $date_weibo['weibo']= $weibo_num + 1;
                $rows = M('userinfo')->where('uid = "'.$uid.'"')->save($date_weibo);
                $this->success('发送成功','','1'); 
            }else{
                $this->error('发送失败','','1');
            }
        }else{
            if($res){
                $data_pic['max'] = $_POST['max'];
                $data_pic['medium'] = $_POST['medium'];
                $data_pic['mini'] = $_POST['mini'];
                $data_pic['wid'] = $res;
                // var_dump($data_pic);
                // die;
                $pic = M('picture');
                $resoult = $pic->add($data_pic);
                if($resoult){
                    //uid的发表微博数加+1
                    $weibo_num = M('userinfo')->where('uid = "'.$uid.'"')->getField('weibo');
                    $date_weibo['weibo']= $weibo_num + 1;
                    $rows = M('userinfo')->where('uid = "'.$uid.'"')->save($date_weibo);
                    $this->success('发送成功','','1');
                }else{
                    $weibo->where('id = "'.$res.'"')->delete();
                    unlink($_POST['max']);
                    unlink($_POST['medium']);
                    unlink($_POST['mini']);
                }
            }else{
                unlink($_POST['max']);
                unlink($_POST['medium']);
                unlink($_POST['mini']);
            }  
        }
    }


    protected function _upload($path,$type,$size,$width){
        // 实例化上传类
        $upload = new \Think\Upload();
        $upload->maxSize = $size;
        // 设置文件上传类型
        $upload->exts = $type;
        // 设置保存路径
        $upload->rootPath = './Public';
        $upload->savePath = '/Uploads/'.$path.'/';
        // 开启子目录保存 并以日期(格式为Y-m-d)为子目录
        $upload->autoSub = true;
        $upload->subName = array('date','Y-m-d');    
        $info = $upload->upload();
        if(!$info){
            $msg = $upload->getError();
            return array(
                'status' => 0,
                'msg' => $msg
                );
        }else{
            $path = $upload->rootPath.$info['Filedata']['savepath'].$info['Filedata']['savename'];
            $path_l = $upload->rootPath.$info['Filedata']['savepath'];
            $path_r = $info['Filedata']['savename'];
            // 生成缩略图
            if(!empty($width)){
                $img = new \Think\Image(); 
                $img->open($path);
                $qz = array('max_','medium_','mini_');
                for( $i = 0; $i< count($width); $i++){
                    $img->thumb($width[$i],$width[$i])->save($path_l.$qz[$i].$path_r);
                }
                unlink($path); //删除原图
            }
            $path =array(
               'max' => $info['Filedata']['savepath'].$qz['0'].$info['Filedata']['savename'],
               'medium' => $info['Filedata']['savepath'].$qz['1'].$info['Filedata']['savename'],
               'mini' => $info['Filedata']['savepath'].$qz['2'].$info['Filedata']['savename']
                );
            // $path = var_dump($info);   
            return array(
                'status' => 1,
                'path' => $path
                );
        }
    }

    public function clickZan(){
        // var_dump($_GET);
        $num = I('get.num');
        $wid = I('get.wid');
        $data['zan'] = $num;
        $weibo = M('weibo');
        $res = $weibo->where('id = "'.$wid.'"')->save($data);
        echo json_encode($res);
    }


    public function comment(){
        $isturn = I('post.isturn');
        $_POST['time'] = time();
        $comment = M('comment');
        $comment->create();
        $res = $comment->add();
        //评论时 微博表中评论转发数+1
        $weibo = M('weibo');
        $comment_num = $weibo->where('id = "'.I('post.wid').'"')->getField('comment');
        $date_comment['comment']= $comment_num + 1;
        $rows = $weibo->where('id = "'.I('post.wid').'"')->save($date_comment);
        if($res){
            if($isturn){
                //uid的发表微博数加+1
                $weibo_num = M('userinfo')->where('uid = "'.I('post.uid').'"')->getField('weibo');
                $date_weibo['weibo']= $weibo_num + 1;
                $rows = M('userinfo')->where('uid = "'.I('post.uid').'"')->save($date_weibo);
                //转发时 微博表中转发数+1
                $turn_num = $weibo->where('id = "'.I('post.wid').'"')->getField('turn');
                $date_turn['turn']= $turn_num + 1;
                $rows = $weibo->where('id = "'.I('post.wid').'"')->save($date_turn);
                //增加一条转发微博
                $data['time'] = $_POST['time'];
                $data['content'] = I('post.content');
                $data['isturn'] = I('post.wid');
                $data['uid'] = I('post.uid');               
                $row = $weibo->add($data); 
            }
            $info = M('userinfo')->where('uid ="'.I('post.uid').'"')->find();
            $str = '';
            $username = $info['username'];
            $face50 = $info['face50'];
            $str .= '<dl class="comment_content">';
            // 跳到个人主页  代后开发
            $str .= '<dt><a href="">';
            $str .= '<img src="';
            if($face50){
                $str .= "/Public".$face50; 
            }else{
                $str .= '/Public/Home/Images/noface.gif';
            }
            $str .= '" alt="'.$username.'" width="30px" height="30px">';
            $str .= '</a></dt><dd>';
            $str .= '<a href="" class="comment_name">';
            $str .= $username.'</a> : '.I('post.content');  
            $str .= '<h3 style="margin-top:5px">'.date('Y-m-d H:i:s',$_POST['time']).'</h3>'; 
            $str .= '<div class="reply" style="margin-top:-20px">';
            $str .= '<a href="">回复</a>';
            $str .= '</div></dd></dl>';

            echo $str;
        }else{
            echo false;
        }
    }

    public function getComment(){
        $wid = I('get.wid');
        $p = empty($_GET['p'])?1:$_GET['p'];
        $comment = M('comment');
        $count = $comment->where('wid ="'.$wid.'"')->count();
        $num = 2;
        $Page = new \Think\Page($count,$num);
        $limit = $Page->firstRow.','.$Page->listRows;
        $res = $comment->where('wid = "'.$wid.'"')->order('time desc')->limit($limit)->select();
        // var_dump($res);
        if($res){
            $str = '';
            foreach ($res as $k => $val) {
                $info = M('userinfo')->where('uid ="'.$val['uid'].'"')->find();
                $username = $info['username'];
                $face50 = $info['face50'];
                $str .= '<dl class="comment_content">';
                // 跳到个人主页  代后开发
                $str .= '<dt><a href="">';
                $str .= '<img src="';
                if($face50){
                    $str .= "/Public".$face50; 
                }else{
                    $str .= '/Public/Home/Images/noface.gif';
                }
                $str .= '" alt="'.$username.'" width="30px" height="30px">';
                $str .= '</a></dt><dd>';
                $str .= '<a href="" class="comment_name">';
                $str .= $username.'</a> : '.$val['content'];  
                $str .= '<h3 style="margin-top:5px">'.date('Y-m-d H:i:s',$val['time']).'</h3>'; 
                $str .= '<div class="reply" style="margin-top:-20px">';
                $str .= '<a href="">回复</a>';
                $str .= '</div></dd></dl>';
            }
            $str .='<div class="comment-page">'.$Page->show().'</div>';
            echo $str;
        }         
    }

    public function keep(){
        $wid = I('post.wid');
        $uid = $_SESSION['uid'];
        $keep = M('keep');
        $res = $keep->where('uid = "'.$uid.'" AND wid = "'.$wid.'"')->select();
        if(!empty($res)){
            echo json_decode(-1);
        }else{
            $data['uid'] = $uid;
            $data['wid'] = $wid;
            //1111
            $data['ktime'] = time();
            $row = $keep->add($data);
            if($row){
                echo json_decode(1); 
            }else{
                echo json_decode(0);
            }
        }
    }
    //发送ajax来实时发现@我的
    public function atmemeurl(){
        $weibo = M('weibo');
        $newtime = time()-10;
        //得到时间之内的微博的id和uid
        $wei = $weibo->where('time>'.$newtime)->field('id,uid')->select();
        $weibocount = $weibo->where('time>'.$newtime)->field('id,uid')->count();
        $atme = M('atme');
        // echo $weibocount;
        for ($i=0; $i <$weibocount ; $i++) { 
            //所有atme表的所有wid为$wei[$i]['id']和uid为session('uid')的atme
            $atmeList = $atme->where('`wid`="'.$wei[$i]["id"].'" and `uid`="'.session("uid").'"')->select();
            if(!empty($atmeList)){
                session('newatme',session('newatme')+1);
                // echo $newatme;
                // $newletter = session('newletter',session('newatme'));

            }else{
                // echo 6;
            }
        }
        // echo session('newletter');
        echo json_encode(array('newatme'=>session('newatme'),'newletter'=>session('newletter')));
        
    }
    //会员购买
    PUBLIC function huiyuan(){
        $this->display();
    }
    //会员中心
    public function huiyuancenter(){
        $userinfo = M('userinfo');
        $info = $userinfo->where('uid='.session('uid'))->select();
        if($info[0]['face180']!=''){
            $this->assign('face',$info[0]['face180']);
        }
        $this->assign('info',$info[0]);
        //判断是不是会员
        $vip = M('vip');
        $isvip = $vip->where('uid='.session('uid'))->select();

        if(!empty($isvip)){
            //会员是否到期
            if($isvip[0]['buytime']+$isvip[0]['vtime']>time()){
                //是会员
                $this->assign('vtime',1);
                //会员到期时间
                $day = floor(($isvip[0]['buytime']+$isvip[0]['vtime']-time())/24/3600);
                $this->assign('day',$day);
            }
        }
        $this->display();
    }
    //会员开通
    public function vip(){
        $username = $_POST['huiyuanname'];
        $userinfo = M('userinfo');
        $uid = $userinfo->where('username="'.$username.'"')->select();
        //购买时间转化为秒数
        $_POST['buytime'] = $_POST['buytime']*30*24*3600;
        //vip购买时间
        $_POST['vtime'] = time();
        //到期时间就是vtime+buytime<现在时间
        $vip = M('vip');
        //会员续增
        $isvip = $vip->where('uid="'.$uid[0]["uid"].'"')->select();
        if(!empty($isvip)){
            //会员是否到期
            if($isvip[0]['buytime']+$isvip[0]['vtime']>time()){
                //增加会员购买时间
                $res = $vip->where('uid="'.$uid[0]["uid"].'"')->setInc('buytime',$_POST['buytime']);
                echo $vip->_sql();
                if($res){
                    $this->success('恭喜你续加vip成功',U('Home/Index/index'),2);
                    die;
                }else{
                    $this->error('请核对信息');
                    die;
                }
            }
        }
        
        $_POST['uid'] = $uid[0]['uid'];
        $vip->create();
        $res = $vip->add();
        if($res){
            $this->success('恭喜你成为小小微博vip',U('Home/Index/index'),2);
        }else{
            $this->error('请核对信息');
        }
    }
    
}