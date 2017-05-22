<?php 
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\TransaksiForm;
use app\models\Transaksi;
use app\models\TransaksiSearch;

class TransaksiController extends Controller
{
	public function actionTambah()
    {
        $model = new Transaksi();
        
        return $this->render('tambah', [
            'model' => $model,
        ]);
    }

    public function actionIndex()
    {
        $searchModel = new TransaksiSearch();
        $model = new TransaksiForm();
        $dataProvider = $searchModel->search();
        if (Yii::$app->request->post('TransaksiForm')) {
            $dataProvider = $searchModel->search(Yii::$app->request->post('TransaksiForm'));
        }
        /*$data = file_get_contents('http://localhost/transact/web/services/gettransaksi');
        $data = json_decode($data, true);
        return $this->render('_index', [
            //'searchModel' => $searchModel,
            'dataProvider' => $data,
            'model' => $model,
            ]);*/
        return print_r($dataProvider);
        
    }

    
}