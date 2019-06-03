<?php
namespace app\common\model;
use think\Db;
class Admin extends Base{
	protected $autoWriteTimestamp = true;
	/**
	 * 角色名称
	 * @param unknown $value
	 * @param unknown $data
	 * @return  */
	public function getRoleNameAttr($value,$data){
        return $data['id']==1?"超级管理员":Db::name('Role')->where(array('id'=>$data['role_id']))->value('role_name');
    }
    /**
     * 密码
     * @param unknown $value
     * @param unknown $data
     * @return string  */
    public function setPasswordAttr($value,$data){
    	return md5(md5($value).$data['encrypt']);
    }
    
	/* *
	 * 更新
	 *  */
	public function updates(){
		$data=input('post.');
		if(isset($data['id']) && $data['id']==1) return $this->error='不能对超级管理员进行修改！';
		
		if(!$data['password']){
			$data['password']=null;
		}else{
			$data['encrypt']=randString(5);
		}
		
		/* 验证数据 */
		$validate = validate('Admin');
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
		
		if($id==1) return $this->error('不能删除超级管理员！');
		
		if($id==session('admin.id')) return $this->error('不能删除自己！');
		
		if($this->destroy($id)){
			return true;
		}
		return $this->error("删除失败！");
	}

    public function login($login_name,$password,$verify=''){
        //验证用户名
        if(!check_login_name($login_name)) return $this->error('用户名填写错误！');
        //验证密码
        if(!check_password($password)) return $this->error('密码输入有误！');
        //验证验证码
        if(!check_verify($verify)) return $this->error('验证码输入有误！');

        //获取管理员信息
        $map=array(
            'login_name'=>$login_name
        );
        $admin=$this->where($map)->find();
        if(!$admin) return $this->error('该管理员不存在！');
        //匹配密码
        if(md5(md5($password).$admin['encrypt'])!=$admin['password']) return $this->error('账号或密码输入有误！');

        //设置权限
		$admin=$admin->toArray();
        model('Node')->set_right($admin);

        //更新管理员信息
        $data=array(
            'last_login_time'=>time(),
            'last_login_ip'=>request()->ip()
        );
        $this->where($map)->setField($data);
        return true;
    }
	
}

?>
