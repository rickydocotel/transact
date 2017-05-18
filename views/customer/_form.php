<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Country;
use app\models\City;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;



/* @var $this yii\web\View */
/* @var $model app\models\Customer */
/* @var $form yii\widgets\ActiveForm */
$datarayA=ArrayHelper::map(Country::find()->asArray()->all(), 'id', 'name');
$datarayB=ArrayHelper::map(City::find()->asArray()->all(), 'id', 'name');

?>

<div class="customer-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'country_id')->dropDownList($datarayA, ['prompt'=>'Select','id'=>'country_id']);?>
   <!--  $form->field($model, 'country_id')->dropDownList($datarayA, 
             ['prompt'=>'-Choose a Category-',
              'onchange'=>'
                $.post( "'.Yii::$app->urlManager->createUrl('customer/lists?id=').'"+$(this).val(), function( data ) {
                  $( "select#city_id" ).html( data );
                });
            ']); -->        
    <?= $form->field($model, 'city_id')->widget(DepDrop::classname(), [
     'options' => ['id'=>'city_id'],
     'pluginOptions'=>[
         'depends'=>['country_id'],
         'placeholder' => 'Select...',
         'url' => Url::to(['/customer/listkota'])
     ]
    ]);?>

    <!-- <?= $form->field($model, 'city_id')->dropDownList(
            $datarayB,           
            ['id'=>'city_id']
        ); ?> -->

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
