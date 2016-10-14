<?php
/*
 *


性别: 0男  1女

密码加密    pwd+createtime+phone


seseion ：
用户登录信息------------  user = json_encode(array('id','phone','email','createtime','authority','nick'))
后台管理登录信息---------  optLogin= json_encode(array('id','phone','email','createtime','authority','nick'))
用户登录错误次数---------  login-error-num = array('num'=>'次数','time'=>'最后一次错误时间')
点击记录---------------   click= array('点击的页面'=>array('ID号1','ID号2','ID号13'...))
用户登录验证码---------    login-sfx
支付密码错误次数---------   pay-error-num
邮箱验证  ----------       verify-email = array('time','code')
手机验证  ----------       verify-phone = array('time','code','num')



普通用户   网站管理员/系统管理员
1            1/2
user:     普通用户   100000
edit:     网站管理员 110000
admin:    系统管理员 120000
 */
// windows下
$paths  = str_replace('\\','/',dirname(__FILE__));
$paths  = explode('/',$paths);
array_pop($paths);
$path   = implode('/', $paths);
//网站配置
$website	= array(
    'database'=>array(
      'db'    => array(
        'name'      => 'mysql',         //数据库类型
        'host'      => '127.0.0.1',     //数据库地址
        'usr'       => 'kubei',       //数据库登录名
        'pwd'       => 'abc13579ABC',      //数据库密码
        'db'        => 'gaoxiao.qiaoxiao.com',   //数据库表名
        'charset'   => 'utf8',          //数据库使用的字符集
        'durable'   => false,            //是否是持久连接 true是 false否(一般都是短连接)
        'cache'     => true,
        'prefix'    => '',              //数据库前缀名 sfx_
        'debug'     => true,            //是否开启错误提示 true开启 false关闭
        'caching'   => false,            //是否开启数据缓存 file缓存开启  false关闭
        //缓存控制
        'cache' =>array(
          //文件缓存
          'path' => $path.'/data/db' , //文件缓存根目录
          'max'  => 30000        //文件夹内文件上限
        ),
      )
    ),
    //权限
    'authority' =>array(
      'user'      => 100000,
      // 'edit'      => 110000, 后台编辑
      // 'admin'     => 120000, 系统管理员
    ),
    //分页配置
    'page'  =>array(
      'num'           => 40 //默认每页显示个数
    ),
    //存放类实例
    'class' => array(),
    //URL地址
    'url'   => array(
            //网站地址例：http://www.test.com
            'root'  => 'http://'.$_SERVER['HTTP_HOST']
                     .($_SERVER["SERVER_PORT"] != '80' ? ':'.$_SERVER["SERVER_PORT"] : ''),
            'error' =>  'http://www.qiaoxiao.com',     //错误跳转页面
            'up'    =>  'http://www.qiaoxiao.com',     //上次访问的URL
            'now'   =>  'http://www.qiaoxiao.com'      //当前URL
    ),
    //网站硬盘地址
    'path'  => array(
      //网站物理根地址
      'root'	    => $path,
      //类存放地址
      'lib'       => $path.'/lib',
      //网站配置文件地址
      'conf'	    => $path.'/conf',
      //网站数据地址
      'data'      => $path.'/data',

      //数据上传地址
      'upload'    => array(
        // 用户图片
        'user'      => $path.'/data/upload/user/image',
        // 文章图片
        'image'     => $path.'/data/upload/image'
      ),

      //临时文件夹
      'temp'      => $path.'/data/temp',
      //页面处理web
      'action'    => $path.'/action',
      //页面处理非pc端
      'mobile'    => $path.'/action/mobile',
      //静态文件存放地址
      'css'       => $path.'/css',
      'js'        => $path.'/js',
      'html'      => $path.'/data/html',

      //后台地址
      'opt'       => array(
        'root'      => $path.'/opt',
        'act'       => $path.'/opt/act',
        'moduleJs'  => $path.'/opt/js/module',
        'moduleCss' => $path.'/opt/css/module'
      ),
      // 模板地址
      'template'=> $path.'/tpl',
      // 模板编译地址
      'compileDir'  => $path.'/data/compile',
    ),

    //配置模板类配置
    'template'=>array(
      'templateDir' => $path.'/tpl',//模板地址
      'compileDir'  => $path.'/data/compile',//模板编译后存放地址
      'left'        => '<!--{',
      'right'       => '}-->',
      'cache'       => false  //是否开启直接读取缓存 ----- 开发时开启，正式运行时关闭
    ),
    //安全配置
    'safe'  => array(
      //系统管理员账号
      'system'    => array(),
      //安全IP
      'ip'    => '0.0.0.0',
      //安全域名
      'domain'=> array('gaoxiao.qiaoxiao.com'),
      //安全码
      'key'   => 'sfsdf81ASDWI12Wf9s!*@_A#JSDSIG19',
      //上传文件限制
      'upload'  => array(
        'size'=>20480000,//单位B---10M
        'format'=>array('jpg','gif','png')
      ),
      //登录失败次数，超过则需要重启浏览器
      'loginNum'=>10
    ),
    //分类信息
    'tid'=> array(
      // 权限相关
      'admin'=>1,
      // 链接
      'links'=>15,
      // 文章内容
      'aritcle'=>17,
      // 图片父类
      'image'=>18
    ),
    //临时存放内容
    'temp'=>array(),
    // 日志配置
    'log'=>array(
      'path'  => $path.'/data/log',// 存放根地址
      'size'  => 20,//日志文件大小M
    )



);
