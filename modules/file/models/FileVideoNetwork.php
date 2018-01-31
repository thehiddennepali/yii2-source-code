<?php
/**
 * Created by PhpStorm.
 * User: nurbek
 * Date: 11/2/16
 * Time: 8:42 PM
 */

namespace file\models;


use yii\base\Event;
use yii\base\Exception;
use yii\base\Model;
use Yii;
use yii\behaviors\AttributeBehavior;
use yii\helpers\Html;

class FileVideoNetwork extends File
{
    public static function find()
    {
        return new query\FileVideoNetworkQuery(get_called_class());
    }


    public function behaviors()
    {
        $behaviours = parent::behaviors();
        return array_merge($behaviours, [
            [
                'class' => AttributeBehavior::className(),
                'attributes'=>[
                    self::EVENT_BEFORE_INSERT => 'file_name',
                    self::EVENT_BEFORE_VALIDATE => 'file_name',
                ],
                'value' => function (Event $event) {
                    /* @var $model self */
                    $model = $event->sender;
                    $model->initVideo();
                    return $model->file_name;
                },
            ],
        ]);
    }
    public function rules()
    {
        $rules = parent::rules();
        return array_merge($rules, [
            ['link', 'required', 'on'=>'image',],
            ['link', 'validateVideo'],
        ]);
    }

    public $link;

    const TYPE_VIDEO_YOUTUBE=50;
    const TYPE_VIDEO_VK=51;

    public $typeValues = [
        self::TYPE_VIDEO_YOUTUBE=>'Youtube',
        self::TYPE_VIDEO_VK=>'vk.com',
    ];

    public function getImg($options=[])
    {
        return Html::tag("div", Html::img($this->imageUrl, $options), ['class'=>'video-image', 'data'=>['id'=>$this->id, 'file_name'=>$this->file_name]]);
    }
    public function getVideo($options=['width'=>560, 'height'=>315])
    {
        return "<iframe src='//www.youtube.com/embed/".$this->file_name."'
                        width='".$options['width']."'
                        height='".$options['height']."'
                        frameborder='0'></iframe>
                ";
    }
    public function getImageUrl()
    {
        if($this->type==self::TYPE_VIDEO_YOUTUBE)
            return "http://img.youtube.com/vi/{$this->file_name}/0.jpg";
    }
    public function initVideo()
    {
        if(preg_match('/youtube.com\/watch\?v=/', $this->link)){
            $this->file_name=substr($this->link, strpos($this->link, "v=")+2);
            $this->type=self::TYPE_VIDEO_YOUTUBE;
        }
        if(preg_match('/youtu.be\//', $this->link)){
            $this->link=substr($this->link, strpos($this->link, ".be/")+4);
            $this->type=self::TYPE_VIDEO_YOUTUBE;
        }

        if(preg_match('/vk.com/', $this->link)){
            $this->link=urldecode($this->link);
            if(preg_match('/z=video/', $this->link)){
                $str=substr($this->link, strpos($this->link, "z=video")+7);
                $this->file_name=substr($str,0, strpos($str, "/"));
            }
            if(strpos($this->link, 'vk.com/video')!==false && strpos($this->link, 'vk.com/video?')===false)
                $this->file_name=substr($this->link, strpos($this->link, "video")+5);
            $this->type=self::TYPE_VIDEO_VK;
        }
    }

    public function validateVideo()
    {
        $this->initVideo();
        if($this->link && !$this->file_name)
            $this->addError('link', Yii::t('app', 'Неправильная ссылка видеосервиса.'));
    }

    public static function createVideoNetwork($parentModel, $value, $options=[])
    {
        /* @var $model File */
        $model = new static();
        $model->model_name=get_class($parentModel);
        $model->model_id=$parentModel->id;
        $model->link=$value;
        Yii::configure($model, $options);

        if($model->validate()){
            return $model->save();
        }
        else
            throw new Exception(Html::errorSummary($model, ['header'=>false]));
    }
}