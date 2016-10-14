    <script type="text/javascript" src="<?php echo fn_url(array('href'=>'/js/min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo fn_url(array('href'=>'/js/plugin.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo fn_url(array('href'=>'/js/public.js')); ?>"></script>
    <script src="http://s95.cnzz.com/z_stat.php?id=1260365517&web_id=1260365517" language="JavaScript"></script>
    <?php if (isset($jss) && is_array($jss)){foreach($jss as $js){ ?>
    <script type="text/javascript" src="<?php echo fn_url(array('href'=>$js)); ?>"></script>
    <?php }} ?>
