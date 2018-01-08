<?php
namespace merchant\controllers;
use common\models\GalleryPhoto;
use yii\web\Controller;
use Yii;
/**
 * Backend controller for GalleryManager widget.
 * Provides following features:
 *  - Image removal
 *  - Image upload/Multiple upload
 *  - Arrange images in gallery
 *  - Changing name/description associated with image
 *
 * @author Bogdan Savluk <savluk.bogdan@gmail.com>
 */

class GalleryController extends Controller
{
    public function filters()
    {
        return array(
            'postOnly + delete, ajaxUpload, order, changeData',
        );
    }

    /**
     * Removes image with ids specified in post request.
     * On success returns 'OK'
     */
    public function actionDelete()
    {
        $id = $_POST['id'];
        /** @var $photos GalleryPhoto[] */
        $photos = \common\extensions\gallerymanager\models\GalleryPhoto::find()->where(['id' => $id])->all();
        foreach ($photos as $photo) {
            if ($photo !== null) $photo->delete();
            else throw new CHttpException(400, 'Photo, not found');
        }
        echo 'OK';
    }

    /**
     * Method to handle file upload thought XHR2
     * On success returns JSON object with image info.
     * @param $gallery_id string Gallery Id to upload images
     * @throws CHttpException
     */
    public function actionAjaxUpload($gallery_id = null)
    {
	    
	if(empty($gallery_id)){
		$merchant = Yii::$app->user->identity;
		
		if(empty($merchant->gallery_id)){
			$gallery = new \common\extensions\gallerymanager\models\Gallery;
			$gallery->save();
			$merchant->gallery_id = $gallery->id;
			$merchant->save(false);
			$gallery_id = $gallery->id;
		}
		
	}
        $model = new \common\extensions\gallerymanager\models\GalleryPhoto();
        $model->gallery_id = $gallery_id;
        $imageFile = \yii\web\UploadedFile::getInstanceByName('image');
        
        
        $model->file_name = $imageFile->name;
	
	
        
        $model->save(false);
        

        $model->setImage($imageFile->tempName);
	
        //header("Content-Type: application/json");
        echo json_encode(
            array(
                'id' => $model->id,
                'rank' => $model->rank,
                'name' => (string)$model->name,
                'description' => (string)$model->description,
                'preview' => $model->getPreview(),
            ));
    }

    /**
     * Saves images order according to request.
     * Variable $_POST['order'] - new arrange of image ids, to be saved
     * @throws CHttpException
     */
    public function actionOrder()
    {
        if (!isset($_POST['order'])) throw new CHttpException(400, 'No data, to save');
        $gp = $_POST['order'];
        $orders = array();
        $i = 0;
        foreach ($gp as $k => $v) {
            if (!$v) $gp[$k] = $k;
            $orders[] = $gp[$k];
            $i++;
        }
        sort($orders);
        $i = 0;
        $res = array();
        foreach ($gp as $k => $v) {
            /** @var $p GalleryPhoto */
            $p = \common\extensions\gallerymanager\models\GalleryPhoto::findOne($k);
            $p->rank = $orders[$i];
            $res[$k]=$orders[$i];
            $p->save(false);
            $i++;
        }

        echo CJSON::encode($res);

    }

    /**
     * Method to update images name/description via AJAX.
     * On success returns JSON array od objects with new image info.
     * @throws CHttpException
     */
    public function actionChangeData()
    {
        if (!isset($_POST['photo'])) throw new CHttpException(400, 'Nothing, to save');
        $data = $_POST['photo'];
//        $criteria = new CDbCriteria();
//        $criteria->index = 'id';
//        $criteria->addInCondition('id', array_keys($data));
        /** @var $models GalleryPhoto[] */
        
        
        
        $models = \common\extensions\gallerymanager\models\GalleryPhoto::find()
                ->indexBy('id')
                ->where(['in','id', array_keys($data)])
                ->all();
        
        
        
        foreach ($data as $id => $attributes) {
            if (isset($attributes['name']))
                $models[$id]->name = $attributes['name'];
            if (isset($attributes['description']))
                $models[$id]->description = $attributes['description'];
            
            
            $models[$id]->save();
        }
        $resp = array();
        foreach ($models as $model) {
            $resp[] = array(
                'id' => $model->id,
                'rank' => $model->rank,
                'name' => (string)$model->name,
                'description' => (string)$model->description,
                'preview' => $model->getPreview(),
            );
        }
        echo json_encode($resp);
    }
}
