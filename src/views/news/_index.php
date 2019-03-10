<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 13.04.2018
 * Time: 19:31
 *
 * @var $this \yii\web\View
 * @var $model News
 */

use floor12\editmodal\EditModalHelper;
use floor12\news\News;
use yii\helpers\Html;

?>

<div class="list-object <?= $model->status == News::STATUS_DISABLED ? "object-disabled" : NULL ?>">

    <?php if (Yii::$app->getModule('pages')->adminMode()): ?>
        <div class="pull-right">
            <?= EditModalHelper::editBtn(['/news/news/form'], $model->id) ?>
            <?= EditModalHelper::deleteBtn(['/news/news/form'], $model->id) ?>
        </div>
    <?php endif; ?>

    <?= Html::a($model->title, $model->url, ['class' => 'list-object-title', 'data-pjax' => '0']) ?>

    <?php if ($model->images && $model->poster_in_listing): ?>
        <?= Html::a(
            Html::img($model->images[0]->hrefPreview, ['class' => 'list-object-poster', 'alt' => $model->title_seo]),
            $model->url,
            ['data-pjax' => '0']
        ) ?>
    <?php endif; ?>

    <p>
        <?= $model->announce ?>
    </p>

    <div class="list-object-date">
        <?= \Yii::$app->formatter->asDate($model->publish_date) ?>
    </div>
</div>
