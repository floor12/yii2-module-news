<?php

use yii\db\Migration;

class m180403_114045_news extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }


        #Новости --------------------------------------------------------------------------------------------------
        $this->createTable('{{%news}}', [
            'id' => $this->primaryKey(),
            'id_old' => $this->integer()->null()->comment('Старый ID'),
            'status' => $this->smallInteger()->notNull()->defaultValue(0)->comment('Скрыть'),
            'created' => $this->integer()->notNull()->comment('Время создания'),
            'updated' => $this->integer()->notNull()->comment('Время обновления'),
            'create_user_id' => $this->integer()->null()->comment('Создал'),
            'update_user_id' => $this->integer()->null()->comment('Обновил'),
            'key' => $this->string(400)->notNull()->comment('Ключевое слово для URL'),
            'title' => $this->string(255)->notNull()->comment('Заголовок новости'),
            'title_seo' => $this->string(255)->notNull()->comment('Title страницы'),
            'description_seo' => $this->string(400)->null()->comment('Meta Description'),
            'keywords_seo' => $this->string(400)->null()->comment('Meta keywords'),
            'announce' => $this->text()->notNull()->comment('Анонс новости'),
            'body' => $this->text()->null()->comment('Текст новости'),
            'publish_date' => $this->integer()->notNull()->comment('Дата публикации'),
            'page_id' => $this->integer()->null()->comment('Связь с разделом'),
            'index_page' => $this->integer(1)->null()->defaultValue(1)->comment('Показывать на главной'),
            'poster_in_listing' => $this->integer(1)->null()->defaultValue(1)->comment('Показывать ли постер в списке'),
            'poster_in_view' => $this->integer(1)->null()->defaultValue(1)->comment('Показывать ли постер при просмотре'),
            'slider' => $this->integer(1)->null()->defaultValue(0)->comment('Показывать слайдер'),
        ], $tableOptions);

        $this->createIndex("idx-news-status", "{{%news}}", "status");
        $this->createIndex("idx-news-publish_date", "{{%news}}", "publish_date");
        $this->createIndex("idx-news-key", "{{%news}}", "key");
        $this->createIndex("idx-news-index_page", "{{%news}}", "index_page");
        $this->createIndex("idx-news-page_id", "{{%news}}", "page_id");

        $this->createIndex("idx-news-created", "{{%news}}", "created");
        $this->createIndex("idx-news-updated", "{{%news}}", "updated");
        $this->createIndex("idx-news-create_user_id", "{{%news}}", "create_user_id");
        $this->createIndex("idx-news-update_user_id", "{{%news}}", "update_user_id");

   }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable("{{%news}}");
    }


}
