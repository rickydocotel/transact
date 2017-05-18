<?php

namespace app\models;

use Yii;
use app\models\City;
use app\models\Country;

/**
 * This is the model class for table "customer".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $telp
 * @property string $address
 * @property integer $country_id
 * @property integer $city_id
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'telp', 'address', 'country_id', 'city_id'], 'required'],
            [['country_id', 'city_id'], 'integer'],
            [['name', 'email'], 'string', 'max' => 50],
            ['email', 'email'],
            [['telp'], 'string', 'max' => 20],
            [['address'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nama',
            'email' => 'Email',
            'telp' => 'No Telp',
            'address' => 'Alamat',
            'country_id' => 'Negara',
            'city_id' => 'Kota',
        ];
    }

    public function getCountry() {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

    public function getCity() {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    
}
