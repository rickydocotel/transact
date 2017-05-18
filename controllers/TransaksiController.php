<?php 
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\TransaksiForm;
use app\models\TransaksiSearch;

class TransaksiController extends Controller
{
	public function actionTambah()
    {
        $model = new TransaksiForm();
        if ($model->load(Yii::$app->request->post())) {
            TransaksiForm::tambah(Yii::$app->request->post('TransaksiForm'));
        }
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
        return $this->render('_index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            ]);
        
    }

    
}