<?php

namespace app\controllers;

use app\services\site\CookieService;
use app\services\site\ValidatorPrepareData;
use app\services\site\ValidatorService;
use Yii;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $validatorsService = new ValidatorService();
        $validatorsArr = $validatorsService->getAllValidators();
        $this->view->params['kiraValidatorsStatus'] = $validatorsArr['validatorStatus'];
        $autocompleteList = $validatorsService->getValidatorsForAutocomplete($validatorsArr['validators']);
        $prepareValidator = new ValidatorPrepareData();
        $validators=$validatorsArr['validators'];

        if (\Yii::$app->request->isGet && !empty(Yii::$app->request->get('status'))){
            $validators = $validatorsService->getValidatorByStatus($validators, Yii::$app->request->get('status'));
        }

        if(\Yii::$app->request->isPjax && !empty(Yii::$app->request->post('address'))){
            $validators = $validatorsService->getValidatorByAddress($validators, Yii::$app->request->post('address'));
        }

        $dataProvider = $prepareValidator->prepareDataProvider($validators);
        $dataProviderFavorite = $prepareValidator->prepareDataProvider($validatorsArr['favoritesValidators']);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'autocompleteList' => $autocompleteList,
            'dataProviderFavorite' => $dataProviderFavorite,
            'columns' => $prepareValidator->getColumnsGridView()
            ]);
    }

    public function actionInFavorites()
    {
        $cookieService = new CookieService();
        $cookieService->addInCookie(Yii::$app->request->post('address'));

        return true;
    }

    public function actionFromFavorites()
    {
        $cookieService = new CookieService();
        $cookieService->deleteFromCookie(Yii::$app->request->post('address'));

        return true;
    }
}
