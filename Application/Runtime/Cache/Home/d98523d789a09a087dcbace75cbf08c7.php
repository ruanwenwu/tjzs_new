<?php if (!defined('THINK_PATH')) exit();?><html lang="en">
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
<script src="//cdn.bootcss.com/pace/1.0.2/pace.min.js"></script>
<link href="//cdn.bootcss.com/pace/1.0.2/themes/black/pace-theme-big-counter.css" rel="stylesheet">
<link rel="stylesheet" href="//cdn.bootcss.com/weui/0.4.0/style/weui.min.css">
<link rel="stylesheet" href="//cdn.bootcss.com/font-awesome/4.5.0/css/font-awesome.min.css">
<link href="/app/css/weui1.css" rel="stylesheet">
	<link rel="stylesheet" href="/Public/jqueryweui/dist/lib/weui.css">
	<!--<link rel="stylesheet" href="/Public/node_modules/weui/dist/lib/weui.css">-->
	<link rel="stylesheet" href="/Public/jqueryweui/dist/css/jquery-weui.css">
<link href="/app/css/timespan.css" rel="stylesheet">
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
	<div class="container" _v-0be13b8c="">
		<div id="reg-detail" class="reg-detail weui-cells_form" _v-0be13b8c="">
			<!--<div class="weui_cells_title" _v-0be13b8c="">
				就诊卡：
			</div>-->
			<div class="weui_cells weui_cells_access " style="margin-top:10px" _v-0be13b8c="">
				<a class="weui_cell" href="javascript:;" _v-0be13b8c="">
				<div class="weui_cell_hd" _v-0be13b8c="">
					<i class="fa fa-credit-card fa-2x icon-color" style="width:45px;margin-right:5px;display:block" _v-0be13b8c=""></i>
				</div>
				<div class="weui_cell_bd weui_cell_primary" _v-0be13b8c="">
					<p _v-0be13b8c="">
						<?php echo ($userInfo['patientname']); ?> <span style="margin-left:15px" class="blue_tag" _v-0be13b8c="">就诊信息</span>
					</p>
					<p _v-0be13b8c="">
						<?php echo ($userInfo['phoneno']); ?>
					</p>
				</div>
				<!--<div class="weui_cell_ft" _v-0be13b8c="">
					 选就诊卡
				</div>-->
				</a>
			</div>
			<div class="weui_cells_title" _v-0be13b8c="">
				挂号详情：
			</div>
			<div class="weui_cells" _v-0be13b8c="">
				<div class="weui_cell" _v-0be13b8c="">
					<div class="weui_cell_bd weui_cell_primary" _v-0be13b8c="">
						<p _v-0be13b8c="">
							<span class="label" _v-0be13b8c="">科&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;室</span><span class="info" _v-0be13b8c=""><?php echo ($deptInfo['deptname']); ?></span>
						</p>
					</div>
				</div>
				<div class="weui_cell" _v-0be13b8c="">
					<div class="weui_cell_bd weui_cell_primary" _v-0be13b8c="">
						<p _v-0be13b8c="">
							<span class="label" _v-0be13b8c="">医&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;生</span><span class="info" _v-0be13b8c=""><?php echo ($docInfo['doctorname']); ?></span>
						</p>
					</div>
				</div>
				<div class="weui_cell" _v-0be13b8c="">
					<div class="weui_cell_bd weui_cell_primary" _v-0be13b8c="">
						<p _v-0be13b8c="">
							<span class="label" _v-0be13b8c="">号&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;类</span><span class="info" _v-0be13b8c=""><?php echo ($visitTypeInfo['visitname']); ?></span>
						</p>
					</div>
				</div>
				<div class="weui_cell" _v-0be13b8c="">
					<div class="weui_cell_bd weui_cell_primary" _v-0be13b8c="">
						<p _v-0be13b8c="">
							<span class="label" _v-0be13b8c="">就诊日期</span><span class="info" _v-0be13b8c=""><?php echo ($realInfo['visitdate']); ?></span>
						</p>
					</div>
				</div>
				<div class="weui_cell" _v-0be13b8c="">
					<div class="weui_cell_bd weui_cell_primary" _v-0be13b8c="">
						<p _v-0be13b8c="">
							<span class="label" _v-0be13b8c="">就诊时间</span><span class="info" _v-0be13b8c=""><?php echo ($periodName); ?></span>
						</p>
					</div>
				</div>
				<div class="weui_cell" _v-0be13b8c="">
					<div class="weui_cell_bd weui_cell_primary" _v-0be13b8c="">
						<p _v-0be13b8c="">
							<span class="label" _v-0be13b8c="">挂&nbsp;&nbsp;号&nbsp;&nbsp;费</span><span class="info" _v-0be13b8c=""><?php echo ($visitTypeInfo['cost']); ?> 元</span>
						</p>
					</div>
				</div>
				<div class="demos-content-padded" style="padding:1px 10px" _v-0be13b8c="">
					<?php if($status == 1): ?><a id="cancelAppoint" href="javascript:;" class="weui-btn weui-btn_plain-default">取消本次预约</a>
					<?php elseif($status == 2): ?>
					<a href="javascript:;" class="weui-btn weui-btn_plain-default">预约失败</a>
					<?php else: ?>
					<a href="javascript:;" class="weui-btn weui-btn_plain-default">已取消</a><?php endif; ?>
				</div>
			</div>
			<div _v-0be13b8c="">
				<p style="padding:10px" class="am-ft-sm am-ft-gray" _v-0be13b8c="">
					<span class="am-ft-orange" _v-0be13b8c=""><i class="fa fa-info-circle" _v-0be13b8c=""></i></span> 微信挂号支付只支持自费及普通医保，暂不支持公费！
				</p>
			</div>
		</div>  
		<div class="reg-success" id="reg-success" _v-0be13b8c="" style="display:none">
			<div class="weui_msg" _v-0be13b8c="">
				<div class="weui_icon_area" _v-0be13b8c="">
					<i class="weui_icon_success weui_icon_msg" _v-0be13b8c=""></i>
				</div>
				<div class="weui_text_area" _v-0be13b8c="">
					<h2 class="weui_msg_title" _v-0be13b8c="">挂号成功</h2>
					<p class="weui_msg_desc" _v-0be13b8c="">
						 请牢记您的就诊时间:<?php echo ($realInfo['visitdate']); ?> <?php echo ($periodName); ?> (序号:4), 就诊医生:<?php echo ($deptInfo['deptname']); ?> <?php echo ($docInfo['doctorname']); ?>
					</p>
				</div>
				<div class="weui_opr_area" _v-0be13b8c="">
					<p class="weui_btn_area" _v-0be13b8c="">
						<a href="javascript:;" class="weui_btn weui_btn_primary" _v-0be13b8c="">查看详情</a>
					</p>
				</div>
			</div>
		</div>
		<div class="reg-failed" _v-0be13b8c="" style="display: none;">
			<div class="weui_msg" _v-0be13b8c="">
				<div class="weui_icon_area" _v-0be13b8c="">  
					<i class="weui_icon_warn weui_icon_msg" _v-0be13b8c=""></i>
				</div>
				<div class="weui_text_area" _v-0be13b8c="">
					<h2 class="weui_msg_title" _v-0be13b8c="">已取消</h2>
					<p class="weui_msg_desc" _v-0be13b8c="">
					</p>
				</div>
				<div class="weui_opr_area" _v-0be13b8c="">
					<p class="weui_btn_area" _v-0be13b8c="">
						<a href="http://www.tjzsyl.com" class="weui_btn weui_btn_primary" _v-0be13b8c="">返回首页</a>
					</p>
				</div>
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
<script src="/Public/jqueryweui/dist/js/jquery-weui.js"></script>
<script>
$("#cancelAppoint").click(function(){
	var url = "/index.php/Home/Api/cancelAppointment";
	var data = {"tpid":'<?php echo $realInfo['tpid']; ?>',"hid":'<?php echo $realInfo['hid']; ?>',"appointCode":'<?php echo $appointcode; ?>'};
	$.post(url,data,function(response){
		console.log(response);
		if(response.result == "00000000"){
			$("#reg-detail").hide();
			$(".reg-failed").show();
		} else {
			$.alert(response.message);  
		}
	},"json");
});
</script>