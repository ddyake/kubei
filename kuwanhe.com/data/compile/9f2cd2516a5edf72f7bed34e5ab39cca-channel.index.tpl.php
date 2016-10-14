<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="keywords" content="<?php echo $keywords; ?>" />
    <meta name="description" content="<?php echo $description; ?>" />
    <title><?php echo $tit; ?></title>
    <?php if (isset($css) && is_array($css)){foreach($css as $cs){ ?>
    <link type="text/css" rel="stylesheet" href="<?php echo fn_url(array('href'=>$cs)); ?>">
    <?php }} ?>
</head>

<body>
<div class="m-index">

<?php if($cid){ ?>
<?php if(!$login){ ?>
<div class="login">
  输入密码：<input type="password" /><input type="hidden" value='<?php echo $cid; ?>' /> <button>登录</button>
</div>
<?php }else{ ?>
<table>
  <thead>
    <tr>
      <th>渠道名称</th>
      <th>开始时间</th>
      <th>下载数量</th>
      <th>安装量</th>
      <th>卸载量</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><?php echo $channel['tit']; ?></td>
      <td><?php echo date('Y-m-d',$channel['createtime']); ?></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
  </tbody>
  <tfoot>

  </tfoot>
</table>
<?php } ?>


</div>





<?php }else{ ?>
<h2>请输入正确渠道链接!</h2>
<?php } ?>



<script type="text/javascript" src="<?php echo fn_url(array('href'=>'/js/min.js')); ?>"></script>
<?php if (isset($jss) && is_array($jss)){foreach($jss as $js){ ?>
<script type="text/javascript" src="<?php echo fn_url(array('href'=>$js)); ?>"></script>
<?php }} ?>
</body>
</html>
