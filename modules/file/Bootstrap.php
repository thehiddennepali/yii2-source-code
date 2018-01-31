<?php

namespace modules\file;

use page\models\Page;
use page\url_rules\PageUrlRule;
use Yii;
use yii\base\BootstrapInterface;
use yii\web\UrlRule;

/**
 * Hook with application bootstrap stage
 * @author John Martin <john.itvn@gmail.com>
 * @since 1.0.0
 */
class Bootstrap implements BootstrapInterface {

    /**
     * Initial application compoments and modules need for extension
     * @param \yii\base\Application $app The application currently running
     * @return void
     */
    public function bootstrap($app) {

        if (!isset(Yii::$app->get('i18n')->translations['file*'])) {
            Yii::$app->get('i18n')->translations['file*'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => __DIR__ . '/messages',
            ];
        }
    }
}
