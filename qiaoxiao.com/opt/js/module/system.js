// System系统控制


//分类管理
function SysType(event,ui,bool){
    ui.newPanel.load('fragment.html .b-types',function(){
        var $left   = $(this).find("div.b-types-left"),
            $right  = $(this).find("div.b-types-right"),
            height  = ui.newPanel.height(),
            width   = ui.newPanel.width(),
            actIpt  = {},
            data    = {},
            $click,
            $add    = $('#b-types-add'),
            $edit   = $('#b-types-mend'),
            $del    = $('#b-types-del');
            func    = function(){
              $click = $(this);
              var up  = $(this).parents("ul:eq(0)").prev();
              data = $(this).data('data');
              data.up = up;
              $add.find('input:eq(0)').val(data.tit);
              if(up.length){
                  $edit.find('input:eq(0)')
                        .val(up.data('data').tit)
                        .attr('upid',up.data('data').upid)
                        .attr('tid',up.data('data').id);
              }else{
                  data.upid = 0;
                  $edit.find('input:eq(0)')
                      .val('顶级类')
                      .attr('upid',0)
                      .attr('tid',data.id);
              }
              $add.find('input:eq(0)').attr('upid',data.upid)
                                      .attr('tid',data.id);

              $edit.find('label:eq(0)').text(data.id);
              $edit.find('input:eq(1)').val(data.tit);
              $edit.find('input:eq(2)').val(data.tp);
              $edit.find('input:eq(3)').val(data.cont);

              $del.find('input:eq(0)').val(data.tit);
            };
        ui.newPanel.css('overflow','hidden');
        $left.height(height);
        $right.css({width:''.concat(width-$left.outerWidth()-20,'px'),height:''.concat(height,'px')});
        $right.find('div:eq(0)').tabs({heightStyle:'fill',collapsible:1});
        $(window).on('resize',function(){$right.find('div:eq(0)').tabs({heightStyle:'fill'});});
        $del.find('input:eq(0)').attr('readonly','readonly');

        //显示分类树
        $left.tree({
            upid:0,
            click:func
        });
        //顶级类设置
        $right.find('form a:contains("顶级类")').button().on('click',function(){
                $(this).prev().val('顶级类');
                $(this).prev()
                .attr('tid',0)
                .attr('upid',0);
                data.tit    = '顶级类';
                data.upid   = 0;
                data.tid    = 0;
        }).css({margin:'0 0 5px 0',height:'22px','line-height':'36px','font-size':'13px'});

        //弹出类别选择框-定位
        $('#b-types-add input:eq(0),#b-types-mend input:eq(0)').on('mousedown',function(){
            var actIpt   = $(this);
            $('.b-types-tree').show().empty().position({
                my  : 'left top',
                at  : 'left bottom-1',
                of  : actIpt
            }).tree({
                upid    : 0,
                click   : function(){
                    var datas    = $(this).data('data');
                    actIpt.val(datas.tit);
                    switch($right.find('div:eq(0)').tabs('option','active')){
                        case 0:
                          $('#b-types-add input:eq(0)').attr('tid',datas.upid);
                          break;
                        case 1:
                          $('#b-types-mend input:eq(0)')
                          .attr('tid',datas.id)
                          .attr('upid',datas.upid);
                    }

                }
            });
            return false;
        });
        $(document.body).on('mousedown',function(){$('.b-types-tree').hide();});
        $right.find('form').on('submit',function(evt){evt.parentDefault();});
        //添加提交
        $add.find('button').button({icons:{primary:"ui-icon-disk"}}).on('click',function(){
            var $this   = $(this).parents('form:eq(0)'),
                tit     = $this.find('input:eq(1)').val(),
                tp      = $this.find('input:eq(2)').val(),
                cont    = $this.find('input:eq(3)').val();
            if($.trim(tit) === ''){
                $('<div title="提示">请输入分类名称!</div>').dialog({
                    dialogClass : 'alert',
                    maxHeight:300,
                    modal:1,
                    buttons     : {
                        '确 定':function(){
                            $this.find('input:eq(2)').focus();
                            $(this).dialog('close');
                        }
                    }
                });
                return false;
            }

            $.servers({
                data:{
                    act     : 'system-types-insert',
                    upid    : $this.find('input:eq(0)').attr('tid'),
                    tit     : tit,
                    tp      : tp,
                    cont    : cont
                },
                type:'post',
                success:function(json){
                    if(json.status === 'ok'){
                        if(data.upid === 0){
                            $left.empty();
                            //重新显示分类树
                            $left.tree({
                                upid:0,
                                click:func
                            });
                        }else{
                            data.up.find('img:eq(0)').trigger('mousedown').trigger('mousedown');
                        }
                        $this.find('input:eq(1)').val('').focus();
                        //$this.find('input:eq(2)').val('');
                        //$this.find('input:eq(3)').val('');
                        $.alert(json.data,3);
                    }else{
                        $.alert(json.data);
                    }
                }
            });
            return false;
        });
        //提交修改
        $edit.find('button').button({icons:{primary:"ui-icon-disk"}}).on('click',function(){
            var $this   = $(this).parents('form:eq(0)'),
                tid     = $this.find('label:eq(0)').text(),
                oUpid   = $left.find('a[tid="'.concat(tid,'"]')).attr('upid'),
                //新的上级ID
                nUpid    = $this.find('input:eq(0)').attr('tid');
            $.servers({
                data:{
                    act     : 'system-types-update',
                    tid     : tid,
                    upid    : nUpid,
                    tit     : $this.find("input:eq(1)").val(),
                    tp      : $this.find("input:eq(2)").val(),
                    cont    : $this.find("input:eq(3)").val()
                },
                type:'post',
                success:function(json){
                    if(json.status === 'ok'){
                        if(data.upid === 0){
                            $left.empty();
                            //重新显示分类树
                            $left.tree({
                                upid:0,
                                click:func
                            });
                        }else{
                          data.up.find('img:eq(0)').trigger('mousedown').trigger('mousedown');
                          if(oUpid != nUpid){
                            var $nUp  = $left.find('a[tid="'.concat(nUpid,'"]')),
                                nNum  = Number($nUp.attr('num'))+1,
                                $oUp  = $left.find('a[tid="'.concat(oUpid,'"]')),
                                oNum  = Number($oUp.attr('num'))-1;
                            $nUp.attr('num',nNum);
                            $nUp.find('img').attr('src','/opt/image/plus.gif');
                            $oUp.attr('num',oNum < 0 ? 0 : oNum);
                            if(oNum < 1){
                              $oUp.find('img').attr('src','/opt/image/minus.gif');
                            }
                          }
                        }
                        $.alert(json.data);
                    }else{
                      $.alert(json.data);
                    }
                }
            });
            return false;
        });
        //删除
        $del.find('a:eq(0)').button().on('click',function(){
            var $this   = $(this).parents('form:eq(0)');
            $('<div title="提示">是否真的删除 '.concat(data.tit,' </div>')).dialog(
                {
                    dialogClass : 'alert',
                    maxHeight:300,
                    modal:1,
                    buttons     : {
                        '确 定':function(){
                            $.servers({
                                data:{
                                    act     : 'system-types-delete',
                                    tid     : data.id
                                },
                                type:'post',
                                success:function(json){
                                    switch(json.status){
                                        case 'ok':
                                            $this.find('input:eq(0)').val("");
                                            if(data.up.find('img:eq(0)').length){
                                                data.up.find('img:eq(0)').trigger('mousedown').trigger('mousedown');
                                            }else{
                                                $left.empty().tree({
                                                    upid:0,
                                                    click:func
                                                });
                                            }
                                            break;
                                        // case 'error':
                                        default:
                                            $.alert({cont:json.data});
                                    }
                                }
                            });
                            $(this).dialog('close');
                        },
                        '取 消':function(){
                            $(this).dialog('close');
                        }
                    }
                }
            );

            return false;
        });

    });
}

//缓存管理
function SysCache(event,ui){

}

//系统信息
function SysInfo(event,ui){
    $.servers({
        data    : {act:'system-info-get'},
        type    : 'post',
        success : function(json){
            if(json.status != 'ok'){$.alert(json.data,2);return false;}
            var data    = json.data,
                cpu     = '<fieldset><legend>CPU信息</legend><ul>',
                cpuUsed = '<fieldset><legend>CPU使用情况</legend><ul>',
                hard    = '<fieldset><legend>硬盘使用情况</legend><ul>',
                memory  = '<fieldset><legend>内存使用情况</legend><ul>',
                html    = '',i;

            for(i in data.cpu){
                var arr = data.cpu[i].split(':');
                cpu = cpu.concat(
                        '<li>',
                        '<span>',
                        arr[0],
                        '：</span>',
                        arr[1],
                        '</li>'
                );
            }
            html = html.concat(cpu,'</ul></fieldset>');

            for(i in data.cpuUsed){
                var arrs = data.cpuUsed[i].split(':');
                cpuUsed = cpuUsed.concat(
                        '<li>',
                        '<span>',
                        arrs[0],
                        '：</span>',
                        (Math.floor(arrs[1]*1000))/1000,'%</li>'
                );
            }
            html = html.concat(cpuUsed,'</ul></fieldset>');

            for(i in data.hard){
                var arrt = data.hard[i].split(',');
                for(var j in arrt){
                    var arrTwo = arrt[j].split(':');
                    hard = hard.concat(
                            '<li>',
                            '<span>',
                            arrTwo[0],
                            '：</span>',
                            arrTwo[1],'</li>'
                    );
                }
            }
            html = html.concat(hard,'</ul></fieldset>');

            for(i in data.memory){
                if(i>1){break;}
                var arrf = data.memory[i].split(':'),
                    mb  = arrf[1].replace(/\s*/,'');
                    mb  = arrf[1].replace(/ kB/,'');

                memory = memory.concat(
                        '<li>',
                        '<span>',
                        arrf[0],
                        '：</span>',
                        Math.floor(mb/1024),
                        mb>0?'MB':'',
                        '</li>'
                );
            }
            html = html.concat(memory,'</ul></fieldset>');



            ui.newPanel.append(html);
        }
    });
}

//网站修复
function SysRestore(event,ui){
    var $restore =$('<a>网站分类修复</a>');
    ui.newPanel.append($restore);
    //分类修复
    $restore.button({
      icons: {
        primary: "ui-icon-calculator"
      }
    }).on('click',function(){
        $.servers({
            data    : {act:'system-restore-type'},
            success : function(json){
                $.alert({cont:json.data});
            }
        });
    });
}

//权限管理
function SysAuthority(event,ui){
    var $accordion = $("<div></div>").attr('id','SysAuthority');
    ui.newPanel.append($accordion);
    $.servers({
      data    : {act:'system-authority-init'},
      type    : 'post',
      success : function(json){
        if(json.status != 'ok'){$.alert({cont:json.data});return;}

        $.each(json.data,function(){
          var $h3 = $('<h3></h3>').text(this.nick.concat('(',this.authority,')')),
              $div= $('<div></div>'),
              user=this;
          $accordion.append($h3).append($div);

          $.each(this.module,function(){
            var $ul = $('<ul></ul>')
                      .append(
                        $('<li></li>').append(
                          $('<label></label>')
                          .text(this.tit)
                          .attr('tid',this.id).attr('uid',user.id)
                          .prepend($('<input type="checkbox" />').prop('checked',this.authority))
                        )
                      ),
                $li = $('<li class="next"></li>');
            $div.append($ul.append($li));
            $.each(this.next,function(){
                var $label = $('<label></label>')
                              .text(this.tit)
                              .attr('tid',this.id).attr('uid',user.id)
                              .prepend($('<input type="checkbox" />').prop('checked',this.authority));
                $li.append($label);
            });
          });
        });
        //设置权限
        $accordion.find('label').on('click',function(){
          $.servers({
            data    : {
              act:'system-authority-set',
              uid:$(this).attr('uid'),
              tid:$(this).attr('tid'),
              authority:$(this).find('input').prop('checked')
            },
            type    : 'post',
            success : function(json){
              if(json.status != 'ok'){
                $.alert(json.data);
              }
            }
          });
        });
        $accordion.accordion();
      }
    });
}

//后台模块控制
function SysModule(event,ui){
  ui.newPanel.load('fragment.html .mod-module',function(){
      var $left   = $(this).find("div.b-types-left"),
          $right  = $(this).find("div.b-types-right"),
          height  = ui.newPanel.height(),
          width   = ui.newPanel.width(),
          $this   = $(this),
          $nowTree,
          $add = $('#module-add'),
          $med = $('#module-med'),
          $del = $('#module-del'),
          $tree= $('<div></div>');

      ui.newPanel.css('overflow','hidden');
      $left.height(height);
      $right.css({width:''.concat(width-$left.outerWidth()-20,'px'),height:''.concat(height,'px')});
      $right.find('div:eq(0)').tabs({heightStyle:'fill',collapsible:1});
      $(window).on('resize',function(){$right.find('div:eq(0)').tabs({heightStyle:'fill'});});
      //顶级类设置
      $right.find('a:contains("设为顶级类")').button().on('click',function(){
        $(this).prev('input:eq(0)')
                .val('后台模块')
                .attr('tid',$.website.tid.admin);
      });



      //显示分类树
      $left.types({
          data:{upid:$.website.tid.admin},
          click:function(that){
            var args = that._active.data('args');
            // 添加
            $add.find('input:eq(0)').val(args.tit).attr('tid',args.id);
            // 修改
            $med.find('input:eq(0)').val(args.tit).attr('tid',args.id);
            $med.find('input:eq(2)').val(args.cont);
            $.servers({
              data:{act:'global-type-id',tid:args.upid},
              success:function(json){
                if(json.status!='ok'){$.alert(json.data);return false;}
                $med.find('input:eq(1)').val(json.data.tit).attr('tid',json.data.id);
              }
            });
            // 删除
            $del.find('label:eq(0)').text(args.id);
            $del.find('label:eq(1)').text(args.tit);
          }
      });

      //检测参数
      function argsTest($upid,$tit,$cont){
        if(!$upid.attr('tid')){
          $.alert('选择上级模块.',5);
          return false;
        }
        if($tit.val().length === 0){
          $.alert('请输入模块名称.',5);
          $tit.focus();
          return false;
        }
        if($cont.val().length ===0){
          $.alert('请输入正确函数名称.',5);
          $cont.focus();
          return false;
        }
        return true;
      }
      // 提交添加模块参数
      $add.find('a:contains("添加模块")')
          .button({icons: { primary:'ui-icon-plus'}})
          .on('click',function(){
            var $upid  = $add.find('input:eq(0)'),
                $tit   = $add.find('input:eq(1)'),
                $cont  = $add.find('input:eq(2)'),
                test  = argsTest($upid,$tit,$cont);
            if(test){
              $.servers({
                data:{
                  act : 'system-module-add',
                  upid: $upid.attr('tid'),
                  tit : $tit.val(),
                  cont: $cont.val()
                },
                type:'post',
                success:function(json){
                  switch(json.status){
                    case 'ok':
                      $.alert('添加模块成功!'.concat(json.data),100);
                      $tit.val('');
                      $cont.val('');
                      var key =$upid.attr('tid')==$.website.tid.admin?'init':'refresh';
                      $left.types(key);
                      break;
                    default:
                      $.alert(json.data);
                  }
                }
              });
            }
          });
      //------------------ 修改模块参数功能
      // 编辑框中的选择分类
      $tree.types({
                  data:{upid:$.website.tid.admin},
                  click:function(that){
                    var args = that._active.data('args');
                    $med.find('input:eq(1)').val(args.tit).attr('tid',args.id);
                    $tree.hide();
                  }
                })
          .on('click',function(){return false;})
          .css({border:'1px #ccc solid',padding:'5px',position:'absolute',background:'#fff',overflow:'scroll'})
          .width($med.find('input:eq(1)').width()-5)
          .height(200)
          .hide()
          .appendTo('body');
      // 编辑时选择分类
      $med.find('input:eq(1)')
          .on('click',function(){
            $tree.toggle()
            .position({
              of:$(this),
              at:'left bottom',
              my:'left top'
            });
          });
      // 提交修改模块参数
      $med.find('a:contains("修改模块")')
          .button({icons: { primary:'ui-icon-gear'}})
          .on('click',function(){
            var $upid  = $med.find('input:eq(1)'),
                $tit   = $med.find('input:eq(0)'),
                $cont  = $med.find('input:eq(2)'),
                test  = argsTest($upid,$tit,$cont);
            if($upid.attr('tid') == $tit.attr('tid')){$.alert('下级分类不能是自身!');return false;}
            if(test){
              $.servers({
                data:{
                  act : 'system-module-update',
                  upid: $upid.attr('tid'),
                  tit : $tit.val(),
                  tid : $tit.attr('tid'),
                  cont: $cont.val()
                },
                type:'post',
                success:function(json){
                  switch(json.status){
                    case 'ok':
                      $.alert('修改模块成功!'.concat(json.data),1);
                      var oldUpid = $left.types('act').data('args').upid;
                      if(oldUpid == $upid.attr('tid')){
                        $left.types('update');
                      }else{
                        var key = $upid.attr('tid')==$.website.tid.admin || oldUpid==$.website.tid.admin ?'init':'refresh';
                        $left.types(key);
                      }
                      break;
                    default:
                      $.alert(json.data);
                  }
                }
              });
            }
          });
      //------------------ 删除模块功能
      $del.find('a:contains("删除模块")')
          .button({icons: { primary:'ui-icon-close'}})
          .on('click',function(){
              var $tid = $del.find('label:eq(0)'),
                  $act = $left.types('act');
              if(!$.isNumeric($tid.text())){
                $.alert('选择左侧你需要删除的!',2);return false;
              }else if($act.data('args').num != '0'){
                $.alert('当前所选分类有子分类的，得先删除子分类!',2);
                return false;
              }
              $.servers({
                data:{
                  act:'system-module-del',
                  tid:$tid.text()
                },
                success:function(json){
                  if(json.status!='ok'){$.alert(json.data);return false;}
                  var key = $act.data('args').upid == $.website.tid.admin ?'init':'refresh';
                  $.alert(json.data,1);
                  if(key != 'init'){
                    $left.types('act').parent().parent().prev()
                         .find('span:eq(0)')
                         .trigger('click').trigger('click');
                  }else{
                    $left.types(key);
                  }
                  $del.find('label').text('');
                  $med.find('input').val('').attr('tid','');
                  $add.find('input').val('').attr('tid','');
                }
              });
          });

  });
}
