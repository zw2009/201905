<?php
namespace app\common\validate;

use think\Validate;
class Admin extends Validate{
	protected $rule = [
	    ['login_name','require|alphaDash|length:1,25|unique:Admin','账号有误！|账号只能包含数字、字母、下划线和破折号|账号不得超过25个字符|该管理员已存在'],
	    ['password','require|alphaDash|length:6,25','密码不得为空！|密码只能包含数字、字母、下划线和破折号|密码为6-25为字符'],
	];
}