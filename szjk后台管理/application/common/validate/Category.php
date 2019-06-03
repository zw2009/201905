<?php
namespace app\common\validate;

use think\Validate;
class Category extends Validate{
	protected $rule = [
	    ['name','require|max:25','栏目名称不得为空！|栏目名称不得超过25个字符'],
	    ['name_en','max:100','英文名称不得超过100个字符'],
	    ['type','in:article,linkstore,image,service,team','栏目类型选择错误'],
	    ['description','length:0,255','描述内容不得超过255个字符'],
	    ['parent_id','number','所属分类有误'],
	];
}