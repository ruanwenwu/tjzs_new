<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
 <head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no"/>
   <title>加密视频测试页面</title>
   <link rel="stylesheet" href="//g.alicdn.com/de/prismplayer/2.2.0/skins/default/aliplayer-min.css" />
   <script type="text/javascript" src="//g.alicdn.com/de/prismplayer/2.2.0/aliplayer-min.js"></script>
 </head>
 <body>
   <div class="prism-player" id="J_prismPlayer"></div>
   <script type="text/javascript">
     var player = new Aliplayer({
                          id: 'J_prismPlayer',
                          width: '100%',
                          height:'540px',
                          barMode: 0,
                          autoplay: false,
                          useFlashPrism:true,
                          vid: '<?php echo ($videoId); ?>',
                          playauth: '<?php echo ($playAuth); ?>'
                 });
   </script>
 </body>
 </html>