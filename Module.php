<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\gii;

use Yii;
use yii\base\BootstrapInterface;
use yii\helpers\Json;
use yii\web\ForbiddenHttpException;

/**
 * This is the main module class for the Gii module.
 *
 * To use Gii, include it as a module in the application configuration like the following:
 *
 * ~~~
 * return [
 *     'bootstrap' => ['gii'],
 *     'modules' => [
 *         'gii' => ['class' => 'yii\gii\Module'],
 *     ],
 * ]
 * ~~~
 *
 * Because Gii generates new code files on the server, you should only use it on your own
 * development machine. To prevent other people from using this module, by default, Gii
 * can only be accessed by localhost. You may configure its [[allowedIPs]] property if
 * you want to make it accessible on other machines.
 *
 * With the above configuration, you will be able to access GiiModule in your browser using
 * the URL `http://localhost/path/to/index.php?r=gii`
 *
 * If your application enables [[\yii\web\UrlManager::enablePrettyUrl|pretty URLs]],
 * you can then access Gii via URL: `http://localhost/path/to/index.php/gii`
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Module extends \yii\gii\Module implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'yii\gii\controllers';



    /**
     * Returns the list of the core code generator configurations.
     * @return array the list of the core code generator configurations.
     */
    protected function coreGenerators()
    {
        return array_merge( parent::coreGenerators(),  [
            'dcrud' => ['class' => 'yii\gii\generators\dcrud\Generator'],
            'dmodel' => ['class' => 'yii\gii\generators\dmodel\Generator'],
            'thinkcrud' => ['class' => 'yii\gii\generators\thinkcrud\Generator'],
            'thinkcontroller' => ['class' => 'yii\gii\generators\thinkcontroller\Generator'],
            'ecstorecrud' => ['class' => 'yii\gii\generators\ecstorecrud\Generator'],
            'discuzplugin' => ['class' => 'yii\gii\generators\discuzplugin\Generator'],
            'wcrud' => ['class' => 'yii\gii\generators\wcrud\Generator'],
        ]);
    }
}
