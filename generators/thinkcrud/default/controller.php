<?php
/**
 * This is the template for generating the ActiveQuery class.
 */

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\model\Generator */
/* @var $className string class name */
/* @var $modelClassName string related model class name */

$modelFullClassName = $className;
if ($generator->ns !== $generator->queryNs) {
    $modelFullClassName = '\\' . $generator->ns . '\\' . $modelFullClassName;
}

echo "<?php\n";
?>

class <?= $controllerClass ?>Action extends <?= $moduleName ?>Action {

    /**
     * 首页，列表页
     */
    public function index() {
        //模型
        $model = D('<?= $className ?>');
        $where = array();

        //筛选条件
        if($params = $_POST['<?= $className ?>']){
            $where = array_merge($where,$this->_handleSearch($params));
            $this->assign('<?= $className ?>',$params);
        }

        //分页
        $count=$model->where($where)->count();
        $page=new Page($count,25);
        $this->assign('count',$count);
        $this->assign('page',$page->show());

        //列表数据
        $list = $model->where($where)
                    ->order('<?= isset($tableSchema->columns['listorder'])? "listorder asc" : "$pk desc" ?>')
                    ->limit($page->firstRow.','.$page->listRows)
                    ->select();
        $this->assign('list',$list);

        //当前页面地址
        $localurl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $this->assign('localurl',$localurl);

        $this->display();
    }

    /**
     * 增加
     */
    public function add() {
        //接收数据提交
        if(IS_POST){
            $data = $_POST['<?= $className ?>'];
            $model = D('<?= $className ?>');
<?php if(isset($tableSchema->columns['listorder'])): ?>

            //排序
            $lastListorder = M('<?= $className ?>')
                    ->order('listorder desc')
                    ->field('listorder')
                    ->find();
            $data['listorder'] = $lastListorder['listorder']+1;
<?php endif; ?>
<?php if(isset($tableSchema->columns['create_time'])): ?>
            $data['create_time'] = time();//创建时间
<?php endif; ?>
<?php if(isset($tableSchema->columns['update_time'])): ?>
            $data['update_time'] = time();//编辑时间
<?php endif; ?>
<?php if(isset($tableSchema->columns['token'])): ?>
            $data['token'] = $this->token;//微信公众号token
<?php endif; ?>

            //验证通过
            if($model->create($data)){
                $result = $model->add();
                $this->success('添加成功！', U('<?= $controllerClass ?>/index', array('token' => $this->token)));
                return;
            }
            $this->assign('error',$model->getError());
            $this->assign('<?= $className ?>',$data);
        }else{
            //默认值
            $default = array();
            $this->assign('<?= $className ?>',$default);
        }

        $this->assign('scenario','create');
        $this->display('edit');
    }

    /**
     * 编辑页，修改
     */
    public function edit() {
        $id=$_GET['id'];
        if(empty($id)){
            return $this->error('页面不存在！', U('<?= $controllerClass ?>/index', array('token' => $this->token)));
        }

        $where['<?= $pk ?>']=$id;
        $row = M('<?= $className ?>')->where($where)->find();
        if(empty($row))
            return $this->_jsonOutput(1,'页面不存在！');

        //接收数据提交
        if(IS_POST){
            $data = $_POST['<?= $className ?>'];
            $data = array_merge($row, $data);
<?php if(isset($tableSchema->columns['update_time'])): ?>

            //创建时间
            $data['update_time'] = time();
<?php endif; ?>

            //模型
            $model = D('<?= $className ?>');

            //验证通过
            if($model->create($data)){
                $result = $model->save($data);
                $this->success('修改成功！', U('<?= $controllerClass ?>/index', array('token' => $this->token)));
                return;
            }
            $this->assign('error',$model->getError());
            $this->assign('<?= $className ?>',$data);
        }else{
            $this->assign('<?= $className ?>',$row);
        }

        $this->assign('scenario','update');
        $this->display('edit');
    }


    /**
     * 详情页
     */
    public function view() {
        $id=$_GET['id'];
        if(empty($id)){
            return $this->error('页面不存在！', U('<?= $controllerClass ?>/index', array('token' => $this->token)));
        }

        $where['<?= $pk ?>']=$id;
        $row = M('<?= $className ?>')->where($where)->find();
        if(empty($row))
            return $this->_jsonOutput(1,'页面不存在！');

        $this->assign('<?= $className ?>',$row);
        $this->display();
    }

    /**
     * 删除
     */
    public function del() {
        $id=$_GET['id'];
        if(empty($id)){
            return $this->error('页面不存在！', U('<?= $controllerClass ?>/index', array('token' => $this->token)));
        }

        $where['<?= $pk ?>']=$id;
        $result=M('<?= $className ?>')->where($where)->delete();
        if (false !== $result){
            $this->success('删除成功！', U('<?= $controllerClass ?>/index', array('token' => $this->token)));
        }else{
            $this->error('删除失败！', U('<?= $controllerClass ?>/index', array('token' => $this->token)));
        }
    }
<?php if(isset($tableSchema->columns['listorder']) || isset($tableSchema->columns['status'])): ?>
    /**
     * ajax切换状态，排序，启用停用
     * @return {[type]} [description]
     */
    public function ajaxEdit(){
        $id=$_GET['id'];
        $operate = $_GET['operate'];
        if(empty($id))
            return $this->_jsonOutput(1,'页面不存在！');

        $where['<?= $pk ?>']=$id;
        $data=M('<?= $className ?>')->where($where)->find();
        if(empty($data))
            return $this->_jsonOutput(1,'页面不存在！');

        switch ($operate) {
<?php if(isset($tableSchema->columns['listorder'])): ?>
            case 'listup':
                # 排序上升
                $prex = M('<?= $className ?>')
                            ->where(array('listorder'=>array('LT',$data['listorder'])))
                            ->order('listorder desc')
                            ->field('<?= $pk ?>, listorder')
                            ->find();
                //无最前
                if(empty($prex)){
                    return $this->_jsonOutput(1,'已排最前！');
                }
                $res = M('<?= $className ?>')->where(array('<?= $pk ?>'=>$data['<?= $pk ?>']))
                                        ->save(array('listorder'=>$prex['listorder']));
                if(false === $res)
                    break;
                $res = M('<?= $className ?>')->where(array('<?= $pk ?>'=>$prex['<?= $pk ?>']))
                                        ->save(array('listorder'=>$data['listorder']));
                break;
            case 'listdown':
                # 排序下降
                $next = M('<?= $className ?>')
                            ->where(array('listorder'=>array('GT',$data['listorder'])))
                            ->order('listorder asc')
                            ->field('<?= $pk ?>, listorder')
                            ->find();
                //已是最后
                if(empty($next)){
                    return $this->_jsonOutput(1,'已是最后！');
                }
                $res = M('<?= $className ?>')->where(array('<?= $pk ?>'=>$data['<?= $pk ?>']))
                                        ->save(array('listorder'=>$next['listorder']));
                if(false === $res)
                    break;
                $res = M('<?= $className ?>')->where(array('<?= $pk ?>'=>$next['<?= $pk ?>']))
                                        ->save(array('listorder'=>$data['listorder']));
                break;
<?php endif; ?>
<?php if(isset($tableSchema->columns['status'])): ?>
            case 'togglestatus':
                 # 切换启动信用
                 $status = ($data['status']==1)? 0 : 1 ;
                 $res = M('<?= $className ?>')->where(array('<?= $pk ?>'=>$data['<?= $pk ?>']))
                        ->save(array('status'=>$status));

                 break;
<?php endif; ?>
            default:
                 return $this->_jsonOutput(1,'操作不存在！');
                 break;
         }

        if(false !== $res){
            return $this->_jsonOutput('ok','操作成功！');
        }else{
            return $this->_jsonOutput(1,'操作失败！');
        }
    }

    protected function _jsonOutput($code, $msg="操作成功")
    {
        $data = array('code'=>$code,'msg'=>$msg);
        echo json_encode($data);
    }
<?php endif; ?>

    /**
     * 处理检索条件
     * @param  {[type]} $data 搜索条件
     * @return {[type]}       db where条件
     */
    protected function _handleSearch($data){
          $where = array();
<?php
    $i=0;
    foreach ($tableSchema->columns as $col){
        echo "          if((\${$col->name} = trim(\$data['{$col->name}'])) !== \"\")\n";

        $where = ($col->type=='string')? "array('LIKE',\"%{\${$col->name}}%\")" : "\${$col->name}";

        echo "              \$where['{$col->name}'] = $where;\n\n";
    }
?>
        return $where;
    }
}