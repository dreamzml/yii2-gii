<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use yii\i18n\Formatter;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\mcrud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();
$class = $generator->modelClass;
$pks = $class::primaryKey();
$pk = reset($pks);
echo "<?php\n";
?>

use yii\helpers\Html;
use common\utility\Options;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
?>


<?php
$count = 0;
foreach ($generator->getColumnNames() as $attribute) {
    if (++$count == 6) {
        echo "\n\n    <!-- \n";
    }
	echo "    <td>\n";

	if($count == 1){
		echo "        <?= Html::checkBox('id[]', 0, ['class'=>'select-item', 'value'=>\$model->{$pk}]) ?>\n";
	}

    switch ($attribute) {
    	case 'status':
    		echo "        <?= Html::a((\$model->status==Options::STATUS_ACTIVE)?Options::getStatus(Options::STATUS_ACTIVE):Options::getStatus(Options::STATUS_DISABLE), ['update', 'id'=>\$model->{$pk}, 'toggle'=>'status'], ['class'=>'toggle-link']) ?>\n";
    		break;
    	case 'inputtime':
    	case 'updatetime':
        case 'create_time':
        case 'update_time':
    		echo "        <?= Yii::\$app->getFormatter()->format(\$model->{$attribute}, 'datetime'); ?>\n";
    		break;
        case 'listorder':
            echo "        <?php echo Html::a('<i class=\"fa fa-arrow-up text-success\"></i>',['listorder', 'id'=>\$model->{$pk}, 'type'=>'up']) ?>\n";
            echo "        <?php echo Html::a('<i class=\"fa fa-arrow-down text-info\"></i>',['listorder', 'id'=>\$model->{$pk}, 'type'=>'down']) ?>\n";
            # code...
            break;
    	default:
    		echo "        <?= \$model->" . $attribute . " ?>\n";
    		break;
    }


    
    echo "    </td>\n\n";
    
}

if($count >= 6){
	echo "    -->\n\n";
}
?>

    <td class="handle-td">
    	<?= "<?= Html::a('<span class=\"glyphicon glyphicon-eye-open\"></span>查看', ['view', {$urlParams}], ['title'=>'View', 'class'=>'text-muted', 'data-pjax'=>'0']) ?>\n" ?>
    	<?= "<?= Html::a('<span class=\"glyphicon glyphicon-pencil\"></span>编辑', ['update', {$urlParams}], ['title'=>'Update', 'class'=>'text-success', 'data-pjax'=>'0']) ?>\n" ?>
    	<?= "<?= Html::a('<span class=\"glyphicon glyphicon-trash\"></span>删除', ['delete', {$urlParams}], ['title'=>'Delete', 'class'=>'text-danger', 'data-pjax'=>'0', 'data-method'=>'post', 'data-confirm'=>'Are you sure you want to delete this item?']) ?>\n" ?>
    </td>