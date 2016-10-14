// 链接管理
function ContLink(event,ui){
  ui.newPanel.load('fragment.html .mod-links',function(){
    var $type = $(this).find('.mod-links-left'),
        $cont = $(this).find('.mod-links-right');
    $cont.width($(this).width()-$type.width()-20);
    $type.types({
      data:{upid:$.website.tid.links},
      click:function(that){
        var fields  = {
              id:'编号',
              image:'图片',
              tit:'标题',
              href:'链接'
            },
            search = fields,
            $treeData= that._active.data('args'),
            $treeAct = $(this);
        $cont.paging({
            tb          : 'links',
            checkbox    : 0,
            num         : 10,
            fields      : fields,
            search      : search,
            where       : 'tid = '.concat($treeData.id),
            desc        : 'id desc',
            editBtns	:{
              '编辑':function(evt){
                  var lid     = evt.data.tr.find('.field-id span').text(),
                      $table  = evt.data.tr.parents('table:first'),
                      $win    = $('<div title="编辑链接"></div>');
                  if(!/\d+/.test(lid)){$.alert({cont:'编号错误!'});return;}
                  $win.load('fragment.html .mod-links-add-edit',function(){
                    var $links = $(this),
                        $tit    = $links.find('.tit input'),
                        $href   = $links.find('.href input'),
                        $cont   = $links.find('.cont textarea'),
                        $target = $links.find('select:eq(0)'),
                        $color  = $links.find('select:eq(1)'),
                        $image  = $links.find('li.image'),
                        $img    = $image.find('img'),
                        $imgIpt = $image.find('input:eq(0)'),
                        $imgBtn = $image.find('a:eq(0)'),
                        $imgRest= $image.find('a.rest'),
                        $process= $image.find('span'),
                        // 上传图片
                        $uploader;
                    // 获取单条数据
                    $.servers({
                        type:'post',
                        data:{
                            act:'content-links-get',
                            lid : lid
                        },
                        success:function(json){
                            if(json.status != 'ok'){
                                $.alert({cont:json.data});
                                return;
                            }
                            var data    = json.data;
                            $tit.val(data.tit);
                            $href.val(data.href);
                            $cont.val(data.cont);
                            $target.val(data.target);
                            $color.val(data.color);
                            $imgIpt.val(data.image);
                            $imgIpt.attr('old',data.image);
                            if(data.image){$img.attr('src',data.image).show();}
                            $uploader = WebUploader.create({
                               auto:true,
                               swf   : './image/upload.swf',
                               server: './act.php?act=global-upload',
                               pick: $imgBtn,
                               multiple:false,
                               fileNumLimit:1,
                               fileSizeLimit:$.website.upload.size,
                               accept:{
                                   title: 'Images',
                                   extensions: 'gif,jpg,jpeg,png',
                                   mimeTypes: 'image/*'
                               }
                             }).on('beforeFileQueued',function(file){
                              if(file.size > $.website.upload.size){
                                $.alert('图片大小超过'.concat($.website.upload.size,'K'));
                              }
                             }).on('uploadProgress',function( file, percentage ) {
                              $process.text(percentage * 100+'%')
                                      .css( 'width', percentage * 100 + 'px' );
                             }).on( 'uploadSuccess', function( file ){
                              $process.text('已上传');
                             }).on( 'uploadError', function( file ) {
                              $process.text('上传出错');
                             }).on( 'uploadComplete', function( file ) {//上传完成
                              $process.text('上传成功!');
                             }).on('uploadAccept',function(obj,data){
                              try{
                                var json = $.parseJSON(data._raw);
                                switch(json.status){
                                  case 'ok':
                                   $imgIpt.val(json.data.url);
                                   $imgBtn.hide();
                                   $imgRest.button().show().on('click',function(){
                                     $uploader.reset();
                                     $imgBtn.show();
                                     $img.removeAttr('src').hide();
                                     $(this).hide();
                                     $process.width(0).text('');
                                   });
                                   $img.attr(
                                     'src',''.concat(
                                       $.website.path.temp.replace(new RegExp($.website.path.root),''),
                                       '/',
                                       json.data.url
                                     )
                                   ).show().on('click',function(){
                                     if($img.attr('status') && !$img.attr('src')){return;}
                                     $(this).attr('status','open');
                                     $('<div/>')
                                     .attr('title','图片')
                                     .append(
                                       $('<img/>').css({'vertical-align':'middle','margin':'0 auto'}).width(300)
                                       .attr('src',$(this).attr('src'))
                                     ).dialog({modal:true,width:300,close:function(){$img.removeAttr('status');}});
                                   });
                                  break;
                                  default:
                                    $.alert(json.data);
                                    $uploader.removeFile(obj.file,true);
                                    $uploader.reset();
                                    $process.text('');
                                    $imgRest.hide();
                                }
                              }catch(e){
                                $.alert('错误：'.concat(e));
                                $uploader.removeFile(obj.file,true);
                                $uploader.reset();
                                $process.text('');
                                $imgRest.hide();
                               //  alert(data._raw);
                              }
                            });
                            $win.dialog({
                              width:800,
                              height:500,
                              buttons:{
                                '保 存':function(){
                                  var $dialog = $(this);
                                  $.servers({
                                      type    : 'post',
                                      data    : {
                                          act     : 'content-links-update',
                                          lid     : lid,
                                          color   : $color.val(),
                                          target  : $target.val(),
                                          tit     : $tit.val(),
                                          href    : $href.val(),
                                          cont    : $cont.val(),
                                          image   : $imgIpt.val() != $imgIpt.attr('old')?$imgIpt.val():''
                                      },
                                      success : function(json){
                                          if(json.status != 'ok'){$.alert({cont:json.data});return;}
                                          $.alert(json.data,2);
                                          $table.find('tfoot a:contains(跳转)')
                                                .trigger('click');
                                          $win.dialog('destroy');
                                      }
                                  });//servers
                                }
                              }
                            });//dialog
                          }
                      });//servers
                  });
              },
              '删除':function(evt){
                  var lid     = evt.data.tr.find('.field-id span').text(),
                      $table  = evt.data.tr.parents('table:first');
                  $('<div title="提示">是否真的删除？</div>').dialog({
                      modal:1,
                      buttons:{
                          '确 定':function(){
                              if(!/\d+/.test(lid)){$.alert({cont:'编号错误!'});return;}
                              var $dialog = $(this);
                              $.servers({
                                      type:'post',
                                      data:{
                                      act:'content-links-delete',
                                      lid:lid
                                  },
                                  success:function(json){
                                      if(json.status != 'ok'){
                                          $.alert({cont:json.data});
                                      }else{
                                          $table.find('tfoot input.page')
                                                  .val($table.find('tfoot span.pages')
                                                          .text()
                                                          .split('/')[0]);
                                          $table.find('tfoot a:contains(跳转)')
                                                  .trigger('click');
                                      }
                                      $dialog.dialog('destroy');
                                  }
                              });
                          },
                          '取 消':function(){
                              $(this).dialog('destroy');
                          }
                      }
                  });
              }
            },
            footBtns    : {
              '添加链接':function(event){
                var $win     = $('<div title="添加链接"></div>'),
                    $table  = event.data.table;
                $win.load('fragment.html .mod-links-add-edit',function(){
                  var $links = $(this),
                      $tit    = $links.find('.tit input'),
                      $href   = $links.find('.href input'),
                      $cont   = $links.find('.cont textarea'),
                      $target = $links.find('select:eq(0)'),
                      $color  = $links.find('select:eq(1)'),
                      $image  = $links.find('li.image'),
                      $img    = $image.find('img'),
                      $imgIpt = $image.find('input:eq(0)'),
                      $imgBtn = $image.find('a:eq(0)'),
                      $imgRest= $image.find('a.rest'),
                      $process= $image.find('span'),
                      // 上传图片
                      $uploader = WebUploader.create({
                         auto:true,
                         swf   : './image/upload.swf',
                         server: './act.php?act=global-upload',
                         pick: $imgBtn,
                         multiple:false,
                         fileNumLimit:1,
                         fileSizeLimit:$.website.upload.size,
                         accept:{
                             title: 'Images',
                             extensions: 'gif,jpg,jpeg,png',
                             mimeTypes: 'image/*'
                         }
                       }).on('beforeFileQueued',function(file){
                        if(file.size > $.website.upload.size){
                          $.alert('图片大小超过'.concat($.website.upload.size,'K'));
                        }
                       }).on('uploadProgress',function( file, percentage ) {
                        $process.text(percentage * 100+'%')
                                .css( 'width', percentage * 100 + 'px' );
                       }).on( 'uploadSuccess', function( file ){
                        $process.text('已上传');
                       }).on( 'uploadError', function( file ) {
                        $process.text('上传出错');
                       }).on( 'uploadComplete', function( file ) {//上传完成
                        $process.text('上传成功!');
                       }).on('uploadAccept',function(obj,data){
                        try{
                          var json = $.parseJSON(data._raw);
                          switch(json.status){
                            case 'ok':
                             $imgIpt.val(json.data.url);
                             $imgBtn.hide();
                             $imgRest.button().show().on('click',function(){
                               $uploader.reset();
                               $imgBtn.show();
                               $img.removeAttr('src').hide();
                               $(this).hide();
                               $process.width(0).text('');
                             });
                             $img.attr(
                               'src',''.concat(
                                 $.website.path.temp.replace(new RegExp($.website.path.root),''),
                                 '/',
                                 json.data.url
                               )
                             ).show().on('mouseup',function(){
                               $('<div/>')
                               .attr('title','图片')
                               .append(
                                 $('<img/>').css({'vertical-align':'middle','margin':'0 auto'}).width(300)
                                 .attr('src',$(this).attr('src'))
                               ).dialog({modal:true,width:300});
                             });
                            break;
                            default:
                              $.alert(json.data);
                              $uploader.removeFile(obj.file,true);
                              $uploader.reset('');
                              $process.text();
                              $imgRest.hide();
                          }
                        }catch(e){
                          $.alert('错误：'.concat(e));
                          $uploader.removeFile(obj.file,true);
                          $uploader.reset();
                          $process.text('');
                          $imgRest.hide();
                         //  alert(data._raw);
                        }
                      });
                  $win.dialog({
                    width:800,
                    height:500,
                    buttons     : {
                    '保 存':function(){
                      var $dialog = $(this);
                      $.servers({
                            type:'post',
                            data:{
                                act:'content-links-insert',
                                tid     : $treeData.id,
                                color   : $color.val(),
                                target  : $target.val(),
                                tit     : $tit.val(),
                                href    : $href.val(),
                                image   : $imgIpt.val(),
                                cont    : $cont.val()
                            },
                            success:function(json){
                                //测试alert(json.sql);
                                if(json.status != 'ok'){
                                    $.alert(json.data);
                                }else{
                                  $tit.val('');
                                  $href.val('');
                                  $image.val('');
                                  $cont.val('');
                                  $.alert(json.data,2);
                                  $table.find('tfoot a:contains(跳转)')
                                        .trigger('click');
                                }
                            }
                        });//servers
                    },
                    '关闭':function(){
                      $(this).dialog("destroy");
                    }
                  }
                  });//dialog
                });//$win.load
              }
            },
            end         : function(table){
                table.data('tfoot').find('a[title="添加链接"]').button({
                  icons: {
                    primary: "ui-icon-plus"
                  }
                });
            },
            func        : function(tr){
              //排序功能
              var $btnUp = $('<b>升</b>'),
                  $btnDown=$('<b>降</b>');
              //tr.find('.field-sort span.txt').css({display:'block'});
              tr.find('.field-sort span.txt').append($btnUp).append($btnDown);
              $btnUp.button().on('click',{tr:tr},function(e){
                e.preventDefault();
                var id  = e.data.tr.find('span.field-id').text(),
                    sort= e.data.tr.find('span.field-sort').text();
                if(Number(sort)-1 > 0){
                  $.servers({
                    type:'post',
                    data:{
                        act : 'content-links-sort',
                        lid : id,
                        sort: Number(sort)-1
                    },
                    success:function(json){
                      $.alert(json.data);
                    }
                  });
                }
              }).css('margin','0 5px');
              $btnDown.button().on('click',{tr:tr},function(e){
                e.preventDefault();
                var id  = e.data.tr.find('.field-id span.txt').html(),
                    sort= e.data.tr.find('.field-sort span.txt').attr('title');
                  $.servers({
                    type:'post',
                    data:{
                        act:'content-links-sort',
                        lid : id,
                        sort: Number(sort)+1
                    },
                    success:function(json){
                      alert(json.data);
                    }
                  });
              });
              // //编辑删除
              tr.find('.table-ctrl a[title="编辑"]').button({
                  icons: {primary: 'ui-icon-wrench'}
              });
              tr.find('.table-ctrl a[title="删除"]').button({
                  icons: {primary: 'ui-icon-close'}
              });
              // 图片
              var $img = tr.find('td.field-image span'),
                  img  = $img.text();
              if(img){
                $img.empty()
                .append(
                  $('<img/>').attr('src',img)
                             .css({'vertical-align':'middle',width:'auto',height:'50px'})
                             .on('click',function(){
                               $('<div>').attr('title','显示图片').append($('<img>').attr('src',img).css({width:'100%',height:'auto'}))
                               .dialog({width:500,height:300});
                             })
                );
              }
            }
        });
      }
    });//types
  });//load
}

// 网站文章内容管理
function ContArticle(event,ui){
  var id           = 1,//编辑器ID 每次加载递增
      editorConfig = {//编辑器初始化
        autoHeight:false,
        initialFrameWidth:900
      },
      $treeData,//左侧被选中元素相关数据
      $treeAct;//左侧被选中元素
  ui.newPanel.load('fragment.html .mod-links',function(){
    var $type = $(this).find('.mod-links-left'),
        $cont = $(this).find('.mod-links-right');
    $cont.width($(this).width()-$type.width()-20);
    $type.types({
      data:{upid:$.website.tid.aritcle},
      click:function(that){
        var fields  = {
              id:'编号',
              tit:'标题',
              createtime:'更新时间',
              click:'点击量',
              pg:'总页数'
            },
            search = fields;
        $treeData= that._active.data('args');
        $treeAct = $(this);
        $cont.paging({
          tb          : 'article',
          checkbox    : 0,
          num         : 10,
          fields      : fields,
          search      : search,
          where       : 'tid = '.concat($treeData.id),
          desc        : 'id desc',
          editBtns    : {
            '编辑'  : new_edit_article,
            '删除': function(evt){
              var aid     = evt.data.tr.find('.field-id span').text(),
                  $table  = evt.data.tr.parents('table:first'),
                  $dialog = $('<div />')
                            .attr('title','确认删除')
                            .text('是否真的要删除'.concat(evt.data.tr.find('.field-tit span').text(),'?'))
                            .dialog({
                    'modal':true,
                    'buttons':[
                      {
                        text  : '确认',
                        click : function(){
                          var $this = $(this);
                          $.servers({
                            data:{act:'content-article-delete','aid':aid},
                            success:function(json){
                              if(json.status != 'ok'){$.alert(json.data);return;}
                              $this.dialog('destroy');
                              evt.data.tr.parents('table:eq(0)')
                                         .find('tfoot a:contains(跳转)')
                                         .trigger('click');
                            }
                          });//servers
                        }
                      },
                      {
                        text  : '取消',
                        click : function(){$(this).dialog('destroy');}
                      }
                    ]
                  });

            }
          },
          footBtns    : {
            '新建文章'  : new_edit_article
          },
          end         : function(table){
            table.data('tfoot').find('a[title="新建文章"]').button({
              icons: {
                primary: "ui-icon-plus"
              }
            });
          },
          func        : function(tr){
            var times = tr.find('td.field-createtime span');
            times.text($.formatime('%Y-%M-%D',times.text()));
            //编辑删除
            tr.find('.table-ctrl a[title="编辑"]').button({
                icons: {primary: 'ui-icon-wrench'}
            });
            tr.find('.table-ctrl a[title="删除"]').button({
                icons: {primary: 'ui-icon-close'}
            });
            var tit = tr.find('td.field-tit span').text();
            tr.find('td.field-tit span').html(
              $('<a/>').attr('target','_blank')
                       .attr('href','/act.php?act=article&aid='.concat(tr.find('td.field-id span').text()))
                       .text(tit)
            );
          }
        });//paging
      }
    });//types
  });//load

  // 新建或编辑文章
  function new_edit_article(evt){
    var table = evt.data.tr?evt.data.tr.parents('table'):evt.data.table,
        $dialog = $('<div/>').attr('title',evt.data.tr?'编辑文章':'新建文章'),
        $article,
        editor;
    $dialog.load('fragment.html .mod-article',function(){
      var $this = $(this),
          date  = new Date(),
          $tit  = $this.find('.tit input'),
          $source  = $this.find('.source input'),
          $editors  = $this.find('.editor input'),
          $tid  = $this.find('.tid select').attr('tid',$treeData.id),
          $tag  = $this.find('.tag input'),
          $timeClick = $this.find('.time-click'),
          $ctime= $timeClick.find('input:first').val(''.concat(date.getFullYear(),'-',date.getMonth()+1,'-',date.getDate())),
          $click= $timeClick.find('input:last'),
          editId= 'container_'.concat(id),
          $cont = $this.find('.article script').attr('id',editId),
          // 简介
          $note = $this.find('li.note textarea'),
          $nchecked = $this.find('li.note-check label:last').on('click',function(){
            var $ipt = $(this).find('input');
            if($ipt.is(':checked')){
              $note.hide();
            }else{
              $note.show();
            }
          }),
          // 副标题
          $tits = $this.find('li.tits'),
          $titsList = $this.find('li.tits-list'),
          // 缩略图相关
          $image    = $this.find('.image'),
          $img      = $image.find('img'),
          $uploadBtn= $image.find('a').on('click',function(){$uploader.reset();}),
          $checked  = $image.find('label:last').on('click',function(){
            var $ipt = $(this).find('input');
            if($ipt.is(':checked')){
              $uploadBtn.hide();
              $img.hide();
              $process.hide();
            }else{
              $uploadBtn.show();
              $process.show();
              $img.show();
            }
          }),
          $process  = $image.find('span'),
          $uploader = WebUploader.create({
             auto:true,
             swf   : './image/upload.swf',
             server: './act.php?act=global-upload',
             pick: $uploadBtn,
             multiple:false,
             fileNumLimit:1,
             fileSizeLimit:$.website.upload.size,
             accept:{
                 title: 'Images',
                 extensions: 'gif,jpg,jpeg,png',
                 mimeTypes: 'image/*'
             }
           }).on('beforeFileQueued',function(file){
            if(file.size > $.website.upload.size){
              $.alert('图片大小超过'.concat($.website.upload.size,'K'));
            }
           }).on('uploadProgress',function( file, percentage ) {
            $process.text(percentage * 100+'%')
                    .css( 'width', percentage * 100 + 'px' );
           }).on( 'uploadSuccess', function( file ){
            $process.text('已上传');
           }).on( 'uploadError', function( file ) {
            $process.text('上传出错');
           }).on( 'uploadComplete', function( file ) {//上传完成
            $process.text('上传成功!');
           }).on('uploadAccept',function(obj,data){
            try{
              var json = $.parseJSON(data._raw);
              switch(json.status){
                case 'ok':
                 $img.attr('src',''.concat(
                   $.website.path.temp.replace(new RegExp($.website.path.root),''),
                   '/',
                   json.data.url)
                 )
                 .attr('href',json.data.url).show()
                 .on('click',function(){
                   if($img.attr('status') && !$img.attr('src')){return;}
                   $(this).attr('status','open');
                   $('<div/>')
                   .attr('title','图片')
                   .append(
                     $('<img/>').css({'vertical-align':'middle','margin':'0 auto'}).width(250)
                     .attr('src',$(this).attr('src'))
                   ).dialog({modal:true,width:300,close:function(){$img.removeAttr('status');}});
                 });
                break;
                default:
                  $.alert(json.data);
                  $uploader.removeFile(obj.file,true);
                  $uploader.reset();
                  $process.text('');
                  $imgRest.hide();
              }
            }catch(e){
              $.alert('错误：'.concat(e));
              $uploader.removeFile(obj.file,true);
              $uploader.reset();
              $process.text('');
              $imgRest.hide();
             //  alert(data._raw);
            }
          }),
          // 保存按钮
          $save= $this.find('.btn a').on('save',function(evt,aid){
            if($save.attr('status')){
              $.alert($save.attr('status'));
              setTimeout(function(){$save.removeAttr('status');},3000);
              return;
            }
            var tits = [],
                data = {
                  act:'content-article-'.concat(aid?'update':'insert'),
                  upid:$tid.find('option:selected').attr('upid'),
                  tid:$tid.find('option:selected').attr('tid'),
                  aid:aid?aid:0,
                  tit:$tit.val(),
                  source:$source.val(),
                  editor:$editors.val(),
                  tag:$tag.val(),
                  time:$ctime.val(),
                  click:$click.val(),
                  image:$checked.find('input').is(':checked')?'':$img.attr('href'),
                  checked:$checked.find('input').is(':checked')?1:0,
                  note:$note.val(),
                  nchecked:$nchecked.find('input').is(':checked')?1:0,
                  article:editor.getContent()
            };
            $titsList.find('input').each(function(i){
              tits.push($(this).val());
            });
            data.tits = JSON.stringify(tits);
            $.servers({
              type:'post',
              data:data,
              success:function(json){
                $save.removeAttr('status');
                if(json.status != 'ok'){$.alert(json.data);return;}
                if(!aid){
                  $tit.val('');
                  $tag.val('');
                  $click.val(1);
                  if(!$checked.find('input').is(':checked')){
                    $img.removeAttr('href')
                        .removeAttr('src');
                  }
                  editor.setContent('');
                  $.alert('文章新建成功!');
                }else{
                  $.alert('文章编辑成功!');
                  $dialog.dialog('destroy');
                }
                table.find('tfoot a:contains(跳转)').trigger('click');

              }
            });//servers
          });//save
      // 分类下拉
      $.servers({
        data:{act:'global-type-next','tid':$.website.tid.aritcle},
        success:function(json){
          if(json.status != 'ok'){$.alert(json.data);return;}
          var $select = $tid.detach();
          $.each(json.data,function(){
            if(parseInt(this.num) > 0 && this.next){
              var $optgroup = $('<optgroup/>')
                              .attr('label',this.tit)
                              .attr('tid',this.id)
                              .attr('upid',this.upid);
              $.each(this.next,function(){
                $optgroup.append(
                  $('<option/>')
                    .attr('value',this.id)
                    .attr('tid',this.id)
                    .attr('upid',this.upid)
                    .text(this.tit)
                );
              });
              $select.append($optgroup);
            }else{
              $select.append(
                $('<option/>')
                  .attr('value',this.id)
                  .attr('tid',this.id)
                  .attr('upid',this.upid)
                  .text(this.tit)
              );
            }
          });
          $select.appendTo($this.find('.tid'))
                .val($select.attr('tid'))
                // .find('option[tid="'.concat($select.attr('tid'),'"]')).attr("selected",'selected')
                .selectmenu({width:250});
        }
      });
      // 为了自适应编辑器高度
      $article = $this;
      editorConfig = $.extend(editorConfig,{initialFrameHeight:$this.outerHeight()-220});
      editor= UE.getEditor(editId,editorConfig);
      id++;
      $ctime.datepicker({
        dateFormat: 'yy-mm-dd',
        monthNames: ['一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月'],
        dayNamesMin  : ['日','一','二','三','四','五','六']
      });
      if(evt.data.tr){//编辑文章---需要获取别选文章所有内容
        // 所有内容为不能编辑状态
        $save.attr('status','读取编辑数据中...');
        $checked.find('input').trigger('click');
        var aid = evt.data.tr.find('.field-id span').text();
        $.servers({
          data:{act:'content-article-get',aid:aid},
          success:function(json){
            $save.removeAttr('status');
            if(json.status != 'ok'){$.alert(json.data);return;}
            $tit.val(json.data.tit);
            $editors.val(json.data.editor);
            $source.val(json.data.source);
            $tag.val(json.data.tag);
            $click.val(json.data.click);
            $ctime.val($.formatime('%Y-%M-%D',json.data.createtime));
            $img.attr('src',json.data.image)
                .attr('href',json.data.image);
            editor.ready(function(){
              editor.setContent(json.data.article);
              // editor.setHeight($article.outerHeight()-180);
            });
            $note.val(json.data.note);
            $save.on('click',function(){
              $(this).trigger('save',[aid]);
            });
            var $ulTits = $titsList.find('ul'),
                time = setInterval(function(){
              if($ulTits.attr('status') == 'ok'){
                var $ipts = $ulTits.find('input');
                $.each(json.data.tits,function(i){
                  $($ipts[i]).val(json.data.tits[i]);
                });
                clearInterval(time);
              }
            },1000);
          }
        });//get article
      }else if(evt.data.table){//新建文章
        $save.on('click',function(){$(this).trigger('save');});
      }else{
        $.alert('似乎出错了.');
      }
    }).dialog({
      maximize:1,
      minimize:1,
      appendTo:$('body'),
      width:1170,
      height:500,
      open:function(event,ui){
        var $this = $(this),
            tm    = setInterval(function(){
              if(editor && $this.length){
                var $titsList= $article.find('ul.list li.tits-list ul'),
                    $page = $article.find('ul.list li.tits span');
                editor.ready(function(){
                  editor.setHeight($article.outerHeight()-180);
                  var cont = editor.getContent();
                      page = (cont.split(/<hr\/>/)).length,
                      len  = $titsList.find('li').length,
                      num  = page-len;
                  if($page.text() != page){$page.text(page);}

                  if(num>0){
                    $titsList.detach();
                    for(i=len;i<page;i++){
                      $titsList.append(
                        $('<li/>').append($('<label/>').addClass('lab'))
                                  .append($('<input/>').attr('type','text'))
                                  .append($('<a/>').button({
                                            icons:{primary:'ui-icon-minus',text:false}
                                          }).on('click',function(){$(this).parent().remove();})
                                  )
                      );
                    }
                    $titsList.attr('status','ok');
                    $article.find('ul.list li.tits-list').append($titsList);
                    $article.find('ul.list li.tits-list label').each(function(i){
                      $(this).text('第'.concat(i+1,'页：'));
                    });
                  }
                });
              }else if(!$this.length){
                clearInterval(tm);
              }
            },1000);
      }
    }).trigger('resize');//load
  }//新建或编辑文章

}

// 图片内容管理
function ContImage(event,ui){
  var $treeData,//左侧被选中元素相关数据
      $treeAct;//左侧被选中元素
  ui.newPanel.load('fragment.html .mod-links',function(){
    var $type = $(this).find('.mod-links-left'),
        $cont = $(this).find('.mod-links-right');
    $cont.width($(this).width()-$type.width()-20);
    $type.types({
      data:{upid:$.website.tid.image},
      click:function(that){
        var fields  = {
              id:'编号',
              tit:'标题',
              createtime:'更新时间',
              click:'点击量',
              pg:'总页数'
            },
            search = fields;
        $treeData= that._active.data('args');
        $treeAct = $(this);
        $cont.paging({
          tb          : 'article',
          checkbox    : 0,
          num         : 10,
          fields      : fields,
          search      : search,
          where       : 'tid = '.concat($treeData.id),
          desc        : 'id desc',
          editBtns    : {
            '编辑'  : new_edit_image,
            '删除': function(evt){
              var aid     = evt.data.tr.find('.field-id span').text(),
                  $table  = evt.data.tr.parents('table:first'),
                  $dialog = $('<div />')
                            .attr('title','确认删除')
                            .text('是否真的要删除'.concat(evt.data.tr.find('.field-tit span').text(),'?'))
                            .dialog({
                    'modal':true,
                    'buttons':[
                      {
                        text  : '确认',
                        click : function(){
                          var $this = $(this);
                          $.servers({
                            data:{act:'content-image-delete','aid':aid},
                            success:function(json){
                              $this.dialog('destroy');
                              if(json.status != 'ok'){$.alert(json.data);return;}
                              evt.data.tr.parents('table:eq(0)')
                                         .find('tfoot a:contains(跳转)')
                                         .trigger('click');
                            }
                          });//servers
                        }
                      },
                      {
                        text  : '取消',
                        click : function(){$(this).dialog('destroy');}
                      }
                    ]
                  });

            }
          },
          footBtns    : {
            '新建图片'  : new_edit_image
          },
          end         : function(table){
            table.data('tfoot').find('a[title="新建图片"]').button({
              icons: {
                primary: "ui-icon-plus"
              }
            });
          },
          func        : function(tr){
            var times = tr.find('td.field-createtime span');
            times.text($.formatime('%Y-%M-%D',times.text()));
            //编辑删除
            tr.find('.table-ctrl a[title="编辑"]').button({
                icons: {primary: 'ui-icon-wrench'}
            });
            tr.find('.table-ctrl a[title="删除"]').button({
                icons: {primary: 'ui-icon-close'}
            });
            var tit = tr.find('td.field-tit span').text(),
                href= $treeData.id == '5700'?'http://m.qiaoxiao.com/act.php?act=gpicture&pid=':'/act.php?act=picture&pid=';
            tr.find('td.field-tit span').html(
              $('<a/>').attr('target','_blank')
                       .attr('href',href.concat(tr.find('td.field-id span').text()))
                       .text(tit)
            );
          }
        });//paging
      }
    });//types
  });//load

  // 新建编辑图片
  function new_edit_image(evt){
    $('<div/>').load('fragment.html .mod-cont-image',function(){
      var aid     = evt.data.tr?evt.data.tr.find('.field-id span').text():false,
          $table  = aid?evt.data.tr.parents('table:first'):evt.data.table,
          $this   = $(this).attr('title',aid?'编辑图片':'新建图片'),
          $tit    = $this.find('.ctrl .tit input'),
          $tag    = $this.find('.ctrl .tag input'),
          $tid    = $this.find('.ctrl .tid select').attr('tid',$treeData.id),
          $source    = $this.find('.ctrl .source input'),
          $editor    = $this.find('.ctrl .editor input'),
          date  = new Date(),
          $ctime    = $this.find('.ctrl .time input').val(''.concat(date.getFullYear(),'-',date.getMonth()+1,'-',date.getDate())),
          $click    = $this.find('.ctrl .click input'),
          $image    = $this.find('.ctrl li.image'),
          $imageBtn = $this.find('.ctrl li.image-btn'),
          $process  = $imageBtn.find('span'),
          smallUploader = WebUploader.create({
              auto:true,
              swf   : './image/upload.swf',
              server: './act.php?act=global-upload',
              pick: $imageBtn.find('a'),
              multiple:false,
              fileNumLimit:100,
              fileSizeLimit:$.website.upload.size,
              accept:{
                  title: 'Images',
                  extensions: 'gif,jpg,jpeg,png',
                  mimeTypes: 'image/*'
              }
            }).on('beforeFileQueued',function(file){
             if(file.size > $.website.upload.size){
               $.alert('图片大小超过'.concat($.website.upload.size/1024,'KB'));
             }
            }).on('uploadProgress',function( file, percentage ) {
             $process.text(percentage * 100+'%')
                     .css( 'width', percentage * 100 + 'px' );
            }).on( 'uploadSuccess', function( file ){
             $process.text('已上传');
            }).on( 'uploadError', function( file ) {
             $process.text('上传出错');
            }).on( 'uploadComplete', function( file ) {//上传完成
             $process.text('上传成功!');
            }).on('uploadAccept',function(obj,data){
             try{
               var json = $.parseJSON(data._raw);
               switch(json.status){
                 case 'ok':
                  $imageBtn.find('img').attr('src',''.concat(
                    $.website.path.temp.replace(new RegExp($.website.path.root),''),
                    '/',
                    json.data.url)
                  ).attr('href',json.data.url);
                 break;
                 default:
                   $.alert(json.data);
                   smallUploader.removeFile(obj.file,true);
                   smallUploader.reset('');
                   $process.text();
               }
             }catch(e){
               $.alert('错误：'.concat(e));
               smallUploader.removeFile(obj.file,true);
               smallUploader.reset();
               $process.text('');
              //  alert(data._raw);
             }
           }),
          $note    = $this.find('.ctrl .note textarea'),
          // 上传图片
          $select = $this.find('.ctrl .uploads a.select'),
          $pause  = $this.find('.ctrl .uploads a.pause'),
          $save   = $this.find('.ctrl .save a:first'),
          $delete = $this.find('.ctrl .save a:eq(1)'),
          $list   = $this.find('.list'),
          $images = $list.find('.images'),
          uploader  = WebUploader.create({
            auto:true,
            swf   : './image/upload.swf',
            server: './act.php?act=global-upload',
            pick: $select,
            resize: false,
            multiple:true,
            fileNumLimit:100,
            fileSizeLimit:$.website.upload.size,
            accept:{
              title: 'Images',
              extensions: 'gif,jpg,jpeg,png',
              mimeTypes: 'image/*'
            }
          }).on('beforeFileQueued',function(file){
            if(file.size > $.website.upload.size){
              $.alert('图片大小超过'.concat($.website.upload.size,'K'));
            }else{
              uploader.makeThumb( file, function( error, ret ) {
                if (!error){
                  $images.append(
                    $('<li/>').attr('id',file.id)
                    .append($('<img/>').attr('src',ret))
                    .append(
                      $('<a/>').text('×').addClass('close')
                      .on('click',function(){
                        uploader.removeFile(file,true);
                        $(this).parent().remove();
                      })
                    ).append($('<p/>')).addClass('img')
                  );
                }
              });
            }
          }).on('uploadStart',function(file){
            $('#'.concat(file.id,' p')).show();
          }).on('uploadProgress',function( file, percentage ) {
            $('#'.concat(file.id,' p')).text(percentage * 100+'%')
                 .css( 'width', percentage * 100 + 'px' );
          }).on( 'uploadSuccess', function( file ){
            $('#'.concat(file.id,' p')).text('已上传');
          }).on( 'uploadError', function( file ) {
            $('#'.concat(file.id,' p')).text('上传出错');
          }).on( 'uploadComplete', function( file ) {//上传完成
            $('#'.concat(file.id,' p')).text('上传成功!');
          }).on('uploadAccept',function(obj,data){
            var $img = $('#'.concat(obj.file.id));
              try{
               var json = $.parseJSON(data._raw);
               switch(json.status){
                 case 'ok':
                  $img.find('img').attr(
                    'href',''.concat(
                      $.website.path.temp.replace(new RegExp($.website.path.root),''),
                      '/',
                      json.data.url
                    )
                  );
                 break;
                 default:
                   $.alert(json.data);
                   $img.find('p').hide();
                   $img.append(
                       $('<a/>')
                       .addClass('reset')
                       .text('重新上传')
                       .on('click',function(){
                         $(this).remove();
                         uploader.upload(obj.file);
                       })
                    );
               }
              }catch(e){
               $.alert('错误：'.concat(e));
               $img.find('p').hide();
               $img.append(
                   $('<a/>')
                   .addClass('reset')
                   .text('重新上传')
                   .on('click',function(){
                     $(this).remove();
                     uploader.upload(obj.file);
                   })
                );
              //  alert(data._raw);
              }
            });
      // 图片排序
      $images.sortable();
      $images.disableSelection();
      // 图片停止上传
      $pause.on('click',function(){uploader.stop();});
      // 缩略图
      $image.find('input').on('change',function(){
        if($(this).prop('checked')){
          $imageBtn.hide();
        }else{
          $imageBtn.show();
        }
      });
      $imageBtn.find('a:first').on('click',function(){smallUploader.reset();});
      // 分类下拉
      $.servers({
        data:{act:'global-type-next','tid':$.website.tid.image},
        success:function(json){
          if(json.status != 'ok'){$.alert(json.data);return;}
          var $select = $tid.detach();
          $.each(json.data,function(){
            if(parseInt(this.num) > 0 && this.next){
              var $optgroup = $('<optgroup/>')
                              .attr('label',this.tit)
                              .attr('tid',this.id)
                              .attr('upid',this.upid);
              $.each(this.next,function(){
                $optgroup.append(
                  $('<option/>')
                    .attr('value',this.id)
                    .attr('tid',this.id)
                    .attr('upid',this.upid)
                    .text(this.tit)
                );
              });
              $select.append($optgroup);
            }else{
              $select.append(
                $('<option/>')
                  .attr('value',this.id)
                  .attr('tid',this.id)
                  .attr('upid',this.upid)
                  .text(this.tit)
              );
            }
          });
          $select.appendTo($this.find('.tid'))
                .val($select.attr('tid'))
                // .find('option[tid="'.concat($select.attr('tid'),'"]')).attr("selected",'selected')
                .selectmenu({width:250});
        }
      });
      // 时间选择
      $ctime.datepicker({
        dateFormat: 'yy-mm-dd',
        monthNames: ['一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月'],
        dayNamesMin  : ['日','一','二','三','四','五','六']
      });
      // 生成窗口
      $this.dialog({
        width:1100,
        height:600,
        maximize:1,
        minimize:1,
        appendTo:$('body'),
        open:function(){
          // 保存按钮
          $save.button({icon:'ui-icon-disk'}).on('click',function(){
            if($save.attr('status')){
              $.alert($save.attr('status'));
              setTimeout(function(){$save.removeAttr('status');},3000);
              return;
            }
            $save.attr('status','数据正在保存中...');
            var imgs=[];
            $list.find('img').each(function(){
              if($(this).attr('href') && !$(this).attr('aid')){
                imgs.push($(this).attr('href'));
              }
            });
            if(!$tit.val()){
              $.alert('请输入图片标题!');
              return;
            }
            $.servers({
              type:'post',
              data:{
                act : 'content-image-'.concat(aid?'update':'insert'),
                imgs: JSON.stringify(imgs),
                tit : $tit.val(),
                tid : $tid.find('option:selected').attr('tid'),
                aid : aid?aid:0,
                source:$source.val(),
                editor:$editor.val(),
                tag:$tag.val(),
                time:$ctime.val(),
                click:$click.val(),
                image:$image.find('input').is(':checked')?'':$imageBtn.attr('href'),
                checked:$image.find('input').is(':checked')?1:0,
                note:$note.val(),
              },
              success:function(json){
                $save.removeAttr('status');
                $.alert(json.data,3);
                if(json.status == 'ok'){
                  uploader.reset();
                  $table.find('tfoot a:contains(跳转)').trigger('click');
                  if(aid){$this.dialog('destroy');return;}
                  $delete.trigger('click');
                  $tit.val('');
                  $tag.val('');
                  $note.val('');
                  $image.find('input').prop('checked',true);
                  $imageBtn.find('img')
                  .removeAttr('src')
                  .removeAttr('href');
                }
              }
            });
          });
          // 清空按钮
          $delete.button({icon:'ui-icon-trash'}).on('click',function(){
            $.each($images.find('li'),function(){
              $(this).find('a.close').trigger('click');
            });
          });
          // 编辑加载
          if(aid){
            $.servers({
              data:{act:'content-image-select',aid:aid},
              success:function(json){
                if(json.status != 'ok'){$.alert(json.data,3);return;}
                $tit.val(json.data.tit);
                $tag.val(json.data.tag);
                $source.val(json.data.source);
                $editor.val(json.data.editor);
                $ctime.val($.formatime('%Y-%M-%D',json.data.createtime));
                $click.val(json.data.click);
                $note.val(json.data.note);
                $imageBtn.find('img').attr('src',json.data.image)
                      .attr('href',json.data.image);
                $.each(json.data.img,function(){
                  $images.append(
                    $('<li/>')
                    .append($('<img/>').attr('src',this.img).attr('href',this.img))
                    .append(
                      $('<a/>').text('×').addClass('close')
                      .on('click',function(){
                        $(this).parent().remove();
                      })
                    )
                    .append($('<p/>'))
                    .addClass('img')
                  );
                });
              }
            });
          }
        }
      });
    });
  }

}
