(function($){
$(function(){
$('.m-pictures .page a img').on('click',function(){
  $('.bg')
  .show()
  .width($(window).width())
  .height($(document).height());
  // .css('margin','-'.concat($(window).height(),'px 0 0 0')


})
  var h = $('.m-picture .refer .flex .up a p1 .img img ').height();
  console.log('h');
alert('111');
    //     $top = ($(window).height() - $('.plist').height())/2;
    //     var left = ($(window).width() - $('.plist').width())/2;
    //     var scrollTop = $(document).scrollTop();
    //     var scrollLeft = $(document).scrollLeft();
    //     $('.plist').css( { position : 'absolute', 'top' : top + scrollTop, left : left + scrollLeft } ).show();
    // }

});
})(jQuery);
