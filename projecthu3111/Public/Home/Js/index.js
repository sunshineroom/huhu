/**
 * 首页
 * @author Carmen
 */
$(function () {

	/**
	 * 上传微博图片
	 */
	$('#picture').uploadify({
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
			// console.log = data;
			if (data.status) {
				$('input[name=max]').val(data.path.max);
				$('input[name=medium]').val(data.path.medium);
				$('input[name=mini]').val(data.path.mini);
				$('#upload_img').fadeOut().next().fadeIn().find('img').attr('src', PUBLIC + data.path.medium);
			} else {
				alert(data.msg);
			}
		}
	});
	
	/**
	 * 发布转入框效果
	 */
	$('.send_write textarea').focus(function () {
		//获取焦点时改变边框背景
		$('.ta_right').css('backgroundPosition', '0 -50px');
		//转入文字时
		$(this).css('borderColor', '#FFB941').keyup(function () {
			var content = $(this).val();
			//调用check函数取得当前字数
			var lengths = check(content);
			if (lengths[0] > 0) {//当前有输入内容时改变发布按钮背景
				$('.send_btn').css('backgroundPosition', '-133px -50px');
			} else {//内容为空时发布按钮背景归位
				$('.send_btn').css('backgroundPosition', '-50px -50px');
			};
			//最大允许输入140字个
			if (lengths[0] >= 140) {
				$(this).val(content.substring(0, Math.ceil(lengths[1])));
			}
			var num = 140 - Math.ceil(lengths[0]);
			var msg = num < 0 ? 0 : num;
			//当前字数同步到显示提示
			$('#send_num').html(msg);
		});
	//失去焦点时边框背景归位
	}).blur(function () {
		$(this).css('borderColor', '#CCCCCC');
		$('.ta_right').css('backgroundPosition', '0 -69px');
	});
	//内容提交时处理
	$('form[name=weibo]').submit(function () {
		var cons = $('textarea', this);
		if (cons.val() == '') {//内容为空时闪烁输入框
			var timeOut = 0;
			var glint = setInterval(function () {
				if (timeOut % 2 == 0) {
					cons.css('background','#FFA0C2');
				} else {
					cons.css('background','#fff');
				}
				timeOut++;
				if (timeOut > 7) {
					clearInterval(glint);
					cons.focus();
				}
			}, 100);
			return false;
		}
	});
	//显示图片上传框
	$('.icon-picture').click(function () {
		$('#phiz').hide();
		$('#upload_img').show();
	});



	/**
	 * 图片点击放大处理
	 */
	$('.mini_img').click(function () {
		$(this).hide().next().show();
	});
	$('.img_info img').click(function () {
		$(this).parents('.img_tool').hide().prev().show();
	});
	$('.packup').click(function () {
		$(this).parent().parent().parent().hide().prev().show();
	});
	$('.turn_mini_img').click(function () {
		$(this).hide().next().show();
	});
	$('.turn_img_info img').click(function () {
		$(this).parents('.turn_img_tool').hide().prev().show();
	});





	/**
	 * 转发框处理
	 */
	 $('.turn').click(function () {
	 	//获取原微内容并添加到转发框
	 	var orgObj = $(this).parents('.wb_tool').prev().prev();
	 	console.log(orgObj);
	 	var author = $.trim(orgObj.find('.author').html());
	 	var content = orgObj.find('.content p').html();
	 	var tid = $(this).attr('tid') ? $(this).attr('tid') : 0;
	 	var cons = '';

	 	//多重转发时，转发框内容处理
	 	if (tid) {
	 		author = orgObj.find('.author a').html();
	 		cons = replace_weibo(' // @' + author + ' : ' + content);
	 		author = $.trim(orgObj.find('.turn_name').html());
	 		content = orgObj.find('.turn_cons p').html();
	 	}

	 	$('.turn_main p').html(author + ' : ' + content);
	 	$('.turn-cname').html(author);
	 	$('form[name=turn] textarea').val(cons);

	 	//提取原微博ID
	 	$('form[name=turn] input[name=id]').val($(this).attr('id'));
	 	$('form[name=turn] input[name=tid]').val(tid);

	 	//隐藏表情框
	 	$('#phiz').hide();
	 	//点击转发创建透明背景层
	 	createBg('opacity_bg');
	 	//定位转发框居中
	 	var turnLeft = ($(window).width() - $('#turn').width()) / 2;
	 	var turnTop = $(document).scrollTop() + ($(window).height() - $('#turn').height()) / 2;
	 	$('#turn').css({
	 		'left' : turnLeft,
	 		'top' : turnTop
	 	}).fadeIn().find('textarea').focus(function () {
	 		$(this).css('borderColor', '#FF9B00').keyup(function () {
				var content = $(this).val();
				var lengths = check(content);  //调用check函数取得当前字数
				//最大允许输入140个字
				if (lengths[0] >= 140) {
					$(this).val(content.substring(0, Math.ceil(lengths[1])));
				}
				var num = 140 - Math.ceil(lengths[0]);
				var msg = num < 0 ? 0 : num;
				//当前字数同步到显示提示
				$('#turn_num').html(msg);
			});
	 	}).focus().blur(function () {
	 		$(this).css('borderColor', '#CCCCCC');	//失去焦点时还原边框颜色
	 	});
	 });
	drag($('#turn'), $('.turn_text'));  //拖拽转发框




	/**
	 * 收藏微博
	 */
	$('.keep').click(function () {
		var wid = $(this).find('a').attr('wid');
		var keepUp = $(this).find('.keep-up').show();
		var msg = '';

		$.post(keepUrl, {wid : wid}, function (data) {
			if (data == 1) {
				msg = '收藏成功';
			}

			if (data == -1) {
				msg = '已收藏';
			}

			if (data == 0) {
				msg = '收藏失败';
			}

			keepUp.html(msg).fadeIn();
			setTimeout(function () {
				keepUp.fadeOut();
			}, 3000);

		}, 'json');
		
	});






	/**
	 * 评论框处理
	 */
	//点击评论时异步提取数据
	$('.comment').toggle(function(){

		//异步加载状态DIV
		var commentLoad = $(this).parents('.wb_tool').next();
		// alert(111);
		var commentList = commentLoad.next();

		//提取当前评论按钮对应微博的ID号
		var wid = $(this).attr('wid');
		//异步提取评论内容
		$.ajax({
			url : getComment,
			data : {wid : wid},
			dataType : 'html',
			type : 'get',
			beforeSend : function () {
				commentLoad.show();
			},
			success : function (data) {
				if (data != 'false') {
					commentList.append(data);	
					p = 1;
				}
			},
			complete : function () {
				commentLoad.hide();
				commentList.show().find('textarea').val('').focus();
			}
		});
	}, function () {
		$(this).parents('.wb_tool').next().next().hide().find('dl').remove();
		$(this).parents('.wb_tool').next().next().hide().find('.comment-page').remove();
		$('#phiz').hide();
	});
	//评论输入框获取焦点时改变边框颜色
	$('.comment_list textarea').focus(function () {
		$(this).css('borderColor', '#FF9B00');
	}).blur(function () {
		$(this).css('borderColor', '#CCCCCC');
	}).keyup(function () {
		var content = $(this).val();
		var lengths = check(content);  //调用check函数取得当前字数
		//最大允许输入140个字
		if (lengths[0] >= 140) {
			$(this).val(content.substring(0, Math.ceil(lengths[1])));
		}
	});
	//回复
	$('.reply a').live('click', function () {
		var reply = $(this).parent().siblings('a').html();
		$(this).parents('.comment_list').find('textarea').val('回复@' + reply + ' ：').focus();
		return false;
	});
	//提交评论
	$('.comment_btn').click(function () {
		var commentList = $(this).parents('.comment_list');
		var _textarea = commentList.find('textarea');
		var content = _textarea.val();

		//评论内容为空时不作处理
		if (content == '') {
			_textarea.focus();
			return false;
		}

		//提取评论数据
		var cons = {
			content : content,
			wid : $(this).attr('wid'),
			uid : $(this).attr('uid'),
			isturn : $(this).prev().find('input:checked').val() ? 1 : 0
		};

		$.post(commentUrl, cons, function (data) {
			if (data != 'false') {
				if (cons.isturn) {
					window.location.reload();
				} else {
					_textarea.val('');
					commentList.find('ul').after(data);
				}
			} else {
				alert('评论失败，请重试...');
			}
		}, 'html');
	});

 // 评论异步分类处理
	
	$('.comment-page a').live('click', function () {
		var commentList = $(this).parents('.comment_list');
		var commentLoad = commentList.prev();
		var wid = commentLoad.prev().find('.comment').attr('wid');
		// alert(p);
		p = parseInt(p);
		var page = $(this).attr('class');
		if(page == 'prev'){
			p = p - 1;
		}else if(page == 'next'){
			p = p + 1;
		}else{
			p = $(this).html();
		}
		// alert(p);
		//异步提取评论内容
		$.ajax({
			url : getComment,
			data : {wid : wid, p : p},
			dataType : 'html',
			type : 'get',
			beforeSend : function () {
				commentList.hide().find('dl').remove();
				commentList.hide().find('.comment-page').remove();
				commentLoad.show();
			},
			success : function (data) {
				if (data != 'false') {
					commentList.append(data);
				}
			},
			complete : function () {
				commentLoad.hide();
				commentList.show().find('textarea').val('').focus();
			}
		});
		return false;
	});

	/**
	 * 删除微博
	 */
	$('.wb_cons .screen').hover(function(){
		$(this).find('.screen_list').show();
	},function(){
		$(this).find('.screen_list').hide();
	})

	$('.wb_cons .screen_list .del').click(function(){
		var wid = $(this).find('a').attr('wid');
		var isDel = confirm('确认要删除该微博?');
		var obj = $(this).parents('.weibo');
		if(isDel){
			$.post(delWeibo,{wid:wid},function(data){
				if(data){
					obj.slideUp('slow',function(){
						obj.remove();
					});
				}else{
					alert('删除失败请重试...');
				}
			},'json')
		}
	});

	// 微博举报
	$('.report').click(function(){
		var wid = $(this).find('a').attr('wid');
		var isReport = confirm('确认要举报改微博?');
		var report = $(this);
		var msg = '';
		if(isReport){
			$.post(reportWeibo,{wid:wid},function(data){
				if (data == 1) {
					// report.attr('disabled','true');
					report.parent().append('<li><a href="javascript:void(0)">举报</a></li>');
					report.remove();
					msg = '举报成功';
				}
				if (data == 0){
					msg = '举报失败';
				}
			alert(msg);
			},'json');
		}
	});

     /**
       * 表情处理
       */
      $('.phiz').live('click',function(){
    			//定位表情框到对应位置
    		$('#phiz').show().css({
    			'left' : $(this).offset().left,
    			'top' : $(this).offset().top + $(this).height() + 5
     		});
     		//为每个表情图片添加事件
         var phizImg = $("#phiz img");
         var sign = this.getAttribute('sign');
         for (var i = 0; i < phizImg.length; i++){
         	phizImg[i].onclick = function () {
    			var content = $('textarea[sign = '+sign+']');
    			content.val(content.val() + '[' + $(this).attr('title') + ']');
    			$('#phiz').hide();
         	}
         }
       });

  	//关闭表情框
	$('.close').hover(function () {
		$(this).css('backgroundPosition', '-100px -200px');
	}, function () {
		$(this).css('backgroundPosition', '-75px -200px');
	}).click(function () {
		$(this).parent().parent().hide();
		$('#phiz').hide();
		if ($('#turn').css('display') == 'none') {
			$('#opacity_bg').remove();
		};
	});

	// 点赞
	var zan = false;
	$('.wb_tool li .zan').click(function(){
		zan = !zan;
		// alert(zan);
		var num = $(this).find('i').html();
		num = parseInt(num);
		var wid = $(this).attr('id');
		// alert(wid);
		// alert(num);
		if(zan){
			num = num + 1;
		}else{
			num = num - 1;
		}
		// alert(num);
		Zan = $(this);
		$.get(clickZan,{num:num,wid:wid},function(data){
			if(data){
				Zan.find('i').html(num);
			}
		},'json');
	})



	// 瀑布流
	// 全局配置
	var p = 1; // 页码信息 
	var isLoading = false;
	requestData();
	function requestData(){
	    // 加载请求时关门
	    isLoading = true;
	    // 发起请求
	    $.get(getWeibo,{p:p},function(data){
	        // alert(data);
	        if(data == null){
	            $('#middle').append('<div style="padding-top:20px;font-size:20px;text-align:center">没有发布的微博</div>');
	            return false;
	        }
	        // 循环遍历创建元素
	        for (var i=0; i< data.length;i++){
	            // alert(data[i]['isturn']);
	            if(data[i]['isturn'] == 0){
	                // alert(1111);
			            // 普通微博显示
	                // 克隆普通微博模板
	                var original = $('#original').clone(true);
	                // console.log(original);
	                original.show();
	                //判断头像图片是否存在
	                if(data[i]['face50'] == ''){
	                    original.find('.face img').attr('src',PUBLIC+'/Home/Images/noface.gif');
	                }else{
	                		// 使用默认头像
	                    original.find('.face img').attr('src',PUBLIC+data[i]['face50']);
	                }
	                // 插入用户名
	                var username = data[i]['username'];
	                original.find('.wb_cons .author a').html(username);
	                var url = person.replace(/value/i,data[i]['uid']);
	                original.find('.face a').attr('href',url);
	                original.find('.wb_cons .author a').attr('href',url);              
	                // 插入微博内容
	                var content = data[i]['content'];
	                original.find('.content p').html(content);
	                // 判断是否发表图片
	                if(data[i]['max'] == null){
	                	original.find('.wb_img').parent().remove();
	                }else{
	                	original.find('.wb_img .mini_img').attr('src',PUBLIC+data[i]['mini']);
	                	original.find('.wb_img a').attr('href',PUBLIC+data[i]['max']);
	                	original.find('.wb_img .img_info img').attr('src',PUBLIC+data[i]['medium']);
	                }
	                // 格式化发表微博时间
	                var send_time = untotime(data[i]['time']*1000);
	                original.find('.wb_tool .send_time').html(send_time);
	                if(data[i]['uid'] == uid){
	                	// 自己发布的微博可以删除
	                	original.find('.wb_cons .screen .del a').attr('wid',data[i]['id']);
	                	original.find('.wb_cons .screen .del').siblings().remove();	
	                }else{
	                	// 关注的人发布的微博可以收藏和举报
	                	original.find('.wb_cons .screen .del').remove();
	                	original.find('.wb_cons .screen .keep a').attr('wid',data[i]['id']);	
	                	original.find('.wb_cons .screen .report a').attr('wid',data[i]['id']);	
	                }
	                // 微博转发数
	                original.find('.wb_tool li .turn').attr('id',data[i]['id']);
	                original.find('.wb_tool li .turn i').html(data[i]['turn']);
	                // 微博点赞数
	                original.find('.wb_tool li .zan').attr('id',data[i]['id']);
	                original.find('.wb_tool li .zan i').html(data[i]['zan']);
	                // 微博评论数
	                original.find('.wb_tool li .comment').attr('wid',data[i]['id']);
	                original.find('.wb_tool li .comment i').html(data[i]['comment']);
	                original.find('.comment_load img').attr('src',PUBLIC+'/Home/Images/loading.gif');
	                original.find('.comment_list ul .comment_btn').attr({wid:data[i]['id'],uid:uid});
			            $('#middle').append(original);
	            }else{
	            		// 转发的微博显示模板
	            		// 克隆转发微博模板
	            		var forward = $('#forward').clone(true);
	            		forward.show();
	            		if(data[i]['face50'] == ''){
	            		    forward.find('.face img').attr('src',PUBLIC+'/Home/Images/noface.gif');
	            		}else{
	            		    forward.find('.face img').attr('src',PUBLIC+data[i]['face50']);
	            		}
	            		var username = data[i]['username'];
	            		forward.find('.wb_cons .author a').html(username);
	            		var url = person.replace(/value/i,data[i]['uid']);
	            		forward.find('.face a').attr('href',url);
	            		forward.find('.wb_cons .author a').attr('href',url);   
	            		var content = data[i]['content'];
	            		forward.find('.content p').html(content);
	            		$.ajax({
	            			url : getTurnWeibo,
	            			data : {wid:data[i]['isturn']},
	            			dataType : 'json',
	            			type : 'post',
	            			success : function(date){
	            				if(date == null){
	            					// 判断原微博已删除
	            					forward.find('.wb_cons .content').next().show();	
	            				}else{
	            					forward.find('.wb_cons .content').next().next().find('.wb_turn').show();
	            					// 原创微博的作者
	            					forward.find('.turn_name a').html('@'+date['username']);
	            					var url = person.replace(/value/i,date['uid']);
	            					forward.find('.turn_name a').attr('href',url); 
	            					// 原创微博的内容
	            					forward.find('.turn_cons p').html(date['content']);
	            					// 判断是否发布图片
	            					if(date['max'] == null){
	            						forward.find('.turn_img').parent().remove();
	            					}else{
	            						forward.find('.turn_img .turn_mini_img').attr('src',PUBLIC+date['mini']);
	            						forward.find('.turn_img a').attr('href',PUBLIC+date['max']);
	            						forward.find('.turn_img .turn_img_info img').attr('src',PUBLIC+date['medium']);
	            					}
	            					var send_time = untotime(date['time']*1000);
	            					forward.find('.turn_tool .send_time').html(send_time);
	            					forward.find('.turn_tool li:eq(0) i').html(date['turn']);
	            					forward.find('.turn_tool li:eq(2) i').html(date['zan']);
	            					forward.find('.turn_tool li:eq(4) i').html(date['comment']);
	            				}
	            			},
	            			async: false
	            		});
	            		// 发布时间
	            		var send_time = untotime(data[i]['time']*1000);
	            		forward.find('.wb_tool .send_time').html(send_time);
	            		if(data[i]['uid'] == uid){
	            			// 自己发布的微博可以删除
	            			forward.find('.wb_cons .screen .del a').attr('wid',data[i]['id']);
	            			forward.find('.wb_cons .screen .del').siblings().remove();	
	            		}else{
	            			// 关注的人发布的微博可以收藏和举报
	            			forward.find('.wb_cons .screen .del').remove();
	            			forward.find('.wb_cons .screen .keep a').attr('wid',data[i]['id']);	
	            			forward.find('.wb_cons .screen .report a').attr('wid',data[i]['id']);	
	            		}
	                // 微博转发数
	                forward.find('.wb_tool li .turn').attr('id',data[i]['id']);
	                forward.find('.wb_tool li .turn').attr('tid',data[i]['isturn']);
	                forward.find('.wb_tool li .turn i').html(data[i]['turn']);
	                // 微博点赞数
	                forward.find('.wb_tool li .zan').attr('id',data[i]['id']);
	                forward.find('.wb_tool li .zan i').html(data[i]['zan']);
	                // 微博评论数
	                forward.find('.wb_tool li .comment').attr('wid',data[i]['id']);
	                forward.find('.wb_tool li .comment i').html(data[i]['comment']);
	                forward.find('.comment_load img').attr('src',PUBLIC+'/Home/Images/loading.gif');
	                forward.find('.comment_list ul .comment_btn').attr({wid:data[i]['id'],uid:uid});
			        $('#middle').append(forward);
	            }

	        }
	        // 让页码自增
	        p++;
	        // 打开
	        isLoading = false;

	    },'json');
	}

	// 绑定滚动事件
	$(window).scroll(function(){
	    // 检测当前是否正在发送请求
	    if(isLoading){return;}
	    // 获取整个文档的高度
	    var sH = $('#middle').height();
	    // 获取页面滚动的高度
	    var sT = $(window).scrollTop();
	    // 获取可视区域的高度
	    var cH = $(window).height();
	    if(sH <= sT + cH){
	        requestData();
	    }
	})

});


// 格式化时间戳
function untotime(str){
  var date = new Date(str);
  Y = date.getFullYear() + '-';
  M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '-';
  D = date.getDate() + ' ';
  h = date.getHours() + ':';
  m = date.getMinutes() + ':';
  s = (date.getSeconds()+1 < 10 ? '0'+(date.getSeconds()+1) : date.getSeconds()+1) ;
  return Y+M+D+h+m+s;
}

/**
 * 统计字数
 * @param  字符串
 * @return 数组[当前字数, 最大字数]
 */
function check (str) {
	var num = [0, 140];
	for (var i=0; i<str.length; i++) {
		//字符串不是中文时
		if (str.charCodeAt(i) >= 0 && str.charCodeAt(i) <= 255){
			num[0] = num[0] + 0.5;//当前字数增加0.5个
			num[1] = num[1] + 0.5;//最大输入字数增加0.5个
		} else {//字符串是中文时
			num[0]++;//当前字数增加1个
		}
	}
	return num;
}

/**
 * 替换微博内容，去除 <a> 链接与表情图片
 */
function replace_weibo (content) {
	content = content.replace(/<img.*?title=['"](.*?)['"].*?\/?>/ig, '[$1]');
	content = content.replace(/<a.*?>(.*?)<\/a>/ig, '$1');
	return content.replace(/<span.*?>\&nbsp;(\/\/)\&nbsp;<\/span>/ig, '$1');
}