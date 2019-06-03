<?php
namespace app\admin\controller;
use think\Db;
class Index extends Base{
	public function index(){
        $team=Db::name('Article')
            ->alias('a')
            ->join('hly_category b','b.id=a.cate_id')
            ->where('b.type','team')
            ->where('a.status',1)
            ->count();
        $this->assign('team',$team);
        $linkstore=Db::name('Article')
            ->alias('a')
            ->join('hly_category b','b.id=a.cate_id')
            ->where('b.type','linkstore')
            ->where('a.status',1)
            ->count();
        $this->assign('linkstore',$linkstore);
        $service=Db::name('Article')
            ->alias('a')
            ->join('hly_category b','b.id=a.cate_id')
            ->where('b.type','service')
            ->where('a.status',1)
            ->count();
        $this->assign('service',$service);
		return $this->fetch();
	}
}
?>