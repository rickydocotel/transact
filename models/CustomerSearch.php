<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Customer;

/**
 * CustomerSearch represents the model behind the search form about `app\models\Customer`.
 */
class CustomerSearch extends Customer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'country_id', 'city_id','stat'], 'integer'],
            [['name', 'email', 'telp', 'address','country_id','city_id'], 'safe'],
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
    public function search($params)
    {
        $query = Customer::find()->where(['stat'=>1]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,'pagination' => [ 'pageSize' => 5 ]

        ]);

        $this->load($params);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        
        //$dataProvider->query->joinWith('country');
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            //'country_id' => $this->country_id,
            //'city_id' => $this->city_id,
        ]);

        $query->andFilterWhere(['like', 'customer.name', $this->name])
            ->andFilterWhere(['like', 'customer.email', $this->email])
            ->andFilterWhere(['like', 'customer.telp', $this->telp])
            ->andFilterWhere(['like', 'customer.address', $this->address])
            ->andFilterWhere(['like', 'customer.country_id', $this->country_id])
            ->andFilterWhere(['like', 'customer.city_id', $this->city_id]);


        return $dataProvider;
    }
}
