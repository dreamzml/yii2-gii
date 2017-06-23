<?php 

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

$pkCount = count($tableSchema->primaryKey);


?>

<div class="tableform">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="gridlist">
		<thead>
			<tr>
<?php foreach ($tableSchema->columns as $col): ?>
			  	<th><{t}><?= empty($col->comment)?$col->name: $col->comment  ?><{/t}></th>
<?php endforeach; ?>
			</tr>
		</thead>
		<tbody>
			<tr>
<?php foreach ($tableSchema->columns as $col): ?>
			  	<td <?php if($col==end($tableSchema->columns)) echo 'class="textleft"' ?> ><{$<?= $modelNames ?>.<?= $col->name ?>}></td>
<?php endforeach; ?>
			</tr>
		</tbody>
	</table>
</div>

