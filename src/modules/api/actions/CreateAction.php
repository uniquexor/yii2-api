<?php
    namespace unique\yii2api\modules\api\actions;

    use Yii;

    class CreateAction extends \yii\rest\CreateAction {

        public function run() {

            if ( $this->checkAccess ) {
                call_user_func( $this->checkAccess, $this->id );
            }

            /* @var $model \yii\db\ActiveRecord */
            $model = new $this->modelClass( [
                'scenario' => $this->scenario,
            ] );

            $model->load( Yii::$app->getRequest()->getBodyParams(), '' );
            if ( $model->save() ) {

                $expand = \Yii::$app->request->get( '_expand', [] );
                if ( is_string( $expand ) ) {

                    $expand = explode( ',', $expand );
                    $expand = array_map( 'trim', $expand );
                }

                return $model->toArray( [], $expand );
            } elseif ( !$model->hasErrors() ) {

                // We ignore relation errors
                // @todo we should either make sure it's a relation problem or find a better way to handle it?..
                $model->addError( 'id', 'Unable To Save Data' );
            }

            return $model;
        }
    }