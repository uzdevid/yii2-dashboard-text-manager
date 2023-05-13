<?php

namespace uzdevid\dashboard\text\controllers;

use uzdevid\dashboard\base\rest\Controller;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class TextManagerController extends Controller {
    public function behaviors(): array {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ];

        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'check-field' => ['POST'],
            ],
        ];

        return $behaviors;
    }

    public function __construct($id, $module, $config = []) {
        parent::__construct($id, $module, $config);

        $this->viewPath = '@uzdevid/yii2-dashboard-text-manager/views/text-manager';
    }

    public function actionCheckField(): array {
        $text = Yii::$app->request->post('text');

        $corrector = Yii::$app->textManager->suggestions()->setText($text);

        return [
            'success' => true,
            'body' => [
                'title' => Yii::t('system.content.korrektor', 'Check'),
                'view' => $this->renderAjax('check', compact('corrector')),
            ]
        ];
    }
}
