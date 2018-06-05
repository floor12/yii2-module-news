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
