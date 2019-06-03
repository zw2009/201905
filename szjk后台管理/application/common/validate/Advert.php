<?php
namespace app\common\validate;

use think\Validate;
class Advert extends Validate{
	protected $rule = [
	    ['position_id','number','广告位有误'],
	    ['title','require','广告标题不得为空'],
	    ['link','url','链接格式有误'],
	    ['listorder','number|max:3','排序输入有误|排序不得超过3位'],
	];
}