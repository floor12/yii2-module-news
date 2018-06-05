<?php

namespace floor12\news;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\models\News]].
 *
 * @see \common\models\News
 */
class NewsQuery extends ActiveQuery
{
    /**
     * @return $this
     */
    public function active()
    {
        return $this->andWhere(['status' => News::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     * @return News[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return News|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
