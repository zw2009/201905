<?php
namespace app\common\model;
use think\Db;
class Category extends Base{

	public function updates(){
		$data=input('post.');
		
		//分类图标
		if(!empty($_FILES['thumb']['name'])){
			$up_res=uploads_single('thumb',true,'150','150');
			if($up_res['code']!=1) return $this->error($up_res['msg']);
			$data['thumb']=$up_res['data'];
		}
		
		if(!isset($data['is_menu'])) $data['is_menu']=0;
		if(!isset($data['is_focus'])) $data['is_focus']=0;

		//文章模型
		if($data['parent_id']!=0){
			$pcate=Db::name('Category')->where('id',$data['parent_id'])->find();
			if(!$pcate) return $this->error('上级栏目不存在');
			$data['type']=$pcate['type'];
		}
		/* 获取数据 */
		$validate = validate('Category');
		if(!$validate->check($data)){
			return $this->error($validate->getError());
		}
	
		/* 添加或更新数据 */
		if(!isset($data['id'])){
			//新增数据
			$this->allowField(true)->save($data);
			if(!$this->id) return $this->error ('新增失败！');
		} else {
            $cate=Db::name('Category')->where('id',$data['id'])->find();
			//更新数据
			$status = $this->allowField(true)->isUpdate(true)->save($data);
			if(false === $status) return $this->error ('更新失败！');
			if($data['parent_id']==0){
                //修改顶级分类
                if($cate['type']!=$data['type']){
                    //修改下级模型
                    $allcate=Db::name('Category')->select();
                    $child_ids=getChildsId($allcate, $data['id']);
                    if($child_ids){
                        $res=Db::name('Category')->where('id','in',$child_ids)->setField('type',$data['type']);
                        if(!$res) return $this->error('修改失败');
					}
                }
			}
		}
		return true;
	}
	/**
	 * 删除
	 * @param unknown $id
	 * @return boolean  */
	public function del($id){
		$cate=$this->where('id',$id)->find();
		if(!$cate) return $this->error('查询记录失败！');
		if($cate['is_system']==1) return $this->error('系统分类，不能删除！');
    	/* 判断该栏目是否是末级栏目 */
    	if($this->where('parent_id',$id)->count()) return $this->error('该栏目不是末级栏目,请先删除其子栏目');

    	/* 判断该栏目下是否存在文章  */
    	$has_cont=Db::name('Article')->where('cate_id',$id)->count();
    	
    	if($has_cont>0) $this->error('该栏目下存在关联的文章，您不能删除!');
    	
		if($this->destroy($id)){
			return true;
		}
		return $this->error("删除失败！");
	}
	
	/**
	 * 生成适合select的数组
	 * @param string $where
	 * @return array  */
	public function options_cate($where='1=1'){
		$allCate=Db::name('Category')->where($where)->order('listorder ASC')->select();
		if(!$allCate) return array();
		$allCate=unlimitedForCat($allCate);
		$arr=array(
				'0'=>'请选择栏目'
		);
		if($allCate){
			foreach ($allCate as $v){
				$arr[$v['id']]=$v['html'].$v['name'];
			}
		}
		return $arr;
	}
}

?>
