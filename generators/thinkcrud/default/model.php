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

echo "<?php\n";
?>

class <?= $className ?>Model extends Model{

    /**
     * 表单数据验证
     * @type {[type]}
     */
    protected $_validate = array(
<?php 
foreach ($rules as $ruleStr)
{
    $ruleArr = eval("return {$ruleStr};");
    list($clumn, $ruletype) = $ruleArr;
    //var_dump($ruleArr);exit;
    switch ($ruletype) {
        case 'required':
            foreach ($clumn as $col) {
                $comment = $tableSchema->columns[$col]->comment;
                $comment = empty($comment)?$col:$comment;
                echo "            array('{$col}', 'require', '{$comment}不能为空', 1),\n";
            }
            break;
        case 'number':
        case 'integer':
            foreach ($clumn as $col) {
                if(in_array($col, ['listorder','status','create_time','update_time']))
                    continue;
                $comment = $tableSchema->columns[$col]->comment;
                $comment = empty($comment)?$col:$comment;
                echo "            array('{$col}', 'number', '{$comment}必需为整数', 1),\n";
            }
            break;
        case 'string':
            if(!isset($ruleArr['max']))
                break;

            $max = $ruleArr['max'];
            foreach ($clumn as $col) {
                $comment = $tableSchema->columns[$col]->comment;
                $comment = empty($comment)?$col:$comment;
                echo "            array('{$col}', '0,{$max}', '{$comment}格式不正确', 1, 'length'),\n";
            }
            break;
        default:
            # code...
            break;
    }
}
?>
    );

    /**
     * 自动完成，默认值
     * @type {[type]}
     */
    protected $_auto = array (
        // array('status','0'),  // 新增的时候把status字段设置为1
        // array('token','getToken',Model:: MODEL_BOTH,'callback'),
    );

    /**
     * 自动完成，初始化值函数
     * @return {[type]} [description]
     */
    // function getToken(){
    //     return $_SESSION['token'];
    // }
}

?>