<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "logs".
 *
 * @property integer $id
 * @property string $request
 * @property string $response
 * @property string $ip_address
 * @property string $created_date
 */
class LogsTambah extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'logs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['request', 'ip_address', 'created_date'], 'required'],
            [['request', 'response'], 'string'],
            [['created_date'], 'safe'],
            [['ip_address'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'request' => 'Request',
            'response' => 'Response',
            'ip_address' => 'Ip Address',
            'created_date' => 'Created Date',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->created_date = date('Y-m-d H:i:s');
            return true;
        } else {
            return false;
        }
    }
}
