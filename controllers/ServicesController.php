<?php

namespace app\controllers;
use Yii;
use yii\rest\Controller;
use yii\web\Response;
use app\models\Transaksi;

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
//                    'update' => ['get', 'put', 'post'],
//                    'delete' => ['post', 'delete'],
                ],
            ],
            [
                'class' => 'yii\filters\ContentNegotiator',
                'only' => ['tambah','ubah'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
        ];
    }

    public function actionTambah(){
    	$post = Yii::$app->request->post();
    	$create = new Transaksi();
        $create->attributes=$post;
    	$create->save();
        	if($create->validate()){
        		return array('status'=> true,'data'=>'berhasil');
        	}else{
                return array('status'=> false,'data'=>$create->getErrors());
        	}
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