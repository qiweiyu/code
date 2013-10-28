<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/bs/js/jquery.min.js" ></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/bs/js/bootstrap.min.js" ></script>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/bs/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/bs/css/main.css" />
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/prettify/prettify.js" ></script>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/prettify/prettify-dark.css" />
</head>

<body>
<?php echo $content; ?>
<script type="text/javascript">
$(document).ready(function(){prettyPrint();});
</script>

</body>
</html>

