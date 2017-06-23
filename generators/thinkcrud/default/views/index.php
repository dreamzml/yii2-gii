<include file="Public:head"/>
<link href="./tpl/static/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="./tpl/static/bootstrap/css/autoadapt.css" rel="stylesheet" type="text/css" />
<script src="./tpl/static/bootstrap/js/thinkcurd.js" type="text/javascript"></script>

<div class="content">
    <div class="cLineB">
        <h4><?= $className ?>管理 共({shinho:$count}) 条</h4>
        <div class="clr"></div>
    </div>
    <div class="pageNavigator left">
  		<a href='{shinho::U("<?= $controllerClass ?>/add")}' title='新增<?= $className ?>' class='btnGrayS vm bigbtn'><img width="16" class="vm" src="./tpl/User/default/common/images/product/add.png">新增<?= $className ?></a>
    	当前链接地址：{shinho:$localurl}
    </div>
    <div class="cLine"><div class="clr"></div></div>
    <div class="msgWrap">
            <form class="form-inline" id="search-form"  method="post">
<?php
	$i=0;
	foreach ($tableSchema->columns as $col){
		$i++;
		if($i>8) continue;
		echo "				<div class=\"form-group\">\n";
		echo "                	<input type=\"text\" class=\"form-control\" value=\"{shinho:\${$className}.{$col->name}}\" name=\"{$className}[{$col->name}]\" placeholder=\"{$col->comment}\">\n";
		echo "				</div>\n";
	}
?>
              	<button type="submit" class="btn btn-default">搜索</button>
            </form>

            <table class="ListProduct" border="0" cellspacing="0" cellpadding="0" width="100%">
                <thead>
                    <tr>
<?php
	$i=0;
	foreach ($tableSchema->columns as $col){
		$i++;

		$colum = "<th>{$col->comment}</th>";
		if($i>8){
			echo "                        <!-- {$colum} -->\n";
		}else{
			echo "                        {$colum}\n";
		}
	}
?>
                        <th class="norightborder">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <tr></tr>
                <volist id="list" name="list" >
                    <tr>
<?php
	$i=0;
	foreach ($tableSchema->columns as $col){
		$i++;

		switch ($col->name) {
			case 'listorder':
				$linkup = '<a href="{shinho::U(\''.$controllerClass.'/ajaxEdit\',array(\'id\'=>$list[\''.$pk.'\'],\'operate\'=>\'listup\'))}" class="list-ajaxoperate-listup"><i class="glyphicon glyphicon-arrow-up text-success"></i></a>';
				$linkdown = '<a href="{shinho::U(\''.$controllerClass.'/ajaxEdit\',array(\'id\'=>$list[\''.$pk.'\'],\'operate\'=>\'listdown\'))}" class="list-ajaxoperate-listdown"><i class="glyphicon glyphicon-arrow-down text-success"></i></a>';
				$colum = "<td>\n                        	{$linkup}\n                        	{$linkdown}\n                        </td>";
				break;
			case 'status':
				$colum = "<td><a href=\"{shinho::U('{$controllerClass}/ajaxEdit',array('id'=>\$list['{$pk}'],'operate'=>'togglestatus'))}\" class=\"list-ajaxoperate-togglestatus <if condition=\"\$list['{$col->name}'] neq '1' \">text-danger</if>\"><if condition=\"\$list['{$col->name}'] eq '1' \">启用<else />停用</if></a></td>";
				break;
			case 'create_time':
			case 'update_time':
				$colum = "<td>{shinho:\$list.{$col->name}|date=\"Y-m-d  H:i:s\",###}</td>";
				break;
			default:
				$colum = "<td>{shinho:\$list.{$col->name}}</td>";
				break;
		}
		if($i>8){
			echo "                        <!-- {$colum} -->\n";
		}else{
			echo "                        {$colum}\n";
		}
	}
?>
                        <td class="norightborder">
	                        <a class="text-primary" href="{shinho::U('<?= $controllerClass ?>/edit',array('id'=>$list['<?= $pk ?>']))}" title="编辑">编辑</a> |
	                        <a class="text-warning" href="{shinho::U('<?= $controllerClass ?>/view',array('id'=>$list['<?= $pk ?>']))}" title="查看">查看</a> |
	                        <a class="text-danger" href="javascript:drop_confirm('您确定要删除吗?删除会把投票结果也一起删除！', '{shinho::U('<?= $controllerClass ?>/del',array('id'=>$list['<?= $pk ?>']))}');">删除</a> <br/>
                        </td>
                    </tr>
                </volist>
                </tbody>
            </table>
    </div>
    <div class="cLine">
        <div class="pageNavigator right">
            <div class="pages">{shinho:$page}</div>
        </div>
        <div class="clr"></div>
    </div>
</div>
<include file="Public:footer"/>