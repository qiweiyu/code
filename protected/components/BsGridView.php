<?php
Yii::import('zii.widgets.grid.CGridView');
class BsGridView extends CGridView
{
	public $cssFile = false;
	public function init()
	{
		$this->itemsCssClass='table table-striped table-hover';
		parent::init();
	}
}
