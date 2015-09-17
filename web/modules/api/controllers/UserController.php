<?php

namespace app\web\modules\api\controllers;

use Yii;
use app\web\common\ApiController; 
use yii\base\Module; 

class UserController extends ApiController
{
	public $defaultAction='getlist';
	public $modelClass = 'app\models\User';

	public function actionGetlist(){parent::actionGetlist();} 
	public function actionGetone(){parent::actionGetone();} 
	public function actionCreate(){parent::actionCreate();} 
	public function actionDelete(){parent::actionDelete();} 
	public function actionModify(){parent::actionModify();} 
}
