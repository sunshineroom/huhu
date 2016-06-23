<?php 
namespace Admin\Controller;
use Think\Controller;
class ReportController extends CommonController {
	public function index(){
		$username = $_SESSION['username'];
		$this->assign('username',$username);

		$weibo = M('wb_weibo');
		$count = $weibo->where('report > 0')->count();
		// 实例化分页类 
		$num = 4;
		$Page = new \Think\Page($count,$num);
		//获取limit参数
		$limit = $Page->firstRow.','.$Page->listRows;
		$report = M('wb_userinfo')->join('wb_weibo on wb_userinfo.uid = wb_weibo.uid')->join('wb_picture on wb_weibo.id = wb_picture.wid','left')->where('wb_weibo.report > 0')->order('wb_weibo.report desc')->limit($limit)->select();
		// $report = M()->table('wb_weibo weibo,wb_userinfo userinfo')->field('weibo.id,weibo.content,weibo.time,weibo.report,userinfo.username,userinfo.uid')->where('weibo.uid = userinfo.uid AND weibo.report > 0')->order('weibo.report desc')->limit($limit)->select();
		// $report = $weibo->where('report > 0')->order('report desc')->limit($limit)->select();
		 // var_dump($report);
		 // 分页显示输出
		 $pages = $Page->show();
		 $this->assign('pages',$pages);
		 $this->assign('report',$report);
		 // 解析模板
		 $this->display();

	} 

	public function del(){
		$wid = I('get.wid'); 
		$uid = I('get.uid'); 
		$pic = M('wb_picture');
		$res = $pic->where('wid = "'.$wid.'"')->find();
		// var_dump($res);
		// die;
		if($res['max'] == null){
		    $weibo = M('wb_weibo');
		    $res = $weibo->where('id = "'.$wid.'"')->delete();
		    if($res){
		        //uid的发表微博数-1
		        $weibo_num = M('wb_userinfo')->where('uid = "'.$uid.'"')->getField('weibo');
		        $date_weibo['weibo']= $weibo_num - 1;
		        $rows = M('wb_userinfo')->where('uid = "'.$uid.'"')->save($date_weibo);
		        echo '1';
		    }else{
		        echo '0';
		    }
		}else{
		    unlink('./Public/'.$res['max']);
		    unlink('./Public/'.$res['medium']);
		    unlink('./Public/'.$res['mini']);
		    $weibo = M('wb_weibo');
		    $row = $weibo->where('id = "'.$wid.'"')->delete();
		    $row = $pic->where('wid = "'.$wid.'"')->delete();
		    if($res){
		        //uid的发表微博数-1
		        $weibo_num = M('wb_userinfo')->where('uid = "'.$uid.'"')->getField('weibo');
		        $date_weibo['weibo']= $weibo_num - 1;
		        $rows = M('wb_userinfo')->where('uid = "'.$uid.'"')->save($date_weibo);
		        echo '1';
		    }else{
		        echo '0';
		    }
		}
	}

	public function warning(){
		$datetime = I('post.datetime');
		switch ($datetime) {
			case '1':
				$data['datetime'] = time() + 3600*24*7;
				break;
			case '2':
				$data['datetime'] = time() + 3600*24*30;
				break;
			case '3':
				$data['datetime'] = time() + 3600*24*30*6;
				break;
			case '4':
				$data['datetime'] = time() + 3600*24*30*12;
				break;
			case '5':
				$data['lock'] = 1;
				break;
		}
		$data['warning'] = I('post.info');
		$user = M('wb_user');
		$res = $user->where('id ="'.I('post.id').'"')->save($data);
		if($res){
			echo true;
		}else{
			echo false;
		}
	}
}















 ?>