<?php 
namespace Home\Controller;
use Think\Controller;

class AdminController extends BaseController{
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
    
    public function appointLog(){
        $today = strtotime(date("Y-m-d"));
        $startday = I("get.startday");
        $endday   = I("get.endday");
        $page = I("get.page") ? I("get.page") : 1;
        $pageSize = 10;
        $startI = ($page - 1) * $pageSize;
        $startday = $startday ? strtotime($startday) : $today;
        $endday   = $endday ? strtotime($endday) : $today+86399;
        $totalNum = M("appointlog")->where(array("status"=>1))->where("ctime > $startday and ctime < $endday")->count();
        $res = M("appointlog")->where(array("status"=>1))->where("ctime > $startday and ctime < $endday")->order("id desc")->limit("$startI,$pageSize")->select();
        foreach ($res as &$re){
            //通过realid得到挂号信息
            $realInfo = $re['realInfo'] =  M("visitreal")->where(array("realid"=>$re['realid']))->find();
            //die(M("visitreal")->getLastSql());
            $re['docInfo'] =  M("doctor")->where(array("docid"=>$realInfo['docid']))->find();
            $re['deptInfo'] = M("department")->where(array("deptid"=>$realInfo['deptid']))->find();
        }

        $this->assign("data",$res);
        $this->assign("startday",date("Y-m-d H:i:s",$startday));
        $this->assign("endday",date("Y-m-d H:i:s",$endday));
        $this->assign("total",$totalNum);
        $this->display();
    }
    
    public function appointLogForAjax(){
        $startday = I("get.startday");
        $endday   = I("get.endday");
        $page = I("get.page") ? I("get.page") : 1;
        $pageSize = 10;
        $startI = ($page - 1) * $pageSize;
        $startday = $startday ? strtotime($startday) : $today;
        $endday   = $endday ? strtotime($endday) : $today+86399;
        $totalNum = M("appointlog")->where(array("status"=>1))->where("ctime > $startday and ctime < $endday")->count();
        if ($totalNum < $startI){
            $return = array(
                "status"    =>  false,
                "message"   =>  "没有更多数据了"
            );
            $this->ajaxReturn($return);
        }
        $res = M("appointlog")->where(array("status"=>1))->where("ctime > $startday and ctime < $endday")->order("id desc")->limit("$startI,$pageSize")->select();
        foreach ($res as &$re){
            //通过realid得到挂号信息
            $realInfo = $re['realInfo'] =  M("visitreal")->where(array("realid"=>$re['realid']))->find();
            //die(M("visitreal")->getLastSql());
            $re['docInfo'] =  M("doctor")->where(array("docid"=>$realInfo['docid']))->find();
            $re['deptInfo'] = M("department")->where(array("deptid"=>$realInfo['deptid']))->find();
        }
    
        $this->assign("data",$res);
        $res = $this->fetch("appointLogForAjax");
        $return = array(
            "status"    =>  true,
            "message"   =>  "加载成功",
            "data"      => $res, 
        );
        $this->ajaxReturn($return);
    }
}
?>