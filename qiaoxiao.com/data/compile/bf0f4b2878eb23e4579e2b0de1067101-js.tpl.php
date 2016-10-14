    <script type="text/javascript" src="<?php echo fn_url(array('href'=>'/js/min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo fn_url(array('href'=>'/js/plugin.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo fn_url(array('href'=>'/js/public.js')); ?>"></script>
    <?php if (isset($jss) && is_array($jss)){foreach($jss as $js){ ?>
    <script type="text/javascript" src="<?php echo fn_url(array('href'=>$js)); ?>"></script>
    <?php }} ?>
    <!-- <script type="text/javascript">
      var _hmt = _hmt || [];
      (function() {
        var hm = document.createElement("script");
        hm.src = "//hm.baidu.com/hm.js?89d7300ea5a4633a73a6751712c5b352";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
      })();
    </script> -->
