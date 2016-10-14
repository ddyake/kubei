(function($){

    $(function(){
      //主页面
      var $left	  = $('.m-left'),
          $right  = $('.m-right'),
          $cont	  = $(".m-right div.cont"),
          $mode 	= $(".m-left ul.mode"),
          $status = $('.m-bottom');
      //窗口改变主题尺寸变化
      $(window).on('resize',function(){
        var h = $(window).outerHeight()-$status.outerHeight();
        $right.height(h);
        $cont.height(h-$('.m-right .top').height()-20);
        $left.height(h);
      }).trigger('resize');


      //加载系统
      $.admin.load({
        module	: $mode,
        cont	: $cont,
        top     : $right.find('.top')
      });

    });//ready
})(jQuery);
