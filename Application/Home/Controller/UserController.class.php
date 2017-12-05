<?php
namespace Home\Controller;
class UserController extends BaseController {
    public function __construct(){
        parent::__construct();
    }

    //绑定手机号，身份证，和性别
    public function bind(){
        $backUrl = I("get.backurl");
        $this->assign("backurl",$backUrl);
        $this->assign("seo",array("title"=>"绑定信息"));
        $this->display();
    }

    //接收绑定数据
    public function doBind(){
        $userid = cookie("userid");    
        $data = array(
            "phoneno"   =>  I("post.phone"),
            "gidcard"   =>  I("post.idcard"),
            "patientname"   =>  I("post.name"),
            "patientsex"    =>  I("post.sex"),
        );
        $res = M("user")->where(array("openid"=>$userid))->save($data);

        if ($res) {
            $return = array("code"=>1,"message"=>"成功");
        } else {
            $return = array("code"=>0,"message"=>"失败");
        }
        $this->ajaxReturn($return);
    }
    
}