<script type="text/javascript" src="<?php echo fn_url(array('href'=>'/js/min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo fn_url(array('href'=>'/js/mobile/swiper.js')); ?>"></script>
<script type="text/javascript" src="<?php echo fn_url(array('href'=>'/js/mobile/public.js')); ?>"></script>
<?php if (isset($jss) && is_array($jss)){foreach($jss as $js){ ?>
<script type="text/javascript" src="<?php echo fn_url(array('href'=>$js)); ?>"></script>
<?php }} ?>
<?php require_once 'cs.php';echo '<img src="'._cnzzTrackPageView(1260557375).'" style="display:none" />'; ?>
