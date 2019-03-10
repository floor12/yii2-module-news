<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 13.04.2018
 * Time: 15:33
 *
 * @var $this \yii\web\View
 * @var $model \floor12\news\News
 */

use floor12\editmodal\EditModalHelper;
use floor12\files\assets\LightboxAsset;
use floor12\files\components\FilesBlock;
use floor12\news\SwiperAsset;
use yii\helpers\Html;
use yii\widgets\Pjax;


SwiperAsset::register($this);
LightboxAsset::register($this);

$this->title = $model->title_seo;
$this->registerMetaTag(['name' => 'description', 'content' => $model->description_seo]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $model->keywords_seo]);

SwiperAsset::register($this);
$this->registerJs('initSwiper()', \yii\web\View::POS_READY);

$this->params['breadcrumbs'][] = $this->title;

Pjax::begin(['id' => 'items']);

?>

<?php if (Yii::$app->getModule('pages')->adminMode()): ?>
    <div class="pull-right">
        <?= EditModalHelper::editBtn(['/news/news/form'], $model->id) ?>
        <?= EditModalHelper::deleteBtn(['/news/news/form'], $model->id) ?>
    </div>
<?php endif; ?>

<h1><?= $model->title ?></h1>

<?php if ($model->images && $model->poster_in_view && !$model->slider): ?>
    <?= Html::a(Html::img($model->images[0]->href, ['class' => 'content-big-image', 'alt' => $model->title_seo]), $model->images[0]->href, ['data-lightbox' => 'news']); ?>
<?php endif; ?>

<?php if ($model->images && $model->slider): ?>
    <div class="swiper-container swiper-full ">
        <div class="swiper-wrapper">
            <?php foreach ($model->images as $image) { ?>
                <a class="swiper-slide" data-lightbox="hotel" href="<?= $image->href ?>"
                   style="background-image: url(<?= $image->href ?>); background-size: cover;"></a>
            <?php } ?>
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>

    <br><br><br>

<?php endif; ?>

<?= $model->body ?>

<div class="news-date">
    <?= \Yii::$app->formatter->asDate($model->publish_date) ?>
</div>


<?php
if (sizeof($model->images) > 1 && !$model->slider):
    echo FilesBlock::widget([
        'files' => $model->images,
        'passFirst' => true,
    ]);
endif;
Pjax::end()
?>

<div class="clearfix"></div>

<script>
    // index page swiper
    function initSwiper() {

        setTimeout(function () {

            var swiper = new Swiper('.swiper-container', {
                pagination: '.swiper-pagination',
                paginationClickable: true,
                nextButton: '.swiper-button-next',
                prevButton: '.swiper-button-prev',
                spaceBetween: 30,
                keyboardControl: true,
                autoplay: 4000,
            });
        }, 500);
    }

</script>