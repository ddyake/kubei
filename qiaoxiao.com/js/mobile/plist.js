(function($){
$(function(){

$(window).on('resize',function(){
  var width = $('.m-picture .pictures li').width()-5;
  $('.m-picture .pictures li img').width(width);
}).trigger('resize');


});
})(jQuery);
