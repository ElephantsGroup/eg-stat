<?php

namespace elephantsGroup\stat\controllers;

use Yii;
use elephantsGroup\stat\models\Stat;
use elephantsGroup\stat\models\StatSearch;
//use yii\web\Controller;
//use app\modules\news\components\Controller;
use elephantsGroup\base\EGController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use elephantsGroup\jdf\Jdf;

/**
 * StatController implements the CRUD actions for Stat model.
 */
class ReportsController extends EGController
{
    public function behaviors()
    {
		$behaviors = [];
		$behaviors['verbs'] = [
			'class' => VerbFilter::className(),
			'actions' => [
				'delete' => ['post'],
			],
		];
        $auth = Yii::$app->getAuthManager();
        if (!$auth)
		{
			$behaviors['access'] = [
				'class' => \yii\filters\AccessControl::className(),
				'only' => ['index'],
				'rules' => [
					[
						'actions' => ['index'],
						'allow'   => true,
						'roles'   => ['admin'],
					],
				],
			];
		}
		return $behaviors;
    }

    /**
     * Lists all Stat models.
     * @return mixed
     */
    public function actionIndex()
    {
        // TODO: add some reports
    }
}
