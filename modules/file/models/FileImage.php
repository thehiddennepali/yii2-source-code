<?php
/**
 * Created by PhpStorm.
 * User: Nurbek
 * Date: 5/12/16
 * Time: 3:32 PM
 */

namespace file\models;


use Yii;
use yii\helpers\Html;

use yii\imagine\Image;
use Imagine\Image\ImageInterface;
use Imagine\Image\Box;
use Imagine\Image\Point;



/**
 * FileImage model
 *
 * @property string $img
 * @property string $thumbUrl
 * @property string $imageUrl
*/
class FileImage extends File
{
    /**
     * @inheritdoc
     * @return \file\models\query\FileImageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new query\FileImageQuery(get_called_class());
    }
    const TYPE_SINGLE_IMAGE = 10;

    const TYPE_IMAGE_MAIN = 11;
    const TYPE_IMAGE = 12;

    public $typeValues = [
        self::TYPE_SINGLE_IMAGE=>'Profile image file',
        self::TYPE_IMAGE_MAIN=>'Main image file',
        self::TYPE_IMAGE=>'Simple image file',
    ];



    public function getImg($options=[])
    {
        return Html::img($this->thumbUrl, $options);
    }

    public function getImageUrl()
    {
        return parent::getFileUrl();
    }
    public function getThumbUrl($type=null)
    {
        if(!$type){
            if(Yii::$app->id=='app-backend')
                $type = "xs";
            if(Yii::$app->id=='app-frontend')
                $type = "sm";
        }
        return $this->baseUrl."/$this->uploadFolder/".strtolower($this->shortModelName)."/".$this->model->id.'/thumb/'.$type."-".$this->file_name;
    }
    public $thumbXs = true;
    public $thumbSm = true;
    public $thumbMd = true;
    public $thumbXsWidth=50;
    public $thumbXsHeight=50;
    public $thumbSmWidth=120;
    public $thumbSmHeight=120;
    public $thumbMdWidth=400;
    public $thumbMdHeight=400;

    public $imageWidth=1000;
    public $imageHeight=800;
    public $padding=true;

    public function saveFile()
    {
        if($this->fileAttribute)
        {
            parent::saveFile();

            $image = Image::getImagine();

            $image = $image->open($this->dir.'/'.$this->file_name);
            //растягивает по высоте несмотря ни на что
            //$image->resize($size->heighten(1000))->save("assets/resized.png", ['quality' => 80] );
            //растягивает по ширине несмотря ни на что
            //$image->resize($size->widen(100))->save("assets/resized.png", ['quality' => 80] );
            //$image->crop(new Point(0, 0),new Box(100, 100))->save("assets/cropped.png", ['quality' => 80] );
            //Устанавливает масимумы пределы сохраняя пропорции, если предел не првышается все остается так как и было
            //$image->thumbnail(new Box(1500, 1500))->save("assets/thumbnail1.png", ['quality' => 80] );

            //big image
            if($this->padding){
                $image->thumbnail(new Box($this->imageWidth, $this->imageHeight), ImageInterface::THUMBNAIL_INSET)->save($this->dir.'/'.$this->file_name, ['quality' => 80] );
                \extended\imagine\Imagine::pad($this->dir.'/'.$this->file_name, new Box($this->imageWidth, $this->imageHeight));
            }else
                $image->thumbnail(new Box($this->imageWidth, $this->imageHeight), ImageInterface::THUMBNAIL_OUTBOUND)->save($this->dir.'/'.$this->file_name, ['quality' => 80] );



            //thumbnails
            if($this->thumbXs || $this->thumbSm || $this->thumbMd){
                if(!is_dir($this->dir.'/thumb'))
                    mkdir($this->dir.'/thumb');
            }
            if($this->thumbXs){
                $size = new Box($this->thumbXsWidth, $this->thumbXsHeight);
                $fileName = $this->dir.'/thumb/xs-'.$this->file_name;
                if($this->padding){
                    $image->thumbnail($size, ImageInterface::THUMBNAIL_INSET)->save($fileName, ['quality' => 80] );
                    \extended\imagine\Imagine::pad($fileName, $size);
                }else
                    $image->thumbnail($size, ImageInterface::THUMBNAIL_OUTBOUND)->save($fileName, ['quality' => 80] );
            }
            if($this->thumbSm){
                $size = new Box($this->thumbSmWidth, $this->thumbSmHeight);
                $fileName = $this->dir.'/thumb/sm-'.$this->file_name;
                if($this->padding){
                    $image->thumbnail($size, ImageInterface::THUMBNAIL_INSET)->save($fileName, ['quality' => 80] );
                    \extended\imagine\Imagine::pad($fileName, $size);
                }else
                    $image->thumbnail($size, ImageInterface::THUMBNAIL_OUTBOUND)->save($fileName, ['quality' => 80] );
            }
            if($this->thumbMd){
                $size = new Box($this->thumbMdWidth, $this->thumbMdHeight);
                $fileName = $this->dir.'/thumb/md-'.$this->file_name;
                if($this->padding){
                    $image->thumbnail($size, ImageInterface::THUMBNAIL_INSET)->save($fileName, ['quality' => 80] );
                    \extended\imagine\Imagine::pad($fileName, $size);
                }else
                    $image->thumbnail($size, ImageInterface::THUMBNAIL_OUTBOUND)->save($fileName, ['quality' => 80] );
            }

        }
    }

    public function deleteFile()
    {
        if(is_file($this->dir.'/'.$this->file_name))
            unlink($this->dir.'/'.$this->file_name);
        foreach (['xs', 'sm', 'md'] as $size) {
            if(is_file($this->dir.'/thumb/'.$size.'-'.$this->file_name))
                unlink($this->dir.'/thumb/'.$size.'-'.$this->file_name);
        }
    }
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['fileAttribute'] = Yii::t('app', 'Image file');
        return array_merge($labels, $this->labels);
    }
    public function rules()
    {
        return array_merge(parent::rules() , [
            [
                'fileAttribute', 'file',
                'extensions' => 'gif, jpg, jpeg, png',
                'mimeTypes' => 'image/jpeg, image/png, image/gif',
            ],
            /*[
                'fileAttribute',  'image',
                'minWidth' => 338,
                'minHeight' => 212,
                'maxFiles'=>10,
            ],*/
        ]);
    }
} 