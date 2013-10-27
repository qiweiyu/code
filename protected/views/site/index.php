<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<?php $this->widget('BsGridView', array(
	'id'=>'grid',
	'dataProvider'=>$model->search(),
	'filter'=>null,
	'columns'=>array(
		'name',
		'filename',
		'md5',
		array(
			'class'=>'BsButtonColumn',
			'buttons'=>array(
				'open'=>array(
					'label'=>'View',
					'url'=>'Yii::app()->controller->createUrl("view", array("id"=>$data->id))',
					'options'=>array('class'=>'btn glyphicon glyphicon-folder-open'),
				),
				'download'=>array(
					'label'=>'Download',
					'url'=>'Yii::app()->controller->createUrl("download", array("id"=>$data->id))',
					'options'=>array('class'=>'btn glyphicon glyphicon-save', 'target'=>'_blank'),
				),
			),
			'template' => '{open}{download}',
		),
	),
)); ?>
