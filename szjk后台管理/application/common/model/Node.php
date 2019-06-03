<?php
namespace app\common\model;
use think\Db;
class Node extends Base{
	
	public function getUrlAttr($value,$data){
	    if($data['m'] && $data['c'] && $data['a']){
            $url = url($data['m']."/".$data['c']."/".$data['a'],$data['param']);
        }else{
	        $url = '#';
        }
		return $url;
	}
	
	public function setMAttr($value){
		return ucwords($value);
	}
	
	public function setCAttr($value){
		return ucwords($value);
	}
	
	public function updates(){
		$data=input('post.');
	
		$data['m']=$data['modules'];
		$data['c']=$data['controller'];
		$data['a']=$data['action'];
		$data['is_display']=input('is_display')?1:0;
		
		if(isset($data['id'])){
			//获取所有分类
			$allNode=Db::name('Node')->select();
			//获取该分类的所有子分类id
			$child_ids=getChildsId($allNode,$data['id']);
			if(in_array($data['parent_id'],$child_ids)) return  $this->error('所选择的上级节点不能是当前节点或者当前节点的下级节点!');
		}
		
		/* 获取数据 */
		$validate = validate('Node');
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
		if(!$id) return $this->error('参数传递错误！'); 
		//判断该节点下是否还有子节点
		/* 获取所有节点 */
		$allNode=Db::name('Node')->select();
		/* 获取该分类的所有子分类id */
		$child_ids=getChildsId($allNode,$id);
		if(!empty($child_ids)) return $this->error('该节点不是末级节点或者此节点下还存在关联信息,您不能删除!');
		
		if($this->destroy($id)){
			//删除与该节点相关联的权限
			Db::name('RoleNode')->where(array('node_id'=>$id))->delete();
			return true;
		}
		return $this->error("删除失败！");
	}
    /*
     * 获取页面信息
     * */
    public function page_info($m,$c,$a){
	    $data=array();
        $all_node=Db::name('Node')->field(['id','parent_id','node_name','m','c','a','param'])->select();
        //页面标题
        $map=array(
            'm'=>ucfirst($m),
            'c'=>ucfirst($c),
            'a'=>$a
        );
        $page=$this->where($map)->find();
        if($page){
            //页面标题
            $data['page_title']=$page['node_name'];
            //二级栏目
            $node_id=$page['id'];
            $arr_parent_id=getParentsId($all_node,$node_id);
            $arr_parent_id=$arr_parent_id?array_merge($arr_parent_id,array($node_id)):array($node_id);
            $top_node=getTopParentsId($all_node,$node_id);
            $sub_node=model('Node')->where('parent_id',$top_node)->where('is_display',1)->order('listorder ASC')->select();
            $data['sub_node']=$sub_node;
            $data['arr_parent_id']=$arr_parent_id;
            //面包屑导航
            $data['bread']=getParents($all_node,$node_id);
            foreach ($data['bread'] as $k=>$v){
                $data['bread'][$k]['url']=$this->getUrlAttr(null,$v);
            }
            $data['bread']=array_reverse($data['bread']);
        }else{
            $data['page_title']="后台管理";
            $data['sub_node']=[];
            $data['arr_parent_id']=[];
            $data['bread']=[];
        }
        return $data;
    }
    /**
     * 获取页面标题
     * @param unknown $m
     * @param unknown $c
     * @param unknown $a
     * @return Ambigous <\Think\mixed, NULL, mixed, unknown, multitype:Ambigous <unknown, string> unknown , object>  */
    public function page_bread($m,$c,$a){
        $map=array(
            'm'=>ucfirst($m),
            'c'=>ucfirst($c),
            'a'=>$a
        );
        $node=$this->field(array('node_name','parent_id'))->where($map)->find();
        $bread['page_title']=$node['node_name'];
        if($node['parent_id']>0) $bread['parent_title']=$this->where(array('id'=>$node['parent_id']))->value('node_name');

        return $bread;
    }
    /**
     * 获取导航
     * @return multitype:urlnknown  */
    public function get_menu($where=null){
        $map=array(
            'status'=>1,
            'm'=>'Admin',
            'is_display'=>1
        );
        if($where) $map=array_merge($map,$where);
        $node=Db::name('Node')->field(array('id','parent_id','node_name','m','c','a','param'))->where($map)->order('listorder ASC')->select();
        foreach ($node as $k=>$v){
            $node[$k]['url']=url($v['m']."/".$v['c']."/".$v['a'],$v['param']);
        }
        $node=list_to_tree($node);
        return $node;
    }

    public function get_node_tree($m='Admin'){
        $map=array(
            'status'=>1,
            'm'=>$m
        );
        $node=Db::name('Node')->field(array('id','parent_id','node_name','m','c','a'))->where($map)->order('listorder ASC')->select();

        if($node){
            $node=list_to_tree($node);
        }
        return $node;
    }
    /**
     * 设置权限
     * @param unknown $admin  */
    public function set_right($admin = null){
        if(!$admin) $admin=session('admin');
        //获取管理权限
        $admin['is_superadmin']=$admin['id']==1? 1:0;
        if($admin['is_superadmin']!=1){
            //判断角色状态
            $role_status=model('Role')->where(array('id'=>$admin['role_id']))->value('status');
            if($role_status!=1) return $this->error('所在管理组已被取消！');
            $map=array(
                'role_id'=>$admin['role_id']
            );
            $access_node=Db::name('RoleNode')->where($map)->column('node_id');
            //获取权限导航
            if($access_node){
                $map=array('id'=>array('in',$access_node));
                $menu=$this->get_menu($map);
                session('access_menu',$menu);
            }
            session('access_node',$access_node);
        }else{
            $menu=$this->get_menu();
            session('access_menu',$menu);
        }
        session('admin',$admin);
    }
    /**
     * 判断权限
     * @return boolean  */
    public function check_right(){
        if(session('admin.is_superadmin')!=1){
            $map=array(
                'm'=>ucfirst(request()->module()),
                'c'=>request()->controller(),
                'a'=>request()->action(),
                'status'=>1
            );
            $curr_node=$this->where($map)->value('id');
            if($curr_node){
                if(!in_array($curr_node,session('access_node'))) return false;
            }
        }
        return true;
    }
}

?>
