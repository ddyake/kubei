(function($){
$(function(){

  var $ul   = $('.m-scroll ul'),
      $prev = $('.m-scroll .prev a'),
      $next = $('.m-scroll .next a'),
      width = 1210,
      mWidth= $ul.find('li').length*width,
      bool= 1;
      num = window.setInterval(function () {
        if(!bool){return;}
        $ul.finish();
        var left = Math.abs($ul.position().left);
        if(left >=(mWidth-width)){
          left = 0;
          $ul.css('left','0');
        }
        $ul.animate({left:'-'.concat(left+width,'px')}, 'slow');
      }, 5000);
  $ul.width(mWidth);
  $ul.on('mouseover',function(){bool=0;});
  $ul.on('mouseout',function(){bool=1;});
  $prev.on('click',function(){
    $ul.finish();
    var left = Math.abs($ul.position().left);
    if(left >=(mWidth-width)){
      $ul.animate({left:0}, 100);
    }else{
      $ul.animate({left:'-'.concat(left+width,'px')}, 'slow');
    }
  });
  $next.on('click',function(){
    $ul.finish();
    var left = Math.abs($ul.position().left);
    if(left <=(width)){
      $ul.animate({left:'-'.concat(mWidth-width,'px')}, 100);
    }else{
      $ul.animate({left:'-'.concat(left-width,'px')}, 'slow');
    }
  });
  // $(".m-scroll").slide({
  //   mainCell:".bg ul",
  //   effect:"leftLoop",
  //   vis:"auto",
  //   autoPlay:true,
  //   autoPage:true,
  //   trigger:"click" });


  // 排行
  var $tab  = $('#tab'),
      $tabLi= $tab.find('li');
  $tabLi.on('mouseover',function(){
    $tabLi.removeClass('act');
    $(this).addClass('act');
  });

  // 滑动效果
  $('.m-index .block-2 .l .img2')
  .on('mouseover',function(){
    $(this).find('.txt').addClass('hover');
    $(this).find('.cont').addClass('conthover');
  }).on('mouseout',function(){
    $(this).find('.txt').removeClass('hover');
    $(this).find('.cont').removeClass('conthover');
  });

  // 图片还原/放大
  $('.m-index .block-4 a')
  .on('mouseover',function(){
    var $img = $(this).find('img'),
        w = $img.width(),
        h = $img.height();
    $img.animate({
      width:''.concat(w*1.1,'px'),
      height:''.concat(h*1.1,'px')
    },'fast').attr('w',w).attr('h',h);
  }).on('mouseout',function(){
    var $img = $(this).find('img'),
        w = $img.attr('w'),
        h = $img.attr('h');
    $img.animate({
      width:''.concat(w,'px'),
      height:''.concat(h,'px')
    },'fast');
  });
  
});
})(jQuery);
