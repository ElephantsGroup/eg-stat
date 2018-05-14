<?php

namespace elephantsGroup\stat;

use Yii;

class Module extends \yii\base\Module
{
    public $archive_duration = 86400; // by seconds

    public function init()
    {
        parent::init();

        if (empty(Yii::$app->i18n->translations['statistics']))
		{
            Yii::$app->i18n->translations['statistics'] =
			[
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => __DIR__ . '/messages',
                //'forceTranslation' => true,
            ];
        }
    }

    public static function t($message, $params = [], $language = null)
    {
        return \Yii::t('statistics', $message, $params, $language);
    }
}
