<?php
/* @var $this TrabajadorController */
/* @var $model Trabajador */

$this->breadcrumbs=array(
	'Trabajadores'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Lista de Trabajadores', 'url'=>array('index')),
);
?>

<h1><font color="#336699">Crear Trabajador</font></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>