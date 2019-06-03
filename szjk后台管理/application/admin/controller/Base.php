<?php
namespace app\admin\controller;
use think\Controller;
class Base extends Controller{
	public function _initialize(){
		if(!session('admin.id')){
			$this->redirect('Common/login');
		}else{
            //判断权限
            if(!model('Node')->check_right()) $this->error('没有权限！');
            //导航
            $this->assign('menu',session('access_menu'));
            //管理员信息
            $this->assign('session',session('admin'));
			$copyright=model('Config')->get_config('copyright');
			$this->assign('copyright',$copyright);
            //当前页面信息
            $module=$this->request->module();
            $controller=$this->request->controller();
            $action=$this->request->action();
			$page=model('Node')->page_info($module,$controller,$action);
			if($page){
                $this->assign('page_title',$page['page_title']);
                $this->assign('sub_node',$page['sub_node']);
                $this->assign('arr_parent_id',$page['arr_parent_id']);
                $this->assign('bread',$page['bread']);
            }
		}
	}
}
?>