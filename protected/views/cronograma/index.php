<?php
/* @var $this CronogramaController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Cronogramas',
);

$this->menu=array(
	array('label'=>'Crear Cronograma', 'url'=>array('create')),
	array('label'=>'Administrar Cronogramas', 'url'=>array('admin')),
);
?>

<h1>Cronogramas</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>