<?php

namespace floor12\news;

/**
 * pages module definition class
 * @property  string $editRole
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'floor12\news';

    /**
     * Те роли в системе, которым разрешено редактирование новостей
     * @var array
     */
    public $editRole = '@';

    /** Вьюхи
     * @var string
     */
    public $viewIndex = '@vendor/floor12/yii2-module-news/src/views/news/index';
    public $viewIndexListItem = '@vendor/floor12/yii2-module-news/src/views/news/_index';
    public $viewView = '@vendor/floor12/yii2-module-news/src/views/news/view';
    public $viewForm = '@vendor/floor12/yii2-module-news/src/views/news/_form';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }

    public function adminMode()
    {
        if ($this->editRole == '@')
            return !\Yii::$app->user->isGuest;
        else
            return \Yii::$app->user->can($this->editRole);
    }
}
