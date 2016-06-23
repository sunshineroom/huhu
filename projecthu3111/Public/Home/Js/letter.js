$(function () {
   //发送私信框
   $('.l-reply').click(function () {
      //弹出私信框
      var left = ($(window).width()-400)/2+'px';
      var top = ($(window).height()-300)/2+'px';
      var obj = $('#letter').show().css({
         'left' : left,
         'top' : top
      });
      //清空消息内容
      $('#letter').find('textarea').val('');
      var btn = $(this);
      //回复那个人的昵称
      var username = btn.parents('dd').prev().find('a').html();

      //回复 直接找到收信人的uid
      var from = btn.attr('from');
      $('input[name=infousername]').val(username);

      //发送
      $('.send-lt-sub').click(function(){
         var content = $('#letter').find('textarea').val();
         $.post('addletter',{uid:from,content:content},function(data){
            if(data == 1){
               $('#letter').hide();
            }else{
               alert('发送失败');
            }
         })
      })
   });
   //发送私信 通过输入收信人昵称来发送
   $('.send').click(function () {
      //弹出私信框
      var left = ($(window).width()-400)/2+'px';
      var top = ($(window).height()-300)/2+'px';
      var obj = $('#letter').show().css({
         'left' : left,
         'top' : top
      });
      //清空消息内容
      // $('input[name=name]').val('');
      $('#letter').find('textarea').val('');
      //得到写入的username值
      $("input[name='infousername']").blur(function(){
         var username = $(this).val();
         //发送
         $('.send-lt-sub').click(function(){
            //发送ajax的到收信人的uid
            $.post('getuid',{username:username},function(data){
               var uid = data;
               if(uid==0){
                  alert('不可以给自己发私信');
                  return;
               }
               //获取书写的收信人昵称
               var content = $('#letter').find('textarea').val();
               $.post('addletter',{uid:uid,content:content},function(data){
                  if(data == 1){
                     $('#letter').hide();
                  }else{
                     alert('发送失败');
                  }
               })
            })
         })
      });
   })
   //直接发送信息
   $('.send-lt-hu').click(function(){
         $('#lattermain').scrollTop(newtop);
         var scrolltop = $('#lattermain').scrollTop();
         //得到对话的人的letter表的from值
         var from = $('#sendto').find('.fromfrom').attr('from');
         //信息内容
         var content = $('#privatemsg').find('textarea').val();
         $('#privatemsg').find('textarea').val('');
         $.post('addaddletter',{uid:from,content:content},function(data){
               var newmykuang =  $('<dl><dt class="fright">\n\
                      <a href="'+singlewei+'?uid='+data["uid"]+'"><img src="/Public/Home/Images/noface.gif" width="50" height="50"/></a>\n\
                        </dt>\n\
                        <dd class="lettermsg fright">\n\
                            <span class="fright" style="padding-right:20px">'+data["content"]+'</span>\n\
                        </dd>\n\
                        <dd class="tright fright">\n\
                            <span class="send_time fright" time="'+data["time"]+'" style="padding-right:20px"><?php echo date("y-m-d H:i",'+data["time"]+')?></span>\n\
                            <span class="del-letter fright" lid="{$v.from}" style="padding-right:20px">删除</span> \n\
                        </dd></dl>');
               newmykuang.find('.send_time').attr('time',data['time']).html(data["newtime"]);
               if(data['face50']!=''){
                  newmykuang.find('img').attr('src','/Public'+data['face50']);
               }
               newmykuang.find('.del-letter').attr('lid',data['from']);  
               $('#lattermain').append(newmykuang);
               var newttp = $('#lattermain').find('dt:last').offset().top;
               var newheight = $('#lattermain').find('dt:last').height();
               // alert(newttp+newheight);
               $('#lattermain').scrollTop(scrolltop+newheight+1000);    
         },'json');
      })
   //删除当前对话人所有私信
   $('.del-allletter').click(function(){
      var btn = $(this);
      //得到wb_letter的from的
      var from = $(this).attr('lid');
      //发ajax删除letter
      $.post('delallletter',{from:from},function(data){
         if(data==1){
            btn.parents('dl').remove();
         }else{
            alert('删除失败');
         }
      })
   })
   //双击进入对话框
   $('dl').live("dblclick",function(){
      //收信人 from
      var from = $(this).find('.l-reply').attr('from');
      location.href = dblurl+'?from='+from;

   })
   
   //删除当条私信
   $('.del-letter').live("click",function(){
      var btn = $(this);
      //得到wb_letterfrom的
      var from = $(this).attr('lid');
      //得到发送的时间
      var time = $(this).prev().attr('time');
      //发ajax删除letter
      $.post('delletter',{from:from,time:time},function(data){
         if(data==1){
            btn.parents('dl').remove();
         }else{
            alert('删除失败');
         }
      })
   })
   //关闭弹窗
   $('.letter-cencle').click(function(){
      $('#letter').hide();
   })



  
   
   
});

   
