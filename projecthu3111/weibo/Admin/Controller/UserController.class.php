<?php
namespace Admin\Controller;
use Think\Controller;
class UserController extends CommonController {
    public function index(){

    	    // echo '后台用户列表';
    	    //创建对象
    	    $user = M('wb_adminuser');
    	    // var_dump($user);
    	
    	    //查看sql语句
    	    // echo $user->getLastSql();

    	   //获取每页显示的数量
    	   $num = !empty($_GET['num']) ? $_GET['num'] :5;
    	   // echo $num;

    	    //获取关键字
    	    if(!empty($_GET['keyword'])){
    	        //有关键字
    	        $where = " AND username like '%".$_GET['keyword']."%'";
    	    }else{
    	        $where = '';
    	    }


    	    // 查询满足要求的总记录数
    	    $count = $user->where($where)->count();
    	    // echo $user->_sql();	
    	    // echo $count;
    	    // 实例化分页类 传入总记录数和每页显示的记录数
    	    $Page = new \Think\Page($count,$num);
    	
    	    //获取limit参数
    	    $limit = $Page->firstRow.','.$Page->listRows;

    	     //执行查询
    	    // $users = $user->join('userinfo on user.id = userinfo.uid')->where($where)->limit($limit)->select();
    	    $users = $user->table('wb_adminuser,think_auth_group_access')->where('wb_adminuser.id = think_auth_group_access.uid'.$where)->limit($limit)->select();
    	    // echo ($user->_sql());
    	    // var_dump($users);
    	    // 分页显示输出
    	    $pages = $Page->show();

    	    //为了让首页能显示最新的用户名
    	    $sid = $_SESSION['uid'] - 1 ;
    	 
    	    $_SESSION['username'] = $users[$sid]['username'];
    	    $username = $_SESSION['username'];
    	    $this->assign('username',$username);
    	    // $this->assign
    	    //分配变量
    	    $this->assign('users',$users);
    	    $this->assign('pages',$pages);
    		//解析模板

    		$this->display();  	
    }

    //显示后台用户添加
    public function add(){
    	// echo '用户添加';
    	//解析模板
    	$username = $_SESSION['username'];
    	$this->assign('username',$username);
    	$this->display();
    }

    //处理用户的数据添加
    public function insert(){

        //创建表对象
        $user = M('wb_adminuser');
        // var_dump($user);
        //创建数据
        $user->create();
        //添加数据
        $id = $user->add();
        // var_dump($id);
        //创建附表
        $group = M('think_auth_group_access');
        // var_dump($group);die;

        //处理uid
        $_POST['uid'] = $id;
        $a['uid'] =  $_POST['uid'];
        $a['group_id'] =  $_POST['group_id'];

    	// var_dump($a);die;
        //创建附表数据
        $group->create();
        //执行添加
        $res = $group->add($a);
       	// echo ($group->_sql());die;
        // var_dump($res);
       if($res){
             //设置成功后跳转页面的地址，默认的返回页面是$_SERVER['HTTP_REFERER']
            $this->success('新增成功', U('Admin/User/index'),3);
       }else{
            //错误页面的默认跳转页面是返回前一页，通常不需要设置
            $this->error('新增失败');
       }
    }

    //用户的修改
    public function save(){
    	$username = $_SESSION['username'];
    	$this->assign('username',$username);
        $id = I('get.id');
        //创建表对象
        $user = M('wb_adminuser');
        //查询当前用户的数据
        $info = $user->find($id);
        // var_dump($info);die;
        

        //分配变量
        $this->assign('info',$info);
        //解析模板
        $this->display();
    }

    //执行修改
    public function update(){
        // var_dump($_POST);
         //创建数据表对象
        $user = M('wb_adminuser');  
        //创建数据
        $res = $user->create();
        //执行修改
       $res =  $user->save();

       $group = M('think_auth_group_access');
       // $res2 = $group->create();
       $data['group_id'] = $_POST['group_id']; 
       $res2 = $group->where('uid = '.$_POST['id'])->save($data);
       // echo ($user->_sql());
       // echo ($group->_sql());die;

       // var_dump($res);
        //执行添加
       if($res || $res2){
             //设置成功后跳转页面的地址，默认的返回页面是$_SERVER['HTTP_REFERER']
            $this->success('更新成功', U('Admin/User/index'),3);
       }else{
            //错误页面的默认跳转页面是返回前一页，通常不需要设置
            $this->error('更新失败');
       }
    }

    //处理用户的删除
        public function ajaxdel(){
        // var_dump($_GET);
        //创建表对象
        $user = M('wb_adminuser');
        //获取id
        $id = $_GET['id'];
        //执行删除
        $res = $user->delete($id);

        $group = M('think_auth_group_access');
        $uid =  $_GET['id'];
        $res = $group->where('uid = '.$uid)->delete();
        echo $group->_sql;


        // 向ajax返回数据
        if($res){
            echo 1;
        }else{
            echo 0;
        }
    }

    //用户修改自身
    public function settingself(){
	    // var_dump($_GET);
	    $id = $_SESSION['uid'];
	    // var_dump($_SESSION);
	    //创建表对象
	    $user = M('wb_adminuser');
	    //查询当前用户的数据
	    $info = $user->find($id);
	    // var_dump($info);die;
	    //分配变量
	    $this->assign('info',$info);
		$_SESSION['username'] = $info['username'];
		$username = $_SESSION['username'];
		$this->assign('username',$username);
	    //解析模板
	    $this->display();
    }
    //执行用户修改自身
    public function setting(){
    	 // var_dump($_POST);
    	  //创建数据表对象
    	 $user = M('wb_adminuser');  
    	 //创建数据
    	 $res = $user->create();
    	 //执行修改
    	 $res =  $user->save();
    	 //执行添加
    	 if($res){
    	      //设置成功后跳转页面的地址，默认的返回页面是$_SERVER['HTTP_REFERER']
    	     $this->success('更新成功', U('Admin/User/index'),3);
    	 }else{
    	     //错误页面的默认跳转页面是返回前一页，通常不需要设置
    	     $this->error('更新失败');
    	 }
    }
}