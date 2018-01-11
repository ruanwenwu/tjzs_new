<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1,minimum-scale=1,user-scalable=no">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title><?php echo ($seo['title']); ?></title>

    <!-- Bootstrap -->
	<link rel="stylesheet" href="/Public/jqueryweui/dist/lib/weui.css">
	<!--<link rel="stylesheet" href="/Public/node_modules/weui/dist/lib/weui.css">-->
	<link rel="stylesheet" href="/Public/jqueryweui/dist/css/jquery-weui.css">
	
	
	

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>
  <body>
	<div class="home">
	
        <div class="weui_cells weui_cells_form">
            <div class="weui_cell">
                <div class="weui_cell_hd"><label class="weui_label">真实姓名</label></div>
                <div class="weui_cell_bd weui_cell_primary">
                    <input id="name" class="weui_input" type="text" pattern="[\u4e00-\u9fa5]*" placeholder="您身份证上的姓名"/>
                </div>
            </div>
            <div class="weui_cell">
                <div class="weui_cell_hd"><label class="weui_label">身份证号</label></div>
                <div class="weui_cell_bd weui_cell_primary">
                    <input id="idcard" class="weui_input"  pattern="^(\d{6})(\d{4})(\d{2})(\d{2})(\d{3})([0-9]|X)$"
                           placeholder="15位或者18位身份证号码"/>
                </div>
            </div>
            <div class="weui_cell">
                <div class="weui_cell_hd"><label class="weui_label">手机号</label></div>
                <div class="weui_cell_bd weui_cell_primary">
                    <input id="phone" class="weui_input" type="number" pattern="/^1\d{10}$/"
                           placeholder="您正在使用的手机号"/>
                </div>
            </div>
            <div class="weui_cell">
                <div class="weui_cell_hd"><label class="weui_label">性别</label></div>
                <div class="weui_cell_bd weui_cell_primary">
                		<select name="sex" id="sex">
                			<option selected value="1">男</option>
                			<option value="2">女</option>   
                		</select>
                </div>  
            </div>
        </div>
        <div class="weui_btn_area">
            <a class="weui_btn weui_btn_primary" href="javascript:" id="submit">提交</a>
        </div>
        <div class="weui_toptips weui_warn js_tooltips" style="display: none;">��ʽ����</div>

	</div>	

	<script src="/Public/jqueryweui/dist/lib/jquery-2.1.4.js"></script>
	<script src="/Public/jqueryweui/dist/js/jquery-weui.js"></script>
	
	
    <script>
    $(function(){
        $("#submit").click(function () {
        		//检查表单
        		var patt1 = new RegExp("[\u4e00-\u9fa5]+");
        		if (!patt1.test($("#name").val())){
        			$.alert("请输入合法的真实姓名");
        			return false;
        		}   

        		var patt2 = /(^[1-9]\d{5}(18|19|([23]\d))\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{3}[0-9Xx]$)|(^[1-9]\d{5}\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{2}$)/;
        		if (!patt2.test($("#idcard").val())){
        			$.alert("请输入合法的身份证号码");
        			return false;  
        		}
        		var patt3 = /\d{11}/;
        		if (!patt3.test($("#phone").val())){
        			$.alert("请输入合法的手机号码");
        			return false;  
        		}  

            $.showLoading("正在提交...");
            var data = {
                "name": $("#name").val(),
                "idcard": $("#idcard").val(),
                "phone": $("#phone").val(),
                "sex":$("#sex").val()
            };  
            
           var url = "/index.php/Home/User/doBind"; 
            $.post(url, data, function (data) {
                $.hideLoading();
                if (data.code == 1) { //成功
                			location.href="<?php echo $backurl; ?>";
                } else if (data.code == 0) {     
                    $.alert(data.message);
                }
            },"json");
        });
    });   
    </script>

  </body>
</html>