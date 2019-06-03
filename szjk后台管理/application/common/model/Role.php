<?php
namespace app\common\model;
class Role extends Base{
	protected $autoWriteTimestamp = true;
	
	/* *
	 * 新增/修改
	 *  */
	public function updates(){
		$data=input('post.');
		
		$data['status']=isset($data['status'])?1:0;
			
		/* 获取数据 */
		$validate = validate('Role');
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
		//角色信息
		$role=$this->details($id);
		if(!$role){
			return $this->error('该角色不存在！');
		}
		//判断该角色下是否存在管理员
		$map=array('role_id'=>$id);
		$count=model('Admin')->where($map)->count();
		if($count){
			return $this->error('该角色下存在管理员，您不能删除！');
		}
		if($this->destroy($id)){
			return true;
		}
		return $this->error("删除失败！");
	}
	
}

?>
