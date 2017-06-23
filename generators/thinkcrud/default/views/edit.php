<include file="Public:head"/>
<link href="./tpl/static/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="./tpl/static/bootstrap/css/autoadapt.css" rel="stylesheet" type="text/css" />

<div class="content">
    <div class="cLineB">
    	<h4><if condition="$scenario eq 'create'">添加<else />编辑</if><?= $className ?></h4>
    	<a href="javascript:history.go(-1);"  class="right btnGrayS vm" style="margin-top:-27px" >返回</a>
    </div>

    <div class="msgWrap">
	    <form class="form-horizontal mt_40"  method="post"  enctype="multipart/form-data" >
	    	<if condition="$error neq ''">
	        	<div id="from-errmsg" class="alert alert-warning">{shinho:$error }</div>
	    	</if>
<?php foreach ($tableSchema->columns as $col): ?>
<?php if($col->isPrimaryKey || in_array($col->name, ['listorder','status','create_time','update_time','token'])) continue; ?>
			<div class="form-group form-group">
			    <label class="col-sm-2 control-label" for="formGroupInputSmall">
<?php 
if(!$col->allowNull) echo "			      	<i class=\"text-danger\">*</i>\n";
echo "			      	{$col->comment}：\n";
?>
			    </label>
			    <div class="col-sm-6">
			      	<input class="form-control" type="text" value="{shinho:$<?= $className ?>.<?= $col->name ?>}" name="<?= "{$className}[{$col->name}]" ?>" placeholder="<?= $col->comment ?>">
			    </div>
			    <div class="col-sm-4">
			    	<p class="help-block-error text-warning"><?php if(!$col->allowNull) echo '必填项' ?></p>
			    </div>
			</div>

<?php endforeach; ?>
			<div class="form-group">
			    <div class="col-sm-offset-2 col-sm-10">
			    	<button type="submit" class="btn btn-default"><if condition="$scenario eq 'create'">保存<else />修改</if></button>
			    </div>
	  		</div>
	  	</form>
	</div>
</div>

<!--底部-->
<include file="Public:footer"/>
