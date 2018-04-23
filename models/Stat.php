<?php

namespace elephantsGroup\stat\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "eg_statistics".
 *
 * @property integer $id
 * @property string $module
 * @property string $controller
 * @property string $action
 * @property string $creation_time
 * @property string $ip
 * @property string $status
 * @property integer $user_id
 *
 */
class Stat extends \yii\db\ActiveRecord
{
	public static $_STATUS_LOGGED = 0;
	public static $_STATUS_ARCHIVED = 1;
	public $creation_time_time;

	public static function getStatus()
	{
		$base = \Yii::$app->getModule('base');
		return [
			self::$_STATUS_LOGGED => $base::t('Logged'),
			self::$_STATUS_ARCHIVED => $base::t('Archived')
		];
	}

    /**
     * @inheritdoc
     */
	
	public static function tableName()
    {
        return '{{%eg_statistics}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'item_id', 'status'], 'integer'],
			[['module', 'controller', 'action', 'ip'], 'trim'],
            [['module', 'controller', 'action', 'ip'], 'string', 'max' => 32],
            [['controller', 'action', 'status'], 'required'],
            [['creation_time_time'], 'string', 'max' => 11],
			[['creation_time'], 'date', 'format'=>'php:Y-m-d H:i:s'],
			[['creation_time'], 'default', 'value' => (new \DateTime)->setTimestamp(time())->setTimezone(new \DateTimeZone('Iran'))->format('Y-m-d H:i:s')],
            [['status'], 'default', 'value' => self::$_STATUS_LOGGED],
			[['status'], 'in', 'range' => array_keys(self::getStatus())]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
		$base = \Yii::$app->getModule('base');
        return [
            'id' => $base::t('ID'),
            'user_id' => $base::t('User ID'),
            'creation_time' => $base::t('Creation Time'),
            'module' => $base::t('Module'),
            'controller' => $base::t('Controller'),
            'action' => $base::t('Action'),
            'ip' => $base::t('IP'),
			'status' => $base::t('Status'),
            'item_id' => $base::t('Item ID'),
        ];
    }

	public function beforeSave($insert)
	{
		$date = new \DateTime();
		$date->setTimestamp(time());
		$date->setTimezone(new \DateTimezone('Iran'));
		if($this->isNewRecord)
			$this->creation_time = $date->format('Y-m-d H:i:s');
		return parent::beforeSave($insert);
	}

	public static function setView($module, $controller, $action, $item_id = 0)
	{
		try {
			$stat = new Stat;
			$stat->module = $module;
			$stat->controller = $controller;
			$stat->action = $action;
			$stat->status = self::$_STATUS_LOGGED;
            $stat->item_id = $item_id;
			if(!Yii::$app->user->isGuest)
				$stat->user_id = Yii::$app->user->id;
			$stat->ip = Yii::$app->request->userIP;
			if($stat->save())
				return true;
			return false;
		}
		catch(Exception $exp)
		{
			// TODO: raise warning
			return false;
		}
	}

	public static function setAutoView($item_id = 0)
	{
		try {
			$stat = new Stat;
			$stat->module = Yii::$app->controller->module->id;
			$stat->controller = Yii::$app->controller->id;
			$stat->action = Yii::$app->controller->action->id;
			$stat->status = self::$_STATUS_LOGGED;
			$stat->item_id = $item_id;
			if(Yii::$app->request->get('id'))
				$stat->item_id = Yii::$app->request->get('id');
			if(!Yii::$app->user->isGuest)
				$stat->user_id = Yii::$app->user->id;
			$stat->ip = Yii::$app->request->userIP;
			if($stat->save())
				return true;
			return false;
		}
		catch(Exception $exp)
		{
			// TODO: raise warning
			return false;
		}
	}
}