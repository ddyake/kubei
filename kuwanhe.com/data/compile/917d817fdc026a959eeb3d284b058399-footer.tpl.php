<script type="text/javascript" src="<?php echo fn_url(array('href'=>'/js/min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo fn_url(array('href'=>'/js/plugin.js')); ?>"></script>
<script type="text/javascript" src="<?php echo fn_url(array('href'=>'/js/public.js')); ?>"></script>
<?php if (isset($jss) && is_array($jss)){foreach($jss as $js){ ?>
<script type="text/javascript" src="<?php echo fn_url(array('href'=>$js)); ?>"></script>
<?php }} ?>

</body>
</html>
