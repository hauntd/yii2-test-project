<?php

namespace app\controllers\api;

use app\models\Task;
use Yii;
use yii\db\QueryInterface;
use yii\rest\ActiveController;

/**
 * @author Alexander Kononenko <contact@hauntd.me>
 * @package app\controllers\api
 */
class TaskController extends ActiveController
{
    public $modelClass = Task::class;

    public $serializer = [
        'class' => \yii\rest\Serializer::class,
        'collectionEnvelope' => 'items',
    ];

    public function actions()
    {
        return array_merge(parent::actions(), [
            'index' => [
                'class' => 'yii\rest\IndexAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
                'prepareSearchQuery' => function (QueryInterface $query, $requestParams) {
                    if ($userId = Yii::$app->request->get('user_id')) {
                        $query->andWhere(['user_id' => $userId]);
                    }
                    return $query;
                }
            ],
        ]);
    }
}
