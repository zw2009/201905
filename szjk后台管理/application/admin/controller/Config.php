<?php
namespace app\admin\controller;

class Config extends Base {
    /**
     * 设置配置
     *   */
	public function index(){
		if($this->request->isPost()){
			$data=input('post.');
			//处理普通配置
			if($data){
				foreach($data as $k=>$v){
					model('Config')->where('id',$k)->update(['value'=>$v]);
				}
			}
			//文件类型
			if($_FILES){
				foreach($_FILES as $k=>$v){
					$value=uploads_single($k);
					if($value['code']==1){
						model('Config')->where('id',$k)->update(['value'=>$value['data']]);
					}
				}
			}
			$this->success('保存成功！');
		}else{
			// 获取所有配置
			$config=model('Config')->lists();
			$this->assign('config',$config);
	    	return $this->fetch();
		}
    }
    
  	/**
     * 新增配置
     *   */
	public function add_config(){
    	//获取所有分类
    	$map=array(
    			'parent_id'=>0
    	);
    	$allConfig=model('Config')->where($map)->select();
    	$this->assign('allConfig',$allConfig);
    	return $this->fetch();
    }
    /**
     * 配置列表
     *   */
    public function config_list(){
    	// 获取所有配置
    	$config=model('Config')->lists();
    	$this->assign('config',$config);
    	return $this->fetch();
    }
    
    /**
     * 修改配置项
     *   */
    public function edit_config($id = 0){
    	if($id<1) $this->error('参数传递错误！');
    	//获取所有分类
    	$map=array(
    			'parent_id'=>0
    	);
    	$allConfig=model('Config')->where($map)->select();
    	$this->assign('allConfig',$allConfig);
    		
    	$config=model('Config')->where(array('id'=>$id))->find();
    	$this->assign('config',$config);
    		
    	return $this->fetch('add_config');
    }
    
    /**
     * 更新
     *   */
    public function update_config(){
    	$mod=model('Config');
    	$res = $mod->updates();
    	if(!$res){
    		$this->error($mod->getError());
    	}else{
    		if(isset($_POST['id'])){
    			$this->success('更新成功');
    		}else{
    			$this->success('新增成功');
    		}
    	}
    }
    /**
     * 删除配置项
     *   */
    public function del_config($id = 0){
    	$mod=model('Config');
    	if($mod->del($id)){
    		$this->success('删除成功！');
    	}else{
    		$this->error($mod->getError());
    	}
    }
    /**
     * 排序
     *   */
    public function listorder(){
    	if(IS_POST){
    		$mod=model('Config');
    		foreach($_POST['listorders'] as $id => $listorder) {
    			$id = intval($id);
    			$mod->where('id',$id)->update(['listorder'=>$listorder]);
    		}
    	}
    	$this->success('操作成功！');
    }
}