<?php
namespace Admin\Controller;
use Think\Controller;
class HomeuserController extends CommonController {
    public function index(){
    	$user = M('wb_user');
               //获取每页显示的数量
               $num = !empty($_GET['num']) ? $_GET['num'] :5;
               // echo $num;
                //获取关键字
                if(!empty($_GET['keyword'])){
                    //有关键字
                    $where = " account like '%".$_GET['keyword']."%'";
                }else{
                    $where = '';
                }


                // 查询满足要求的总记录数
                $count = $user->where($where)->count();
                // echo $user->_sql();  
                // 实例化分页类 传入总记录数和每页显示的记录数
                $Page = new \Think\Page($count,$num);
            
                //获取limit参数
                $limit = $Page->firstRow.','.$Page->listRows;

                 //执行查询
                // $users = $user->join('userinfo on user.id = userinfo.uid')->where($where)->limit($limit)->select();
                $users = $user->where($where)->limit($limit)->select();
                // echo ($user->_sql());
                // var_dump($users);
                // 分页显示输出
                $pages = $Page->show();

                //为了让首页能显示最新的用户名
                $username = $_SESSION['username'];
                $this->assign('username',$username);
                // var_dump($_SESSION);
                // $this->assign
                //分配变量
                $this->assign('users',$users);
                $this->assign('pages',$pages);
                //解析模板

                $this->display();   
    }
    	
   // 前台用户详细信息查看
    public function find(){
        $uid = $_GET['uid'];
        // echo $uid;
        $user = M('wb_userinfo');
        $info  = $user->where(' uid = "'.$uid .'"')->find();
        // var_dump($info);
        // 分配变量
        $this->assign('info',$info);
        $username = $_SESSION['username'];
        $this->assign('username',$username);
        //解析模板
    	$this->display();
    }
    
    //
}