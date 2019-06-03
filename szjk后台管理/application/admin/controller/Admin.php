<?php
namespace app\admin\controller;
class Admin extends Base{
    /* *
     * 管理员列表
     *   */
	public function index(){
		$data=model('Admin')->paginate();
    	$this->assign('data',$data);
    	$this->assign('page',$data->render());
    	return $this->fetch();
    }
    /* *
     * 新增管理员
     *   */
    public function add_admin(){
    	//获取所有角色
    	$map=array('status'=>1);
    	$role=model('Role')->where($map)->select();
    	$this->assign('role',$role);
    	return $this->fetch();
    	
    }
    /* *
     * 修改管理员
     *   */
    public function edit_admin($id){
    	$mod=model('Admin');
    	if($id<1) $this->error('参数传递错误！');
    	//获取所有角色
    	$role=model('Role')->where('status',1)->select();
    	$this->assign('role',$role); 
    	
    	$admin=$mod->where('id',$id)->find();
    	if(!$admin) $this->error('该管理员不存在');
    	if($admin['id']==1) $this->error('不能对超级管理员进行修改！');
    	$this->assign('data',$admin);
    		
    	return $this->fetch('add_admin');
    }
    /* *
     * 更新（新增/修改）
     *   */
    public function update_admin(){
    	$mod=model('Admin');
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
    /* *
     * 删除管理员
     *   */
    public function del_admin($id = 0){
    	$mod=model('Admin');
    	if($mod->del($id)){
    		$this->success('删除成功！');
    	}else{
    		$this->error($mod->getError());
    	}
    }
    /* *
     * 修改密码
     *   */
    public function modify_password(){
    	if($this->request->isPost()){
    		$data=input('post.');
    		$mod=model('Admin');
    		$data['id']=session('admin.id');
    		$map=array(
    			'id'=>session('admin.id')
    		);
    		$admin=$mod->where($map)->find();
    		if(md5(md5($data['org_password']).$admin['encrypt'])!=$admin['password']) $this->error('旧密码输入错误！');
    		
    		$_POST['encrypt']=$data['encrypt']=randString(5);
    		
    		if($mod->allowField(true)->isUpdate(true)->save($data)){
    			$this->success('修改成功！请重新登录！','Common/logout');
    		}else{
    			$this->error('修改失败！');
    		}
    		
    	}else{
    		return $this->fetch();
    	}
    }
   
    /* *
     * 角色列表
     *   */
    public function role(){
    	$role=db('Role')->order('listorder ASC')->select();
    	$this->assign('data',$role);
    	return $this->fetch();
    }
    
    /* *
     * 添加角色
     *   */
    public function add_role(){
    	
    	return $this->fetch();
    }
    /* *
     * 修改角色
     *   */
    public function edit_role($id = 0){
    	$mod = model ( 'Role' );
		$id || $this->error ( '参数传递错误！' );
		// 角色信息
		$role = $mod->where('id',$id)->find();
		$role || $this->error ( '该角色不存在！' );
		$this->assign ( 'data', $role );
		return $this->fetch ( 'add_role' );
    	
    }
    /* *
     * 更新（新增/修改）
     *   */
    public function update_role(){
    	$mod=model('Role');
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
    /* *
     * 删除角色
     *   */
    public function del_role($id){
    	$mod=model('Role');
    	if($mod->del($id)){
    		$this->success('删除成功！');
    	}else{
    		$this->error($mod->getError());
    	}
    }
    
    /* *
     * 设置角色权限
     *   */
    public function set_role_node(){
    	if($this->request->isPost()){
    		$role_id=input('role_id');
    		if($role_id<1) $this->error('参数传递错误！');
    		//角色信息
    		$role=model('Role')->where('id',$role_id)->find();
    		if(!$role) $this->error('该角色不存在！');
    		//删除旧权限
    		db('RoleNode')->where(array('role_id'=>$role_id))->delete();
    		//写入信息权限
    		if(isset($_POST['node_id'])){
    			$parent_node=array_keys($_POST['node_id']);
    			foreach ($parent_node as $parent_id){
    				if($_POST['node_id'][$parent_id]){
	    				$data=array(
	    						'role_id'=>$role_id,
	    						'node_id'=>$parent_id
	    				);
	    				db('RoleNode')->insert($data);
	    				
	    				foreach($_POST['node_id'][$parent_id] as $node_id){
	    					$data=array(
	    							'role_id'=>$role_id,
	    							'node_id'=>$node_id
	    					);
	    					db('RoleNode')->insert($data);
	    				}
    				}
    			}
    		}
    		//重置权限
    		model('Node')->set_right();
    		$this->success('权限设置成功！');
    	}else{
    		$role_id=input('id');
    		if($role_id<1) $this->error('参数传递错误！');
    		
    		//不能修改自己所属角色的权限
    		if($role_id==session('admin.role_id')) $this->error('不能修改自己角色的权限！');
    		
    		//角色信息
    		$role=model('Role')->where('id',$role_id)->find();
    		if(!$role) $this->error('该角色不存在！');
    		$this->assign('role',$role);
    		
	    	$all_node=model('Node')->get_node_tree();
	    	//return json($all_node);
	    	$this->assign('all_node',$all_node);
	    	//获取所有已有权限
	    	$right=db('RoleNode')->where('role_id',$role_id)->column('node_id');
	    	$this->assign('right',$right);
	    	return $this->fetch();
    	}
    }
    /* *
     * 节点列表
     *   */
    public function node($m = 'Admin',$parent_id=0){
    	//获取所有节点
    	$map=array(
    			'm'=>$m,
    			'parent_id'=>$parent_id
    	);
    	$node=model('Node')->where($map)->order('listorder ASC')->select();
    	$this->assign('data',$node);
    	$this->assign('m',$m);
    	return $this->fetch();
    }
    /* *
     * 新增节点
     *   */
    public function add_node($m = 'Admin'){
    	$mod=model('Node');
    	// 获取所有节点
		$all_node = $mod->field ( array ('id','node_name','parent_id','m' ) )->where ( array ('parent_id' => 0 ,'m'=>$m) )->order('m ASC,listorder ASC')->select ();
		$this->assign ( 'all_node', $all_node );
		return $this->fetch ();
    }
    /* *
     * 修改节点
     *   */
    public function edit_node($id){
    	$mod=model('Node');
    	
    	$node=$mod->where('id',$id)->find();
    	$this->assign('data',$node);
    	//获取所有节点
    	$all_node = $mod->field ( array ('id','node_name','parent_id','m' ) )->where ( array ('parent_id' => 0 ,'m'=>$node['m']) )->order('m ASC,listorder ASC')->select ();
		$this->assign('all_node',$all_node);
    
    	return $this->fetch('add_node');
    }
    /* *
     * 更新（新增/修改）
     *   */
    public function update_node(){
    	$mod=model('Node');
    	$res = $mod->updates();
    	if(!$res){
    		$this->error($mod->getError());
    	}else{
    		model('Node')->set_right();
    		$gourl=input('post.gourl')?input('post.gourl'):$_SERVER['HTTP_REFERER'];
    		if(isset($_POST['id'])){
    			$this->success('更新成功',$gourl);
    		}else{
    			$this->success('新增成功',$gourl);
    		}
    	}
    }
    /* *
     * 删除节点
     *   */
    public function del_node($id = 0){
    	$mod=model('Node');
    	if($mod->del($id)){
    		//重置权限
    		model('Node')->set_right();
    		$this->success('删除成功！');
    	}else{
    		$this->error($mod->getError());
    	}
    }
    /* *
     * 排序
     *   */
    public function node_listorder(){
    	if($this->request->isPost()){
    		$mod=model('Node');
    		foreach($_POST['listorder'] as $id => $listorder) {
    			$id = intval($id);
    			db('Node')->where(array('id'=>$id))->setField('listorder',$listorder);
    		}
    		//重置权限
    		model('Node')->set_right();
    	}
    	$this->success('操作成功！');
    }
    /* *
     * 修改状态
     *   */
    public function node_status($id){
    	if(!$id) $this->error('参数传递错误！');
    	$status=db('Node')->where(array('id'=>$id))->value('status');
    	$status=$status?0:1;
    	db('Node')->where(array('id'=>$id))->setField('status',$status);
    	//重置权限
    	model('Node')->set_right();
    	$this->redirect($_SERVER['HTTP_REFERER']);
    }
    /* *
     * 修改显示状态
     *   */
    public function node_display_status($id){
    	if(!$id) $this->error('参数传递错误！');
    	$status=db('Node')->where(array('id'=>$id))->value('is_display');
    	$status=$status?0:1;
    	db('Node')->where(array('id'=>$id))->setField('is_display',$status);
    	//重置权限
    	model('Node')->set_right();
    	$this->redirect($_SERVER['HTTP_REFERER']);
    }
}