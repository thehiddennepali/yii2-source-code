<?php

namespace file\models;

use yii\base\Behavior;
use yii\base\Event;
use yii\base\Exception;
use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\AttributeBehavior;
use yii\helpers\Html;
use yii\web\UploadedFile;
use yii\db\Expression;
use yii\web\Request;

/**
 * This is the model class for table "file".
 *
 * @property integer $id
 * @property integer $model_id
 * @property string $model_name
 * @property string $title
 * @property string $file_name
 * @property string $dir
 * @property string $shortModelName
 * @property integer $type
 * @property string $icon
 * @property string $typeText
 * @property string $uploadFolder
 * @property array $allTypeValues
 *
 * @property ActiveRecord $model
 */
class File extends ActiveRecord
{
    use FileTrait {
        //getIcon as getIconTrait;
    }


    const TYPE_DOC = 20;
    const TYPE_AUDIO = 30;
    public $typeValues = [
        self::TYPE_DOC=>'Doc file',
        self::TYPE_AUDIO=>'Audio file',
    ];
    public function getTypeText()
    {
        return isset($this->allTypeValues[$this->type]) ? $this->allTypeValues[$this->type]:$this->type;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%file}}';
    }
    public static function find()
    {
        return new query\FileQuery(get_called_class());
    }



    public static function create($parentModel, UploadedFile $attribute, $options=[])
    {
        /* @var $model File */
        $model = new static();
        $model->model_name=get_class($parentModel);
        $model->model_id=$parentModel->id;
        $model->fileAttribute=$attribute;
        Yii::configure($model, $options);
        if($model->save())
            return true;
        else
            throw new Exception(Html::errorSummary($model, ['header'=>false]));
    }

    public function getUploadFolder()
    {
        if(isset(Yii::$app->params['uploadFolder']))
            return Yii::$app->params['uploadFolder'];
        return "upload";
    }
    public function init()
    {
        $this->on(static::EVENT_BEFORE_DELETE, [$this, 'deleteFile']);
        $this->on(static::EVENT_AFTER_INSERT, [$this, 'saveFile']);
        $this->on(static::EVENT_AFTER_UPDATE, [$this, 'saveFile']);

        $this->baseUrl = Yii::$app->urlManagerFrontend->hostInfo;

        $this->path=Yii::getAlias('@frontend').'/web/'.$this->uploadFolder;
        $this->path_tmp=Yii::getAlias('@frontend').'/web/tmp';


        parent::init();
    }
    public function behaviors()
    {
        return [
            [
                'class' => AttributeBehavior::className(),
                'attributes'=>[
                    self::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                ],
                'value' => function (Event $event) {
                    /* @var $model self */
                    //$model = $event->sender;
                    return date('Y-m-d H:i:s');
                },
            ],
        ];
    }

    public function copy($url, $tmpName="justTmpFileName")
    {
        $tmp_file = $this->path_tmp.'/'.$tmpName.'.'.pathinfo($url, PATHINFO_EXTENSION);
        if(copy($url, $tmp_file , stream_context_create( ["ssl" => ["verify_peer"=> false, "verify_peer_name" => false]] )))
            return $tmp_file;
        else
            throw new Exception("File failed to copy.");
    }
    public function saveFile()
    {
        if($this->fileAttribute)
        {
            if(!is_dir($this->dir))
                mkdir($this->dir);

            $this->file_name = md5(rand(100,999)).'.'.$this->fileAttribute->extension;
            $this->title = $this->fileAttribute->name;
            $this->updateAttributes(['file_name'=>$this->file_name, 'title'=>$this->title,]);


            if($_FILES===[]){
                $copy = copy($this->fileAttribute->tempName, $this->dir.'/'.$this->file_name);
                unlink($this->fileAttribute->tempName);
                return $copy;
            }

            return $this->fileAttribute->saveAs($this->dir.'/'.$this->file_name);
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model_id', 'model_name'], 'required'],
            [['file_name'], 'safe'],
            [['file_name'], 'default', 'value'=>'',],
            //[['file_name'], 'required'],
            [['model_id'], 'integer'],
            [['title'], 'default', 'value'=>'',],
            [['title'], 'safe'],
            [['type'], 'default', 'value'=>0,],
            //[['type'], 'in', 'range'=>[self::TYPE_IMAGE,self::TYPE_DOC,self::TYPE_AUDIO, ]],
            [
                'fileAttribute', 'file',
                //'skipOnEmpty'=>false,
                'maxSize'=>1024*1024*50,//50 mb
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public $labels=[];
    public function setAttributeLabel($field, $value)
    {
        $this->labels[$field]=$value;
    }
    public function attributeLabels()
    {
        $labels = [
            'fileAttribute'=>Yii::t('app', 'File'),
            'created_at'=>Yii::t('app', 'Created date'),
        ];
        return array_merge($labels, $this->labels);
    }


    /**
     * @return \yii\db\ActiveRecord
     */
    public function getModel()
    {
        if(class_exists($this->model_name))
            return $this->hasOne($this->model_name, ['id' => 'model_id']);
    }
    public function getShortModelName()
    {
        return (new \ReflectionClass($this->model_name))->getShortName();
    }

    public $fileAttribute;
    public $baseUrl;
    public $path;
    public $path_tmp;

    //это не вызывается
    public function getDir()
    {
        return "$this->path/".strtolower($this->shortModelName)."/{$this->model->id}";
    }

    public function getFileUrl()
    {
        return $this->baseUrl."/".$this->uploadFolder."/".strtolower($this->shortModelName)."/".$this->model->id.'/'.$this->file_name;
    }

    public function deleteFile()
    {
        if(is_file($this->dir.'/'.$this->file_name))
            unlink($this->dir.'/'.$this->file_name);
    }

    public function fields()
    {
        return [
            'id',
            'title',
            'created_at',
            'url'=>function(){
                    return $this->fileUrl;
                },
        ];
    }
}
