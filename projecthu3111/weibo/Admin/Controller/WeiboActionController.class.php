<?php
namespace Admin\Controller;
use Think\Controller;
class WeiboActionController extends CommonController {
    public function index(){
        $weibo = M('wb_weibo');
            // var_dump($weibo);die;
           //获取每页显示的数量
           $num = !empty($_GET['num']) ? $_GET['num'] :5;
           // echo $num;die;

            //获取关键字
            if(!empty($_GET['keyword'])){
                //有关键字
                $where = " AND username like '%".$_GET['keyword']."%'";
            }else{
                $where = '';
            }


            // 查询满足要求的总记录数
            $count = $weibo->where($where)->count();
            // echo $weibo->_sql();  
            // echo $count;die;
            // 实例化分页类 传入总记录数和每页显示的记录数
            $Page = new \Think\Page($count,$num);
        
            //获取limit参数
            $limit = $Page->firstRow.','.$Page->listRows;
            $userinfo = M('wb_userinfo');
             //执行查询
            // $weibos = $weibo->table('wb_userinfo,wb_weibo')->where('wb_userinfo.uid = wb_weibo.uid '.$where)->limit($limit)->select();
            $userinfos = $userinfo->join('wb_weibo ON wb_userinfo.uid = wb_weibo.uid')->join('wb_picture ON wb_weibo.id = wb_picture.wid','left')->where(' wb_weibo.isturn = 0'.$where)->limit($limit)->order('wb_weibo.time desc')->select();
            // $userinfo = $user->join('userinfo on user.id = userinfo.uid')->where($where)->limit($limit)->select();
            // echo ($weibo->_sql());
            // var_dump($userinfos);
            // 分页显示输出
            $pages = $Page->show();
            $username = $_SESSION['username'];
            $this->assign('username',$username);

            //分配变量
            $this->assign('userinfos',$userinfos);
            $this->assign('pages',$pages);
            //解析模板

            $this->display();   
    	
    }

    //被举报的微博删除
    public function ajaxdel(){
        // var_dump($_GET);
        //创建表对象
        $user = M('wb_weibo');
        //获取id
        $id = $_GET['id'];
        //执行删除
        $res = $user->delete($id);

        $picture = M('wb_picture');
        $wid =  $id;

        $a = $picture->where('wid = '.$wid)->delete();


        // 向ajax返回数据
        if($res){
            echo 1;
        }else{
            echo 0;
        }
    }
}


