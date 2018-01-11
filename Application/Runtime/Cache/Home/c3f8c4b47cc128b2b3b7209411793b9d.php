<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title><?php echo ($deptInfo['name']); ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<style>
			div{
				padding:0px 10px 10px 10px;
			}
			h2{text-align:center;}
		</style>
	</head>

	<body>
		<h2><?php echo ($deptInfo['name']); ?>	</h2>
		<div>
<?php echo ($deptInfo['brief']); ?>	
		</div>	
	</body>
</html>