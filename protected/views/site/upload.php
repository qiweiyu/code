<?php
$this->pageTitle=Yii::app()->name . ' - Upload';
?>
<div class="col-md-6 col-md-offset-3">
<div class="alert alert-info">
You can only upload a single <b>PHP</b> file or a <b>ZIP</b> file. The maxium file size allowed is 20MB.
</div>
<?php $form=$this->widget('BsVForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions'=>array('enctype'=>"multipart/form-data"),
	'model'=>$model,
	'items'=>array(
		'name',
		array(
			'name'=>'codefile',
			'type'=>'fileField',
		),
		array(
			'name'=>'Upload',
			'type'=>'submit',
		),
	),
)); ?>
