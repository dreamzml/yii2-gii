<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$class = $generator->modelClass;
$pks = $class::primaryKey();
$pk = reset($pks);

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\helpers\Url;
use common\utility\Options;
use common\utility\Img;

/* @var $widget yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $key yii\widgets\ActiveForm */
/* @var $index yii\widgets\ActiveForm */

?>

<a class="weui_cell" href="<?= "<?= " ?>Url::to(['view', 'id' => $model->id]) ?>">
<?php
$count = 0;
foreach ($generator->getColumnNames() as $attribute) {
    if (++$count < 4) {
        $class = ($attribute==$pk)? "weui_cell_hd cloumn_pk" : "weui_cell_bd weui_cell_primary";
        echo "    <div class=\"{$class}\">\n";
        echo "          <?= \$model->".$attribute." ?>\n";
        echo "    </div>\n\n";
    } else {
        echo "    <?php // echo \$model->".$attribute." ?>\n\n";
    }
}
?>
    <div class="weui_cell_ft">详细</div>
</a>