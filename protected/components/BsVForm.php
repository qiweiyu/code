<?php
class BsVForm extends CActiveForm
{
	public $items;
	public $model;
	public function init()
	{
		$this->htmlOptions['class']='form-horizontal';
		parent::init();
	}
	public function run()
	{
		echo $this->errorSummary($this->model);
		foreach($this->items as $v)
		{
			$this->renderBsField($v);
		}
		parent::run();
	}
	protected function renderBsField($v)
	{
		if(is_array($v) && isset($v['visible']) && ($v['visible'] == false)) return;
		if(!is_array($v))
		{
			$v = array('name'=>$v);
		}
		$class = 'form-group';
		if($this->model->getError($v['name'])) $class = $class.' has-error';
		echo CHtml::openTag('div', array('class'=>$class));
		$model = $this->model;
		$labelHtmlOptions = array('class'=>'col-sm-2 control-label');
		$fieldHtmlOptions = array('class'=>'col-sm-10');
		$v['type'] = $type = isset($v['type'])?$v['type']:'textField';
		$v['label'] = isset($v['label'])?$v['label']:$v['name'];
		$htmlOptions = array('class'=>'form-control');
		if(!(isset($v['placeholder']) && ($v['placeholder']==false)))
			$htmlOptions['placeholder'] = isset($v['placeholder'])?$v['placeholder']:$model->getAttributeLabel($v['name']);
		if($type=='submit')
		{
			$this->renderSubmit($v['name']);
		}
		else if($type == 'dropDownList')
		{
			$this->renderDropDownList($v, $labelHtmlOptions, $fieldHtmlOptions);
		}
		else
		{
			echo $this->label($model,$v['label'],$labelHtmlOptions);
			echo CHtml::openTag('div', $fieldHtmlOptions);
			if(isset($v['htmlOptions']))
			{
				$htmlOptions = $htmlOptions+$v['htmlOptions'];
			}
			echo $this->$v['type']($model,$v['name'], $htmlOptions);
			echo CHtml::closeTag('div');
		}
		echo CHtml::closeTag('div');
	}
	protected function renderSubmit($name)
	{
			echo CHtml::openTag('div', array('class'=>'col-sm-offset-2 col-sm-10'));
			echo CHtml::tag('button', array('type'=>'submit', 'class'=>'btn btn-default'), L::f($name));
			echo CHtml::closeTag('div');
	}
	protected function renderDropDownList($v, $labelHtmlOptions, $fieldHtmlOptions)
	{
		$model = $this->model;
		echo $this->label($model,$v['label'],$labelHtmlOptions);
		echo CHtml::openTag('div', $fieldHtmlOptions);
		$htmlOptions = array('class'=>'form-control');
		if(isset($v['htmlOptions']))
		{
			$htmlOptions = $htmlOptions+$v['htmlOptions'];
		}
		echo $this->$v['type']($model,$v['name'], $v['options'], $htmlOptions);
		echo CHtml::closeTag('div');
		echo $this->error($model,$v['name']);
	}
	public function errorSummary($models, $header=NULL, $footer=NULL, $htmlOptions=array ( ))
	{
		$htmlOptions = $htmlOptions+array('class'=>'alert alert-danger');
		return parent::errorSummary($models, $header, $footer, $htmlOptions);
	}
}
