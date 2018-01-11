<?php
namespace Home\Controller;
use Think\Controller;

class AjaxController extends Controller{
    public function _initialize(){
        //echo '1';
    }
    
    public function login(){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $res = M("hospitallogin")->where(array("username"=>$username,"password"=>$password))->find();
        if($res){
            $data = array(
                "status"  => "y",
            );
            $userInfo = M("hospital")->where(array("id"=>$res['id']))->find();
            session("hospital_login",$userInfo);
        }else{
            $data = array(
                "status"  =>  "n",
            );
        }
        
        $this->ajaxReturn($data);
        exit;
    }
    
    //上传图片
    public function upload(){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =     '../Uploads/'; // 设置附件上传根目录
        $upload->savePath  =     date("Y/m/d/",time()); // 设置附件上传（子）目录
        $upload->saveName = 'time';
        // 上传文件 
        $info   =   $upload->upload();
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }else{// 上传成功
            $this->ajaxReturn($info);
            die;
        }
    }
}