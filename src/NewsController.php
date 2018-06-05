<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 10.04.2018
 * Time: 21:17
 */

namespace floor12\news;

use floor12\pages\Page;
use floor12\editmodal\EditModalAction;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use floor12\editmodal\DeleteAction;
use \Yii;
use yii\filters\VerbFilter;

class NewsController extends Controller
{

    public $layout = '@frontend/views/layouts/columns';

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
        return $this->render('@common/modules/news/views/news/index', ['model' => $model, 'page' => $page]);
    }

    public function actionView($key, $page_id = null)
    {
        $model = News::find()->where(['key' => $key])->andFilterWhere(['page_id' => $page_id])->one();
        if (!$model)
            throw new NotFoundHttpException();

        return $this->render('@common/modules/news/views/news/view', ['model' => $model]);
    }

    public function actions()
    {
        return [
            'form' => [
                'class' => EditModalAction::class,
                'model' => News::class,
                'logic' => NewsUpdate::class,
            ],
            'delete' => [
                'class' => DeleteAction::class,
                'model' => News::class,
                'message' => 'Отель удален',
            ]
        ];
    }

}