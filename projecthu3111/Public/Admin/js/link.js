// 友情链接表的增删改查
$(function(){
	//前台显示
	// alert($);
	$('.isshow').on('click',function(){
		var link = $(this);
		var id = $(this).attr('id');
		$.post(showurl,{id:id},function(data){
			if(data==1){
				//把他变成不显示
				var showlink = link.attr('class','btn btn-warning btn-circle isshow').find('i').attr('class','fa fa-times');
			}else{
				//把他变成显示
				var showlink = link.attr('class','btn btn-info btn-circle isshow').find('i').attr('class','fa fa-check');
			}
		})
	})
	//更改src
	$('.linksrc').dblclick(function(){
		var link = $(this);
		var id = link.attr('id');
		var src = link.html();
		var input = $('<input type="text" style="width:300px;height:40px;padding-left:10px" value='+src+' />');
		link.html(input);
		input.blur(function(){
			var newsrc = $(this).val();
			$.post(newsrcurl,{id:id,src:newsrc},function(data){
				if(data>0){
					link.html(newsrc);
					alert('修改成功');
				}
			})
		})
	})
	//更改链接名称
	$('.linkcontent').dblclick(function(){
		var link = $(this);
		var id = link.attr('id');
		var src = link.html();
		var input = $('<input type="text" style="width:300px;height:40px;padding-left:10px" value='+src+' />');
		link.html(input);
		input.blur(function(){
			var newcontent = $(this).val();
			$.post(newsrcurl,{id:id,linkcontent:newcontent},function(data){
				if(data>0){
					link.html(newcontent);
					alert('修改成功');
				}else{
					alert('修改失败');
				}
			})
		})
	})
	//新增友情链接
	$('.newlink').on('click',function(){
		var maxid = parseInt($('tbody').find('tr:last').find('.linkcontent').attr('id'))+1;

		var hang = $('tbody').find('tr:eq(0)').clone(true);
		hang.find('.sid').html(maxid);
		var newinputsrc = $('<input type="text" style="width:300px;height:40px;padding-left:10px" value='+hang.find('.linksrc').html()+' />');
		hang.find('.linksrc').html(newinputsrc);
		var newinputcontent = $('<input type="text" style="width:300px;height:40px;padding-left:10px" value='+hang.find('.linkcontent').html()+' />');
		hang.find('.linkcontent').html(newinputcontent);
		
		$('tbody').append(hang);
		newinputcontent.blur(function(){
			var newsrc = newinputsrc.val();
			var newcontent = newinputcontent.val();
			$.post(newlinkurl,{src:newsrc,linkcontent:newcontent},function(data){
				if(data>0){
					hang.find('.sid').html(data);
					hang.find('.linksrc').attr('id',data);
					hang.find('.linkcontent').attr('id',data);
					hang.find('.isshow').attr('id',data);
					hang.find('.dellink').attr('id',data);
					hang.find('.linksrc').html(newsrc);
					hang.find('.linkcontent').html(newcontent);
					alert('新增成功');
				}
			})
		})
	})
	// 删除友情链接
	$('.dellink').on('click',function(){
		var id = $(this).attr('id');
		var link = $(this);
		$.post(dellinkurl,{id:id},function(data){
			if(data>0){
				link.parents('tr').remove();
			}else{
				alert('删除失败');
			}
		})
	})


	//公告栏开始
	//前台显示
	// alert($);
	$('.isgong').on('click',function(){
		var link = $(this);
		var id = $(this).attr('id');
		$.post(showurl,{id:id},function(data){
			if(data==1){
				//把他变成不显示
				var showlink = link.attr('class','btn btn-warning btn-circle isgong').find('i').attr('class','fa fa-times');
			}else{
				//把他变成显示
				var showlink = link.attr('class','btn btn-info btn-circle isgong').find('i').attr('class','fa fa-check');
			}
		})
	})
	//更改src
	$('.gongsrc').dblclick(function(){
		var link = $(this);
		var id = link.attr('id');
		var src = link.html();
		var input = $('<input type="text" style="width:300px;height:40px;padding-left:10px" value='+src+' />');
		link.html(input);
		input.blur(function(){
			var newsrc = $(this).val();
			$.post(newsrcurl,{id:id,gongsrc:newsrc},function(data){
				if(data>0){
					link.html(newsrc);
					alert('修改成功');
				}
			})
		})
	})
	//更改链接名称
	$('.gongcontent').dblclick(function(){
		var link = $(this);
		var id = link.attr('id');
		var src = link.html();
		var input = $('<input type="text" style="width:300px;height:40px;padding-left:10px" value='+src+' />');
		link.html(input);
		input.blur(function(){
			var newcontent = $(this).val();
			$.post(newsrcurl,{id:id,gongcontent:newcontent},function(data){
				if(data>0){
					link.html(newcontent);
					alert('修改成功');
				}else{
					alert('修改失败');
				}
			})
		})
	})
	//新增友情链接
	$('.newgong').on('click',function(){
		var maxid = parseInt($('tbody').find('tr:last').find('.gongcontent').attr('id'))+1;

		var hang = $('tbody').find('tr:eq(0)').clone(true);
		hang.find('.sid').html(maxid);
		// alert(hang.find('.gongsrc').html());
		var newinputsrc = $('<input type="text" style="width:300px;height:40px;padding-left:10px" value='+hang.find('.gongsrc').html()+' />');
		hang.find('.gongsrc').html(newinputsrc);
		var newinputcontent = $('<input type="text" style="width:300px;height:40px;padding-left:10px" value='+hang.find('.gongcontent').html()+' />');
		hang.find('.gongcontent').html(newinputcontent);
		
		$('tbody').append(hang);
		newinputcontent.blur(function(){
			var newsrc = newinputsrc.val();
			var newcontent = newinputcontent.val();
			$.post(newlinkurl,{gongsrc:newsrc,gongcontent:newcontent},function(data){
				if(data>0){
					hang.find('.sid').html(data);
					hang.find('.gongsrc').attr('id',data);
					hang.find('.gongcontent').attr('id',data);
					hang.find('.isgong').attr('id',data);
					hang.find('.delgong').attr('id',data);
					hang.find('.gongsrc').html(newsrc);
					hang.find('.gongcontent').html(newcontent);
					alert('新增成功');
				}
			})
		})
	})
	// 删除友情链接
	$('.delgong').on('click',function(){
		var id = $(this).attr('id');
		var link = $(this);
		$.post(dellinkurl,{id:id},function(data){
			if(data>0){
				link.parents('tr').remove();
			}else{
				alert('删除失败');
			}
		})
	})
	
	
})