<?php

namespace floor12\news;

use floor12\pages\models\Page;
use floor12\pages\interfaces\PageObjectInterface;
use yii\db\ActiveRecord;
use floor12\files\components\FileBehaviour;
use floor12\files\models\File;
use common\models\User;
use \Yii;


/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property int $id_old Старый ID
 * @property int $status Скрыть
 * @property int $created Время создания
 * @property int $updated Время обновления
 * @property int $create_user_id Создал
 * @property int $update_user_id Обновил
 * @property int $page_id Связь со страницей
 * @property string $key Ключевое слово для URL
 * @property string $title Заголовок новости
 * @property string $title_seo Title страницы
 * @property string $description_seo Meta Description
 * @property string $keywords_seo Meta keywords
 * @property string $announce Анонс новости
 * @property string $body Текст новости
 * @property int $publish_date Дата публикации
 * @property string $url Адрес страницы
 * @property bool $index_page Показывать на главной
 * @property bool $poster_in_listing Показывать постер в списке
 * @property bool $poster_in_view Показывать постер при просмотре
 * @property bool $slider Показывать слайдер
 *
 * @property User $creator
 * @property User $updator
 * @property File[] $images
 */
class News extends ActiveRecord implements PageObjectInterface
{

    const SHOW_IN_INDEX = 1;
    const HIDE_IN_INDEX = 0;

    const POSTER_IN_LISTING_SHOW = 1;
    const POSTER_IN_LISTING_HIDE = 0;

    const POSTER_IN_VIEW_SHOW = 1;
    const POSTER_IN_VIEW_HIDE = 0;

    const SLIDER_ENABLED = 1;
    const SLIDER_DISABLED = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['key', 'trim'],
            [['status', 'created', 'updated', 'create_user_id', 'update_user_id', 'publish_date', 'page_id', 'index_page', 'poster_in_listing', 'poster_in_view', 'slider'], 'integer'],
            [['created', 'updated', 'key', 'title', 'title_seo', 'announce', 'publish_date'], 'required'],
            [['announce', 'body'], 'string'],
            [['key', 'description_seo', 'keywords_seo'], 'string', 'max' => 400],
            [['title', 'title_seo'], 'string', 'max' => 255],
            [['create_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Yii::$app->getModule('news')->userModel, 'targetAttribute' => ['create_user_id' => 'id']],
            [['update_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Yii::$app->getModule('news')->userModel, 'targetAttribute' => ['update_user_id' => 'id']],
            ['images', 'file', 'maxFiles' => 10, 'extensions' => ['jpg', 'jpeg', 'png', 'gif']],
            ['key', 'match', 'pattern' => '/^[-a-z0-9]*$/', 'message' => 'Ключ URL может состоять только из латинских букв в нижнем регистре, цифр и дефиса.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Скрыть',
            'created' => 'Время создания',
            'updated' => 'Время обновления',
            'create_user_id' => 'Создал',
            'update_user_id' => 'Обновил',
            'key' => 'Ключевое слово для URL',
            'title' => 'Заголовок новости',
            'title_seo' => 'Title страницы',
            'description_seo' => 'Meta Description',
            'keywords_seo' => 'Meta keywords',
            'announce' => 'Анонс новости',
            'body' => 'Текст новости',
            'publish_date' => 'Дата публикации',
            'images' => 'Изображения',
            'index_page' => 'Показывать на главной',
            'poster_in_listing' => 'Показывать постер в списке',
            'poster_in_view' => 'Показывать постер при просмотре',
            'slider' => 'Показывать слайдер'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreator()
    {
        return $this->hasOne(User::className(), ['id' => 'create_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdator()
    {
        return $this->hasOne(User::className(), ['id' => 'update_user_id']);
    }

    /**
     * @inheritdoc
     * @return NewsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NewsQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'files' => [
                'class' => FileBehaviour::class,
                'attributes' => [
                    'images'
                ]
            ]
        ];
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        $page_path = Page::find()->where(['id' => $this->page_id])->select('path')->scalar();
        return "/{$page_path}/{$this->key}.html";
    }
}
