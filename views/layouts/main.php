<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use \lavrentiev\widgets\toastr\NotificationFlash;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => [
            ['label' => 'Active: '.$this->params['kiraValidatorsStatus']['active_validators'], 'url' => ['/site/index', 'status' => 'active']],
            ['label' => 'Paused: '.$this->params['kiraValidatorsStatus']['paused_validators'], 'url' => ['/site/index', 'status' => 'paused']],
            ['label' => 'Inactive: '.$this->params['kiraValidatorsStatus']['inactive_validators'], 'url' => ['/site/index', 'status' => 'inactive']],
            ['label' => 'Jailed: '.$this->params['kiraValidatorsStatus']['jailed_validators'], 'url' => ['/site/index', 'status' => 'jailed']],
            ['label' => 'Total: '.$this->params['kiraValidatorsStatus']['total_validators'], 'url' => ['/site/index']],
        ],
    ]);
    NavBar::end();
    ?>
</header>

<main role="main" class="flex-shrink-0">
    <div class="container">

        <?//= Alert::widget() ?>
        <?= NotificationFlash::widget([

            'options' => [
                "closeButton" => true,
                "debug" => false,
                "newestOnTop" => false,
                "progressBar" => false,
                "positionClass" => \lavrentiev\widgets\toastr\NotificationFlash::POSITION_TOP_RIGHT,
                "preventDuplicates" => false,
                "onclick" => null,
                "showDuration" => "300",
                "hideDuration" => "1000",
                "timeOut" => "5000",
                "extendedTimeOut" => "1000",
                "showEasing" => "swing",
                "hideEasing" => "linear",
                "showMethod" => "fadeIn",
                "hideMethod" => "fadeOut"
            ]
        ]) ?>
        <?= $content ?>
    </div>
</main>

<footer class="footer mt-auto py-3 text-muted">
    <div class="container">
        <p class="float-left">&copy; My Company <?= date('Y') ?></p>
        <p class="float-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
