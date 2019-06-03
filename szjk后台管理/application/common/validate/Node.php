<?php
namespace app\common\validate;

use think\Validate;
class Node extends Validate{
	protected $rule = [
	    ['node_name','require','节点名称不得为空'],
	    ['m','/^[a-zA-z]{1}\w+$/','模型有误'],
	    ['c','/^[a-zA-z]{1}\w+$/','控制器有误'],
	    ['a','/^[a-zA-z]{1}\w+$/','方法有误'],
	    ['parent_id','number','上级节点选择有误'],
	    ['status','in:0,1','状态有误'],
	    ['is_display','in:0,1','显示状态有误'],
	    ['listsort','between:1,100','排序请填写100以内整数'],
	];
}