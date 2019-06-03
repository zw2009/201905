<?php
namespace app\admin\controller;
use think\Db;
class Category extends Base {
    /* *
     * 文章列表
     *   */
	public function index(){
        // 获取所有分类
        $data = model('Category')->select();
        $data = unlimitedForCat($data);
        $this->assign('data', $data);
        return $this->fetch();
    }
    
	/* *
     * 添加
     *   */
    public function add(){
        $pid=input('pid',0);
        if($pid){$pcate=Db::name('Category')->where('id',$pid)->find();
            if(!$pcate) $this->error('非法操作');
            $this->assign('pcate',$pcate);
        }
        $this->assign('pid',$pid);
        return $this->fetch();
    	
    }

    /* *
     * 修改
     */
    public function edit($id = 0){
        //分类信息
        $cate=model('Category')->where('id',$id)->find();
        if(!$cate) $this->error('该记录不存在！');
        $this->assign('data',$cate);
        //上级
        $pid=$cate['parent_id'];
        if($pid){
            $pcate=Db::name('Category')->where('id',$pid)->find();
            if(!$pcate) $this->error('非法操作');
            $this->assign('pcate',$pcate);
        }
        $this->assign('pid',$pid);
        return $this->fetch('add');
    }
    /* *
     * 更新
     *   */
    public function update(){
        $mod=model('Category');
        Db::startTrans();
        $res = $mod->updates();
        if(!$res){
            $this->error($mod->getError());
        }else{
            Db::commit();
            if(isset($_POST['id'])){
                $this->success('更新成功','index');
            }else{
                $this->success('新增成功','index');
            }
        }
    }
    /* *
     * 状态切换
     *   */
    public function cate_status($id){
    	$status=db('Category')->where(array('id'=>$id))->value('status');
    	$status=$status?0:1;
    	db('Category')->where(array('id'=>$id))->setField('status',$status);
    	$this->redirect($_SERVER['HTTP_REFERER']);
    }
    /* *
     * 推荐
     *   */
    public function is_focus_status($id){
    	$status=db('Category')->where(array('id'=>$id))->value('is_focus');
    	$status=$status?0:1;
    	db('Category')->where(array('id'=>$id))->setField('is_focus',$status);
    	$this->redirect($_SERVER['HTTP_REFERER']);
    }
    /* *
     * 排序
     *   */
    public function set_listorder(){
    	$data=input('post.');
    	if($data['listorder']){
    		foreach ($data['listorder'] as $id=>$sort){
    			Db::name('Category')->where(array('id'=>$id))->setField('listorder',$sort);
    		}
    	}
    	$this->redirect($_SERVER['HTTP_REFERER']);
    }

    /* *
     * 删除栏目
     * @param $id
     */
    public function del($id){
    	$mod=model('Category');
    	if($mod->del($id)){
    		$this->success('删除成功！');
    	}else{
    		$this->error($mod->getError());
    	}
    }
}