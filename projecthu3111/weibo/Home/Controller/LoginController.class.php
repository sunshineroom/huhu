<?php
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller {
    //注册登录类

    //登陆页面
    public function index(){
        $this->display();
    }

    //用户进行登录
        public function login(){
            $user = M('user');
            // var_dump($user);
            //接受数据
            $account = I('post.account');
            $password = I('post.password');

            //查询
            $info = $user->where('account = "'.$account.'" and password = "'.$password.'"')->find();
            // echo $user->_sql();
            // var_dump($info);
            // die;

            $id = $info['id'];
            if (!empty($info)) {
                if($info['lock'] == '0'){
                    if($info['datetime'] == '0'){
                        session_start();
                        $_SESSION['uid'] = $info['id'];
                        session('account',$info['account']);
                        $data['status'] = 0;
                        $res = $user->where('id ="'.$id.'"')->save($data);
                        $this->success('登录成功',U('Home/Index/index'),3);
                    }else if(time() >= $info['datetime']){
                        session_start();
                        $_SESSION['uid'] = $info['id'];
                        session('account',$info['account']);
                        $data['status'] = 0;
                        $data['datetime'] = 0;
                        $data['warning'] = null;
                        $res = $user->where('id ="'.$id.'"')->save($data);
                        $this->success('登录成功',U('Home/Index/index'),3);
                    }else{
                        $this->error($info['warning'],'',3);
                    }
                }else{
                    $this->error($info['warning'],'',3);
                }
                
            }else{
                $this->error('请输入正确的登录邮箱','',3);
            }
        }

    //注册页面;
    public function register(){

        $this->display();
    }

    //生成验证码
    public function CreateVcode(){
        $Verify = new \Think\Verify();
        $Verify->entry();
    }

    //用户进行注册
    public function runRegis(){
        // var_dump($_POST);
        $register = D('user');
        // var_dump($register);
        // $res = $register->create();
        // var_dump($res);die;

        //创建表数据
        $time = time();
        if (!$register->create()) {
            //获取错误
            $info = $register->getError();
            $this->error($info);
        }
        // var_dump($register);die;
        // $register['datetime'] = $time;die;
         //执行添加
        $id = $register->add();
        if($id){
	        //插入自己是自己的粉丝 自己关注自己
        	$info = M('userinfo');
        	$follow = M('follow');
        	//先插入一条记录
        	$dataListf[] = array('follow'=>$id,'fans'=>$id);
        	$followinfo  =$follow->addAll($dataListf);
        	$dataListu[] = array('follow'=>1,'fans'=>1,'uid'=>$id);
        	$userinfo = $info->addAll($dataListu);
        	if($followinfo>0 && $userinfo>0){
	            //设置成功后跳转页面的地址，默认的返回页面是$_SERVER['HTTP_REFERER']
	        	$info = M('userinfo');
	        	$data['uid'] = $id;
	        	$res = $info->add($data);
	            $this->success('注册成功', U('Home/Login/index'),3);
        	}
        }else{
             //错误页面的默认跳转页面是返回前一页，通常不需要设置
             $this->error('注册失败');
        }

    }

    //Ajax验证用户名邮箱是否已经被使用
    public function checkAccount(){
        $user = M('user');
        $account = $_POST['account'];

        $res = $user->where('account = "'.$account.'"')->select();
        
        if (empty($res)){
            //如果为空,证明可用
            echo 0;
        }else{
            echo 0;
        }
    }
    
    //忘记密码
    public function forgetPwd(){
        $this->display();
    }

    //重置密码
    public function findPwd(){
        $findPwd = D('user');
        $account = I('post.account');
        // var_dump($account);
        if (!$findPwd->create()) {
            //获取错误
            $info = $findPwd->getError();
            $this->error($info);
        }
        //验证account是否已经注册
        $res = $findPwd->where('account = "'.$account.'"')->find();
        // var_dump($res);
        $account = $res['account'];
        if (empty($res)){
            //如果为空,证明可用
            $this->error('请输入正确的登录邮箱');
        }else{
            $this->success('请立即前往您的邮箱重置您的密码', U('Home/Login/index'),3);
            sendMail($account,'您的注册邮箱为'.$account.'请点击立即重置您的密码','<a href="http://weibo/Home/Login/resetPwd/account/'.$account.'">点击验证</a>');
            
        }
    }
    
        //邮箱验证跳转到重置密码页面
        public function resetPwd(){
            $this->display();
        }

        //通过邮箱验证对账户重置密码
        public function reset(){
            // var_dump($_POST);die;
            $reset = M('user');

            $account = $_POST['account'];
       
            $password['password'] = $_POST['password'];
            $res = $reset->where("account = '".$account."'")->save($password);

            echo $reset->_sql();
            var_dump($res);
         
            if($res){
                  //设置成功后跳转页面的地址，默认的返回页面是$_SERVER['HTTP_REFERER']
                 $this->success('修改成功', U('Home/Login/index'),3);
            }else{
                 //错误页面的默认跳转页面是返回前一页，通常不需要设置
                 $this->error('请输入新的密码');
            }
        }


}