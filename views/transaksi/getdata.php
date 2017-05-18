<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CountrySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar TRANSAKSI';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="country-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Country', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <table class="table">
                <tr>
                <th>Jurnal</th>
                <th>Customer</th>
                <th>Nama Transaksi</th>
                <th>Type</th>
                <th>Jumlah</th>;
                <th>Tanggal Transaksi</th>
                </tr>
            foreach ($model as $key => $value) {
                echo "<tr>";
                echo "<td>".$value['jurnal_no']."</td>";
                echo "<td>".$value['customer_id']."</td>";
                echo "<td>".$value['trans_name']."</td>";
                echo "<td>".$value['type']."</td>";
                echo "<td>".$value['currency']." ".$value['amount']."</td>";
                echo "<td>".$value['trans_date']."</td>";
                echo "</tr>";
            }
        ?>
    </table>
    
</div>
