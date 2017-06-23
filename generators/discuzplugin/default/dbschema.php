<?php
/**
 * This is the template for generating the ActiveQuery class.
 */

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\model\Generator */
/* @var $className string class name */
/* @var $modelClassName string related model class name */


//查看字符串型
$ruleString = $ruleNumber = [];
foreach ($rules as $rule) {
	list($cols, $type) = eval("return {$rule};");
	if($type=='string'){
		foreach ((array)$cols as $c) {
			$ruleString[] = $c;
		}
	}
	if($type=='number' || $type=='integer'){
		foreach ((array)$cols as $c) {
			$ruleNumber[] = $c;
		}
	}
}

$tableSchema = (array)$tableSchema;

foreach ($tableSchema['columns'] as &$value) {
	$value = (array)$value;

	//默认备注
	if(empty($value['comment']))
		$value['comment'] = $value['name'];

	$value['label'] = mb_substr($value['comment'], 0, 12);
	$value['in_list'] = true;
	$value['default_in_list'] = true;
	$value['editable'] = true;
	$value['filterdefault'] = true;
	$value['pkey'] = $value['isPrimaryKey'];
	if(in_array($value['name'], $ruleString)){
		$value['filtertype'] =  'custom';
	}elseif(in_array($value['name'], $ruleNumber)){
		$value['filtertype'] =  'number';
	}

	//自增字段
	if($value['autoIncrement'])
		$value['extra'] = 'auto_increment';
}

echo "<?php\n";
?>

/**
 * @Author: 16020028
 * @Date: 2016-05-17 20:10:58
 * @Last Modified by:   16020028
 * @Last Modified time: 2016-05-19 11:55:19
 *
 * @columns var $in_list   是否在desktop 列表中显示
 * @columns var $default_in_list 是否默认在desktop 列表中显示
 * @columns var $editable 
 * @columns var $filterdefault
 * @columns var $filtertype
 */

$db['<?= $tables_name ?>'] = <?php var_export(json_decode(json_encode($tableSchema),true)); ?>;

