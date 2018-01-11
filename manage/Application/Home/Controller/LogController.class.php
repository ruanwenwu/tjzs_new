<?php
namespace Home\Controller;
use Think\Controller;
class LogController extends Controller {
    public function __construct(){
        parent::__construct();
    }
    
    public function _initialize(){
        //判断是否登录,如果没有登录直接转到登录页面
        checkLogin();
        $this->Hospital = D("Zshospital");
        $userInfo = session("hospital_login");
        $this->assign("random",time());
        $this->assign("userInfo",$userInfo);
        
    }
    
    public function errinfo(){
        $dashBoard = array(
            "parent"    =>  array(
                "name"  =>  "挂号信息",
                "url"   =>  ""
            ),
            "child"     =>  array(
                "name"  =>  "挂号列表",
                "url"   =>  "",
            )
        );
        
        $data = M("zserrlog")->order("id desc")->select();
        foreach($data as $k => &$v){
            $errres = unserialize($v['errinfo']);
            $str = "";
            foreach($errres as $ck => $cv){
                $str .= "$ck:$cv<br/>";
            }
            $v['errinfo'] = $str;
        }
        $this->assign("Dashboard",$dashBoard);
        $this->assign("data",$data);
        $this->display();
    }
    
    /*
     * 获得医院列表
     */
    public function hospitals(){
        $hospitals = $this->Hospital->getAllHospital();
        $dashBoard = array(
            "parent"    =>  array(
                "name"  =>  "医院信息",
                "url"   =>  ""
             ),
            "child"     =>  array(
                "name"  =>  "医院列表",
                "url"   =>  "",
            )
        );

        $this->assign("Dashboard",$dashBoard);
        $this->assign("hospitals",$hospitals);
        $this->assign("ctl","hospitalmanage");
        $this->display();
    }
    
    /*
     * 首页获取医院信息，并可以进行实时修改
     */
    public function index(){
         $dashBoard = array(
            "parent"    =>  array(
                "name"  =>  "医院信息",
                "url"   =>  ""
             ),
            "child"     =>  array(
                "name"  =>  "医院列表",
                "url"   =>  "",
            )
        );
         
        //得到医院信息
        $this->assign("hospitalInfo",session("hospital_login"));
        $this->assign("Dashboard",$dashBoard);
        $this->assign("ctl","hospitalmanage");
        $this->assign("act","hospitalinfo");
        $this->display(); 
    }
    
   /**
    * 更新医院信息
    */
    public function updateHospital(){
        $data = $_POST;
        if(M("zshospital")->save($data)){
            $data = array(
                "status"=>"y"
            );
           
        }else{
            $data = array(
                "status"=>"n"
            );
        }
        $this->ajaxReturn($data);
        die;
    }
}