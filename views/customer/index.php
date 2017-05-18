<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\depdrop\DepDrop;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Customers';
$this->params['breadcrumbs'][] = $this->title;
$dataA = ArrayHelper::map(\app\models\Country::find()->all(), 'id', 'name');
$dataB = ArrayHelper::map(\app\models\City::find()->all(), 'id', 'name');
?>
<div class="customer-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Customer', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php $form = ActiveForm::begin(); ?>
     <?= $form->field($model, 'country_id')->dropDownList($dataA, ['prompt'=>'Select','id'=>'country_id','onchange'=>'$.pjax.reload({
                url: "'.Url::to(['index']).'?CustomerSearch[country_id]="+$(this).val(),
                container: "#pjax-gridview",
                timeout: 1000,
            });']);?>
     <?= $form->field($model, 'city_id')->widget(DepDrop::classname(), [
     'options' => ['id'=>'city_id','onchange'=>'$.pjax.reload({
                url: "'.Url::to(['index']).'?CustomerSearch[country_id]="+$("select#country_id").val()+"&CustomerSearch[city_id]="+$(this).val(),
                container: "#pjax-gridview",
                timeout: 1000,
            });','prompt'=>'Select'],
     'pluginOptions'=>[
         'depends'=>['country_id'],
         'placeholder' => 'Select...',
         'url' => Url::to(['/customer/listkota'])
     ]
    ]);

     /*
Html::dropDownList('country', null, $dataA,['prompt'=>'- Pilih Negara -','class'=>'form-control','id'=>'country','onchange'=>'$.pjax.reload({
                url: "'.Url::to(['index']).'?CustomerSearch[country_id]="+$(this).val(),
                container: "#pjax-gridview",
                timeout: 1000,
            });']);
     Html::dropDownList('city', null, $dataB,['prompt'=>'- Pilih Kota -','class'=>'form-control','id'=>'city','onchange'=>'$.pjax.reload({
                url: "'.Url::to(['index']).'?CustomerSearch[country_id]="+$("select#country").val()+"&CustomerSearch[city_id]="+$(this).val(),
                container: "#pjax-gridview",
                timeout: 1000,
            });']);
          
     */?>
      <?php ActiveForm::end(); ?>
<?php Pjax::begin(['id' => 'pjax-gridview']); ?>    
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'email:email',
            'telp',
            'address',
            ["attribute"=>"country_id",
            "value"=>function($data){
                    return $data->country->name;
            }
            ],
            ["attribute"=>"city_id",
            "value"=>function($data){
                    return $data->city->name;
            }
            ],

            ['class' => 'yii\grid\ActionColumn'],

        ],
    ]); ?>
<?php Pjax::end(); ?></div>
