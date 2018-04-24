<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id_user
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property integer $province
 * @property integer $city
 * @property integer $districts
 * @property string $address
 *
 * @property Item[] $items
 * @property Store[] $stores
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'email', 'password', 'province', 'city', 'districts', 'address'], 'required'],
            [['province', 'city', 'districts'], 'integer'],
            [['address'], 'string'],
            [['first_name', 'last_name', 'email', 'password'], 'string', 'max' => 225],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_user' => 'Id User',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'password' => 'Password',
            'province' => 'Province',
            'city' => 'City',
            'districts' => 'Districts',
            'address' => 'Address',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Item::className(), ['id_user' => 'id_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStores()
    {
        return $this->hasMany(Store::className(), ['id_user' => 'id_user']);
    }
}
