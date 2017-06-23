<?php 

//控制器访问ctl命名
$nameArr = explode('_', $controllerClass);
$app = array_shift($nameArr);
$alt = array_shift($nameArr);
$actionName = join('_', $nameArr);

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
    
<form name="coupon_form" id="coupon_form"  method='post' action='index.php?app=<?= $app ?>&ctl=<?= $actionName ?>&act=toAdd'>
    <h3 id="coupon_title"><{t}> <?= $className ?> <{/t}></h3>
    

    <div class="division">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
		<{input type='hidden' value=$isNewRecord name='isNewRecord'}>
<?php foreach ($tableSchema->columns as $col): ?>
<?php 
	if(($col->isPrimaryKey && $pkCount==1) || in_array($col->name, ['listorder','status','create_time','update_time','token'])){
		echo "<{input type='hidden' value=\${$modelNames}.{$col->name} name='{$modelNames}[{$col->name}]'}>\n";
		continue;
	}
?>
        <th><?php if(!$col->allowNull) echo '<em class="red">*</em>';?><{t}><?= empty($col->comment)?$col->name: $col->comment  ?>：<{/t}></th>
        	<td><{input type='text' value=$<?= $modelNames ?>.<?= $col->name ?> name='<?= $modelNames ?>[<?= $col->name ?>]' <?php if(!$col->allowNull) echo "vtype='required'";?>}></td>
      	</tr>

<?php endforeach; ?>
    </table>
    </div>

    <div class="table-action">
    	<{assign var=___d value=$___b2c='确定退出?'|t:'b2c'}>
        <{button class="btn-primary" type="button"  label=$___b2c="保存并关闭"|t:'b2c' id="btn_submit"}>
        <{button class="btn-secondary" type="button"  label=$___b2c="取消"|t:'b2c' id="btn_cancel" onclick=""}>
    </div>
</form>
</div>


<script>
(function(){
    var page = {
    	//页面初始化
        init:function(){
            var _this = this;

            //绑定页面事件
            _this.bindEven();
        },
        //绑定事件
        bindEven: function(){
        	var _this = this;

        	//提交按钮绑定事件
		    $('btn_submit').addEvent('click',function(e){
		        if(_this.validate(this.getParent('form')))
		        	e.stop();
		    });

		    //关闭事件
		    $('btn_cancel').addEvent('click',function(e){
		        if(confirm('<{$___d}>'))
		        	window.close()
		    });
        },
        //表单表交验证
        validate:function(obj){
            var _this = this;

            if(!obj)
            	return true;

            //通用表单验证
            var div_els = obj.getElements('[vtype]')
            var _return = div_els.every(function(el){
                var vtype = el.get('vtype');
                if(!$chk(vtype))return true;
                /*if(!el.isDisplay()&&(el.getAttribute('type')!='hidden'))return true;*/
                if((el.getAttribute('type')=='hidden')) return true; /* 跳过隐藏项 */
                var valiteArr  = vtype.split('&&');
                if(el.get('required')) valiteArr = ['required'].combine(valiteArr.clean());

                return valiteArr.every(function(key){
                            if(!validatorMap[key])return true;
                            var _caution = el.getNext();
                            var cautionInnerHTML = el.get('caution')|| validatorMap[key][0];

                            if(validatorMap[key][1](el,el.getValue())){
                                    if(_caution&&_caution.hasClass('error')){_caution.remove();};
                                    return true;
                            }

                            if(!_caution||!_caution.hasClass('caution')){
                                 new Element('span',{'class':'error caution notice-inline','html':cautionInnerHTML}).injectAfter(el);
                                 el.removeEvents('blur').addEvent('blur',function(){
                                                                         if(validate(el)){
                                                                               if(_caution&&_caution.hasClass('error')){_caution.remove()};
                                                                               el.removeEvent('blur',arguments.callee);
                                                                         }
                                });
                            }else if(_caution&&_caution.hasClass('caution')&&_caution.get('html')!=cautionInnerHTML){
                                _caution.set('html',cautionInnerHTML);
                            }
                            return false;
                     });
            });

            if(_return){
            	//自定义表单验证默认不开启，开启后需根据业务调整以下方法
                //_return = _this.specialValidate(obj);
            }

            //验证通过表单提交
            if(_return)
            	_this.formSubmit();
        },
        //自定义验证，例，默认不开启，开启后需根据业务调整以下方法
        specialValidate:function(){
            var _this = this;
            //列验证开始时间和结束时间
            var from_time = $$('input[name=from_time]')[0].get('value')+ " " +$$('select[name="_DTIME_[H][from_time]"]')[0].get('value') + ":" +$$('select[name="_DTIME_[M][from_time]"]')[0].get('value');
            var to_time = $$('input[name=to_time]')[0].get('value')+ " " +$$('select[name="_DTIME_[H][to_time]"]')[0].get('value') + ":" +$$('select[name="_DTIME_[M][to_time]"]')[0].get('value');
            if(Date.parse(from_time.replace(/-/gi,"/")) > Date.parse(to_time.replace(/-/gi,"/"))) {
                MessageBox.error('<{t}>开始时间不能大于结束时间<{/t}>');
                return false;
            }
            return _this.validateMemberLv();
        },
        //自定义验证，例，默认不开启，开启后需根据业务调整以下方法
        validateMemberLv:function(){
            var _this = this;

            var flag = false;
            $ES('input[type=checkbox]', '#mLev').each(function(item){
                if(item.checked) {
                    flag = true;
                }
            });
            if(!flag) {
                $('mleverror').set('html', '<div class="x-vali-error" name="validationMsgBox"><{t}>必须选择一项<{/t}></div>');
                //MessageBox.error('<{t}>必须选择一项<{/t}>');
            }else{
                $('mleverror').set('html', '');
            }
            return flag;
        },
        //表单提交
        formSubmit:function(){
        	var _this = this;

        	var _form= $('btn_submit').getParent('form');

        	var target={
                    onComplete:function(rs){
                        if(rs&&!!JSON.decode(rs).success){
                            if(window.opener.finderGroup&&window.opener.finderGroup['<{$env.get.finder_id}>']){
                                window.opener.finderGroup['<{$env.get.finder_id}>'].refresh();
                            }
                            window.close();
                        }
                    }
                };
            _form.store('target',target);

        	_form.fireEvent('submit',new Event(event));
        }
    };
    page.init();
})();
</script>