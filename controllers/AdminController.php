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
class AdminController extends EGController
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
				'only' => ['index', 'view', 'update', 'delete'],
				'rules' => [
					[
						'actions' => ['index', 'view', 'update', 'delete'],
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
        $searchModel = new StatSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Stat model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Deletes an existing Stat model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Stat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Stat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Stat::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
