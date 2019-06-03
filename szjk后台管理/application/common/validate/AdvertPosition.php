<?php
namespace app\common\validate;

use think\Validate;
class AdvertPosition extends Validate{
	protected $rule = [
	    ['name','require|unique:AdvertPosition','广告位名称不得为空！|该广告位已存在'],
	    ['type','in:1,2','广告类型有误'],
	    ['width','number','宽度输入有误'],
	    ['height','number','高度输入有误'],
	];
}