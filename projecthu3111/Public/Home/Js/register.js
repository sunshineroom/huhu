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

		//注册邮箱丧失焦点事件
		$('input[name=account]').blur(function(){
			//检测用户名是否正确
			var reg = /^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/;
			//获取用户名邮箱
			var account = $(this).val();
			//检测 
			var res = reg.test(account);
			if (!res){
				$(this).next().html('邮箱格式不合法').css('color','red');
				//设置样式
				$(this).addClass('error');;
				CUSER = false;
				return false;
			};	
			var inp = $(this);
			//发送ajax确认用户名是否可用
			$.ajax({
				url:url,
				data:{account:account},
				type:'post',
				async:false,
				success:function(data){
					if (data == 0){
						inp.next().html('√').css('color','green');
						inp.attr('class','input');
					}else{
						inp.next().html('注册邮箱已经存在').css('color','red');
						inp.addClass('error');
						CUSER = false;
					}
				}

			})

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