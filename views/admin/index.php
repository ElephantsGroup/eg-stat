<?php

use yii\helpers\Html;
use yii\grid\GridView;
use elephantsgroup\stat\models\Stat;
use elephantsGroup\jdf\Jdf;
use elephantsGroup\user\models\User;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$module = \Yii::$app->getModule('stat');
$this->title = $module::t('Statistics') . ' - ' . Yii::t('config', 'Company Name') . ' - ' . Yii::t('config', 'description');
$this->params['breadcrumbs'][] = $module::t('Statistics');
?>
<div class="news-index">

    <h1><?= $module::t('Statistics') ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'module',
            'controller',
            'action',
            'ip',
            'item_id',
            [
                'attribute' => 'user_id',
				'format' => 'raw',
                'filter' => ArrayHelper::map(User::find()->all(), 'id', 'username'),
                'value' => function ($model) { if($model->user_id) return User::findOne($model->user_id)->username; },
            ],
            [
                'attribute' => 'creation_time',
				'format' => 'raw',
                'value' => function ($model) { return Jdf::jdate('Y/m/d', (new \DateTime($model->creation_time))->getTimestamp(), '', 'Iran', 'en'); },
            ],
			'status',
            /*[
				'class' => 'yii\grid\ActionColumn',
				'template' => '{view}',
				'buttons' => [
					'view' => function ($url, $model)
					{
						$label = '<span class="glyphicon glyphicon-eye-open"></span>';
						$url = ['/statistics/admin/view', 'id'=>$model->id, 'lang'=>Yii::$app->controller->language];
						return Html::a($label, $url);
					},
				],
			],*/
        ],
    ]); ?>

</div>
