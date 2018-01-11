<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Demo</title>
   <!--  IE需要es6-promise -->
    <script src="/Public/jquery-3.2.1.min.js"></script>
    <script src="/Public/aliyun-vod-upload-js-sdk-1.2.0/lib/es6-promise.min.js"></script>
    <script src="/Public/aliyun-vod-upload-js-sdk-1.2.0/lib/aliyun-oss-sdk.min.js"></script>
    <script src="/Public/aliyun-vod-upload-js-sdk-1.2.0/aliyun-vod-upload-sdk-1.2.0.min.js"></script>
</head>
<body>
	<form action="">
		<input type="file" name="file" id="files" multiple/>
	</form>
	<input type="button" value="开始上传" id="startUpload" />

   <script>
   var uploadAuth, uploadAddress;
   getUploadAddressAndAuth();
   var uploader = new AliyunUpload.Vod({
	     //分片大小默认1M
	     partSize: 1048576,
	     //并行上传分片个数，默认5
	     parallel: 5,
	     //网络原因失败时，重新上传次数，默认为3
	     retryCount: 3,
	     //网络原因失败时，重新上传间隔时间，默认为2秒
	     retryDuration: 2,
	    // 开始上传
	    'onUploadstarted': function (uploadInfo) {
	      console.log("onUploadStarted:" + uploadInfo.file.name + ", endpoint:" + uploadInfo.endpoint + ", bucket:" + uploadInfo.bucket + ", object:" + uploadInfo.object);
	      uploader.setUploadAuthAndAddress(uploadInfo, uploadAuth, uploadAddress);
	    },
	    // 文件上传成功
	    'onUploadSucceed': function (uploadInfo) {
	      console.log("onUploadSucceed: " + uploadInfo.file.name + ", endpoint:" + uploadInfo.endpoint + ", bucket:" + uploadInfo.bucket + ", object:" + uploadInfo.object);
	    },
	    // 文件上传失败
	    'onUploadFailed': function (uploadInfo, code, message) {
	      console.log("onUploadFailed: file:" + uploadInfo.file.name + ",code:" + code + ", message:" + message);
	    },
	    // 文件上传进度，单位：字节
	    'onUploadProgress': function (uploadInfo, totalSize, loadedPercent) {
	    	console.log("onUploadProgress:file:" + uploadInfo.file.name + ", fileSize:" + totalSize + ", percent:" + Math.ceil(loadedPercent * 100) + "%");
	    },
	    // 上传凭证超时
	    'onUploadTokenExpired': function () {
	    	console.console.log("onUploadTokenExpired");
	        // uploader.resumeUploadWithAuth(uploadAuth);
	    },
	    
	});
   
   function getUploadAddressAndAuth(){
	   	var url = "/index.php/Home/Test/getVideoUploadAuth";
		$.ajax({
			type: 'POST',
		  	url: url,
		  	data: {},
		  	success: function(response){
		  		uploadAuth = response.auth;
		  		uploadAddress = response.addr;
		  	},
		  	dataType: 'json',
		  	async:true
		});
   }
   
   userData = '';
   document.getElementById("files").addEventListener('change', function (event) {
      for(var i=0; i<event.target.files.length; i++) {
    	  uploader.addFile(event.target.files[i], null, null, null, userData);// 逻辑代码
      }
   });
   
   document.getElementById("startUpload").onclick = function(){
	   uploader.startUpload();
   }
   </script>
</body>
</html>