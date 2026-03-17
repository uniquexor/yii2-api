<?php
    namespace unique\yii2api\modules\api\interfaces;

    /**
     * A model capable of decorating other models.
     */
    interface ModelWithDecoratorsInterface {

        /**
         * Decorates the given models.
         * @param array $models
         * @return void
         */
        public function decorateModels( array $models ): void;
    }