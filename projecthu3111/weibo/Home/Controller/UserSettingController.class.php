<?php
namespace Home\Controller;
use Think\Controller;
class UserSettingController extends CommonController {

    public function index(){
        $uid = $_SESSION['uid'];
        $user = M('userinfo');
        $res = $user->where('uid ="'.$uid.'"')->find();
        $user = M('user');
        $account = $user->where('id ="'.$uid.'"')->getField('account');
        // echo $user->_sql();
        // $res['location'] = explode(',',$res['location']);
        // var_dump($res);
        // var_dump($account);
        // die;
        $this->assign('userinfo',$res);
        $this->assign('style',$res['style']);
        $this->assign('account',$account);
        $this->display();
    }

    public function edit(){
        // var_dump($_POST);
        $uid = $_SESSION['uid'];
        $info['username'] = I('post.nickname');
        $info['truename'] = I('post.truename');
        $info['sex'] = I('post.sex')=='1'?'男':'女';
        $info['location'] = I('post.province').','.I('post.city'); 
        $info['constellation'] = I('post.night');
        $info['intro'] = I('post.intro');
        // var_dump($info);
        $user = M('userinfo');
        $res = $user->where('uid ="'.$uid.'"')->save($info);
        // echo $user->_sql();
        if($res){
            $this->success('修改成功','',3);
        }else{
            $this->success('修改失败','',3);
        }
    
    }

    public function face(){
        // var_dump($_POST);
        $uid = $_SESSION['uid'];
        // $user = M('userinfo');
        // $res = $user->where('uid="'.$uid.'"')->field('face180,face80,face50')->select();
        $Model = M();
        $res = $Model->table(array('wb_user'=>'user','wb_userinfo'=>'info'))->where('user.id = info.uid AND info.uid = "'.$uid.'"')->field('user.account,info.face180,info.face80,info.face50')->select();
        // echo $Model->_sql();
        $res = $res[0];
        $user = M('userinfo');
        $row = $user->where('uid="'.$uid.'"')->save($_POST);
        // echo $user->_sql();
        if($row){
            if(!empty($res['face180'])){
                $path1 = './Public'.$res['face180'];
                $path2 = './Public'.$res['face80'];
                $path3 = './Public'.$res['face50'];
                $account = $res['account'];
                moveFile($path1,$account);
                moveFile($path2,$account);
                moveFile($path3,$account);
            }
            $this->success('修改成功','','3');
        }else{
            unlink('./Public'.$res['face180']);
            unlink('./Public'.$res['face80']);
            unlink('./Public'.$res['face50']);
             $this->success('修改失败','','3');
        }
       
        // var_dump($res);
    }


    public function editPwd(){
        $newPwd = I('post.new');
        $Pwd['password'] = $newPwd;
        $uid = $_SESSION['uid'];
        $user = M('user');
        $res = $user->where('id="'.$uid.'"')->save($Pwd);
        if($res){
            $this->success('密码修改成功',U('Home/Login/index'),3);
        }else{
            $this->error('密码修改失败','',3);
        }
    }

    public function ajaxpwd(){
        $uid = $_SESSION['uid'];
        $password = I('post.password');
        $user = M('user');
        $res = $user->where('id="'.$uid.'"')->getField('password');
        // echo $user->_sql();
        // var_dump($res) ;
        if($res == $password){
            echo '0';
        }else{
            echo '1';
        }
    }

    public function ajax(){
      // var_dump($_POST);
      // $uid = I('post.uid');
      $username = I('post.username');
      // die;  
      $user = M('userinfo');
      $res = $user->where('username ="'.$username.'"')->getField('uid');
      // echo $user->_sql();
      // echo $res;
      if($res){
        echo $res;
      }else{
        echo 0;
      }
    }
}
?>