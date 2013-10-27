<?php
Yii::import('zii.widgets.CDetailView');
class BsTable extends CDetailView
{
	public $striped=true;
	public $hover=false;
	public function init()
	{
		$this->cssFile = false;
		parent::init();
	}
	public function run()
	{
		$this->htmlOptions['class']='table'.($this->striped?' table-striped':'').($this->hover?' table-hover':'');
		parent::run();
	}
}
