<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use elephantsGroup\stat\models\Stat;
use hoomanMirghasemi\jdf\Jdf;
use dektrium\user\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\News */

$module = \Yii::$app->getModule('stat');
$this->title = $module::t('Stat ID') . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => $module::t('Statistics'), 'url' => ['index', 'lang'=>Yii::$app->controller->language]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a($module::t('Update'), ['update', 'id' => $model->id, 'lang'=>Yii::$app->controller->language], ['class' => 'btn btn-primary']) ?>
        <?= Html::a($module::t('Delete'), ['delete', 'id' => $model->id, 'lang'=>Yii::$app->controller->language], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => $module::t('Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

	<?php
		$path_string = $module::t('Path');
		$guest_string = $module::t('Guest');
	?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
			/*[
				'header'  => $path_string,
				'value'  => $model->module . '->' . $model->controller . '-' . $model->action,
			],*/
			/*[
				'attribute'  => 'user_id',
				'value'  => Yii::$app->user->isGuest ? $guest_string : User::findOne($model->user_id)->username,
			],*/
			'ip',
			'item_id',
			[
				'attribute'  => 'creation_time',
				'value'  => Jdf::jdate('Y/m/d H:i:s', (new \DateTime($model->creation_time))->getTimestamp(), '', 'Iran', 'en'),
			],
			[
				'attribute'  => 'status',
				'value'  => Stat::getStatus()[$model->status],
			],
        ],
    ]) ?>

</div>
