<include file="Public:head"/>
<link href="./tpl/static/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="./tpl/static/bootstrap/css/autoadapt.css" rel="stylesheet" type="text/css" />

<div class="content">   
    <div class="cLineB">
        <h4><?= $className ?>详情</h4>
        <a href="javascript:history.go(-1);"  class="right btnGrayS vm" style="margin-top:-27px" >返回</a>
        <div class="clr"></div>
    </div>
	<div class="msgWrap bgfc view-list" style="magin-top:120px">
	    <table class="userinfoArea" style=" margin:0;" border="0" cellspacing="0" cellpadding="0" width="100%"><tbody>
<?php foreach ($tableSchema->columns as $col): ?>
	        <tr>
	            <th><?= $col->comment ?>：</th>
	            <td>
<?php
	switch ($col->name) {
		case 'status':
			$colum = "<if condition=\"\${$className}['{$col->name}'] eq '1' \">启用<else />停用</if>";
			break;
		case 'create_time':
		case 'update_time':
			$colum = "{shinho:\${$className}.{$col->name}|date=\"Y-m-d  H:i:s\",###}";
			break;
		default:
			$colum = "{shinho:\${$className}.{$col->name}}";
			break;
	}
	echo "	            	 $colum\n"
?>
	            </td>
	        </tr>
<?php endforeach; ?>
	        <tr>
	            <th>&nbsp;</th>
	            <td>
	              <a href="javascript:history.go(-1);"  class="btnGreen sub" >返回</a>
	            </td>
	        </tr>
        </table>
    </div> 

</div>
<include file="Public:footer"/>