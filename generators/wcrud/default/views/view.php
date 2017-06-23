<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\helpers\Url;
use common\widgets\listview\DetailView;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = $model-><?= $generator->getNameAttribute() ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-view">

    <div class="weui_cells_title"><?= "<?= " ?>$this->title ?></div>

    <?= "<?= " ?>DetailView::widget([
        'model' => $model,
        'options'=>['tag'=>'div','class'=>'weui_cells weui_cells_access'],
        'template'=>['\common\widgets\listview\DetailView', 'getWeixinDetail'],
        'attributes' => [
<?php
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        echo "            '" . $name . "',\n";
    }
} else {
    foreach ($generator->getTableSchema()->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
    }
}
?>
            // [
            //     'label'=>'商品名称',
            //     'value'=>$model->title,
            //     'url'=>Url::to(['index']),
            // ],
        ],
    ]) ?>

    <div class="weui_btn_area">
        <div class="btn-group btn-group-sm" role="group">
            <?= "<?= " ?>Html::a('编辑', ['update', <?= $urlParams ?>], ['class' => 'btn btn-info']) ?>
            <?= "<?= " ?>Html::a('返回列表', ['index'], ['class' => 'btn btn-default']) ?>
            <?= "<?= " ?>Html::a('删除', ['delete', <?= $urlParams ?>], [
                'class' => 'btn btn-warning',
                'data' => [
                    'confirm' => <?= $generator->generateString('你确认要删除码?') ?>,
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </div>

</div>
