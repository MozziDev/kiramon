<?php

/* @var $this yii\web\View */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

$this->title = 'Kira Validators Info';
?>
<div class="site-index">
    <div class="row mb-2">
        <div class="col-md-6 mb-2">
            <div class="coinmarketcap-currency-widget" data-currencyid="6930" data-base="USD" data-secondary="" data-ticker="true" data-rank="false" data-marketcap="false" data-volume="false" data-statsticker="true" data-stats="USD"></div>
        </div>
        <div class="col-md-6">
            <?php
            echo AutoComplete::widget([
                'name' => 'kiraAddress',
                'options'=>[
                    'class'=>'form-control mb-1',
                    'placeholder' => 'Insert Moniker or Address: kira154a6j42c8dtafr....',
                    'template' => '{label}{input}'
                ],
                'clientOptions' => [
                    'source' => $autocompleteList,
//                    'autoFill'=>true,
                    'minLength'=>'0',
                    'select' => new JsExpression("function( event, ui ) {
                        $.pjax.reload({
		                    container: '#validatorsList',
		                    type: 'POST',
		                    data: {address: ui.item.address}
	                        });
	                        $('#resetButton').show();
                        
                    }")
                ],
            ]);
            ?>
                <?php
                echo Html::a('Reset filter',['site/index'],['id' => 'resetButton','class' => 'btn btn-danger btn-block', 'style' => 'display:none'])
                ?>
        </div>
    </div>

    <?php Pjax::begin([
            'id' => 'validatorsList'
    ]); ?>

    <?php

    if ($dataProviderFavorite->getCount()){
    echo GridView::widget([
            'dataProvider' => $dataProviderFavorite,
            'tableOptions' => [
                'class' => 'table table-striped table-bordered'
            ],
            'options' => ['style' => 'font-size:12px;'],
            'columns' => $columns,
        ]);
    }?>

    <span style="font-size: 12px; font-weight: bold">Data from: <a href="https://testnet-rpc.kira.network/api/valopers?all=true">https://testnet-rpc.kira.network/api/valopers?all=true</a></span>

    <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'tableOptions' => [
                'class' => 'table table-striped table-bordered'
            ],
            'options' => ['style' => 'font-size:12px;'],
            'columns' => $columns,
        ]); ?>
    <?php Pjax::end(); ?>
</div>

<?php
$this->registerJsFile('@web/js/site/favorites.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>