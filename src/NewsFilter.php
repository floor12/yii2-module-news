<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 13.04.2018
 * Time: 18:48
 */

namespace floor12\news;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\web\BadRequestHttpException;

class NewsFilter extends Model
{

    public $showDisabled = false;
    public $page_id;

    private $_query;

    public function rules()
    {
        return [
            ['showDisabled', 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'showDisabled' => 'отобразить скрытые'
        ];
    }

    public function dataProvider()
    {
        if (!$this->validate())
            throw new BadRequestHttpException('Ошибка валидации модели.');

        $this->_query = News::find()->orderBy('publish_date DESC')->where(['page_id' => $this->page_id]);

        if (!(Yii::$app->getModule('news')->adminMode() && $this->showDisabled))
            $this->_query->active();

        return new ActiveDataProvider([
            'pagination' => [
                'route' => Yii::$app->request->getPathInfo(),
                'pageSize' => 20,
            ],
            'query' => $this->_query,
        ]);
    }

}