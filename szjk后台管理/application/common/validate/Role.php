<?php
namespace app\common\validate;

use think\Validate;
class Role extends Validate{
	protected $rule = [
	    ['role_name','require|unique:Role','角色名称不得为空！|该角色已存在'],
	    ['parent_id','number','上级角色有误'],
	    ['status','in:0,1','状态有误'],
	    ['listsort','between:1,100','排序请填写100以内整数'],
	];
}