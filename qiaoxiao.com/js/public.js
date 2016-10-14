(function($){
$(function(){
 	// 判断浏览器是否支持 placeholder  input内灰色提示字符
  if(!('placeholder' in document.createElement('input'))){
      $('[placeholder]').focus(function() {
          var input = $(this);
          if (input.val() == input.attr('placeholder')) {
              input.val('');
              input.removeAttr('style');
          }
      }).blur(function() {
          var input = $(this);
          if (input.val() === '' || input.val() === input.attr('placeholder')) {
              input.attr('style','color:#f2f2f2');
              input.val(input.attr('placeholder'));
          }
      }).blur();
  }
  var $loading = $('<img id="loading" src="/image/loading.gif" />')
              .appendTo(document.body)
              .css({
                position:'absolute',
                'z-index':99999,
                top:0,
                left:0
              })
              .hide();
  //默认数据
  $.ajaxSetup({
    cancel:false,
    complete:function(json){$loading.fadeOut(500);},
    beforeSend:function(){
      $loading.css({
        top:''.concat($(document).scrollTop(),'px')
      }).show();
    },
    error : function(XMLHttpRequest, textStatus, errorThrown){
      $.windows.show({
        width:300,
        height:200,
        html:''.concat(
          '错误类型：',textStatus,'<br />',
          '错误调试：',errorThrown,'<br />',
          '错误内容：',XMLHttpRequest.responseText,'</div>'
        ),
        'method':'alert'
      });
    }
  });




  //导航栏事件触发
  $('.m-navs li a').on('mouseover',function(){

  });

  //当窗口小于1170时的body的最大值
  $(window).resize(function(){
      if($(window).width() < 1170){
          $(document.body).css('width','1170px');
      }else{
          $(document.body).css('width','auto');
      }
  }).trigger('resize');


  var $span,second,time;
  if($('.m-alert .jump').length){// 页面跳转
    $span   = $('.m-alert .jump');
    second  = Number($span.attr('second'))-1;
    time    = setInterval(function () {
      if(second > 0){
        $span.text(second);
        second--;
      }else{
        clearInterval(time);
        location.href = $span.attr('url');
      }
    },1000);
  }else if($('.m-alert .back').length){// 页面返回
    $span   = $('.m-alert .back');
    second  = Number($('.m-alert .back').attr('second'))-1;
    time    = setInterval(function () {
      if(second > 0){
        $span.text(second);
        second--;
      }else{
        clearInterval(time);
        history.go(-1);
      }
    },1000);
    $span.next().on('click',function(){
      history.go(-1);
    });
  }


  // 导航事件
  var $navBtn= $('.m-nav li.btn'),
      $navAct= $('.m-nav li a.ngb').parent(),
      $navLi = $('.m-nav li').not($navBtn)
      .on('mouseover',function(){
        $navBtn.finish();
        var $this = $(this);
        $navBtn.animate({
          left:''.concat($this.position().left,'px'),
          width:''.concat($this.width(),'px')
        },'fast' );
      });
    $('.m-nav').on('mouseleave',function(){
      $navBtn.animate({
        left:''.concat($navAct.position().left,'px'),
        width:''.concat($navAct.width(),'px')
      }, 'fast' );
    });
    $navAct.trigger('mouseover');
});
})(jQuery);
