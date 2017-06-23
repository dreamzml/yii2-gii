<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">

    <?= "<?php " ?>$form = ActiveForm::begin([
        'fieldConfig'=>['template'=>"<div class=\"weui_cell_hd\">{label}</div>\n<div class=\"weui_cell_bd weui_cell_primary\">\n{input}\n</div>\n{hint}\n{error}"],
        'options'=>['class'=>'weui_cells_form']
        ]); ?>

        <div class="weui_cells">
<?php foreach ($generator->getColumnNames() as $attribute) {
	if(in_array($attribute, ['create_time','update_time','token','status','listorder']))
		continue;

    if (in_array($attribute, $safeAttributes)) {
        echo "    		<?= \$form->field(\$model, '{$attribute}', [
	                'options'=>['class'=>'weui_cell'],
	                'inputOptions'=>['class'=>'weui_input', 'placeholder'=>\$model->getAttributeLabel('{$attribute}')],
	                'labelOptions'=>['class'=>'weui_label']
	            ])->textInput() 
			?>\n\n";
			
    }
} ?>
		</div>

	    <div class="weui_btn_area">
	        <?= "<?= " ?>Html::submitButton('保存', ['class' => 'weui_btn weui_btn_primary']) ?>
	    </div>

    <?= "<?php " ?>ActiveForm::end(); ?>

</div>
