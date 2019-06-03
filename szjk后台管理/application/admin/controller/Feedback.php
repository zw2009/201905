<?php
namespace app\admin\controller;
class Feedback extends Base{
	
	/*
	 * 列表
	 * */
	public function index(){
		$data=model('Feedback')->order('create_time DESC')->paginate();
		$this->assign('data',$data);
		$this->assign('page',$data->render());
		return $this->fetch();
	}
	
}
?>