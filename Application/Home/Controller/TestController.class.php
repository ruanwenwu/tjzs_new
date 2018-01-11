<?php
namespace Home\Controller;
use vod\Request\V20170321 as vod;
use \Profile\DefaultProfile;

class TestController extends \Think\Controller{
    public function test(){
            $regionId = 'cn-shanghai';
            $access_key_id = "LTAInydAA57dVOCE";
            $access_key_secret="WE8cAr64vsUziEwmwXjOs8Qi74cylx";
            $videoId = '92f6aebef9784b9bb23c745dfe0cb74f';
            $client = $this->init_vod_client($access_key_id,$access_key_secret);
            $res = $this->get_play_info($client,$videoId);
            var_dump($res);die;
            $this->display();
    }
    
    function init_vod_client($accessKeyId, $accessKeySecret) {
        $regionId = 'cn-shanghai';  // 点播服务所在的Region，国内请填cn-shanghai，不要填写别的区域
        $profile = \DefaultProfile::getProfile($regionId, $accessKeyId, $accessKeySecret);
        return new \DefaultAcsClient($profile);
    }
    function get_play_info($client, $videoId) {
        $request = new vod\GetPlayInfoRequest();
        $request->setVideoId($videoId);
        $request->setAcceptFormat('JSON');
        return $client->getAcsResponse($request);
    }
    
    function getPlayAuthDo(){
        $regionId = 'cn-shanghai';
        $access_key_id = "LTAInydAA57dVOCE";
        $access_key_secret="WE8cAr64vsUziEwmwXjOs8Qi74cylx";
        $videoId = 'e3dc3f23126c4b4294552ea3fad1d0a6';
        $client = $this->init_vod_client($access_key_id,$access_key_secret);
        $res = $this->get_play_auth($client,$videoId);
        $this->assign("videoId",$videoId);
        $this->assign("playAuth",$res->PlayAuth);
        $this->display("auth");
    }
    
    function get_play_auth($client, $videoId) {
        $request = new vod\GetVideoPlayAuthRequest();
        $request->setVideoId($videoId);
        $request->setAuthInfoTimeout(3600);  // 播放凭证过期时间，默认为100秒，取值范围100~3600；注意：播放凭证用来传给播放器自动换取播放地址，凭证过期时间不是播放地址的过期时间
        $request->setAcceptFormat('JSON');
        $response = $client->getAcsResponse($request);
        return $response;
    }
    
    public function uploadVideo(){
        $this->display();
    }
    
    public function getVideoUploadAuth(){
        $regionId = 'cn-shanghai';
        $access_key_id = "LTAInydAA57dVOCE";
        $access_key_secret="WE8cAr64vsUziEwmwXjOs8Qi74cylx";
        $client = $this->init_vod_client($access_key_id,$access_key_secret);
        $createResponse = $this->getVideoUploadAuthApi($client,$regionId);
        $return = array(
            "auth"  =>  $createResponse->UploadAuth,
            "addr"  =>  $createResponse->UploadAddress,
            "vid"   =>  $createResponse->VideoId,
            "rid"=>$createResponse->RequestId
        );
        $this->ajaxReturn($return);
    }
    
    public function getVideoUploadAuthApi($client, $regionId){
        $request = new vod\CreateUploadVideoRequest();
        //视频源文件标题(必选)
        $request->setTitle("视频标题");
        //视频源文件名称，必须包含扩展名(必选)
        $request->setFileName("文件名称.mov");
        //视频源文件字节数(可选)
        $request->setFileSize(0);
        //视频源文件描述(可选)
        $request->setDescription("视频描述");
        //自定义视频封面URL地址(可选)
        $request->setCoverURL("http://cover.sample.com/sample.jpg");
        //上传所在区域IP地址(可选)
        $request->setIP("127.0.0.1");
        //视频标签，多个用逗号分隔(可选)
        $request->setTags("标签1,标签2");
        //视频分类ID(可选)
        $request->setCateId(0);
        $response = $client->getAcsResponse($request);
        return $response;
    }
    
    
}