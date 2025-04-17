<?php
    namespace unique\yii2api\modules\api\actions;

    use yii\db\ActiveRecord;
    use yii\web\ServerErrorHttpException;

    class UpdateAction extends \yii\rest\UpdateAction {

        public function run( $id = null ) {

            if ( $id === null ) {

                $modelClass = $this->modelClass;
                $keys = $modelClass::primaryKey();
                
                $id = [];
                foreach ( $keys as $key ) {

                    $id[] = \Yii::$app->request->getBodyParam( $key );
                }

                $id = implode( ',', $id );
            }

            /* @var $model ActiveRecord */
            $model = $this->findModel($id);

            if ($this->checkAccess) {
                call_user_func($this->checkAccess, $this->id, $model);
            }

            $model->scenario = $this->scenario;
            $model->load( \Yii::$app->getRequest()->getBodyParams(), '' );
            if ( $model->save() === false && !$model->hasErrors() ) {

                throw new ServerErrorHttpException( 'Failed to update the object for unknown reason.' );
            }

            if ( $model->hasErrors() ) {

                return $model;
            }

            $expand = \Yii::$app->request->get( '_expand', [] );
            if ( is_string( $expand ) ) {

                $expand = explode( ',', $expand );
                $expand = array_map( 'trim', $expand );
            }

            return $model->toArray( [], $expand );
        }
    }