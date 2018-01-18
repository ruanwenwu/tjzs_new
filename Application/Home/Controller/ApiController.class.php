<?php 
namespace Home\Controller;
use Think\Controller;

class ApiController extends Controller{
    const AUTHCODE = "D1B2CDC4";
    const API_HOST = "http://60.205.187.164/";    //去掉8080即使线上环境

    /*public function __construct(){
        $username = $_GET['username'];
        $passwd   = $_GET['password'];
        
        if ($username != "ruanwenwu" || $passwd != "chillylips88") exit("no rights");
    }*/

    //获取权限
    public function getPermitionParams($force=true){
        $accessInfo = S("accessInfo");
   
        if ($accessInfo && !$force) {   
            return $accessInfo;
        }   

        $url = self::API_HOST."api/account/login";
        $data = array(
            'AuthCode'  =>  self::AUTHCODE,
        );  
        $data = http_build_query($data);

        $header = array(
            'Content-type:application/x-www-form-urlencoded',
        );
        $res = httpPostRequest($url,$data,$header);

        $res = json_decode($res,true);
        if ($res['result'] == "00000000"){
            $expireTime = $_SERVER['REQUEST_TIME'] + $res['data']['expires_in'] - 300;
            $cacheTime  = $res['data']['expires_in'] - 300;
            $token = $res['data']['access_token'];
            S("accessInfo",$res['data'],$cacheTime);
        } else { 
            var_dump($res);
            die;
        }
          
        return $res['data'];
    }

    //获取医院信息
    public function syncHospitalInfo(){
        //清空原来的数据
        $sql = "truncate zs_hospital";
        M("hospital")->execute($sql);   
        /*ini_set("display_errors","on");
        error_reporting(E_ALL);
        */
        $accessTokenInfo = $this->getPermitionParams(true);
        $url = self::API_HOST."api/sync/hospital";
        $data = array(
            'TPID'  =>  $accessTokenInfo['TPID'],
        );

        $data = http_build_query($data);
        $header = array(
            'Content-type:application/x-www-form-urlencoded',
            'Authorization:'.$accessTokenInfo['token_type']." ".$accessTokenInfo['access_token'],
        );
        $res = json_decode(httpPostRequest($url,$data,$header),true);

        if ($res['result'] == "00000000" && $res['data']['total'] > 0){     //如果数据正常,

            foreach ($res['data']['rows'] as $key => $val){
                $data = array(
                    "tpid"  => $accessTokenInfo['TPID'],
                    "mtime" => $_SERVER['REQUEST_TIME'],
                    'hid'   => $val['HID'],
                    'hospitalname' => $val['HospitalName'],
                );
                //添加数据
                M("hospital")->add($data);
            }   
        } else {
            echo 33;die;
            var_dump($res);
            die;
        }
    }
    
    //同步科室信息
    public function syncDepartmentInfo(){
        //清空原来的数据     
        $sql = "truncate zs_department";
        M("department")->execute($sql);
        $accessTokenInfo = $this->getPermitionParams();
        $url = self::API_HOST."api/sync/dept";
        //获得医院信息
        $hospitalInfo = M("hospital")->select();
        if (!$hospitalInfo || !is_array($hospitalInfo)) die("医院信息获取失败");
        
        $insertSql = "insert into zs_department (tpid,hid,deptid,deptname,isenabled,mtime,branchname,ordernum,branchtype) values ";
        foreach ($hospitalInfo as $hk => $hv){          
            $data = array(
                'TPID'  =>  $hv['tpid'],
                'Hid'   =>  $hv['hid'],
            );
            $data = http_build_query($data);
            $header = array(
                'Content-type:application/x-www-form-urlencoded',
                'Authorization:'.$accessTokenInfo['token_type']." ".$accessTokenInfo['access_token'],
            );
            $res = json_decode(httpPostRequest($url,$data,$header),true);
            if ($res['result'] == "00000000" && $res['data']['total'] > 0){     //如果数据正常,
                foreach ($res['data']['rows'] as $key => $val){
                    //echo '<pre>';
                    //var_dump($val);die; 
                    if(preg_match("/北院/",$val['BranchName'])){
                        $branchType = 1;
                    }else if(preg_match("/南院/",$val['BranchName'])){
                        $branchType = 2;
                    }else{
                        $branchType = 0;
                    }
                    $insertSql .= "('{$hv['tpid']}','{$hv['hid']}','{$val['DeptID']}','{$val['DeptName']}',{$val['IsEnabled']},{$_SERVER['REQUEST_TIME']},'{$val['BranchName']}','{$val['OrderNum']}','{$branchType}'),";
                }
            } else {
                var_dump($res);
                die;
            }
        }
        $insertSql = rtrim($insertSql,",");       
        return M("department")->execute($insertSql);
    }
    
    //同步医生信息
    public function syncDoctorsInfo(){
        //清空原来的数据       
        $sql = "truncate zs_doctor";
        M("doctor")->execute($sql);  
        $accessTokenInfo = $this->getPermitionParams();
        $url = self::API_HOST."api/sync/doctor";
        //获得医院信息
        $hospitalInfo = M("hospital")->select();
        if (!$hospitalInfo || !is_array($hospitalInfo)) die("医院信息获取失败");
        
        $insertSql = "insert into zs_doctor (tpid,hid,docid,doctorname,doctorlevel,photourl,isenabled) values ";
        foreach ($hospitalInfo as $hk => $hv){
            $data = array(
                'TPID'  =>  $hv['tpid'],
                'Hid'   =>  $hv['hid'],
            );
            $data = http_build_query($data);
            $header = array(
                'Content-type:application/x-www-form-urlencoded',
                'Authorization:'.$accessTokenInfo['token_type']." ".$accessTokenInfo['access_token'],
            );          
            $res = json_decode(httpPostRequest($url,$data,$header),true);           
            if ($res['result'] == "00000000" && $res['data']['total'] > 0){     //如果数据正常,
                foreach ($res['data']['rows'] as $key => $val){
                    $insertSql .= "('{$hv['tpid']}','{$hv['hid']}','{$val['DocID']}','{$val['DoctorName']}','{$val['DoctorLevel']}','{$val['PhotoUrl']}','{$val['IsEnabled']}'),";
                }
            } else {
                //var_dump($res);
                //die;
            }
        }
        $insertSql = rtrim($insertSql,",");
        //echo $insertSql;die;
        return M("department")->execute($insertSql);
    }
    
    //同步医生科室关系
    public function syncDocDepRelation(){
        //清空原来的数据     
        $sql = "truncate zs_docanddep";
        M("docanddep")->execute($sql);
        $accessTokenInfo = $this->getPermitionParams();
        $url = self::API_HOST."api/sync/doctoranddept";
        //获得医院信息
        $hospitalInfo = M("hospital")->select();
        if (!$hospitalInfo || !is_array($hospitalInfo)) die("医院信息获取失败");
        
        $insertSql = "insert into zs_docanddep (tpid,hid,deptid,docid,isenabled,ctime,specialty,ordernum,introduction) values ";
        foreach ($hospitalInfo as $hk => $hv){
            $data = array(
                'TPID'  =>  $hv['tpid'],
                'Hid'   =>  $hv['hid'],
            );
            $data = http_build_query($data);
            $header = array(
                'Content-type:application/x-www-form-urlencoded',
                'Authorization:'.$accessTokenInfo['token_type']." ".$accessTokenInfo['access_token'],
            );
            $res = json_decode(httpPostRequest($url,$data,$header),true);
            if ($res['result'] == "00000000" && $res['data']['total'] > 0){     //如果数据正常,
                foreach ($res['data']['rows'] as $key => $val){
                    $insertSql .= "('{$hv['tpid']}','{$hv['hid']}','{$val['DeptID']}','{$val['DocID']}',{$val['IsEnabled']},{$_SERVER['REQUEST_TIME']},'{$val['Specialty']}','{$val['OrderNum']}','{$val['Introduction']}'),";
                }  
            } else {
                var_dump($res);
                die;
            }  
        }
        $insertSql = rtrim($insertSql,",");
        return M("department")->execute($insertSql);
    }

    //同步号别信息
    public function syncVisitType(){
        //清空原来的数据     
        $sql = "truncate zs_visittype";
        M("visittype")->execute($sql);
        $accessTokenInfo = $this->getPermitionParams();
        $url = self::API_HOST."api/sync/visittype";
        //获得医院信息
        $hospitalInfo = M("hospital")->select();
        if (!$hospitalInfo || !is_array($hospitalInfo)) die("医院信息获取失败");
    
        $insertSql = "insert into zs_visittype (tpid,hid,visittypeid,visitname,regfee,inspectfee,ctime,cost) values ";
        foreach ($hospitalInfo as $hk => $hv){
            $data = array(
                'TPID'  =>  $hv['tpid'],
                'Hid'   =>  $hv['hid'],
            );
            $data = http_build_query($data);
            $header = array(
                'Content-type:application/x-www-form-urlencoded',
                'Authorization:'.$accessTokenInfo['token_type']." ".$accessTokenInfo['access_token'],
            );

            $res = json_decode(httpPostRequest($url,$data,$header),true);
       
            if ($res['result'] == "00000000" && $res['data']['total'] > 0){     //如果数据正常,
                foreach ($res['data']['rows'] as $key => $val){
                    $insertSql .= "('{$hv['tpid']}','{$hv['hid']}','{$val['VisitTypeID']}','{$val['VisitName']}',{$val['RegFee']},'{$val['InspectFee']}',{$_SERVER['REQUEST_TIME']},'{$val['Cost']}'),";
                }
            } else {
                var_dump($res);
                die;   
            }
        }
        $insertSql = rtrim($insertSql,",");
        return M("department")->execute($insertSql);
    }
    
    //同步出诊信息
    public function syncVisitReal(){
        //清空原来的数据     
        //$sql = "truncate zs_visitreal";
        //M("visitreal")->execute($sql);
        $nowDay = date("Y-m-d");
        $sql = "delete from zs_visitreal where visitdate > '$nowDay'";
        M("visitreal")->execute($sql);
        $accessTokenInfo = $this->getPermitionParams();
        $url = self::API_HOST."api/sync/visitreal";               
        //获得医院信息
        $hospitalInfo = M("hospital")->select();
        if (!$hospitalInfo || !is_array($hospitalInfo)) die("医院信息获取失败");
        $insertSql = "insert into zs_visitreal (tpid,hid,realid,visitdate,week,apw,docid,deptid,visittypeid,isenabled) values ";
        foreach ($hospitalInfo as $hk => $hv){
            //获得需要同步的日期
            $days = $this->getNeedSyncVisitTypeDays();
            if (!$days) {
                return false;
            }
            foreach($days as $day){
                $data = array(
                    'TPID'  =>  $hv['tpid'],
                    'Hid'   =>  $hv['hid'],
                    'VisitDate'=>$day,
                );  
                $data = http_build_query($data);
                $header = array(
                    'Content-type:application/x-www-form-urlencoded',
                    'Authorization:'.$accessTokenInfo['token_type']." ".$accessTokenInfo['access_token'],
                );
                $res = json_decode(httpPostRequest($url,$data,$header),true);
                if ($res['result'] == "00000000" && $res['data']['total'] > 0){     //如果数据正常,
                    $goon = true;
                    foreach ($res['data']['rows'] as $key => $val){
                        $insertSql .= "('{$hv['tpid']}','{$hv['hid']}','{$val['RealID']}','$day',{$val['Week']},'{$val['APW']}','{$val['DocID']}','{$val['DeptID']}','{$val['VisitTypeID']}','{$val['IsEnabled']}'),";
                    }
                } else {
                    //var_dump($res);   
                    //die;  
                }     
            }
        }
        if ($goon) {
            $insertSql = rtrim($insertSql,",");
            $nowtime = time();
            $insertSql .= " on duplicate key update updatetime = '$nowtime'";
            M("department")->execute($insertSql);
            //记录日志
            M("visittype_sync_log")->add(array("date"=>array_pop($days)));
        } else {  
            echo 'no data';
            var_dump($res);die;
        }
        //die;
    }
    
    //获得需要同步的日期
    public function getNeedSyncVisitTypeDays(){
        $today = date("Y-m-d");
        $sevenDaysLater = date("Y-m-d",strtotime("+8 days"));
        //获得日志表里最后一条记录
        $res = M("visittype_sync_log")->order("id desc")->find();
        if ($res && false) {
            $lastDate = $res['date'];
        } else {
            $lastDate = $today;
        }
        $return = array();

        while ($lastDate < $sevenDaysLater){
            $return[] = $lastDate = date("Y-m-d",strtotime($lastDate)+86400);
        }
        return $return;
    }
    
    //获得时段的剩余号数
    public function getRealTypeRemainNum($tpid,$hid,$realid){
        header("Content-type:text/html;charset=utf-8");
        $accessTokenInfo = $this->getPermitionParams();
        $url = self::API_HOST."api/buss/period";

        //获得医院信息
        $hospitalInfo = M("hospital")->where(array("hid"=>$hid))->select();
        if (!$hospitalInfo || !is_array($hospitalInfo)) die("医院信息获取失败");
        $data = array(
            'TPID'  =>  $tpid,
            'Hid'   =>  $hid,
            'RealID'=>  $realid,//'7c23e6a8-3dfa-44e8-ba1c-843e7fa97ddf',
        );       
        $data = http_build_query($data);  
        $header = array(
            'Content-type:application/x-www-form-urlencoded',
            'Authorization:'.$accessTokenInfo['token_type']." ".$accessTokenInfo['access_token'],
        );         

        $res = json_decode(httpPostRequest($url,$data,$header),true);
        /*if ($res['result'] == "00000000" && $res['data']['total'] > 0){     //如果数据正常,
            return $res['data']['rows'];
        } else {
            var_dump($res);die;
            return false;
        }*/
        return $res;
    }

    //获取图片验证码
    public function getVerifyCode($tpid,$phone){
        if (!$tpid || !$phone) return false;
        
        $accessTokenInfo = $this->getPermitionParams();
        $url = self::API_HOST."api/buss/GetImageCode";
        $data = array(
            'TPID'  =>  $tpid,
            'PhoneNo'   =>  $phone,
        );
        $data = http_build_query($data);
        $header = array(
            'Content-type:application/x-www-form-urlencoded',
            'Authorization:'.$accessTokenInfo['token_type']." ".$accessTokenInfo['access_token'],
        );
        $res = json_decode(httpPostRequest($url,$data,$header),true);
        if ($res['result'] == "00000000") {     //如果数据正常,
            return $res['data'];
        } else {
            return false;
        }
    }
    
    //获取短信验证码      
    public function getPhoneTextVerifyCode(){
        $tpid = I("post.tpid");
        $phone = I("post.phone");
        $picCode = I("post.picCode");
        if (!$tpid || !$phone || !$picCode) return false;
        
        $accessTokenInfo = $this->getPermitionParams();
        $url = self::API_HOST."api/buss/GetPhoneCode";
        $data = array(
            'TPID'  =>  $tpid,
            'PhoneNo'   =>  $phone,
            'PicCode'   =>  $picCode,
        );
        $data = http_build_query($data);
        $header = array(
            'Content-type:application/x-www-form-urlencoded',
            'Authorization:'.$accessTokenInfo['token_type']." ".$accessTokenInfo['access_token'],
        );
        $res = json_decode(httpPostRequest($url,$data,$header),true);
        $this->ajaxReturn($res);
    }

    //预约挂号接口
    public function appoint(){
        $tpid        = I("post.tpid");
        $hid         = I("post.hid");
        $phoneno     = I("post.phoneno");
        $idcard      = I("post.idcard");
        $uid         = I("post.uid");
        $periodname  = I("post.periodname");
        //$gidcard     = I("post.gidcard");
        $patientName = I("post.patientname");
        $patientSex  = I("post.patientsex");
        $realid      = I("post.realid");
        $periodid    = I("post.periodid");
        $verifyCode    = I("post.verifycode");
        $accessTokenInfo = $this->getPermitionParams();
        $url = self::API_HOST."api/buss/appoint";
        $data = array(
            'TPID'        =>  $tpid,
            'HID'         =>  $hid,
            'PhoneNo'     =>  $phoneno,
            'IDCard'      =>  $idcard,
            'PatientName' =>  $patientName,
            'PatientSex'  =>  $patientSex,
            'RealID'      =>  $realid,
            'PeriodID'    =>  $periodid,
            'VerifyCode'  =>  $verifyCode,
        );
        //echo '<pre>';
        //var_dump($data);die;
        $data = http_build_query($data);
        $header = array(
            'Content-type:application/x-www-form-urlencoded',
            'Authorization:'.$accessTokenInfo['token_type']." ".$accessTokenInfo['access_token'],
        );
        $res = json_decode(httpPostRequest($url,$data,$header),true);
        if ($res['result'] == "00000000") {     //如果数据正常,
            $status = 1;
            $appointCode = $res['data']['AppointCode'];
        }else{
            $status = 2;
            $appointCode = "";
            //如果失败，记录失败原因
        }
        //写入挂号记录
        $logSql = "insert into `zs`.`zs_appointlog` ( `hid`, `realid`, `uid`, `tpid`, `ctime`,`period`,`status`,`appointcode`) values ( '$hid', '$realid', '$uid', '$tpid', '{$_SERVER['REQUEST_TIME']}','$periodname',$status,'$appointCode')";
        M("appointlog")->execute($logSql); 
        $id = M("appointlog")->getLastInsID();
        M("appointdetail")->add(array("appointid"=>$id,"message"=>$res['message'],"data"=>serialize($data)));
        $res['id'] = $id;
        //返回成功提醒
        $this->ajaxReturn($res);
    }
    
    //退预约
    public function cancelAppointment(){
        $tpid = I("post.tpid");
        $hid = I("post.hid");
        $appointCode = I("post.appointCode");
        if (!$tpid || !$hid || !$appointCode) return false;
    
        $accessTokenInfo = $this->getPermitionParams();
        $url = self::API_HOST."api/buss/backappoint";
        $data = array(
            'TPID'  =>  $tpid,
            'HID'   =>  $hid,
            'AppointCode'   =>  $appointCode,
        );
        $data = http_build_query($data);
        $header = array(
            'Content-type:application/x-www-form-urlencoded',
            'Authorization:'.$accessTokenInfo['token_type']." ".$accessTokenInfo['access_token'],
        );
        $res = json_decode(httpPostRequest($url,$data,$header),true);
        if ($res['result'] == "00000000"){
            //更改预约状态为3
            M("appointlog")->where("appointcode='$appointCode'")->save(array("status"=>3));
        }
        $this->ajaxReturn($res);
    }  
    
    //获取出诊信息变更
    public function visitrealchange(){
             $hospitalInfo = M("hospital")->find();
             if (!$hospitalInfo || !is_array($hospitalInfo)) die("医院信息获取失败");
        
            $accessTokenInfo = $this->getPermitionParams();
            $url = self::API_HOST."api/sync/visitrealchange";
            $data = array(
                'TPID'  =>  $hospitalInfo['tpid'],
                'HID'   =>  $hospitalInfo['hid'],
                'SearchTime'   =>  date("Y-m-d H:i:s",strtotime("-3 days")),
            );
            $data = http_build_query($data);
            //var_dump($data);die;
            $header = array(
                'Content-type:application/x-www-form-urlencoded',
                'Authorization:'.$accessTokenInfo['token_type']." ".$accessTokenInfo['access_token'],
            );
            $res = json_decode(httpPostRequest($url,$data,$header),true);
            if ($res['result'] == "00000000" && $res['data']['total'] > 0){
                foreach ($res['data']['rows'] as $re) {
                    
                    $exist = M("visitreal")->where(array("realid"=>$re['RealID']))->find();
                    if ($exist) {
                        M("visitreal")->where(array("realid"=>$re['RealID']))->save(array('isenabled'=>$re['IsEnabled']));
                    } else {
                        //如果是新增，添加到visitreal表中
                        //看realchange表中是否存在
                            $data = array(
                                "tpid"     =>  $hospitalInfo['tpid'],
                                "hid"      =>  $hospitalInfo['hid'],
                                "realid"   =>  $re['RealID'],
                                "visitdate"=>  strstr($re['VisitDate'],"T",true),
                                "week"     =>  $re['Week'],
                                "apw"      =>  $re['APW'],
                                "docid"    =>  $re['DocID'],
                                "deptid"   =>  $re['DeptID'],
                                "visittypeid"=> $re['VisitTypeID'],
                                "isenabled"=>   $re['IsEnabled'],
                            );
                            M("visitreal")->add($data);
                            $sql = "insert into zs_realchange (`realid`,`changetype`,`date`) values ('{$re['RealID']}','{$re['ChangeType']}','{$data['visitdate']}') ";
                            M("realchange")->execute($sql);
                    }      
                }
            }else{
                die();
            }
            //die;
    }
    
    //停改诊计划任务操作,每1个小时
    public function realchangeCrontab(){
        //执行时间延长
        set_time_limit(0); 
        $this->visitrealchange();
        $this->syncSevendaysAvailable();
        $this->syncEverydayAvailable();
    }
    
    //同步近7天内的科室的排班信息
    public function syncSevendaysAvailable(){
        //从明天开始的，7天内的排班信息
        //选出所有enabled的科室
        //遍历科室，统计7天内的科室，如果没有的话，update为0（从列表中去除）
        $depts = M("department")->where(array("isenabled"=>1))->select();
        $startDay = date("Y-m-d");
        $endDay   = date("Y-m-d",strtotime("+7 days"));
        foreach ($depts as $dep){
            $avl = M("visitreal")->where(array("deptid"=>$dep['deptid']))->where("visitdate > '$startDay' and visitdate <= '$endDay'")->count();
            //echo M("visitreal")->getLastSql();die;
            if (!$avl){
                //echo M("visitreal")->getLastSql();die;
                M("department")->where(array(array("deptid"=>$dep['deptid'])))->save(array("servendays"=>0));                
            }
        }  
    }
    
    //同步每天的排班情况
    public function syncEverydayAvailable(){
        $sql = "truncate zs_deptdayavl";
         M("visitreal")->execute($sql);
        
        $beginTime = strtotime("+1 day");
        $days = array();
        $depts = M("department")->where(array("isenabled"=>1))->select(); 
        $sql = "insert into zs_deptdayavl (deptid,status,date) values ";
        for ($i = 0; $i <= 6; $i++) {
            $nowDate = date("Y-m-d",$beginTime + 86400*$i);
            foreach ($depts as $dep) {
                $nowNum = M("visitreal")->where(array("visitdate"=>$nowDate,"isenabled"=>1,'deptid'=>$dep['deptid']))->count();
                //die(M()->getLastSql());
                $status = $nowNum > 0 ? 1 : 0;
                $sql .= "('{$dep['deptid']}',{$status},'{$nowDate}'),";
            }
        } 
        $sql = rtrim($sql,",");
        M("deptdayavl")->execute($sql);
    }
    
    //同步医生头像信息
    public function syncDocPicInfo(){
        $imgs = M("docimg")->select();
        if ($imgs && is_array($imgs)) {
            foreach ($imgs as $img) {
                M("doctor")->where(array("docid"=>$img['docid']))->save(array("photourl"=>$img['pic']));
                //echo M()->getLastSql();
                //die;
            }
        }
    }
    
    //每日同步
    public function syncEveryDay(){
        //执行时间延长
        set_time_limit(0); 
        //同步科室
        $this->syncDepartmentInfo();   
        //同步医生
        $this->syncDoctorsInfo();
        //同步医生和科室关系
        $this->syncDocDepRelation();
        //同步不显示的医生
        $this->checkIfWhiteOrdinary();
        //同步医生图片
        $this->syncDocPicInfo();
        //同步医生简介
        $this->suplementDocInfo();
        //同步医生排序
        $this->alterOrdinaryOrder();
        //同步排班信息
        $this->syncVisitReal();
        //停掉停了的医生的出诊
        $this->disableDisabledDoctorVisit();
        //同步七天排班信息
        $this->syncSevendaysAvailable();
        //同步每天排班信息
        $this->syncEverydayAvailable();
        
    }
    
    public function tt(){
        echo 3;die;
    }

    //已经停诊的医生，他的所有排版信息要disenabled掉
    public function disableDisabledDoctorVisit(){
        //遍历医生表，查出disabled了的医生，把他们的排版停掉
        $disabledDoctors = M("doctor")->where(array("isenabled"=>0))->select();
        $docStr = "";
        foreach ($disabledDoctors as $doc){
            $docStr .= "'{$doc['docid']}',";
        }
        
        $docStr = rtrim($docStr, ",");
        $sql = "update zs_visitreal set isenabled = 0 where docid in ($docStr)";
        M("visitreal")->execute($sql);
    }

    //插入普通医生图片
    public function addPutongDocImg(){
        $doctors = M("doctor")->where("doctorname like '%科普通号'")->select();
        $insertSql = "insert into zs_docimg (docid,pic) values ";
        foreach ($doctors as $doc){
            $insertSql .= "('{$doc['docid']}','kouqiangputong.jpg'),";
        }
        echo $insertSql;die;
    }

    //获取可是简介
    public function getDeptBrief(){
        //读取文件
        $depts = file("/data/wwwroot/tjzsyl/depbrief.csv");
        if ($depts && is_array($depts)){
            foreach ($depts as $dep){
                $tempData = explode(",",$dep);
                $deptname = trim($tempData[1]);
                $data['brief']  = $tempData[2];
                $deptInfo = M("department")->where(array("deptname"=>$deptname))->find();
                if ($deptInfo){
                    $data['name']   = $deptInfo['deptname'];
                    $data['deptid'] = $deptInfo['deptid'];
                    M("department_brief_two")->add($data);
                }
            }
        }
        die;
    }
    
    ///删除重复数据
    public function delRepeatData(){
        $sql = "select id,count(realid) as c,realid from zs_visitreal group by realid having c > 1";
        $res = M()->query($sql);

        if ($res){
            $delIds = "";
            foreach ($res as $re){
                $id = $re['id'];
                $delIds .= $id.",";
            }
            $delIds = rtrim($delIds,",");
            M("visitreal")->delete($delIds);
        }
        die;
    }
    
    //普通号白名单,只有这些普通号医生能显示
    public function checkIfWhiteOrdinary(){
        $deptWhite = array(
            "824c51a2-6728-4682-a1ca-547c89c8d275",//北院推拿
            "a9bbc5ee-3eeb-4515-8f0e-862c50d451a0",//北院肿瘤
            "1f777950-9363-4296-a554-d64ac0a35018",//北心身
            "15f43627-fda1-46a3-a93a-689f0ee79c88",//北口腔
            "8c486d8b-74df-4ac5-9aae-eb1efb033966",//南院心身
        );
        $docWhite = array(
            "6accc1f5-60e3-4dda-bd63-d8086f6d47df", //北院腰颈损伤荣兵
            "62e02cec-6775-4da2-8a9a-d36a388a9dd6", //北院腰颈损伤林向前
            "f538239a-9391-4381-b811-664d405572b0", //北院关节软伤，刘波
            "3227d3e7-d91a-42cf-8754-efc5b993d65b", //南院口腔科
            //"c92b580a-7cda-404f-8643-e1d5700490e5",//北院肿瘤赵林林
            "ea3ccee7-24f9-44fb-801f-d469bf6a872c"//北院肿瘤赵林林
        );
        
        //查询含有普通名称的医生，将他们根据白名单进行disabled掉
        $sql = "select d.docid,r.deptid from zs_doctor as d,zs_docanddep as r where r.docid = d.docid and d.doctorname like '%普通号';";
        $res = M()->query($sql);
        foreach ($res as $re){
            //$re['deptid'] = 'a9bbc5ee-3eeb-4515-8f0e-862c50d451a0';
            if (in_array($re['docid'],$docWhite) || in_array($re['deptid'], $deptWhite)){
            }else{
                $sql = "update zs_doctor set isenabled = 0 where docid = '{$re['docid']}'";
                M()->execute($sql);
            }
        }
    }
    
    /**
     * 补充医生简介
     * @author rww
     * @date 2017/01/09
     */
    public function suplementDocInfo(){
        //查询所有的补充信息，然后填充到doc表
        $res = M("suplement_doc_bref")->select();
        foreach ($res as $re){
            $sql = "update zs_docanddep set introduction = '{$re['bref']}' where docid = '{$re['docid']}'";
            M()->execute($sql);
        }
    }
    
    /**
     * 修正普通号的顺序
     */
    public function alterOrdinaryOrder(){
        $docids = array(
            array("docid"=>"48093cf0-29b8-4d2b-9f02-6e216cbeae50","deptid"=>"1f777950-9363-4296-a554-d64ac0a35018","order"=>120),
            array("docid"=>"66e3d5dc-a64b-4ed3-9a0c-61f4b8a8c5fe","deptid"=>"1f777950-9363-4296-a554-d64ac0a35018","order"=>120),
            array("docid"=>"098d66c5-c209-4b86-8961-d93baddc4c57","deptid"=>"dbb12165-5a03-4faa-b307-3865c3b0e133","order"=>5),
            array("docid"=>"45686db3-2956-435c-b729-52ad3ff10318","deptid"=>"23acf6f8-ee79-44ff-8f37-9d151b31c4e7","order"=>11),
            array("docid"=>"553b6ad1-5204-4864-a55d-75e26c3e28ff","deptid"=>"80e01028-0c8f-4d31-ad61-adab1da095ec","order"=>3),
        );
        
        foreach ($docids as $did){
            $docid = $did['docid'];
            $deptid= $did['deptid'];
            $order = $did['order'];
            $sql = "update zs_docanddep set ordernum = '$order' where docid = '$docid' and deptid = '$deptid'";
            M()->execute($sql);
        }
    }
    
}
?>