<?php
namespace app\common\model;
use think\Db;
class Area extends Base{
    public function get_dist(){
        $arr=array();
        $dist=$this->column('code,name,ucode','code');
        foreach($dist as $code=>$v){
            if($v['ucode']==0) $v['ucode']=-1;
            $arr[$v['ucode']][$code]=$v['name'];
        }
        return $arr;
    }

    public function get_area_name($code){
        return $this->where('code',$code)->value('name');
    }
}

?>
