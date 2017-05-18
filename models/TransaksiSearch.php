<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Transaksi;
use app\models\Customer;


/**
 * CitySearch represents the model behind the search form about `app\models\City`.
 */
class TransaksiSearch extends Transaksi
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['jurnal_no', 'customer_id', 'trans_name', 'amount'], 'integer'],
            [['code', 'name', 'trans_name', 'type', 'currency', 'tgl_Dari','tgl_Ke'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params=null)
    {
        //print_r($params);die();
       // $query = Connection::createCommand('SELECT * FROM transaction')->queryAll();
        $query = Transaksi::find();
        //if(!$params){

        //}
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $dari = $params['tgl_Dari'];
        $ke = $params['tgl_Ke'];

        // grid filtering conditions
        $query
        ->joinWith('customer')
        ->andFilterWhere(['jurnal_no'=>$params['jurnal_no'],'customer_id'=>$params['customer_id'],'type'=>$params['type'],'currency'=>$params['currency']])
       ->andFilterWhere(['between','trans_date', $dari, $ke]);

        /*$query->andFilterWhere(['like', 'jurnal_no', $params['jurnal_no']])
            ->andFilterWhere(['like', 'type', $params['type']])
            ->andFilterWhere(['like', 'currency', $params['currency']]);
            //->andFilterWhere(['like', 'tgl_Dari', $this->tgl_Dari])
            //->andFilterWhere(['like', 'tgl_Ke', $this->tgl_Ke]);*/


        return $dataProvider;
    }

    private function pecah($tgl){
        $datax=explode("-",$tgl);
        return print_r($datax);
        die();
    }

    
}
