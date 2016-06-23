<?php
namespace Admin\Controller;
use Think\Controller;
class LinController extends CommonController {
    public function index(){
        $num = 4;
        $link = M('wb_gonggao');
        $count = $link->count();
        // 实例化分页类 传入总记录数和每页显示的记录数
        $Page = new \Think\Page($count,$num);
        //获取limit参数
        $limit = $Page->firstRow.','.$Page->listRows;
         //执行查询
        $linkinfo = $link->limit($limit)->select();
        $pages = $Page->show();
        $this->assign('gonginfo',$linkinfo);
        $this->assign('pages',$pages);
        $username = $_SESSION['username'];
        $this->assign('username',$username);
        $this->display();
    }

    public function showurl(){
        $id = $_POST['id'];
        $link = M('wb_gonggao');
        $show = $link->where('id='.$id)->field('gongshow')->select();
        // echo $link->_sql();
        $show = $show[0]['gongshow'];
        $noshow = (($show==1)? 0 : 1);
        $link->gongshow = $noshow;
        //更改数据库
        $link->where('id='.$id)->save();
        echo $show;
    }
    public function newsrcurl(){
        $link = M('wb_gonggao');
        $link->create();
        $res = $link->save();
        // echo $link->_sql();
        if($res>0){
            echo 1;
        }
    }
    public function newcontenturl(){
        $link = M('wb_gonggao');
        $link->create();
        $res = $link->save();
        if($res>0){
            echo 1;
        }
    }
    //新增友情列表
    public function newlinkurl(){
        $link = M('wb_gonggao');
        $link->create();
        $res = $link->add();
        if($res>0){
            echo $res;
        }
    }
    //删除友情列表
    public function dellinkurl(){
        $link = M('wb_gonggao');
        $id = $_POST['id'];
        $res = $link->where('id='.$id)->delete();
        if($res>0){
            echo 1;
        }
    }
    



   
}