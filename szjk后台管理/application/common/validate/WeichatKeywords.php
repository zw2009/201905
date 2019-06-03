<?php
namespace app\common\validate;

use think\Validate;
class WeichatKeywords extends Validate{
	protected $rule = [
	    ['keywords','require|length:1,20|unique:WeichatKeywords','关键字不得为空|关键字不得超过20位|该关键字回复已存在'],
	    ['content','requireIf:type,pic,text','内容不得为空'],
	    ['pic','requireIf:type,pic','图片不得为空'],
	    ['title','requireIf:type,pic','标题不得为空'],
	    ['link','url','链接地址填写错误'],
	    ['status','in:0,1','状态有误']
	];
}