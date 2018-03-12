<?php
namespace Home\Controller;
use Think\Controller;
class BaseController extends Controller {
    protected  $userObj;
    protected $userInfo;

    public function __construct(){
        parent::__construct();
        $this->userObj = D("User");
        $userid = cookie("userid");

        if ($userid){
            $userInfo = $this->userInfo = $this->userObj->userIfExists($userid);
            $this->assign("userInfo", $userInfo);
        }

        if (!$userid || !$userInfo) {
            //记录授权前的地址
            $host = $_SERVER['HTTP_HOST'];
            $uri = $_SERVER['REQUEST_URI'];
            $url = $host.$uri;
            cookie("auth_back_url",$url,600);     
            //调到授权页面
            $wechat = new \Org\Util\Wechat();
            $wechat -> authorize();
        }
    }
}