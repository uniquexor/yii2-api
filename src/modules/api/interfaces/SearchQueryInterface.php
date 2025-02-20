<?php
    namespace unique\yii2api\modules\api\interfaces;

    use yii\db\QueryInterface;

    interface SearchQueryInterface {

        public function getSearchQuery(): QueryInterface;
    }