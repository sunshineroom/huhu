<?php
namespace Admin\Controller;
use Think\Controller;
class VipController extends CommonController {
    public function index(){
        $vip = M('wb_vip');

        $num = 1;
        $count = $vip->join('wb_userinfo on wb_userinfo.uid = wb_vip.uid')->count();
        // 实例化分页类 传入总记录数和每页显示的记录数
        $Page = new \Think\Page($count,$num);
        //获取limit参数
        $limit = $Page->firstRow.','.$Page->listRows;
         //执行查询
        $userlist = $vip->join('wb_userinfo on wb_userinfo.uid = wb_vip.uid')->limit($limit)->select();
        $pages = $Page->show();

        $this->assign('userlist',$userlist);
        $this->assign('count',$count);
        $username = $_SESSION['username'];
        $this->assign('pages',$pages);
        $this->assign('username',$username);
        $this->display();
    }
}