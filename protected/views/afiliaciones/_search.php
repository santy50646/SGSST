<?php
/* @var $this AfiliacionesController */
/* @var $model Afiliaciones */
/* @var $form CActiveForm */
?>
<!-- search-form -->
<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div >
		<?php echo $form->label($model,'Id'); ?>
		<?php echo $form->textField($model,'Id'); ?>
	</div>

	<div >
		<?php echo $form->label($model,'Nombre'); ?>
		<?php echo $form->textField($model,'Nombre',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div >
		<?php echo $form->label($model,'Descripcion'); ?>
		<?php echo $form->textField($model,'Descripcion',array('size'=>60,'maxlength'=>300)); ?>
	</div>
	<div>
		<?php echo CHtml::submitButton('Buscar',array("class"=>"btn btn-primary btn-medium")); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->