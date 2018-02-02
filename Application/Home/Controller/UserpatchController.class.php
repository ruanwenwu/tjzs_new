<?php
namespace Home\Controller;
class UserpatchController extends BaseController {
    public function __construct(){
        parent::__construct();
    }

    //绑定手机号，身份证，和性别
    public function bind(){
        $patientId = I("get.patientid");
        if ($patientId){
            $userInfo = M("patient")->find($patientId);
            $this->assign("userInfo",$userInfo);
        }else{
            $this->assign("userInfo",'');
        }
        $backUrl = I("get.backurl");
        $this->assign("patientId",$patientId);
        $this->assign("backurl",$backUrl);
        $this->assign("seo",array("title"=>"绑定信息"));
        $this->display();
    }

    //接收绑定数据
    public function doBind(){
        $userInfo = $this->userInfo;
        $uid = $userInfo['id'];
        $phone = I("post.phone");
        $idcard = I("post.idcard");
        $sixteenC = substr($idcard, 16,1);
        $sex = $sixteenC%2;
        $patientId = I("post.patientid");
        $data = array(
            "phone"   =>  $phone,
            "idcard"   =>  I("post.idcard"),
            "gidcard"   =>  I("post.gidcard"),
            "name"   =>  I("post.name"),
            "uid"    => $uid,
            "sex"    => $sex,
            "age"    => I("post.age")
        );
        //先查看这个身份证号是否已经注册过
       $gres = M("patient")->where(array("idcard"=>$idcard))->find();
       if ($patientId){       
           $data['id'] = $patientId;
           M("patient")->save($data);
       }else{
            if ($gres){
                $return = array("code"=>0,"message"=>"您已经绑定过该用户了");
                $this->ajaxReturn($return);
            }else{
                M("patient")->add($data);   
            }
       } 
       $return = array("code"=>1,"message"=>"成功");
       $this->ajaxReturn($return);
    }
    
}