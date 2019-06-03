<?php
namespace app\common\model;
class WeichatConfig extends Base{
	
	/**
	 * 单条记录
	 *   */
	public function details($id){
		return $this->where('id',$id)->find();
	}
	
	public function updates(){
		$data['appid']=input('appid');
		$data['appsecret']=input('appsecret');
		$data['token']=input('token');
		$data['aeskey']=input('aeskey');
		$data['subscribe']=input('subscribe');
		$data['default_reply']=input('default_reply');
		$id=input('id');
		if($id) $data['id']=input('id');
		/* 添加或更新数据 */
		if(!isset($data['id'])){
			//新增数据
			$this->allowField(true)->save($data);
			if(!$this->id) return $this->error ('新增失败！');
		} else { 
			//更新数据
			$status = $this->allowField(true)->isUpdate(true)->save($data);
			if(false === $status) return $this->error ('更新失败！');
		}
		return true;
	}
	
}

?>
