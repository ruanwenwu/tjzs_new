<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>天津中医药大学第一附属医院</title>
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<meta name="format-detection" content="email=no">
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,minimum-scale=1,user-scalable=0">
<link href="/app/css/weui1.css" rel="stylesheet">
	<link rel="stylesheet" href="/Public/jqueryweui/dist/lib/weui.css">
	<!--<link rel="stylesheet" href="/Public/node_modules/weui/dist/lib/weui.css">-->
	<link rel="stylesheet" href="/Public/jqueryweui/dist/css/jquery-weui.css">
</head>
<body class=" pace-done">
<div class="pace pace-inactive">
	<div class="pace-progress" style="transform: translate3d(100%, 0px, 0px);" data-progress-text="100%" data-progress="99">
		<div class="pace-progress-inner">
		</div>
	</div>
	<div class="pace-activity">
	</div>
</div>
<div class="page">
	<div class="container" _v-3a85f76e="">
		
		<div id="" class="" _v-3a85f76e="" style="">
			<div class="scroller" _v-3a85f76e="" style="transition-property: transform; transform-origin: 0px 0px 0px; transform: translate(0px, 0px) scale(1) translateZ(0px);">
				<div class="weui-panel weui-panel_access">
				  <div class="weui-panel__hd">预约须知</div>
				  <div class="weui-panel__bd">
				  <?php if(is_array($guahao)): foreach($guahao as $key=>$vo): ?><a href="javascript:void(0);" class="weui-media-box weui-media-box_appmsg">
				      <div class="weui-media-box__bd">   
				      
				        <p class="weui-media-box__desc"><?php echo ($vo); ?></p>
				      </div>
				    </a><?php endforeach; endif; ?>
				  </div>
				 
				</div>
				<!--fragment-start-->
				<div style="height:8px;">
				</div>
				<!--<div class="am-ft-center am-ft-13 am-ft-darkgray">
      金融支持：
					<img src="/Images/boc.png" style="height:18px;width:auto;">中国银行;技术支持：倍康益众
				</div>-->
				<div style="height:8px;">
				</div>
				<!--fragment-end--><!--v-partial-->
			</div>
		</div>
	</div>
	<!--v-component-->
	<div class="weui_dialog_alert" style="display: none;">
		<div class="weui_mask">
		</div>
		<div class="weui_dialog">
			<div class="weui_dialog_hd">
				<strong class="weui_dialog_title">标题</strong>
			</div>
			<div class="weui_dialog_bd">
				正文
			</div>
			<div class="weui_dialog_ft">
				<a href="javascript:;" class="weui_btn_dialog primary">确定</a>
			</div>
		</div>
	</div>
	<!--v-component-->
	<div class="weui_dialog_confirm" style="display: none;">
		<div class="weui_mask">
		</div>
		<div class="weui_dialog">
			<div class="weui_dialog_hd">
				<strong class="weui_dialog_title">标题</strong>
			</div>
			<div class="weui_dialog_bd">
				正文
			</div>
			<div class="weui_dialog_ft">
				<a href="javascript:;" class="weui_btn_dialog default">取消</a><a href="javascript:;" class="weui_btn_dialog primary">确定</a>
			</div>
		</div>
	</div>
	<!--v-component-->
	<div _v-63e5f651="">
		<div _v-63e5f651="" style="display: none;">
			<div class="weui_toast_common" _v-63e5f651="">
				<p class="weui_toast_content_common" _v-63e5f651="">
					内容
				</p>
			</div>
		</div>
		<div class="weui_loading_toast" _v-63e5f651="" style="display: none;">
			<div class="weui_mask_transparent" _v-63e5f651="">
			</div>
			<div class="weui_toast" _v-63e5f651="">
				<div class="weui_loading" _v-63e5f651="">
					<div class="weui_loading_leaf weui_loading_leaf_0" _v-63e5f651="">
					</div>
					<div class="weui_loading_leaf weui_loading_leaf_1" _v-63e5f651="">
					</div>
					<div class="weui_loading_leaf weui_loading_leaf_2" _v-63e5f651="">
					</div>
					<div class="weui_loading_leaf weui_loading_leaf_3" _v-63e5f651="">
					</div>
					<div class="weui_loading_leaf weui_loading_leaf_4" _v-63e5f651="">
					</div>
					<div class="weui_loading_leaf weui_loading_leaf_5" _v-63e5f651="">
					</div>
					<div class="weui_loading_leaf weui_loading_leaf_6" _v-63e5f651="">
					</div>
					<div class="weui_loading_leaf weui_loading_leaf_7" _v-63e5f651="">
					</div>
					<div class="weui_loading_leaf weui_loading_leaf_8" _v-63e5f651="">
					</div>
					<div class="weui_loading_leaf weui_loading_leaf_9" _v-63e5f651="">
					</div>
					<div class="weui_loading_leaf weui_loading_leaf_10" _v-63e5f651="">
					</div>
					<div class="weui_loading_leaf weui_loading_leaf_11" _v-63e5f651="">
					</div>
				</div>
				<p class="weui_toast_content" _v-63e5f651="">
					加载中...
				</p>
			</div>
		</div>
		<div _v-63e5f651="" style="display: none;">
			<div class="weui_mask_transparent" _v-63e5f651="">
			</div>
			<div class="weui_toast" _v-63e5f651="">
				<i class="weui_icon_toast" _v-63e5f651=""></i>
				<p class="weui_toast_content" _v-63e5f651="">
					已完成
				</p>
			</div>
		</div>
	</div>
	<!--v-component-->
</div>
<script src="//cdn.bootcss.com/jquery/2.2.1/jquery.min.js"></script>
</body>
</html>