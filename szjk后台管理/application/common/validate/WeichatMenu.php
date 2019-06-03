<?php
namespace app\common\validate;

use think\Validate;
class WeichatMenu extends Validate{
	protected $rule = [
	    ['name','require','名称填写有误'],
	    ['parent_id','number','上级菜单选择有误'],
	    ['type','in:view,click','类型选择有误'],
	    ['keywords','number','关键词选择有误'],
	    ['link','url|requireIf:type,view','链接地址填写错误|view类型菜单，链接地址不得为空'],
	    ['status','in:0,1','状态有误'],
	    ['listorder','number','排序填写有误']
	];
}