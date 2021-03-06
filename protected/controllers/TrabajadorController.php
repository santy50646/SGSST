<?php

class TrabajadorController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','admin','delete','index','view'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Trabajador;

		// Uncomment the following line if AJAX validation is needed

		if(isset($_POST['Trabajador']))
		{
			$model->attributes=$_POST['Trabajador'];
			if($this->existe($model))
			{
				Yii::app()->user->setFlash("error","Ya existe un trabajador con la cedula ".$model->Cedula);
			}
			elseif($model->save())
			{
				Yii::app()->user->setFlash("success","El trabajador se creó exitosamente");
				$this->redirect(array('view','id'=>$model->Cedula));
			}
			else
			{
				Yii::app()->user->setFlash("error","El trabajador no se creó exitosamente");
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed

		if(isset($_POST['Trabajador']))
		{
			$model->attributes=$_POST['Trabajador'];
			if($model->save())
			{
				Yii::app()->user->setFlash("success","El trabajador se actualizó exitosamente");
				$this->redirect(array('view','id'=>$model->Cedula));
			}
			else
			{
				Yii::app()->user->setFlash("success","El trabajador no se actualizó exitosamente");
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
		{
			Yii::app()->user->setFlash("success","El trabajador se eliminó exitosamente");
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
		{
			Yii::app()->user->setFlash("success","El trabajador no se eliminó exitosamente");
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Trabajador');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Trabajador('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Trabajador']))
		{
			$model->attributes=$_GET['Trabajador'];
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Trabajador the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Trabajador::model()->findByPk($id);
		if($model===null)
		{
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Trabajador $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='trabajador-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	/**
		Permite verificar si existen mensajes sobre los examenes pendientes del trabajador.
	*/
	public function tieneExamenes($cedula)
	{
		$trabajador=$this->loadModel($cedula);
		$trabajador->getMensaje();
	}
	/**
		Permite verificar por medio de la Cedula si el trabajador a crear ya existe como registro en la base de datos.
	*/
	public function existe($modelo)
	{
		$trabajadores= Trabajador::model()->findAll();
		foreach ($trabajadores as $trabajador)
		{
			if($trabajador->Cedula == $modelo->Cedula)
			{
				return true;
			}
		}
		return false;
	}
}
