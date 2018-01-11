<?php
namespace Home\Model;
use Think\Model;

class ZshospitalModel extends Model{
    public function getAllHospital(){
        return M("hospital")->select(); 
    }
}