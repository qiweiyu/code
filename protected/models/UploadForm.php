<?php
class UploadForm extends CFormModel
{
	public $name;
	public $codefile;

	public $md5;
	
	public function rules()
	{
		return array(
			array('name, codefile', 'required'),
			array('name', 'isUniqueName'),
			array('codefile', 'file', 'types'=>'php, zip', 'maxSize'=>1024 * 1024 * 20, 'tooLarge'=>'File has to be smaller than 20MB'),
			array('codefile', 'isUniqueFile'),
		);
	}
	public function attributeLabels()
	{
		return array(
			'codefile'=>'File',
		);
	}
	public function isUniqueName($attribute,$params)
	{
		if(Code::model()->find('name=:name', array('name'=>$this->name))) $this->addError('name', 'This name is exists!');
	}

	public function isUniqueFile($attribute,$params)
	{
		$this->md5 = md5_file($this->codefile->tempName);
		if(Code::model()->find('md5=:md5', array('md5'=>$this->md5))) $this->addError('codefile', 'This file is exists!');
	}
}
