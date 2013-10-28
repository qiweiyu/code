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
				'clickFile'=>'clickTab',
			)); ?>
		</div>
	</div>
</div>
<div class="col-md-10 col-md-offset-2" style="padding-left:3%;">
	<ul class="nav nav-tabs" id="file">
	</ul>
	<div class="tab-content" id="file-tab">
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	modifyHeight();
	$(window).resize(function(){modifyHeight()});
});
function modifyHeight()
{
	$('#dir').height($(document).height()-$('#dir').position().top-60);
	$('#dir .panel').height($('#dir').height());
	$('#dir .panel-body').height($('#dir').height()-$('#dir .panel-body').position().top);
	$('#file-tab').height($('#dir').height()-$('#file').height());
}
function addTab(node, path)
{
	var t = new Date();
	var id = "tab_"+t.getTime();
	node.attr('tab-id', id);
	$('<div class="tab-pane" id="'+id+'"><iframe frameborder=0 width="100%" height="100%" src="<?php echo Yii::app()->controller->createUrl('viewFile', array('id'=>$model->id))?>&path='+path+'"></iframe></div>').appendTo('#file-tab');
	$('<li><a href="#'+id+'" title="'+path+'"><span class="closePage pull-right badge clearCloseStyle">&times;</span><span class="title">'+node.html()+'</span></a></li>').appendTo('#file');
	$('#file a').unbind().click(function (e) {
		e.preventDefault();
		$(this).tab('show');
	});
	$('#file span.closePage').unbind().hover(
		function(e){
			$(this).removeClass('clearCloseStyle');
		},
		function(e){
			$(this).addClass('clearCloseStyle');
		}).click(function(){
			if($(this).parent().parent().hasClass('active'))
			{
				if($(this).parent().parent().prev().size())
				{
 					$(this).parent().parent().prev().find('a').click();
				}
 				else if($(this).parent().parent().next().size())
				{
					$(this).parent().parent().next().find('a').click();
				}
			}
 			$('#file-tab').find($(this).parent().attr('href')).remove();
			$(this).parent().parent().remove();
			modifyHeight();
		}
	);
	$('#file a[href=#'+id+']').click();
	modifyHeight();
}
function clickTab(node, path)
{
	if(node.attr('tab-id') && $('#'+node.attr('tab-id')).size()) $('#file a[href=#'+node.attr('tab-id')+']').click();
	else addTab(node, path);
}
</script>
