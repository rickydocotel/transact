<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Transaksi;

/**
 * ContactForm is the model behind the contact form.
 */
class TransaksiForm extends Model
{
    public $jurnal_no;
    public $customer_id;
    public $trans_name;
    public $type;
    public $amount;
    public $currency;
    public $trans_date;
    public $tgl_Dari;
    public $tgl_Ke;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['jurnal_no','customer_id','type','currency','tgl_Dari','tgl_Ke'], 'required'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function tambah($post)
    {
        /*$query = new ('yii\db\QueryBuilder');
        $sql = $query->insert('transaction',[
            'jurnal_no'=>$post['jurnal_no'],
            'customer_id'=>$post['customer_id'],
            'trans_name'=>$post['trans_name'],
            'type'=>$post['type'],
            'amount'=>$post['amount'],
            'currency'=>$post['currency'],
            'trans_date'=>date("Y-m-d h:i:s")
        ]);
        return $sql;*/
        // $customer = new Transaksi;
        // $customer->jurnal_no = $post['jurnal_no'];
        // $customer->customer_id = $post['customer_id'];
        // $customer->trans_name = $post['trans_name'];
        // $customer->type = $post['type'];
        // $customer->amount = $post['amount'];
        // $customer->currency = $post['currency'];
        // $customer->trans_date = date("Y-m-d h:i:s");
        // $customer->insert();
    }

    /*public function pecah($tgl)
    {
        return explode("-".$tgl);
    }*/
}
