<?php

namespace app\controllers;

use Yii;
use app\models\Item;
use app\models\ItemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ItemController implements the CRUD actions for Item model.
 */
class AngularController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Item models.
     * @return mixed
     */
    public function actionIndex()
    {
        
        return $this->render('index');
    }

    public function actionDialogOne()
    {
        return $this->render('dialog_one');
    }

    public function actionDialogTwo($id)
    {
        // echo $id;exit;
        $getdata = Item::find()->where(['id_item' => $id])->one();
        $data = [
            'title' => $getdata->item_name,
            'info' => $getdata->info
        ];
        $encod = json_encode($data,true);
        $domain = (isset($_SERVER['HTTPS']) ? "https" : "http")."://".$_SERVER['HTTP_HOST'];
         return $this->redirect($domain.'/web/store/web/dialog/dialog_two.php?id='.$encod);
        // $_POST['a'] = "HALAOOO";
        // return $this->redirect($domain.'/web/store/web/dialog/tes.php');
    }

    
}
