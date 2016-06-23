<?php 
namespace Admin\Controller;
use Think\Controller;
class AdvertController extends CommonController{
	public function index(){
		$advert = M('wb_advert');

		//获取每页显示的数量
       	$num = !empty($_GET['num']) ? $_GET['num'] :5;
       	// echo $num;
        // 查询满足要求的总记录数
        $count = $advert->count();
        // echo $advert->_sql();  
        // 实例化分页类 传入总记录数和每页显示的记录数
        $Page = new \Think\Page($count,$num);
    
        //获取limit参数
        $limit = $Page->firstRow.','.$Page->listRows;

         //执行查询
        $adverts = $advert->limit($limit)->select();
        // echo ($user->_sql());
        // var_dump($adverts);
        // 分页显示输出
        $pages = $Page->show();

        //为了让首页能显示最新的用户名
        $username = $_SESSION['username'];
        $this->assign('username',$username);
        // var_dump($_SESSION);
        // $this->assign
        //分配变量
        $this->assign('adverts',$adverts);
        $this->assign('pages',$pages);
        //解析模板

        $this->display();   
	}

		public function showurl(){
        $id = $_POST['id'];
        // echo $id;die;
        $advert = M('wb_advert');
        $show = $advert->where('id='.$id)->field('status')->select();
        // echo $advert->_sql();
        $show = $show[0]['status'];
        // echo $show;
        $noshow = (($show==1)? 0 : 1);
        $advert->status = $noshow;
        //更改数据库
        $advert->where('id='.$id)->save();
        echo $show;
    }
	
	
	//广告添加页面
	public function add(){
		$username = $_SESSION['username'];
		$this->assign('username',$username);
		$this->display();
	
	}
	//执行添加页面
	public function insert(){
		$username = $_SESSION['username'];
		$this->assign('username',$username);
		
		$upload=new \Think\Upload();
		$upload->maxSize=1024000000;
		$upload->exts=array('jpg','gif','png','jpeg');
		$upload->rootPath='Public';
		$upload->savePath='/uploads/Advert/';
		$upload->autoSub  = false;
		$info=$upload->upload();
		if(!$info) {
			$this->error($upload->getError());
		}else{
			foreach($info as $file){
			$name=$file['savename'];
		}}
		
		$file=$name;
		// var_dump($file);exit;
		//放入数据库
		$reg=M('wb_advert');
		$data=$_POST;
		$data['pic']=$file;
		// dump($data);exit;
       
			//var_dump($name);
            if($reg -> add($data)){
				//@unlink("Public/uploads/{$name}");
			   $this -> success("添加广告成功！",U("Advert/index"));            
			   //U()方法根据控制器/方法生成url
            }else{
				//@unlink("Public/uploads/k_{$name}");
				@unlink("__PUBLIC__/Uploads/Advert/".$file);
                $this -> error("添加广告失败!");
            }
	}
	// 广告修改页面
	public function save(){
		$username = $_SESSION['username'];
    	$this->assign('username',$username);
    	$id =I('get.id');
    	//创建表对象
    	$advert  = M('wb_advert');

    	$info = $advert->find($id);
    	$this->assign('info',$info);
    	// var_dump($info);
    	$this->display();
	}
	public function update(){
		// var_dump($_POST);
		$advert = M('wb_advert');
		$upload=new \Think\Upload();
		$upload->maxSize=1024000000;
		$upload->exts=array('jpg','gif','png','jpeg');
		$upload->rootPath='Public';
		$upload->savePath='/uploads/Advert/';
		$upload->autoSub  = false;
		$info=$upload->upload();
		if(!$info) {
			$this->error($upload->getError());
		}else{
			foreach($info as $file){
			$name=$file['savename'];
		}}
		
		$file=$name;
		// var_dump($file);exit;
		//放入数据库
		// $reg=M('wb_advert');
		$data=$_POST;
		$data['pic']=$file;
		// var_dump($data) ;die;


		$res = $advert->create();
		//创建数据
		$res = $advert->save($data);
		// echo $advert->_sql();
		if($res){
			$this->success('更新广告成功',U('Admin/Advert/index'));
		}else{
            $this->error('更新广告失败');

		}
	}

	public function ajaxdel(){
		// var_dump($_GET);
		//创建表对象
		$advert = M('wb_advert');
		//获取id
		$id = $_GET['id'];
		//执行删除
		$res = $advert->delete($id);
		// 向ajax返回数据
		if($res){
		    echo 1;
		}else{
		    echo 0;
		}
	}
}


 ?>