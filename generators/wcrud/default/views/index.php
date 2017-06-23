<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

$columns = $generator->getColumnNames();

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use <?= $generator->indexWidgetType === 'grid' ? "yii\\grid\\GridView" : "common\\widgets\\listview\\ListView" ?>;

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$this->registerJsFile("/css/wechat/cell_listview.js", ['depends'=>['frontend\assets\AppAsset']]);
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index">


<?php if(!empty($generator->searchModelClass)): ?>
    <div class="weui_search_bar" id="search_bar">
        <?= "<?php " ?> $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
            'options' => ['class'=>'weui_search_outer'],
            'id' => 'search_bar',
        ]); ?>
            <div class="weui_search_inner">
                <i class="weui_icon_search"></i>
                <?= "<?= " ?> $form->field($searchModel, '<?= reset($columns) ?>',['template'=>'{input}'])->textInput(['type'=>'search','placeholder'=>'搜索','id'=>'search_input','class'=>'weui_search_input']) ?>
                <a href="javascript:" class="weui_icon_clear" id="search_clear"></a>
            </div>
            <label for="search_input" class="weui_search_text" id="search_text">
                <i class="weui_icon_search"></i>
                <span>搜索<?= "<?php " ?>if(!empty($searchModel-><?= reset($columns) ?>)) echo ": ".$searchModel-><?= reset($columns) ?> ?></span>
            </label>
        <?= "<?php " ?> ActiveForm::end(); ?>
        <a href="javascript:" class="weui_search_cancel" id="search_cancel">取消</a>
    </div>
<?php endif; ?>

<?php if ($generator->indexWidgetType === 'grid'): ?>
    <?= "<?= " ?>GridView::widget([
        'dataProvider' => $dataProvider,
        <?= !empty($generator->searchModelClass) ? "'filterModel' => \$searchModel,\n        'columns' => [\n" : "'columns' => [\n"; ?>
            ['class' => 'yii\grid\SerialColumn'],

<?php
$count = 0;
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        if (++$count < 6) {
            echo "            '" . $name . "',\n";
        } else {
            echo "            // '" . $name . "',\n";
        }
    }
} else {
    foreach ($tableSchema->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        if (++$count < 6) {
            echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        } else {
            echo "            // '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        }
    }
}
?>

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php else: ?>
    <?= "<?= " ?>ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['tag'=>false],
        'itemView' => '_view',
        'summaryOptions' => ['class' => 'col-md-3 pull-right text-right mh-15'],
        'itemsOptions' => ['tag'=>'div','class' => 'weui_cells weui_cells_access'],
        'layout' => "{items}\n{pager}",
        'bottomPagerSimple' => true,
        'pager' => ['class'=>'common\widgets\listview\ScrollPager'],
        'batch' => ['selectAll'=>false],
    ]) ?>
<?php endif; ?>

    <div class="weui_btn_area">
        <?= "<?= " ?>Html::a(<?= $generator->generateString('创建 ' . Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>, ['create'], ['class' => 'weui_btn weui_btn_default']) ?>
    </div>
</div>
