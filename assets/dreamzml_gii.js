(function ($) {
    return {
        init: function () {
            // thinkcrud 生成模块名称
            $('#ecstorecrud-generator #generator-tablename').on('blur', function () {
                var tableName = $(this).val();

                var modelClass = '';

                var tableArr = tableName.split('_');
                var prefix = tableArr.shift();
                var app = tableArr.shift();
                var tableStr = tableArr.join('_');

                var modelName = app+'_'+'mdl'+'_'+tableStr;

                console.log('tableArr', modelName);

                $('#generator-modelclass').val(modelName);

                if($('#generator-modulename').val().length > 0){
                    var modeule = $('#generator-modulename').val();
                    var controllerName = app+'_'+'ctl'+'_'+modeule+'_'+tableStr;
                    $('#generator-controllerclass').val(controllerName).blur();
                }

            });
            // ecstorecrud 生成控制器名称
            $('#ecstorecrud-generator #generator-modulename').on('blur', function () {
                var modeule = $(this).val();

                var tableArr = $('#generator-tablename').val().split('_');
                var prefix = tableArr.shift();
                var app = tableArr.shift();
                var tableStr = tableArr.join('_');
                var controllerName = app+'_'+'ctl'+'_'+modeule+'_'+tableStr;
                $('#generator-controllerclass').val(controllerName).blur();
            });
        }
    };

})(jQuery);