<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/bs/js/jquery.min.js" ></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/bs/js/bootstrap.min.js" ></script>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/bs/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/bs/css/main.css" />
</head>

<body>

<div class="container" id="page">

	<div class="navbar navbar-default navbar-fixed-top" role="nav">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" href="/"><?php echo CHtml::encode(Yii::app()->name); ?></a>
			</div>
			<div class="navbar-collapse collapse">
				<?php $this->widget('zii.widgets.CMenu',array(
					'htmlOptions'=>array(
						'class' => 'nav navbar-nav',
					),
					'items'=>array(
						array('label'=>'Home', 'url'=>array('/site/index')),
						array('label'=>'View', 'url'=>array('/site/view')),
						array('label'=>'New', 'url'=>array('/site/upload')),
					),
				)); ?>
				<?php $this->widget('zii.widgets.CMenu',array(
					'htmlOptions'=>array(
						'class' => 'nav navbar-nav navbar-right',
					),
					'items'=>array(
						array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
						array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
					),
				)); ?>
			</div>
		</div>
	</div>
	<div style="height:50px;margin-bottom:20px;"></div>

	<?php echo $content; ?>
	<div style="height:40px;"></div>
	<div id="footer" class="container well well-sm">
		Copyright &copy; <a href="http://qi.weiyu.me" target="_blank">Weiyu Qi</a>. Powered By <a href="http://www.yiiframework.com/" target="_blank">Yii</a>. Thanks to <a href="http://getbootstrap.com" target="_blank">Bootstrap</a>, <a href="http://glyphicons.com/" target="_blank">Glyphicons</a>, <a href="https://code.google.com/p/google-code-prettify/" target="_blank">Google-code-prettify</a>. Contact me: <a href="mailto:qi@weiyu.me">qi@weiyu.me</a>.
	</div>
</div><!-- page -->

</body>
</html>
