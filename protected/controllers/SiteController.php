<?php

class SiteController extends Controller
{
	public function filters()
	{
		return array(
			'accessControl',
		);
	}
	public function accessRules()
	{
		return array(
			array(
				'deny',
				'actions'=>array('upload'),
				'expression' => '$user->isGuest',
			),
		);
	}
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$model=new Code('search');
		$this->render('index', array(
			'model'=>$model,
		));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

	public function actionUpload()
	{
		$model = new UploadForm;
		if(isset($_POST['UploadForm']))
		{
			$model->attributes=$_POST['UploadForm'];
	        $model->codefile=CUploadedFile::getInstance($model,'codefile');
	        if($model->validate())
			{
				$codeModel = new Code;
				$codeModel->name=$model->name;
				$codeModel->md5 =$model->md5;
				$codeModel->codefile = $model->codefile;
				$codeModel->save();
				$this->redirect(array('view', 'id'=>$codeModel->id));
			}
        }
		$this->render('upload',array('model'=>$model));
	}

	public function actionView($id=null)
	{
		if($id != null)
			$model = Code::model()->findByPk($id);
		else
			$model = null;
		if($model)
		{
			$this->pageTitle = Yii::app()->name.' - View '.$model->name;
			$this->render('view', array('model'=>$model));
		}
		else
			$this->actionIndex();
	}
	public function actionDownload($id=null)
	{
		if($id != null)
			$model = Code::model()->findByPk($id);
		else
			$model = null;
		if($model)
		{
			header('Content-Disposition: attachment; filename="'.$model->filename.'"'); 
			header("Content-type: application/force-download");
			readfile($model->savePath.$model->filename);
		}
		else
			$this->actionIndex();
	}
	public function actionLoadDir($id=null, $path=null)
	{
		if($id != null)
			$model = Code::model()->findByPk($id);
		else
			$model = null;
		if($model && $path && is_dir($model->sourcePath.$path))
		{
			$isSafe = $model->isSafePath($path);
		}
		else
			$isSafe = false;
		if($isSafe)
		{
			echo json_encode($model->listDir($path));
		}
		else
			throw new CHttpException(404);
	}
	public function actionViewFile($id=null, $path=null)
	{
		if($id != null)
			$model = Code::model()->findByPk($id);
		else
			$model = null;
		if($model && $path)
		{
			$isSafe = $model->isSafePath($path);
		}
		else
			$isSafe = false;
		if($isSafe && !is_dir($model->sourcePath.$path))
		{
			$this->layout = '//layouts/view';
			$pathinfo = pathinfo($model->sourcePath.$path);
			if(isset($pathinfo['extension']))
			{
				switch($pathinfo['extension'])
				{
					case 'php':
					case 'js':
					case 'css':
					case 'html':
						$type = $pathinfo['extension'];
						break;
					default:
						$type = false;
				}
			}
			else
			{
				$type = false;
			}
			$this->render('file', array('type'=>$type, 'content'=>CHtml::encode(file_get_contents($model->sourcePath.$path))));
		}
		else
			throw new CHttpException(404);
	}
}
