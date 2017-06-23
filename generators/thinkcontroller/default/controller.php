<?php
/**
 * This is the template for generating a controller class file.
 */

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\controller\Generator */

echo "<?php\n";
?>

/**
 * <?= StringHelper::basename($generator->controllerClass)."\n"; ?>
 */
class <?= StringHelper::basename($generator->controllerClass) ?>Action extends <?= $generator->moduleName ?>Action
{
<?php foreach ($generator->getActionIDs() as $action): ?>

	/**
	 * <?= Inflector::id2camel($action)."\n" ?>
	 * @type page
	 */
    public function <?= Inflector::id2camel($action) ?>()
    {
        $this->display();
    }

<?php endforeach; ?>
}
