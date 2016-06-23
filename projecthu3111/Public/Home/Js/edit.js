$(function () {
	//修改资料选项卡
	$('#sel-edit li').click( function () {
		var index = $(this).index();
		// console.log(index);
		$(this).addClass('edit-cur').siblings().removeClass('edit-cur');
		$('.form').hide().eq(index).show();
	} );


	var value = $("input[name=nickname]").val();
	

	$("input[name=nickname]").blur(function(){
		var username = $(this).val();
		var inp = $(this);
		// alert(uid);
		if(username != value){
			$.post(AJAX,{username:username},function(data){
					if(data){
						inp.next().html(' 昵称已存在').css('color','red');
					}else{
						inp.next().html(' √').css('color','green');
					}
			},'json');
		}else{
				inp.next().html('');
		}
 });


	//城市联动
	var province = '';
	$.each(city, function (i, k) {
		province += '<option value="' + k.name + '" index="' + i + '">' + k.name + '</option>';
	});
	$('select[name=province]').append(province).change(function () {
		var option = '';
		if ($(this).val() == '') {
			option += '<option value="">请选择</option>';
		} else {
			var index = $(':selected', this).attr('index');
			var data = city[index].child;
			for (var i = 0; i < data.length; i++) {
				option += '<option value="' + data[i] + '">' + data[i] + '</option>';
			}
		}
		
		$('select[name=city]').html(option);
	});

	//所在地默认选项
	address = address.split(',');
	$('select[name=province]').val(address[0]);
	$.each(city, function (i, k) {
		if (k.name == address[0]) {
			var str = '';
			for (var j in k.child) {
				str += '<option value="' + k.child[j] + '" ';
				if (k.child[j] == address[1]) {
					str += 'selected="selected"';
				}
				str += '>' + k.child[j] + '</option>';
			}
			$('select[name=city]').html(str);
		}
	});

	//星座默认选项
	$('select[name=night]').val(constellation);

	//头像上传 Uploadify 插件
	$('#face').uploadify({
		swf : PUBLIC + '/Home/Uploadify/uploadify.swf',	//引入Uploadify核心Flash文件
		uploader : uploadUrl,	//PHP处理脚本地址
		width : 120,	//上传按钮宽度
		height : 30,	//上传按钮高度
		buttonImage : PUBLIC + '/Home/Uploadify/browse-btn.png',	//上传按钮背景图地址
		fileTypeDesc : 'Image File',	//选择文件提示文字
		fileTypeExts : '*.jpeg; *.jpg; *.png; *.gif',	//允许选择的文件类型
		// formData : {'session_id' : sid},
		//上传成功后的回调函数
		onUploadSuccess : function (file, data, response) {
			eval('var data = ' + data);
			if (data.status) {
				$('#face-img').attr('src',PUBLIC+data.path.max);
				$('input[name=face180]').val(data.path.max);
				$('input[name=face80]').val(data.path.medium);
				$('input[name=face50]').val(data.path.mini);
			} else {
				alert(data.msg);
			}
		}
	});

	$('input[name=old]').blur(function(){
		var password = $(this).val();
		var inp = $(this);
		// alert(password);
		$.post(AJAXPWD,{password:password},function(data){
			if(data == '1'){
				inp.next().html('密码错误').css('color','red');
			}else{
				inp.next().html('√').css('color','green');
			}
		})
	});

	var newPwd = '';
	$('input[name=new]').blur(function(){
		newPwd = $(this).val();
	});
	$('input[name=newed]').blur(function(){
		var rePwd = $(this).val();
		if(rePwd != newPwd){
			$(this).next().html('两次密码不一致').css('color','red');
		}else{
			$(this).next().html('√').css('color','green');	
		}
	});



});