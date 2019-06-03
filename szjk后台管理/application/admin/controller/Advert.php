<?php
namespace app\admin\controller;

class Advert extends Base{
	
	/**
	 * 列表
	 * @return */
	public function index(){
		$data=model('AdvertPosition')->paginate();
		$this->assign('data',$data);
		$this->assign('page',$data->render());
		return $this->fetch();
	}
	/**
	 * 新增
	 * @return */
	public function add_pos(){
		return $this->fetch();
	}
	/**
	 * 修改
	 * @param number $id
	 * @return*/
	public function edit_pos($id = 0){
		$data=model('AdvertPosition')->where('id',$id)->find();
		if(!$data) return $this->error('参数传递错误！');
		$this->assign('data',$data);
		return $this->fetch('add_pos');
	}
	/**
	 * 更新
	 * @param number $id
	 * @return*/
	public function update_pos(){
		$mod=model('AdvertPosition');
		$res = $mod->updates();
		if(!$res){
			$this->error($mod->getError());
		}else{
			$gourl=input('post.gourl')?input('post.gourl'):$_SERVER['HTTP_REFERER'];
    		if(isset($_POST['id'])){
    			$this->success('更新成功',$gourl);
    		}else{
    			$this->success('新增成功',$gourl);
    		}
		}
	}
	/**
	 * 删除
	 * @param unknown $id  */
	public function del_pos($id){
		$mod=model('AdvertPosition');
		if($mod->del($id)){
			$this->success('删除成功！');
		}else{
			$this->error($mod->getError());
		}
	}
	
	/**
	 * 广告位状态
	 *   */
	public function pos_status(){
		$id=input('id',0,'intval');
		if(!$id) $this->error('参数传递错误！');
		$mod=model('AdvertPosition');
		$status=$mod->where(array('id'=>$id))->value('status');
		$status=$status?0:1;
		$mod->where('id',$id)->update(['status'=>$status]);
		$this->redirect($_SERVER['HTTP_REFERER']);
	}
	
	/**
	 * 广告列表
	 *   */
	public function advert($pos_id){
		if($pos_id<1) $this->error('参数传递错误！');
		
		$result=model('Advert')->where('position_id',$pos_id)->paginate();
		
		$this->assign('data',$result);
		$this->assign('page',$result->render());
		 
		$this->assign('pos_id',$pos_id);
		return $this->fetch();
	}
	/**
	 * 添加广告
	 *   */
	public function add_advert($pos_id){
		 
		if($pos_id<1) $this->error('参数传递错误！');
		$map=array(
				'id'=>$pos_id
		);
		$pos=model('AdvertPosition')->get($pos_id);
		$this->assign('pos',$pos);
		$this->assign('pos_id',$pos['id']);
		
		return $this->fetch();
		 
	}
	/**
	 * 编辑/修改广告
	 *   */
	public function edit_advert($id){
		if($id<1) $this->error('参数传递错误！');
		//获取当前广告信息
		$advert=model('Advert')->get($id);
		if(!$advert) $this->error('该广告不存在！');
		$this->assign('data',$advert);
		$this->assign('pos',$advert->position);
		$this->assign('pos_id',$advert['position_id']);
		
		return $this->fetch('add_advert');
	}
	/**
	 * 更新
	 *   */
	public function update_advert(){
		$mod=model('Advert');
		$res = $mod->updates();
		if(!$res){
			$this->error($mod->getError());
		}else{
			$gourl=input('post.gourl')?input('post.gourl'):$_SERVER['HTTP_REFERER'];
    		if(isset($_POST['id'])){
    			$this->success('更新成功',$gourl);
    		}else{
    			$this->success('新增成功',$gourl);
    		}
		}
	}
	/**
	 * 删除广告
	 *   */
	public function del_advert($id){
		$mod=model('Advert');
		if($mod->del($id)){
			$this->success('删除成功！');
		}else{
			$this->error($mod->getError());
		}
	}
	/**
	 * 修改状态
	 *   */
	public function advert_status($id){
		if(!$id) $this->error('参数传递错误！');
		$mod=model('Advert');
		$status=$mod->where(array('id'=>$id))->value('status');
		$status=$status?0:1;
		$mod->where(array('id'=>$id))->update(['status'=>$status]);
		$this->redirect($_SERVER['HTTP_REFERER']);
	}
	/**
	 * 排序
	 *   */
	public function set_advert_order(){
		$data=input('post.');
		if($data['listorder']){
			foreach ($data['listorder'] as $id=>$sort){
				model('Advert')->where('id',$id)->update(['listorder'=>$sort]);
			}
		}
		$this->success('设置成功！');
	}
}
?>