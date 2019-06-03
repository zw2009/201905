<?php
namespace app\common\validate;

use think\Validate;
class Config extends Validate{
	protected $rule = [
	    ['config_name','require','配置名称不得为空'],
	    ['config_code','checkConfigName:thinkphp|unique:Config','配置标识设置有误！|该配置已存在'],
	    ['input_type','in:1,2,3,4,5,6','配置类型选择有误'],
	    ['parent_id','number','所属分类有误'],
	];
	
	protected function checkConfigName($value){
		return hasNoChinese($value);
	}
}