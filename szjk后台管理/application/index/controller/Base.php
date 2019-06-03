<?php
namespace app\index\controller;
use think\Config;
use think\Controller;
use think\Db;

class Base extends Controller{
    public  function __construct()
    {
        if(ismobile()){
            config('template.view_path','../application/index/view/mobile/');
        }else{
            config('template.view_path','../application/index/view/default/');
        }
        parent::__construct();
    }
    public function _initialize(){
        $menu=Db::name('Category')
            ->field(['id','parent_id','name'])
            ->where('status',1)
            ->order('listorder ASC,id DESC')
            ->select();
        $menu=list_to_tree($menu);
        $this->assign('menu',$menu);

        $config=model('Config')->get_config('basic');
        $webconfig=model('Config')->get_config('webconfig');
        $config=array_merge($config,$webconfig);
        $this->assign('config',$config);

        $cfooter=Db::name('Category')
            ->field(['id','name'])
            ->where('status',1)
            ->where('is_focus',1)
            ->order('listorder ASC,id DESC')
            ->select();
        $this->assign('cfooter',$cfooter);
    }
}
