<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "store".
 *
 * @property integer $id_store
 * @property string $name_store
 * @property string $address
 * @property integer $id_user
 *
 * @property Users $idUser
 */
class Store extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'store';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_store', 'address', 'id_user'], 'required'],
            [['address'], 'string'],
            [['id_user'], 'integer'],
            [['name_store'], 'string', 'max' => 225],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['id_user' => 'id_user']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_store' => 'Id Store',
            'name_store' => 'Name Store',
            'address' => 'Address',
            'id_user' => 'Id User',
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
