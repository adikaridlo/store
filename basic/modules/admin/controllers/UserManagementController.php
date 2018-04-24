<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Users;
use app\models\UsersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\AuthAssignment;
use yii\web\Response;
use yii\widgets\ActiveForm;
use app\models\WebSession;



/**
 * UserManagementController implements the CRUD actions for Users model.
 */
class UserManagementController extends Controller
{
    const ROLE_ADMIN = 'admin';
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
     * Lists all Users models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['user_type' => 'admin']);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Users model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionActivate($id)
    {
        $model = $this->findModel($id);
        $isActive = ($model->is_active == 1) ? 0 : 1;
        $model->is_active = $isActive;

        if ($model->save()) {

            if ($isActive == 0) {
                // $user_session = WebSession::findOne(['user_id' => $model->user_id]);
                // $session = \Yii::$app->session;
                // $session->setId($user_session->id);
                // $session->destroy();

                WebSession::deleteAll(['user_id' => $model->user_id]);

            }
            return $this->redirect(['index']);
        }  else {
            // throw new NotFoundHttpException();
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Users();
        $model->scenario = 'create';
        $dataPost = Yii::$app->request->post();

        if (Yii::$app->request->isAjax && $model->load($dataPost)) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }


        if ($model->load($dataPost) && $model->validate()) {

            // to administrator

            $model->merchant_id = 0;
            $model->created_date = date('Y-m-d H:i:s');
            if (!isset($dataPost['is_active'])) {
                $model->is_active = 1;
            }

            $model->setPassword($model->password);
            $model->password_confirm = $model->password;

            if ($model->save()) {

                // set role

                $assign = new AuthAssignment();
                $assign->user_id = (string)$model->user_id;
                $assign->item_name = self::ROLE_ADMIN;
                $assign->created_at = date('U');

                if ($assign->save()) {
                    return $this->redirect(['index']);
                }
            }
        }


        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'create';

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->setPassword($model->password);
            $model->password_confirm = $model->password;
            
            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Users model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    // public function actionDelete($id)
    // {
    //     $this->findModel($id)->delete();

    //     return $this->redirect(['index']);
    // }

    /**
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
