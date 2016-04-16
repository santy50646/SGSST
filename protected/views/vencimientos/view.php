<?php
/* @var $this VencimientosController */
/* @var $model Vencimientos */

$this->breadcrumbs=array(
	'Insumos'=>array('index'),
	$model->Nombre,
);

$this->menu=array(
	array('label'=>'Lista de insumos', 'url'=>array('index')),
	#array('label'=>'Crear insumo', 'url'=>array('create')),
	array('label'=>'Actualizar insumo', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar insumo', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Seguro que desea eliminar este insumo?')),
	#array('label'=>'Manage Vencimientos', 'url'=>array('admin')),
);
?>

<h1><font color="#336699">Insumo: </font><font color="black"><?php echo $model->Nombre; ?></font></h1>
<!--
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'Nombre',
		'fecha_Vencimiento',
		'Instrucciones',
		'estado',
		'Cedula_Trabajador',
	),
)); ?>

-->

<?php 
$date1=date('Y-m-d');
#echo "----".strtotime($date1);
#echo "<br>";
$date2=$model->fecha_Vencimiento;
#echo "----".strtotime($date2);
#echo "<br>";

if(strtotime($date1)>=strtotime($date2))
{
	Yii::app()->user->setFlash("warning","Este insumo esta vencido");
	$estado=1;
	$model->cambiarEstado($model->id,$estado);
}
else
{
	$estado=0;
	$model->cambiarEstado($model->id,$estado); 
}
?>

<table class="table table-bordered table-striped">
	<tr>
		<td><strong><font color="#336699">Id</font></strong></td>
		<td><?php echo $model->id ?></td>		
	</tr>
	<tr>
		<td><strong><font color="#336699">Nombre</font></strong></td>
		<td><?php echo $model->Nombre ?></td>
		
	</tr>
	<tr>
		<td><strong><font color="#336699">fecha de vencimiento</font></strong></td>
		<td><?php echo $model->fecha_Vencimiento ?></td>
	</tr>
	<tr>
		<td><strong><font color="#336699">Instrucciones de uso</font></strong></td>
		<td><?php echo $model->Instrucciones ?></td>
	</tr>
	<tr>
		<td><strong><font color="#336699">Responsable</font></strong></td>
		<td><?php echo CHtml::link($model->getNombreTrabajador($model->Cedula_Trabajador),array('trabajador/view&id='.$model->Cedula_Trabajador)) ?></td>
	</tr>

</table>

