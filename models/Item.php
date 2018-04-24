<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "item".
 *
 * @property integer $id_item
 * @property integer $id_user
 * @property string $item_name
 * @property integer $item_price
 * @property integer $stock
 * @property string $satuan
 * @property string $packaging_name
 *
 * @property Users $idUser
 */
class Item extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'item_name', 'item_price', 'stock'], 'required'],
            [['id_user', 'item_price', 'stock'], 'integer'],
            [['info'], 'string'],
            [['item_name', 'satuan', 'packaging_name'], 'string', 'max' => 225],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['id_user' => 'id_user']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_item' => 'Id Item',
            'id_user' => 'Id User',
            'item_name' => 'Item Name',
            'item_price' => 'Item Price',
            'stock' => 'Stock',
            'satuan' => 'Satuan',
            'packaging_name' => 'Packaging Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUser()
    {
        return $this->hasOne(Users::className(), ['id_user' => 'id_user']);
    }
}
