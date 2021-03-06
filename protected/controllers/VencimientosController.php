<?php

class VencimientosController extends Controller
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
			/*array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),*/
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','enabled','delete','admin','index','view'),
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
		$model=new Vencimientos;

		// Uncomment the following line if AJAX validation is needed

		if(isset($_POST['Vencimientos']))
		{

			$date1=date('Y-m-d');
			$date2=$model->fecha_Vencimiento;

			if(strtotime($date1)>=strtotime($date2) )
			{
				$model->estado=1;
			}
			else
			{
				$model->estado=0;
			}
			$model->attributes=$_POST['Vencimientos'];

			
			if($model->save())
			{
				Yii::app()->user->setFlash("success","El insumo se creó exitosamente");
				$this->redirect(array('view','id'=>$model->id));
			}
			else
			{
				Yii::app()->user->setFlash("error","El insumo no se creó exitosamente");
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

		if(isset($_POST['Vencimientos']))
		{
			$model->attributes=$_POST['Vencimientos'];
			if($model->save())
			{
				Yii::app()->user->setFlash("success","El insumo se actualizó exitosamente");
				$this->redirect(array('view','id'=>$model->id));
			}
			else
			{
				Yii::app()->user->setFlash("error","El insumo no se actualizó exitosamente");
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
			Yii::app()->user->setFlash("success","El insumo se eliminó exitosamente");
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
		{
			Yii::app()->user->setFlash("success","El insumo no se eliminó exitosamente");
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Vencimientos');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Vencimientos('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Vencimientos']))
		{
			$model->attributes=$_GET['Vencimientos'];
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Vencimientos the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Vencimientos::model()->findByPk($id);
		if($model===null)
		{
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Vencimientos $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='vencimientos-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	/**
		PErmite cambiar el estado del insumo que corresponde al id ingresado por parametro.
	*/
	public function actionEnabled($id)
	{

		$model=Vencimientos::model()->findByPk($id);
		
		if($model->estado==0)
		{
			$model->estado=1;
		}
		else
		{
			$model->estado=0;
		}
		$model->save();
		$this->redirect(array("index"));
	}
	/**
		Retorna true si algun insumo se encuentra vencido, es decir, si su fecha de caducidad expiro.
	*/
	public function getVencidos()
	{
		$insumos= Vencimientos::model()->findAll();

		foreach ($insumos as $insumo)
		{
			if($insumo->vencido)
			{
				return true;
			}
		}
		return false;
	}
	/**
		Retorna el porcentaje de todos los insumos que se encuentran vencidos.
	*/
	public function getMetricaGeneral()
	{
		$insumos= Vencimientos::model()->findAll();
		$metricaRealizacion=0;
		$numeroInsumos=0;
		$insumosVencidos=0;

		foreach ($insumos as $insumo)
		 {
		 	$numeroInsumos++;
			if($insumo->estado == 1)
			{
				$insumosVencidos++;
			}
		}
		return $metricaRealizacion=($insumosVencidos*100)/$numeroInsumos;		
	}

	

	
}
