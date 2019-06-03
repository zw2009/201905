<?php
namespace app\index\controller;
use think\Controller;
use think\Db;

class Article extends Base {
    /*
     * 首页
     * */
    public function lists(){
        //当前分类
        $cid=input('cid');
        $cate=Db::name('Category')->where('id',$cid)->find();
        $this->assign('cate',$cate);
        if(!$cate) $this->error('记录不存在');

        //顶级分类
        $all_cate=Db::name('Category')
            ->where('type',$cate['type'])
            ->where('status',1)
            ->select();
        $top_id=getTopParentsId($all_cate,$cid);
        $this->assign('top_id',$top_id);
        $topcate=Db::name('Category')->where('id',$top_id)->find();
        $this->assign('topcate',$topcate);
        //二级分类
        $subcate=Db::name('Category')
            ->where('parent_id',$top_id)
            ->where('status',1)
            ->select();
        $this->assign('subcate',$subcate);
        if($cate['type']=='article' && $cate['is_page']==1){
            $this->assign('data',$cate);
            $template=$cate['index_template']?$cate['index_template']:"index_".$cate['type'];
            return $this->fetch($template);
        }else{
            $cate_ids=getChildsId($all_cate,$cid);
            $cate_ids=$cate_ids?array_merge($cate_ids,array($cid)):array($cid);
            if($cate['type']=='linkstore'){
                $map=array(
                    'cate_id'=>['in',$cate_ids]
                );
                $dist=input('dist');
                if($dist){
                    $map['b.province']=$dist;
                }
                $lists=model('Article')
                    ->alias('a')
                    ->join('hly_addon_'.$cate['type'].' b','a.id=b.article_id')
                    ->where($map)
                    ->paginate();
                //已有省份列表
                $province=Db::name('Article')
                    ->field(['b.province'=>'code','c.name'])
                    ->alias('a')
                    ->join('hly_addon_linkstore b','a.id=b.article_id')
                    ->join('hly_area c','b.province=c.code')
                    ->distinct(true)
                    ->select();
                $this->assign('province',$province);
            }elseif($cate['type']!='article'){
                $lists=model('Article')
                    ->alias('a')
                    ->join('hly_addon_'.$cate['type'].' b','a.id=b.article_id')
                    ->where('cate_id','in',$cate_ids)
                    ->paginate();
            }else{
                $lists=model('Article')
                    ->where('cate_id','in',$cate_ids)
                    ->paginate();
            }

            $this->assign('lists',$lists);
            $this->assign('page',$lists->render());
            $template="list_".$cate['type'];
            return $this->fetch($template);
        }
    }

    public function info(){
        $id=input('id');
        $data=model('Article')->where('id',$id)->find();
        if(!$data) $this->error('内容不存在');
        $type=$data['cate_type'];
        $data['content']=$data->content;
        $data=$data->toArray();
        if($type!='article'){
            $addon=Db::name('Addon'.ucfirst($type))
                ->where('article_id',$id)
                ->find();
            if(!$addon) return $this->error('内容不存在');
            $data=array_merge($data,$addon);
        }
        $this->assign('data',$data);
        //当前分类
        $cid=$data['cate_id'];
        $cate=Db::name('Category')->where('id',$cid)->find();
        //顶级分类
        if(!$cate) $this->error('记录不存在');
        $all_cate=Db::name('Category')
            ->where('type',$cate['type'])
            ->where('status',1)
            ->select();
        $top_id=getTopParentsId($all_cate,$cid);
        $this->assign('top_id',$top_id);
        $topcate=Db::name('Category')->where('id',$top_id)->find();
        $this->assign('topcate',$topcate);
        //二级分类
        $subcate=Db::name('Category')
            ->where('parent_id',$top_id)
            ->where('status',1)
            ->select();
        $this->assign('subcate',$subcate);
        if($type=='linkstore'){
            $lists=model('Article')
                ->alias('a')
                ->field(['a.id','a.title'])
                ->join('hly_category b','a.cate_id=b.id')
                ->where('b.type','linkstore')
                ->where('b.status',1)
                ->where('a.status',1)
                ->select();
            $this->assign('lists',$lists);
        }elseif($type=='service'){
            $lists=model('Article')
                ->alias('a')
                ->field(['a.id','a.title'])
                ->join('hly_category b','a.cate_id=b.id')
                ->where('b.type','service')
                ->where('b.status',1)
                ->where('a.status',1)
                ->select();
            $this->assign('lists',$lists);
        }

        $template='info_'.$type;
        return $this->fetch($template);
    }
}
