<?php

namespace app\controllers;

use Yii;
use app\models\Customer;
use app\models\CustomerSearch;
use app\models\City;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\Url;

/**
 * CustomerController implements the CRUD actions for Customer model.
 */
class CustomerController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Customer models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new CustomerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new Customer();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'=>$model
        ]);
    }

    /**
     * Displays a single Customer model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionAktivasi($id)
    {
        $updet = Customer::findOne($id);
        $updet->stat = 1;
        $updet->save();
        return 'Aktivasi Berhasil';
    }

    /**
     * Creates a new Customer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Customer();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
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
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Customer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Customer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Customer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Customer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Customer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    
    public function actionLists($id)
    {
        $countPosts = City::find()
                ->where(['country_id' => $id])
                ->count();
 
        $posts = City::find()
                ->where(['country_id' => $id])
                ->orderBy('id DESC')
                ->all();
 
        if($countPosts>0){
            foreach($posts as $post){
                echo "<option value='".$post->id."'>".$post->name."</option>";
            }
        }
        else{
            echo "<option>-</option>";
        }
 
    }

    public function actionListkota()
    {
       $out = [];
    if (isset($_POST['depdrop_parents'])) {
        $parents = $_POST['depdrop_parents'];
        if ($parents != null) {
            $cat_id = $parents[0];
            $data = City::find()->where(['country_id'=>$cat_id])->asArray()->all(); 
            foreach ($data as $key => $datas) {
                $out[]=["id"=>$datas["id"],"name"=>$datas["name"]];
            }
            // the getSubCatList function will query the database based on the
            // cat_id and return an array like below:
            // [
            //    ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
            //    ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
            // ]
            echo Json::encode(['output'=>$out, 'selected'=>'']);
            return;
        }
    }
    echo Json::encode(['output'=>'', 'selected'=>'']);
 
    }



}
