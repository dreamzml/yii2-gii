jQuery(function($){
  var dm_gii = {
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

            // model generator: translate table name to model class
            $('#dmodel-generator #generator-tablename').on('blur', function () {
                var tableName = $(this).val();
                var tablePrefix = $(this).attr('table_prefix') || '';
                if (tablePrefix.length) {
                    // if starts with prefix
                    if (tableName.slice(0, tablePrefix.length) === tablePrefix) {
                        // remove prefix
                        tableName = tableName.slice(tablePrefix.length);
                    }
                }
                if ($('#generator-modelclass').val() === '' && tableName && tableName.indexOf('*') === -1) {
                    var modelClass = '';
                    $.each(tableName.split(/\.|\_/), function() {
                    if(this.length>0)
                        modelClass+=this.substring(0,1).toUpperCase()+this.substring(1);
                    });
                    $('#generator-modelclass').val(modelClass).blur();
                }
          });

          // model generator: synchronize query namespace with model namespace
          $('#dmodel-generator #generator-ns').on('blur', function () {
              var stickyValue = $('#dmodel-generator .field-generator-queryns .sticky-value');
              var input = $('#dmodel-generator #generator-queryns');
              if (stickyValue.is(':visible') || !input.is(':visible')) {
                  var ns = $(this).val();
                  stickyValue.html(ns);
                  input.val(ns);
              }
          });


        }
    };
    return dm_gii.init();
});