	<link type="text/css" rel="stylesheet" href="<?php echo fn_url(array('href'=>'/css/global.css')); ?>">
    <?php if (isset($css) && is_array($css)){foreach($css as $cs){ ?>
    <link type="text/css" rel="stylesheet" href="<?php echo fn_url(array('href'=>$cs)); ?>">
    <?php }} ?>
