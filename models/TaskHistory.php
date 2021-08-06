<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * @author Alexander Kononenko <contact@hauntd.me>
 * @package app\models
 *
 * @property int $id
 * @property string $task_id
 * @property string|null $data
 * @property int $created_at
 */
class TaskHistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task_history';
    }

    /**
     * @return array[]
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => false,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_id'], 'required'],
            [['data'], 'string'],
            [['task_id'], 'integer'],
            [['task_id'], 'exist', 'targetClass' => Task::class, 'targetAttribute' => 'id'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_id' => Yii::t('app', 'Task'),
            'data' => Yii::t('app', 'Data'),
        ];
    }

    /**
     * @return array
     */
    public function fields()
    {
        return [
            'id',
            'task_id',
            'created_at',
            'task' => function (TaskHistory $taskHistory) {
                if (isset($taskHistory->data)) {
                    return json_decode($taskHistory->data);
                }
                return null;
            }
        ];
    }
}
