<?php
class BsDirTree extends CWidget
{
	public $name;
	public $items;
	public $loadDirUrl;

	public function init()
	{
		$css = '
			ul#'.$this->id.'{
				padding-left:10px;
			}
			#'.$this->id.' ul{
				padding-left:16px;
			}
			#'.$this->id.' li{
				list-style:none;
				margin:5px 0px;
			}
			#'.$this->id.' span{
				cursor:pointer;
			}
			#'.$this->id.' .glyphicon-folder-open{
				color:#ED9C28;
			}
			#'.$this->id.' .glyphicon-file{
				color:#47A447;
			}
			#'.$this->id.' .loading{
				color:#39B3D3;
			}
		';
		Yii::app()->clientScript->registerCss($this->id, $css);
		$js = '
		function '.$this->id.'_init()
		{
			$("#'.$this->id.' .file").unbind().click(function(){'.$this->id.'_clickFile($(this));});
			$("#'.$this->id.' .dir").unbind().click(function(){'.$this->id.'_clickDir($(this));});
		}
		function '.$this->id.'_clickDir(node)
		{
			if(node.hasClass("glyphicon-folder-open"))
			{
				node.removeClass("glyphicon-folder-open");
				node.addClass("glyphicon-folder-close");
				node.parent().find("ul").eq(0).hide();
			}
			else
			{
				if(node.parent().find("ul").size())
				{
					node.removeClass("glyphicon-folder-close");
					node.addClass("glyphicon-folder-open");
					node.parent().find("ul").eq(0).show();
				}
				else '.$this->id.'_loadDir(node);
			}
		}
		function '.$this->id.'_clickFile(node)
		{
		}
		function '.$this->id.'_loadDir(node)
		{
			var url = "'.$this->loadDirUrl.'&path="+escape('.$this->id.'_findPath(node));
			var succ = '.$this->id.'_loadingAnimateControl(node, true);
			if(succ)
				$.getJSON(url, function(data){
					'.$this->id.'_loadingAnimateControl(node, false);
					node.addClass("glyphicon-folder-open");
					var items = [];
					$.each(data, function(key, val){
						items.push("<li><span class=\"glyphicon glyphicon-"+(val.dir?"folder-close dir":"file file")+"\">/"+val.name+"</span></li>");
					});
					node.after($("<ul>", {
    					html: items.join( "" )
					}));
					'.$this->id.'_init();	
				})
				.fail(function(){
					'.$this->id.'_loadingAnimateControl(node, false);
					node.addClass("glyphicon-folder-close");
				});
		}
		function '.$this->id.'_findPath(node)
		{
			var path = "";
			for(;;)
			{
				if(node.parent().parent().hasClass("root")) break;
				path = node.html()+path;
				node = node.parent().parent().parent().find("span").eq(0);
			}
			return path;
		}
		function '.$this->id.'_loadingAnimateControl(node, start)
		{
			if(start)
			{
				if(typeof loadingDir == "undefined") loadingDir = [];
				if($.inArray(node, loadingDir) != -1) return false;
				loadingDir[loadingDir.length] = node;
				node.removeClass("glyphicon-folder-close");
				node.addClass("glyphicon-refresh");
				if((typeof ldaTh == "undefined") || (ldaTh == 0)) '.$this->id.'_loadingAnimate();
				return true;
			}
			else
			{
				var index = $.inArray(node, loadingDir);
				if(index == -1) return false;
				node.removeClass("loading");
				node.removeClass("glyphicon-refresh");
				loadingDir.splice(index, 1);
			}
		}
		function '.$this->id.'_loadingAnimate()
		{
			if(loadingDir.length == 0){
				clearTimeout(ldaTh);
				ldaTh = 0;
				return;
			}
			for(var i = 0; i < loadingDir.length; i++)
			{
				if(loadingDir[i].hasClass("loading")) loadingDir[i].removeClass("loading");
				else loadingDir[i].addClass("loading");
			}
			ldaTh = setTimeout('.$this->id.'_loadingAnimate, 500);
		}
		$(document).ready(function(){
			'.$this->id.'_init();
		});
		';
		Yii::app()->clientScript->registerScript($this->id, $js);
	}
	public function run()
	{
			echo CHtml::openTag('ul', array('id'=>$this->id, 'class'=>'root'));
			echo CHtml::openTag('li');
			echo CHtml::openTag('span', array('class'=>'glyphicon glyphicon-folder-open dir'));
			echo '/'.CHtml::encode($this->name);
			echo CHtml::closeTag('span');
			echo CHtml::openTag('ul');
			foreach($this->items as $v)
			{
					echo CHtml::openTag('li');
					echo CHtml::openTag('span', array('class'=>'glyphicon glyphicon-'.($v['dir']?'folder-close dir':'file file')));
					echo '/'.CHtml::encode($v['name']);
					echo CHtml::closeTag('span');
					echo CHtml::closeTag('li');
			}
			echo CHtml::closeTag('ul');
			echo CHtml::closeTag('li');
			echo CHtml::closeTag('ul');
	}
}
