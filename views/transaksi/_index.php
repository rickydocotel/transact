<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\bootstrap\ActiveForm;
use dosamigos\datepicker\DatePicker;
use app\models\Customer;


/* @var $this yii\web\View */
/* @var $searchModel app\models\CustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Customers';
$this->params['breadcrumbs'][] = $this->title;
$dataA = ArrayHelper::map(\app\models\Country::find()->all(), 'id', 'name');
$dataB = ArrayHelper::map(\app\models\City::find()->all(), 'id', 'name');
$dataCustom = ArrayHelper::map(Customer::find()->asArray()->all(), 'id', 'name');
?>

<div class="customer-index">
    <?php $form = ActiveForm::begin(['id'=>'cari-id']) ?>

    <?= $form->field($model, 'jurnal_no')->textInput(["id"=>"jurnal_no"]) ?>
    <?= $form->field($model, 'customer_id')->dropDownList($dataCustom, 
             ['prompt'=>'-Choose a Customer-']); ?>
    <?= $form->field($model, 'type')->dropDownList(["C"=>"Kredit","D"=>"Debet"], 
             ['prompt'=>'-Choose a Type-']); ?>
    <?= $form->field($model, 'currency')->textInput(["id"=>"currency"]) ?>
    
    <?= $form->field($model, 'tgl_Dari')->textInput(["id"=>"tgl_Dari"])->widget(
        DatePicker::className(),[
            'inline' => false,
            'clientOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]
        ]
    ); ?>
    <?= $form->field($model, 'tgl_Ke')->textInput(["id"=>"tgl_Ke"])->widget(
        DatePicker::className(),[
            'inline' => false,
            'clientOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]
        ]
    ); ?>
    <div class="form-group">
        <?= Html::submitButton('Submit'); ?>
    </div>
    <?php ActiveForm::end(); ?>
    
<?php Pjax::begin(['id' => 'pjax-gridview']); ?>    
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'jurnal_no',
            [
            "attribute"=>"customer_id",
            "label"=>"Nama Customer",
            "value"=>"customer.name"
            ],
            ["attribute"=>"trans_name",
            "label"=>"Nama Transaksi",
            "value"=>"trans_name"
            ],
            ["attribute"=>"type",
            "value"=>function($data){
                if($data->type=="C"){
                    return "Credit";
                }else{
                    return "Debet";
                }
            }
            ],
            ["attribute"=>"amount",
            'contentOptions' => ['class' => 'text-right'],
            "value"=>function($data){
                    return $data->currency." ".number_format($data->amount,0,",",".");
                    }
            ],
            ["attribute"=>"trans_date",
            "value"=>function($data){
                    return date("d-m-Y", strtotime($data->trans_date));
                    }
            ],

        ],
    ]); ?>
<?php Pjax::end(); ?></div>
