$(function () {

	//声明全局变量
	var CUSER = true;
		//绑定表单事件
		$('form').submit(function(){
		CUSER   = true;
		//丧失焦点事件
		$('input').trigger('blur');
		//检测是否正确
		if (!CUSER){
			return false;
		}
		//阻止默认行为
			return true;
		})

		//绑定获取焦点事件,显示提示信息
		$('input').focus(function(){
			// alert('2');
			//获取属性
			var str  = $(this).attr('readmin');
			//设置文本
			$(this).next().html(str).css({color:'#aaa',fontSize:'17px'});
			//设置样式
			$(this).attr('class','input');
		})



		//密码格式丧失焦点事件
		$('input[name=password]').blur(function(){
			// alert('2');
			var pass = $(this).val();
			var reg = /^\w{6,18}$/;
			if (!reg.test(pass)) {
				$(this).next().html('密码格式不正确').css('color','red');
				//设置样式
				$(this).addClass('error');
				CUSER = false;
				return false;
			}else{
				$(this).next().html('√').css('color','green');
				//设置样式
				$(this).attr('class','input');
			}
		})

		//确认密码丧失焦点事件
		$('input[name=pwded]').blur(function(){
			var pass = $(this).val();
			var password = $('input[name=password]').val();

			if(pass == password){
				$(this).next().html('√').css('color','green');
				//设置样式
				$(this).attr('class','input');
			}else{
				$(this).next().html('两次密码不一致').css('color','red');
				//设置样式
				$(this).addClass('error');
				CUSER = false;
			}
		})

});