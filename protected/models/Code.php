<?php

/**
 * This is the model class for table "code".
 *
 * The followings are the available columns in table 'code':
 * @property string $id
 * @property string $name
 * @property string $filename
 * @property string $md5
 * @property string $path
 */
class Code extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $codefile;

	public function tableName()
	{
		return 'code';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, filename, md5, path', 'required'),
			array('name', 'length', 'max'=>240),
			array('filename', 'length', 'max'=>255),
			array('md5', 'length', 'max'=>32),
			array('path', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, filename, md5, path', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'filename'=> 'File Name',
			'md5' => 'Md5',
			'path' => 'Path',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria(array('order'=>'id desc'));

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('filename',$this->filename,true);
		$criteria->compare('md5',$this->md5,true);
		$criteria->compare('path',$this->path,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Code the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function beforeValidate()
	{
		if(parent::beforeValidate())
		{
			do
			{
				$length = 20;
				$chars = array_merge(range(0,9), range('a','z'), range('A','Z'));
				shuffle($chars);
				$path = implode(array_slice($chars, 0, $length));
			}while($this::model()->find('path=:path', array('path'=>$path)));
			$this->path = $path;
			$this->filename = $this->codefile->name;
		}
		return true;
	}
	public function afterSave()
	{
		$this->saveFile();
		return true;
	}
	public function isSafePath($path)
	{
		$path = urldecode($path);
		if((strstr($path, './')===false) && (strstr($path, '.\\')===false) && (strstr($path, '..')===false))
		{
			return file_exists($this->sourcePath.$path);
		}
		return false;
	}
	public function listDir($path = null)
	{
		
		if($path != null)
			$isSafe = $this->isSafePath($path);
		else
			$isSafe = true;
		if($isSafe == false) return array();
		$dirPath = $this->sourcePath.$path.'/';
		$list = scandir($dirPath);
		array_shift($list);
		array_shift($list);
		$return = array();
		foreach($list as $k=>$v)
		{
			$return[$k] = array('name'=>$v, 'dir'=>is_dir($dirPath.$v));
		}
		return $return;
	}
	public function saveFile()
	{
		mkdir($this->savePath);
		mkdir($this->sourcePath);
		$this->codefile->saveAs($this->savePath.$this->filename);
		$this->{'save'.strtoupper($this->codefile->extensionName)}();
		return true;
	}
	public function getSavePath()
	{
		return Yii::app()->basePath.'/code/'.$this->path.'/';
	}
	public function getSourcePath()
	{
		return $this->savePath.'/source/';
	}
	protected function savePHP()
	{
		copy($this->savePath.$this->filename, $this->sourcePath.$this->filename);
		return true;
	}
	protected function saveZIP()
	{
		$zip = new ZipArchive;
		$res = $zip->open($this->savePath.$this->filename);
		$zip->extractTo($this->sourcePath);
		$zip->close();
		for(;;){
			$list = $this->listDir();
			if((count($list) == 1) && $list[0]['dir'])
			{
				rename($this->sourcePath.$list[0]['name'], $this->savePath.'tmp');
				rmdir($this->sourcePath);
				rename($this->savePath.'tmp', $this->sourcePath);
			}
			else
			{
				break;
			}
		}
		return true;
	}
}
