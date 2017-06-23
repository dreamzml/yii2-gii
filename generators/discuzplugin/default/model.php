<?php
/**
 * This is the template for generating the model class of a specified table.
 */

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\model\Generator */
/* @var $tableName string full table name */
/* @var $className string class name */
/* @var $queryClassName string query class name */
/* @var $tableSchema yii\db\TableSchema */
/* @var $labels string[] list of attribute labels (name => label) */
/* @var $rules string[] list of validation rules */
/* @var $relations array list of relations (name => relation declaration) */
//model访问命名
$modelNameArr = explode('_', $modelClass);
$modelapp = array_shift($modelNameArr);
$mdl = array_shift($modelNameArr);
$modelName = join('_', $modelNameArr);

echo "<?php\n";
?>

/**
 * @Author: 16020028
 * @Date: 2016-05-17 20:10:58
 * @Last Modified by:   16020028
 * @Last Modified time: 2016-05-19 11:57:16
 */
class <?= $modelClass ?> extends dbeav_model{
    /**
     * 表示id的列
     */
    var $idColumn = '<?= $pk ?>';
    /**
     * 默认排序
     */
    var $defaultOrder = <?= isset($tableSchema->columns['time'])? "array('time','desc')" : "array('$pk','desc')" ?>;

    /**
     * custom filter 自定义过滤器
     * @param  [type] $filter     过滤条件
     * @param  [type] $tableAlias 表别名
     * @param  [type] $baseWhere  基础条件
     * @return [type]             查询where
     */
    function _filter($filter,$tableAlias=null,$baseWhere=null){
        $where=array(1);
<?php 
foreach ($rules as $ruleStr)
{
    $ruleArr = eval("return {$ruleStr};");
    list($clumn, $ruletype) = $ruleArr;
    //var_dump($ruleArr);exit;
    switch ($ruletype) {
        case 'required':
        case 'number':
        case 'integer':
            break;
        case 'string':
            foreach ($clumn as $col) {
                echo "        if (\$filter['{$col}'] && is_string(\$filter['{$col}'])) {
            \$where[] = '`{$col}` like\'%'.\$filter['{$col}'].'%\'';
            unset(\$filter['{$col}']);
        }\n";
            }
            break;
        default:
            # code...
            break;
    }
}
?>
        return parent::_filter($filter).' and '.implode($where,' and ');
    }

    /**
     * 显示格式转换
     * @param  [type] $time [description]
     * @return [type]       [description]
     */
    // public function modifier_time($time){
    //     return date('Y-m-d H:i:s', $time);
    // }

}


