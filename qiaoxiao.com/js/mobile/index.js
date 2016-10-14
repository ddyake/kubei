(function($){
$(function(){

  $('.m-index .t-more').on('click',function(){
    $('.none').removeClass('none');
    $(this).remove();
    $('.lists .noborder').removeClass('noborder');
    $('.lists:last .foot').addClass('noborder');
  });



});
})(jQuery);
