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

namespace <?= $generator->ns ?>;

use Yii;

/**
 * This is the model class for table "<?= $generator->generateTableName($tableName) ?>".
 *
<?php foreach ($tableSchema->columns as $column): ?>
 * @property <?= "{$column->phpType} \${$column->name}\n" ?>
<?php endforeach; ?>
<?php if (!empty($relations)): ?>
 *
<?php foreach ($relations as $name => $relation): ?>
 * @property <?= $relation[1] . ($relation[2] ? '[]' : '') . ' $' . lcfirst($name) . "\n" ?>
<?php endforeach; ?>
<?php endif; ?>
 */
class <?= $className ?> extends <?= '\\' . ltrim($generator->baseClass, '\\') . "\n" ?>
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '<?= $generator->generateTableName($tableName) ?>';
    }
<?php if ($generator->db !== 'db'): ?>

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('<?= $generator->db ?>');
    }
<?php endif; ?>

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [<?= "\n            " . implode(",\n            ", $rules) . "\n        " ?>];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
<?php foreach ($labels as $name => $label): ?>
            <?= "'$name' => " . $generator->generateString($label) . ",\n" ?>
<?php endforeach; ?>
        ];
    }
<?php foreach ($relations as $name => $relation): ?>

    /**
     * @return \yii\db\ActiveQuery
     */
    public function get<?= $name ?>()
    {
        <?= $relation[0] . "\n" ?>
    }
<?php endforeach; ?>
<?php if ($queryClassName): ?>
<?php
    $queryClassFullName = ($generator->ns === $generator->queryNs) ? $queryClassName : '\\' . $generator->queryNs . '\\' . $queryClassName;
    echo "\n";
?>
    /**
     * @inheritdoc
     * @return <?= $queryClassFullName ?> the active query used by this AR class.
     */
    public static function find()
    {
        return new <?= $queryClassFullName ?>(get_called_class());
    }
<?php endif; ?>

    /**
     * beforeSave
     * @return [type] bool
     */
    public function beforeSave($insert)
    {
        if(!parent::beforeSave($insert))
            return false;

        //增加注册日期
        if($this->isNewRecord){
            <?php if(isset($tableSchema->columns['create_time']))  echo "\$this->create_time = time();\n"; ?>
            <?php if(isset($tableSchema->columns['update_time']))  echo "\$this->update_time = time();\n"; ?>            
<?php if(isset($tableSchema->columns['listorder'])): ?>
            //排序
            $next = static::find()->orderBy(['listorder'=>SORT_DESC])->one();
            $this->listorder = empty($next)? 1 : $next->listorder+1;
<?php endif; ?>
        }else{
            <?php if(isset($tableSchema->columns['update_time']))  echo '$this->update_time = time();'; ?> 
        }

        // 图片域名处理
        // $this->pic = Img::toMarke($this->pic);

        return true;
    }

    /**
     * 查看后的数据处理
     * @return {[type]} [description]
     */
    public function afterFind()
    {   
        // 图片域名处理
        // $this->pic = Img::toUrl($this->pic);
    }

    /**
     * [afterSave description]
     * @param  [type] $insert            [description]
     * @param  [type] $changedAttributes [description]
     * @return [type]                    [description]
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        //更新缓存
        //$this->updateCache();
    }

    /**
     * [afterSave description]
     * @return {[type]} [description]
     */
    public function afterDelete()
    {
        //更新缓存
        //$this->updateCache();
    }

    /**
     * 更新缓存
     * @return [type] [description]
     */
    public function updateCache(){
        // Cache::delete('cache_weixinapp_list');
        // Cache::delete('cache_weixinapp_item_'.$this->token);
    }
}
