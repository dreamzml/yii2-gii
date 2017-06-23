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
 * @Date:   2016-05-18 13:26:14
 * @Last Modified by:   16020028
 * @Last Modified time: 2016-05-19 14:25:43
 */
class <?= $app ?>_apiv_apis_response_<?= $modelName ?>
{

    /**
     * 列表
     */
    public function get_list($params,&$service){

        //筛选条件
        $filter = array();
        if(isset($params['filter']))
            $filter = array_merge($filter, (array)$params['filter']);

        //分页
        $page_no = $params['page_no'] >= 1 ? $params['page_no'] : 1;
        $page_size = $params['page_num'] ? $params['page_num'] : 20;
        $offset = ($page_no - 1) * $page_size;
        $limit = $page_size;

        //model
        $model = app::get('b2c')->model('<?= $modelName ?>');

        //总页数
        $total = $model->count($filter);
        $pages = ceil($total/$page_size);

        //排序
        $order = '<?= $pk ?> DESC';
        if(isset($params['order']) && !empty($params['order']))
            $order = $params['order'];

        $items = $model->getList('*',$filter, $offset, $limit, $order);

        $data['page_no'] = (int)$page_no;
        $data['page_size'] = $page_size;
        $data['page_total'] = $pages;
        $data['record_total'] = $total;
        $data['items'] = $items;

        return $data;
    }

    /**
     * 创建
     */
    public function create($params, &$service){

        //接收数据
        $<?= $modelNames ?> = $this->_prepareData($params['<?= $modelName ?>'], true);

        //model
        $model = app::get('b2c')->model('<?= $modelName ?>');

        //验证
        if(empty($<?= $modelNames ?>))
            return $service->send_user_error('8002','提交数据为空');

        $res = $model->insert($<?= $modelNames ?>);
        if($res===false)
            return $service->send_user_error('8001','保存失败');

        $data['item'] = $<?= $modelNames ?>;
        return $data;
    }

    /**
     * 保存前数据预处理
     * @param  {[type]} $aData 待处理的数据
     * @return {[type]}        处理后的数据
     */
    function _prepareData($aData, $isNewRecord) {

        // if(isset($aData['addon']) && is_array($aData['addon']))
            // $aData['addon'] = serialize($aData['addon']);

        // if($isNewRecord)
            // $aData['time'] = time();

        return $aData;
    }

    /**
     * 详情
     */
    public function get_item($params, &$service){

        $id = isset($params['<?= $pk ?>'])? $params['<?= $pk ?>']: '';

        //主键为空
        if(empty($id))
            return $service->send_user_error('8002','point_id不能为空');

        //model
        $model = app::get('b2c')->model('<?= $modelName ?>');

        $item = $model->dump($id);
        $data['item'] = $item;

        return $data;
    }

}
