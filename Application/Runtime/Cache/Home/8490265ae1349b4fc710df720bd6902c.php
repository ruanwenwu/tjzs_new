<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no"/>
		<link rel="stylesheet" href="https://g.alicdn.com/de/prismplayer/2.3.5/skins/default/aliplayer-min.css" />
		<script type="text/javascript" src="https://g.alicdn.com/de/prismplayer/2.4.0/aliplayer-flash-min.js"></script>
	</head>
	<body>
		<div class="prism-player" id="J_prismPlayer"></div>
		<script>
			var player = Aliplayer({
				id: "J_prismPlayer",
				autoplay: false,
				width: "400px",
				height: "300px",
				vid: "<?php echo ($videoId); ?>",
				playauth: "<?php echo ($playAuth); ?>",
				});
		</script>
	</body>
</html>