<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller {

	public function index(){
		$value1 = cookie('username');
        $value2 = cookie('password');
        $this->assign('password',$value2);
        $this->assign('username',$value1);

		//解析模板
		$this->display();
	}

	public function login(){
		// var_dump($_POST);

		$user = M('wb_adminuser');

		//接受数据
		$username = I('post.username');
		$password = I('post.password');

		//查询
		$info = $user->where('username = "'.$username.'" and password = "'.$password.'"')->find();
		// echo $user->_sql();
		// var_dump($info);
		//检测用户是否存在
		if(!empty($info)){
			if ($_POST['auto']) {
               cookie('username',$username,600);
               cookie('password',$password,600);
               $value1 = cookie('username');
               $value2 = cookie('password');
               $this->assign('password',$value1);
               $this->assign('username',$value2);
            }
			session_start();
			// var_dump($_SESSION);
			$_SESSION['uid'] = $info['id'];
			session('username',$info['username']);
			$this->success('登录成功',U('Admin/Index/index'),3);
		}else{
			$this->error('登录失败','',3);
		}
	}

}