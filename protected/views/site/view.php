<div class="col-md-2" style="position:fixed;" id="dir">
	<div class="panel panel-default">
		<div class="panel-heading"><?php echo CHtml::encode($model->name); ?>
			<?php echo CHtml::link('', array('download', 'id'=>$model->id), array('class'=>'glyphicon glyphicon-save', 'target'=>'_blank', 'title'=>'Download', 'style'=>'float:right;padding:0px;')); ?>
		</div>	
		<div class="panel-body" style="padding:0px;overflow:scroll;width:100%;">
			<?php $this->widget('BsDirTree', array(
				'name'=>$model->name,
				'items'=>$model->listDir(),
				'loadDirUrl'=>Yii::app()->controller->createUrl('loadDir', array('id'=>$model->id)),
			)); ?>
		</div>
	</div>
</div>
<div class="col-md-10 col-md-offset-2" style="padding-left:30px;">
</div>
<script type="text/javascript">
$(document).ready(function(){
	modifyHeight();
	$(window).resize(function(){modifyHeight()});
});
function modifyHeight()
{
	$('#dir').height($(document).height()-$('#dir').position().top-20);
	$('#dir .panel').height($('#dir').height());
	$('#dir .panel-body').height($('#dir').height()-$('#dir .panel-body').position().top);
}
</script>
