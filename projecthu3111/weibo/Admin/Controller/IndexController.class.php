<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends CommonController {
    public function index(){

    	$username = $_SESSION['username'];
    	$this->assign('username',$username);


        $data = M('wb_userinfo');
        // var_dump($data);
        $all = $data->count();


        $man = $data->where('sex = 1')->count();
        $woman = $all - $man;
        $user = M('wb_user');
        $total  = $user->count();
        $weizhi = $total - $count;

        $zaixian = $user->where(' status = 0')->count();     
        
        $this->assign('man',$man);
        $this->assign('zaixian',$zaixian);
        $this->assign('woman',$woman);
        $this->assign('weizhi',$weizhi);
    	$this->display();
    	
    }
    public function loginOut(){
    	session(null);
    	if(empty($_SESSION)){
	    	$this->success("退出成功",U('Admin/Login/index'),3);
    	}
    }
}