<?php
namespace app\web\common;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\data\ActiceDataProvider;

class ApiController extends Controller{
	public $modelClass;
	public $params;
	private $data;
	private $code;
	
	public function init(){
		//set response format
		Yii::$app->response->format='json';

		if($this->modelClass !== null){
			$this->modelClass = new $this->modelClass;
			$this->params = Yii::$app->request->get();
			
		}else{
			throw new ServerErrorHttpException('model not exists');
		}
	}

	//getlist
	public function actionGetList(){
		$this->data = $this->modelClass->find()->asArray()->orderby('id asc')->offset(0)->limit(100)->all();
	}

	//findone
	public function actionGetone(){
		$this->data = $this->modelClass->findOne(Yii::$app->request->get('id'));
	}

	//created
	public function actionCreated(){
		$this->modelClass->load($this->params,'');
		$this->code = ($this->data = $this->modelClass->insert() === true)?200:201;
	}
	
	//delete
	public function actionDelete(){
		$model= $this->modelClass->findOne(Yii::$app->request->get('id'));	
		if($model=== null){
			throw new NotFoundHttpException;
		}else{
			$this->data = $model->delete() === 1 ? true:[];
			if($this->data === [])
				   $this->code = 201;
		}	
	}

	//modify
	public function actionModify(){
		$model = $this->modelClass->findOne(Yii::$app->request->get('id'));
	
		if($model === null)
			throw new NotFoundHttpException;

		if( $model->load(Yii::$app->request->get(),'') && $model->save()){
			$this->data = true;	
		}else{
			$this->data=[];
		}
	}


	public function afterAction($action,$result){
		$data = isset($this->data)?$this->data:[];
	    $code = isset($this->code)?$this->code:200;
		Yii::$app->response->setStatusCode($code);
		Yii::$app->response->data = $data; 
		Yii::$app->response->send();
	}

}
?>
