<?php 
namespace Home\Controller;
use Think\Controller;

class AdminController extends Controller{
    public function alterDocInterface(){
        $doctorname = I("get.doctorname");
        if ($doctorname){
            $sql = "select * from zs_doctor where doctorname like '%$doctorname%'";
            $res = M("doctor")->query($sql);    //医生基本信息
            
            //获取docid
            if ($res){
                
            }
            
        }
        
        $this->display();
    }
}
?>