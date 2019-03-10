<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 10.04.2018
 * Time: 21:18
 *
 * @var $this \yii\web\View
 * @var $model \frontend\models\NewsFilter
 * @var $page Page
 */

use floor12\editmodal\IconHelper;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;
use yii\widgets\Pjax;

?>
<?php if (Yii::$app->getModule('pages')->adminMode()): ?>
    <a class="btn btn-xs btn-default pull-right"
       onclick="showForm('/news/news/form',{id:0,page_id:<?= $page->id ?>})">
        <?= IconHelper::PLUS ?> добавить объект
    </a>
<?php endif; ?>

    <div class="h1-wrapper h1-wrapper-margin">
        <h1><?= $page->title ?></h1>
        <div></div>
    </div>

<?php if (Yii::$app->getModule('pages')->adminMode()) {
    $form = ActiveForm::begin([
        'method' => 'GET',
        'options' => [
            'data-container' => '#items',
            'class' => 'autosubmit pull-right'
        ],
    ]);
    echo $form->field($model, 'showDisabled')->checkbox();
    ActiveForm::end();
} ?>

<?php Pjax::begin(['id' => 'items']);

echo ListView::widget([
    'dataProvider' => $model->dataProvider(),
    'itemView' => Yii::$app->getModule('news')->viewIndexListItem,
    'layout' => '{items}{pager}',
]);

Pjax::end();



