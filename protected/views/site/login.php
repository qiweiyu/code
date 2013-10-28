<?php
/* @var $this SiteController */
/* @var $model LoginForm */

$this->pageTitle=Yii::app()->name . ' - Login';
?>

<div class="col-md-6 col-md-offset-3">
<div class="alert alert-info">
If you need an account, please send an email to <a href="mailto:qi@weiyu.me">qi@weiyu.me</a>.
</div>
<?php $form=$this->widget('BsVForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'model'=>$model,
	'items'=>array(
		'username',
		array(
			'name'=>'password',
			'type'=>'passwordField',
		),
		array(
			'name'=>'Login',
			'type'=>'submit',
		),
	),
)); ?>
</div><!-- form -->
