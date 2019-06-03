<?php
namespace app\common\model;
class Advert extends Base{
	protected $autoWriteTimestamp = true;
	
	public function getPicturePathAttr($value,$data){
		return filterPic($data['picture']);
	}
	public function position(){
		return $this->belongsTo('AdvertPosition','position_id');
	}
	
	public function updates(){
		$data=input('post.');
		//获取当前选择的广告位信息
		if(isset($data['position_id'])) $pos=model('AdvertPosition')->get($data['position_id']);
		if(!$pos) return $this->error('当前选择的广告位不存在！');
		if($pos['type']==1){
			unset($data['content']);
			if(empty($data['picture'])){
				return $this->error('广告图片不得为空');
			}
		}elseif($pos['type']==2){
			$data['picture']='';
			if(!$data['content']) return $this->error('文字广告，图片不得为空！');
		}else{
			return $this->error('广告类型有误！');
		}
			
		/* 获取数据 */
		$validate = validate('Advert');
		if(!$validate->check($data)){
			return $this->error($validate->getError());
		}
		
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
	/**
	 * 删除
	 * @param unknown $id
	 * @return boolean  */
	public function del($id){
		if($this->destroy($id)){
			return true;
		}
		return $this->error("删除失败！");
	}
	/* *
	 * 获取广告
	 *  */
	public function get_advert($pos_id,$size=1){
		$map=array(
				'position_id'=>$pos_id,
				'status'=>1
		);
		if($size==1){
			$advert=$this->field(['id','title','link','picture','type','link_id','position_id'])->where($map)->order('listorder ASC,create_time DESC')->find();
			$advert['picture_path']=$advert->picture_path;
		}elseif($size>1){
			$advert=$this->field(['id','title','link','picture','type','link_id','position_id'])->where($map)->order('listorder ASC,create_time DESC')->limit($size)->select();
			if($advert){
				foreach ($advert as $k=>$v){
					$v['picture_path']=$v->picture_path;
				}
			}
		}
		return $advert;
	}
}

?>
