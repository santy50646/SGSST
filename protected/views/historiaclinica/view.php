<?php
/* @var $this HistoriaclinicaController */
/* @var $model Historiaclinica */

$this->breadcrumbs=array(
	'Historias clinicas'=>array('index'),
	$model->Id,
);

$this->menu=array(
	#array('label'=>'Lista de Historias clinicas', 'url'=>array('index')),
	#array('label'=>'Create Historiaclinica', 'url'=>array('create')),
	array('label'=>'Actualizar Historia clinica', 'url'=>array('update', 'id'=>$model->Id)),
	array('label'=>'Eliminar Historia clinica', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Id),'confirm'=>'Seguro que desea eliminar esta historia clinica?')),
	#array('label'=>'Manage Historiaclinica', 'url'=>array('admin')),
	#array('label'=>'Examen de ingreso vs Examen de egreso', 'url'=>array('view2','id'=>$model->Id)),
	
);
?>

<h1><font color="#336699">Historia clinica de:</font><font color="black"> <?php echo $model->getNombreTrabajador($model->Cedula_trabajador); ?></font></h1>

<?php 
		if ($this->getExamenIngreso($model->Id) == true) 
		{
			Yii::app()->user->setFlash("warning","Se debe realizar un examen de ingreso");
		}
		if($this->getExamenRealizacionEspecifico($model->Id) == true)
		{
			Yii::app()->user->setFlash("warning","Se debe realizar un examen periodico");
		} 
	?>


<!--
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Id',
		'Descripcion',
		'Cedula_trabajador',
	),
)); ?>-->

<table class="table table-bordered table-striped">
	<tr>
		<td><strong><font color="#336699">Descripción</font></strong></td>
		<td><?php echo $model->Descripcion ?></td>		
	</tr>
	<tr>
		<td><strong><font color="#336699">Cedula del trabajador</font></strong></td>
		<td><?php echo CHtml::link($model->Cedula_trabajador,array('trabajador/view&id='.$model->Cedula_trabajador)) ?></td>
		
	</tr>
</table>


<h2><font color="#336699">Lista de examenes</font></h2>

<?php echo CHtml::submitButton('Crear examen', array('submit'=>array('examenes/create'),"class"=>"btn btn-inverse btn-medium")); ?>   
<?php echo CHtml::submitButton('Examen ingreso Vs Examen egreso', array('submit'=>array('historiaclinica/view2&id='.$model->Id),"class"=>"btn btn-inverse btn-medium")); ?>
<br> 
<br>

<table class="table table-bordered table-striped">
	
	<tr>
		<td> <strong><font color="#336699">Tipo</font></strong></td>
		<td><strong><font color="#336699">Fecha</font></strong></td>
		<td><strong><font color="#336699">Descripción</font></strong></td>
		<td><strong><font color="#336699">Diagnostico</font></strong></td>
	</tr>
	<?php foreach ($model->examenes as $examen)	: ?>

		<tr>			
			<td> <?php  echo CHtml::link($examen->Tipo, array('examenes/view&id='.$examen->id)) ?></td>
			<td> <?php  echo $examen->Fecha ?></td>
			<td> <?php  echo $examen->Descripcion ?></td>
			<td> <?php  echo $examen->Diagnostico ?></td>
		</tr>

	<?php  endforeach; ?>
	
</table>	
	



