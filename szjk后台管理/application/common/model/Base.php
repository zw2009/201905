<?php
namespace app\common\model;

use think\Model;

class Base extends Model{
	public function error($info = ''){
		$this->error=$info;
		return false;
	}
	
	public function success($data = null){
		if($data!=null){
			$this->data('data',$data);
		}
		return true;
	}
	
}
?>
