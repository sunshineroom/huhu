<?php 
namespace Admin\Controller;
use Think\Controller;
class ThemeController extends CommonController{
	public function index(){
    //解析模板
    $this->display();   
	}
	
	public function uploadPic(){
	    // 实例化上传类
	    $name = I('post.sid');
	    $upload = new \Think\Upload();
	    $upload->maxSize = 10485760;
	    // 设置文件上传类型
	    $upload->exts = array('jpg','gif','png','jpeg');
	    // 设置保存路径
	    $upload->rootPath = './Public';
	    $upload->savePath = '/Uploads/Theme/'; 
	    $upload->autoSub  = false; 
	    $info = $upload->upload();
	    if(!$info){
	        $msg = $upload->getError();
	        echo $msg;
	    }else{
	        $path = $upload->rootPath.$info['Filedata']['savepath'].$info['Filedata']['savename'];
	        $path_l = $upload->rootPath.$info['Filedata']['savepath'];
	        $path_r = $info['Filedata']['savename'];
	        // 生成缩略图
          $img = new \Think\Image(); 
          $img->open($path);
        	$res = $img->thumb(125,125)->save($path_l.$name.'.jpg');
        	$path_copy = './Public/Home/Theme/'.$name.'/Images/body_bg.jpg';
        	copy($path,$path_copy);
          unlink($path); //删除原图
          echo '修改成功';
	    }
	}
}


 ?>