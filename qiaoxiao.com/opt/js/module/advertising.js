
// 广告渠道管理
function AdChannel(event,ui){
  var fields = {id:'编号',tit:'名称',createtime:'创建时间'};
  ui.newPanel.paging({
    tb          : 'adv_channel',
    checkbox    : 0,
    num         : 10,
    fields      : fields,
    search      : fields,
    desc        : 'id desc',
    editBtns	:{
      '编辑':insert_update,
      '删除':function(evt){
        $('<div title="确认删除">').text('是否真的删除？').dialog({
          modal:true,
          buttons:{
            '确认':function(){
              var $this = $(this);
              $.servers({
                data:{act:'adv-channel-delete',cid:evt.data.tr.find('.field-id span').text()},
                success:function(json){
                  if(json.status != 'ok'){$.alert(json.data);return;}
                  evt.data.tr.parents('table:eq(0)').find('tfoot a:contains(跳转)').trigger('click');
                  $this.dialog('close');
                }
              });
            },
            '取消':function(){$(this).dialog('close');}
          }
        });
      }
    },
    footBtns    : {
      '新建渠道':insert_update
    },
    end         : function(table){
        table.data('tfoot').find('a[title="新建渠道"]').button({
          icons: {
            primary: "ui-icon-plus"
          }
        });
    },
    func        : function(tr){
      tr.find('a:contains(编辑)').button({icon:'ui-icon-gear'});
      tr.find('a:contains(删除)').button({icon:'ui-icon-closethick'});
      var $createtime = tr.find('.field-createtime span');
      $createtime.text($.formatime('%Y-%M-%D',$createtime.text()));
    }
  });
  // 新建/编辑渠道
  function insert_update(evt){
    var cid    = evt.data.tr?evt.data.tr.find('.field-id span').text():false,
        $table = cid?evt.data.tr.parents('table:eq(0)'):evt.data.table;
    $('<div>').load('./fragment.html .mod-ad-channel',function(){
      var $this = $(this),
          $tit  = $this.find('.tit input'),
          $url  = $this.find('.url span');
      if(cid){//获取编辑数据
          $tit.val(evt.data.tr.find('.field-tit span').text());
          $url.text('http://m.qiaoxiao.com/act.php?act=gpicture&pid=15761&channel='.concat(evt.data.tr.find('.field-id span').text()));
      }
      $this.attr('title',cid?'编辑渠道':'新建渠道').dialog({
        width:800,
        height:300,
        buttons:{
          '保存':function(){
            if(!$tit.val()){$.alert('请输入名称!').on('dialogclose',function(){$tit.focus();});return;}
            $.servers({
              data:{act:cid?'adv-channel-update':'adv-channel-insert',tit:$tit.val(),cid:cid},
              success:function(json){
                if(json.status != 'ok'){$.alert(json.data);return;}
                if(!cid){
                  cid = json.data;
                  $url.text('http://m.qiaoxiao.com/act.php?act=gpicture&pid=15761&channel='.concat(json.data));
                }else{
                  $.alert(json.data,2);
                }
                $table.find('tfoot a:contains(跳转)').trigger('click');
              }
            });
          },
          '关闭':function(){$(this).dialog('close');}
        }
      });

    });
  }



}
