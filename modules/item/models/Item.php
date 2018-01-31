<?php

namespace item\models;

use inventory\models\ItemLocation;
use measurement\models\Measurement;
use measurement\models\MeasurementItem;
use Yii;
use yii\base\Exception;
use yii\behaviors\AttributeBehavior;
use yii\helpers\ArrayHelper;
use recipe\models\Recipe;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "{{%item}}".
 *
 * @property integer $id
 * @property string $item_name
 * @property string $create_time
 * @property string $update_time
 * @property string $gtin
 * @property integer $published
 * @property string $unit_measure
 * @property integer $purchasable
 * @property string $item_description
 * @property string $categories_json
 * @property string $ingredients_json
 * @property string $diet_labels
 * @property string $alergens
 * @property string $short_name
 * @property string $image_url
 * @property string $sku
 * @property integer $has_ingredients
 * @property string $inner_pack
 * @property string $outer_pack
 * @property string $height
 * @property string $width
 * @property string $depth
 * @property integer $cube_unit
 * @property string $orig_id
 * @property string $weight
 * @property string $weight_interval
 * @property string $prep
 * @property string $bricks
 * @property integer $yield
 * @property string $unit_weight
 * @property string $item_type
 * @property string $itemTypeText
 * @property array $typeValues
 * @property double $prod_pounds_per_man_hour
 * @property integer $assembly_people_count
 * @property string $assembly_units_hour
 * @property string $labor_process
 * @property integer $container_type_id
 *
 * @property ItemAttribute[] $itemAttributes
 * @property ItemCategory[] $itemCategories
 * @property Category[] $categories
 * @property ItemVariant[] $itemVariants
 * @property array $unitValues
 * @property float $selling_price
 * @property float $cost_percent
 * @property float $total_recipe_cost
 * @property float $profit
 * @property float $price
 * @property float $eachPrice
 * @property float $casePrice
 * @property float $poundPrice
 * @property float $size
 * @property integer $case
 * @property integer $size_unit
 * @property string $size_unitText
 * @property ItemLocation $itemLocation
 * @property PurchaseOrderItem[] $purchaseOrderItems
 * @property string $unitType
 */
class Item extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%item}}';
    }


   public function behaviors()
   {
       return [
           [
               'class' => AttributeBehavior::className(),
               'attributes' => [
                   self::EVENT_BEFORE_UPDATE => 'update_time',
               ],
               'value' => function ($event) {
                   return date('Y-m-d H:i:s');
               },
           ]
       ];
   }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_name', 'outer_pack','size', 'size_unit'], 'required'],
            //[[ 'sku', 'inner_pack', 'height', 'width', 'depth', 'cube_unit', 'orig_id'], 'required'],
            [[ 'inner_pack', 'outer_pack', 'height', 'width', 'depth', 'cube_unit'], 'default', 'value'=>0,],
            [[ 'sku', 'orig_id'], 'default', 'value'=>'0',],
            [['create_time', 'update_time'], 'safe'],
            [['published', 'purchasable', 'has_ingredients', 'cube_unit', 'yield', 'assembly_people_count', 'container_type_id'], 'integer'],
            [['unit_measure', 'categories_json', 'ingredients_json', 'diet_labels', 'alergens', 'item_type'], 'string'],
            [['inner_pack', 'outer_pack', 'height', 'width', 'depth', 'weight', 'weight_interval', 'prod_pounds_per_man_hour', 'assembly_units_hour'], 'number'],
            [['item_name'], 'string', 'max' => 125],
            [['item_description', 'short_name', 'image_url', 'prep', 'labor_process'], 'string', 'max' => 255],
            [['gtin'], 'string', 'max' => 20],
            [['sku'], 'string', 'max' => 50],
            [['orig_id', 'unit_weight'], 'string', 'max' => 10],
            [['bricks'], 'string', 'max' => 155],
            [['selling_price', 'cost_percent', 'total_recipe_cost', 'profit'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'item_name' => Yii::t('app', 'Item Name'),
            'create_time' => Yii::t('app', 'Create Time'),
            'update_time' => Yii::t('app', 'Update Time'),
            'gtin' => Yii::t('app', 'Gtin'),
            'published' => Yii::t('app', 'Published'),
            'unit_measure' => Yii::t('app', 'Unit Measure'),
            'purchasable' => Yii::t('app', 'Purchasable'),
            'item_description' => Yii::t('app', 'Item Description'),
            'categories_json' => Yii::t('app', 'Categories Json'),
            'ingredients_json' => Yii::t('app', 'Ingredients Json'),
            'diet_labels' => Yii::t('app', 'Diet Labels'),
            'alergens' => Yii::t('app', 'Alergens'),
            'short_name' => Yii::t('app', 'Short Name'),
            'image_url' => Yii::t('app', 'Image Url'),
            'sku' => Yii::t('app', 'Sku'),
            'has_ingredients' => Yii::t('app', 'Has Ingredients'),
            'inner_pack' => Yii::t('app', 'Inner Pack'),
            'outer_pack' => Yii::t('app', 'Outer Pack'),
            'height' => Yii::t('app', 'Height'),
            'width' => Yii::t('app', 'Width'),
            'depth' => Yii::t('app', 'Depth'),
            'cube_unit' => Yii::t('app', 'Cube Unit'),
            'orig_id' => Yii::t('app', 'Orig ID'),
            'weight' => Yii::t('app', 'Weight'),
            'weight_interval' => Yii::t('app', 'Weight Interval'),
            'prep' => Yii::t('app', 'Prep'),
            'bricks' => Yii::t('app', 'Bricks'),
            'yield' => Yii::t('app', 'Yield'),
            'unit_weight' => Yii::t('app', 'Unit Weight'),
            'item_type' => Yii::t('app', 'Item Type'),
            'prod_pounds_per_man_hour' => Yii::t('app', 'Prod Pounds Per Man Hour'),
            'assembly_people_count' => Yii::t('app', 'Assembly People Count'),
            'assembly_units_hour' => Yii::t('app', 'Assembly Units Hour'),
            'labor_process' => Yii::t('app', 'Labor Process'),
            'container_type_id' => Yii::t('app', 'Container Type ID'),
            'cost_percent' => Yii::t('app', 'Cost %'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemAttributes()
    {
        return $this->hasMany(ItemAttribute::className(), ['item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemCategories()
    {
        return $this->hasMany(ItemCategory::className(), ['item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['id' => 'category_id'])->viaTable('{{%item_category}}', ['item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemVariants()
    {
        return $this->hasMany(ItemVariant::className(), ['item_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \item\models\query\ItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \item\models\query\ItemQuery(get_called_class());
    }

    const TYPE_PRODUCT = 'product';
    const TYPE_PACKING = 'packing_material';
    const TYPE_PROCESSED = 'processed_material';
    const TYPE_RAW = 'raw_material';
    const TYPE_SPEC = 'spec';
    /**
     * @return string
     */
    public function getTypeValues()
    {
        return [
            self::TYPE_PRODUCT=>'Product',
            self::TYPE_PACKING=>'Packing material',
            self::TYPE_PROCESSED=>'Processed material',
            self::TYPE_RAW=>'Raw material',
            self::TYPE_SPEC=>'Special material',
        ];
    }


    /**
     * @return string
     */
    public function getItemTypeText()
    {
        if(isset($this->typeValues[$this->item_type]))
            return $this->typeValues[$this->item_type];
        return $this->item_type;
    }

    //get all units from measurement table
    public function getUnitValues()
    {
        /*$measures = ArrayHelper::map(Measurement::find()->all(), 'short_name',
                    function(Measurement $data) use (&$results){
                        $results[$data->type][$data->short_name] = $data->name;
                        return $data->name;
                    });*/
        $results = [
           'Pack'=>[
               'CS'=>'Case',
               'EA'=>'Each',
           ],
        ];

        $this->getMeasurementItems()->indexBy(function(MeasurementItem $data) use (&$results){
            $results['Alternative']['alt:'.$data->id] = $data->name;
        })->all();

        Measurement::find()->indexBy(function(Measurement $data) use (&$results){
            $results[$data->type][$data->id] = $data->name;
        })->all();

        return $results;
    }


    public function getUnitType()
    {
        if(isset($this->unitValues['Volume'][$this->size_unit]))
            return 'Volume';
        if(isset($this->unitValues['Weight'][$this->size_unit]))
            return 'Weight';
        if(isset($this->unitValues['Other'][$this->size_unit]))
            return 'Other';
    }


    /**
     * @return \item\models\query\PurchaseOrderItemQuery;
     */
    public function getPurchaseOrderItems()
    {
        return $this->hasMany(PurchaseOrderItem::className(), ['item_id' => 'id']);
    }

    public function getItemLocation()
    {
        return $this->hasOne(ItemLocation::className(), ['item_id'=>'id']);
    }

    public function getMeasurementItems()
    {
        return $this->hasOne(MeasurementItem::className(), ['item_id'=>'id']);
    }



    /**
     * @return string
     */
    public function getSize_unitText()
    {
        $measures = Measurement::getMeasurements();
        if(isset($measures[$this->size_unit]))
            return $measures[$this->size_unit]->short_name;
        return $this->unit;
    }
    public function getSizeText()
    {
        return $this->size.' '.$this->size_unitText;
    }

    public function getCase()
    {
        if($this->inner_pack)
            return $this->inner_pack * $this->outer_pack;
        return $this->outer_pack;
    }


    //this is the cost of one case, because in purchase dear Ian buy via cases.
    public function getCasePrice()
    {
        if($location = $this->itemLocation){
            $po_items = $this->getPurchaseOrderItems()->lastActual($location->on_hand)->all();
            $quantity=0;
            $prices=0;
            foreach ($po_items as $po_item) {
                if($location->on_hand > $quantity+$po_item->quantity){
                    $quantity+=$po_item->quantity;
                    $prices+=$po_item->quantity*$po_item->act_cost;
                }else{
                    $remain = $location->on_hand - $quantity;
                    $quantity+=$remain;
                    $prices+=$remain*$po_item->act_cost;
                }
            }
            if($quantity!=0)
                return $prices/$quantity;
        }
    }
    //the cost of one each
    public function getEachPrice()
    {
        if($this->case)
            return $this->casePrice/$this->case;
    }
    public function getPrice()
    {
        return $this->eachPrice;
    }

    // this is a raw price
    public function getRawPrice($price)
    {
        if($this->yield)
            return $price/100 * $this->yield;
    }

    // the single density for all items, in the future we can set it individual for every item
    public $density=4.55;// KG/GAL

    //the price of item for one pound
    public function getPoundPrice()
    {
        if($this->size)
            return $this->price/$this->size;
    }

    public function getConvertedPoundPrice($unit)
    {
        if($unit=='CS')
            return $this->casePrice;
        if($unit=='EA')
            return $this->eachPrice;

        if(strpos($unit, 'alt:')!==false){
            $unit = str_replace('alt:', '', $unit);
            $alt_unit = MeasurementItem::findOne($unit);
            return $this->getConvertedPoundPrice($alt_unit->master_unit)/$alt_unit->factor;
        }

        $price = $this->poundPrice;
        if(!$unit || $unit==$this->size_unit)
            return $price;

        if(isset($this->unitValues['Volume'][$unit]))
            $unitType =  'Volume';
        if(isset($this->unitValues['Weight'][$unit]))
            $unitType =  'Weight';
        if(isset($this->unitValues['Other'][$unit]))
            $unitType =  'Other';

        if(!isset($unitType))
            throw new Exception("Unit is not defined");


        $measures = Measurement::getMeasurements();

        $coef=$measures[$this->size_unit]->coefficient/$measures[$unit]->coefficient;
        if($this->unitType==$unitType)
            return $coef * $price;
        if($this->unitType=='Weight' && $unitType=='Volume')
            $coef*=$this->density;
        if($this->unitType=='Volume' && $unitType=='Weight')
            $coef/=$this->density;
        return $coef * $price;
    }





}
