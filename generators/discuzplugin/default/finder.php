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

echo "<?php\n";
?>

/**
 * finder
 * @Author: 16020028
 * @Date: 2016-05-17 20:10:58
 * @Last Modified by:   16020028
 * @Last Modified time: 2016-05-18 15:43:17
 */
class <?= $appid ?>_finder_<?= $actionName ?>

{
	/**
	 * 初始化
	 * @param  {[type]} $app [description]
	 * @return {[type]}      [description]
	 */
    public function __construct($app)
    {
        $this->app = $app;
    }

	var $column_control = '操作';
	var $column_control_width = '100';
    function column_control($row)
    {

        $edit_html = '<a href="index.php?app=<?= $appid ?>&ctl=<?= $actionName ?>&act=edit&p[0]=' . $row['<?= $pk ?>'] . '" target="_blank">' . app::get('b2c')->_('编辑') . '</a>' ;
		//验证权限
		$permObj = kernel::single('desktop_controller');
        if (!$permObj->has_permission('<?= $modelName ?>_edit')) {
            $edit_html = "";
        }
        return $edit_html;
    }

	/////////////////////////////  自定义列  ///////////////////////////////
    // var $column_goods = "购物车商品";
    // var $column_goods_width = '200';
    // function column_goods($row)
    // {
    //     $objectData = unserialize($row['params']);
    //     $product = $this->app->model('products')->getRow('name'  , array('product_id' => $objectData['product_id']));
    //     return $product['name'];
    // }

	var $detail_basic = '查看';
	var $detail_basic_width = '200';
    function detail_basic($id)
    {
        $<?= $modelNames ?> = $this->app->model('<?= $modelName ?>')->dump($id);

		$render = $this->app->render();
        $render->pagedata['<?= $modelNames ?>'] = $<?= $modelNames ?>;
        return $render->fetch('<?= $viewDir ?>/view.html');
    }
}