// SEO

// 链接推送
function SeoUrlsPush(event,ui){

  ui.newPanel.load('./fragment.html .mod-seo',function(){
    var $this = $(this),
        $over = $this.find('.over'),
        $time = $this.find('.time input').datepicker({
                  dateFormat: 'yy-mm-dd',
                  monthNames: ['一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月'],
                  dayNamesMin  : ['日','一','二','三','四','五','六']
                }).datepicker('setDate',new Date()),
        $send = $this.find('.time button')
                .button({})
                .on('click',function(){
          if(!$time.val()){$.alert('请选择日期');}
          $.servers({
            data:{act:'seo-urls-push',time:$time.val()},
            success:function(json){
              if(json.status != 'ok'){$.alert(json.data);return;}
              var $ul = $('<ul>');
              $ul.append($('<li>').text('m.qiaoxiao.com提交返回值：'+json.data.m));
              $ul.append($('<li>').text('www.qiaoxiao.com提交返回值：'+json.data.w));
              $over.empty().append($ul);
            }
          });
        });

  });


}
