<?php
// +----------------------------------------------------------------------
namespace Org\Util;
class Wechat {
    private $appid;
    private $appsecrete;
    public function __construct(){
        $this->appid = C("APPID");
        $this->appsecrete = C("APP_SECRETE");
    }
    public function test(){
        echo 'jin来le';
        die;
    }

    //进行授权操作
    public function authorize(){
        $redirect_uri = "http://www.tjzsyl.com/index.php/Home/Wechat/authorize";
        $authorizeUrl = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$this->appid."&redirect_uri={$redirect_uri}&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
        header("Location:$authorizeUrl");
        die;
    }

    //通过openid获取用户信息
    public function getUserInfoByOpenid(){
        
    }
}