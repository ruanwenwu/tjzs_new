/**
 * 
 */
$(function(){
	//$(".registerform").Validform();  //就这一行代码！;
	
	//方法一;
	$("#xxx").Validform({
		ajaxPost:true,
		ignoreHidden:false,
		tiptype:function(msg,o,cssctl){
			//msg：提示信息;
			//o:{obj:*,type:*,curform:*}, obj指向的是当前验证的表单元素（或表单对象），type指示提示的状态，值为1、2、3、4， 1：正在检测/提交数据，2：通过验证，3：验证失败，4：提示ignore状态, curform为当前form对象;
			//cssctl:内置的提示信息样式控制函数，该函数需传入两个参数：显示提示信息的对象 和 当前提示的状态（既形参o中的type）;
			if(!o.obj.is("form")){//验证表单元素时o.obj为该表单元素，全部验证通过提交表单时o.obj为该表单对象;
				var objtip=o.obj.siblings(".Validform_checktip");
				cssctl(objtip,o.type);
				objtip.text(msg);
			}else{
				var objtip=o.obj.find("#msgdemo");
				cssctl(objtip,o.type);
				objtip.text(msg);
			}
		},
		callback:function(data){
			if(data.status=="y"){
				$("button[type=submit]").attr("disabled",true);
				/*setTimeout(function(){
					//$.Hidemsg(); //公用方法关闭信息提示框;显示方法是$.Showmsg("message goes here.");
					//alert
				},2000);*/
				alert("修改成功");
				
			}else{
				alert("没做出任何修改");
			}
		}
	});
	
	//图片异步上传并实时显示
	$("input[type=file]").change(function(){
		 var prevDiv = $("#"+$(this).attr("t")+"-preview").get(0);
		 if (this.files && this.files[0])  
		 {  
			 var reader = new FileReader();
			 var self = this;
			 reader.onload = function(evt){  
				 prevDiv.innerHTML = '<img src="' + evt.target.result + '" />'; 
				 var oMyForm = new FormData();
				 
				 oMyForm.append(self.getAttribute("name"), self.files[0]);
				 oMyForm.append("accountnum", 123456); // 数字123456被立即转换成字符串"123456"
				  
				  
				 var oReq = new XMLHttpRequest();
				 oReq.responseType = "json";
				 oReq.open("POST", "/manage/index.php?c=ajax&a=upload");
				 oReq.send(oMyForm);
				 oReq.onload = function(){
					 var response = this.response[self.getAttribute("name")];
					 $("#"+self.getAttribute("name")+"d").val(response.savepath+response.savename);
				 }
				
			 } 
	     
		     reader.readAsDataURL(this.files[0]); 	//显示图片到本地，然后上传图片
		    
		 }
	});
});