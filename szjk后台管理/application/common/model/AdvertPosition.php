<?php
namespace app\common\model;
use think\Db;
class AdvertPosition extends Base{
	protected $autoWriteTimestamp = true;
	public function getAdvertNumsAttr($value,$data){
		return Db::name('Advert')->where('position_id',$data['id'])->count();
	}
	/**
	 * 新增/修改
	 * @return boolean  */
	public function updates(){
		$data=input('post.');
		
		if($data['type']==2){
			$data['height']=$data['width']=0;
		}
		$data['code']=md5($data['name']);
		
		if(isset($data['id'])){
			//判断该广告位下是否有广告，如果有，那么广告类型不得修改
			$count=Db::name('Advert')->where('position_id',$data['id'])->count();
			if($count>0 && isset($data['type'])){
				//判断是否修改了类型
				$pos_type=$this->where('id',$data['id'])->value('type');
				if($pos_type!=$data['type']) return $this->error('该广告位下存在广告，您不能修改广告位类型！');
			}
		}
		 
		/* 获取数据 */
		$validate = validate('AdvertPosition');
		if(!$validate->check($data)){
			return $this->error($validate->getError());
		}
		
		/* 添加或更新数据 */
		if(empty($data['id'])){
			//新增数据
			$this->data($data,true)->save();
			if(!$this->id) return $this->error ('新增失败！');
		} else { 
			//更新数据
			$status = $this->isUpdate(true)->save($data);
			if(false === $status) return $this->error ('更新失败！');
		}
		return true;
	}
	/**
	 * 删除
	 * @param unknown $id
	 * @return boolean  */
	public function del($id){
		//判断该广告位下是否存在广告
		$map=array(
				'position_id'=>$id
		);
		$count=Db::name('Advert')->where($map)->count();
		if($count>0) $this->error('该广告位下存在广告，不能删除！');
		
		if($this->destroy($id)){
			return true;
		}
		return $this->error("删除失败！");
	}
	/**
	 * 
	 * @param unknown $value
	 * @param unknown $data
	 * @return Ambigous <string>  */
	public function getStatusTextAttr($value,$data){
        $status = [0=>'禁用',1=>'正常'];
        return $status[$data['status']];
    }
	
}

?>
