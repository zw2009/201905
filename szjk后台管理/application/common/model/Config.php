<?php
namespace app\common\model;
use think\Db;
class Config extends Base{
	
	/**
	 * 列表
	 * @return unknown  */
	public function lists(){
		$config=Db::name('Config')->order('listorder ASC')->select();
		foreach($config as $k=>$v){
			if($v['select_range']){
				$temp=array();
				$range=array_filter(explode(';', $v['select_range']));
				if($range){
					foreach($range as $key=>$val){
						$val=explode(':', $val);
						$temp[]=array(
								$val[0],
								$val[1],
						);
					}
				}
				$config[$k]['select_range']=$temp;
			}
		}
		$config=list_to_tree($config,'id','parent_id','child');
		return $config;
	}
	
	/**
	 * 单条记录
	 *   */
	public function details($id){
		return $this->where('id',$id)->find();
	}
	
	public function updates(){
		$data=input('post.');
		
		$data['input_type']=input('input_type',1);
		
		if($data['input_type']==2 || $data['input_type']==3){
		    if($data['select_range']){
		    	$data['select_range']=str_replace(array('；','：'," ","　","\t","\n","\r"),array(';',':',"","","","",""),$data['select_range']);
		    }else{		
		    	return  $this->error('单选/复选类型的配置项必须设置可选范围！');
		    }
	    }else{
	    	$data['select_range']='';
	    }
	    
	    if($data['parent_id']!=0 && isset($data['id'])){
	    	$map=array(
	    			'parent_id'=>$data['id'],
	    	);
	    	if($this->where($map)->count() > 0) return $this->error('该配置下存在配置项，您不能修改所属上级分类！');
	    }
			
		/* 获取数据 */
		$validate = validate('Config');
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
		$map=array(
				'parent_id'=>$id,
		);
		if($this->where($map)->count() > 0) return $this->error('该配置下存在配置项，您不能删除！');
		
		if($this->destroy($id)){
			return true;
		}
		return $this->error("删除失败！");
	}
	
	public function get_config($code = ''){
		if(empty($code)){
			$config=Db::name('Config')->order('parent_id ASC')->column('id,parent_id,config_code,value','id');
			if($config){
				foreach ($config as $k=>$v){
					if($v['parent_id']!=0){
						if(isset($config[$v['parent_id']]['config_code'])) $data[$config[$v['parent_id']]['config_code']][$v['config_code']]=$v['value'];
					}
				}
			}
		}else{
			$config=Db::name('Config')->where('config_code',$code)->find();
			if(!$config) return '';
			if($config['parent_id']==0){
				$data=Db::name('Config')->where('parent_id',$config['id'])->column('value','config_code');
			}else{
				$data=$config['value'];
			}
		}
		return $data;
	}
}

?>
