<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Customer;
use yii\helpers\ArrayHelper;

$this->title = 'Tambah Transaksi';
$this->params['breadcrumbs'][] = $this->title;
$dataCustom = ArrayHelper::map(Customer::find()->asArray()->all(), 'id', 'name');
?>

<h1><?= Html::encode($this->title) ?></h1>
        <div class="row">
            <div class="col-lg-5">

                <?php $form = ActiveForm::begin(['id' => 'transaksi-form']); ?>

                    <?= $form->field($model, 'jurnal_no')->textInput(['autofocus' => true]) ?>

                    <?= $form->field($model, 'customer_id')->dropDownList($dataCustom) ?>

                    <?= $form->field($model, 'trans_name') ?>
                    <?= $form->field($model, 'type')->dropDownList(["C"=>"Kredit","D"=>"Debet"]) ?>
                    <?= $form->field($model, 'amount') ?>
                    <?= $form->field($model, 'currency') ?>

                    <div class="form-group">
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                    </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>

