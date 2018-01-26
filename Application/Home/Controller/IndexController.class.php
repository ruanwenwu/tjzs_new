<?php
namespace Home\Controller;
class IndexController extends BaseController {
    public function __construct(){
        parent::__construct();
    }

    //首页科室列表
    public function index(){
        header("Content-type:text/html;charset=utf-8");
        //如果非白名单用户，直接输出模板
        /*if(!in_array($this->userInfo['id'],array(10,61,52,12,14,18,19,54,11,57,20,22,60))){
            $this->display("maintaining");
            die;
        }*/
        
        //如果有子院区
        $yuan = M("yuan")->where(array("hid"=>1))->order("id desc,enabled desc")->select();
        $this->assign("yuan",$yuan);
        $this->display();  
             
        
    }
    
    //部门列表
    public function departlist(){
        $dep = I("get.depname");
        $branchType = I("get.branchtype");
        //$where = array("isenabled"=>1);
        
        

        if ($dep) {
            $erwhere = "deptname like '%$dep%'";  
        }  
        
        $statusWhere = array("isenabled"=>1,"servendays"=>1);
        if ($branchType) {
            $statusWhere['branchtype'] = $branchType;
        }
        $departments = M("department")->where($erwhere)->where($statusWhere)->order(array("ordernum"=>"asc"))->select();
        $this->assign("departments",$departments);
        $this->display();
    }
    
    //院区列表
    public function yuanlist(){
        $this->display();
    }

    //科室出诊信息
    public function departmentArrange(){
        $deptid = I("get.deptid");  
        $nextDay = date("Y-m-d",strtotime("+1 days"));
        
        //查询有出诊信息的日期
        $lastDay = date("Y-m-d",strtotime("+7 days"));
        $avlDays = M("deptdayavl")->where("date >= '$nextDay' and date <= '$lastDay'")->where(array(status=>1,'deptid'=>$deptid))->group("date")->select();
        $checkDate = I("get.date") ? I("get.date") : $avlDays[0]['date'];
        //获取日历信息  
        $dateInfo = array();
        $weekConfig = array(
            1 =>    "一",
            2 =>    "二",
            3 =>    "三",
            4 =>    "四",
            5 =>    "五",
            6 =>    "六",
            7 =>    "日",
        );
        
        foreach ($avlDays as $days){
            $dateDetail['date'] = date("j",strtotime($days['date']));
            $dateDetail['fulldate'] = date("Y-m-d",strtotime($days['date']));
            $dateDetail['day'] = $weekConfig[date("N",strtotime($days['date']))];
            $dateDetail['on'] = false;
            if ($checkDate == $days['date']){
                $dateDetail['on'] = true;
            }
            $dateInfo[] = $dateDetail;
        }

        /*for($i = 1; $i <= 7; $i++) {
            $dateDetail['date'] = date("j",strtotime("+$i days"));
            $dateDetail['fulldate'] = date("Y-m-d",strtotime("+$i days"));
            $dateDetail['day'] = $weekConfig[date("N",strtotime("+$i days"))];
            $dateDetail['on'] = false;
            if ($checkDate == date("Y-m-d",strtotime("+$i days"))){
                $dateDetail['on'] = true;
            }
            $dateInfo[] = $dateDetail;
        }*/

        //获得科室信息
        $deptInfo = M("department")->where(array("deptid"=>$deptid))->find();
        
        //获得该科室，当天的出诊信息
        $today = date("Y-m-d",strtotime("+1 days"));  
        $visits = M("visitreal")->where(array("deptid"=>$deptid,'visitdate'=>$checkDate,'isenabled'=>1))->select();
        
        //echo(M("visitreal")->getLastSql());die;
        //获取科室对应的visittype信息  
        //获取医生信息   
        if ($visits && is_array($visits)) {
            foreach ($visits as $visit) {
                //医生数组
                $docs[] = $visit['docid'];
                //visittype
                $visittypes[] = $visit['visittypeid'];
            }
            //根据docs得到医生信息
            $docStr = changeArrToStr($docs);
            
            $docsInfos = M("doctor")->where("docid in ($docStr)")->where(array("isenabled"=>1))->select();
            //echo M()->getLastSql();die;
            $docInfoRes = getResByKey($docsInfos,"docid");
            //var_dump($docInfoRes);DIE;
            unset($docsInfos);

            //得到docanddep关系
            $docanddep = M("docanddep")->where("docid in ($docStr) and deptid = '$deptid'")->where(array("isenabled"=>1))->select();
            $docanddepRes = getResByKey($docanddep,"docid");
            unset($docanddep);

            //根据visittype   
            $visitStr = changeArrToStr($visittypes);
            $visitInfos = M("visittype")->where("visittypeid in ($visitStr)")->select();
            $visitInfoRes = getResByKey($visitInfos,"visittypeid");
            unset($visitInfos);
        
            //补充陈列数组信息
            foreach ($visits as $key => &$visit) {
                $visit['docname'] = $docInfoRes[$visit['docid']]['doctorname'];
                if (!$visit['docname']){
                    unset($visits[$key]);
                    continue;
                }
                $visit['docintro'] = $docanddepRes[$visit['docid']]['introduction'];
                $visit['doclevel'] = $docInfoRes[$visit['docid']]['doctorlevel'];
                $visit['cost']    = $visitInfoRes[$visit['visittypeid']]['cost'];
                $visit['visitname']    = $visitInfoRes[$visit['visittypeid']]['visitname'];
                $visit['timespan'] = $visit['apw'] == "A" ? "上午" : "下午";
                $visit['pic'] = $docInfoRes[$visit['docid']]['photourl'];
                $visit['ordernum'] = $docanddepRes[$visit['docid']]['ordernum'];
                if ($visit['apw'] == "A"){
                    $shang[] = $visit;
                }else{
                    $xia[] = $visit;
                }
            }
            
            
  
            //usort
            usort($shang,'sortbyorder');
            usort($xia,'sortbyorder');
        
            if ($_GET['debug']){
                echo '<pre>';
                var_dump($shang);die;
            }
            $this->assign("shang",$shang);
            $this->assign("xia",$xia);
            $this->assign("visitInfo",$visits);
        }  
        $this->assign("dateInfo",$dateInfo);
        $this->assign("checkDate",$checkDate);
        $this->assign("deptid",$deptid);
        $this->assign("deptInfo",$deptInfo);    //分配科室信息
        $this->display(); 
    }

    //医院介绍
    public function hospitalInfo(){
        $hid = I("get.hid");
        if (!$hid) $hid = 'f3be0033-5684-476c-929c-09021cf857ff';
        $res = M("hospital_brief")->where(array("hid"=>$hid))->find();
        $this->assign("hospital", $res);
        $this->display();
    }

    //医生时段信息
    public function timespan(){
        //如果时间不在7:00-17:00
        $start = strtotime(date("Y-m-d")." 07:00:00");
        $end   = strtotime(date("Y-m-d")." 16:45:00");
        $now   = time();
        $todayStart = strtotime(date("Y-m-d"));
        
        
        $realid = I("get.visitid"); //注意，这个接的是主键id
        //通过realid获得hid,tpid和realid
        $realInfo = M("visitreal")->where(array("id"=>$realid))->find();
        $registerDayStart = strtotime($realInfo['visitdate']);
        $dayInterval = ceil(($registerDayStart - $todayStart)/86400);
        if (($now < $start || $now > $end) && $dayInterval <3){
            $this->display("passtime");
            die;
        }
        $API = new \Home\Controller\ApiController();
        $res = $API->getRealTypeRemainNum($realInfo['tpid'],$realInfo['hid'],$realInfo['realid']);
        if ($res['result'] == "00000000" && $res['data']['total'] > 0){
            $timeSpan = $res['data']['rows'];
        }else {
            if ($res['result'] == '31022506'){
                $this->display("passtime");
                die;
            }
        }
        //获得号别信息
        $visitTypeInfo = M("visittype")->where(array("visittypeid"=>$realInfo['visittypeid']))->find();
        //得到医生信息
        $docInfo = M("doctor")->where(array("docid"=>$realInfo['docid']))->find();
        //得到科室信息
        $deptInfo = M("department")->where(array("deptid"=>$realInfo['deptid']))->find();
        $this->assign("timeSpan",$timeSpan);
        $this->assign("docInfo",$docInfo);
        $this->assign("deptInfo",$deptInfo);
        $this->assign("realid",$realid);
        $this->assign("visitTypeInfo",$visitTypeInfo);
        $this->display();
    }

    //订单预处理,提交订单
    public function preorder(){
        $realid = I("get.realid");
        $period = I("get.peroid");
        $periodName = I("get.periodname");
        //获得用户信息,看是否有绑定手机号
        $userId = cookie("userid");
        //$userId = "o4d8FwnnbIQoZlzdkmdqwJbl9J38";
        $userInfo = M("user")->where(array("openid"=>$userId))->find();
        $bind = 1;
        $this->assign("bind",$bind);

        if (!$userInfo['phoneno'] || !$userInfo['gidcard'] || !$userInfo['patientname']) {
            $bind = 0;
            $this->assign("bind",$bind);
        }
        $backUrl = urlencode("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
        
        //获取挂号信息，根据realid，这个也是主键
        $realInfo = M("visitreal")->where(array("id"=>$realid))->find();        
        //获得号别信息
        $visitTypeInfo = M("visittype")->where(array("visittypeid"=>$realInfo['visittypeid']))->find();
        //得到医生信息
        $docInfo = M("doctor")->where(array("docid"=>$realInfo['docid']))->find();
        //得到科室信息
        $deptInfo = M("department")->where(array("deptid"=>$realInfo['deptid']))->find();
       
        $this->assign("backUrl",$backUrl);
        $this->assign("userInfo",$userInfo);
        $this->assign("deptInfo",$deptInfo);
        $this->assign("docInfo",$docInfo);
        $this->assign("visitTypeInfo",$visitTypeInfo);
        $this->assign("realInfo",$realInfo);
        $this->assign("periodName",$periodName);
        $this->assign("periodId",$period);

        if ($bind){
            
            //获取验证码
            $API = new \Home\Controller\ApiController();
            $img = $API->getVerifyCode($realInfo['tpid'],$userInfo['phoneno']);
            if ($img){
                $img = "data:image/gif;base64,".$img;
                $this->assign("vcode",$img);
            }

            //获取科室信息

            
            $this->display();
        } else {
            $this->display();   
        }
    }

    //查看详情
    public function checkAppointDetail(){
        $realid = I("get.realid");       
        $period = I("get.peroid");
        $appointId = I("get.appointId");
        $periodName = I("get.periodname");
        $appointCode = I("get.appointcode");
        $userId = cookie("userid");    
        $userInfo = M("user")->where(array("openid"=>$userId))->find();
        //获取挂号信息，根据realid，这个也是主键
        if (!$realid && !$period && !$periodName && ($appointId || $appointCode)){
            //通过appointId获取period和periodName
            if ($appointId){
                $res = M("appointlog")->find($appointId);
            }else if ($appointCode){
                $res = M("appointlog")->where(array("appointcode"=>$appointCode))->find();
            }
            $realWhere = array("realid"=>$res['realid']);
            $periodName = $res['period'];
            $appointCode = $res['appointcode'];
            $status = $res['status'];  
        }else{
            $realWhere = array("id"=>$realid);
        }
        $realInfo = M("visitreal")->where($realWhere)->find();
        
        //获得号别信息
        $visitTypeInfo = M("visittype")->where(array("visittypeid"=>$realInfo['visittypeid']))->find();
        //得到医生信息   
        $docInfo = M("doctor")->where(array("docid"=>$realInfo['docid']))->find();
        //得到科室信息
        $deptInfo = M("department")->where(array("deptid"=>$realInfo['deptid']))->find();
        $this->assign("userInfo",$userInfo);
        $this->assign("deptInfo",$deptInfo);
        $this->assign("docInfo",$docInfo);
        $this->assign("visitTypeInfo",$visitTypeInfo);
        $this->assign("realInfo",$realInfo);
        $this->assign("periodName",$periodName);
        $this->assign("periodId",$period);
        $this->assign("appointcode",$appointCode);
        $this->assign("status",$status);
        $this->display();
    }      

    //获取图形验证码
    public function getVerifyCode(){
        $tpid = I("post.tpid");
        $phone= I("post.phone");
        //获取验证码
        $API = new \Home\Controller\ApiController();
        $img = $API->getVerifyCode($tpid,$phone);
        if ($img){
            $img = "data:image/gif;base64,".$img;
            $data = array("status"=>true,"src"=>$img);
        } else {
            $data = array("status"=>false);
        }
        $this->ajaxReturn($data);
    }

    public function test(){
        $wechat = new Wechat();
        $wechat->test();
        echo 3;die;
    }

    public function aa(){
        echo 4;die;
    }
    
    public function appointList(){
        $userId = cookie("userid");
        $userInfo = M("user")->where(array("openid"=>$userId))->find();
        $res = M("appointlog")->where("appointcode != ''")->where(array("uid"=>$userInfo['id']))->select();
        foreach ($res as &$re){
            //通过realid得到挂号信息
            $re['realInfo'] = $realInfo = M("visitreal")->where(array("realid"=>$re['realid']))->find();
            //die(M("visitreal")->getLastSql());
            $re['docInfo'] = $doctorInfo = M("doctor")->where(array("docid"=>$realInfo['docid']))->find();
            $re['deptInfo'] = M("department")->where(array("deptid"=>$realInfo['deptid']))->find();
        }
        $this->assign("timeSpan",$res);
        $this->display();
    }
    
    /**
     * 挂号须知
     */
    public function appointTips(){
        $guahao = array(
            "1.可预约7日内号源，早7点至前一天16：50，就诊日取号时支付费用。",
            "2.取号时间上午7：00可取8：00-9：00预约号，下午12:00可取13：00-14：30预约号，其他时间段提前30分钟取号。",
            "3.退号时间以就诊时间算起，至少提前一天，17:00之前。",
            "4.违约处罚，1个月爽约3次将取消当月预约资格。",
        );
        $this->assign("guahao",$guahao);
        $this->display();
    }

    /**
     * 乘车路线
     * @author rww
     */
    public function busPath(){
        $this->display();
    }

    /**
     * 科室简介列表
     */
    public function departBriefList(){
        $dep = I("get.depname");
        $branchType = I("get.branchtype");
        //$where = array("isenabled"=>1);
        
        
        
        if ($dep) {
            $erwhere = "deptname like '%$dep%'";
        }
        
        $statusWhere = array("isenabled"=>1,"servendays"=>1);
        if ($branchType) {
            $statusWhere['branchtype'] = $branchType;
        }
        $departments = M("department")->where($erwhere)->where($statusWhere)->order(array("ordernum"=>"asc"))->select();
        $this->assign("departments",$departments);
        $this->display();
    }

    /**
     * 简介详情
     */
    public function departBriefDetail(){
        $id = I("get.id");
        $content = M("department_brief_two")->where(array("deptid"=>$id))->find();
        $content['brief'] = preg_replace("/^\s+/", "", $content['brief']);
        $content['brief'] = preg_replace("/\s{2,}/", "</p><p>", trim($content['brief']));
        $this->assign("deptInfo", $content);
        $this->display();
    }

}
