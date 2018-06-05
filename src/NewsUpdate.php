<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 13.04.2018
 * Time: 19:18
 */

namespace floor12\news;

use yii\web\IdentityInterface;
use \Yii;

class NewsUpdate
{
    private $_model;
    private $_data;
    private $_page_id;
    private $_identity;

    public function __construct(News $model, array $data, IdentityInterface $identity)
    {
        $this->_model = $model;
        $this->_data = $data;
        $this->_identity = $identity;

        if ($this->_model->isNewRecord) {
            $this->_model->create_user_id = $this->_identity->getId();
            $this->_model->created = time();
        }

        $this->_model->update_user_id = $this->_identity->getId();
        $this->_model->updated = time();
        $this->_page_id = (int)Yii::$app->request->get('page_id');


    }

    public function execute()
    {
        $this->_model->load($this->_data);
        if ($this->_page_id)
            $this->_model->page_id = $this->_page_id;

        if (!is_numeric($this->_model->publish_date))
            $this->_model->publish_date = strtotime($this->_model->publish_date);

        if ($this->_model->isNewRecord && !$this->_model->publish_date)
            $this->_model->publish_date = time();

        return $this->_model->save();
    }
}