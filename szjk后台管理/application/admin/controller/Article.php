<?php
namespace app\admin\controller;
use think\Db;
class Article extends Base {
    public function lists($type=''){
        $cate_ids=Db::name('Category')->where('type',$type)->column('id');
        $cate_ids=$cate_ids?$cate_ids:'';
        $map=array(
            'cate_id'=>array('in',$cate_ids)
        );
        /*标题  */
        $keywords=input('keywords');
        if($keywords) $map['title|keywords']=array('like',"%$keywords%");
        //分类
        $cate_id=input('cate_id');
        if($cate_id>0) $map['cate_id']=$cate_id;

        $data=model('Article')->where($map)->order('create_time DESC')->paginate();
        $this->assign('data',$data);
        $this->assign('page',$data->render());
        //所有分类
        $allCate=model('Category')->where('status',1)->select();
        $allCate=unlimitedForCat($allCate);
        $this->assign ( 'allCate', $allCate );
        //标题
        $cate_name=Db::name('Category')->where('id',$cate_id)->value('name');
        $this->assign('page_title',$cate_name);
        $this->assign('type',$type);
        return $this->fetch('index');
    }
    /* *
     * 文章列表
     *   */
	public function index(){
	    $type='article';
	    return $this->lists($type);
    }
    /*
     * 连锁机构
     * */
    public function linkstore(){
        $type='linkstore';
        return $this->lists($type);
    }
    /* *
     * 科室
     *   */
    public function service(){
        $type='service';
        return $this->lists($type);
    }
    /*
     * 团队
     * */
    public function team(){
        $type='team';
        return $this->lists($type);
    }
	/* *
     * 添加
     *   */
    public function add(){
        $type=input('type');
        //所有分类
        $allCate=model('Category')->where('type',$type)->where('status',1)->select();
        $allCate=unlimitedForCat($allCate);
        $this->assign ( 'allCate', $allCate );
        $types=array('article','linkstore','service','team');
        if(in_array($type,$types)){
            $this->assign('type',$type);
            if($type=='linkstore'){
                /* 区域数据 */
                $dist=model('Area')->get_dist();
                $this->assign('dist',$dist);
            }
            return $this->fetch();
        }else{
            $this->error('参数传递有误');
        }
    }

    /* *
     * 修改
     * @param int $id
     * @return mixed
     */
    public function edit($id = 0){
    	$id<1 && $this->error('参数传递错误！');
    	//获取当前文章信息
    	$data=model('Article')->where('id',$id)->find();
        $data ||  $this->error('该内容不存在！');
    	$this->assign('data',$data);

    	$type=$data['cate_type'];
        $this->assign('type',$type);

        if($data['cate_type']=='linkstore'){
            /* 区域数据 */
            $dist=model('Area')->get_dist();
            $this->assign('dist',$dist);
        }
        //所有分类
        $allCate=model('Category')->where('type',$type)->where('status',1)->select();
        $allCate=unlimitedForCat($allCate);
        $this->assign ( 'allCate', $allCate );
    	return $this->fetch('add');
    }
    /* *
     * 更新
     *   */
    public function update(){
    	$mod=model('Article');
    	Db::startTrans();
    	$res = $mod->updates();
    	if(!$res){
    		$this->error($mod->getError());
    	}else{
            Db::commit();
    		if(isset($_POST['id'])){
    			$this->success('更新成功');
    		}else{
    			$this->success('新增成功');
    		}
    	}
    }

    /* *
     * 状态
     * @param $id
     */
    public function news_status($id){
    	$article=db('Article')->where(array('id'=>$id))->find();
    	if($article['is_system']==1) return $this->error('系统文章不得关闭');
    	$status=$article['status']?0:1;
    	db('Article')->where(array('id'=>$id))->setField('status',$status);
    	$this->redirect($_SERVER['HTTP_REFERER']);
    }

    /* *
     * 推荐状态
     * @param $id
     */
    public function news_recommend($id){
    	$status=db('Article')->where(array('id'=>$id))->value('is_recommend');
    	$status=$status?0:1;
    	db('Article')->where(array('id'=>$id))->setField('is_recommend',$status);
    	$this->success('设置成功！');
    }

    /* *
     * 删除内容
     * @param int $id
     */
    public function del($id = 0){
    	$mod=model('Article');
    	if($mod->del($id)){
    		$this->success('删除成功！');
    	}else{
    		$this->error($mod->getError());
    	}
    }

}