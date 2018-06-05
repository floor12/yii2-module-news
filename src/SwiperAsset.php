<?php

namespace floor12\news;

use yii\web\AssetBundle;


class SwiperAsset extends AssetBundle
{

    public $publishOptions = [
#        'forceCopy' => true,
    ];
    public $sourcePath = '@bower/';
    public $css = [
        'swiper/dist/css/swiper.min.css'
    ];
    public $js = [
        'swiper/dist/js/swiper.min.js'
    ];
    public $depends = [
        //    'yii\web\JqueryAsset',
    ];

}
