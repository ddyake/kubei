<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="keywords" content="<?php echo $keywords; ?>" />
    <meta name="description" content="<?php echo $description; ?>" />
    <title><?php echo $tit; ?></title>
    <link type="text/css" rel="stylesheet" href="<?php echo fn_url(array('href'=>'/css/global.css')); ?>">
    <?php if (isset($css) && is_array($css)){foreach($css as $cs){ ?>
    <link type="text/css" rel="stylesheet" href="<?php echo fn_url(array('href'=>$cs)); ?>">
    <?php }} ?>
</head>

<body>
