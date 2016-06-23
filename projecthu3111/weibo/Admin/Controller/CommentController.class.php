<?php
namespace Admin\Controller;
use Think\Controller;
class CommentController extends CommonController {
	public function index(){
			$comment = M('wb_comment');
		    //查看sql语句
		   //获取每页显示的数量
		   $num = !empty($_GET['num']) ? $_GET['num'] :5;
		   // echo $num;
		    //获取关键字
		    if(!empty($_GET['keyword'])){
		        //有关键字
		        $where = " AND wb.content like '%".$_GET['keyword']."%'";
		    }else{
		        $where = '';
		    }


		    // 查询满足要求的总记录数
		    $count = $comment->where($where)->count();
		    // 实例化分页类 传入总记录数和每页显示的记录数
		    $Page = new \Think\Page($count,$num);
		
		    //获取limit参数
		    $limit = $Page->firstRow.','.$Page->listRows;

		     //执行查询
		   
		    $comments = $comment->field('ct.id,ct.content contents,wb.content,info.username,ct.time')
		    			->table(array('wb_weibo'=>'wb','wb_comment'=>'ct','wb_userinfo'=>'info'))
		    			->where('wb.id = ct.wid AND ct.uid = info.uid'.$where)->limit($limit)->select();
		    // echo ($comment->_sql());
		    // var_dump($comments);
		    // 分页显示输出
		    $pages = $Page->show();

		    $username = $_SESSION['username'];
		    $this->assign('username',$username);
		    //分配变量
		    $this->assign('comments',$comments);
		    $this->assign('pages',$pages);
			//解析模板
		$this->display();
	}

	// ajax删除评论
	public function ajaxdel(){
		// var_dump($_GET);
        //创建表对象
        $comment = M('wb_comment');
        //获取id
        $id = $_GET['id'];
        //执行删除
	    //删除成功,将weibo表中的评论数量减1;
		$wid = $comment->field('wid')->where(' id = "'.$id.'"')->find();
		// var_dump($wid);die;
	    $weibo = M('wb_weibo');
	    $wid = $wid['wid'];
	    $wb = $weibo->field('comment')->where(' id = "'.$wid.'"')->find();
	    $wb = $wb['comment'];
	    // var_dump($wb);die;
	    $wb = $wb - '1';
	    $weibo->comment = $wb;
	    $updatacomment = $weibo->where(' id = "'.$wid.'"')->save();
	    // echo $weibo->_sql();die;
        $res = $comment->delete($id);


        // 向ajax返回数据
        if($res){
            echo 1;
        }else{
            echo 0;
        }
	}
}