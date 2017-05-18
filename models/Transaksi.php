<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transaction".
 *
 * @property integer $id
 * @property string $jurnal_no
 * @property integer $customer_id
 * @property string $trans_name
 * @property string $type
 * @property string $amount
 * @property string $currency
 * @property string $trans_date
 */
class Transaksi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transaction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['jurnal_no', 'customer_id', 'trans_name', 'type', 'amount', 'currency', 'trans_date'], 'required'],
            [['customer_id'], 'integer'],
            [['type'], 'string'],
            [['amount'], 'number'],
            [['trans_date'], 'safe'],
            [['jurnal_no'], 'string', 'max' => 8],
            [['trans_name'], 'string', 'max' => 50],
            [['currency'], 'string', 'max' => 3],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jurnal_no' => 'Jurnal No',
            'customer_id' => 'Customer ID',
            'trans_name' => 'Trans Name',
            'type' => 'Type',
            'amount' => 'Amount',
            'currency' => 'Currency',
            'trans_date' => 'Trans Date',
        ];
    }

    public function getCustomer() {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }
}
