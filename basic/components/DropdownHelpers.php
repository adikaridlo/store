<?php
namespace app\components;

use Yii;
use app\models\City;
use app\models\Merchant;
use yii\base\Component;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
/**
* 
*/
class DropdownHelpers
{
	
	public static function getCityLists($param)
	{

		$regex = '/^([0-9]){1,3}$/i';
		// $param = Yii::$app->request->queryParams;
		$id = isset($param['id']) ? $param['id'] : false;


        if(!preg_match($regex,$id)){
            // throw new \yii\web\BadRequestHttpException("Invalid Params !");
            return false;
        }

        // $cities = City::find()->select(['city_id', 'type', 'city_name'])->where(['province_id' => $id])->orderBy('province_id DESC')->all(); 
        $cities = City::getDb()->cache(function ($db) use($id) {

            return City::find()->select(['city_id', 'type', 'city_name'])->where(['province_id' => $id])->orderBy('province_id DESC')->all(); 
        });
        if (count($cities)>0) { 

            echo "<option value=''>Pilih Kota/Kabupaten</option>";

            foreach($cities as $city){ 
                echo "<option value='".$city->city_id."'>".$city->type." ".$city->city_name."</option>"; 
            } 

        } else { 
            echo "<option value=''>Pilih Kota/Kabupaten</option>";
        } 
	}

    public static function getMid($param)
    {

        $regex = '/^([0-9]){1,11}$/i';
        // $param = Yii::$app->request->queryParams;
        $id = isset($param['id']) ? $param['id'] : false;

        if(!preg_match($regex,$id)){
            // throw new \yii\web\BadRequestHttpException("Invalid Params !");
            return false;
        }

        $merchant = Merchant::getDb()->cache(function ($db) use($id) {
            return Merchant::findDataMid($id);
        });

        return empty($merchant) ? '-' : $merchant->mid;
    }

    public static function getOpg($param)
    {

        $regex = '/^([0-9]){1,11}$/i';
        // $param = Yii::$app->request->queryParams;
        $id = isset($param['id']) ? $param['id'] : false;

        if(!preg_match($regex,$id)){
            // throw new \yii\web\BadRequestHttpException("Invalid Params !");
            return false;
        }

        $opg = Merchant::findDataOpg($id);


        return empty($opg) ? '-' : $opg[0]['opg'];
    }

    public static function getMdr($param)
    {

        $regex = '/^([0-9]){1,11}$/i';
        // $param = Yii::$app->request->queryParams;
        $id = isset($param['id']) ? $param['id'] : false;

        if(!preg_match($regex,$id)){
            // throw new \yii\web\BadRequestHttpException("Invalid Params !");
            return false;
        }

        $mdr = Merchant::findMdrAggregator($id);
        if(empty($mdr[0]['emoney_aggregator']) && empty($mdr[0]['cc_aggregator']) && empty($mdr[0]['dc_aggregator'])){
            $emoney_aggregator  = 0;
            $cc_aggregator      = 0;
            $dc_aggregator      = 0;
        }else{
            $emoney_aggregator  = $mdr[0]['emoney_aggregator'];
            $cc_aggregator      = $mdr[0]['cc_aggregator'];
            $dc_aggregator      = $mdr[0]['dc_aggregator'];
        }
        $result = array($emoney_aggregator,$cc_aggregator,$dc_aggregator);
        return empty($mdr) ? '-' : Json::encode(["emoney_aggregator"=>$result[0],"cc_aggregator"=>$result[1],"dc_aggregator"=>$result[2]]);
    }
}
  