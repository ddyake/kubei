<?php
require 'website.conf.php';
require '../lib/func.php';
require '../lib/Database.class.php';
exit();

function loop_mkdir(&$website,$arr){
  foreach($arr as $v){
    if(is_array($v)){
      loop_mkdir($website,$v);
    }else{
      if(!is_dir($v)){
        fn_mkdir($v);
      }
    }
  }
}

// 创建所有文件夹
loop_mkdir($website,$website['path']);
// 系统管理员账户
$systemAccount = array('phone'=>'1234567890111','email'=>'jm_0114@163.com','pwd'=>'jiangmin');


// 创建分类表  用户表
$db = new Database($website);
$website['class']['db'] = $db;
$db->exec(
"CREATE TABLE `type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '类型ID',
  `upid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上级ID',
  `num` int(11) unsigned NOT NULL COMMENT '子类型个数',
  `tp` varchar(11) NOT NULL DEFAULT '' COMMENT '类别类型',
  `tit` varchar(20) NOT NULL DEFAULT '' COMMENT '类型名称',
  `cont` varchar(20) NOT NULL DEFAULT '' COMMENT '介绍',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='类别集合';"
);
$db->exec(
"CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `authority` int(11) unsigned NOT NULL COMMENT '会员组别',
  `phone` bigint(11) unsigned NOT NULL COMMENT '手机',
  `createtime` int(11) unsigned NOT NULL COMMENT '创建时间',
  `pwd` char(32) NOT NULL COMMENT '密码',
  `pwdd` char(32) NOT NULL DEFAULT '' COMMENT '密码',
  `isId` tinyint(1) unsigned NOT NULL COMMENT '审核通过身份证',
  `isPhone` tinyint(1) unsigned NOT NULL COMMENT '审核通过手机号',
  `isEmail` tinyint(1) unsigned NOT NULL COMMENT '审核通过邮箱号',
  `isDisabled` tinyint(1) unsigned NOT NULL COMMENT '是否禁用',
  `nick` varchar(11) NOT NULL DEFAULT '' COMMENT '昵称',
  `email` varchar(50) NOT NULL DEFAULT '' COMMENT '电子邮箱',
  PRIMARY KEY (`id`),
  UNIQUE KEY `only` (`phone`,`nick`,`email`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='用户登录';"
);
$db->exec(
"CREATE TABLE `user_detail` (
  `id` int(11) unsigned NOT NULL,
  `gold` int(11) unsigned NOT NULL COMMENT '积分',
  `rip` bigint(20) unsigned NOT NULL COMMENT '注册IP',
  `qq` bigint(20) unsigned NOT NULL COMMENT 'QQ',
  `sex` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '性别',
  `idc` char(18) NOT NULL COMMENT '身份证',
  `over` decimal(7,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '账户余额',
  `name` varchar(10) NOT NULL COMMENT '姓名',
  `job` varchar(10) NOT NULL COMMENT '职业',
  `address` varchar(50) NOT NULL COMMENT '地址',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户详细信息';"
);
$db->exec(
"CREATE TABLE `user_record` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned NOT NULL COMMENT '用户id',
  `authority` int(11) unsigned NOT NULL COMMENT '用户组别',
  `ip` int(11) unsigned NOT NULL COMMENT '登陆IP',
  `times` int(11) unsigned NOT NULL COMMENT '登陆时间',
  `auto` tinyint(1) unsigned NOT NULL COMMENT '自动登录',
  `device` varchar(10) NOT NULL DEFAULT '' COMMENT '登陆设备',
  `browser` varchar(10) NOT NULL DEFAULT '' COMMENT '浏览器',
  `os` varchar(10) NOT NULL DEFAULT '' COMMENT '操作系统',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='记录每次用户的登陆信息';"
);
$db->exec(
"CREATE TABLE `links` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tid` int(11) unsigned NOT NULL COMMENT '分类id',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `indexs` tinyint(1) NOT NULL DEFAULT '0' COMMENT '置顶排序',
  `color` varchar(10) NOT NULL DEFAULT '' COMMENT 'css样式',
  `target` varchar(10) NOT NULL COMMENT '跳转方式',
  `tit` varchar(30) NOT NULL DEFAULT '' COMMENT '标题',
  `href` varchar(100) NOT NULL DEFAULT '' COMMENT '链接地址',
  `image` varchar(100) NOT NULL DEFAULT '' COMMENT '图片',
  `cont` varchar(200) NOT NULL DEFAULT '' COMMENT '简介',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;"
);
$db->exec(
"CREATE TABLE `admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned NOT NULL COMMENT '用户ID',
  `tid` int(11) unsigned NOT NULL COMMENT '分类ID',
  PRIMARY KEY (`id`),
  KEY `index` (`uid`,`tid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='系统管理员';"
);

$db->exec(
"CREATE TABLE `article` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned NOT NULL COMMENT '用户ID',
  `upid` int(11) unsigned NOT NULL COMMENT '上级分类ID',
  `tid` int(11) unsigned NOT NULL COMMENT '分类ID',
  `createtime` int(11) unsigned NOT NULL COMMENT '创建时间',
  `click` int(11) unsigned NOT NULL COMMENT '点击量',
  `pg` smallint(5) unsigned NOT NULL COMMENT '分页总数',
  `tag` varchar(10) NOT NULL DEFAULT '' COMMENT '标签,间隔',
  `tit` varchar(30) NOT NULL COMMENT '文章标题',
  `source` varchar(30) NOT NULL DEFAULT '' COMMENT '来源',
  `editor` varchar(30) NOT NULL DEFAULT '' COMMENT '编辑',
  `note` varchar(100) NOT NULL DEFAULT '' COMMENT '文章简介',
  `image` varchar(100) NOT NULL DEFAULT '' COMMENT '缩略图',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='文章集合';"
);
$db->exec(
"CREATE TABLE `article_detail` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `aid` int(11) unsigned NOT NULL COMMENT '文章集合id',
  `page` smallint(5) unsigned NOT NULL COMMENT '分页数',
  `tits` varchar(30) NOT NULL DEFAULT '' COMMENT '分页小标题',
  `article` text NOT NULL COMMENT '文章内容',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='文章详细内容';"
);
$db->exec(
"CREATE TABLE `article_image` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned NOT NULL COMMENT '用户编号',
  `page` smallint(5) unsigned NOT NULL COMMENT '图片分页',
  `aid` int(11) unsigned NOT NULL COMMENT '文章ID',
  `img` varchar(100) NOT NULL DEFAULT '' COMMENT '图片地址',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='详细图片';"
);


if(!$db->table('user')->where('phone=? or email=?',$systemAccount['phone'],$systemAccount['email'])->count()){
  // 创建系统用户
  $uid = $db->table('user')
            ->field('phone','email','pwd','createtime','authority')
            ->value(
              $systemAccount['phone'],
              $systemAccount['email'],
              md5($systemAccount['pwd'].$_SERVER['REQUEST_TIME'].$systemAccount['phone']),
              $_SERVER['REQUEST_TIME'],
              120000
            )
            ->insert();
  $db->table('user_detail')
            ->field('id')
            ->value($uid)
            ->insert();
  echo '<br/>系统管理员创建成功!<br/>';

  // 创建后台模块管理 及操作权限
  // ---先创建模块管理
  $adminId = $db->table('type')->field('tit','tp','cont')->value('后台模块','admin','admin')->insert();
    $sysId   = $db->table('type')->field('upid','tit','tp','cont')->value($adminId,'系统设置','admin','system')->insert();
      $db->table('admin')->field('uid','tid')->value($uid,$sysId)->insert();
    $sid   = $db->table('type')->field('upid','tit','tp','cont')->value($sysId,'系统信息','admin','SysInfo')->insert();
      $db->table('admin')->field('uid','tid')->value($uid,$sid)->insert();
    $cid = $db->table('type')->field('upid','tit','tp','cont')->value($sysId,'缓存控制','admin','SysCache')->insert();
      $db->table('admin')->field('uid','tid')->value($uid,$cid)->insert();
    $tid = $db->table('type')->field('upid','tit','tp','cont')->value($sysId,'分类管理','admin','SysType')->insert();
      $db->table('admin')->field('uid','tid')->value($uid,$tid)->insert();
    $rid = $db->table('type')->field('upid','tit','tp','cont')->value($sysId,'网站修复','admin','SysRestore')->insert();
      $db->table('admin')->field('uid','tid')->value($uid,$rid)->insert();
    $aid = $db->table('type')->field('upid','tit','tp','cont')->value($sysId,'权限管理','admin','SysAuthority')->insert();
      $db->table('admin')->field('uid','tid')->value($uid,$aid)->insert();
    $mid = $db->table('type')->field('upid','tit','tp','cont')->value($sysId,'后台模块','admin','SysModule')->insert();
      $db->table('admin')->field('uid','tid')->value($uid,$mid)->insert();
    $usrId  = $db->table('type')->field('upid','tit','tp','cont')->value($adminId,'用户中心','admin','user')->insert();
      $db->table('admin')->field('uid','tid')->value($uid,$usrId)->insert();
    $umid = $db->table('type')->field('upid','tit','tp','cont')->value($usrId,'用户管理','admin','UserManage')->insert();
      $db->table('admin')->field('uid','tid')->value($uid,$umid)->insert();


    $contId   = $db->table('type')->field('upid','tit','tp','cont')->value($adminId,'内容管理','admin','content')->insert();
      $db->table('admin')->field('uid','tid')->value($uid,$contId)->insert();
      $lid   = $db->table('type')->field('upid','tit','tp','cont')->value($contId,'页面链接管理','admin','ContLink')->insert();
        $db->table('admin')->field('uid','tid')->value($uid,$lid)->insert();
      $aid   = $db->table('type')->field('upid','tit','tp','cont')->value($contId,'文章内容管理','admin','ContArticle')->insert();
        $db->table('admin')->field('uid','tid')->value($uid,$aid)->insert();
      $iid   = $db->table('type')->field('upid','tit','tp','cont')->value($contId,'图片内容管理','admin','ContImage')->insert();
        $db->table('admin')->field('uid','tid')->value($uid,$iid)->insert();

// 链接管理
$linksid   = $db->table('type')->field('upid','tit','tp','cont')->value(0,'链接管理','links','链接管理')->insert();
// 内容管理
$contid   = $db->table('type')->field('upid','tit','tp','cont')->value(0,'内容管理','article','内容管理')->insert();
$articleid   = $db->table('type')->field('upid','tit','tp','cont')->value($contid,'文章内容管理','article','文章内容管理')->insert();
$imageid   = $db->table('type')->field('upid','tit','tp','cont')->value($contid,'图片内容管理','image','图片内容管理')->insert();


$file = file_get_contents('website.conf.default.php');
$file = str_replace(
  array('":adminid"','":linksid"','":aritcleid"','":imageid"'),
  array($adminId,$linksid,$articleid,$imageid),
  $file
);
file_put_contents('website.conf.php',$file);

include('../opt/act/system/restore.php');
act_restore_type($website);

}else{
  echo '<br/>数据库已存在!<br/>';
}



















exit();
