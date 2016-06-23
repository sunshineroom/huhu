<?php 
namespace Home\Model;
use Think\Model;

//自定义的数据库操作类 继承Think里的model
class UserModel extends Model{
	//自动验证 
	protected $_validate = array(
		 //默认情况下用正则进行验证
		// array('verify','require','验证码必须！'),
		//验证码是否正确
		array('verify','check_verify','验证码不正确',0,'function',1)

		// 验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间]
		// array('title','require','商品名称必须填写',0,'',1),
		// // 在新增的时候验证name字段是否 唯一
		// array('title','','商品名称已经存在',0,'unique',1),
		// //验证价格
		// array('price','number','商品价格必须为数字',0,'',1),
		// //商品数量
		// array('num','number','商品数量必须为数字',0,'',1),
	);

	protected $_auto = array (
        array('registime', 'time', 1, 'function'), // 对regdate字段在新增的时候写入当前时间戳
        // array('regip', 'get_client_ip', 1, 'function'), // 对regip字段在新增的时候写入当前注册ip地址
    );
}


 ?>