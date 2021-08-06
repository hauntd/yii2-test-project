<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * @author Alexander Kononenko <contact@hauntd.me>
 * @package app\models
 *
 * @property int $id
 * @property string $name
 * @property string|null $deadline_datetime
 * @property string|null $description
 * @property int|null $user_id
 * @property string $status
 *
 * @property-read  User $user
 */
class Task extends \yii\db\ActiveRecord
{
    const STATUS_TO_BE_DONE = 'tbd';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_TESTING = 'testing';
    const STATUS_DONE = 'done';

    public static function getStatusOptions()
    {
        return [
            self::STATUS_TO_BE_DONE => Yii::t('app', 'To Be Done'),
            self::STATUS_IN_PROGRESS => Yii::t('app', 'In Progress'),
            self::STATUS_TESTING => Yii::t('app', 'Testing'),
            self::STATUS_DONE => Yii::t('app', 'Done'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * @return \string[][]
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'status'], 'required'],
            [['deadline_datetime'], 'safe'],
            [['description'], 'string'],
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['user_id'], 'validateUser'],
            [['name'], 'string', 'max' => 255],
            [['status'], 'in',
                'range' => array_keys(self::getStatusOptions()),
                'message' => Yii::t('app', 'Correct statuses are: {0}',
                    implode(', ', array_keys(self::getStatusOptions())))
            ],
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => Yii::t('app', 'Name'),
            'deadline_datetime' => Yii::t('app', 'Deadline Datetime'),
            'description' => Yii::t('app', 'Description'),
            'user_id' => Yii::t('app', 'User'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return bool
     */
    public function validateUser()
    {
        $user = User::findIdentity($this->user_id);

        if ($user === null) {
            $this->addError('user_id', Yii::t('app', 'User not found'));
            return false;
        }

        return true;
    }

    public function afterSave($insert, $changedAttributes)
    {
        // do not save history for new records
        if ($insert === true) {
            return true;
        }

        $taskHistory = new TaskHistory([
            'task_id' => $this->id,
            'data' => json_encode($this->attributes),
        ]);

        $taskHistory->save();
    }

    public function afterDelete()
    {
        TaskHistory::deleteAll(['task_id' => $this->id]);
    }

    public function fields()
    {
        return array_merge(parent::fields(), [
            'history' => function (Task $task) {
                return TaskHistory::findAll(['task_id' => $task->id]);
            }
        ]);
    }
}
