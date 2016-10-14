(function($){
$(function(){
  // 后台编辑功能
  $('.opt-edit').each(function(){
    var $this   = $(this),
        tid     = $(this).attr('tid'),
        positon = $this.offset(),
        $edit = $('<div/>')
                  .addClass('m-edit')
                  .attr('tid',tid)
                  .append($('<button/>').text('编 辑').addClass('edit-btn').on('click',{tid:tid},links))
                  .css({left:''.concat(positon.left,'px'),top:''.concat(positon.top,'px')})
                  .width($this.width()-6)
                  .height($this.height());
    $('body').append($edit);
  });


  function links(evt){
    var tid     = evt.data.tid,
        fields  = {id:'编号',image:'图片',tit:'标题',href:'链接'},
        $ul     = $('<ul class="m-links"><li class="list"></li><li class="tit"><label class="lab">链接名称：</label><input type="text" value="" /></li><li class="href"><label class="lab">链接地址：</label><input type="text" value="" /></li><li class="image"><label class="lab">链接图片：</label><input type="text" value="" /><img /><a>上传图片</a><span></span></li><li class="cont"><label class="lab">链接简介：</label><textarea></textarea></li><li class="btn"><a>新增链接</a><a>重置</a></li></ul>'),
        $list   = $ul.find('.list'),
        $save   = $ul.find('.btn a:first').button({icon:'ui-icon-disk'}),
        $rest   = $ul.find('.btn a:last').button({icon:'ui-icon-cancel'}),
        $imgBtn = $ul.find('li.image a'),
        $img    = $ul.find('li.image img'),
        $dialog = $('<div/>')
          .append($ul)
          .dialog({width:800,height:500,minimize:1,appenTo:$('body')}),
        size    = 10240000,
        uploader= WebUploader.create({
          auto  : true,
          swf   : '/opt/image/upload.swf',
          server: '/opt/act.php?act=global-upload',
          pick: $imgBtn,
          multiple:false,
          fileNumLimit:1,
          fileSizeLimit:size,
          accept:{
            title: 'Images',
            extensions: 'gif,jpg,jpeg,png',
            mimeTypes: 'image/*'
          }
        }).on('beforeFileQueued',function(file){
          if($imgBtn.attr('status')){$.alert($imgBtn.attr('status'));return;}
          $imgBtn.attr('status','图片上传中...');
          if(file.size > size){
            $.alert('图片大小超过'.concat('10240K'));
            $imgBtn.removeAttr('status');
          }
        }).on( 'uploadSuccess', function( file ){
          $imgBtn.removeAttr('status');
        }).on( 'uploadError', function( file ) {
          $.alert('上传出错');
          $imgBtn.removeAttr('status');
        }).on( 'uploadComplete', function( file ) {//上传完成
          $imgBtn.removeAttr('status');
        }).on('uploadAccept',function(obj,data){
          $imgBtn.removeAttr('status');
          if(data.data.url){
            if(data.status != 'ok'){
              $.alert(data.data);
              uploader.removeFile(obj.file,true);
              uploader.reset();
              return;
            }
            data.data.url = '/data/temp/'.concat(data.data.url);
            $img.prev().val(data.data.url);
            $img.attr('src',data.data.url).attr('href',data.data.url)
            .show().on('click',function(){
            if($img.attr('status') && !$img.attr('src')){return;}
            $(this).attr('status','open');
            $('<div/>')
            .attr('title','图片')
            .append(
            $('<img/>').css({'vertical-align':'middle','margin':'0 auto'}).width(300)
            .attr('src',$(this).attr('src'))
            ).dialog({modal:true,width:300,close:function(){$img.removeAttr('status');}});
            });
          }
        });
    // 保存
    $save.on('click',function(){
      var data={
            tit:$ul.find('li.tit input').val(),
            href:$ul.find('li.href input').val(),
            image:$ul.find('li.image input:first').val(),
            cont:$ul.find('li.cont textarea').val()
          },
          act = $list.find('li.act').data('json');

        // 编辑
        if($ul.attr('lid')){
          data.id=$ul.attr('lid');
          if(data.tit == act.tit){delete data.tit;}
          if(data.href == act.href){delete data.href;}
          if(data.image == act.image){delete data.image;}
          if(data.cont == act.cont){delete data.cont;}
        }else{//新建
          data.tid = tid;
        }
        if($.isEmptyObject(data)){$.alert('未修改任何数据!');return;}
        $.ajax({
          type:'post',
          dataType: "json",
          url: '/act.php?act='.concat(data.id?'json-links-update':'json-links-insert'),
          data: data,
          success: function(json){
            if(json.status != 'ok'){$.alert(json.data);return;}
            $.alert(json.data,3);
            data.image = json.image;
            if(!data.id){//创建
              data.id = json.lid;
              $ul.attr('lid',data.id);
              $list.find('ul:first').prepend($('<li>').attr('title',data.tit).text(data.tit).data('json',data));
            }else{
              $list.find('li.act').text(data.tit).data('json',data);
            }
          }
        });
    });//保存
    // 获取链接分页
    paging();

    function paging(p){
      p = p?p:1;
      $.getJSON(
        '/act.php',
        {act:'json-links-paging',tid:tid,p:p},
        function(json){
          if(json.status != 'ok'){$.alert(json.data);return;}
          $dialog.dialog('option','title','当前操作分类：'.concat(json.tp.tit));
          var $liUl=$('<ul/>');
          $.each(json.data.data,function(){
            $liUl.append(
              $('<li/>').text(this.tit)
              .attr('title',this.tit)
              .data('json',this)
            );
          });

          // 增加底部按钮
          $liUl.append(
            $('<li/>').addClass('last')
            .append(//增加
              $('<a/>').attr('title','增加链接').button({label:0,icon:'ui-icon-plus'})
              .on('click',function(){
                $ul.removeAttr('lid');
                $save.button({label:'新增链接'});
                $ul.find('li.image input:first').val('');
                $ul.find('li.href input').val('');
                $ul.find('li.cont textarea').val('');
                $ul.find('li.tit input').val('').focus();
              })
            )
            .append(//上一页
              $('<a/>').attr('title','上一页').button({label:0,icon:'ui-icon-triangle-1-w'})
              .on('click',function(){
                if(json.data.nowPage == json.data.upPage || json.data.upPage == '0'){return;}
                paging(json.data.upPage);
              })
            )
            .append(//下一页
              $('<a/>').attr('title','下一页').button({label:0,icon:'ui-icon-triangle-1-e'})
              .on('click',function(){
                if(json.data.nowPage == json.data.downPage || json.data.downPage == '0'){return;}
                paging(json.data.downPage);
              })
            )
            .append(//删除
              $('<a/>').attr('title','删除').button({label:0,icon:'ui-icon-minus'})
              .on('click',function(){
                var $act = $list.find('li.act'),
                    data = $act.data('json'),
                    $this=$(this);
                if(!$act.length || !data.id){$.alert('请点击需要删除的链接!');return;}
                if($this.attr('status')){
                  $.alert($this.attr('status'));
                  settimeout(function(){$this.removeAttr('status');},3000);
                  return;
                }
                $this.attr('status','数据传输中...');
                $.getJSON(
                  '/act.php',
                  {act:'json-links-delete',lid:data.id},
                  function(json){
                    $this.removeAttr('status');
                    if(json.status != 'ok'){$.alert(json);return;}
                    $.alert(json.data,3);
                    $act.remove();
                    $ul.find('li.tit input').val('');
                    $ul.find('li.image input').val('');
                    $ul.find('li.href input').val('');
                    $ul.find('li.cont textarea').val('');
                    $ul.removeAttr('lid');
                  }
                );
              })
            )
          ).on('click','li',function(){
            if($(this).hasClass('btn')){return;}
            $liUl.find('li').removeClass('act');
            $(this).addClass('act');
            var data = $(this).data('json');
            if(!data){return;}
            // 显示内容
            $ul.find('li.image input:first').val(data.image);
            $ul.find('li.tit input').val(data.tit?data.tit:'');
            $ul.find('li.href input').val(data.href?data.href:'');
            $ul.find('li.cont textarea').val(data.cont?data.cont:'');
            if(data.image){
              $ul.find('li.image img:first').attr('src',data.image).attr('href',data.image);
            }else{
              $ul.find('li.image img:first').removeAttr('src').removeAttr('href');
            }
            $ul.attr('lid',data.id);
            $save.button({label:'修改链接'});
          });
          $list.empty().append($liUl);
        }
      );
    }

  }



});
})(jQuery);
