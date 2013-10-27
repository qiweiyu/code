<?php
Yii::import('zii.widgets.grid.CButtonColumn');
class BsButtonColumn extends CButtonColumn
{
	public function init()
	{
		$this->viewButtonOptions['class'] = 'btn btn-info glyphicon glyphicon-info-sign';
		$this->updateButtonOptions['class'] = 'btn btn-warning glyphicon glyphicon-pencil';
		$this->deleteButtonOptions['class'] = 'btn btn-danger glyphicon glyphicon-remove';
		parent::init();
	}	
	protected function renderDataCellContent($row, $data)
	{
		echo CHtml::openTag('div', array('class'=>'btn-group'));
		parent::renderDataCellContent($row, $data);
		echo CHtml::closeTag('div');
	}
	protected function renderButton($id,$button,$row,$data)
        {
                if (isset($button['visible']) && !$this->evaluateExpression($button['visible'],array('row'=>$row,'data'=>$data)))
                          return;
                $label=isset($button['label']) ? $button['label'] : $id;
                $url=isset($button['url']) ? $this->evaluateExpression($button['url'],array('data'=>$data,'row'=>$row)) : '#';
                $options=isset($button['options']) ? $button['options'] : array();
                if(!isset($options['title']))
                        $options['title']=$label;
		echo CHtml::link('',$url,$options);
	}
}
