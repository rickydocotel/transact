<?php

namespace app\controllers;
use Yii;
use yii\rest\Controller;
use yii\web\Response;
use app\models\Transaksi;
use app\models\City;
use app\models\Country;
use app\models\Customer;
use app\models\LogsTambah;
use yii\helpers\ArrayHelper;
use yii\web\Request;


class ServicesController extends Controller
{
    //public $modelClass = "app\models\City";
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'tambah'  => ['post'],
                    'ubah'   => ['put'],
                    'getcustomer'   => ['get'],
                    'tambahcustomer' => ['post']
//                    'update' => ['get', 'put', 'post'],
//                    'delete' => ['post', 'delete'],
                ],
            ],
            [
                'class' => 'yii\filters\ContentNegotiator',
                'only' => ['tambah','ubah','getcustomer','tambahcustomer'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
        ];
    }

    public function beforeAction($action){
        $post = Yii::$app->request->post();
        if($action->id=="tambah"){
            $create = new LogsTambah();
            $create->request = json_encode($post);
            $create->ip_address = Request::getUserIP();
            $create->created_date = date('Y-m-d H:i:s');
            $create->save();
        }       
        $result = parent::beforeAction($action);
        return $result;
    }

    public function actionTambah(){
        $post = Yii::$app->request->post();
    	$create = new Transaksi();
        $create->attributes=$post;
        $create->trans_date=date("Y-m-d H:i:s");
    	$create->save();
        	if($create->validate()){
                $log = LogsTambah::find()->orderBy(['id' => SORT_DESC])->one();
        		return array('status'=> true,'data'=>'berhasil','idx'=>$log['id']);
        	}else{
                return array('status'=> false,'data'=>$create->getErrors());
        	}
            /*$log = LogsTambah::find()->orderBy(['id' => SORT_DESC])->one();
            print_r($post);*/
        /*print_r();*/
    }

   public function afterAction($action, $result)
    {
        if($action->id=="tambah"){
                $updet = LogsTambah::findOne($result['idx']);
                $updet->response = json_encode($result);
                $updet->update();
                $result = parent::afterAction($action, $result);
        }
                if ($updet->update() !== false) {
                    return $result;
                } else {
                   return false;
                }
    }

    /*public function afterAction($action){
        $create = LogsTambah()::findOne();
        $create->response =  
        $create->save();
        if($action->id=="tambah"){
            $result = parent::beforeAction($action);
        }
            return $result;
    }*/

    public function actionGetcustomer(){
        //header("Content-Type:application/json");
        $data = ArrayHelper::map(Customer::find()->asArray()->all(), 'id', 'name');
        foreach ($data as $key => $value) {
            $datass[]=['id'=>$key,'name'=>$value];
        }
        return json_encode(array('res'=>$datass));
    }

    public function actionTambahcustomer(){
        $model = new Customer();
        $model->attributes=Yii::$app->request->post();
        $model->save();
        if($model->validate()){
            $datasatu = Customer::find()->where(['id'=>$model->id])->one();
                Yii::$app->mailer->compose()
                ->setFrom('rickz.avenger@gmail.com')
                ->setTo($datasatu['email'])
                ->setSubject('Email Validasi')
                ->setHtmlBody('Terima kasih anda telah mendaftar di sini<br>
                        Untuk aktivasi silakan klik link ini :<br>
                        <a href="http://localhost/transact/web/customer/aktivasi?id='.$datasatu['id'].'">Aktifkan</a>
                    ')
                ->send();
            return array('status'=>true,'data'=>'berhasil');
        }else{
            return array('status'=>false,'data'=>$model->getErrors());
        }
        /*if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $datasatu = Customer::find()->where(['id'=>$model->id])->one();
                Yii::$app->mailer->compose()
                ->setFrom('rickz.avenger@gmail.com')
                ->setTo($datasatu['email'])
                ->setSubject('Email Validasi')
                ->setHtmlBody('Terima kasih anda telah mendaftar di sini')
                ->send();
            return array('status'=> true,'data'=>'berhasil');
        } else {
            return array('status'=> false,'data'=>$model->getErrors());
        }*/
    }

    public function actionGettransaksi(){
        //header("Content-Type:application/json");
        $datass = Transaksi::find()->asArray()->all();
        return json_encode(array('res'=>$datass));
    }

    public function actionUbah($id){
    	$post = Yii::$app->request->post();
    	$create = Transaksi::findOne($id);
            foreach ($post as $key => $value) {
                $create->$key = $value;
            }
    	$create->save();
        	if($create->validate()){
                return array('status'=> true,'data'=>'berhasil');
            }else{
                return array('status'=> false,'data'=>$create->getErrors());
            }
    }
}