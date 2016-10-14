(function($){
  $.extend({
      domain:function(){
          var strRegex= "^((https|http|ftp|rtsp|mms)?://)"
                        + "?(([0-9a-z_!~*'().&=+$%-]+: )?[0-9a-z_!~*'().&=+$%-]+@)?" //ftp的user@
                        + "(([0-9]{1,3}\.){3}[0-9]{1,3}" // IP形式的URL- 199.194.52.184
                        + "|" // 允许IP和DOMAIN（域名）
                        + "([0-9a-z_!~*'()-]+\.)*" // 域名- www.
                        + "([0-9a-z][0-9a-z-]{0,61})?[0-9a-z]\." // 二级域名
                        + "[a-z]{2,6})" // first level domain- .com or .museum
                        + "(:[0-9]{1,4})?" // 端口- :80
                        + "((/?)|" // a slash isn't required if there is no file name
                        + "(/[0-9a-z_!~*'().;?:@&=+$,%#-]+)+/?)$",
              re      = new RegExp(strRegex),
              arr     = re.exec(window.location.href);
          return arr;
      },//domain
      website:{},
      cookie: function(name, value, options) {
          if (typeof value !== 'undefined') { // name and value given, set cookie
              options = options || {};
              if (value === null) {
                  value = '';
                  options.expires = -1;
              }
              var expires = '';
              if (options.expires && (typeof options.expires === 'number' || options.expires.toUTCString)) {
                  var date;
                  if (typeof options.expires === 'number') {
                      date = new Date();
                      date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
                  }else{
                      date = options.expires;
                  }
                  expires = '; expires=' + date.toUTCString();
              }
              var path = options.path ? '; path=' + options.path : '';
              var domain = options.domain ? '; domain=' + options.domain : '';
              var secure = options.secure ? '; secure' : '';
              document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
          }else{ // only name given, get cookie
              var cookieValue = null;
              if (document.cookie && document.cookie !== '') {
                  var cookies = document.cookie.split(';');
                  for (var i = 0; i < cookies.length; i++) {
                      var cookie = jQuery.trim(cookies[i]);
                      // Does this cookie string begin with the name we want?
                      if (cookie.substring(0, name.length + 1) === (name + '=')) {
                          cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                          break;
                      }
                  }
              }
              return cookieValue;
          }
      },//cookie
      formatime     : function(format,times){//解析时间format:%Y-%m-$d
          var time     = (/\d+/g.test(times)) ? (Number(times)) : (time.replace(/\-/g,"/")),
              date     = new Date(time*1000),
              arrDay   = ['星期天','星期一','星期二','星期三','星期四','星期五','星期六'],
              Year     = date.getFullYear(),//年
              year     = date.getYear(),
              month    = date.getMonth()+1,//月
              Month    = month < 10 ? '0'.concat(month) : month,
              day      = date.getDate(),//天
              Day      = day < 10 ? '0'.concat(day) : day,
              week     = arrDay[date.getDay()],//星期
              hour     = date.getHours(),//时
              Hour     = hour < 10 ? '0'.concat(hour) : hour,
              minutes  = date.getMinutes(),//分
              Minutes  = minutes < 10 ? '0'.concat(minutes) : minutes,
              second   = date.getSeconds(),//秒
              Second   = second < 10 ? '0'.concat(second) : second;
              format   = format.replace(
                  /(%y|%Y|%m|%M|%d|%D|%w|%h|%H|%i|%I|%s|%S)/g,
                  function($0,$1){
                      return {
                          '%y'   : year,     '%Y'   : Year,
                          '%m'   : month,    '%M'   : Month,
                          '%d'   : day,      '%D'   : Day,
                          '%w'   : week,
                          '%h'   : hour,     '%H'   : Hour,
                          '%i'   : minutes,  '%I'   : Minutes,
                          '%s'   : second,   '%S'   : Second
                      }[$1];
                  }
              );
          return format;
      },//formatime
      includes: function(file,random){
        var files = (typeof file == "string" ? [file] : file);

        for (var i = 0; i < files.length; i++){
            var name = files[i].replace(/^s|s$/g, "");
            var att = name.split('.');
            var ext = att[att.length - 1].toLowerCase();
            var isCSS = ext == "css";
            var tag = isCSS ? "link" : "script";
            var type  = isCSS ? 'text/css' : 'text/javascript';
            var obj = document.createElement(tag);
            if(isCSS){
              obj.setAttribute("rel", "stylesheet");
              obj.setAttribute("href", (random ? files[i].concat('?',Math.random()) : files[i]));
            }else{
              obj.setAttribute("language", "javascript");
              obj.setAttribute("src", (random ? files[i].concat('?',Math.random()) : files[i]));
            }
            obj.setAttribute("type", type);
            if (typeof obj!=="undefined"){
                document.getElementsByTagName("head")[0].appendChild(obj);
            }
        }

      },
      include: function(file,random) {
          if(!file){return;}
          //random是否缓存文件 1：不缓存   0：缓存
          random = 1;
          var files   = (typeof file === "string") ? ([file]):(file),
              hrefs   = [];
          random  = random ==='undefined' ? 1 : random;
          $("link").each(function(){
              hrefs.push($(this).attr("href"));
          });

          for(var i = 0; i < files.length;i++){
              if($.inArray(files[i],hrefs) !== -1){
                  return;
              }
          }
          for (var ii = 0; ii < files.length; ii++) {
              var css = document.createElement("link");
              css.setAttribute("rel", "stylesheet");
              css.setAttribute("type", "text/css");
              css.setAttribute("href", (random ? files[ii].concat('?',Math.random()) : files[ii]));
              if (typeof css!=="undefined"){
                  document.getElementsByTagName("head")[0].appendChild(css);
              }
          }
      },//include
      servers  : function(args){
          $.ajax({
              data:args.data,
              type:args.type ? args.type:'get',
              success:function(json){
                if(json.status === 'error' && json.msg === 'login-fail'){
                    $.admin.login();
                    return;
                }else{
                    args.success.call(null,json);
                }
              }
          });
      },
      admin   : {
          args    : {
              root    : '/opt',//根目录
              $load   : $('<ul style="width:100px"><li><img src="/opt/image/load.gif" /></li><li style="height:14px;line-height:14px">数据加载中...</li></ul>'),//加载图片框
              act     : '',//当前活跃的模块编号---english名称
              ctrl    : {},//左侧模块存{english:$obj,english:$obj,...}，数组内为jQuery对象
              module  : {},//显示模块容器 jQuery-----$('ul')*********必须滴
              cont    : {},//显示功能容器 jQuery-----$('div')********必须滴
              top     : {},//顶部按钮 jquery对象*****必须滴
              max     : 10,//选项卡最多显示的个数--未生效
              on      : {}//左侧模块事件触发
          },
          //加载功能
          load    : function(args){
              var admin   = this,
                  $load   = admin.args.$load;
              admin.args  = $.extend(admin.args,args);
              admin.args.on.mouseover = admin.args.on.mouseover ? admin.args.on.mouseover : admin.mouseover;
              admin.args.on.mouseout = admin.args.on.mouseout ? admin.args.on.mouseout : admin.mouseout;
              admin.args.on.click = admin.args.on.click ? admin.args.on.click : admin.click;

              $(document.body).append($load);
              $load.css({
                  position:'absolute',
                  display:'none',
                  fontSize:'12px',
                  'text-align': 'center',
                  top         : ''.concat(($(window).height()-$load.height())/2+$(window).scrollTop(),'px'),
                  left        : ''.concat(($(window).width()-$load.width())/2+$(window).scrollLeft(),'px')
              });

              //默认数据
              $.ajaxSetup({
                  url:'/opt/act.php',
                  cancel:false,
                  dataType:'json',
                  //statusCode:{404:function(){alert('未找到页面!');}},
                  complete:function(json){$load.fadeOut(500);},
                  beforeSend:function(){$load.show();},
                  error : function(XMLHttpRequest, textStatus, errorThrown){
                      $('<div title="错误">'.concat(
                          '错误类型：',textStatus,'<br />',
                          '错误调试：',errorThrown,'<br />',
                          '错误内容：',XMLHttpRequest.responseText,'</div>'
                      )).dialog({
                          dialogClass : 'alert',
                          maxHeight:300,
                          modal:1,
                          buttons     : {'确 定':function(){$(this).dialog('destroy');}}
                      });
                  }
              });
              $.servers({
                  data:{act:'global-load'},
                  type:'post',
                  success:function(json){
                      if(json.status === 'ok'){
                          admin.args.module.empty();
                          //全局website
                          $.website = json.website;
                          $.each(json.data,function(){
                              //首字母大写
                              var english = this.cont.toLowerCase().replace(/\b(\w)|\s(\w)/g, function(m){
                                      return m.toUpperCase();
                                  }),
                                  $html   =$('<li></li>').attr('module',this.cont)
                                            .attr('title',this.tit)
                                            .append($('<span class="l"></span>').text(english))
                                            .append($('<span class="r"></span>').text(this.tit));
                              admin.args.module.append($html);
                              $html.data('modules',this.modules);
                          });
                          //左侧事件触发(划过，点击)
                          admin.args.module.find('li').on('mouseover',{admin:admin},admin.args.on.mouseover);
                          admin.args.module.find('li').on('mouseout',{admin:admin},admin.args.on.mouseout);
                          admin.args.module.find('li').on('click',{admin:admin},admin.args.on.click);
                      }else{
                          admin.login();
                      }
                  }
              });

              //top按钮功能
              admin.args.top.find('a:contains("注销登录")').on('click',function(){
                 $('<div title="提示">是否注销登录？</div>').dialog({
                      dialogClass : 'alert',
                      modal       : 1,
                      buttons     : {
                          '确 定':function(){
                              admin.logout();
                              $(this).dialog('destroy');
                          },
                          '取 消':function(){
                              $(this).dialog('destroy');
                          }
                      }
                  });
                  return false;
              });

          },
          //注销登录
          logout  : function(){
              $(document.body).focus();
              var admin   = this;
              $.servers({
                  data:{'act':'global-logout'},
                  type:'get',
                  success:function(json){
                      if(json.status === 'ok'){
                          admin.args.module.empty();
                          admin.args.cont.empty();
                          admin.args.ctrl={};
                          admin.login();
                      }
                  }
              });
          },
          mouseover:function(evt){
              $(this).attr('class','hover');
          },
          mouseout:function(evt){
              $(this).removeAttr('class');
              if($(this).attr('status')==='click'){
                  $(this).attr('class','click');
              }
          },
          click   :function(evt){//点击左侧显示选项卡
              var admin   = evt.data.admin,
                  $btns   = admin.args.module.find('li'),
                  module  = $(this).attr('module'),
                  $left   = $(this);
              $btns.attr('status','none');
              $btns.removeAttr('class');
              $(this).attr('status','click');
              $(this).attr('class','click');
              //模块已存在
              $.each(admin.args.ctrl,function(i){
                  $(this).hide();
              });

              if(admin.args.ctrl[module] instanceof jQuery){
                  admin.args.ctrl[module].show();
              }else{
                  $.include(admin.args.root.concat('/css/module/',module,'.css'));
                  $.getScript(admin.args.root.concat('/js/module/',module,'.js'),function(){
                      var $ul      = $('<ul></ul>'),
                          $main = $('<div></div>').attr('id',module).css({overflow:'hidden'}).append($ul);
                      $main.height(admin.args.cont.height());
                      $.each($left.data('modules'),function(){
                          var $li = $('<li></li>').attr('english',this.cont)
                                    .append($('<a></a>').attr('href','#'.concat(this.cont)).text(this.tit))
                                    .append($('<span class="ui-icon ui-icon-refresh" role="presentation">刷新tab</span>')),
                              $div=$('<div></div>').attr('id',this.cont);
                          $ul.append($li);
                          $main.append($div);
                      });
                      admin.args.cont.append($main);

                      $main.tabs({
                          heightStyle:'fill',
                          collapsible:true,
                          active:false,
                          activate:function(event,ui){
                              // gui     = ui;
                              // gevent  = event;
                              if(!ui.newTab.attr('english') || ui.newPanel.html().length!==0){return;}
                              //选项卡绑定函数
                              //alert(ui.newTab.attr('english'));
                              window[ui.newTab.attr('english')](event,ui);
                              //刷新按钮
                              ui.newTab.find('span.ui-icon-refresh').on('click',{event:event,ui:ui},function(e){
                                  $main.height(admin.args.cont.height());
                                  ui.newPanel.empty();
                                  setTimeout(function(){window[ui.newTab.attr('english')](e.data.event,e.data.ui)},100);
                              });
                          }
                      });


                      $main.tabs({active:0});
                      admin.args.ctrl[module] = $main;
                  });
              }
          },
          login   : function(){
              $.include("css/login.css");
              var $login = $('<div title="用户登陆"></div>').load('fragment.html .b-login',function(){
                  var $usr    = $(this).find("input[name=usr]"),
                      $pwd    = $(this).find("input[name=pwd]"),
                      $sfx    = $(this).find("input[name=sfx]"),
                      $btn    = $(this).find("li.btn a"),
                      $img    = $(this).find("li.sfx img"),
                      src     = $img.attr("href"),
                      $this   = $(this);
                  $img.attr('src',src);
                  function _login(){
                      $.servers({
                          data:{
                              act   : 'global-login',
                              usr   : $usr.val(),
                              pwd   : $pwd.val(),
                              sfx   : $sfx.val()
                          },
                          type:'post',
                          success:function(json){
                              if(json.status == 'ok'){
                                  $this.dialog('destroy');
                                  $.admin.load();
                              }else{
                                  switch(json.msg){
                                      case 'double':
                                          $.alert({cont:'请不要重复登录！'});
                                          break;
                                      case 'sfx':
                                          $.alert({cont:'验证码错误！'});
                                          break;
                                      case 'login':
                                          $.alert({cont:'密码或用户名错误！'});
                                          break;
                                      default:
                                          $.alert({cont:json.msg});
                                  }
                              }
                          }
                      });
                  }
                  $this.dialog({
                      width   : 350,
                      modal   : 1,
                      buttons : {
                          '登 陆': _login,
                          '取 消': function(){$(this).dialog('destroy');}
                      }
                  });

                  $usr.focus();
                  //验证码
                  $img.on("click",function(){$img.attr("src",src.concat("&",Math.random()));});
                  $this.find("li.sfx a").on("click",function(){$img.trigger('click');});

                  $this.find("form").on('submit',function(event){
                      event.preventDefault();
                      _login();
                  });
              });
          }
      },//admin
      //alert({tit,cont})
      alert:function(){
        var obj={};
        if(!$.isPlainObject(arguments[0])){
          var len = arguments.length;
          if(len==1){
            obj={
              cont: arguments[0],
              tit : '提示'
            };
          }else if(len==2 && $.isNumeric(arguments[1])){
            obj={
              tit : '提示',
              cont:arguments[0],
              timeout:arguments[1]
            };
          }else if(len==2){
            obj={
              tit:arguments[0],
              timeout:arguments[1]
            };
          }else if(len==3){
            obj={
              tit:arguments[0],
              cont:arguments[1],
              timeout:arguments[2]
            };
          }
        }else{
          obj = arguments[0];
        }

        var $alert = $('<div/>').attr('title',obj.tit).html(obj.cont).dialog({
            dialogClass : 'alert',
            maxHeight:300,
            modal:1,
            buttons : {
                '确 定': function(){$alert.remove();}
            }
        });
        //几秒后关闭窗口功能
        if(obj.timeout && $.isNumeric(obj.timeout) && $alert.length){
          var tit = $alert.dialog('option','title'),
              time,
              num = obj.timeout;
          $alert.dialog("option", "title",''.concat(tit,'-',num,'秒后关闭窗口'));
          time = setInterval(function(){
            num--;
            if(num<=0){
              clearInterval(time);
              if($alert.length){
                $alert.dialog('close');
                $alert.remove();
              }
              return;
            }
            if($alert.length){
              $alert.dialog('option','title',tit.concat('-',num,'秒后关闭窗口') );
            }

          },1000);
        }

        return $alert;
      }
  });

  $.fn.extend({
    // 居中
    center:function(){
      $(this).on('click',function(){
        var $img=$('<img />')
                   .attr('src',$(this).attr('src'))
                   .css({
                     position:'absolute',
                     'z-index':9999,
                     maxWidth:$(document.body).width()
                   }).
            position({
            at:'center middle',
            my:'top middle',
            of:window
         }).appendTo($(document.body).on('mousedown',function(){$img.remove();}));
      });
      return this;
    },
    //paging分页
    paging      : function(args){
        //args{
        // --------------以下是可选参数
        //   act     : 'global-paging' 默认参数可以不填写  与$.servers里面的act关联
        //   checkbox: 1,                 //是否显示首例checkbox,默认不显示
        //   page    : 1,                            //当前页数
        //   num     : 10,                          //每页显示条数
        //   where   : '',
        //   desc    : '`id` desc',                //排序,
        //   note    : '排序说明：前台排序，按照排序数字的由高到低。',        //最后的说明HTML
        //   editBtns : {
        //     '按钮名称':function(evt){} //evt.data.tr 当前行
        //   },
        //   footBtns : {
        //     '按钮名称':function(evt){} //evt.data.table 当前表格
        //   },
        //   func : function(tr){
        //
        //   },     //表格一行生成完成时候执行的函数   tr当前行
        //   end  : function(table){},//加载完之后执行    table 当前表格

        // --------------以下是必选参数
        //   tb      : 'goods_list',            //表名
        //   fields  : {id:'编号',tit:'名称',...},   //显示字段  数据字段名:字段意思
        //   search  :  {id:'编号',tit:'名称',...},  //查询字段

        // }
        //对象清空内容
        $(this).empty();
        $(this).load('/opt/fragment.html .table',function(){
            var maxPage = 0,//最大页数
                table   = $(this),
                $sfield,$scond,
                caption = table.find("caption"),
                thead   = table.find("thead"),
                tbody   = table.find("tbody"),
                tfoot   = table.find("tfoot"),
                theadTr = thead.find("tr"),
                note    = tfoot.find("tr:eq(1) th"),
                where   = args.where,//查询条件原始
                wheres  = where,
                colspan = 0;//底部右侧分页按钮占用几格
            //表格说明
            if(args.note){note.html(args.note);}
            table.data('caption',caption);
            table.data('thead',thead);
            table.data('tbody',tbody);
            table.data('tfoot',tfoot);

            //是否有caption字段查询功能
            if(!$.isEmptyObject(args.search)){
                $.each(args.search,function(i){
                    caption.find("select:eq(0)").append('<option value="'.concat(
                        i,
                        '" >',
                        args.search[i],
                        "</option>")
                    );
                });
                caption.find("input.num").val(args.num);

                //查询按钮
                var _field      = '',//查询字段
                    _condition  = '';//查选条件
                $sfield = caption.find("select:eq(0)").selectmenu({
                    change:function(evt,data){
                        _field = data.item.value;
                    },
                    width:150,
                    height:40
                });

                $scond = caption.find("select:eq(1)").selectmenu({
                    change:function(evt,data){
                        _condition = data.item.value;
                    },
                    width:150,
                    height:40
                });
                caption.find("a.button").button().on('click',function(){
                    var _cont       = caption.find("input:eq(0)"),//查询内容
                        _num        = caption.find("input:eq(1)");//查询显示数目
                    wheres = '';
                    if(_field=== "0" || _condition === "0" || _cont.val() === "输入查询内容" || !_field || !_condition || !_cont.val()){
                        $('<div title="错误">请正确选择和输入查询内容!</div>').dialog({
                            dialogClass : 'alert',
                            modal       : 1,
                            buttons     : {'确 定':function(){$(this).dialog('destroy');}}
                        });
                        return;
                    }else{
                        wheres = "`".concat(
                            _field,
                            "` ",
                            _condition,
                            " '",
                            (_condition === "like") ? ('%'.concat(_cont.val(),"%")) : (_cont.val()),
                            "'"
                        );

                            wheres = args.where ? args.where.concat(" and ",wheres) : wheres;

                        if(/^where/gi.test(where)){
                            wheres = where.replace('/^where/gi','');
                        }
                    }
                    _get_paging();
                });
            }else{caption.remove();}

            //头部是否有全选按钮
            if(args.checkbox){
                theadTr.append('<th title="全选"><input type="checkbox" /></th>');
            }

            //数据左侧是否有相关操作
            if(!$.isEmptyObject(args.editBtns)){
                theadTr.append('<th>相关操作</th>');
                ++colspan;
            }

            //获取表格头部标题字段
            for(var i in args.fields){
                theadTr.append('<th field="'.concat(i,'">',args.fields[i],'</th>'));
            }
            colspan += thead.find("th").length;

            //thead第一个按钮 全/不选
            thead.find("input:eq(0)").on("mouseup",function(){
                var _bool   = !$(this).prop("checked"),
                    _tr     = $(this).parents("table:eq(0)").find("tbody tr"),
                    _ctrl   = (_bool)?("addClass"):("removeClass");
                for(var _i=0,_len=_tr.length;_i<_len;_i++){
                    $(_tr[_i]).find("input:eq(0)").prop("checked",_bool);
                    $(_tr[_i])[_ctrl]("down");
                }
            });

            //thead字段点击事件
            thead.find("th")
                    .not(thead.find("th input")
                    .parent())
                    .not(thead.find("th:contains('相关操作')"))
                    .on("mousedown",function(){
                        var img = $(this).find("img"),
                            src = img.attr("src");
                        thead.find("th").removeAttr("desc");
                        thead.find("th img").remove();

                        if(!img.length){
                            args.desc = "`".concat($(this).attr("field"),"` desc");
                            $(this).append('<img src="'.concat($.admin.args.root,'/image/down.png" />'));
                        }else if(src.indexOf("down.png") !== -1){
                            args.desc = "`".concat($(this).attr("field"),"` asc");
                            $(this).append('<img src="'.concat($.admin.args.root,'/image/up.png" />'));
                        }else{
                            args.desc = "`".concat($(this).attr("field"),"` desc");
                            $(this).append('<img src="'.concat($.admin.args.root,'/image/down.png" />'));
                        }
                        //开始查询
                        _get_paging();
                    });

            //反选
            if(args.checkbox){
                $(tfoot.find("input:eq(0)")).on('click',function(){
                    var _tr = $(this).parents("table:eq(0)").find("tbody tr");
                    $(this).parents("table:eq(0)").find("thead input:eq(0)").prop("checked",false);
                    for(var _i=0,_len=_tr.length;_i<_len;_i++){
                        var _bool   = !$(_tr[_i]).find("input:eq(0)").prop("checked"),
                            _ctrl   = (_bool)?("addClass"):("removeClass");
                        $(_tr[_i]).find("input:eq(0)").prop("checked",_bool);
                        $(_tr[_i])[_ctrl]("down");
                    }
                });
                colspan++;
            }else{
                tfoot.find("th:eq(0)").remove();
            }

            //表格底部功能
            tfoot.find('th.ctrl-btn').attr('colspan',colspan);
            tfoot.find('th:last').attr('colspan',Number(tfoot.find('th.ctrl-btn').attr('colspan'))+colspan);
            $.each(!$.isEmptyObject(args.footBtns) ? args.footBtns : [],function(i){
              var $a = $('<a title="'.concat(
                              i,'">',
                              i,
                              '</a>'
                          )
              );
              tfoot.find("th.ctrl-btn").append($a);
              $a.on('click',{table:table},args.footBtns[i]);
            });

            //表格底部上一页
            $(tfoot.find('a:eq(0)')).button({icons:{primary:'ui-icon-seek-prev'}}).on('click',function(){
                if(args.page-1 > 0){
                    args.page -= 1;
                    _get_paging();
                    tfoot.find("input.page").val("");
                }
            });
            //表格底部下一页
            $(tfoot.find('a:eq(1)')).button({icons:{secondary:'ui-icon-seek-next'}}).on('click',function(){
                if(args.page+1 <= maxPage){
                    args.page += 1;
                    _get_paging();
                    tfoot.find("input.page").val("");
                }
            });
            //跳转功能
            $(tfoot.find('a:eq(2)')).button({icons:{primary:'ui-icon-refresh'}}).on('click',function(e,myPage){
                if(myPage && /\d+/.test(myPage)){
                    args.page = myPage;
                    _get_paging();
                    return;
                }else{
                    var _ipt = tfoot.find('input.page'),
                        _page= Math.abs(Number(_ipt.val()));

                    if(!_page || !/\d+/.test(_page) || _page <= 0){
                        $('<div title="警告">页数非法!</div>').dialog({modal:1,dialogClass:'alert'});
                        _ipt.select();
                        return false;
                    }else{
                        args.page = _page;
                        _ipt.val("");
                        _get_paging();
                    }
                }
            });


            //获取分页
            function _get_paging(){
                tbody.empty();
                var fields = [];
                $.each(args.fields,function(i){
                    fields.push(i);
                });
                $.servers({
                    data:{
                        act     : args.act || 'global-paging',
                        tb      : args.tb,
                        fields  : fields.join(','),//数组字符串化,
                        page    : args.page  || 1,  //默认第一页
                        where   : wheres || '',//条件
                        order   : args.desc,
                        num     : (/\d+/.test(caption.find('input.num').val()))?(Number(caption.find('input.num').val())):(10),//默认10条
                        desc    : args.desc
                    },
                    type    : 'post',
                    success : function(json){
                        if(json.status !== 'ok'){alert($.alert({cont:json.data}));return;}
                        //测试alert(json.data.sql);
                        json    = json.data;
                        var _fields = json.data;
                        //清空tbody
                        tbody.empty();

                        for(var i=0,l=_fields.length;i<l;i++){
                            var _tds    = '',
                                _tr     = $("<tr></tr>");
                            //checkbox
                            if(args.checkbox){
                                _tr.append('<td><input class="check" type="checkbox" /></td>');
                            }
                            //相关操作按钮
                            if(!$.isEmptyObject(args.editBtns)){
                                var _btns   = '',
                                    _tds    = $('<td class="table-ctrl"></td>');
                                $.each(args.editBtns,function(i){
                                    var $a = $('<a title="'.concat(
                                                    i,'">',
                                                    i,
                                                    '</a>'
                                    ));
                                    _tds.append($a);
                                    $a.on('click',{tr:_tr},this);
                                    if(i == '编辑'){_tr.on("dblclick",{tr:_tr},this);}
                                    $a.on('mousedown',function(){return false;});
                                });
                                _tr.append(_tds);
                            }
                            //字段信息
                            for(var ii in _fields[i]){
                                _tr.append(
                                    '<td class="field-'.concat(
                                        ii,
                                        '"><span class="txt" title="',
                                        _fields[i][ii],'">',
                                        _fields[i][ii],
                                        '</span></td>'
                                    )
                                );
                            }
                            tbody.append(_tr);
                            if($.isFunction(args.func)){
                                args.func.apply(null,[_tr]);
                            }
                        }


                        //表格底部分页显示文本
                        tfoot.find("span.pages").text(''.concat(json.nowPage,'/',json.maxPage?json.maxPage:1));
                        maxPage     = Number(json.maxPage);
                        args.page   = Number(json.nowPage);
                        tfoot.find("input.page").val(json.nowPage);
                        //tbody事件
                        tbody.find("tr").on("mouseover",function(){$(this).addClass("hover");});

                        tbody.find("tr").on("mouseout",function(){$(this).removeClass("hover");});

                        //选择按钮
                        tbody.find("tr").on("mousedown",function(){
                            if($(this).hasClass("down")){
                                $(this).removeClass("down");
                                $(this).find("input.check").prop("checked",false);
                            }else{
                                $(this).addClass("down");
                                $(this).find("input.check").prop("checked",true);
                            }
                        });
                        table.find("input.check").on("mousedown",function(){
                            $(this).parents("tr:eq(0)").trigger("mousedown");
                            $(this).prop("checked",!$(this).prop("checked"));
                            return false;
                        });

                    }
                });
            }
            _get_paging();
            if($.isFunction(args.end)){
                args.end.apply(null,[table]);
            }
        });

    },//paging
    //树形结构
    tree        : function(args){
          /*对象内容必须为空
           * args{
           *  unfurl     : function(){}//展开事件动作
           *  furl       : function(){}//收缩树形事件
           *  click      : function(){}//点击分类事件
           *  unfurlImg  : "/image/minus.gif",展开图片
           *  furlImg    : "/image/plus.gif",收缩图片
           *  act        : 'type-get',执行地址
           *  upid       : 0,//上级ID[]
           *  empty      : 0,//是否清空容器数据
           *  tp         : "",分类类型
           *  tid        : "",分类ID
           *
           * }
           *
           */
          var def    = {
                  act     : "global-type",
                  parent  : $(this),
                  minus   : ''.concat($.admin.args.root,"/image/minus.gif"),
                  plus    : ''.concat($.admin.args.root,"/image/plus.gif"),
                  upid    : 1,
                  empty   : 0,
                  tp      : "",
                  tid     : "",
                  unfurl  : function(json){
                      var _ul    = $("<ul class='tree'></ul>"),
                          _actTp;//当前被点击的分类<a></a>
                          for(var i=0,l=json.data.length;i<l;i++){
                              var _obj    = json.data[i],
                                  _li     = $("<li></li>"),
                                  _a      = $('<a href="javascript:"></a>'),
                                  _span   = $("<span>".concat(_obj.tit,"</span>")),
                                  _img    = $("<img />"),
                                  title   = [];
                              _a.append(_img,_span);
                              _li.append(_a);
                              _ul.append(_li);
                              _img.attr("src",(Number(_obj.num))?(this.plus):(this.minus));
                              $(_a).data('data',_obj);

                              for(var n in _obj){
                                  switch(n){
                                    case 'title':
                                      _a.attr('tit',_obj[n]);
                                      break;
                                    case 'id':
                                      _a.attr('tid',_obj[n]);
                                      break;
                                    default:
                                      _a.attr(n,_obj[n]);
                                  }
                                  title.push(''.concat(n,':',_obj[n]));
                              }
                              _a.attr('title',title.join("\r\n"));
                              //显示下级菜单/收起下级菜单
                              _img.on(
                                  "mousedown",
                                  {upid:_obj.id,obj:_li,next:_a,tree:def,img:_img},
                                   function(e){
                                      if(Number($(this).parent().attr('num'))){
                                        if(!$(this).parents("li:eq(0)").find("ul").length){//加载树
                                            $(this).attr("src",e.data.tree.minus);
                                            if(e.data.tree.tp){delete e.data.tree.tp;}
                                            e.data.obj.tree($.extend(e.data.tree,{upid:e.data.upid,parent:e.data.obj}));
                                        }else{//收起树
                                            e.data.tree.furl(e);
                                        }
                                      }
                                      return false;
                                  }
                              );
                              _a.on("mousedown",this.click);
                          }
                          $(this.parent).append(_ul);
                  },
                  furl    : function(e){
                      e.data.img.attr("src",this.plus);
                      e.data.next.next("ul").remove();
                  },
                  click   : function(){}
              };
          $.extend(def,args);
          if(def.empty){def.parent.empty();}
          $.servers({
              data:{act:def.act,upid:def.upid,tp:def.tp,tid:def.tid},
              success:
                  function(json){
                      if(json.status === 'ok'){
                          //测试使用alert(json.sql);
                          def.unfurl(json);
                      }
                  }
          });
          return $(this);
      },//tree
  });


  //分类属性
  $.widget('custom.types',{
    //当前活动的
    _active:null,
    //树形元素
    tree:null,
    //父ID
    parentId:null,
    options:{
      //点击树内容是触发
      click:function(){},
      data:{act:'global-type',upid:0},//act:'xx-xxx-xxx'...
      type:'get',//post|get
      success:function(){},
      width:200
    },
    //更新当前所选类
    update:function(){
      if(!this._active){return false;}
      var that = this,
          data = that.options.data;
      delete data.upid;
      data.tid=this._active.data('args').id;
      data.act='global-type-id';
      $.servers({
        data:data,
        type:that.options.type,
        success:function(json){
          if(json.status != 'ok'){$.alert(json.data);return;}
          that._active.data('args',json.data);
          that._active.find('label:eq(0)').text(json.data.tit);
        }
      });
    },
    //刷新当前所选下级类
    refresh:function(){
      var that = this,
          data = that.options.data;
      delete data.tid;
      if(!this._active){
        alert(this.parentId);
        data.upid = this.parentId;
        $.servers({
          data:data,
          type:that.options.type,
          success:function(json){
            if(json.status != 'ok'){$.alert(json.data);return;}
            var $ul = that._complie(json.data);
            that._active.nextAll().remove();
            that._active.after($ul);
          }
        });
      }else{
        data.upid=this._active.data('args').id;
        this._create();
      }

    },
    //初始化所有
    init:function(){
      this._create();
      this._active=null;
      this.parentId = this.options.upid;
    },

    _create:function(){
      var that = this;
      that.element.empty();
      $.servers({
        data:this.options.data,
        type:this.options.type,
        success:function(json){
          if(json.status != 'ok'){$.alert(json.data);return;}
          that.tree   = that._complie(json.data);
          that.element.append(that.tree);
          that.tree.addClass('type-none');
        }
      });
    },
    act:function(){
      return this._active;
    },
    // 解析
    _complie:function(data){
      var $ul=$('<ul class="type"></ul>'),
          that= this;
      $.each(data,function(){
        var $li   = $('<li></li>'),
            $ico  = $('<span></span>')
                    .addClass('ui-icon '.concat(this.num>0 ? 'ui-icon-plus':'ui-icon-minus')),
            $label= $('<label></label>').text(this.tit),
            $a    = $('<a></a>')
                  .append($ico)
                  .append($label).width(that.options.width),
            title ='';
        $a.data('args',this);
        $li.append($a);
        $ul.append($li);
        for(var n in this){
          title = title.concat(n,':',this[n],'\r\n');
        }
        $a.attr('title',title);
        $a.on('click',function(){
          that.tree.find('a').removeAttr('class');
          $(this).addClass('act');
          //当前活动对象
          that._active = $(this);
          that.options.click.call(null,that);
          return false;
        });
        $ico.on('click',function(){return false;});
        if(this.num>0){
          $ico.on('click',function(){
            //展开下级分类
            if($(this).hasClass('ui-icon-plus')){
              var data = that.options.data,
                  args = $a.data('args');
              data.upid= args.id;
              $.servers({
                data:data,
                type:that.options.type,
                success:function(json){
                  if(json.status != 'ok'){$.alert(json.data);return;}
                  $li.append(that._complie(json.data));
                }
              });
            }else{//收缩下级菜单
              $a.next('ul:eq(0)').remove();
            }
            if($(this).hasClass('ui-icon-minus')){
              $(this).removeClass('ui-icon-minus');
              $(this).addClass('ui-icon-plus');
            }else{
              $(this).addClass('ui-icon-minus');
              $(this).removeClass('ui-icon-plus');
            }
          });
        }
      });
      return $ul;
    }
  });

  //dialog 加最大化最小化图标功能
  $.widget(
    'ui.dialog',
    $.ui.dialog,
    {
      _init:function(){
        if(this.options.icon && !this.icon){
          this._createIcon();
        }else if(!this.options.icon && this.icon){
          this.icon.remove();
          this.icon=null;
        }
        if(this.options.maximize){
          this._createMaximize();
        }else if(this.uiDialogTitlebarMax){
          this.uiDialogTitlebarMin.remove();
          this.uiDialogTitlebarMin = null;
        }

        if(this.options.minimize){
          this._createMinimize();
        }else if(this.uiDialogTitlebarMax){
          this.uiDialogTitlebarMax.remove();
          this.uiDialogTitlebarMax = null;
        }
        // 创建进程
        if(!$('body').data('process')){$('body').data('process',[]);}
        $('body').data('process').push({
          title:this.options.title,
          zIndex:1,
          self:this
        });

        return this._super();
      },
      _setOption:function(key,value){
        this._super( key, value );
        this._superApply( arguments );
        switch(key){
          case 'icon':
            this.icon.attr('src',value);
            break;
          case 'minimize':
            if(this.uiDialogTitlebarMin && !value){
              this.uiDialogTitlebarMin.remove();
              this.uiDialogTitlebarMin = null;
            }else if(value && !this.uiDialogTitlebarMin){
              this._createMinimize();
            }
            break;
          case 'maximize':
            if(this.uiDialogTitlebarMax){
              this.uiDialogTitlebar.find('.ui-dialog-title').off('dblclick');
              this.uiDialogTitlebarMax.remove();
              this.uiDialogTitlebarMax = null;
            }else{
              this._createMaximize();
            }
          break;
        }

        return this._super();
      },
      _createIcon:function(){
        var $icon = $('<img src="'.concat(this.options.icon,'" />'));
        this.icon = $icon;
        $icon.prependTo(this.uiDialogTitlebar.find('.ui-dialog-title'));
        $icon.addClass('ui-dialog-icon');
      },
      _createMaximize:function(){//最大化
        this.uiDialogTitlebarMax = $("<button/>").attr('title','最大化')
                                    .button({
                                      label:'max',
                                      icons: {primary: 'ui-icon-extlink'},
                                      text: false
                                    }).attr('status','small');
        this.uiDialogTitlebarMax.appendTo( this.uiDialogTitlebar )
                                .addClass("ui-dialog-titlebar-maximize");
        uiDialogTitlebarMax = this.uiDialogTitlebarMax;
        this._on( this.uiDialogTitlebarMax, {
          click: function( event ) {
            event.preventDefault();
            var maxWidth = this.options.appendTo.width(),
                maxHeight= this.options.appendTo.height(),
                nowWidth = this.options.width,
                nowHeight= this.options.height;
            if(this.uiDialogTitlebarMax.attr('status') == 'small'){//最大化
              this.options.resizable = false;
              this.options.oldWidth = nowWidth;
              this.options.oldHeight= nowHeight;
              this.options.oldPositon=this.options.position;
              this.options.width = maxWidth;
              this.options.height= maxHeight;
              this.options.position={
                my: "top left",
                at: "top left",
                of: this.options.appendTo
              };
              this.uiDialog.draggable( 'option', 'disabled', true );
              this.uiDialogTitlebarMax.button('option','icons',{primary:'ui-icon-newwin'})
                                      .attr('title','还原大小')
                                      .attr('status','big');
              this._size();
              this._position();
            }else{//还原大小
              this.options.resizable = true;
              this.options.width = this.options.oldWidth;
              this.options.height= this.options.oldHeight;
              this.options.position=this.options.oldPositon;
              this.uiDialogTitlebarMax.button('option','icons',{primary:'ui-icon-extlink'})
                                      .attr('title','最大化')
                                      .attr('status','small');
              this._size();
              this._position();
              this.uiDialog.draggable('option', 'disabled', false );
            }
          }
        });
        this._on(this.uiDialogTitlebar.find('.ui-dialog-title'),
          {
            dblclick:function(evt){
              uiDialogTitlebarMax.trigger('click');
            }
          }
        );
      },
      _createMinimize:function(){//最小化按钮
        this.uiDialogTitlebarMin = $( "<button type='button'></button>" )
          .button( {
            label: 'min',
            icons: {
              primary: "ui-icon-minusthick"
            },
            text: false
          } )
          .appendTo( this.uiDialogTitlebar )
          .addClass( this.uiDialogTitlebar.find('button').length == 3 ? "ui-dialog-titlebar-minimize":"ui-dialog-titlebar-minimize-2");
        this._on( this.uiDialogTitlebarMin, {
          click: function( event ) {
            event.preventDefault();
            // this.uiDialog.hide();
            this.uiDialog.height(30).width(150).css({overflow:'hidden'});
          }
        } );
      }
    }
  );


})(jQuery);
