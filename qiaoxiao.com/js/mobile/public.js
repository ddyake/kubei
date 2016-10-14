(function($){
$(function(){
  // 置顶 顶部
  var h         = $(window).height()/2,
      $topIndex = $('.m-top-index');
  $topIndex.find('a.index').on('click',function(){
    $(window).scrollTop(0);
  });
  $topIndex.hide();
  $(window).on('scroll',function(){
    if($(this).scrollTop() > h){
      $topIndex.show();
    }else{
      $topIndex.hide();
    }
  });

  // 幻灯
  var mySwiper = new Swiper ('.m-slide', {
        direction: 'horizontal',
        autoplay:5000,
        loop: true,
        height:130,
        pagination: '.swiper-pagination',
        grabCursor: true,
      	paginationClickable: true,
    		onSlideChangeEnd : function() {
    			var bannerTitle = $(".swiper-container .swiper-slide-active a").attr("title");
    			$(".swiper-tit p").text(bannerTitle);
    		}
      }),
      $search  = $('.m-search'),
      $navs    = $('.m-navs'),
      $navsBg  = $('.m-navs .bg');
  // 搜索框
  $('.m-header .btn a:first').on('click',function(){
    $search.toggle(500);
    $navs.hide();
  });
  $('.m-search form').on('submit',function(){
    if(!$(this).find('input.radius-10').val()){
      return false;
    }
  });
  // 链接
  $('.m-header .btn a:last').on('click',function(){
    $search.hide();
    if($navs.is(':hidden')){
      $navs.toggle();
      $navs.find('div.nlist').animate({height:60},300);
    }else{
      $navs.find('div.nlist').animate({height:0},300,function(){
        $navs.toggle();
      });
    }
  });
  $navs.find('a').on('mousedown',function(){return false;});
  $navsBg.on('mousedown',function(){
    if(!$navs.is(':hidden')){
      $navs.toggle();
    }
    if(!$search.is(':hidden')){
      $search.toggle();
    }
  });



  $(window).on('resize',function(){
    // 图片自适应大小
    // 首页幻灯高宽 500*320
    var width = $(window).width(),
        hh    = width/11*5;
      $('.swiper-tit').css('font-size',''.concat(width/300*0.625*80+'%'));
      $('.swiper-container').height(hh);

    $('.m-picture .plist div').height(width/2/25*16);
    $('.m-picture .plist div').width(width/2);

    // 头部导航链接
    var height = $(document).height(),
        h      = height-$('.m-header').height();
    $navs.height(h);
    $navs.find('.bg').height(h-$navs.find('.n-list').height());

    // gpicture
    var ghh    = width/3/8*5;
      $('.gpicture .text')
        .css('font-size',''.concat(width/300*0.625*80+'%'))
        .height(22);
      $('.gpicture .img,.gpicture img').height(ghh);
      $('.gpicture').height(ghh+22);
      // 相关图 推荐图
      $('.m-pictures .text')
        .css('font-size',''.concat(width/300*0.625*80+'%'))
        .height(22);
        $('#img img,.m-pictures .refer img').height(ghh);
    // 底部图片
    var bh = width/1/5;
    $('.gpicture-bottom,.gpicture-image,.gpicture-image img').height(bh);
  }).trigger('resize');


  // article page
  $('.m-article .page p').on('click',function(){
    return $('.m-article .page select').click();
  });

//tupian
  var s = ($(window).height()-$('.plist').outerHeight())/4;
  $('.m-pictures .page a img')
  .add($('.m-article .page a img'))
  .add($('.m-pictures .ps a img'))
  .on('touchstart click',function(){
    if($(this).attr('jump') != '1'){return true;}
    $('.m-bg')
    .show()
    .width($(document).width())
    .height($(document).height());

    $('.m-advert').show();
    $('.m-advert .plist').show().css('top',''.concat(s,'px'));
    return false;
  });
  $('.m-bg').on('touchstart click',function(){
    $('.m-advert').hide();
    $('.m-bg').hide();
    return false;
  });


  // gpicture页面
  // 底部
  $('.m-bottom .close a').on('click',function(){
    $('.m-bottom').remove();
  });
  // 头部
  $('.mk-1 p span').on('click',function(){
    $('.mk-1').remove();
  });
});
})(jQuery);
