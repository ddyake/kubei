//User用户中心

//所有用户
function UserManage(event,ui){
  var fields  = {id:'编号',authority:'权限',phone:'手机号码',email:'邮箱地址'};
  ui.newPanel.paging({
      tb          : 'user',
      checkbox    : "block",
      num         : 10,
      fields      : fields,
      search      : fields,
      desc        : 'id desc',
      editBtns	: {
          '编辑':save,
          '禁用':function(tr){

          }
      },
      footBtns : {
          '添加新用户':save
      },
      end : function(table){
        table.data('tfoot').find('a[title="添加新用户"]' ).button({
          icons: {
            primary: "ui-icon-plus"
          }
        });
        table.data('tfoot').find('input[value="反选"]').button();
    },
    func        : function(tr){
      tr.find("td.table-ctrl a:eq(0)").button({
          icons: {
            primary: "ui-icon-wrench"
          }
      });
      tr.find("td.table-ctrl a:eq(1)").button({
          icons: {
            primary: "ui-icon-cancel"
          }
      }).on('dblclick',function(){return false;});
    }
  });

  // 编辑-新建
  function save(evt){
    // 保存用户信息
    var id    = evt.data.tr ? $(evt.data.tr).find('.field-id span').text() : false,
        $divs,$len,$lis,
        $phone,$ctime,$pwd,$pwdd,$isId,$isPhone,$isEmail,$isDisabled,$nick,$email,
        $times,$rip,$ip,$name,$idc,$gold,$qq,$address,$sex,
        $doctor,$hospital,$company,$drugstore,$admin,$edit,
      //窗口开始
      $dialog = $('<div title="编辑用户-id:'.concat(id,'"></div>')).dialog({
        width:620,
        height:540,
        maximize:1,
        minimize:1,
        appendTo:$('body'),
        buttons:{
          '保 存':function(){
            if($(this).attr('status')){$.alert($(this).attr('status'));return;}
            var $this = $(this),
                data  = {act:id?'user-info-update':'user-info-insert'};
            $this.attr('status','数据保存中...');
            if(id){data.id = id;}
            if($pwd.val()){data.pwd=$pwd.val();}
            if($pwdd.val()){data.pwdd=$pwdd.val();}
            if($email.val() != $email.attr('old')){data.email=$email.val();}
            if($phone.val() != $phone.attr('old')){data.phone=$phone.val();}
            if($email.val() != $email.attr('old')){data.email=$email.val();}
            if($nick.val() != $nick.attr('old')){data.nick=$nick.val();}

            data.doctor=$doctor.prop('checked')?1:0;
            data.hospital=$hospital.prop('checked')?1:0;
            data.company=$company.prop('checked')?1:0;
            data.drugstore=$drugstore.prop('checked')?1:0;
            data.admin=$admin.prop('checked')?1:0;
            data.edit=$edit.prop('checked')?1:0;

            if($isId.attr('old') == '1'){data.isId=$isId.prop('checked')?1:0;}
            if($isPhone.attr('old') == '1'){data.isPhone=$isPhone.prop('checked')?1:0;}
            if($isEmail.attr('old') == '1'){data.isEmail=$isEmail.prop('checked')?1:0;}
            if($isDisabled.attr('old') == '1'){data.isDisabled=$isDisabled.prop('checked')?1:0;}
            if($gold.val() != $gold.attr('old')){data.gold=$gold.val();}

            if($divs.find('input[name=sex]:checked').val() != $sex.parents('li').attr('old')){data.sex=$divs.find('input[name=sex]:checked').val();}
            if($idc.val() != $idc.attr('old')){data.idc=$idc.val();}
            if($qq.val() != $qq.attr('old')){data.qq=$qq.val();}
            if($name.val() != $name.attr('old')){data.name=$name.val();}
            if($address.val() != $address.attr('old')){data.address=$address.val();}
            if($job.val() != $job.attr('old')){data.job=$job.val();}
            // for(var i in data){
            //   alert(i+':'+data[i]);
            // }
            $.servers({
              type:'post',
              data:data,
              success:function(json){
                $this.removeAttr('status');
                $.alert(json.data,2);
                if(json.status != 'ok'){return;}
                if(id){
                  $dialog.dialog('destroy');
                }else{
                  $divs.find('input[type=text]').val('');
                  $divs.find('input[type=checkbox]').prop('checked',false);
                  $divs.find('input[type=radio]').removeAttr('checked');
                  $divs.find('span').text('');
                }
              }
            });
          },
          '取 消':function(){$(this).dialog('destroy');}
        }
      }).load('fragment.html .mod-user',function(){
        $lis    = $(this).find('.mod-user-tab a');
        lens    = $lis.length;
        $divs   = $(this).find('.mod-user-tabs div');
        $pwd    = $divs.find('input.pwd');
        $pwdd   = $divs.find('input.pwdd');
        $email  = $divs.find('input.email');
        $phone  = $divs.find('input.phone');
        $ctime  = $divs.find('span.ctime');
        $times  = $divs.find('span.times');
        $isId   = $divs.find('input.isId');
        $isPhone   = $divs.find('input.isPhone');
        $isEmail   = $divs.find('input.isEmail');
        $isDisabled   = $divs.find('input.isDisabled');
        $nick   = $divs.find('input.nick');
        $over   = $divs.find('span.over');
        $gold   = $divs.find('input.gold');
        $rip    = $divs.find('span.rip');
        $qq     = $divs.find('input.qq');
        $sex    = $divs.find('input[name=sex]');
        $idc    = $divs.find('input.idc');
        $name   = $divs.find('input.name');
        $ip     = $divs.find('span.ip');
        $address= $divs.find('input.address');
        $job= $divs.find('input.job');
        $doctor=$divs.find('input.doctor').on('click',function(){$(this).attr('old',1);});
        $hospital=$divs.find('input.hospital').on('click',function(){$(this).attr('old',1);});
        $company=$divs.find('input.company').on('click',function(){$(this).attr('old',1);});
        $drugstore=$divs.find('input.drugstore').on('click',function(){$(this).attr('old',1);});
        $admin=$divs.find('input.admin').on('click',function(){$(this).attr('old',1);});
        $edit=$divs.find('input.edit').on('click',function(){$(this).attr('old',1);});
        // 编辑-获取用户信息
        if(id){
          $.servers({
            data:{act:'user-info-select',id:id},
            type:'get',
            success:function(json){
              if(json.status == 'error'){alert(json.data);return;}

              $email.val(json.data.email).attr('old',json.data.email);
              $phone.val(json.data.phone).attr('old',json.data.phone);
              if(json.data.createtime){$ctime.text($.formatime('%Y-%M-%D',json.data.createtime));}
              if(json.data.times){$times.text($.formatime('%Y-%M-%D',json.data.times));}

              $nick.val(json.data.nick).attr('old',json.data.nick);

              $isId.prop('checked',json.data.isId=='1'?true:false).on('click',function(){$(this).attr('old',1);});
              $isPhone.prop('checked',json.data.isPhone=='1'?true:false).on('click',function(){$(this).attr('old',1);});
              $isEmail.prop('checked',json.data.isEmail=='1'?true:false).on('click',function(){$(this).attr('old',1);});
              $isDisabled.prop('checked',json.data.isDisabled=='1'?true:false).on('click',function(){$(this).attr('old',1);});

              $rip.text(json.data.rip);
              $ip.text(json.data.ip);
              $over.text(json.data.over);
              $name.val(json.data.name).attr('old',json.data.name);
              $idc.val(json.data.idc).attr('old',json.data.idc);
              $gold.val(json.data.gold).attr('old',json.data.gold);
              $qq.val(json.data.qq).attr('old',json.data.qq);
              $job.val(json.data.job).attr('old',json.data.job);
              $address.val(json.data.address).attr('old',json.data.address);
              $sex.eq(Number(json.data.sex)).attr('checked',true).parents('li').attr('old',json.data.sex);
              $.each(json.data.authority,function(){
                $divs.find('input.'.concat(this)).prop('checked',true);
              });
            }
          });
        }
        //解锁密码
        $divs.find('.pwd').next().button({icons:{primary:'ui-icon-unlocked'}}).on('click',function(){
          var confrim = $('<div title="输入保护密码">密码：<input type="password" /></div>').dialog({
            modal:true,
            buttons:{
              '确 定':function(){
                if($(this).find('input').val() == 'ddyake'){
                  $pwd.removeAttr('readonly');
                  $(this).dialog('destroy');
                }else{
                  $(this).find('input').after('<p style="color:red">密码错误,请重新输入!</p>');
                }
              },
              '取 消':function(){
                $(this).dialog('destroy');
              }
            }
          });
        });
        //解锁密码
        $divs.find('.pwdd').next().button({icons:{primary:'ui-icon-unlocked'}}).on('click',function(){
          var confrim = $('<div title="输入保护密码">密码：<input type="password" /></div>').dialog({
            modal:true,
            buttons:{
              '确 定':function(){
                if($(this).find('input').val() == 'ddyake'){
                  $pwdd.removeAttr('readonly');
                  $(this).dialog('destroy');
                }else{
                  $(this).find('input').after('<p style="color:red">密码错误,请重新输入!</p>');
                }
              },
              '取 消':function(){
                $(this).dialog('destroy');
              }
            }
          });
        });
        for(var i=0;i<lens;i++){
          var href  = $($lis[i]).attr('href'),
              newId = ''.concat(href,'-',id);
          $($lis[i]).attr('href','#'.concat(newId));
          $($divs[i]).attr('id',newId);
        }
        $(this).find('.mod-user-tabs').tabs();
    });
    ///窗口结束
  }





}

//系统管理员
function UserAdmin(event,ui){
    var fields = {id:'编号',authority:'权限',phone:'手机号码',email:'邮箱地址'};
    ui.newPanel.paging({
        tb          : 'user',
        checkbox    : 'block',
        num         : 10,
        fields      : fields,
        search      : fields,
        where       : 'authority >= 110000',
        desc        : 'id desc',
        editBtns	: {
            '编辑':function(tr){

            },
            '删除':function(tr){

            }
        },
        footBtns        : {
            '添加新用户':function(){alert(2);}
        },
        end         : function(table){
            table.data('caption').find('a[title="查询"]').button({
              icons: {
                primary: "ui-icon-search"
              }
            });
            table.data('tfoot').find('a[title="添加新用户"]').button({
              icons: {
                primary: "ui-icon-plus"
              }
            });
            table.data('tfoot').find('input[value="反选"]').button();
        },
        func        : function(tr){
            tr.find("td.table-ctrl a:eq(0)").button({
                icons: {
                  primary: "ui-icon-wrench"
                }
            });
            tr.find("td.table-ctrl a:eq(1)").button({
                icons: {
                  primary: "ui-icon-close"
                }
            });
        }
    });

}
