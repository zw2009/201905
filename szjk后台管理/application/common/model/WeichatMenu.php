<?php
namespace app\common\model;
use think\Db;
class WeichatMenu extends Base{
	/**
	 * 角色名称
	 * @param unknown $value
	 * @param unknown $data
	 * @return  */
	public function getKeywordsNameAttr($value,$data){
        return !$data['keywords']?"":Db::name('WeichatKeywords')->where(array('id'=>$data['keywords']))->value('keywords');
    }
   
    
	/**
	 * 列表
	 * @return unknown  */
	public function lists(){
		$list=$this->order('listorder ASC')->select();
		return $list;
	}
	
	/**
	 * 单条记录
	 *   */
	public function details($id){
		return $this->where('id',$id)->find();
	}
	/**
	 * 新增/修改
	 * @return string|boolean  */
	public function updates(){
		$post=input('post.');
	
		if($post['type']=='click'){
    		//关键字
    		$data = array (
					'name' => $post ['name'],
					'parent_id' => $post ['parent_id'],
					'type' => 'click',
					'keywords' => intval ( $post ['keywords'] ),
					'listorder' => intval ( $post ['listorder'] ),
					'status' => intval ( $post ['status'] ) 
			);
		} elseif ($post ['type'] == 'view') {
			// 跳转链接
			$data = array (
					'name' => $post ['name'],
					'parent_id' => $post ['parent_id'],
					'type' => 'view',
					'link' => trim ( $post ['link'] ),
					'listorder' => intval ( $post ['listorder'] ),
					'status' => intval ( $post ['status'] ) 
			);
		} else {
			return $this->error ( '类型选择有误！' );
		}
		if(isset($post['id'])) $data['id']=$post['id'];
		
		/* 获取数据 */
		$validate = validate('WeichatMenu');
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
		//判断是否末级分类
		$has_child=$this->where(array('parent_id'=>$id))->count();
		if($has_child['counts']>0) $this->error('该菜单存在下级菜单！');
		if($this->destroy($id)){
			return true;
		}
		return $this->error("删除失败！");
	}
	
	
}

?>
