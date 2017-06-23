<?php
/**
 * This is the template for generating the ActiveQuery class.
 */

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\model\Generator */
/* @var $className string class name */
/* @var $modelClassName string related model class name */

//控制器访问ctl命名
$nameArr = explode('_', $controllerClass);
$app = array_shift($nameArr);
$alt = array_shift($nameArr);
$actionName = join('_', $nameArr);

//model访问命名
$modelNameArr = explode('_', $modelClass);
$modelapp = array_shift($modelNameArr);
$mdl = array_shift($modelNameArr);
$modelName = join('_', $modelNameArr);

//model实例对象驼峰命名
foreach ($modelNameArr as &$v) {
    $v = ucfirst(strtolower($v));
}
$modelNames = join('', $modelNameArr);
$modelNames = lcfirst($modelNames);

//视图目录
$cNameArr = explode('_', $controllerClass);
$appid = array_shift($cNameArr);
$ctl = array_shift($cNameArr);
$viewDir = join('/',$cNameArr);

//字段列表
$cols =join(',',array_keys($labels));

echo "<?php\n";
?>

/**
 * @Author: 16020028
 * @Date: 2016-05-17 20:10:58
 * @Last Modified by:   16020028
 * @Last Modified time: 2016-05-19 14:44:06
 */
class <?= $controllerClass ?> extends desktop_controller{

    var $workground = '<?= $controllerClass ?>';

    public function __construct($app){
        parent::__construct($app);
        header("cache-control: no-store, no-cache, must-revalidate");
    }

    /**
     * 列表页
     * @return {[type]} [description]
     */
    function index(){
        $this->finder('<?= $modelClass ?>',array(
                'title'=>app::get('<?= $app ?>')->_('<?= $className ?>'),
                //默认显示的字段
                'finder_cols' => 'column_control,<?= $cols ?>',
                //批量删除开启
                'use_buildin_recycle'=>true,
                //导出开启
                'use_buildin_export'=>true,
                //过滤器开启
                'use_buildin_filter'=>true,
                //新窗口打开详情开启
                'allow_detail_popup'=>true,
                //默认筛选条件
                'base_filter'=>array(),
                //自定义列
                'addon_columns' => array(
                    array(kernel::single('<?= $app ?>_finder_<?= $actionName ?>'),'column_control'),
                    //array(kernel::single('<?= $app ?>_finder_<?= $actionName ?>'),'column_goods'),
                ),
                //详情页面
                'detail_pages' => array(
                    'detail_basic'=>array(kernel::single('<?= $app ?>_finder_<?= $actionName ?>'),'detail_basic'),
                ),
                //主操作按钮
                'actions'=>array(
                    array(
                        'label' => app::get('<?= $app ?>')->_('add<?= $className ?>'),
                        'href' => 'index.php?app=<?= $app ?>&ctl=<?= $actionName ?>&act=add',
                        'target' => '_blank',
                    ),
                ),
            ));
    }

    /**
     * 添加
     */
    function add() {
        $this->pagedata['isNewRecord'] = 1;
        $this->_editor();
    }

    /**
     * 修改
     */
    function edit($id) {
        $model = $this->app->model('<?= $modelName ?>');
        $<?= $modelNames ?> = $model->dump($id);
        if(empty($<?= $modelNames ?>))
            $this->splash('fail','index.php?app=<?= $app ?>&ctl=<?= $actionName ?>',app::get('<?= $app ?>')->_('数据错误'));

        $this->pagedata['<?= $modelNames ?>'] = $<?= $modelNames ?>;
        $this->pagedata['isNewRecord'] = 0;
        $this->_editor();
    }

    /**
     * 添加修改，共用部分
     */
    function _editor(){
        header("Cache-Control:no-store");
        $this->singlepage('<?= $viewDir ?>/edit.html');
    }

    /**
     * 添加&修改(post)
     */
    function toAdd() {
        $this->begin('index.php?app=<?= $app ?>&ctl=<?= $actionName ?>');

        $isNewRecord = ($_POST["isNewRecord"]==1);
        $<?= $modelNames ?> = $this->_prepareData($_POST['<?= $modelNames ?>'], $isNewRecord);

        $model = $this->app->model('<?= $modelName ?>');

        $this->end($model->save($<?= $modelNames ?>),app::get('<?= $app ?>')->_('操作成功'));
    }

    /**
     * 保存前数据预处理
     * @param  {[type]} $aData [description]
     * @return {[type]}        [description]
     */
    function _prepareData($aData, $isNewRecord) {

        // if(isset($aData['addon']) && is_array($aData['addon']))
            // $aData['addon'] = serialize($aData['addon']);

        // if($isNewRecord)
            // $aData['time'] = time();

        return $aData;
    }

    /**
     * 列表页 tab标签栏分类显示数据
     * @return {[type]} [description]
     */
    function _views()
    {
        $sub_menu = array();
        $model = $this->app->model('<?= $modelName ?>');

        //已选中的商品
        // $filter = array('display' => 'true');
        // $count = $model->count($filter);
        // $sub_menu[] = array('label' => app::get('b2c')->_('已选中的商品'), 'optional' => true, 'filter' => $filter, 'addon' => $count, 'href' => 'index.php?app=<?= $app ?>&ctl=<?= $actionName ?>&act=index&view=0&view_from=dashboard');

        //未选中的
        // $filter = array('display' => 'false');
        // $count = $model->count($filter);
        // $sub_menu[] = array('label' => app::get('b2c')->_('未选中的商品'), 'optional' => true, 'filter' => $filter, 'addon' => $count, 'href' => 'index.php?app=<?= $app ?>&ctl=<?= $actionName ?>&act=index&view=1&view_from=dashboard');

        return $sub_menu;
    }
}
