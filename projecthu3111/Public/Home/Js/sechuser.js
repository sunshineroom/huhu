$(window).load(function(){
	$('#sech-cons').focus(function(){
		var sech = $(this).val();
		if(sech=='搜索微博、找人'){
			$(this).val('');
		}
	});
})

