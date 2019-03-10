<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 10.04.2018
 * Time: 21:17
 */

namespace floor12\news;

use floor12\pages\models\Page;
use floor12\editmodal\EditModalAction;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use floor12\editmodal\DeleteAction;
use \Yii;
use yii\filters\VerbFilter;

class NewsController extends Controller
{

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->layout = Yii::$app->getModule('news')->layout;
        parent::init();
    }


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['form', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [Yii::$app->getModule('pages')->editRole],
                    ],

                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['delete'],
                ],
            ],
        ];
    }


    public function actionIndex(Page $page)
    {
        $model = new NewsFilter();
        $model->page_id = $page->id;
        $model->load(Yii::$app->request->get());
        return $this->render(Yii::$app->getModule('news')->viewIndex, ['model' => $model, 'page' => $page]);
    }

    public function actionView($key, $page_id = null)
    {
        $model = News::find()->where(['key' => $key])->andFilterWhere(['page_id' => $page_id])->one();
        if (!$model)
            throw new NotFoundHttpException('Новость не найдена.');

        if (!Yii::$app->getModule('news')->adminMode() && $model->status == News::STATUS_DISABLED)
            throw new NotFoundHttpException('Новость не найдена.');

        return $this->render(Yii::$app->getModule('news')->viewView, ['model' => $model]);
    }

    public function actions()
    {
        return [
            'form' => [
                'class' => EditModalAction::class,
                'model' => News::class,
                'view' => Yii::$app->getModule('news')->viewForm,
                'logic' => NewsUpdate::class,
            ],
            'delete' => [
                'class' => DeleteAction::class,
                'model' => News::class,
                'message' => 'Новость удалена',
            ]
        ];
    }

}